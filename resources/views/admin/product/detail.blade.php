@extends('admin.master')
@section('content')
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

{{-- **************************produt detail start*************--}}
<div class="row mt-5 col-10 offset-1  p-3 rounded" style="background: rgb(172, 130, 173); color:rgb(28, 25, 25)">
    <a href="{{route('product#show')}}" class="text-end text-dark" >
        <i class="fa-solid fa-xmark fa-2x"></i>
    </a>
    <h2 class=" text-center mb-5">Product Details</h2>
    <div class=" col-6 p-3" style="border: 1px solid black" >
        <div class="d-flex mt-2" >
            <h5 class="me-3">Name -</h5>
            <p class="pt-1 text-white">{{$product[0]->name}}</p>
        </div>
        <div class="d-flex mt-2" >
            <h5 class="me-3">Brand -</h5>
            <p class="pt-1 text-white">{{$product[0]->brand}}</p>
        </div>
        <div class="d-flex mt-2" >
            <h5 class="me-3">Main Category -</h5>
            <p class="pt-1 text-white">{{$product[0]->main_category}}</p>
        </div>
        <div class="d-flex mt-2" >
            <h5 class="me-3">Sub Category -</h5>
            <p class="pt-1 text-white">{{$product[0]->subcategory}}</p>
        </div>
        <div class="d-flex mt-2" >
            <h5 class="me-3">Price -</h5>
            <p class="pt-1 text-white">{{number_format($product[0]->price)}} Kyats</p>
        </div>
        <div class="d-flex mt-2" >
            <h5 class="me-3">Discount Price -</h5>
            @if ($product[0]->discount_price)
            <p class="pt-1 text-white">{{$product[0]->discount_price}} Kyats</p>
            @endif
        </div>
        <div class="d-flex mt-2" >
            <h5 class="me-3">Discount Precentage -</h5>
            @if ($product[0]->discount_precentage)
            <p class="pt-1 text-white">{{$product[0]->discount_precentage}} %</p>
            @endif
        </div>
        <div class="d-flex mt-2" >
            <h5 class="me-3">View -</h5>
            <p class="pt-1 text-white">{{$product[0]->views}} </p>
        </div>

        <div class="d-flex mt-2" >
            @if ( count($rating) == 0 )

            <h5 class="me-3">Review & Rating -</h5>
            <p class="pt-1 text-white">( 0 ) </p>

            @else
                @php
            // Encode the array of IDs into a query parameter
                     $ids = implode(',', $rating->pluck('id')->toArray());
                @endphp

            <a href="{{route('product#rating',$ids)}}" class="text-dark text-decoration-none"><h5 class="me-3">Review & Rating -</h5></a>

            <p class="pt-1 text-white">( {{count($rating)}} )</p>
            @endif
        </div>

        <div class=" mt-2" >
            <h5 class="me-3 ">Description</h5>
            <p class="pt-1 text-white" style="line-height: 20px;  text-indent: 50px;" >{!!$product[0]->description !!}</p>
        </div>


    </div>
    <div class=" col-6 " style="border: 1px solid black" >
        <h4 class="text-center p-3">Images</h4>
       <div class=" row d-flex ">

        @foreach ($product as $p)
        @if ($p->images != null)
        <div class="col-4" >
            <img src="{{asset('storage/'.$p->images)}}" class="w-100 rounded mb-3" style="height: 150px;">
        </div>
        @else
        <h6>There is no image</h6>
        @endif

        @endforeach


       </div>
    </div>
    {{-- **************************produt detail *************--}}
    {{-- **************************Edit product **************--}}

    <div class="p-3 text-center mt-2">
        <button class="btn btn-dark w-25" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">Edit</button>

        <div class="offcanvas offcanvas-top  h-100" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel" style="background:pink">
          <div class="offcanvas-header ">
            <button type="button" class="btn-close text-reset " data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <div class="row col-8 offset-2  rounded p-2" style="border:1px solid black" >
                <form action="{{route('product#update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex">
                        <div class="col-6">
                            <div class="text-start mb-3 ">
                                <input type="hidden" name="id" value="{{$product[0]->id}}">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control " value="{{old('name',$product[0]->name)}}" placeholder="Enter Name" >
                                @error('name')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                               </div>



                               <div class="text-start mb-3">
                                <label for="">Price</label>
                                <input type="text" name="price" class="form-control "  value="{{old('price',$product[0]->price)}}" placeholder="Enter Price" >
                                @error('price')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                               </div>

                               <div class="text-start mb-3">
                                <label for="">Images</label>
                                <input type="file" name="images[]" class="form-control  "  multiple >
                                @error('images.*')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                                @error('images')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                               </div>


                        </div>
                        <div class="col-6">
                            <div class="text-start mb-3 ">
                                <label for="">Brand</label>
                                <input type="text" name="brand" class="form-control " value="{{old('brand',$product[0]->brand)}}" placeholder="Enter Brand" >
                                @error('brand')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                               </div>

                            <div class="text-start mb-3 ">
                             <label for="">Categories</label>
                             <select name="category"  class="form-control   @error('category') is-invalid @enderror"  >
                                <option value="">Choose Categories</option>
                                @foreach ($category as $key=>$value)
                                <optgroup label="{{ $key }}">
                                    @foreach ($value as $sub)
                                        <option value="{{ $sub->id }}" @if ($sub->id == $product[0]->category) selected @endif>{{ $sub->subcategory}}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                            @error('category')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>



                               <div class="text-start mb-3 ">
                                <label for="">Description</label>
                                <textarea name="description" id="editor"  class="ckeditor form-control"  placeholder="Enter description"  rows="5" id="editor">{{old('description',$product[0]->description)}}</textarea>
                                @error('description')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                               </div>
                         </div>
                    </div>

                       <div class="mb-3 ">
                        <button class="btn btn-dark w-25" type="submit">Update</button>
                       </div>
                     <div class="d-flex row">



                       @foreach ($product as $p)

                        @if ($p->images != null)
                        <div class="col-2">
                            <img src="{{asset('storage/'.$p->images)}}" style="width:100%; height:150px" class="rounded mb-2">
                        <a href="{{route('product#imgDelete',$p->images)}}"><button class="btn btn-danger w-100" type="button" onclick="return confirm('do you sure delete')">Remove</button></a>
                            </div>

                        @endif

                       @endforeach



                       </div>

                </form>
            </div>
          </div>
        </div>
    </div>
</div>
{{-- **************************produt detail end*************--}}

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
