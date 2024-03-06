@extends('master')
@section('contant')
<section class="containter pfmain">
    <div class="row col-8 offset-2">
        <div class="mt-5">
            <div class="" onclick="history.back()" style="cursor: pointer">
                <i class="fa-solid fa-arrow-left"></i>
            </div>

        <table class="table table-bordered bg-white text-center">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col">Qty</th>
                <th>Size</th>
                <th>Total Price</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($productLists as $key=>$item)
                <tr>
                    <th >{{$key +1}}</th>
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
                        <p class="py-2">Delivery_fee - {{$productLists[0]->deli_price}} Kyats</p>
                    </td>
                    <td colspan="2" ><p class="py-2">Deli With Total Price</p></td>
                    <td><p class="py-2">{{number_format($productLists[0]->total_price + $productLists[0]->deli_price)}} Kyats</p></td>
                  </tr>

            </tbody>
          </table>
        </div>
    </div>
</section>
@endsection
