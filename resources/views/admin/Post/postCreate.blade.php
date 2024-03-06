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

{{-- post create start --}}
    <div class="text-center mt-3 ">
        <h4 class="text-white">Posts</h4>
        <div class=" row mt-5 text-start">
            <div class="col-10 offset-1 ">
                <details>
                    <summary class="text-white">Create your posts</summary>
                   <div class="row col-6 offset-3 mt-5">
                    <form action="{{route('admin#createPost')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-end p-0">
                            <button class="btn bg-white text-dark mb-3" type="submit">Post</button>
                        </div>

                        <textarea name="text" id="editor"  class="  @error('text') is-invalid  @enderror" placeholder="What is your mind" rows="10" >{{old('text')}}</textarea>
                        @error('text')
                        <small class="text-warning">{{$message}}</small>
                        @enderror


                        <input type="file" class="form-control mt-3" name="images[]" multiple >

                    </form>



                   </div>
                  </details>

                  <div class="mt-5">
                    <table class="table table-primary  text-center table-striped table-hover table-bordered border-dark caption-top">
                        <caption style="color:white; font-size:25px">Post lists Table</caption>
                        <thead class="table-dark">
                          <tr>
                            <th >No</th>
                            <th >Text</th>
                            <th>like</th>
                            <th>unlike</th>
                            <th>Date</th>
                            <th>Handle</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($post as $key=>$item)
                            <tr>
                                <th>{{$key + 1}}</th>
                                <th class="">{!!Illuminate\Support\Str::limit($item->post_text,'70')!!}</th>
                                <th>{{$item->reaction}}</th>
                                <th>{{$item->unlike}}</th>
                                <th>{{$item->created_at->format('m,j,Y')}}</th>
                                <th>
                                    <a href="{{route('admin#detailPost',$item->id)}}" title="detail" class="text-dark"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{route('admin#deletePost',$item->id)}}" title="delete" class="text-dark"><i class="fa-solid fa-trash"></i></a>

                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                  </div>
            </div>
        </div>
    </div>
{{-- post create start --}}
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
