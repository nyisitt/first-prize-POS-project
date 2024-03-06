@extends('delivery.home')
@section('text')
    <div class="">hello</div>
        <div class="delivery  container  mb-5   p-5" >
    <div class="text-center " style="height: 200px">
        <img src="{{asset('images/logistics-flatline.svg')}}" alt="" height="100%">

       </div>
       <div class="mt-5">
        <div class="row mb-3">
            <h5 class="text-dark col-4 d-flex align-items-center ">
                <div class="total ">Total - {{$orderlist->total()}}</div>
            </h5>
            <div class="offset-5 col-3">
                <select name="" id="filter" class="ms-3 form-control w-100 " style="background: wheat">
                    <option value="all">Choose State</option>
                   <option value="0">To Send</option>
                   <option value="1">Arrived</option>
               </select>
            </div>
          </div>

        <table class="table table-primary  text-center table-striped table-hover table-bordered border-dark caption-top rounded">
            <thead class="table-dark">
                <tr>
                    <th >No</th>
                    <th >deli Info </th>
                    <th>order Code</th>
                    <th >Total Price</th>
                    <th>Deli Price</th>
                    <th >Expired Date</th>
                    <th>Payment</th>
                    <th>Status</th>
                  </tr>
            </thead>
            <tbody id="container">
                @foreach ($orderlist as $key=>$item)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>
                       <a href="{{route('deli#detailPage',$item->order_id)}}"> {{$item->deli_code}}</a>
                    </td>
                    <td>
                        <a href="{{route('deli#detailPage',$item->order_id)}}">{{$item->card_code}}</a>
                    </td>
                    <td>{{number_format($item->total_price)}} Kyats</td>
                    <td>{{number_format($item->deli_price)}} Kyats</td>
                    <td>{{$item->expired_date}}</td>
                    <td>
                        @if ($item->payment == 0)
                            <p>Home Pay</p>
                        @else
                            <p>Paid</p>
                        @endif
                    </td>
                    <td>
                        <select name="" id="" class="form-control deliState">
                            <option value="0" @if ($item->status == 0) selected @endif>To Send</option>
                            <option value="1" @if ($item->status == 1) selected @endif>Arrived</option>
                        </select>
                        <input type="hidden"  class="orderId" value="{{$item->id}}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="">
            {{$orderlist->links()}}
        </div>
       </div>
        </div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $(document).on('change','.deliState',function(){
            $state = $(this).val();
            $parent = $(this).closest('td')
            $orderId = $parent.find('.orderId').val();
            // console.log($orderId);
            $.ajax({
                url : '/deli/status/change',
                type : 'get',
                data : {'state': $state , 'orderId':$orderId},
                dataType : "JSON",
                success : function(response){
                    location.reload();
                }
            })
        })
        $('#filter').change(function(){
            $state = $(this).val();
            $.ajax({
                url : '/deli/status/filter',
                type : 'get',
                data : {'state': $state },
                dataType : "JSON",
                success : function(response){
                    console.log(response);
                    $('.total').html(`Total - ${response.length}`)
                    $lists = ``
                    for($i=0; $i<response.length; $i++){
                        if(response[$i].payment == 0){
                            $payment = `<p>Home Pay</p>`
                        }else{
                            $payment = `<p>Paid</p>`
                        }
                        if(response[$i].status == 0){
                            $select = `<select name="" id="" class="form-control deliState">
                            <option value="0" selected>To Send</option>
                            <option value="1" >Arrived</option>
                            </select>`
                        }else{
                            $select = `<select name="" id="" class="form-control deliState">
                            <option value="0" >To Send</option>
                            <option value="1" selected>Arrived</option>
                            </select>`
                        }
                        $lists += `
                        <tr>
                    <td>${$i + 1}</td>
                    <td>
                       <a href="{{url('deli/detail/${response[$i].order_id}')}}">${response[$i].deli_code}</a>
                    </td>
                    <td>
                        <a href="{{url('deli/detail/${response[$i].order_id}')}}">${response[$i].card_code}</a>
                    </td>
                    <td>${response[$i].total_price} Kyats</td>
                    <td>${response[$i].deli_price} Kyats</td>
                    <td>${response[$i].expired_date}</td>
                    <td>${$payment}         </td>
                    <td>
                        ${$select}
                        <input type="hidden"  class="orderId" value="${response[$i].id}">
                    </td>
                </tr>
                        `
                    }
                    console.log($lists);
                    $('#container').html($lists);
                }
            })
        })
    })
</script>
@endsection
