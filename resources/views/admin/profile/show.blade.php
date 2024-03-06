@extends('admin.master')
@section('content')
<div class="row col-8 offset-2 p-2 rounded mt-5" style="background: grey">
    <a href="{{route('admin#homePage')}}" class="text-end" style="font-size:20px" >
        <i class="fa-solid fa-xmark"></i>
    </a>
   <div class="col-5 p-2 text-center mb-3">
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
   <div class="col-6  p-2 mb-3">
    <div class="d-flex p-1 rounded " style="box-shadow: 3px 3px 5px black; ">
        <h5 title="name" class="ms-2"><i class="fa-solid fa-user "></i></h5>
        <h5 class="ms-3">{{Auth::user()->name}}</h5>
    </div>

    <div class="d-flex p-1 rounded mt-3" style="box-shadow: 3px 3px 5px black; ">
        <h5 title="name" class="ms-2"><i class="fa-solid fa-envelope"></i></h5>
        <h5 class="ms-3">{{Auth::user()->email}}</h5>
    </div>

    <div class="d-flex p-1 rounded mt-3" style="box-shadow: 3px 3px 5px black; ">
        <h5 title="name" class="ms-2"><i class="fa-solid fa-person-half-dress"></i></h5>
        <h5 class="ms-3">{{Auth::user()->gender}}</h5>
    </div>

    @if (Auth::user()->phone != null)
    <div class="d-flex p-1 rounded mt-3" style="box-shadow: 3px 3px 5px black; ">
        <h5 title="name" class="ms-2"><i class="fa-solid fa-phone"></i></h5>
        <h5 class="ms-3">{{Auth::user()->phone}}</h5>
    </div>
    @endif

    <div class="d-flex p-1 rounded mt-3" style="box-shadow: 3px 3px 5px black; ">
        <h5 title="name" class="ms-2"><i class="fa-solid fa-user-clock"></i></h5>
        <h5 class="ms-3">{{Auth::user()->created_at->format('F-j-Y')}}</h5>
    </div>
   </div>
</div>
@endsection

