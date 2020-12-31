@extends("layouts.app")

@push('imports')
    <link href="{{ asset('css/colours.css') }}" rel="stylesheet">
    <script src="https://momentjs.com/downloads/moment.js"></script>
@endpush

@section("content")
<div class="container h-100">
    <div class="row">
        <div class="w-50">
            <h1 class="ml-2">{{$post->title}}</h1>
        </div>
        
        @if (Auth::id() == $post->user_id)
            <div class="w-50 my-auto">
                <button class="btn btn-primary float-right mr-3" onclick="location.href='{{ route("posts.edit", ["id" => $post->id])}}'">Edit Post</button>
            </div>
        @endif

        <div class="w-100">
            <p class="h4 ml-2 w-100 text-secondary"> by {{$post->author->name}}</p>
        </div>
        <div class="w-100">
            <h5>
                @foreach ($post->tags as $tag)
                    <span class="badge badge-primary">{{$tag->name}}</span>
                @endforeach
            </h5>
        </div>
        <hr class="w-100 m-0 col-gray">
        <p class="h6 p-2 w-50 m-0"> {{__('Posted on:')}} {{$post->created_at}}</p>
        <p class="h6 p-2 w-50 m-0 text-right"> {{__('Last updated:')}} {{$post->updated_at}}</p>
        <hr class="w-100 m-0 p-0 col-gray">
    </div>
   
    <div class="mt-2">
        {!! $post->text !!}
    </div>
    
    <div class="row">
        <hr class="w-100 mt-3 p-0 col-gray">
    </div>

    <div id="commentsRoot">
        <div class="card p-1 mt-1">
            <div class="card-header">
                <h5 class="h5 ml-2">{{__('Comments:')}}<span class="badge badge-info float-right mr-2">@{{commentsCount}}</span></h5>
            </div>
            <div class="card-body">
                <ul class="list-group borderless" v-for="comment in comments" v-bind:key="comment.id">                  
                   
                    <div class="list-group-item border-0" >
                        <div class="card">
                            <div class="card-header">@{{comment.author.name}}
                                <i v-if="(comment.author.id=={{Auth::id()}} && comment.editable_by_user=='1') || '{{Auth::user()->type}}'=='admin'" class="far fa-edit ml-2" @click="commentEditArea(comment)" aria-title="Edit Comment"></i>
                                <i v-if="canReply" class="far fa-comment-dots ml-1" @click="commentReplyArea(comment)" aria-title="Reply to Comment"></i>
                                <span class="float-right">@{{comment.updated_at | formatDate}}</span>
                                <span v-if="comment.created_at != comment.updated_at" class="float-right mr-3">
                                    <i v-if="comment.editable_by_user==='1'">{{__('(Edited)')}}</i>
                                    <i v-else class="text-danger">{{__('(Moderated by Admin)')}}</i>
                                </span>
                            </div>
                            <div v-bind:id="'commentArea' + comment.id" :contenteditable="(commentToEdit === comment.id) ? true: false" class="card-body">@{{comment.text}}</div>
                        </div>
                        <div v-if="(commentToEdit === comment.id)" class="w-100">
                            <button class="btn btn-primary float-right mt-1" @click="editComment(comment)">{{__('Edit Comment')}}</button>
                        </div>
                        <div v-if="(commentToEdit === comment.id)" class="w-100">
                            <button class="btn btn-primary float-right mt-1 mr-2" @click="cancelEdit(comment)">{{__('Cancel')}}</button>
                        </div>
                    </div>


                 
                    <div class="list-group-item border-0" v-if="comment.comments && comment.comments.length" v-for="subcomment in comment.comments" v-bind:key="subcomment.id">
                        <div class="card float-right" style="width:90%">
                                <div class="card-header">@{{subcomment.author.name}} 
                                    <i v-if="(subcomment.author.id==={{Auth::id()}} && subcomment.editable_by_user==='1') || '{{Auth::user()->type}}'=='admin'" class="far fa-edit ml-2" @click="commentEditArea(subcomment)" aria-title="Edit Comment"></i>
                                    <span class="float-right">@{{subcomment.updated_at | formatDate}}</span>
                                    <span v-if="subcomment.created_at != subcomment.updated_at" class="float-right mr-3">
                                        <i v-if="subcomment.editable_by_user=='1'">{{__('(Edited)')}}</i>
                                        <i v-else class="text-danger">{{__('(Moderated by Admin)')}}</i>
                                    </span>
                                </div>
                                <div v-bind:id="'commentArea' + subcomment.id" :contenteditable="(commentToEdit === subcomment.id) ? true: false" class="card-body">@{{subcomment.text}}</div>
                            </div>
                            <div v-if="(commentToEdit === subcomment.id)" class="w-100">
                                <button class="btn btn-primary float-right mt-1" @click="editSubComment(comment,subcomment)">{{__('Edit Comment')}}</button>
                            </div>

                            <div v-if="(commentToEdit === subcomment.id)" class="w-100">
                                <button class="btn btn-primary float-right mt-1 mr-2" @click="cancelEdit(subcomment)">{{__('Cancel')}}</button>
                            </div>

                            <div v-if="(commentToReply === subcomment.id)" class="w-100">
                                <button class="btn btn-primary float-right mt-1" @click="createCommentToComment(comment,subcomment)">{{__('Submit Comment')}}</button>
                            </div>

                            <div v-if="(commentToReply === subcomment.id)" class="w-100">
                                <button class="btn btn-primary float-right mt-1 mr-2" @click="cancelCreateCommentToComment(comment)">{{__('Cancel')}}</button>
                            </div>
                        </div>
                </ul> 
            </div>
        </div>

    
        <div class="card p-1 mt-3">
            <h5 class="card-header">Leave a Comment:</h5>
            <div class="card-body">
                <textarea class="form-control" rows="3" style="resize: none" v-model="newComment"></textarea>
                <button @click="createCommentToPost" class="btn btn-primary float-right mt-3">{{__('Submit')}}</button>
            </div>
        </div> 
    </div>
</div>
 @endsection


 @section('code')
    <script>
        var token = "<?php echo (Auth::user())->api_token; ?>";

        Vue.filter('formatDate', function(date){
            if(date){
                return moment(date).format('YYYY/MM/DD HH:mm:ss')
            }
        })

        var init = new Vue({
            el: "#commentsRoot",
            data: {
                config: {
                    headers: {
                        Authorization: 'Bearer ' + token,
                        Accept: 'application/json'
                    }
                },
                comments:[],
                newComment: '',
                commentToEdit: null,
                canReply: true,
                commentToReply: null,
                commentsCount: 0,
            },
            methods: {
                createCommentToPost: function(){
                    axios.post("{{ route('api.post.comment.create', ['id' => $post->id]) }}",
                        {
                            text: this.newComment,
                            commentableId: "<?php echo $post->id; ?>",
                            commentableType: "post",
                        },
                        this.config
                    )
                    .then(response => {

                        this.comments.push(response.data);
                        this.newComment = '';
                        this.commentsCount++;
                        
                    })
                    .catch(err => {
                        console.log(err);
                    })
                }, 
                commentEditArea: function(comment){ 
                     
                    this.commentToEdit = comment.id;
                    let areaId = "commentArea" + comment.id;
                    let commentArea = document.getElementById(areaId)
                    init.focusArea(commentArea);

              
                },
                editComment: function(comment){
                    let areaId = "commentArea" + comment.id;
                    let commentArea = document.getElementById(areaId);
                    let url = "{{ route('api.post.comment.update', ['id' => ':id']) }}";
                    url = url.replace(':id', comment.id);
                   
                    axios.put(url,
                        {
                            text: commentArea.textContent
                        }, 
                        this.config
                    )
                    .then(response => {
                        let commentIndex = this.comments.findIndex(c => c.id == comment.id);
                        this.commentToEdit = null;

                        // Change modifiable properties one by one so that subcomments are not re-rendered
                        this.comments[commentIndex].text = response.data.text;
                        this.comments[commentIndex].created_at = response.data.created_at;
                        this.comments[commentIndex].updated_at = response.data.updated_at;
                        this.comments[commentIndex].editable_by_user = response.data.editable_by_user;
                    })
                    .catch(err => {
                        console.log(err);
                    })
                },
                cancelEdit: function(comment){
                    let areaId = "commentArea" + comment.id;
                    let commentArea = document.getElementById(areaId);
                    this.commentToEdit = '';
                    this.revertArea(commentArea, comment.text);

                },
                commentReplyArea: function (comment) {
                    // Add a comment, which will create a reply area for us
                    let ghostComment = {
                        'id': 'Spawned',
                        'name' : '',
                        'editable_by_user': '1',
                        'created_at' : '',
                        'updated_at' :'',
                        'author' : {
                            'id': "<?php echo Auth::user()->id; ?>",
                            'name': "<?php echo Auth::user()->name; ?>",
                        }
                    };

                    if(comment.comments){
                        comment.comments.push(ghostComment);
                    } else {
                        comment.comments = [ghostComment];
                    }
                    this.canReply = false;

                    Vue.nextTick().then(function(){
                        let commentArea = document.getElementById('commentAreaSpawned');
                        init.commentToReply = ghostComment.id;
                        init.focusArea(commentArea);
                    });     
                },
                createCommentToComment: function(parentComment, ghostComment){
                    this.canReply = true;

                    let commentArea = document.getElementById('commentAreaSpawned');
                    axios.post("{{ route('api.post.comment.create', ['id' => $post->id]) }}",
                        {
                            text: commentArea.textContent,
                            commentableId: parentComment.id,
                            commentableType: "comment",
                        },
                        this.config
                    )
                    .then(response => {
                        commentArea.contentEditable = false;

                        parentComment.comments.pop();                        
                        parentComment.comments.push(response.data);
                        this.commentToReply = null;
                        this.commentsCount++;
                    })
                    .catch(err => {
                        console.log(err);
                    })


                },
                cancelCreateCommentToComment: function(parentComment){
                    this.canReply = true;
                    this.commentToReply = false;
                    parentComment.comments.pop();
                },
                editSubComment: function(parentComment, comment){
                    let areaId = "commentArea" + comment.id;
                    let commentArea = document.getElementById(areaId)
                    let url = "{{ route('api.post.comment.update', ['id' => ':id']) }}";
                    url = url.replace(':id', comment.id);
                   
                    axios.put(url,
                        {
                            text: commentArea.textContent
                        }, 
                        this.config
                    )
                    .then(response => {
                        this.commentToEdit = null;
                        let commentIndex = parentComment.comments.findIndex(c => c.id == comment.id);

                        parentComment.comments[commentIndex] = response.data;
                    })
                    .catch(err => {
                        console.log(err);
                    })
                },
                focusArea: function(commentArea){
                    // Set editable explicitly so we don't have a race condition between vue and the focus line.
                    // commentToEdit is still needed to automatically get 
                    // the commentAreas back to non-editable once we stop editing.
                    commentArea.contentEditable = true;
                    commentArea.focus();

                    // move cursor to the end of the comment
                    document.execCommand("selectAll", false, null);
                    document.getSelection().collapseToEnd();

                },
                revertArea: function(commentArea, previousText){
                    commentArea.textContent = previousText;
                    commentArea.contentEditable = false;
                }

            },
            mounted() {
                axios.get("{{ route('api.post.comments', ['id' => $post->id])}}", this.config)
                .then(response => {
                    this.comments = response.data;

                    let count = this.comments.length;

                    this.comments.forEach((comment)=>{
                        count+= comment.comments.length;
                    });

                    this.commentsCount = count;
                })
                .catch(err => {
                    console.log(err);
                })
            },
        });
    </script>
 @endsection

