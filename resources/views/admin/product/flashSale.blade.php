@extends('admin.master')
@section('content')
    <h4 class="mt-3 text-white text-center">Promotion Sale </h4>
    <div class="row mt-5">
        <div class="col-8 offset-2">
            @if($date !== null)
            <span class="text-white">Expried date counter</span>
            <div class="text-white" id="date">{{$date->expired_date}}</div>
            @endif
            <div class="col-5 offset-7">
                <form action="{{route('flashSaleSave')}}" method="POST">
                @csrf
                <div class="d-flex">

                    <input type="text" name="date" id="sale_date" placeholder="YYYY/MM/DD H:M:S" class="form-control">

                    <button class="btn btn-dark ms-3" style="submit" @if ($date !== null)
                    disabled   @endif>Save</button>
                </div>
                @error('date')
                    <small class="text-warning">{{$message}}</small>
                @enderror
                @error('ids')
                    <small class="text-warning">{{$message}}</small>
                @enderror
            </div>
            @if ($disproduct->count() > 0)
            <table class="table table-primary  text-center table-striped table-hover table-bordered border-dark caption-top">
                <caption style="color:white; font-size:25px">Promotion Table</caption>
                <thead class="table-dark">
                  <tr>
                    <th >No</th>
                    <th>Category</th>
                    <th >Name</th>
                    <th>Price</th>
                    <th>Discount_price</th>

                    <th >Handle</th>
                  </tr>
                </thead>
                <tbody>

                    @foreach ($disproduct as $key=>$p)
                    <tr>
                        <th>{{$key + 1}}</th>
                        <th>{{$p->subcategory}}</th>
                        <th>{{$p->name}}</th>
                        <th>{{number_format($p->price)}}kyats</th>
                        <th>{{number_format($p->discount_price)}}kyats</th>
                        @if ($p->expired_date)
                        <th>
                            <input type="checkbox" name="ids[{{$p->id}}]" value="{{$p->id}}" checked>
                            </th>
                        @else
                        <th>
                            <input type="checkbox" name="ids[{{$p->id}}]" value="{{$p->id}}">
                            </th>
                        @endif


                    </tr>
                    @endforeach
                    @else
                        <h5 class="bg-danger mt-5 text-center p-3 text-white rounded">There is no product with discount price</h5>
                    @endif
                </tbody>
              </table>
        </form>

        </div>
    </div>
@endsection
@section('script')
<script>
    $(function(){
        $('#sale_date').datetimepicker();

    })
   $date = $('#date').html();
    var expired_date = new Date($date).getTime();
    // console.log(expired_date);
    if(expired_date !== NaN){
        var countdown = setInterval(function(){
            var now = new Date().getTime();
            var distance = expired_date - now ;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

           $('#date').html(`${days} day ${hours} hours ${minutes} min ${seconds} sec`)

            if (distance < 0) {
            clearInterval(countdown);
            $('#date').html('00 : 00 : 00')
            $.ajax({
                    url : '/admin/flash/sale/delete',
                    type : 'get',
                    dataType : "JSON",
                    success : function(response){
                        location.reload();
                    }
                })
            }

        },1000);
    }


</script>

@endsection
