@extends('master')
@section('contant')


<!------------------------------------- Open Content --------------------------------->
    <section class="">
        <div class="">hello</div>
        <div class="container pb-5  singleContant bg-light px-3">
            {{---------- alert box ---------}}
            @if (session('message'))
            <div class="position-fixed top-20 end-0 p-3" style="z-index: 11">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                  <div class="toast-header">
                    <img src="{{asset('images/2090259-removebg-preview.png')}}" class="" width="50px">
                    <strong class="me-auto">NS Shop Website</strong>
                    <small>Just Now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                  <div class="toast-body ">
                   {{session('message')}}
                  </div>
                </div>
              </div>
            @endif
            {{----------- alert box end -----------}}
            <a href="{{route('productList',$product[0]->subcategory)}}" ><i class="fa-solid fa-arrow-left"></i></a>
            <div class="row  ">
{{-- product Image Slide --}}
                <div class="col-5 mt-3">
                    <div class="card mb-3" style="height: 400px">
                        <img class="card-img img-fluid" src="{{asset('storage/'.$product[0]->first_image)}}" alt="Card image cap" id="product-detail" style="height: 100%">
                    </div>
                    <div class="row">
                        <!--Start Controls-->
                        <div class="col-1 align-self-center">
                            <a href="#multi-item-example" role="button" data-bs-slide="prev">
                                <i class="text-dark fas fa-chevron-left"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                        </div>
                        <!--End Controls-->
                        <!--Start Carousel Wrapper-->
                        <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item" data-bs-ride="carousel">
                            <!-- Start Slides -->
                            <div class="carousel-inner product-links-wap" role="listbox">
                                @php $itemCount = count($product); @endphp
                                @for ($i = 0; $i < $itemCount; $i+=4)
                                <div class="carousel-item{{ $i === 0 ? ' active' : '' }}">
                                    <div class="row d-flex">
                                        @for ($j = $i; $j < $i + 4 && $j < $itemCount; $j++)
                                        <div class="col-3" style="height: 100px;">
                                            <a href="#">
                                                <img class="card-img img-fluid zoom-gallery" src="{{ asset('storage/' . $product[$j]->images) }}" style="height: 100%; width: auto;">
                                            </a>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                                @endfor
                            </div>
                            <!-- End Slides -->
                        </div>
                        <!--End Carousel Wrapper-->
                        <!--Start Controls-->
                        <div class="col-1 align-self-center">
                            <a href="#multi-item-example" role="button" data-bs-slide="next">
                                <i class="text-dark fas fa-chevron-right"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <!--End Controls-->
                    </div>
                </div>
{{-- Product rating comment heart brand--}}
                <div class="col-7 mt-3 productDetailInfo" >
                    <div class="card " >
                        <div class="card-body">
                           <div class="d-flex justify-content-between align-items-center">
                            <h2 class="">{{$product[0]->name}}</h2>

                            @if ($heart == null)
                            <div class=" fs-5" id="heart" style="cursor: pointer">
                                <i class="fa-regular fa-heart text-danger"></i>
                            </div>

                            @elseif ($heart == 'unlogin')
                            <a href="{{route('user#homePage')}}" class=" fs-5" style="cursor: pointer">
                                <i class="fa-regular fa-heart text-danger"></i>
                            </a>
                            @else

                            <a href="{{route('user#heartLists')}}" class=" fs-5" style="cursor: pointer">
                                <i class="fa-solid fa-heart text-danger"></i>
                            </a>
                            @endif

                           </div>

                            <p class="">
                                <span class="list-inline-item text-dark">Rating ( {{$rating->total()}} ) | Comments ( {{($comment->count())}} ) </span>
                            </p>
                            <p>
                                <h6>view - {{$product[0]->views }}</h6>
                            </p>

                            <div class="d-flex brandProduct" >
                                <strong>Brand :</strong>
                                @if ($product[0]->brand !== null)
                                <small class="">{{$product[0]->brand}}</small>
                                @else
                                <small class="">NO Brand</small>
                                @endif
                            </div>
                            <hr class=" text-muted">
{{-- Price and Discount Price --}}
                        @if ($product[0]->discount_price == null)
                            <h2 class="text-waring mt-2" id="totalPrice">Ks {{number_format($product[0]->price)}} </h2>
                        @else

                            <h2 class=" text-warning mt-2" id="totalPrice"> Ks {{number_format($product[0]->discount_price)}}</h2>
                            <div class="d-flex">
                            <small class=" text-decoration-line-through">Ks {{number_format($product[0]->price)}} </small>
                            <small class="ms-3">{{$product[0]->discount_precentage}} %</small>
                            </div>
                            @endif
{{-- Size for shirt --}}
                <form action="{{route('user#addCart')}}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product[0]->id}}">
                    @if (Auth::user())
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    @endif

                    @if ((strpos(strtolower($product[0]->subcategory), 'shirt') !== false || strpos(strtolower($product[0]->subcategory), 'clothes') !== false))

                                <div class="my-3">
                                    <ul class="list-inline pb-3">
                                        <li class="list-inline-item">Size :
                                            <input type="hidden" name="shirt-size" id="product-size" value="S">
                                        </li>
                                        <li class="list-inline-item"><span class="btn btn-secondary btn-size">S</span></li>
                                        <li class="list-inline-item"><span class="btn btn-secondary btn-size">M</span></li>
                                        <li class="list-inline-item"><span class="btn btn-secondary btn-size">L</span></li>
                                        <li class="list-inline-item"><span class="btn btn-secondary btn-size">XL</span></li>
                                    </ul>
                                </div>

                     @endif
{{-- Size for shoe --}}

                    @if ((strpos(strtolower($product[0]->subcategory),'shoe')!== false ))

                                <div class="my-3">
                                    Size :
                                    <input type="text" name="shoe-size" placeholder="Enter your size" class="form-control w-50" id="shoeSize" required>
                                    <small class="text-danger d-none" id="shoeError">Please fill required</small>
                                    @error('shoe-size')
                                    <small class="my-2">{{$message}}</small>
                                    @enderror
                                </div>
                     @endif
{{-- Quantity for products --}}
                        <div class="my-3">
                                <ul class="list-inline pb-3">
                    <li class="list-inline-item text-right">Quantity
                        <input type="hidden" name="qty" id="product-quanity" value="1">
                    </li>
                    <li class="list-inline-item"><span class="btn btn-success" id="btn-minus">-</span></li>
                     <li class="list-inline-item"><span class="badge bg-secondary" id="var-value">1</span></li>
                    <li class="list-inline-item"><span class="btn btn-success" id="btn-plus">+</span></li>
                                </ul>
                        </div>

{{-- To buy or cart button --}}
                <div class="row pb-3">
                    @if (Auth::user())
                    <div class="col d-grid">
                        <button type="submit" class="btn btn-warning btn-lg"  >{{__('welcome.text14')}}</button>
                    </div>
                    @else
                    <a href="{{route('loginPage')}}" class="col d-grid">
                        <button class="btn btn-warning btn-lg" name="submit" >{{__('welcome.text14')}}</button>
                    </a>
                    @endif
                </form>

                    @if (Auth::user())
                    <div class="col d-grid">
                        <button type="button" class="btn btn-primary btn-lg" id="authButton">{{__('welcome.text15')}}</button>
                    </div>
                    @else
                    <a href="{{route('loginPage')}}" class="col d-grid">
                        <button type="button" class="btn btn-primary btn-lg" >{{__('welcome.text15')}}</button>
                    </a>
                    @endif
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{----------------------------- End of product information -----------------------}}

{{----------------------- Open detail of product ---------------------------------}}
        <div class="container detailsection mt-3 bg-light pb-3">
            <div class="pt-3 ">
                <h5>Product Details of {{$product[0]->name}}</h5>
            </div>
            <hr class="">
            <div class="">
                {!!$product[0]->description!!}
            </div>
        </div>
{{------------------------- Close detail of product ------------------------------}}


{{--------------------------- Rating and Rewiew Show Start ---------------------}}
{{-- Rating and review title --}}
          <div class="container mt-3  pb-3 mb-3 ratingsection">
            <div class="pt-3 d-flex justify-content-between">
                <h5>Rating and Review of {{$product[0]->name}}</h5>

                @if (!Auth::user())
                <div class=""><a href="{{route('loginPage')}}">Login</a> or <a href="{{route('registerPage')}}">Register</a> to rating & review</div>
                @endif

            </div>
            <hr class="">

            <input type="hidden" id="product_id" value="{{$product[0]->id}}">
           <div class="row">
{{-- To show average star --}}
            <div class="ms-3 col-3">
                <h4 class="text-secondary"><span id="average_rating">0.0</span> / 5</h4>
                <div class="mb-3">
                    <i class="fas fa-star star-light mr-1 main_star text-secondary"></i>
                    <i class="fas fa-star star-light mr-1 main_star text-secondary"></i>
                    <i class="fas fa-star star-light mr-1 main_star text-secondary"></i>
                    <i class="fas fa-star star-light mr-1 main_star text-secondary"></i>
                    <i class="fas fa-star star-light mr-1 main_star text-secondary"></i>
                </div>
                <h5 class="text-secondary"><span id="total_review">0</span> Review</h5>
            </div>
{{-- To show progress bar --}}
            <div class="col-5 ratingProgress">
                <p class="row bg-danger" style="">
                    <div class="progress-label-left  d-inline-block col-1"><b>5</b> <i class="fas fa-star text-secondary"></i></div>

                    <div class="d-inline-block col-9">
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress" ></div>
                        </div>
                    </div>

                    <div class="progress-label-right d-inline-block col-1">(<span id="total_five_star_review">0</span>)</div>
                </p>

                <p class="row ">
                    <div class="progress-label-left  d-inline-block col-1"><b>4</b> <i class="fas fa-star text-secondary"></i></div>

                    <div class="d-inline-block col-9">
                        <div class="progress">
                            <div class="progress-bar bg-warning " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress" ></div>
                        </div>
                    </div>

                    <div class="progress-label-right d-inline-block col-1">(<span id="total_four_star_review">0</span>)</div>
                </p>

                <p class="row ">
                    <div class="progress-label-left  d-inline-block col-1"><b>3</b> <i class="fas fa-star text-secondary"></i></div>

                    <div class="d-inline-block col-9">
                        <div class="progress">
                            <div class="progress-bar bg-warning " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress" ></div>
                        </div>
                    </div>

                    <div class="progress-label-right d-inline-block col-1">(<span id="total_three_star_review">0</span>)</div>
                </p>

                <p class="row ">
                    <div class="progress-label-left  d-inline-block col-1"><b>2</b> <i class="fas fa-star text-secondary"></i></div>

                    <div class="d-inline-block col-9">
                        <div class="progress">
                            <div class="progress-bar bg-warning " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress" ></div>
                        </div>
                    </div>

                    <div class="progress-label-right d-inline-block col-1">(<span id="total_two_star_review">0</span>)</div>
                </p>

                <p class="row ">
                    <div class="progress-label-left  d-inline-block col-1"><b>1</b> <i class="fas fa-star text-secondary"></i></div>

                    <div class="d-inline-block col-9">
                        <div class="progress">
                            <div class="progress-bar bg-warning " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress" ></div>
                        </div>
                    </div>

                    <div class="progress-label-right d-inline-block col-1">(<span id="total_one_star_review">0</span>)</div>
                </p>

            </div>
{{-- To give rating and review --}}
            <div class="col-3 ">
                @if (Auth::user())
                    <button type="button" class="btn btn-secondary" id="checkproduct">
                        To Review & Rating
                       </button>
                @else
                       <div class="">
                        <img src="{{asset('images/voting-monochromatic.svg')}}" width="200px" height="150px">
                       </div>

                @endif
            </div>


      @if (Auth::user())
{{-- -- Modal 1-- --}}
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                 <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">To write Rating and Review</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <h4 class="text-center mt-2 mb-4">
                <div class="star-rating">
                    <i class="fas fa-star fa-2x  mr-1" ></i>
                    <i class="fas fa-star fa-2x mr-1" ></i>
                    <i class="fas fa-star fa-2x mr-1" ></i>
                    <i class="fas fa-star fa-2x mr-1" ></i>
                    <i class="fas fa-star fa-2x mr-1" ></i>
                   </div>
          </h4>

          <div class="form-group">
            <input type="hidden" id="user_id" value="{{Auth::user()->id}}">
              <textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
          </div>
          <div class="form-group text-center mt-4">
              <button type="button" class="btn btn-primary" id="save" data-bs-dismiss="modal">Submit</button>
          </div>
        </div>

      </div>
    </div>
  </div>

{{-- Modal 2 --}}
                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                <div class="modal-header">
    <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">  Sorry &#128532; &#128532;</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

    <div class="modal-body">
        <h6 style="text-indent: 20px; line-height:25px">
            One product give one rating and review.If you give,you delete previous rating and review
        </h6>
    </div>
                </div>
                    </div>
                        </div>
      @endif
           </div>
           <hr class="my-3">

{{-- to show review lists --}}
     @if (count($rating) == 0)
           <div class="text-center mt-3"> This product has no reviews</div>
     @else
     <div id="review_contant">
        @include('singleProduct.pagination_rating')
     </div>
     @endif
          </div>
{{--------------------------------- Rating and Rewiew Show end--------------------------}}


{{--------------------------------- Question and Answer Start -----------------------------}}
{{-- Question title --}}
            <div class="container mt-3 bg-light pb-3 mb-3 ratingsection" id="commentsection">
            <div class="pt-3 d-flex justify-content-between">
                <h5>Question and Answer of {{$product[0]->name}}</h5>
                   @if (!Auth::user())
                   <div class=""> <a href="{{route('loginPage')}}">Login</a> or <a href="{{route('registerPage')}}">Register</a> <small>to ask questions to seller</small></div>
                   @endif
            </div>
                <hr class="">
{{-- To Ask Question --}}
                @if (Auth::user())
                    <div class="row ">
                        <div class="col-8 m-auto">
                            <textarea id="comment"  class="form-control " placeholder="Please Enter Question to Seller"></textarea>
                             <span class="text-danger d-none" id="error">Please fill question !</span>
                        </div>
                    </div>
                       <div class="text-center">
                            <button class="btn btn-danger w-25 mt-3" id="ask">Ask</button>
                       </div>
{{-- To show Question picture --}}
                @else
                    <div class="text-center">
                        <img src="{{asset('images/question-monochromatic.svg')}}" width="100px" height="100px" class="">
                    </div>
                @endif
                <hr>

{{-- To show Comment Reply --}}
                    @if($comment->count() !== 0)
                @if (Auth::user())
 {{-- My Question --}}
                <div>

                    <h5 class=" mb-3">My Questions </h5>

                    @foreach ($comment as $item)
                    @if($item->user_id  == Auth::user()->id)

                                <div class="my-2">
                    <div class="d-flex ">
                        <div class="ms-3"><i class="fa-solid fa-question"></i></div>
                       <div class="ms-3">
                           <h6 class="mb-0 pb-0">{{$item->comment}}</h6>
                           <p class="text-muted" > <span style="font-size: 15px">{{$item->email}}</span >  - <span style="font-size: 15px">{{$item->created_at->diffForHumans()}}</span> </p>
                       </div>
                   </div>

                    <div class="">
                           @if ($item->reply !== null)
                           <div class="d-flex ">
                               <div class="ms-3"><i class="fa-solid fa-message"></i></div>
                               <div class="ms-3">
                                   <h6 class="mb-0 pb-0">{{$item->reply}}</h6>
                                   <p class="text-muted" > <span style="font-size: 15px">Answered form Admin</span >  - <span style="font-size: 15px">{{$item->updated_at->diffForHumans()}}</span> </p>
                               </div>
                           </div>
                           @else
                               <div class="text-muted ms-3">No answer yet</div>
                           @endif
                    </div>
                        </div>
                            <hr>
                   @endif
                   @endforeach

                </div>

 {{-- Other Question --}}
                <h5 class=" mb-3">Other Questions </h5>
                <div>

                    @foreach ($comment as $item)
                    @if($item->user_id  !== Auth::user()->id)
                                <div class="my-2">
                    <div class="d-flex ">
                        <div class="ms-3"><i class="fa-solid fa-question"></i></div>
                       <div class="ms-3">
                           <h6 class="mb-0 pb-0">{{$item->comment}}</h6>
                           <p class="text-muted" > <span style="font-size: 15px">{{$item->email}}</span >  - <span style="font-size: 15px">{{$item->created_at->diffForHumans()}}</span> </p>
                       </div>
                   </div>

                    <div class="">
                           @if ($item->reply !== null)
                           <div class="d-flex ">
                               <div class="ms-3"><i class="fa-solid fa-message"></i></div>
                               <div class="ms-3">
                                   <h6 class="mb-0 pb-0">{{$item->reply}}</h6>
                                   <p class="text-muted" > <span style="font-size: 15px">Answered from Admin</span >  - <span style="font-size: 15px">{{$item->updated_at->diffForHumans()}}</span> </p>
                               </div>
                           </div>
                           @else
                               <div class="text-muted ms-3">No answer yet</div>
                           @endif
                    </div>
                        </div>
                            <hr>
                   @endif
                   @endforeach

                </div>

                @else

{{-- unlogin Question --}}
                <div id="unlogin" >
                <h5 class=" mb-4">( {{$comment->count()}} ) Questions of {{$product[0]->name}}</h5>
                    @include('singleProduct.pagination_question')


                </div>

                @endif
                    @else
                        <div class="text-center text-danger">There is no Question yet</div>
                    @endif
              </div>
{{---------------------------- Question and Answer end -----------------------------------}}
    </section>



@endsection
@section('script')
<script src="{{asset('assets/js/slick.min.js')}}"></script>

<script>


//--------------------------------- Slide for products images --------------------
    $('#carousel-related-product').slick({
        infinite: true,
        arrows: false,
        slidesToShow: 4,
        slidesToScroll: 3,
        dots: true,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 3
                }
            }
        ]
    });
//--------------------------------- Slide for products images end--------------------

//------------------------------- Question and Answer ------------------------
    $('#ask').click(function(){
        $userId = $('#user_id').val()
        $comment = $('#comment').val()
        if(!$comment){
           $('#comment').addClass('is-invalid')
           $('#error').removeClass('d-none')
        }else{
            $data = {
           'userId' : $('#user_id').val(),
            'productId' : $('#product_id').val(),
            'comment' : $('#comment').val()
         }
         $.ajax({
            url : "/user/comment/send",
            type : 'get',
            data : $data,
            dataType : "JSON",
            success : function(response){
                location.reload();
            }
         })
        }



    })

//------------------------------- Question and Answer end------------------------

// ----------------------------------- Buy Button click start --------------------
        $('#authButton').click(function(){
            $userId = $('#user_id').val();
            $productId = $('#product_id').val();
            $qty = $('#product-quanity').val();
            $total = $('#totalPrice').html().replace('Ks','').replace(/,/g, '');
            $total = $total * $qty
            $shirtSize = $('#product-size').val();
            $shoeSize = $('#shoeSize').val();
            $random = Math.floor(Math.random() * 100000000)
            if($shoeSize !== undefined){
                if($shoeSize == ''){
                    $('#shoeError').removeClass('d-none')
                    $('#shoeSize').addClass('is-invalid')
                }
            }
            if($shirtSize == undefined ){
                $shirtSize = null
            }else{
                $shirtSize = $shirtSize
            }

            if($shoeSize == undefined){
                $shoeSize = null
            }else{
                $shoeSize = $shoeSize
            }

            if($shoeSize !== ''){
                    $data = {
                'userId' : $userId,
                'productId' : $productId,
                'qty' : $qty,
                'total' : $total,
                'shoe' : $shoeSize,
                'shirt' : $shirtSize,
                'random' : $random }

                $.ajax({
                    type : 'get',
                    url : '/user/add/buy/button',
                    data : $data,
                    dataType : 'JSON',
                    success : function(response){
                        window.location.href = '/user/delivery/page/buy'+"?data="+response.code
                    }
                })
            }



        })
// ----------------------------------- Buy Button click end --------------------

//------------------------------ Heart Section start ---------------------
    $('#heart').click(function(){
       $userId = $('#user_id').val();
        $data = {
            'userId': $('#user_id').val(),
            'productId' : $('#product_id').val()
        }
            $.ajax({
                url : '/user/add/heart',
                type : 'get',
                data : $data,
                dataType : 'JSON',
                success : function(response){
                    if(response.status == 'success'){
                        $('#heart').html(`
                        <i class="fa-solid fa-heart text-danger"></i>
                        `)
                        location.reload();
                    }
                }
            })

    })
//------------------------------ Heart Section end ---------------------

//------------------------------- Rating and Review --------------------
    $(document).ready(function(){


// Rating Pagination
        $(document).on('click','.pagination a',function(event){
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var productId= $('#product_id').val()
        fetch_data(page,productId);
       });
       function fetch_data(page,productId){

        $.ajax({
            url : "/rating/pagination?page="+page+"&"+'productId='+productId,
            success:function(data){
                console.log(data)
                $('#review_contant').html(data);

            }
        })
       }

//Check rating product start
            $.ajax({
                url : '/check/product',
                type : 'get',
                data : {'userId': $('#user_id').val() ,'productId': $('#product_id').val()},
                dataType : "JSON",
                success : function(data){

                    if(data.message == 'true'){
                        $('#checkproduct').attr('data-bs-toggle', 'modal'),
                        $('#checkproduct').attr('data-bs-target', '#exampleModal')
                    }
                    if(data.message == 'false'){
                        $('#checkproduct').attr('data-bs-toggle', 'modal'),
                        $('#checkproduct').attr('data-bs-target', '#exampleModal2')
                    }
                }
            })
// Star control plus or minus
        const stars = $('.star-rating i');
         $rating = 0
        stars.click(function () {
        if ($(this).hasClass('text-warning')) {
            // If the star is already clicked, remove the color and decrement the rating
            $(this).removeClass('text-warning');
            $rating -= 1;
        } else {
            // If the star is not clicked, add the color and increment the rating
            $(this).addClass('text-warning');
            $rating += 1;
        }

    });
// To save rating and reveiw
    $('#save').click(function(){
        $review = $('#user_review').val()

        if($review == null || $rating == 0 || $review == ""){
            alert('Please fill rating and review')
        }else{
            $data = {
                'userId' : $('#user_id').val(),
                'productId': $('#product_id').val(),
                'review' : $review,
                'rating' : $rating
            }
            $.ajax({
            type : 'get',
            url :'/rating/review' ,
            data : $data,
            dataType : "JSON",
            success : function(response){
                location.reload();

            }
    })

        }
    })
// To show rating and review
    getRatingData();
    function getRatingData(){
        $.ajax({
            type : 'get',
            url : '/rating/review/get',
            data : {'product_id': $('#product_id').val()},
            dataType : "JSON",
            success : function(response){
                // console.log(response)
                $('#average_rating').text(response.avage_rating)
                $('#total_review').text(response.total_review)

                    $count_star = 0
                $('.main_star').each(function(){
                    $count_star++;
                    if(Math.ceil(response.avage_rating) >= $count_star){
                        $(this).addClass('text-white')
                    }
                })

                $('#total_five_star_review').text(response.five_star)
                $('#total_four_star_review').text(response.four_star)
                $('#total_three_star_review').text(response.three_star)
                $('#total_two_star_review').text(response.two_star)
                $('#total_one_star_review').text(response.one_star)

                $('#five_star_progress').css('width',(response.five_star/response.total_review)*100 +"%")
                $('#four_star_progress').css('width',(response.four_star/response.total_review)*100 +"%")
                $('#three_star_progress').css('width',(response.three_star/response.total_review)*100 +"%")
                $('#two_star_progress').css('width',(response.two_star/response.total_review)*100 +"%")
                $('#one_star_progress').css('width',(response.one_star/response.total_review)*100 +"%")
                // console.log(Math.ceil(response.avage_rating))

            }
        })
    }
    })
//------------------------------- Rating and Review end--------------------
</script>
@endsection


