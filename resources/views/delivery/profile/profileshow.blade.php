@extends('delivery.home')
@section('text')
   <section class="containter pfmain" style="overflow-x: hidden">
        <div class="row ">
            <div class="col-2 offset-1 pfTitle">
                <h5 class="bolder">Manage My Account</h5>
                <a href="{{route('deli#profilePage')}}" class="ms-3  d-block"><i class="fa-solid fa-user-tie me-3"></i>My Profile</a>
                <a href="{{route('deli#profileEdit')}}" class="ms-3  mt-2 d-block"><i class="fa-solid fa-pen me-3"></i>Edit Profle</a>
                <a href="{{route('deli#psEdit')}}" class="ms-3  mt-2 d-block"><i class="fa-solid fa-unlock me-3"></i>Edit Password</a>


            </div>
            <div class="col-8 mt-3 ">

               @yield('userInfo')

            </div>
        </div>
   </section>
@endsection
