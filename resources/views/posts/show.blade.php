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
        <p class="h6 p-2 w-50 m-0"> Posted on: {{$post->created_at}}</p>
        <p class="h6 p-2 w-50 m-0 text-right"> Last updated: {{$post->updated_at}}</p>
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
                <h5 class="h5 ml-2">Comments:<span class="badge badge-info float-right mr-2">@{{comments.length}}</span></h5>
            </div>
            <div class="card-body">
                <ul class="list-group borderless">
                    <div class="list-group-item border-0" v-for="(comment, index) in comments">
                        
                        <div class="card">
                            <div class="card-header">@{{comment.author.name}} 
                                <i v-if="(comment.author.id==={{Auth::id()}} && comment.editable_by_user==='1') || '{{Auth::user()->type}}'=='admin'" class="far fa-edit ml-2" @click="commentEditArea(comment, index)"></i>
                                <span class="float-right">@{{comment.updated_at | formatDate}}</span>
                                <span v-if="comment.created_at != comment.updated_at" class="float-right mr-3">
                                    <i v-if="comment.editable_by_user==='1'">(Edited)</i>
                                    <i v-else class="text-danger">(Moderated by Admin)</i>
                                </span>
                            </div>
                            <div :contenteditable="(commentToEdit === comment.id) ? true: false" class="card-body" name="commentArea">@{{comment.text}}</div>
                        </div>
                        <div v-if="(commentToEdit === comment.id)" class="w-100">
                            <button class="btn btn-primary float-right mt-1" @click="editComment(comment, index)">Edit Comment</button>
                        </div>
                    </div>
            </ul> 
            </div>
        </div>

    
        <div class="card p-1 mt-3">
            <h5 class="card-header">Leave a Comment:</h5>
            <div class="card-body">
                <textarea class="form-control" rows="3" style="resize: none" v-model="newComment"></textarea>
                <button @click="createCommentToPost" class="btn btn-primary float-right mt-3">Submit</button>
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
            },
            methods: {
                createCommentToPost: function(){
                    axios.post("{{ route('api.post.comment.create', ['id' => $post->id]) }}",
                        {
                            text: this.newComment
                        },
                        this.config
                    )
                    .then(response => {
                        this.comments.push(response.data);
                        this.newComment = '';
                        
                        console.log(response.data);
                    })
                    .catch(err => {
                        console.log(err);
                    })
                }, 
                commentEditArea: function(comment, commentAreaIndex){  
                    this.commentToEdit = comment.id;
                    let commentArea = document.getElementsByName("commentArea")[commentAreaIndex]
                    
                    // Set editable explicitly so we don't have race condition between vue and the focus line.
                    // commentToEdit is still needed to automatically get 
                    // the commentAreas back to non-editable once we stop editing.

                    commentArea.contentEditable = true;
                    commentArea.focus();

                    // move cursor to the end of the comment
                    document.execCommand("selectAll", false, null);
                    document.getSelection().collapseToEnd();

                },
                editComment: function(comment, commentAreaIndex){
                    let commentArea = document.getElementsByName("commentArea")[commentAreaIndex]
                    let url = "{{ route('api.post.comment.update', ['id' => ':id']) }}";
                    url = url.replace(':id', comment.id);
                   
                    axios.put(url,
                        {
                            text: commentArea.textContent
                        }, 
                        this.config
                    )
                    .then(response => {
                        this.comments[commentAreaIndex] = response.data;
                        this.commentToEdit = '';
                    })
                    .catch(err => {
                        console.log(err);
                    })
                },

            },
            mounted() {
                axios.get("{{ route('api.post.comments', ['id' => $post->id])}}", this.config)
                .then(response => {
                    this.comments = response.data;
                })
                .catch(err => {
                    console.log(err);
                })
            },
        });
    </script>
 @endsection

