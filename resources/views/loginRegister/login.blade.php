@extends('loginRegister.master')
@section('textLogin')
<section class="container forms">

    <div class="form login">
        <a  class="float-end" onclick="history.back()">
            <i class="fa-solid fa-xmark text-dark fa-2x"></i>
        </a>
        <div class="form-content">
            <header>
                <img src="{{asset('images/2090259-removebg-preview.png')}}" class="img">
                <h3 class="pt-3">{{__('welcome.login')}}</h3>
            </header>
            <form action="{{route('login')}}" method="POST">
                @csrf
                <div class="field input-field">
                    <input type="email" placeholder="Email" class="input" name="email">
                </div>
                @error('email')
                <small class="text-danger">{{$message}}</small>
                @enderror

                <div class="field input-field">
                    <input type="password" placeholder="Password" class="password" name="password">
                    <i class='bx bx-hide eye-icon'></i>
                </div>
                @error('password')
                <small class="text-danger">{{$message}}</small>
                @enderror

                <div class="form-link">
                    <a href="{{route('forgetPassword')}}" class="forgot-pass">{{__('welcome.forget')}}</a>
                </div>

                <div class="field button-field">
                    <button type="submit">{{__('welcome.login')}}</button>
                </div>
            </form>




            <div class="form-link">
                <span>Don't have an account? <a href="{{route('registerPage')}}" class="">{{__('welcome.register')}}</a></span>
            </div>
        </div>

        <div class="line"></div>

        <div class="media-options">
            <a href="{{route('otp#Login')}}" class=" bg-success text-white p-3 rounded field facebook d-flex justify-content-start">
               <span ><i class="fa-solid fa-mobile text-dark" style="font-size: 25px"></i></span>
                <span style="margin-left: 70px"">{{__('welcome.otp')}}</span>
            </a>
        </div>

        <div class="media-options">
            <a href="{{route('facebookLogin')}}" class="field facebook">
                <i class='bx bxl-facebook facebook-icon'></i>
                <span>{{__('welcome.facebook')}}</span>
            </a>
        </div>

        <div class="media-options">
            <a href="{{route('googleLogin')}}" class="field google">
                <img src="{{asset('loginRegister/images/google.png')}}" alt="" class="google-img">
                <span>{{__('welcome.google')}}</span>
            </a>
        </div>

    </div>

    <!-- Signup Form -->


</section>
@endsection
