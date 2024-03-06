@extends('master')
@section('contant')
 <!-- Start Banner Hero -->
 <div id="template-mo-zay-hero-carousel" class="carousel slide mt-5" data-bs-ride="carousel" >
    <ol class="carousel-indicators ">
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active ">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="{{asset('images/undraw_happy_news_re_tsbd.svg')}}" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left align-self-center">
                            <h1 class=" text-success "><b> {{__('welcome.welcome')}}</b> </h1>
                            <h6 class="mb-3" style="font-size: 25px">{{__('welcome.what')}}</h6>
                            <h6 style="font-size: 20px;">
                              {!! __('welcome.text1')!!}
                            </h6>
                            <h6 style="font-size: 20px;">
                               {!!__('welcome.text2')!!}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item mt-5">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="{{asset('images/undraw_on_the_way_re_swjt.svg')}}" alt="">

                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h1 class=" text-success"><b>{{__('welcome.text3')}}</b></h1>

                            <p>
                                {{__('welcome.text4')}}
                            </p>
                            <p> {{__('welcome.text5')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="{{asset('images/undraw_terms_re_6ak4.svg')}}" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h1 class=" text-success"><b>{{__('welcome.text6')}}</b></h1>
                            <ul>
                                <li>{{__('welcome.text7')}}</li>
                                <li>{{__('welcome.text8')}}</li>
                                <li>{{__('welcome.text9')}}</li>
                                <li>{{__('welcome.text10')}}</li>
                                <li>{{__('welcome.text11')}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
        <i class="fas fa-chevron-left"></i>
    </a>
    <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
        <i class="fas fa-chevron-right"></i>
    </a>
</div>
<!-- End Banner Hero -->


<!-- Start Categories of The Month -->
<div class="categorysection">
    <section class="container py-5 ">
        <div class="row  py-3">
                <h3 class="text-start "> {{__('welcome.category')}}</h3>
        </div>
        <div class="row  d-flex">
            @php
            $groupSubcategories = $subcategory->groupBy('subcategory');
             @endphp

        @foreach ($groupSubcategories as  $subcategoriesInGroup)
        {{-------------- To same subcategory and write words casesensative ----------}}

            {{-- Phone category --}}
        @php
        $filter = $subcategoriesInGroup->where('subcategory', 'Phone')->all();
        shuffle($filter);
        $randomPhone = array_shift($filter);
        @endphp
        @if ($randomPhone)

        <div class=" mb-2 col-2 category-items">
            <a href="{{route('productList',$randomPhone->subcategory)}}">
            <img src="{{ asset('storage/' . $randomPhone->first_image) }}" height="60%" width="100%"  >
        <h4 class="text-center mt-3 text-white">{{ $randomPhone->subcategory }}</h4>
            </a>
        </div>
        @endif

            {{-- Ball category --}}
            @php
            $filter = $subcategoriesInGroup->where('subcategory', 'Ball')->all();
            shuffle($filter);
            $randomPhone = array_shift($filter);
            @endphp
            @if ($randomPhone)
            <div class=" mb-2 col-2 category-items">
                <a href="{{route('productList',$randomPhone->subcategory)}}">
                <img src="{{ asset('storage/' . $randomPhone->first_image) }}" height="60%" width="100%"  >
            <h4 class="text-center mt-3 text-white">{{ $randomPhone->subcategory }}</h4>
                </a>
            </div>
            @endif

             {{-- Man watches category --}}
             @php
            $filter = $subcategoriesInGroup->where('subcategory', 'Man Shirts')->all();
            shuffle($filter);
            $randomPhone = array_shift($filter);
            @endphp
            @if ($randomPhone)
            <div class=" mb-2 col-2 category-items">
                <a href="{{route('productList',$randomPhone->subcategory)}}">
                <img src="{{ asset('storage/' . $randomPhone->first_image) }}" height="60%" width="100%"  >
            <h4 class="text-center mt-3 text-white">{{ $randomPhone->subcategory }}</h4>
                </a>
            </div>
            @endif

            {{-- Shirt Category--}}
            @php
            $filter = $subcategoriesInGroup->where('subcategory', 'man watches')->all();
            shuffle($filter);
            $randomPhone = array_shift($filter);
            @endphp
            @if ($randomPhone)
            <div class=" mb-2 col-2 category-items">
                <a href="{{route('productList',$randomPhone->subcategory)}}">
                <img src="{{ asset('storage/' . $randomPhone->first_image) }}" height="60%" width="100%"  >
            <h4 class="text-center mt-3 text-white">{{ $randomPhone->subcategory }}</h4>
                </a>
            </div>
            @endif

            {{-- Pizza Category--}}
            @php
            $filter = $subcategoriesInGroup->where('subcategory', 'Pizza')->all();
            shuffle($filter);
            $randomPhone = array_shift($filter);
            @endphp
            @if ($randomPhone)
            <div class=" mb-2 col-2 category-items">
                <a href="{{route('productList',$randomPhone->subcategory)}}">
                <img src="{{ asset('storage/' . $randomPhone->first_image) }}" height="60%" width="100%"  >
            <h4 class="text-center mt-3 text-white">{{ $randomPhone->subcategory }}</h4>
                </a>
            </div>
            @endif

            {{-- Laptop Category--}}
            @php
            $filter = $subcategoriesInGroup->where('subcategory', 'Laptop')->all();
            shuffle($filter);
            $randomPhone = array_shift($filter);
            @endphp
            @if ($randomPhone)
            <div class=" mb-2 col-2 category-items">
                <a href="{{route('productList',$randomPhone->subcategory)}}">
                <img src="{{ asset('storage/' . $randomPhone->first_image) }}" height="60%" width="100%"  >
            <h4 class="text-center mt-3 text-white">{{ $randomPhone->subcategory }}</h4>
                </a>
            </div>
            @endif

        @endforeach


        </div>
    </section>
</div>
<!-- End Categories of The Month -->

{{-------------------  Most view product start -------------------------}}
<div style="background:whitesmoke">
    <section class="container py-5 ">
       <h3 class="mb-3">{{__('welcome.text12')}}</h3>
        <div class="row">
            @foreach ($popular as $item)
                <div class=" mb-2 col-2 category-items" style="border: 3px solid whitesmoke">
                    <a href="{{route('productSinglePage',$item->id)}}">
                    <img src="{{ asset('storage/' . $item->first_image) }}" height="60%" width="100%"  >
                <h5 class="text-center mt-3 text-white">{{ $item->name}}</h5>
                <small class="text-white ms-3">{{$item->views}} peoples watched </small>
                    </a>
                </div>

            @endforeach

        </div>
    </section>
</div>
{{-------------- Most view product end -------------------}}

{{------------------------ Flash Sale start --------------}}
<section style="background: wheat">
    <div class="container py-5">
        <h3>Promotion</h3>
        <div class="d-flex mt-3">
            <h5 class="">Ending  in</h5>
            <div class="ms-5">
                <span class="bg-info px-3 py-2 rounded me-2" id="day">00</span>:
                <span class="bg-info px-3 py-2 rounded me-2" id="hour">00</span>:
                <span class="bg-info px-3 py-2 rounded me-2" id="min">00</span>:
                <span class="bg-info px-3 py-2 rounded me-2" id="sec">00</span>
            </div>
        </div>
        <hr>
       @if ($promotion->count() > 0)
       <input type="hidden" name="" id="date" value="{{$promotion[0]->expired_date}}">
        <div class="row">
        @foreach ($promotion as $item)
            <div class=" mb-2 col-2 category-items" style="border: 3px solid whitesmoke">
            <a href="{{route('productSinglePage',$item->id)}}">
            <img src="{{ asset('storage/' . $item->first_image) }}" height="60%" width="100%"  >
            <h5 class="text-center mt-3 text-white">{{ $item->name}}</h5>
            <h5 class="text-warning ms-3">{{$item->discount_price}} Ks</h5>
            <div class="d-flex ms-3">
                <h6 class=" text-decoration-line-through text-dark"> {{$item->price}} Ks</h6> &nbsp; &nbsp;<h6 class="text-dark">  {{$item->discount_precentage}} %</h6>
            </div>

                </a>
            </div>
        @endforeach
    </div>
       @endif
    </div>
</section>
{{------------------------ Flash Sale end --------------}}

<!-- Start Featured Product -->
<section class="bg-light">
    <div class="container py-5">
        <div class="row text-start py-3 ">
                <h3>{{__('welcome.text13')}}</h3>
        </div>

        <div class="row" id="data-wrapper">
           @include('child_pagination')
        </div>
        <div class="">
            {{$product->links()}}
        </div>
    </div>
</section>
<!-- End Featured Product -->
@endsection
@section('script')
<script>
  $(document).ready(function(){
//--------------------------- Timer start--------------------
    $date = $('#date').val();
    var expired_date = new Date($date).getTime();


    if(!isNaN(expired_date)){
        var countdown = setInterval(function(){
            var now = new Date().getTime();
            var distance = expired_date - now ;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $('#day').html(days);
            $('#hour').html(hours);
            $('#min').html(minutes);
            $('#sec').html(seconds);

            if(distance < 0) {
                $('#day').html('00');
                $('#hour').html('00');
                $('#min').html('00');
                $('#sec').html('00');
                clearInterval(countdown);

                location.reload();
            }

        },1000);

    }



// -------------------------------Timer end-------------------

       $(document).on('click','.pagination a',function(event){
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        // console.log(page);
        fetch_data(page);
       });
       function fetch_data(page){
        $.ajax({

            url : "/pagination/fetch_data?page="+page,
            success:function(data){
                // console.log(data);
              $('#data-wrapper').html(data)

            }
        })
       }


    })
</script>
@endsection









