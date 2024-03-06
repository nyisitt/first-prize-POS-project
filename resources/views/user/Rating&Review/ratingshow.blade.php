@extends('user.profilemaster')
@section('userInfo')
{{-- alert box start --}}
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
{{-- alert box end --}}

<h4>My Rating & Review</h4>
    <div class="bg-white pfshow  p-5 " >
        @if (count($rating) !== 0)
        @foreach ($rating as $item)
        <div class="mb-3">
            <div class="row">
                <h5 class="col-2">{{$item->name}}</h5>
                <h5 class="col-5">Review</h5>
                <h5 class="col-2">Rating</h5>
                <h5 class="col-2">Date</h5>

            </div>
            <div class="row mt-2">
                <div class="col-2">
                    <img src="{{asset('storage/'.$item->first_image)}}" width="100%" class="rounded">
                </div>
                <div class="col-5 ">
                    <p style="text-indent: 20px">
                        {{$item->review}}
                    </p>
                </div>
                <div class="col-2 ">
                    @for ($i = 0 ; $i< $item->rating; $i++)
                    <i class="fa-solid fa-star text-warning"></i>
                    @endfor
                </div>
                <div class="col-2">
                    {{$item->created_at->diffForHumans()}}
                </div>
                <div class="col-1">
                    <a href="{{route('user#ratingDelete',$item->id)}}" class="text-dark"><i class="fa-solid fa-trash"></i></a>
                </div>
            </div>

        </div>
        <hr>
        @endforeach
        {{$rating->links()}}
        @else
        <div class="text-center">
            <h3 class="text-danger">There is no order.<span class="ms-3"><a href="{{route('user#homePage')}}">Continue to shop</a></span></h3>
        </div>
        @endif

    </div>
@endsection
