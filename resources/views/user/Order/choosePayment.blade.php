@extends('master')
@section('contant')
<div class="">hello</div>
<section class="cardshow">
        <div class="row d-flex ">
            <div class="text-center">
                <h2>Choose Payment</h2>
            </div>
{{-- Home Payment start--}}
            <div class="col-5 offset-1 mt-4 mb-5">
               <div class="card p-5 pt-3">
                <div class="card-title text-center">
                    <h3>Home Payment</h3>
                </div>
                <div class="card-body">
                    <img src="{{asset('images/logistics-two-color.svg')}}" alt="">
                    <div class=" my-3">
                        <div class=" row">
                            <h5 class="col-6 text-center"> Product_code  </h5>
                            <h5 class="col-6"> = {{$order->card_code}}</h5>
                        </div>
                        <div class=" row">
                            <h5 class="col-6 text-center"> Product_prices </h5>
                            <h5 class="col-6"> = {{number_format($order->total_price)}} Kyats</h5>
                        </div>
                        <div class=" row">
                            <h5 class="col-6 text-center"> Delivery_prices </h5>
                            <h5 class="col-6"> = {{number_format($order->deli_price)}} Kyats</h5>
                        </div>
                        <div class=" row">
                            <h5 class="col-6 text-center"> Total_prices </h5>
                            <h5 class="col-6"> = {{number_format($order->total_price + $order->deli_price)}} Kyats</h5>
                        </div>

                     </div>
                </div>
                <a href="{{route('user#orderList')}}" class="text-center">
                    <button class="btn btn-secondary">Continue to Home Payment</button>
                </a>
               </div>

            </div>
{{-- Home Payment end--}}

{{-- Cart Payment start --}}
            <div class="col-5 ms-5 mt-4">
                <div class="card p-5 pt-3">
                    <div class="card-title text-center">
                        <h3>Cart Payment</h3>
                    </div>
                    <div class="card-body">
                        <img src="{{asset('images/credit-card-outline.svg')}}" alt="">
                        <div class=" my-3">
                            <div class=" row">
                                <h5 class="col-6 text-center"> Product_code  </h5>
                                <h5 class="col-6"> = {{$order->card_code}}</h5>
                            </div>
                            <div class=" row">
                                <h5 class="col-6 text-center"> Product_prices </h5>
                                <h5 class="col-6"> = {{number_format($order->total_price)}} Kyats</h5>
                            </div>
                            <div class=" row">
                                <h5 class="col-6 text-center"> Delivery_prices </h5>
                                <h5 class="col-6"> = {{number_format($order->deli_price)}} Kyats</h5>
                            </div>
                            <div class=" row">
                                <h5 class="col-6 text-center"> Total_prices </h5>
                                <h5 class="col-6"> = {{number_format($order->total_price + $order->deli_price)}} Kyats</h5>
                            </div>

                         </div>
                    </div>

                    <a class="text-center">
                        <form action="{{route('user#paymentHomePage')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$order->id}}">
                            <input type="hidden" name="qty" value="{{$qty}}">
                            <button class="btn btn-secondary" type="submit">Continue to Cart Payment</button>
                        </form>
                    </a>
                   </div>
            </div>
{{-- Cart Payment end --}}
        </div>
</section>
@endsection
