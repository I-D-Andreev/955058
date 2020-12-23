@extends("layouts.app")

@push('imports')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>  
    <script src="{{ asset('js/ckeditor_trigger.js') }}"></script>  
@endpush

@section("content")
<div id="create" class="card-body">
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf
        <div class="form-group row m-0">
            <label for="title" class="col-md-12 col-form-label text-center">{{ __('Title') }}</label>
        </div>

        
        <div class="form-group row">
            <div class="col-md-4 offset-md-4">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row m-0">
            <label for="title" class="col-md-12 col-form-label text-center">{{ __('Tags') }}</label>
        </div>

        <div class="form-group row">
            <div class="col-md-4 offset-md-4">
                <input type="text" class="form-control" required>
            </div>

            <div class="ml-0 p-0 my-auto">
                <i class="fas fa-plus-circle fa-2x"></i>
            </div>

            <div class="ml-1 p-0 my-auto">
                <i class="fas fa-minus-circle fa-2x"></i>
            </div>
            
        </div>

        <div class="form-group row m-0">
            <label for="text" class="col-md-12 col-form-label text-center">{{ __('Text') }}</label>
        </div>

        <div class="form-group row h-50">
            <div id="ckedit_parent" class="col-md-6 offset-md-3">
                {{-- <textarea name="text" id="text" class="ckeditor"></textarea> --}}
                <textarea name="text" id="text" class="form-control w-100 h-100" style="resize:none" required autocomplete="post-text"></textarea>
            </div>
        </div>


        <div class="form-group row mb-0">
            <div class="col-md-8 offset-2 text-right">
                <button type="submit" class="btn btn-primary">
                    Create Post
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('code')
    <script>
        // var token = "<?php echo (Auth::user())->api_token; ?>";



        var init = new Vue({
            el: "#create",
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
            
            },
            mounted() {

            },
        });
    </script>
 @endsection

