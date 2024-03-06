@extends('user.profilemaster')
@section('userInfo')

<h4>My Order Lists</h4>
    <div class="bg-white pfshow  py-5 px-3 " >
        @if (count($orderLists) !== 0)
        <div class="mb-3">
            <div class="row mb-3">
                <h5 class="col-2">Order Code</h5>
                <h5 class="col-2">Total Price</h5>
                <h5 class="col-2 ">Deli Price</h5>
                <h5 class="col-2 ">Status</h5>
                <h5 class="col-2">Payment</h5>
                <h5 class="col-2">Date</h5>

            </div>
            @foreach ($orderLists as $item)
            <div class="row mt-3 mb-4 ">
                <a href="{{route('user#orderDetail',$item->card_code)}}" class="col-2 text-center"><h6>{{$item->card_code}}</h6></a>

                <div class="col-2"><h6>{{number_format($item->total_price)}} Ks</h6></div>
                <div class="col-2"><h6>{{number_format($item->deli_price)}} Ks</h6></div>
                <div class="col-2">
                    @if ($item->status == 0)
                    <h6 style="color: rgb(218, 218, 75)">Pending ....</h6>
                    @elseif ($item->status == 1 || $item->status ==3)
                    <h6 style="color: blueviolet">Success ....</h6>
                    @elseif ($item->status == 2)
                    <p class=" text-danger">Reject ....</p>
                    @endif
                </div>
                <div class="col-2">
                    @if ($item->payment == 0)
                    <h6>Home Payment</h6>
                    @else
                    <h6>Card Payment</h6>
                    @endif
                </div>
                <div class="col-2"><h6>{{$item->created_at->format('M,j,Y')}}</h6></div>


            </div>
        <hr>
        @endforeach
    </div>
        @else
            <div class="text-center">
                <h3 class="text-danger">There is no order.<span class="ms-3"><a href="{{route('user#homePage')}}">Continue to shop</a></span></h3>
            </div>
        @endif

    </div>
@endsection
