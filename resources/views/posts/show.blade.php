@extends("layouts.app")


@section("content")
    <h1>{{$post->title}}</h1>   
    <p>Author: {{$post->author->name}}</p>
    <br>
    <div>{{$post->text}}</div> 
    <p>Comments:</p>
    <ul>
        @foreach ($post->comments as $comment)
        <li>
                {{$comment->text}}
                {{$comment->author->name}}
        </li>
        @endforeach
    </ul>

    <div>
        <button type="button" class="btn btn-primary float-right mr-5" onclick="location.href='{{ route("posts.index")}}'">Back to Menu</button>
    </div>

 @endsection