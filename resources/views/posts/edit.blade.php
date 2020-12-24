@extends("layouts.createEditPost")

@section("formAction")
    "{{ route('posts.update', ['id' => $post->id]) }}"
@endsection

@section("formMethod")
    @method("PUT")
@endsection

@section("title")
    "{{$post->title}}"
@endsection

{{-- No space in front of $post->text as it gets added to the original text --}}
@section("text")
{{$post->text}}
@endsection

@section("buttonName")
Edit Post
@endsection

@section("preCode")
    <script>
        var rowNames = (<?php echo $post->tags ?>).map(t=>t.name);
    </script>
@endsection
