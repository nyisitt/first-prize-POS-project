@extends('admin.master')
@section('content')
    <h4 class="mt-3 text-white text-center">Post Details</h4>
    <div class="row mt-5">
        <a href="{{route('admin#createPost')}}" class="text-white col-6 offset-3 ps-0">
            <button class="btn btn-dark mb-2" ><i class="fa-solid fa-arrow-left"></i></button>
        </a>
        <div class="col-6 offset-3 bg-white p-3 rounded pt-2">
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <img src="{{asset('images/default male.avif')}}" width="50px" height="50px" class="rounded-circle">
                    <div class="mt-2">
                        <h6 class="mb-0">Admin</h6>
                        <p class="text-muted mb-0">{{$post->created_at->diffForHumans()}}</p>
                    </div>
                </div>
                <a href="{{route('admin#postEdit',$post->id)}}" class="mt-2 text-dark"><i class="fa-solid fa-ellipsis"></i></a>
            </div>

            <p>{!!$post->post_text!!}</p>
            @if($images)
            <div class="row ">
                @if ($images->count() == 1)

                   @foreach ($images as $image)
                   <div class="col-8 offset-2">
                    <img src="{{asset('storage/'.$image->images)}}" width="100%" height="150px" class="rounded">
                    </div>
                   @endforeach


                @else

                    @foreach ($images as $image)
                    <div class=" col-6 mb-3">
                     <img src="{{asset('storage/'.$image->images)}}" width="100%" height="150px" class="rounded">
                    </div>
                    @endforeach


                @endif

            </div>
            @endif
            <hr>
            <div class="row">
                <div class="col-6  d-flex justify-content-center">
                        <i class="fa-regular fa-thumbs-up"></i>
                        <p class="ms-3">{{$post->reaction}}</p>
                </div>
                <div class="col-6  d-flex justify-content-center">
                    <i class="fa-regular fa-thumbs-down"></i>
                    <p class="ms-3">{{$post->unlike}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
