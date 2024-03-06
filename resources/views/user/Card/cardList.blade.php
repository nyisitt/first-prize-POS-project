@extends('master')
@section('contant')
<div class="">hello</div>
<section class="cardshow">

{{-- alert box --}}
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

{{-- show list header --}}
        @if (count($card) !== 0)
        <div class="row d-flex ">
            <div class="col-8 mt-4">
                <a class="" href="{{route('user#cardAllDelete')}}">
                    <button class="btn btn-secondary py-1 mb-2">All delete</button>
                  </a>
              @foreach ($card as $item)

              <div class="mt-1 mb-2 bg-light rounded cardContainer">
                <div class="row  ms-2 ">
                    <input type="hidden" value="{{$item->product_id}}" class="productId">
                    <input type="hidden" value="{{$item->user_id}}" class="userId">
                   <div class="col-2"><h5 class="mt-2 mb-0"> {{$item->name}}</h5></div>
                <a href="{{route('user#cartSoloDelete',$item->id)}}" class="col-1 offset-9 mt-2 mb-0 text-dark">
                    <i class="fa-solid fa-trash"></i>
                </a>
                </div>

                <hr class="mb-0">
{{-- show list body --}}
                <div class="row  p-3 parents">
                    <div class="ms-3 col-2">
                        <img src="{{asset('storage/'.$item->first_image)}}" width="100%" class="rounded" height="100px">
                    </div>

                    <div class="col-3  text-center">
                        @if ($item->discount_price == null)
                        <h5 class=" mt-3" id="price">{{ number_format($item->price )}} Kyats</h5>
                        @else
                        <h5 class=" mt-3" id="price">{{number_format($item->discount_price)}} Kyats</h5>
                       <div class="d-flex ">
                        <p class=" text-decoration-line-through ms-3">{{number_format($item->price)}} Kyates</p>
                        <p class="ms-3">{{number_format($item->discount_precentage)}} %</p>
                       </div>
                        @endif

                        @if ($item->size !== null)
                        <div class="">
                            <h6 class="">Size - <span class="size">{{$item->size}}</span></h6>
                        </div>
                        @endif
                    </div>

                    <div class="col-3">
                        <div class="quantity mt-3">
                            <li class="list-inline-item text-right">
                                <input type="hidden" name="qty" class="product-quanity" value="1">
                            </li>
                            <li class="list-inline-item"><span class="btn btn-success btn-minus">-</span></li>
                            <li class="list-inline-item"><span class="badge bg-secondary var-value" >{{$item->qty}}</span></li>
                            <li class="list-inline-item"><span class="btn btn-success btn-plus" >+</span></li>

                        </div>

                    </div>
                    <div class="col-3 text-center mt-3" >
                        @if ($item->discount_price == null)
                        <h5 id="totalPrice">{{number_format($item->qty * $item->price)}} Kyats</h5>
                        @else
                        <h5 id="totalPrice">{{number_format($item->qty * $item->discount_price)}} Kyats</h5>
                        @endif

                    </div>

                </div>

            </div>

              @endforeach
            </div>
{{-- Card summery --}}
            <div class="col-4 mt-4 ">
               <h4 class="mb-3">Cart Summery ----------</h4>
               <div class="bg-light rounded p-3">
                <div class="d-flex justify-content-between mb-3 mt-3">
                    <h5>Subtotals <span id="allItem">( {{$totalQty}} )</span></h5>
                    <h6 id="allPrice">Ks {{number_format($totalPrice)}}</h6>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <h5>Delivery Fee</h5>
                    <h6 id="deliveryFee">Ks 3000</h6>
                </div>
                <hr class="mb-4">
                <div class="d-flex justify-content-between mb-3 ">
                    <h5>Total</h5>
                    <h6 id="withDeliFee">Ks {{$totalPrice + 3000}}</h6>
                </div>
                <div  class="text-center mb-3 " id="checkout">
                    <button class="btn btn-secondary w-100">PROCEED TO CHECKOUT </button>
                </div>
            </div>
            </div>

        </div>
        @else
            <div class="text-center p-5 ">
                <h4 class="bg-danger text-white rounded p-3 d-inline ">There is No Cards. <span ><a href="{{route('user#homePage')}}" class="text-white">Continue to shop</a></span></h4>
            </div>
        @endif

</section>
@endsection

@section('script')
<script>
// To increase descrease qty
     $('.btn-minus').click(function(){
        $parent = $(this).parents('.quantity');
        var val = $parent.find('.var-value').html();

        val = (val=='1')?val:val-1;
        $parent.find('.var-value').html(val);
        $parent.find(".product-quanity").val(val);
        return false;
    });
    $('.btn-plus').click(function(){
    $parent = $(this).parents('.quantity');
      var val = $parent.find(".var-value").html();
      val++;
      $parent.find(".var-value").html(val);
      $parent.find(".product-quanity").val(val);
      return false;
    });

// To Checkout
    $('#checkout').click(function(){
        var totalPrice = $('#allPrice').html().replace('Ks','').replace(/,/g, '')
        var delivery = $('#deliveryFee').html().replace('Ks','')
        var datalists = []
        var random = Math.floor(Math.random() * 100000000)
        $('.cardContainer').each(function(index,row){
            datalists.push({
                'user_id' : $(row).find('.userId').val(),
                'product_id' : $(row).find('.productId').val(),
                'qty' : $(row).find('.product-quanity').val(),
                'total' : $(row).find('#totalPrice').html().replace('Kyats','').replace(/,/g, ''),
                'size' : $(row).find('.size').html(),
                'order_code' : random
            })
        })
        console.log(datalists);
        $.ajax({
            url : '/user/add/original/card',
                type : 'get',
                data : Object.assign({}, datalists),
                dataType : "JSON",
                success : function(response){
                    window.location.href = '/user/delivery/page'+"?data="+random+'&'+'price='+totalPrice+'&'+'delivery='+delivery
                }
        })
    })

// To increase decrease total price
    $('.btn-plus').click(function(){
        $parent = $(this).parents('.parents');
        var price =$parent.find('#price').html().replace('Kyats','').replace(/,/g, '');
        var qty = $parent.find('.product-quanity').val();
         $total = (price * qty).toLocaleString();
        $parent.find('#totalPrice').html(`${$total} Kyats `)

        $allPrice = 0 ;
        $allItem = 0 ;
        $('.cardContainer').each(function(index,row){
            $totalPrice = $(row).find('#totalPrice').html();
            $totalPrice = Number($totalPrice.replace('Kyats','').replace(/,/g, ''));
            $totalQty = Number($(row).find('.var-value').html());
            $allItem += $totalQty
            $allPrice += $totalPrice
        })
        $('#allItem').html(`( ${$allItem} )`)
        $('#allPrice').html(` Ks ${$allPrice}`)

        if($allItem >= 10){
            var additionalFee = (($allItem - 10) / 5) * 1000;
           var deliveryFee = 3000 + additionalFee ;
           console.log(deliveryFee);
           $('#deliveryFee').html(`Ks ${deliveryFee}`)
           var withDeliFee = $allPrice + deliveryFee
           $('#withDeliFee').html(` Ks ${withDeliFee}`)
        }

        if($allItem <= 10){
            $('#deliveryFee').html(`Ks 3000`)
           $price = $allPrice + 3000
             $('#withDeliFee').html(` Ks ${$price}`);

        }

    });
    $('.btn-minus').click(function(){
        $parent = $(this).parents('.parents');
        var price =$parent.find('#price').html().replace('Kyats','').replace(/,/g, '');
        var qty = $parent.find('.product-quanity').val();
         $total = (price * qty).toLocaleString();

        $parent.find('#totalPrice').html(` ${$total} Kyats`)

        $allPrice = 0 ;
        $allItem = 0 ;
        $('.cardContainer').each(function(index,row){
            $totalPrice = $(row).find('#totalPrice').html();
            $totalPrice = Number($totalPrice.replace('Kyats','').replace(/,/g, ''));
            $totalQty = Number($(row).find('.var-value').html());
            $allItem += $totalQty
            $allPrice += $totalPrice
        })
        $('#allItem').html(`( ${$allItem} )`)
        $('#allPrice').html(` Ks ${$allPrice}`)

        if($allItem >= 10){
            var additionalFee = (($allItem - 10) / 5) * 1000;
           var deliveryFee = 3000 + additionalFee ;
           console.log(deliveryFee);
           $('#deliveryFee').html(`Ks ${deliveryFee}`)
           var withDeliFee = $allPrice + deliveryFee
           $('#withDeliFee').html(` Ks ${withDeliFee}`)
        }
        if($allItem <= 10){
            $('#deliveryFee').html(`Ks 3000`)
           $price = $allPrice + 3000
             $('#withDeliFee').html(` Ks ${$price}`);

        }
    });

</script>
@endsection

