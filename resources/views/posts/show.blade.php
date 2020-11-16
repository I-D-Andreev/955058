@extends("layouts.base")

@section("title", "Preview Post")

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

 @endsection