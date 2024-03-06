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

{{-- Product create start --}}
<div class="row col-6 offset-3 mt-5 ">
    <a href="{{route('product#show')}}" class="text-end p-2">
        <button class="btn btn-primary ">Product Lists</button>
    </a>
    <div class="p-3  rounded " style="background: grey">
           <h2 class="text-center">Product Create</h2>
           <form action="{{route('product#createPost')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="m-auto my-2" style="width: 350px;">
                <input type="hidden" name="random" value="{{rand()}}">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name" value="{{old('name')}}">
                @error('name')
                <small class="text-danger">{{$message}}</small>
                @enderror
               </div>

               <div class="m-auto my-2" style="width: 350px;">
                <label for="">Brand</label>
                <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" placeholder="Enter Brand" value="{{old('brand')}}">
                @error('brand')
                <small class="text-danger">{{$message}}</small>
                @enderror
               </div>

               <div class="m-auto my-2" style="width: 350px;">
                <label for="">Category</label>
                <select name="category"  class="form-control @error('category') is-invalid  @enderror" >
                    <option value="">Choose Categories</option>
                    @foreach ($category as $key=>$value)
                    <optgroup label="{{ $key }}">
                        @foreach ($value as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->subcategory}}</option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
                @error('category')
                <small class="text-danger">{{$message}}</small>
                @enderror
               </div>

               <div class="m-auto my-2" style="width: 350px;">
                <label for="">Price</label>
                <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Enter Price" value="{{old('price')}}">
                @error('price')
                <small class="text-danger">{{$message}}</small>
                @enderror
               </div>



               <div class="m-auto my-2" style="width: 350px;" >
                <label for="">Description</label>
                <textarea name="description" id="editor"  class="form-control rounded @error('description') is-invalid  @enderror" placeholder="Enter Description" rows="10">{{old('description')}}</textarea>
                @error('description')
                <small class="text-danger">{{$message}}</small>
                @enderror
               </div>


               <div class="m-auto my-2" style="width: 350px;">
                <label for="">Product Image</label>
                <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror" multiple>
                @error('images')
                <small class="text-danger">{{$message}}</small>
                @enderror
                @error('images.*')
                <small class="text-danger">{{$message}}</small>
                @enderror
               </div>

               <div class="text-center mt-3 ">
                <input type="submit" value="Save" class="btn btn-dark w-25">
               </div>

           </form>

    </div>

</div>
{{-- Product create end --}}
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
