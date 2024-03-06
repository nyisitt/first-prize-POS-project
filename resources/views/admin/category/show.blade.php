@extends('admin.master')
@section('content')
@if(session('message'))
<div class="position-fixed top-20 end-0 p-3" style="z-index: 11">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <img src="{{asset('images/2090259-removebg-preview.png')}}" class="" width="50px">
        <strong class="me-auto">NS Shop Website</strong>
        <small>Just Now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body ">
       {{session('message')}}  &#127881; &#127881;
      </div>
    </div>
  </div>
@endif

{{---------------------- Sub Category show -------------------------}}
<div class="row">
    <div class="col-8 offset-2  mt-5">
        {{-- search --}}
        <form action="{{route('category#show')}}" class="d-flex " method="GET">
            @csrf
            <input type="text" name="key" placeholder="Search ...." class="form-control w-25" value="{{request('key')}}">
            <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        {{-- search --}}
        @if (count($subcategory) != 0)
        <form action="{{route('subcategory#delete')}}" method="POST">
            @csrf
            <button class="btn btn-primary float-end" style="submit" onclick="return confirm('Do you sure delete')">Delete All Selected</button>
            <h5 class="text-white mt-3">Total - {{$subcategory->total()}}</h5>
            <table class="table table-primary  text-center table-striped table-hover table-bordered border-dark caption-top">
                <caption style="color:white; font-size:25px">Sub Category Show Table</caption>
                <thead class="table-dark">
                  <tr>
                    <th >No</th>
                    <th >Category </th>
                    <th>Sub Category</th>
                    <th >Date</th>
                    <th >Handle</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($subcategory as $key=>$c)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$c->category}}</td>
                        <td>{{$c->subcategory}}</td>
                        <td>{{$c->created_at->format('M-j-Y')}}</td>
                        <td>
                            <a href="{{route('subcategory#edit',$c->id)}}" class="text-dark me-2" title="edit"><i class="fa-solid fa-pen"></i></a>
                            <input type="checkbox" name="ids[{{$c->id}}]" value="{{$c->id}}">
                        </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </form>
            <small>{{$subcategory->links()}}</small>
        @else
        <div class="text-center text-white fa-2x bg-danger p-2 rounded mt-5">There is No Subcategory</div>
        @endif
    </div>
</div>

{{--------------------- Category show ------------------------}}
<div class="row">
    <div class="col-8 offset-2  mt-5">
        @if (count($category) != 0)
        <table class="table table-primary mt-3 text-center table-striped table-hover table-bordered border-dark caption-top ">
            <caption style="color:white; font-size:25px">Category Show Table</caption>
            <thead class="table-dark">
              <tr>
                <th >No</th>
                <th >Name</th>
                <th >Date</th>
                <th >Handle</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($category as $key=>$c)
                <tr>
                    <th>{{$key + 1}}</th>
                    <th>{{$c->category}}</th>
                    <th>{{$c->created_at->format('M-j-Y')}}</th>
                    <th>
                        <a href="{{route('category#edit',$c->id)}}" class="text-dark me-2" title="edit"><i class="fa-solid fa-pen"></i></a>
                        <a href="{{route('category#delete',$c->id)}}" class="text-dark" title="delete" onclick="return confirm('Do you sure delete')"><i class="fa-solid fa-trash"></i></a>

                    </th>
                </tr>
              @endforeach

            </tbody>
          </table>
        @else
        <div class="text-center text-white fa-2x bg-danger p-2 rounded">There is No Category</div>
          @endif

    </div>
</div>

@endsection

