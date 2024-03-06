@extends('loginRegister.master')
@section('textLogin')
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

<section class="container forms">
    <div class="rounded p-3" style="background: grey">
        <div class="text-end" >
            <a href="{{route('otp#Login')}}"> <i class="fa-solid fa-xmark text-dark fa-2x"></i></a>
          </div>
        <div class="form-content" style="width: 500px">
            <h2 class="text-center">OTP Login</h2>
            <form action="{{route('otp#codePost')}}" method="POST">
                @csrf
                <div class="">
                    {{-- <input type="text" name="userId" value="{{$message}}"> --}}
                    <input type="hidden" name="userId" value="{{$id}}">
                    <label class="mb-2">OTP Code</label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid
                    @enderror" placeholder="Enter OTP number">
                    @error('code')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                    @if(session('error'))
                    <small class="text-danger">{{session('error')}}</small>
                    @endif

                </div>



                <div class=" float-end">
                    <button class="btn btn-dark rounded my-4 w-100" type="submit">Send OTP</button>
                </div>


            </form>

            </div>
        </div>





</section>
@endsection
