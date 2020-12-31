@extends("layouts.createEditPost")

@section("formAction")
    "{{ route('posts.store') }}"
@endsection

@section("title")
"{{ old('title') }}"
@endsection

{{-- No space in front of $post->text as it gets added to the original text --}}
@section("text")
{{ old('text') }}
@endsection

@section("buttonName")
{{__('Create Post')}}
@endsection

@section("preCode")
    <script>
        var rowNames = [];
    </script>
@endsection
