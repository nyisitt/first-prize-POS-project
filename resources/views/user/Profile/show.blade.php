@extends('user.profilemaster')
@section('userInfo')
<h4>My Profile</h4>
<div class="bg-white pfshow row p-5 " >
   <div class="col-4 " >
    <h6 class="text-muted">Full Name</h6>
    <h6>{{Auth::user()->name}}</h6>
   </div>

   <div class="col-4 mb-2">
    <h6 class=" text-muted">Email Address</h6>
    <h6>{{Auth::user()->email}}</h6>
   </div>

   @if (Auth::user()->phone !== null)
   <div class="col-4 mb-2">
    <h6 class="text-muted">Phone</h6>
    <h6>{{Auth::user()->phone}}</h6>
   </div>
   @endif

   <div class="col-4 mb-2">
    <h6 class="text-muted">Gender</h6>
    <h6>{{Auth::user()->gender}}</h6>
   </div>
   <div class="col-4 mb-2">
    <h6 class="text-muted">Photo</h6>
    @if (Auth::user()->image == null)
    <div class="" style="width: 150px">
        @if (Auth::user()->gender == 'male')
            <img src="{{asset('images/default male.avif')}}" class="image" width="100%">
        @else
            <img src="{{asset('images/girl photo.jpg')}}" class="image" width="100%">
        @endif
    </div>
    @else
    <div class="" style="width: 200px">
        <img src="{{asset('storage/'.Auth::user()->image)}}" class="rounded" width="100%">
    </div>
    @endif
   </div>
</div>
@endsection
