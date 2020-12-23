@extends("layouts.app")


@section("content")
    
    <h1>{{$post->title}}</h1>   
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
        </div>

 @endsection


 @section('code')
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

