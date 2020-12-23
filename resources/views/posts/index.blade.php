@extends("layouts.app")

@section("content")
<div class="container h-100">
    <div class="panel w-75 mx-auto py-5">
        <div class="panel-heading">
            <div class="h2 text-center">Posts</div>
        </div>
        <div class="panel-body">
            <ul class="list-group">
                @foreach($posts as $post)
                    <li class="list-group-item"><a href="{{ route('posts.show', ['id' => $post->id])}}">{{$post->title}}</a> by {{ $post->author->name}}  <span class="float-right">{{$post->created_at}} </span></li>
                @endforeach
            </ul> 
        </div>

        <div class="panel-footer mt-3">
            <div class="row">
                <div class="col-md-8">
                    {{ $posts->links() }}
                </div>

                <div class="col-md-4">
                    <button type="button" class="btn btn-primary float-right mr-5" onclick="location.href='{{ route("posts.create")}}'">Create Post</button>
                </div>
            </div>
        </div>
    </div>
    
</div> 
 @endsection