<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NS Shop.com</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{asset('admin/img/svg/logo.svg')}}" type="image/x-icon">
  <!-- Custom styles -->
  <link rel="stylesheet" href="{{asset('admin/css/style.min.css')}}">
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- bootstrap datetime picker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/smalot-bootstrap-datetimepicker/2.4.4/css/bootstrap-datetimepicker.min.css" integrity="sha512-m9g5oqvMhf2FsilNZqftBnOR1GW+dJpb1a8RN+R3Aw1dVI2AeDfpSOa9Sm48xMacONC1vJlM2iIadPy4uLEC4Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body style="background: rgb(18, 18, 18)" >
  <div class="layer"></div>
<!-- ! Body -->
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex" >
<!------------------- ! Sidebar --------------->
  <aside class="sidebar bg-secondary"  >
    <div class="sidebar-start " >
        <div class="sidebar-head">
            <a href="/" class="logo-wrapper text-decoration-none" title="Home">
                <span class="sr-only">Home</span>
                <span class="icon logo" aria-hidden="true"></span>
                <div class="logo-text">
                    <span class="logo-title ">NS Shop</span>
                    <span class="logo-subtitle ">{{Auth::user()->name}}</span>
                </div>

            </a>
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle" aria-hidden="true"></span>
            </button>
        </div>
        <div class="sidebar-body">
            <ul class="sidebar-body-menu">
    {{-- Dashboard start --}}
                <li>
                    <a class="active text-decoration-none " href="{{route('admin#homePage')}}"><span class="icon home" aria-hidden="true"></span>{{__('welcome.dashboard')}}</a>
                </li>
    {{-- Dashboard start --}}

    {{--product start--}}
                <li>
                    <a class="active show-cat-btn text-decoration-none" href="##">
                        <span class="icon document" aria-hidden="true"></span>{{__('welcome.product')}}
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a href="{{route('product#create')}}" class=" text-decoration-none "><i class="fa-brands fa-product-hunt me-3"></i>{{__('welcome.newproduct')}}</a>
                        </li>
                        <li>
                            <a href="{{route('product#show')}}" class=" text-decoration-none "><i class="fa-solid fa-list-ol me-3"></i>{{__('welcome.allproduct')}}</a>
                        </li>
                        <li>
                            <a href="{{route('flashSalePage')}}" class=" text-decoration-none "><i class="fa-solid fa-stopwatch me-3"></i></i>Flash Sale</a>
                        </li>
                    </ul>
                </li>
    {{--product end--}}

    {{-- category start --}}
                <li>
                    <a class="show-cat-btn text-decoration-none active" href="##">
                        <span class="icon folder" aria-hidden="true"></span>{{__('welcome.category')}}
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a href="{{route('category#create')}}" class="text-decoration-none"> <i class="fa-solid fa-circle-plus" style="margin-right: 10px;"></i>{{__('welcome.categorycreate')}}</a>
                        </li>
                        <li>
                            <a href="{{route('category#show')}}" class="text-decoration-none" > <i class="fa-solid fa-list" style="margin-right: 10px;"></i>{{__('welcome.categoryshow')}}</a>
                        </li>
                    </ul>
                </li>
    {{-- category end --}}

    {{-- notification start --}}
                <li>
                    <a class="show-cat-btn text-decoration-none active" href="##">
                        <span class="icon notification" aria-hidden="true"></span>{{__('welcome.notification')}}
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="msg-counter">{{$unread_noti}}</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li class="" >
                            <a href="{{route('admin#notiShow')}}" class=" text-decoration-none"> <i class="fa-solid fa-star me-3"></i>{{__('welcome.reviews')}} <span class="msg-counter">{{$unread_rating}}</span></a>
                        </li>
                        <li>
                            <a href="{{route('admin#notiQuesShow')}}" class=" text-decoration-none"><i class="fa-solid fa-message me-3"></i>{{__('welcome.comments')}}<span class="msg-counter">{{$unread_comment}}</span></a>
                        </li>
                    </ul>
                </li>
     {{-- notification end --}}
     {{-- order start --}}
                <li>
                    <a href="{{route('admin#orderPage')}}" class=" text-decoration-none active">
                        <span class="icon document" aria-hidden="true"></span>
                        {{__('welcome.orders')}}<span class="msg-counter">{{$order_count}}</span>
                    </a>

                </li>
      {{-- order end--}}
            </ul>

            <ul class="sidebar-body-menu">
            {{-- Post start --}}
                <li>
                    <a href="{{route('admin#postCreate')}}" class=" text-decoration-none active">
                        <span class="icon edit" aria-hidden="true"></span>{{__('welcome.posts')}}
                    </a>
                </li>
            {{-- Post end --}}
    {{-- member list start --}}
                <li>
                    <a class="show-cat-btn text-decoration-none active" href="##" >
                        <span class="icon user-3" aria-hidden="true"></span>{{__('welcome.members')}}
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a href="{{route('admin#userlistsPage')}}" class=" text-decoration-none"><i class="fa-solid fa-user-tie me-3"></i>{{__('welcome.userlist')}}</a>
                        </li>
                        <li>
                            <a href="{{route('admin#delilistPage')}}" class=" text-decoration-none"><i class="fa-solid fa-person-biking me-3"></i>{{__('welcome.delilist')}}</a>
                        </li>
                        <li>
                            <a href="{{route('admin#adminlistPage')}}" class=" text-decoration-none"><i class="fa-solid fa-user-secret me-3"></i>{{__('welcome.adminlist')}}</a>
                        </li>
                    </ul>
                </li>
    {{-- member list end --}}
    {{-- Profile start --}}
                <li>
                    <a class="show-cat-btn text-decoration-none active" href="##" >
                        <span class="icon setting" aria-hidden="true"></span>{{__('welcome.setting')}}
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                           <a href="{{route('admin#profileShow')}}" class=" text-decoration-none"><i class="fa-solid fa-user me-3"></i> {{__('welcome.pfshow')}}</a>
                        </li>
                        <li>
                            <a href="{{route('admin#profileEdit')}}" class=" text-decoration-none"><i class="fa-solid fa-pen me-3"></i>{{__('welcome.pfedit')}}</a>
                        </li>
                        <li style="width: 150px">
                            <a href="{{route('admin#passwordEdit')}}" class=" text-decoration-none"><i class="fa-solid fa-key me-3 "></i>{{__('welcome.pschange')}}</a>
                        </li>
                        <li >
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <a class=" text-decoration-none ">
                                    <button type="submit" class="bg-transparent text-white"><i class="fa-solid fa-right-from-bracket me-3"></i>{{__('welcome.logout')}}</button>
                                </a>
                            </form>
                        </li>

                    </ul>
                </li>
    {{-- Profile end --}}
            </ul>
        </div>
    </div>

</aside>
<!------------------- ! Sidebar --------------->

  <div class="main-wrapper" >
<!----------------- ! Main nav ----------------------------->
    <nav style="background:rgb(40, 1, 40)" >
  <div class="container main-nav d-flex" style="height: 100px" >
    <div class="" style="margin-bottom:430px; color:white; ">
      <h4 class="pt-2" >NS Shop Admin Dashboard</h4>
    </div>

    <div class="d-flex justify-content-center" style="margin-bottom: 400px; width:400px;">

      <div class="lang-switcher-wrapper me-3" >
        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:transparent" >

            <span class="nav-user-img bg-dark">
                <span style="color: white" title="language"><i class="fa-solid fa-globe"></i></span>
             </span>
          </a>
        <ul class="dropdown-menu " style=" background:darkgray">
          <li><a href="{{route('localization','en')}}" class="dropdown-item"><img src="{{asset('images/united-kingdom.png')}}" height="20px" width="20px" class="me-3"> English</a></li>
          <hr class="dropdown-divider">
          <li><a href="{{route('localization','my')}}" class="dropdown-item"><img src="{{asset('images/myanmar.png')}}" height="20px" width="20px" class="me-3"> Myanmar</a></li>

        </ul>
      </div>
      <div class=" me-3">
        <a href="{{route('chatify')}}" class=" text-decoration-none text-white">
        <span class="nav-user-img bg-dark">
            <i class="fa-brands fa-facebook-messenger"></i>
            <span class="badge badge-pill ms-3  rounded-circle" style="position: absolute; top:18px">{{$message_count}}</span>
             </span>
         </span>
      </a>
        </div>
{{-- notification page --}}
      <div class=" me-3">
            <a href="{{route('admin#notiShow')}}">
            <span class="nav-user-img bg-dark">
                <span class="icon notification" aria-hidden="true"></span>
              <span class="badge badge-pill ms-3  rounded-circle" style="position: absolute; top:18px">{{$unread_noti}}</span>
             </span>
          </a>
      </div>
{{-- notification page --}}
      <div class="nav-user-wrapper" >
        <a class=" dropdown-toggle d-flex" href="#" role="button" data-bs-toggle="dropdown" style="color:transparent" >

            <span class="nav-user-img">
                @if (Auth::user()->image == null)
                @if (Auth::user()->gender == 'male')
                <img src="{{asset('images/default male.avif')}}" >
                @else
                <img src="{{asset('images/girl photo.jpg')}}" alt="">
                @endif
                @else
                <img src="{{asset('storage/'.Auth::user()->image)}}" width="100%" height="100%">
                @endif

            </span>
          </a>

        <ul class="users-item-dropdown nav-user-dropdown dropdown-menu mt-3 " style="background: grey">
          <li><a href="{{route('admin#profileShow')}}" class="dropdown-item">
              <i data-feather="user" aria-hidden="true"></i>
              <span>{{__('welcome.profile')}}</span>
            </a></li>
            <hr class="dropdown-divider">
          <li><a href="{{route('admin#profileEdit')}}" class="dropdown-item">
            <i class="fa-solid fa-gear me-3"></i>
              <span>{{__('welcome.account')}}</span>
            </a></li>
            <hr class="dropdown-divider">
          <li>
            <a class="danger" href="##" class="dropdown-item">
                <form action="{{route('logout')}}" method="POST">
                    @csrf

                <button type="submit" style="background: transparent; margin-left:18px" ><i class="fa-solid fa-right-from-bracket" style="margin-right: 20px"></i>{{__('welcome.logout')}}
                </button>
            </form>
              </a>
        </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
<!-- -----------------! Main ------------------------------>

   @yield('content')


  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<!-- Chart library -->
<script src="{{asset('admin/plugins/chart.min.js')}}"></script>
<!-- Icons library -->
<script src="{{asset('admin/plugins/feather.min.js')}}"></script>
<!-- Custom scripts -->
<script src="{{asset('admin/js/script.js')}}"></script>
{{-- jquery link --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- ckeditor link --}}
<script src="{{asset('ckeditor5-build-classic/ckeditor.js')}}"></script>
{{-- bootstrap date time picker --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/smalot-bootstrap-datetimepicker/2.4.4/js/bootstrap-datetimepicker.min.js" integrity="sha512-4lTnmq2kNbykTiOPulgEvxRgqegB5/YMhMqaBWvxji/9wRgR9W/TSGF51/mIG1hQ6janxTojpr41y5/gaW9LRA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  {{-- moment js cdn
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js" integrity="sha512-hUhvpC5f8cgc04OZb55j0KNGh4eh7dLxd/dPSJ5VyzqDWxsayYbojWyl5Tkcgrmb/RVKCRJI1jNlRbVP4WWC4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
{{-- boxicon  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/dist/boxicons.js" integrity="sha512-kWH92pHUC/rcjpSMu19lT+H6TlZwZCAftg9AuSw+AVYSdEKSlXXB8o6g12mg5f+Pj5xO40A7ju2ot/VdodCthw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@yield('script');
<script>

    // Initialize Bootstrap Toast
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function (toastEl) {
      return new bootstrap.Toast(toastEl);
    });

    // Show the toast
    toastList.forEach(function (toast) {
      toast.show();
    });
  </script>
</body>

</html>
