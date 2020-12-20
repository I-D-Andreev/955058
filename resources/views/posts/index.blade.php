@extends("layouts.app")

@section("content")
    <p>Posts:</p>
    <ul>
        @foreach($posts as $post)
            <li><a href="{{ route('posts.show', ['id' => $post->id])}}">{{$post->title}}</a></li>
        @endforeach
    </ul> 

    <div>
        <button type="button" class="btn btn-primary float-right mr-5">Create Post</button>
    </div>
    <div>
        {{ $posts->links() }}
    </div>
 @endsection