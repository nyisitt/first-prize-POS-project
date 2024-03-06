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
<a href="{{route('category#show')}}"><button class="btn btn-primary rounded mt-5" style="margin-left: 50px">List Page</button></a>

<div class="row mt-1">
{{----------------  Category -----------------}}
<div class="col-6  text-center">
        <div class="ms-5 p-3 rounded"  style="background: grey; width:500px">
           <h3> Category Create</h3>
           <form action="{{route('category#post')}}" method="POST">
            @csrf
            <div class="my-3 text-start" style="width: 300px">
                <h5 class="mb-2">Category</h5>
                <input type="text" name="category" id="cat" placeholder="Enter Category..." class="form-control" >
                @error('category')
                <small class="danger">{{$message}}</small>
                @enderror
               </div>

               <div class="text-start mt-2">
                <button class="btn btn-dark rounded" type="submit">Save</button>
                <button class="btn  rounded" style="background: white" id="cancel" type="button">Cancel</button>
               </div>
           </form>
        </div>
</div>

{{---------------- Sub Category -----------------}}
<div class="col-6  text-center">

        <div class="ms-5 p-3 rounded"  style="background: grey; width:500px">
            <h3>Sub Category Create</h3>
            <form action="{{route('subcategory#post')}}" method="POST">
                @csrf
                <div class="my-3 text-start" style="width: 300px">
                    <h5 class="mb-2">Category</h5>
                    <select name="categories" id="category" class="form-control">
                        <option value="">Choose Category</option>
                        @foreach ($category as $c)
                        <option value="{{$c->category}}">{{$c->category}}</option>
                        @endforeach
                    </select>
                    @error('categories')
                    <small class="danger">{{$message}}</small>
                    @enderror
                   </div>

                   <div class="my-3 text-start" style="width: 300px">
                    <h5 class="mb-2">Sub Category</h5>
                    <input type="text" name="subcategory" id="subcat" placeholder="Enter Sub Category..." class="form-control">
                    @error('subcategory')
                    <small class="danger">{{$message}}</small>
                    @enderror
                   </div>

                   <div class="text-start mt-2">
                    <button class="btn btn-dark rounded" type="submit">Save</button>
                    <button class="btn  rounded" style="background: white" id="sub" type="button">Cancel</button>
                   </div>
            </form>
         </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#cancel').click(function(){
            $('#cat').val('');
        })
        $('#sub').click(function(){
            $('#subcat').val('');
            $('#category').val('')
        })
})
</script>
@endsection
