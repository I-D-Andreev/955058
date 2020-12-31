@extends("layouts.app")

@section("content")
<div class="container h-100">
    {{-- <ul class="list-group borderless m-auto">
        <div class="list-group-item border-0 bg-transparent">
            <h2 class="text-center">{{$user->name}}</h2>
        </div>

        <div class="list-group-item border-0 bg-transparent">
            <span class="h5 bg-info">{{__('Email:')}}  <span class="form-control w-75">  {{$user->email}}</span> </span>
            
        </div>

    </ul>
     --}}
     <div class="row">
         <h2 class="col-md-12 text-center">{{$user->name}}</h2>
    </div>
     <div class="row mt-2">
        <label class="col-md-5 col-form-label text-md-right">{{ __('E-Mail Address:') }}</label>

        <div class="col-md-6">
            <div class="form-control w-75 text-center"> {{$user->email}}</div>
        </div>
    </div>

    <div class="row mt-2">
        <label class="col-md-5 col-form-label text-md-right">{{ __('Account Type:') }}</label>

        <div class="col-md-6">
            <div class="form-control w-75 text-center"> {{$user->type}}</div>
        </div>
    </div>

    <div class="row mt-2">
        <label class="col-md-5 col-form-label text-md-right">{{ __('Phone Number:') }}</label>

        <div class="col-md-6">
            <div class="form-control w-75 text-center"> {{$user->profile->phone_number}}</div>
        </div>
    </div>

    <div class="row mt-2">
        <label class="col-md-5 col-form-label text-md-right">{{ __('Number of Posts:') }}</label>

        <div class="col-md-6">
            <div class="form-control w-75 text-center"> {{count($user->posts)}}</div>
        </div>
    </div>

    <div class="row mt-2">
        <label class="col-md-5 col-form-label text-md-right">{{ __('Number of Comments:') }}</label>

        <div class="col-md-6">
            <div class="form-control w-75 text-center"> {{count($user->comments)}}</div>
        </div>
    </div>

</div> 
 @endsection