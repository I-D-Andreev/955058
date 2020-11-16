@extends("layouts.base")

@section("title", "Preview Post")

@section("content")
    <h1>{{$post->title}}</h1>   
    <p>Author: {{$post->author->name}}</p>
    <br>
    <div>{{$post->text}}</div> 

 @endsection