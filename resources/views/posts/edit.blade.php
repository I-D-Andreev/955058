@extends("layouts.app")

@push('imports')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>  
    <script src="{{ asset('js/ckeditor_trigger.js') }}"></script>  
@endpush

@section("content")
<div id="create" class="card-body">
    <form method="POST" action="{{ route('posts.update', ['id' => $post->id]) }}">
        @csrf
        @method('PUT')

        <div class="form-group row m-0">
            <label for="title" class="col-md-12 col-form-label text-center">{{ __('Title') }}</label>
        </div>

        <div class="form-group row">
            <div class="col-md-4 offset-md-4">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{$post->title}}" required autocomplete="on" autofocus>

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-2 offset-md-5 col-form-label text-center">{{ __('Tags') }}</label>
            <div class="col-md-1 my-auto">
                <i v-on:click="addRow" class="fas fa-plus-circle fa-2x"></i>
            </div>
        </div>
     

        <div class="form-group row" v-for="(row, index) in rows">
            <div class="col-md-4 offset-md-4">
                <input name="tags[]" type="text" class="form-control" required v-model="rows[index]">
            </div>

            <div class="ml-1 p-0 my-auto">
                <i v-on:click="removeRow(index)" class="fas fa-minus-circle fa-2x"></i>
            </div>
            
        </div>


        <div class="form-group row m-0">
            <label for="text" class="col-md-12 col-form-label text-center">{{ __('Text') }}</label>
        </div>

        <div class="form-group row h-50">
            <div id="ckedit_parent" class="col-md-6 offset-md-3">
                {{-- <textarea name="text" id="text" class="ckeditor"></textarea> --}}
                <textarea name="text" id="text" class="form-control w-100 h-100" style="resize:none" required autocomplete="on">{{$post->text}}</textarea>
            </div>
        </div>


        <div class="form-group row mb-0">
            <div class="col-md-8 offset-2 text-right">
                <button type="submit" class="btn btn-primary">
                    Edit Post
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('code')
    <script>
        var tags = (<?php echo $post->tags ?>).map(t=>t.name);
        
        var init = new Vue({
            el: "#create",
            data: {
                rows : tags
            },
            methods: {
                addRow: function() {
                    this.rows.push("");
                },
                removeRow: function(index) {
                    this.rows.splice(index, 1);
                }
            },
        });
    </script>
 @endsection

