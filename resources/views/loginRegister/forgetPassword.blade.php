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
          <div class="text-end">
            <a href="{{route('loginPage')}}"> <i class="fa-solid fa-xmark text-dark fa-2x"></i></a>
          </div>


                <div class="form-content" style="width: 500px">
                    <p>We will send a link to your email , use that link to reset password.That email should same login email.</p>
                    <form action="{{route('sendEmail')}}" method="POST">
                        @csrf
                        <div class="">
                            <label class="mb-2">Email Address</label>
                            <input type="email" name="email" class="form-control">
                            @error('email')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class=" float-end">
                            <button class="btn btn-dark rounded my-4">Send</button>
                        </div>
                    </form>
                    </div>
                </div>





        </section>
@endsection


