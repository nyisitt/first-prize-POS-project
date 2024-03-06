@extends('master')
@section('contant')
<div class="">hello</div>
<section class="cardshow">

{{-- Delivery infomation --}}
        <div class="row d-flex ">
            <div class="col-8 mt-4 bg-light rounded">
                <h5 class="mt-4 ms-2 mb-3">Delivery Information</h5>

                <div class="ms-3 row ">
                    <div class="col-6 mb-3">
                        <div class="mb-1">Full Name </div>
                        <input type="text" class="form-control w-75 "  placeholder="Please enter your fullname" id="name">
                        <small class="text-danger d-none" id="errorname">Please fill full name !</small>
                    </div>
                    <div class="col-6 mb-3">
                        <div >Region</div>
                        <input type="text"  class="form-control w-75" placeholder="Please enter your region" id="region">
                        <small class="text-danger d-none" id="errorregion">Please fill region !</small>
                    </div>
                    <div class="col-6 mb-3">
                        <div >Phone Number</div>
                        <input type="text"  class="form-control w-75" placeholder="Please enter your phone number" id="phone">
                        <small class="text-danger d-none" id="errorphone">Please fill phone number !</small>
                    </div>
                    <div class="col-6 mb-3">
                        <div >City</div>
                        <input type="text"  class="form-control w-75" placeholder="Please enter your city" id="city">
                        <small class="text-danger d-none" id="errorcity">Please fill city !</small>
                    </div>
                    <div class="col-6 mb-3">
                        <div >Email Address</div>
                        <input type="email"  class="form-control w-75" placeholder="Please enter your email" id="email">
                        <small class="text-danger d-none" id="erroremail">Please fill email address !</small>
                    </div>
                    <div class="col-6 mb-3">
                        <div >Address</div>
                        <input type="text"  class="form-control w-75" placeholder="Example : House No/Street" id="address">
                        <small class="text-danger d-none" id="erroraddress">Please fill address !</small>
                    </div>
                </div>
                <div class="text-center mt-3 mb-5">
                    <button class="btn btn-secondary w-25" id="deliSave">Save</button>
                </div>
            </div>
{{-- Order summery --}}
            @if (Auth::user())
                <input type="hidden" value="{{Auth::user()->id}}" id="userId">
            @endif
            <div class="col-4 mt-4 ">
               <h4 class="mb-3">Order Summery ----------</h4>
               <div class="bg-light rounded p-3">

                <input type="hidden" name="" id="cardCode" value="{{$orderCode}}">
                <div class="deliCode">

                </div>
                <div class="d-flex justify-content-between mb-3 mt-3">
                    <h5>Subtotals (<span id="allItem"> {{$qty}} </span>)</h5>
                    <h6 id="allPrice">Ks {{$totalPrice}}</h6>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <h5>Delivery Fee</h5>
                    <h6 id="deliveryFee">Ks {{$deliveryPrice}}</h6>

                </div>
                <hr class="mb-4">
                <div class="d-flex justify-content-between mb-3 ">
                    <h5>Total</h5>
                    <h6 id="withDeliFee">Ks {{$totalPrice + $deliveryPrice}}</h6>
                </div>
                <div  class="text-center mb-3 ">
                    <button class="btn btn-secondary w-100" id="orderButton" disabled >PROCEED TO ORDER</button>
                </div>
            </div>
            </div>
        </div>
</section>
@endsection
@section('script')
<script>
// Delivery information
    $(document).ready(function(){
        $('#deliSave').click(function(){
           $name = $('#name').val();
           $email = $('#email').val();
           $phone = $('#phone').val();
           $region = $('#region').val();
           $city = $('#city').val();
           $address = $('#address').val();

           if($name == ''){
            $('#errorname').removeClass('d-none')
            $('#name').addClass('is-invalid')
           }
           if($email == ''){
            $('#erroremail').removeClass('d-none')
            $('#email').addClass('is-invalid')
           }
           if($phone == ''){
            $('#errorphone').removeClass('d-none')
            $('#phone').addClass('is-invalid')
           }
           if($region == ''){
            $('#errorregion').removeClass('d-none')
            $('#region').addClass('is-invalid')
           }
           if($city == ''){
            $('#errorcity').removeClass('d-none')
            $('#city').addClass('is-invalid')
           }
           if($address == ''){
            $('#erroraddress').removeClass('d-none')
            $('#address').addClass('is-invalid')
           }

           if($name !== '' && $email !== '' && $phone !== '' && $region !== '' && $city !== '' && $address !== ''){
            $('#errorname').addClass('d-none'),
            $('#erroremail').addClass('d-none')
            $('#errorphone').addClass('d-none')
            $('#errorregion').addClass('d-none')
            $('#errorcity').addClass('d-none')
            $('#erroraddress').addClass('d-none')

            $('#address').removeClass('is-invalid')
            $('#name').removeClass('is-invalid')
            $('#email').removeClass('is-invalid')
            $('#phone').removeClass('is-invalid')
            $('#region').removeClass('is-invalid')
            $('#city').removeClass('is-invalid')

            $random = Math.floor(Math.random() * 100000000)
               $data = {
                    'name' : $name,
                    'email': $email,
                    'phone' : $phone,
                    'region' : $region,
                    'city' : $city,
                    'address' : $address,
                    'deli_code' :$random
                }

                $.ajax({
                    url : '/user/add/delviery',
                    type : 'get',
                    data : $data,
                    dataType : "JSON",
                    success : function (response){
                       $('.deliCode').html(`
                       <input type="hidden" name="deliCode" id="deliCode" value="${response.code}">
                       `)
                       $('#name').val('');
                       $('#phone').val('');
                       $('#region').val('');
                       $('#email').val('');
                       $('#city').val('');
                       $('#address').val('');
                       $orderButton = document.getElementById('orderButton');
                       $orderButton.disabled = false ;
                       $saveButton = document.getElementById('deliSave');
                       $saveButton.disabled = true ;

                    }
                })
           }
        })

// To add Order
            $('#orderButton').click(function(){
              $cardCode = $('#cardCode').val()
              $deliCode = $('#deliCode').val()
              $allQty = $('#allItem').html()
                $totalPrice = $('#allPrice').html().replace('Ks','')
                $deliPrice = $('#deliveryFee').html().replace('Ks','')
                $data = {
                    'userId' : $('#userId').val(),
                    'cardCode': $cardCode,
                    'deliCode' : $deliCode,
                    'total' : $totalPrice,
                    'deli' : $deliPrice
                }
                $.ajax({
                url : '/user/add/order',
                type : 'get',
                data : $data,
                dataType : "JSON",
                success : function(response){
                    $order = response.orderId
                    window.location.href = "/user/choose/payment"+'?data='+$order+'&'+'quantity='+$allQty
                }
        })


            })
    })
</script>
@endsection
