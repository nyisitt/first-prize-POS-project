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

    <div class="mt-3 text-center">
        @if (Auth::user()->image == null)
        @if (Auth::user()->gender == 'male')
        <img src="{{asset('images/default male.avif')}}" class="rounded" width="200px" style="box-shadow:3px 3px 5px rgb(31, 29, 29)" >
        @else
        <img src="{{asset('images/girl photo.jpg')}}" class="rounded " width="200px" style="box-shadow:3px 3px 5px rgb(31, 29, 29)">
        @endif
        @else
        <img src="{{asset('storage/'.Auth::user()->image)}}" class="rounded " width="200px" style="box-shadow:3px 3px 5px rgb(31, 29, 29)">
        @endif
       </div>

       <form action="{{route('admin#profileUpdate')}}" class="row" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{Auth::user()->id}}">
        <div style="margin-left: 170px" class="mt-2">
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" style="width: 300px" >
          </div>
          @error('image')
          <small class="text-danger text-center">{{$message}}</small>
          @enderror

       <div class="col-6  m-auto mt-3" >
        <label for="" class="me-3">Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name" value="{{old('name',$profile->name)}}">
        @error('name')
        <small class="text-danger">{{$message}}</small>
        @enderror
       </div>

       <div class="col-6  m-auto mt-3" >
        <label for="" class="me-3">Email</label>
        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email" value="{{old('email',$profile->email)}}">
        @error('email')
        <small class="text-danger">{{$message}}</small>
        @enderror
       </div>

       <div class="col-6  m-auto mt-3" >
        <label for="" class="me-3">Gender</label>
        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
            <option value="">Choose Gender</option>
            <option value="male" @if (Auth::user()->gender == 'male')selected @endif>Male</option>
            <option value="femail" @if (Auth::user()->gender == 'female')selected @endif>Female</option>
        </select>

        @error('gender')
        <small class="text-danger">{{$message}}</small>
        @enderror
       </div>

       <div class="col-6  m-auto mt-3" >
        <label for="" class="me-3">Phone</label>
        <input type="text" name="phone" class="form-control" placeholder="Enter Phone" value="{{old('phone',$profile->phone)}}" oninput="formatPhoneNumber(this)">
        @error('phone')
        <small class="text-danger">{{$message}}</small>
        @enderror
       </div>

       <button class="btn btn-dark rounded my-3" style="width: 100px; margin-left:260px">Update</button>
       </form>




</div>
@endsection
@section('script')
<script>
    function formatPhoneNumber(input) {
        // Remove non-numeric characters
        let phoneNumber = input.value.replace(/\D/g, '');

        // Ensure the phone number starts with "09"
        if (!phoneNumber.startsWith('09')) {
            phoneNumber = '09' + phoneNumber;
        }

        // Update the input value
        input.value = phoneNumber;
    }
  </script>

@endsection


