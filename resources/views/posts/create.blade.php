@extends("layouts.app")

@push('imports')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>  
    <script src="{{ asset('js/ckeditor_trigger.js') }}" defer></script>  
@endpush

@section("content")
<div class="card-body">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group row mb-1">
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


        <div class="form-group row mb-1">
            <label for="text" class="col-md-12 col-form-label text-center">{{ __('Text') }}</label>
        </div>

        <div class="form-group row h-50">
            <div id="ckedit_parent" class="col-md-6 offset-md-3">
                {{-- <textarea name="text" id="text" class="ckeditor"></textarea> --}}
                <textarea name="text" id="text" class="form-control w-100 h-100" required autocomplete="post-text"></textarea>
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