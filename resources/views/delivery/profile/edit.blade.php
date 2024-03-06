@extends('delivery.profile.profileshow')
@section('userInfo')
<h4>My Profile Edit</h4>

    <form action="{{route('deli#profileUpdate')}}" method="POST" enctype="multipart/form-data">
        @csrf
    <div class="bg-white pfshow row p-5 " >
        <div class="col-4 mb-5" >
            <input type="hidden" name="id" value="{{Auth::user()->id}}">
            <h6 class="text-muted">Full Name</h6>
            <input type="text" name="name" value="{{old('name',Auth::user()->name)}}" class="userinput" placeholder="Enter your name">
            @error('name')
                <small class="d-block text-danger">{{$message}}</small>
            @enderror
           </div>

           <div class="col-4 mb-5" >
            <h6 class="text-muted">Photo</h6>
             <input type="file" name="image" class="userinput w-100" >
             @error('image')
             <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

           <div class="col-4 mb-5 ps-5">
            <h6 class="text-muted">Gender</h6>
            <select name="gender" class="userselectbox">
                <option value="">Choose Gender</option>
                <option value="male" @if (Auth::user()->gender == 'male') selected @endif>Male</option>
                <option value="female"  @if (Auth::user()->gender == 'female') selected @endif>Female</option>
            </select>
            @error('gender')
            <small class="d-block text-danger">{{$message}}</small>
                @enderror
           </div>

           <div class="col-4">
            <h6 class="text-muted">Email Address</h6>
            <h6 class="d-inline">{{Auth::user()->email}}</h6> | <a href="{{route('deli#emailEdit')}}"><small>change</small></a>
           </div>

           @if (Auth::user()->phone == null)
           <div class="col-4">
           <h6 class="text-muted">Phone Address</h6>
           <input type="text" name="phone" class="userinput" placeholder=" Enter your phone" oninput="formatPhoneNumber(this)">
           @error('phone')
           <small class="d-block text-danger">{{$message}}</small>
           @enderror
            </div>

           @else
           <div class="col-4 mb-5" >
           <h6 class="text-muted">Phone Address</h6>
           <input type="text" name="phone" value="{{old('phone',Auth::user()->phone)}}" class="userinput"  oninput="formatPhoneNumber(this)">
           @error('phone')
               <small class="d-block text-danger">{{$message}}</small>
           @enderror
          </div>
           @endif

           <div class="text-center mt-5 ">
                <button class="btn btn-secondary w-25" type="submit">Change</button>
           </div>
    </form>
 </div>
@endsection
