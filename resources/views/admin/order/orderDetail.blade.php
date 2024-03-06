@extends('admin.master')
@section('content')
{{-------------- Product Lists start--------------}}
<div class="mt-5 row col-10 offset-1">
    <div class="text-start ps-0 mb-2 d-flex justify-content-between">
        <button class="text-white btn btn-dark" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i></button>
        <div class="">
           <h4 class="text-white">Date - {{$orderDetail[0]->created_at->format('M,j,Y')}}</h4>
        </div>
    </div>
    <table class="table table-bordered bg-white text-center caption-top rounded">
        <caption class="text-white" style="font-size: 25px">Product Lists Table</caption>
        <thead>
          <tr>
            <th scope="col">No</th>
            <th>Name</th>
            <th scope="col">Image</th>
            <th scope="col">Price</th>
            <th scope="col">Qty</th>
            <th>Size</th>
            <th>Total Price</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($orderDetail as $key=>$item)
            <tr>
                <td >{{$key +1}}</td>
                <td>{{$item->name}}</td>
                <td class="col-2 ">
                    <img src="{{asset('storage/'.$item->first_image)}}" width="100%" height="100px" class="rounded">
                </td>
                <td class="">
                    @if ($item->discount_price == null)
                    <p>{{number_format($item->price)}} Ks</p>
                    @else
                    <p>{{number_format($item->discount_price)}} Ks</p>
                    @endif
                </td>
                <td>
                    <p>{{$item->qty}}</p>
                </td>
                <td>
                    @if ($item->size !== null)
                    {{$item->size}}
                    @endif
                </td>
                <td >
                    {{number_format($item->total )}} Ks
                </td>
              </tr>
            @endforeach


        </tbody>
      </table>
</div>
{{-------------- Product Lists end--------------}}

{{-- Delivery Infomation start--}}
<div class="mt-5 row col-10 offset-1">

    <table class="table table-bordered bg-white text-center caption-top rounded">
        <caption class="text-white" style="font-size: 25px">Delivery Information Table</caption>
        <thead>
          <tr>
            <th >Full Name</th>
            <th >Phone</th>
            <th >Email</th>
            <th >Region</th>
            <th >City</th>
            <th>Address</th>

          </tr>
        </thead>
        <tbody>
            <tr>
                <td >{{$orderDetail[0]->full_name}}</td>
                <td>{{$orderDetail[0]->phone_number}}</td>
                <td >{{$orderDetail[0]->email_address}} </td>
                <td class="">{{$orderDetail[0]->region}} </td>
                <td>{{$orderDetail[0]->city}}</td>
                <td>{{$orderDetail[0]->address}}</td>

              </tr>



        </tbody>
      </table>
</div>
{{-- Delivery Infomation end--}}

{{-- Payment Infomation --}}
@if ($orderDetail[0]->payName == null && $orderDetail[0]->payEmail == null && $orderDetail[0]->amount == null)
   <div class="col-6 offset-3 bg-white p-3 my-5 rounded">
        <div class="cart">
            <h3 class="text-center">Home Payment</h3>
        </div>
        <div class=" col-6 offset-3">
            <img
                src="{{asset('images/logistics-two-color.svg')}}"
                class="img-fluid rounded-top"
                alt=""
            />
        </div>

   </div>
@else
            <div class="col-6 offset-3 bg-white p-3 my-5 rounded">
                <div class="cart">
                    <h3 class="text-center">Card Payment</h3>
                </div>
                <div class="row">
                <div class="col-6 mt-3">
                    <img
                        src="{{asset('images/credit-card-outline.svg')}}"
                        class="img-fluid rounded-top"
                        alt=""
                    />
                </div>
                <div class="col-6">
                    <div class=" mt-5">
                        <h6><i class="fa-solid fa-user me-2"></i>Payment Name    </h6>
                        <h6 class=" ms-3 text-secondary">{{ $orderDetail[0]->payName}}</h6>
                    </div>
                    <div class=" mt-2">
                        <h6><i class="fa-regular fa-envelope me-2"></i>Payment Email  </h6>
                        <h6 class=" ms-3 text-secondary">{{ $orderDetail[0]->payEmail}}</h6>
                    </div>
                    <div class=" mt-2">
                        <h6><i class="fa-solid fa-money-bill me-2"></i>Total Amount  </h6>
                        <h6 class=" ms-3 text-secondary">{{ $orderDetail[0]->amount}} Kyats</h6>
                    </div>
                </div>
            </div>
            </div>
@endif
@endsection
