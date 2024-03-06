@extends('admin.master')
@section('content')
{{-- alert box start --}}
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
{{-- alert box start --}}

{{-- Sub Category --}}
<div class="row">
    <div class="col-10 offset-1  mt-5">
        {{-- search --}}
        <form action="{{route('product#show')}}" class="d-flex " method="GET">
            @csrf
            <input type="text" name="key" placeholder="Search ...." class="form-control w-25" value="{{request('key')}}">
            <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        {{-- search --}}
        @if (count($products) != 0)
        <form action="{{route('product#discount')}}" method="POST">
            @csrf
            {{-- discount section --}}
            <details class=" my-4 p-3 rounded" style="border: 1px solid white">
                <summary class="text-white" style=" font-size:20px">Discount section</summary>
                <div class="d-flex mt-3">
                    <div class=" text-white me-3 ">
                        <p>categories</p>
                        <select name="category" class="form-control" style="width:200px">
                            <option value="">Choose Categories</option>
                            @foreach ($category as $key=>$value)
                            <optgroup label="{{ $key }}">
                                @foreach ($value as $sub)
                                    <option value="{{ $sub->id }}">{{ $sub->subcategory}}</option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>

                    </div>
                    <div class=" text-white me-3 ">
                        <p>presentage amount</p>
                        <input type="text" class="form-control" style="width:200px" name="percentage">
                        @error('percentage')
                        <small>{{$message}}</small>
                        @enderror
                    </div>
                    <div style="margin-top: 30px">
                  <button class="btn btn-primary " style="submit">Discount Selected OR Category</button>
                    </div>
                </div>
            </details>


            {{-- table start --}}
           <h4 class="text-white">Total -  {{$products->total()}}</h4>
            <table class="table table-primary  text-center table-striped table-hover table-bordered border-dark caption-top">
                <caption style="color:white; font-size:25px">Products Table</caption>
                <thead class="table-dark">
                  <tr>
                    <th >No</th>
                    <th>Category</th>
                    <th >Name</th>
                    <th>Price</th>
                    <th>Discount_price</th>
                    <th >Date</th>
                    <th >Handle</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key=>$p)
                    <tr>
                        <th>{{$key + 1}}</th>
                        <th>{{$p->subcategory}}</th>
                        <th>{{$p->name}}</th>
                        <th>{{number_format($p->price)}}kyats</th>
                        @if($p->discount_price)
                        <th>{{number_format($p->discount_price)}}kyats</th>
                        @else
                        <th></th>
                        @endif
                        <th>{{$p->created_at->format('M-j-Y')}}</th>
                        <th>
                            <a href="{{route('product#detail',$p->id)}}" title="see-more" class="me-2"><i class="fa-solid fa-ellipsis text-dark"></i></a>
                            <a href="{{route('product#delete',$p->id)}}" title="trash" class="me-2" onclick="return confirm('Do you sure delete')"><i class="fa-solid fa-trash text-dark"></i></a>
                            <input type="checkbox" name="ids[{{$p->id}}]" value="{{$p->id}}">
                        </th>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </form>
            {{$products->links()}}
        @else
        <div class="text-center text-white fa-2x bg-danger p-2 rounded mt-5">There is No products</div>
        @endif


    </div>
</div>
@endsection
