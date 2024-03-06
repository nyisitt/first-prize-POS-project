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
{{-- alert box end --}}

    <div class="row mt-3">
        <div class="col-10 offset-1">
            <a href="{{route('admin#notiQuesShow')}}" class="text-white" ><i class="fa-solid fa-arrow-left"></i></a>
            <table class="table table-primary  text-center  table-hover table-bordered border-dark caption-top">
                <caption style="color:white; font-size:25px">Questions & Answers List</caption>
                <thead class="table-dark">
                  <tr>
                    <th >No</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th >Comment</th>
                    <th>Reply</th>
                    <th >Date</th>
                    <th>Handle</th>

                  </tr>
                </thead>
                <tbody>
                    @foreach ($commentlist as $key=>$list)
                    <tr>
                        <th>{{$key + 1}}</th>
                        <th>{{$list->name}}</th>
                        <th>{{$list->product_name}}</th>
                        <th class="text-start">{{$list->comment}}</th>
                        <th class="text-start">{{$list->reply}}</th>
                        <th>{{$list->created_at->format('M,j,Y')}}</th>
                        <th>
                            @if ($list->status == 1)
                                <a href="{{route('admin#questionlistDelete',$list->id)}}" class="text-dark"><i class="fa-solid fa-trash"></i></a>
                                <a href="{{route('admin#questionlistEdit',$list->id)}}" class="text-dark"><i class="fa-regular fa-pen-to-square"></i></a>
                            @endif
                        </th>

                    </tr>
                    @endforeach

                </tbody>
              </table>
              {{$commentlist->links()}}
        </div>
    </div>
@endsection

