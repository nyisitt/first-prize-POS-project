@extends('delivery.home')
@section('text')
    <div class="">hello</div>
        <div class="delivery  container  mb-5   p-5" >
       <div class="text-center " style="height: 200px">
        <img src="{{asset('images/map-isometric.svg')}}" alt="" height="100%">
       </div>
       <div class="mt-3">
        <a class="mb-3 text-white" href="{{route('deli#homePage')}}"><i class="fa-solid fa-arrow-left"></i></a>
        <table class="table table-primary  text-center table-striped table-hover table-bordered border-dark caption-top rounded">

            <thead class="table-dark">
                <tr>
                    <th >Name</th>
                    <th >Phone </th>
                    <th>E Mail</th>
                    <th >Region</th>
                    <th>City</th>
                    <th >Address</th>
                  </tr>
            </thead>
            <tbody>

                    <tr>
                        <th>{{$order[0]->full_name}}</th>
                        <th>{{$order[0]->phone_number}}</th>
                        <th>{{$order[0]->email_address}}</th>
                        <th>{{$order[0]->region}}</th>
                        <th>{{$order[0]->city}}</th>
                        <th>{{$order[0]->address}}</th>
                    </tr>


            </tbody>
        </table>
       </div>

       <div class="mt-5">
        <div class="text-center " style="height: 200px">
            <img src="{{asset('images/factory-worker-two-color.svg')}}" height="100%">
           </div>

           <div class="">
            <table class="table table-primary  text-center table-striped table-hover table-bordered border-dark caption-top rounded ">
                <thead class="table-dark">
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
                    @foreach ($order as $key=>$item)
                    <tr>
                        <th >{{$key +1}}</th>
                        <th>{{$item->name}}</th>
                        <td class="col-2 ">
                            <img src="{{asset('storage/'.$item->first_image)}}" width="100%" height="100%" class="rounded">
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
                      <tr>
                        <td colspan="3">
                            <p class="py-2">Delivery_fee - {{$order[0]->deli_price}} Kyats</p>
                        </td>
                        <td colspan="3" ><p class="py-2">Deli With Total Price</p></td>
                        <td><p class="py-2">{{number_format($order[0]->total_price + $order[0]->deli_price)}} Kyats</p></td>
                      </tr>

                </tbody>
              </table>
           </div>
       </div>
        </div>
@endsection
