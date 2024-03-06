@extends('delivery.profile.profileshow')
@section('userInfo')
{{-- alert box start --}}
@if (session('error'))
<div class="position-fixed top-20 end-0 p-3" style="z-index: 11">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <img src="{{asset('images/2090259-removebg-preview.png')}}" class="" width="50px">
        <strong class="me-auto">NS Shop Website</strong>
        <small>Just Now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body ">
       {{session('error')}}
      </div>
    </div>
  </div>
@endif
{{-- alert box start --}}

<h4>Security Password</h4>
    <div class="bg-white pfshow p-5 " >
{{-- To check password --}}
        @if(session('correct'))
        <div class="text-center">
            <i class="fa-regular fa-circle-check"></i>
        </div>
        <div class="mt-5 " style="margin-left: 230px">
            <form action="{{route('deli#emailUpate')}}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{Auth::user()->id}}">
                <label for="">Email</label>
                <input type="text" value="{{old('email',Auth::user()->email)}}" class="form-control w-50" placeholder="Please enter change email" name="email">
                @error('email')
                    <small class="text-danger">{{$message}}</small>
                @enderror
                <div class="m-auto">
                    <button class="btn btn-secondary mt-3">Change</button>
                </div>
            </form>
            </div>

        @else
{{-- To change gmail --}}
        <div class="text-center">
            <i class="fa-solid fa-shield mb-3"></i>
            <p>To protect your account security , we need to old password.</p>
            <p>If you logined with <strong>Google</strong> or <strong>Facebook</strong>, Sorry do not change.</p>
        </div>
        <div class="mt-5 " style="margin-left: 230px">
            <form action="{{route('deli#psCheck')}}" method="POST">
                <input type="hidden" name="id" value="{{Auth::user()->id}}">
                @csrf
                <input type="password" name="password" class="form-control w-50 d-inline" placeholder="Please enter current password">

                <button class="btn btn-secondary ms-2 mb-1" type="submit">Next</button>
            </form>
        </div>
        @endif

    </div>
@endsection
