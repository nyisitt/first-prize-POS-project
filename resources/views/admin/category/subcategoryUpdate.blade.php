@extends('admin.master')
@section('content')
<div class="row mt-3 offset-3">
    <div class="col-6  text-center">

        <div class="ms-5 p-3 rounded"  style="background: grey; width:500px">
            <h3>Sub Category Update</h3>
            <form action="{{route('subcategory#update')}}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$data->id}}">
                <div class="my-3 text-start" style="width: 300px">
                    <h5 class="mb-2">Category</h5>
                    <select name="categories" id="category" class="form-control">
                        <option value="">Choose Category</option>
                        @foreach ($category as $c)
                        <option value="{{$c->category}}" @if ($c->category == $data->category) selected  @endif>{{$c->category}}</option>
                        @endforeach
                    </select>
                    @error('categories')
                    <small class="danger">{{$message}}</small>
                    @enderror
                   </div>

                   <div class="my-3 text-start" style="width: 300px">
                    <h5 class="mb-2">Sub Category</h5>
                    <input type="text" name="subcategory" id="subcat" placeholder="Enter Sub Category..." class="form-control" value="{{old('subcategory',$data->subcategory)}}">
                    @error('subcategory')
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
