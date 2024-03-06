@extends('admin.master')
@section('content')
    <div class="row text-white col-10 offset-1 mt-5">
        <h3 class="text-center mb-5">Delivery lists</h3>
        <div class="d-flex justify-content-between">
            <h5 class="mb-3 ps-0">Total Deliverys - {{$deli->count()}}</h5>
            <div class="mb-3 ">
                <form action="{{route('admin#delilistPage')}}" class=" d-flex"  method="GET">
                    @csrf
                <input type="text" placeholder="Search for name" class="form-control" name="key" value="{{request('key')}}">
                <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
        <div class="row text-center bg-white text-dark p-3 rounded mb-2">
            <div class="col-1">NO</div>
            <div class="col-2">Image</div>
            <div class="col-2">Name</div>
            <div class="col-2">Email</div>
            <div class="col-2">Phone</div>
            <div class="col-1">Gender</div>
            <div class="col-2">Role</div>
        </div>
        @if (count($deli) !== 0)
        @foreach ($deli as $key=>$item)
        <div class="row text-center bg-white text-dark p-3 rounded mb-2 align-items-center" >
            <div class="col-1">{{$key + 1}}</div>
            <div class="col-2" style="height: 100px">
                @if ($item->image == null)
                @if ($item->gender == 'male')
                <img src="{{asset('images/default male.avif')}}" height="100%" class="rounded ">
                @else
                <img src="{{asset('images/girl photo.jpg')}}" height="100%" class="rounded ">
                @endif
                @else
                <img src="{{asset('storage/'.$item->image)}}" height="100%" class="rounded ">
                @endif

            </div>
            <div class="col-2">{{$item->name}}</div>
            <div class="col-2 ">{{$item->email}}</div>
            <div class="col-2 text-end">{{$item->phone}}</div>
            <div class="col-1">{{$item->gender}}</div>
            <div class="col-2 userContainer">
                <select name=""  class="rounded py-1 changeUser">
                    <option value="user" @if ($item->role == 'user') selected  @endif>User</option>
                    <option value="deli" @if ($item->role == 'deli') selected  @endif>Delivery</option>
                    <option value="admin" @if ($item->role == 'admin') selected  @endif>Admin</option>
                </select>
                <input type="hidden" name="" id="userId" value="{{$item->id}}">
            </div>
        </div>
        @endforeach

        @else
            <div class="mt-5 text-center">
                <h3 class="bg-danger p-3 d-inline rounded ">There is no user</h3>
            </div>
        @endif

    </div>
@endsection
@section('script')
 <script>
    $(document).ready(function(){
        $('.changeUser').change(function(){
            $status = $(this).val();
            $parent = $(this).parent('.userContainer')
            $id = $parent.find('#userId').val();
            // console.log($id);
            $.ajax({
                url : '/admin/change/userlist',
                type : 'get',
                data : {'status':$status,'id': $id},
                dataType : 'JSON',
                success : function(response){

                }
            })
        })
    })
 </script>
@endsection
