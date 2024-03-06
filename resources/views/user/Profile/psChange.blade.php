@extends('user.profilemaster')
@section('userInfo')
{{-- alert box start --}}
@if (session('message'))
<div class="position-fixed top-20 end-0 p-3" style="z-index: 11">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <img src="{{asset('images/2090259-removebg-preview.png')}}" class="" width="50px">
        <strong class="me-auto">NS Shop Website</strong>
        <small>Just Now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body ">
       {{session('message')}}
      </div>
    </div>
  </div>
@endif
{{-- alert box end --}}

<h4>Change Password</h4>
<form action="{{route('user#passwordUpdate')}}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{Auth::user()->id}}">
    <div class="bg-white pfshow  p-5 ">
        <div class="mb-3">
            <h6>Current Password</h6>
            <input type="password" name="oldPassword" class="form-control w-50 @error('oldPassword') is-invalid @enderror " placeholder="Please Enter Current Password" >
            @if (session('error'))
                <small class="text-danger">{{session('error')}}</small>
            @endif
            @error('oldPassword')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>

        <div class="mb-3">
            <h6>New Password</h6>
            <input type="password" name="newPassword" class="form-control w-50 @error('newPassword') is-invalid @enderror" placeholder="Minmun 6 characters with number and  letter" >
            @error('newPassword')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>

        <div class="mb-3">
            <h6>Confirm Password</h6>
            <input type="password" name="confirm" class="form-control w-50 @error('confirm') is-invalid @enderror" placeholder="Enter retype your password" >
                @error('confirm')
                    <small class="text-danger">{{$message}}</small>
                @enderror
        </div>

        <div class="text-center mt-1">
            <button class="btn btn-secondary w-25">Change</button>
        </div>
    </div>


</form>
@endsection
