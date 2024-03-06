@extends('user.profilemaster')
@section('userInfo')
@if (session('message'))
{{-- alert box start --}}
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

<h4>My WishLists</h4>
    <div class="bg-white pfshow  p-5 " >
        @if (count($heart) !== 0)

            @foreach ($heart as $item)
            <div class="mb-3">
                <div class="row">
                    <h5 class="col-3">Name</h5>
                    <h5 class="col-2">Image</h5>
                    <h5 class="col-3 text-center">Price</h5>
                    <h5 class="col-3 text-center">Brand</h5>

                </div>
                <div class="row mt-3">
                    <div class="col-3 ">
                        <p >
                            {{$item->name}}
                        </p>
                    </div>
                    <div class="col-2">
                        <img src="{{asset('storage/'.$item->first_image)}}" width="100%" class="rounded">
                    </div>

                    <div class="col-3 text-center">
                      @if ($item->discount_price == null)
                        <p>{{$item->price}} Kyats</p>
                      @else
                      <p>{{$item->discount_price}} Kyats</p>
                      @endif
                    </div>

                    <div class="col-3 text-center">
                        @if ($item->brand == null)
                        <p>No Brand</p>
                        @else
                      <p>{{$item->brand}}</p>
                        @endif
                    </div>
                    <div class="col-1">
                        <a href="{{route('user#heartDelete',$item->id)}}" class="text-dark"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>

            </div>
            <hr>
            @endforeach
            {{$heart->links()}}

        @else
        <div class="text-center">
            <h3 class="text-danger">There is no wishlist.<span class="ms-3"><a href="{{route('user#homePage')}}">Continue to shop</a></span></h3>
        </div>
        @endif

    </div>

@endsection
