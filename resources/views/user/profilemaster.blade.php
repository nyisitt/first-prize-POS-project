@extends('master')
@section('contant')
   <section class="containter pfmain">
        <div class="row mt-5">
            <div class="col-2 offset-1 pfTitle">
                <h5 class="bolder">{{__('welcome.managepf')}}</h5>
                <a href="{{route('user#profileShow')}}" class="ms-3  d-block">{{__('welcome.userpfshow')}}</a>
                <a href="{{route('user#profileEdit')}}" class="ms-3  mt-2 d-block">{{__('welcome.pfedit')}}</a>
                <a href="{{route('user#passwordChange')}}" class="ms-3  mt-2 d-block">{{__('welcome.userpsedit')}}</a>

                <h5 class="mt-4">{{__('welcome.userreview')}}</h5>
                <a href="{{route('user#ratingshowPage')}}" class="ms-3 d-block">{{__('welcome.userrating')}}</a>
                <a href="{{route('user#heartLists')}}" class="ms-3 d-block mt-2">{{__('welcome.userwhilist')}}</a>

                <h5 class="mt-4">{{__('welcome.userorder')}}</h5>
                <a href="{{route('user#orderList')}}" class="ms-3 d-block">{{__('welcome.userorderlist')}}</a>
            </div>
            <div class="col-8 mt-3 ">

               @yield('userInfo')

            </div>
        </div>
   </section>
@endsection
