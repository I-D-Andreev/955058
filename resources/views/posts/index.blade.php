@extends("layouts.app")

@section("content")
    <p>Posts:</p>
    <ul>
        @foreach($posts as $post)
            <li><a href="{{ route('posts.show', ['id' => $post->id])}}">{{$post->title}}</a></li>
        @endforeach
    </ul> 

    <div>
        {{ $posts->links() }}
    </div>
 @endsection