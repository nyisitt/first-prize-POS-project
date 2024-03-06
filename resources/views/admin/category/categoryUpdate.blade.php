@extends('admin.master')
@section('content')
<div class="row mt-3 offset-3">
    <div class="col-6  text-center">
        <div class="ms-5 p-3 rounded"  style="background: grey; width:500px">
           <h3> Category Update</h3>
           <form action="{{route('category#update')}}" method="POST">
            @csrf
            <div class="my-3 text-start" style="width: 300px">
                <h5 class="mb-2">Category</h5>
                <input type="hidden" name="id" value="{{$data->id}}">
                <input type="text" name="category" id="cat" placeholder="Enter Category..." class="form-control"  value="{{old('category',$data->category)}}">
                @error('category')
                <small class="danger">{{$message}}</small>
                @enderror
               </div>

               <div class="text-start mt-2">
                <button class="btn btn-dark rounded" type="submit">Update</button>
              <a onclick="history.back()">  <button class="btn  rounded" style="background: white" id="cancel" type="button" >Cancel</button></a>
               </div>
           </form>
        </div>
    </div>
</div>

@endsection
