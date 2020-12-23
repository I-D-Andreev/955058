@extends("layouts.app")

@push('imports')
    <link href="{{ asset('css/colours.css') }}" rel="stylesheet">
    <script src="https://momentjs.com/downloads/moment.js"></script>
@endpush

@section("content")
<div class="container h-100">
    <div class="row">
        <div class="w-100">
            <h1 class="ml-2">{{$post->title}}</h1>
        </div>
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
        {{$post->text}}
    </div>

    <div class="row">
        <hr class="w-100 mt-3 p-0 col-gray">
    </div>

    <div id="comments_root">
        <div class="card p-1 mt-1">
            <div class="card-header">
                <h5 class="h5 ml-2">Comments: <span class="badge badge-info float-right mr-2">@{{comments.length}}</span></h5>
            </div>
            <div class="card-body">
                <ul class="list-group borderless">
                    <div class="list-group-item border-0" v-for="comment in comments">
                        <div class="card">
                            <div class="card-header">@{{comment.author.name}} <span class="float-right">@{{comment.updated_at | formatDate}}</span></div>
                            <div class="card-body">@{{comment.text}}</div>
                        </div>
                    </div>
            </ul> 
            </div>
        </div>

    
        <div class="card p-1 mt-3">
            <h5 class="card-header">Leave a Comment:</h5>
            <div class="card-body">
                <textarea class="form-control" rows="3" style="resize: none" v-model="newComment"></textarea>
                <button @click="createComment" class="btn btn-primary float-right mt-3">Submit</button>
            </div>
        </div> 
    </div>
 @endsection


 @section('code')
    <script>
        var token = "<?php echo (Auth::user())->api_token; ?>";
        Vue.filter('formatDate', function(date){
            if(date){
                return moment(date).format('YYYY/MM/DD hh:mm:ss')
            }
        })

        var init = new Vue({
            el: "#comments_root",
            data: {
                config: {
                    headers: {
                        Authorization: 'Bearer ' + token,
                        Accept: 'application/json'
                    }
                },
                comments:[],
                newComment: ''
            },
            methods: {
                createComment: function(){
                    axios.post("{{ route('api.post.comments.create', ['id' => $post->id]) }}",
                        {
                            text: this.newComment
                        },
                        this.config
                    )
                    .then(response => {
                        this.comments.push(response.data);
                        this.newComment = '';
                    })
                    .catch(err => {
                        console.log(err);
                    })
                }
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

