@extends("layouts.app")

@push('imports')
<link href="{{ asset('css/colours.css') }}" rel="stylesheet">
@endpush

@section("content")
<div class="container h-100">
    <div class="row">
        <div class="w-100">
            <h1 class="ml-2">{{$post->title}}</h1>
        </div>
        <p class="h4 ml-2 w-100 text-secondary"> by {{$post->author->name}}</p>
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

    <div class="card p-1 mt-1">
        <h5 class="card-header">Leave a Comment:</h5>
        <div class="card-body">
          <form>
              <textarea class="form-control" rows="3" style="resize: none"></textarea>
              <button type="submit" class="btn btn-primary float-right mt-3">Submit</button>
          </form>
        </div>
    </div>
</div>
    {{-- <h1>{{$post->title}}</h1>   
    <p>Author: {{$post->author->name}}</p>
    <br>
    <div>{{$post->text}}</div> 
    <hr>
    <p>Comments:</p>

    <div id="comments_root">
        <div id="comments_root">
            <ul>
                <li v-for="comment in comments">@{{comment.text}} -- by -- @{{comment.author.name}}</li>
            </ul>
        </div>

        <div>
            <button type="button" class="btn btn-primary float-right mr-5" onclick="location.href='{{ route("posts.index")}}'">Back to Menu</button>
        </div>
        

        <div class="mt-5">
            <div>
                <label for="comment_text">Text:</label>
                <input type="text" id="comment_text" v-model="newComment">
                <button @click="createComment" >Comment</button>
            </div>
        </div>
        </div> --}}

 @endsection


 {{-- @section('code')
    <script>
        var token = "<?php echo (Auth::user())->api_token; ?>";
        
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
 --}}
