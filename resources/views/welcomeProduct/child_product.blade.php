@foreach ($product as $item)

<div class="col-3 mb-4"  >
        <a href="{{route('productSinglePage',$item->id)}}">
        <div class="card" style="height: 350px; width:195px;">
            <img src="{{asset('storage/'.$item->first_image)}}" class="card-img-top " style="height:180px">
            <div class="card-body ">
              <h5 class="text-center mb-3 text-dark">{{$item->name}}</h5>
              @if ($item->price && $item->discount_price)

                <h5 class="text-warning ">Ks {{number_format($item->discount_price)}}</h5>
                <div class="d-flex ">
                    <h6 class=" text-decoration-line-through ">Ks {{number_format($item->price)}} </h6> &nbsp; &nbsp;<h6>{{$item->discount_precentage}} %</h6>
                </div>
              @else
              <h5 class="text-warning">Ks {{number_format($item->price)}}</h5>

              @endif

              @if ($item->total == 1)
              @if($item->user_name !== null )
              <div class="text-dark">Reviews - ( {{$item->total}})</div>
              @else
               Reviews - ( 0 )
              @endif
              @else
              <div class="text-dark">Reviews - ( {{$item->total}})</div>
              @endif

              <div class="text-dark"><i class="fa-solid fa-eye"></i> - ({{ $item->views }})</div>
            </div>
          </div>
        </a>
        </div>

@endforeach
<div id="paginationContainer">
   {{$product->links()}}
</div>
