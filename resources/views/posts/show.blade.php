@extends("layouts.app")


@section("content")
    <h1>{{$post->title}}</h1>   
    <p>Author: {{$post->author->name}}</p>
    <br>
    <div>{{$post->text}}</div> 
    <hr>
    <p>Comments:</p>

    <div id="comments_root">
        <ul>
            <li v-for="comment in comments">@{{comment.text}} -- by -- @{{comment.author.name}}</li>
        </ul>
    </div>
    <div>
        <button type="button" class="btn btn-primary float-right mr-5" onclick="location.href='{{ route("posts.index")}}'">Back to Menu</button>
    </div>
    
 @endsection


 @section('code')
    <script>
        var init = new Vue({
            el: "#comments_root",
            data: {
                comments:["hello", "world"],
            },
            mounted() {
                axios.get("{{ route('api.post.comments', ['id' => $post->id])}}")
                .then(response => {
                    console.log("Success");
                    this.comments = response.data;
                })
                .catch(err => {
                    console.log("Error");
                    console.log(err);
                })
            },
        });
    </script>
 @endsection