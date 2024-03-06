@extends('admin.master')
@section('content')
{{-- alert box start --}}
@if (session('message'))
<div class="position-fixed button-20 end-0 p-3" style="z-index: 11">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <img src="{{asset('images/2090259-removebg-preview.png')}}" class="" width="50px">
        <strong class="me-auto">NS Shop Website</strong>
        <small>Just Now</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body ">
       <h6>{{session('message')}} &#127881; &#127881;</h6>
      </div>
    </div>
  </div>
@endif
{{-- alert box end --}}

{{-- post edit start --}}
<h3 class="text-white mt-3 text-center">Post Edit</h3>
    <div class="row mt-5">
        <div class="col-6 offset-3 ">
            <a href="{{route('admin#detailPost',$post->id)}}" class="text-white  ps-0">
                <button class="btn btn-dark mb-2" ><i class="fa-solid fa-arrow-left"></i></button>
            </a>
            <form action="{{route('admin#updatePost')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$post->id}}">
                <textarea name="text" id="editor"  class="form-control">{{$post->post_text}}</textarea>
                @error('text')
                <small class="text-warning">{{$message}}</small>
                @enderror

                <input type="file" name="images[]" id="" class="form-control mt-3" multiple>

                <div class="text-end mt-3 ">
                    <button class="btn btn-dark" type="submit">Update</button>
                </div>

            </form>


            @if ($images->count() !== 0)
            <div class="row mt-3">
                @foreach ($images as $item)
                <div class="col-4">
                    <img src="{{asset('storage/'.$item->images)}}" width="100%" height="150px" class="rounded">
                    <a href="{{route('admin#postImageDelete',$item->images)}}"><button class="btn btn-danger w-100 mt-2">Remove</button></a>
                </div>
                @endforeach
            </div>

            @endif
        </div>
    </div>
{{-- post edit end --}}
@endsection
@section('script')
<script>
    ClassicEditor
		.create( document.querySelector( '#editor' ) )
		.catch( error => {
			console.error( error );
		} );
</script>
@endsection
