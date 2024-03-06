@extends('../master')
@section('contant')
@if (count($product) > 0)
<div class="sectionProduct">
    <div class="row">
     {{-- Filter section start--}}
     <div class="col-2  offset-1  filter ">
        <div class="d-flex justify-content-between">
            <h3>Filters</h3>
            <a href="{{route('productList',$product[0]->subcategory)}}" title="clear all filter"><i class="fa-solid fa-filter-circle-xmark text-dark mt-2"></i></a>
        </div>
        <hr class=" text-muted">

        <h6>Brand</h6>
        @foreach ($brand as $p)
        @if ($p->brand != null)
        <a  class="brand-item d-block text-dark" style="cursor: pointer">
                {{$p->brand}}
        </a>
        @endif

        @endforeach
        <hr class="text-muted">

        <h6>Price</h6>
        <div class="d-flex">
         <input type="text" class="price" placeholder="Min" id="priceMin" >__
         <input type="text" class="price" placeholder="Max" id="priceMax" >
        </div>
        <div class="text-center mt-3">
         <button class="btn btn-warning w-50" id="apply">Apply</button>
        </div>
        <hr class="text-muted">

        <h6 class="mb-3">Reviews</h6>
            <button class="btn btn-primary mb-3" id="reviewHight">Reviews Hight to Low</button>
            <button class="btn btn-secondary " id="reviewLow">Reviews Low to Hight</button>


     </div>
      {{-- Filter section end--}}
      
     {{-- Products section start--}}
     <div class=" col-7 offset-1 products "  >
         <div class="d-flex justify-content-between">
             <h6 class="mt-3">{{$product->total()}} items found for "{{$product[0]->subcategory}}"</h6>
             <div class="me-5">
                 Sort By:
                 <select class="select " id="sorting">
                     <option value="">Best Match</option>
                     <option value="hight">Price Hight to Low</option>
                     <option value="low">Price Low to Hight</option>
                 </select>
             </div>
         </div>
         <hr>
         <input type="hidden" value="{{$product[0]->subcategory}}" id="subcategory">
         <div class="row " id="productContainer" >

           @include('welcomeProduct.child_product')
         </div>
     </div>
     {{-- Products section end--}}
    </div>

 </div>
 @else
    <div class="noData text-center">
        <h3 class="bg-danger w-50 m-auto p-3 rounded">There is not found for products.Sorry &#128542; &#128542;</h3>
    </div>
@endif
@endsection
@section('script')
<script>
$(document).ready(function(){
    $(document).on('click','.pagination a',function(event){
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var category = $('#subcategory').val()
        // console.log(page);
        fetch_data(page,category);
       });
       function fetch_data(page,category){
        $.ajax({
            url : "/pagination/product?page="+page+"&"+'category='+category,
            success:function(data){
                $('#productContainer').html(data);

            }
        })
       }
 // --------------   Sorting brand ------------
       var brand;
       $('.brand-item').click(function(){
        brand = $(this).html();
        var category = $('#subcategory').val()
       $.ajax({
            type : 'get',
            url : '/pagination/brand',
            data : {'brand': brand,'category': category},
            dataType : "JSON",
            success : function(response){
                console.log(response)
                addLists(response)
                $('#productContainer').html($lists);
            }
        })
    })

//----------- Sorting price low to hight or higt to low -----------
       $('#sorting').change(function(){
        var value = $('#sorting').val()
         var category = $('#subcategory').val()
         var minprice = parseInt($('#priceMin').val());
        var maxprice = parseInt($('#priceMax').val());

            $.ajax({
            type : 'get',
            url : '/pagination/sorting',
            data : {'value': value,'category': category,'brand': brand,'min': minprice,'max':maxprice},
            dataType : "JSON",
            success : function(response){
                addLists(response);
                $('#productContainer').html($lists);
            }
       })

    })

//------------- Sorting range Min max --------
 // to check do not contain minus value
  $('#priceMin,#priceMax').on('input',function(){
    var min = $("#priceMin").val();
    var max = $('#priceMax').val();
    if(min < 0){
        $('#priceMin').val(0);
    }
    if(max < 0){
        $('#priceMax').val(0);
    }
  })

  $('#apply').click(function(){
    var minprice = parseInt($('#priceMin').val());
    var maxprice = parseInt($('#priceMax').val());
    var category = $('#subcategory').val()
    if(minprice && maxprice){
        console.log(minprice)
        $.ajax({
        url : '/pagination/minmax/price',
        type : 'get',
        data : {'min':minprice,'max': maxprice,'category':category,'brand': brand},
        dataType : "JSON",
        success : function(response){
            console.log()
            console.log(response)
            if(response.length > 0){

                addLists(response)
                $('#productContainer').html($lists);
            }else{
                $('#productContainer').html(`
                <div class="noData text-center">
        <h3 class="bg-danger w-50 m-auto p-3 rounded">There is not found for products.Sorry &#128542; &#128542;</h3>
                    </div>
                `)
            }

        }
    })
        }

  })

//   Sorting review
  $('#reviewHight').click(function(){
    var category = $('#subcategory').val()
        $.ajax({
            url : '/pagination/sorting/review',
            type : 'get',
            data : {'category': category},
            dataType : "JSON",
            success : function(response){
                console.log(response);
                addLists(response)
                $('#productContainer').html($lists);
            }
        })
  })
  $('#reviewLow').click(function(){

    var category = $('#subcategory').val()
        $.ajax({
            url : '/pagination/sorting/review/low',
            type : 'get',
            data : {'category': category},
            dataType : "JSON",
            success : function(response){
                console.log(response);
                addLists(response)
                $('#productContainer').html($lists);
            }
        })
  })

  function addLists(response){
    $lists = ``
                for($i = 0 ; $i<response.length ; $i++){
                    $discount= ``
                    if(response[$i].discount_price == null){
                       $discount += ` <h5 class="text-warning">Ks ${response[$i].price.toLocaleString()}</h5>`
                    }else{
                      $discount += `  <h5 class="text-warning ">Ks ${response[$i].discount_price}</h5>
                        <div class="d-flex ">
                <h6 class=" text-decoration-line-through ">Ks ${response[$i].price}</h6> &nbsp; &nbsp; <h6>${response[$i].discount_precentage} %</h6>
                </div>`
                    }
                    $review = ``
                    if(response[$i].total == 1){
                        if (response[$i].user_name == null) {
                            $review += `Reviews - ( 0 )`
                        }else{
                            $review += `Review - ( 1 )`
                        }
                    }else{
                        $review += ` Reviews - (${response[$i].total})`
                    }
                    $lists += `
                    <div class="col-3 mb-4" >
                        <a href="{{url('product/single/${response[$i].id}')}}" >
            <div class="card" style="height: 360px; width:195px;">
            <img src="{{asset('storage/${response[$i].first_image}')}}" class="card-img-top " style="height:200px">
            <div class="card-body ">
          <h5 class="text-center mb-3 text-dark">${response[$i].name}</h5>
            ${$discount}

          <div class='text-dark'>${$review}</div>

                <div class='text-dark'><i class="fa-solid fa-eye"></i> - (${response[$i].views})</div>
        </div>
      </div>
    </a>
    </div> `
            }

  }
})
</script>

@endsection













