@extends('admin.master')
@section('content')
 <main class="main users chart-page" id="skip-target">
      <div class="container">
        <h2 class="main-title"> member and product </h2>
        <div class="row stat-cards">
          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon primary">
                <i class="fa-solid fa-users"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">{{$user}} members</p>
                <h5 class="text-white">Total customers</h5>

              </div>
            </article>
          </div>
          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon warning">
                <i class="fa-solid fa-truck"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">{{$delivery}} people</p>
                <h5 class="text-white">Total deliveries</h5>

              </div>
            </article>
          </div>
          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon purple">
                <i class="fa-solid fa-user-tie"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">{{$admin}} people</p>
                <h5 class="text-white">Total admins</h5>

              </div>
            </article>
          </div>
          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
              <div class="stat-cards-icon success">
                <i class="fa-solid fa-boxes-stacked"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num">{{$product}} items</p>
                <h5 class="text-white">Total products</h5>

              </div>
            </article>
          </div>
        </div>

        <h2 class="main-title">Payments</h2>
        <div class="row stat-cards">
            <div class="col-md-6 col-xl-3">
              <article class="stat-cards-item">
                <div class="stat-cards-icon primary">
                   <i class="fa-solid fa-sack-dollar"></i>
                </div>
                <div class="stat-cards-info">
                  <p class="stat-cards-info__num">{{number_format($totalprice)}} Kyats</p>
                  <h5 class="text-white">Total Prices</h5>

                </div>
              </article>
            </div>
            <div class="col-md-6 col-xl-3">
              <article class="stat-cards-item">
                <div class="stat-cards-icon warning">
                  <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <div class="stat-cards-info">
                  <p class="stat-cards-info__num">{{number_format($totaldeli)}} Kyats</p>
                  <h5 class="text-white">Total Deli Prices</h5>

                </div>
              </article>
            </div>
            <div class="col-md-6 col-xl-3">
              <article class="stat-cards-item">
                <div class="stat-cards-icon purple">
                  <i class="fa-regular fa-credit-card"></i>
                </div>
                <div class="stat-cards-info">
                  <p class="stat-cards-info__num">{{number_format($cardprice)}} Kyats</p>
                  <h5 class="text-white">Card Payment</h5>

                </div>
              </article>
            </div>
            <div class="col-md-6 col-xl-3">
              <article class="stat-cards-item">
                <div class="stat-cards-icon success">
                  <i class="fa-solid fa-house"></i>
                </div>
                <div class="stat-cards-info">
                  <p class="stat-cards-info__num">{{number_format($homeprice)}} Kyats</p>
                  <h5 class="text-white">Home Payment</h5>

                </div>
              </article>
            </div>
          </div>


        <h2 class="main-title">Orders </h2>
        <div class="row stat-cards">
            <div class="col-md-6 col-xl-3">
              <article class="stat-cards-item">
                <div class="stat-cards-icon primary">
                    <i class="fa-solid fa-box"></i>
                </div>
                <div class="stat-cards-info">
                  <p class="stat-cards-info__num">{{$order}} orders</p>
                  <h5 class="text-white">Total Orders</h5>

                </div>
              </article>
            </div>
            <div class="col-md-6 col-xl-3">
              <article class="stat-cards-item">
                <div class="stat-cards-icon warning">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="stat-cards-info">
                  <p class="stat-cards-info__num">{{$orderarrive}} items</p>
                  <h5 class="text-white">Total Arrived</h5>

                </div>
              </article>
            </div>
            <div class="col-md-6 col-xl-3">
              <article class="stat-cards-item">
                <div class="stat-cards-icon purple">
                  <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="stat-cards-info">
                  <p class="stat-cards-info__num">{{$orderreject}} items</p>
                  <h5 class="text-white">Total Reject</h5>

                </div>
              </article>
            </div>
          </div>


          <table class="table table-primary  text-center table-striped table-hover table-bordered border-dark caption-top">
            <caption style="color:white; font-size:25px">The most order customer lists Table</caption>
            <thead class="table-dark">
              <tr>
                <th >No</th>
                <th >Name</th>
                <th>Image</th>
                <th>Order time</th>
                <th >Total Price</th>
               
              </tr>
            </thead>
            <tbody>
                @foreach ($customerCounts as $key=>$item)
                    <tr class="">
                        <td>{{$key + 1}}</td>
                        <td>{{$item->name}}</td>
                        <td>
                            @if ($item->image == null)
                                @if ($item->gender == 'male')
                                    <img src="{{asset('images/default male.avif')}}" height="50px" width="80px">
                                @else
                                    <img src="{{asset('images/girl photo.jpg')}}"  height="50px" width="80px">
                                @endif
                            @else
                                <img src="{{asset('storage/'.$item->image)}}"  height="50px" width="80px">
                            @endif
                        </td>
                        <td>{{$item->user_count}} times</td>
                        <td>{{number_format($item->totalPrice)}} Kyats</td>

                    </tr>

                @endforeach
            </tbody>
          </table>
      </div>
    </main>
@endsection
