@extends("layouts.app")

@push('imports')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>  
@endpush

@section("content")
<div id="createEdit" class="card-body">
    <form method="POST" action=@yield("formAction")>
        @csrf
        @yield("formMethod", "")

        <div class="form-group row m-0">
            <label for="title" class="col-md-12 col-form-label text-center">{{ __('Title') }}</label>
        </div>

        
        <div class="form-group row">
            <div class="col-md-4 offset-md-4">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value=@yield("title") required autocomplete="on" autofocus>

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
                <div id="ckeditParent" class="col-md-10 offset-md-1">
                    <textarea id="text" name="text" class="@error('text') is-invalid @enderror">@yield("text")</textarea>
                    
                    @error('text')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <button type="submit" class="btn btn-primary mt-2 float-right">
                        @yield("buttonName", "")
                    </button>
                </div>
        </div>
    </form>
   
</div>

@endsection

@section('code')
    @yield("preCode")

    <script>
        var rowNames = rowNames ? rowNames : [];

        var init = new Vue({
            el: "#createEdit",
            data: {
                rows : rowNames
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

    <script>
        $(function() {
            CKEDITOR.replace('text', {
                resize_enabled: false,
                height: "70%",
                image_previewText: " ",
                filebrowserUploadUrl: "{{route('posts.image.store', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form',
            });
        });
    </script>
 @endsection

