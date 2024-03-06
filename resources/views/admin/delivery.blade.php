@extends('admin.master')
@section('content')
    <div class="text-white mt-3 text-center">
        <h3>Choose Deliverys</h3>
    </div>
{{-- Choose delivery start--}}
    <div class="row mt-5 container px-5">
        <a class="mb-3 text-white" href="{{route('admin#orderPage')}}"><button class="btn btn-dark"><i class="fa-solid fa-arrow-left"></i></button></a>
        <input type="hidden" id="orderId" value="{{$order->id}}">

         @foreach ($delivery as $item)
        <div class="col-4 delicontainer">
            <input type="hidden" id="deliId" value="{{$item->id}}">
            <div class="card ">
                <div class="card-title">
                    @if ($item->image == null)

                        @if ($item->gender == 'male')
                       <div class="text-center">
                        <img src="{{asset('images/default male.avif')}}" width="75%" height="250px"  class="p-3 rounded">
                       </div>
                        @else
                        <div class="text-center">
                            <img src="{{asset('images/girl photo.jpg')}}" width="75%" height="250px" class="p-3 rounded">
                        </div>
                        @endif
                    @else
                    <div class="text-center">
                        <img src="{{asset('storage/'.$item->image)}}" width="75%" height="250px" class="p-3 rounded-circle" >
                    </div>
                    @endif

                </div>
                <div class="card-body text-center">
                  <h4 class="">{{$item->name}}</h4>
                  <h6>( {{$item->email}} )</h6>
                  <div class="mt-3 ">
                    <input type="text" class="form-control datepicker" placeholder="Expired data" style="background: wheat" >
                    <small class="text-danger d-none" id="error">Expired date is required!</small>
                  </div>
                  @if ($order->status == 3)
                  <button class=" btn btn-dark text-white mt-3 "  disabled>Send Delivery</button>
                  @else
                  <button class=" btn btn-dark text-white mt-3 send"  >Send Delivery</button>
                  @endif

                </div>
            </div>
        </div>
        @endforeach
{{-- Choose delivery end--}}


{{-- Delivery list start --}}
        <div class="" style="margin-top: 100px">
          <div class="row ">
            <h5 class="text-white col-4">
                Total - {{$deliInfo->total()}}
            </h5>
            <div class="offset-4 col-4">
                <form action="{{route('admin#chooseDeli',$order->id)}}" class="d-flex " method="GET">
                    @csrf
                    <input type="text" name="key" placeholder="Search order code ..." class="form-control w-100" value="{{request('key')}}">
                    <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
          </div>
          @if (count($deliInfo) !== 0)
            <table class="table table-primary  text-center table-striped table-hover table-bordered border-dark caption-top">
                <caption style="color:white; font-size:25px">Delivery send lists</caption>
                <thead class="table-dark">
                  <tr>
                    <th >No</th>
                    <th >Name </th>
                    <th>order Code</th>
                    <th >Expired Date</th>
                    <th >Sent Date</th>
                    <th>Status</th>
                  </tr>
                </thead>

                <tbody>
                    @foreach ($deliInfo as $key=>$item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->card_code}}</td>
                            <td>{{$item->expired_date}}</td>
                            <td>{{$item->created_at->format('m/j/Y')}}</td>
                            <td>
                                @if ($item->status == 0)
                                    Sending...
                                @else
                                    Arrived
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="">
                {{$deliInfo->links()}}
            </div>
                @else
                        <h4 class="text-center text-white ">There is no deli sent orders</h4>

                @endif

        </div>
{{-- Delivery list end --}}

    </div>
@endsection
@section('script')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function(){
        $('.datepicker').datepicker();
    })

    $('.send').click(function(){
       $parent = $(this).closest('.delicontainer')
        $deliId = $parent.find('#deliId').val();
        $orderId = $('#orderId').val();
        $date = $parent.find('.datepicker').val();
        if($date == ''){
            $parent.find('#error').removeClass('d-none')

        }else{
             $.ajax({
            url : '/admin/deli/send',
            type : 'get',
            data : {'orderId': $orderId,'deliId': $deliId,'date': $date},
            dataType : "JSON",
            success : function(response){
                location.reload();
            }
        })
        }


    })

</script>
@endsection

