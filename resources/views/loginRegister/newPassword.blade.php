@extends('loginRegister.master')
@section('textLogin')
{{-- alert box start --}}
@if (session('success'))
<div class="position-fixed top-20 end-0 p-3" style="z-index: 11">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <img src="{{asset('images/2090259-removebg-preview.png')}}" class="" width="50px">
        <strong class="me-auto">NS Shop Website</strong>
        <small>Just Now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body ">
       {{session('success')}}
      </div>
    </div>
  </div>
@endif
{{-- alert box end --}}

        <section class="container forms">
            <div class="rounded p-3" style="background: grey">

                <div class="form-content" style="width: 500px">
                    <h2 class="text-center">NS shop</h2>
                    <form action="{{route('passwordUpdate')}}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{$token}}">
                        <div class="">
                            <label class="mb-2">Email </label>
                            <input type="email" name="email" class="form-control">
                            @error('email')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                            @if (session('error'))
                            <small class="text-danger">{{session('error')}}</small>
                            @endif
                        </div>

                        <div class="">
                            <label class="mb-2">Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="">
                            <label class="mb-2">Confirm Password</label>
                            <input type="password" name="confirm" class="form-control">
                            @error('confirm')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class=" float-end">
                            <button class="btn btn-dark rounded my-4 w-100" type="submit">Send</button>
                        </div>


                    </form>
                    </div>
                </div>
        </section>
@endsection


