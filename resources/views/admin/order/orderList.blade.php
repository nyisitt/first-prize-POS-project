@extends('admin.master')
@section('content')
<section class="row mt-4">
    <div class="text-center"><h2 class="text-white">Order Lists</h2></div>
    <div class="my-5 col-10 offset-1 text-white">
        <div class="d-flex justify-content-between">
            <div class="">
                <h5>Total Order - {{$orders->total()}}</h5>
                <h5>Home Payment - {{$homepayment}}</h5>
                <h5>Card Payment - {{$cartpayment}}</h5>
            </div>
            <div class="">
                <h5>Pending - {{$pending}}</h5>
                <h5>Success - {{$success}}</h5>
                <h5>Reject - {{$reject}}</h5>
            </div>
        </div>
    </div>
    <div class="col-10 offset-1">
        <div class="d-flex justify-content-between">
            <h5 class="text-white">Order Status - <select id="filterStatus" class="rounded px-3 py-1">
                <option value="all">All</option>
                <option value="0">Pending</option>
                <option value="1">Success</option>
                <option value="2">Reject</option>
                <option value="3">Deli Sent</option>
            </select></h5>
            <h5 class="text-white">Payment - <select name="" id="paymentfilter" class="rounded px-3 py-1">
                <option value="all">Choose</option>
                <option value="1">Card</option>
                <option value="0">Home</option>
            </select></h5>
        </div>
    </div>
    <div class="" id="orderContainer">
    @foreach ($orders as $key=>$item)

        <div class="col-10 offset-1  my-3 p-3 rounded @if ($item->status == 1 || $item->status == 3 )bg-info @elseif ($item->status == 0)bg-white @elseif ($item->status == 2)bg-danger @endif " >
            <div class="d-flex">
                <h6 class="me-3  "  style="width: 50px" >No</h6>
                <h6 class="me-3  " style="width: 120px">Name</h6>
                <h6 class="me-3 " style="width: 120px">Product Lists</h6>
                <h6 class="me-3 " style="width: 120px">Deli Info</h6>
                <h6 class="me-3 " style="width: 120px"> Prices</h6>
                <h6 class="me-3 " style="width: 120px">Deli Prices</h6>
                <h6 class="me-3 " style="width: 120px">Payment</h6>
                @if ($item->status !== 3)
                <h6 class="me-3 " style="width: 120px">Status</h6>
                @endif
                @if ($item->status == 1 || $item->status ==3)
                <h6 class="" style="width: 50px"> Deli</h6>
                @endif
            </div>
            <div class="d-flex mt-3 " >

                <p class="me-3  " style="width: 50px" >{{$key + 1}}</p>
                <p class="me-3 " style="width: 120px">{{$item->name}}</p>

                <a href="{{route('admin#orderDetailPage',$item->id)}}" class="me-3 text-decoration-none" style="width: 120px">{{$item->card_code}}</a>

                <a href="{{route('admin#orderDetailPage',$item->id)}}" class="me-3 text-decoration-none" style="width: 120px">{{$item->deli_code}}</a>

                <p class="me-3 " style="width: 120px">{{$item->total_price}} Kyats</p>
                <p class="me-3 " style="width: 120px">{{$item->deli_price}} Kyats</p>
                <p class="me-3 " style="width: 120px">
                    @if ($item->payment == 0)
                    Home
                    @else
                    <a href="{{route('admin#orderDetailPage',$item->id)}}" class="me-3 text-decoration-none" style="width: 120px">Card</a>
                    @endif
                </p>
                @if ($item->status !== 3)
                <div class="me-3 orderlist" style="width: 120px">
                    <select  id="" class="rounded px-2 py-1 orderStatus ">
                        <option value="0" @if ($item->status == 0) selected @endif>Pending</option>
                        <option value="1" @if ($item->status == 1 ) selected @endif>Success</option>
                        <option value="2" @if ($item->status == 2) selected @endif>Reject</option>
                    </select>
                    <input type="hidden" class="orderId" value="{{$item->id}}">
                </div>
                @endif

                @if ($item->status == 1 || $item->status == 3)
                <div class="" style="width: 50px">
                    <a href="{{route('admin#chooseDeli',$item->id)}}"><i class="fa-solid fa-truck"></i></a>
                </div>
                @endif

            </div>

        </div>


    @endforeach
    <div class="row col-10 offset-1">
        {{$orders->links()}}
    </div>
</div>



</section>
@endsection
@section('script')
<script>
    $(document).ready(function(){
// To filter Order Status
        $('#filterStatus').change(function(){
            $status = $(this).val();
            $.ajax({
                url : '/admin/orderFilter/status',
                type : 'get',
                data : {'status' : $status},
                dataType : 'JSON',
                success : function(response){
                   if(response.data == 'all'){
                    location.reload();
                   }else{

                    $order = ``;
                    dataInput(response);
                    // console.log($order);
                    $('#orderContainer').html($order)
                   }
                }
            })
        })
// To filter Payment
        $('#paymentfilter').change(function(){
            $status = $(this).val();
            $.ajax({
                url : '/admin/orderFilter/payment',
                type : 'get',
                data : {'status' : $status},
                dataType : 'JSON',
                success : function(response){
                    console.log(response);
                if(response.data == 'all'){
                    location.reload();
                }else{
                    $order = ``;
                    dataInput(response);
                    console.log($order);
                    $('#orderContainer').html($order)
                   }
                }
            })
        })
// To Change status
        $(document).on('change','.orderStatus',function(){
            $status = $(this).val();
        $parent = $(this).parent('.orderlist')
        $orderId = $parent.find('.orderId').val();

            $.ajax({
                url : '/admin/orderChange/status',
                type : 'get',
                data : {'status' : $status,'orderId': $orderId},
                dataType : 'JSON',
                success : function(response){
                    location.reload();
                }
            })
        })

    })
// To function input
        function dataInput(response){
            for($i=0; $i<response.length; $i++){
                if(response[$i].payment == 0){
                    $payment = `Home`
                   }else{
                    $payment = `<a href="{{url('admin/order/detail/${response[$i].id}')}}" class="me-3 text-decoration-none" style="width: 120px">Card</a>`
                   }

                   if(response[$i].status == 0){
                    $orderselected = ` <select  id="" class="rounded px-2 py-1 orderStatus">
                    <option value="0" selected>Pending</option>
                    <option value="1" >Success</option>
                    <option value="2" >Reject</option>
                </select>`
                   }else if(response[$i].status == 1 ){
                    $orderselected = ` <select  id="" class="rounded px-2 py-1 orderStatus">
                    <option value="0" >Pending</option>
                    <option value="1" selected>Success</option>
                    <option value="2" >Reject</option>
                </select>`
                   }else if(response[$i].status == 2){
                    $orderselected = ` <select  id="" class="rounded px-2 py-1 orderStatus">
                    <option value="0" >Pending</option>
                    <option value="1" >Success</option>
                    <option value="2" selected>Reject</option>
                </select>`
                   }else if(response[$i].status == 3){
                    $orderselected = `Sending`
                   }



                   if(response[$i].status == 1 || response[$i].status == 3){
                    $delivery = `<div class="" style="width: 50px">
                    <a href="{{url('admin/choose/delivery/${response[$i].id}')}}"><i class="fa-solid fa-truck"></i></a>
                </div>`
                    $titledeli = `<h6 class="" style="width: 50px"> Deli</h6>`
                   }else{
                    $delivery = ``
                    $titledeli = ``
                   }
                       $order += `
                       <div class="col-10 offset-1  my-3 p-3 rounded bg-white" >
        <div class="d-flex">
            <h6 class="me-3  "  style="width: 50px" >No</h6>
            <h6 class="me-3  " style="width: 120px">Name</h6>
            <h6 class="me-3 " style="width: 120px">Product Lists</h6>
            <h6 class="me-3 " style="width: 120px">Deli Info</h6>
            <h6 class="me-3 " style="width: 120px"> Prices</h6>
            <h6 class="me-3 " style="width: 120px">Deli Prices</h6>
            <h6 class="me-3 " style="width: 120px">Payment</h6>
            <h6 class="me-3 " style="width: 120px">Status</h6>
            ${$titledeli}
        </div>
        <div class="d-flex mt-3 " >

            <p class="me-3  " style="width: 50px" >${$i + 1}</p>
            <p class="me-3 " style="width: 120px">${response[$i].name}</p>

            <a href="{{url('admin/order/detail/${response[$i].id}')}}" class="me-3 text-decoration-none" style="width: 120px">${response[$i].card_code}</a>

            <a href="{{url('admin/order/detail/${response[$i].id}')}}" class="me-3 text-decoration-none" style="width: 120px">${response[$i].deli_code}</a>

            <p class="me-3 " style="width: 120px">${response[$i].total_price} Kyats</p>
            <p class="me-3 " style="width: 120px">${response[$i].deli_price} Kyats</p>
            <p class="me-3 " style="width: 120px">${$payment}</p>
            <div class="me-3 orderlist" style="width: 120px">
                ${$orderselected}
                <input type="hidden" class="orderId" value="${response[$i].id}">
            </div>
            ${$delivery}

        </div>

    </div>
                       `
                    }
        }
</script>
@endsection
