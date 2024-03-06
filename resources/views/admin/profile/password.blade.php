@extends('admin.master')
@section('content')
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



<div class="row col-6 offset-3 p-2 rounded mt-5 mb-5" style="background: grey; ">
    <a href="{{route('admin#homePage')}}" class="text-end text-dark" style="font-size:20px" >
        <i class="fa-solid fa-xmark"></i>
    </a>
        <h3 class="text-center">Password Change</h3>


       <form action="{{route('admin#passwordUpdate')}}"  method="POST">
        @csrf
        <input type="hidden" name="id" value="{{Auth::user()->id}}">


       <div class="col-7  m-auto mt-3" >
        <label for="" class="me-3">Old Password</label>
        <input type="password" name="oldPassword" class="form-control @error('oldPassword') is-invalid @enderror " placeholder="Enter Old Password" >
        @if (session('error'))
        <small class="text-warning">{{session('error')}}</small>
        @endif
        @error('oldPassword')
        <small class="text-warning">{{$message}}</small>
        @enderror
       </div>

       <div class="col-7  m-auto mt-3" >
        <label for="" class="me-3">New Password</label>
        <input type="password" name="newPassword" class="form-control @error('newPassword') is-invalid @enderror" placeholder="Enter New Password" >
        @error('newPassword')
        <small class="text-warning">{{$message}}</small>
        @enderror
       </div>



       <div class="col-7  m-auto mt-3" >
        <label for="" class="me-3">Confirm Password</label>
        <input type="password" name="confirm" class="form-control @error('confirm') is-invalid @enderror" placeholder="Enter Confirm Password" >
        @error('confirm')
        <small class="text-warning">{{$message}}</small>
        @enderror
       </div>

       <button class="btn btn-dark rounded my-3" style="width: 230px; margin-left:180px">Change Password</button>
       </form>




</div>
@endsection



