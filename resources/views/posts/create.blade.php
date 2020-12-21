@extends("layouts.app")

@section("content")

<div class="card-body">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label offset-md-4 text-center">{{ __('Title') }}</label>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="text" class="col-md-4 col-form-label text-md-right">{{ __('Text') }}</label>

            <div class="col-md-6">
                <input id="text" type="text" class="form-control" name="text" required autocomplete="post-text">
            </div>
        </div>


        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Create Post
                </button>
            </div>
        </div>
    </form>
</div>
@endsection