<!DOCTYPE html>
<html lang="en">

<head>
    <title>NS Shop.com</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="{{asset('assets/img/apple-icon.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.ico')}}">

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/templatemo.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="{{asset('assets/css/fontawesome.min.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow bar ">
        <div class="d-flex ">
            <div class="" style="margin-right: 50px; margin-left:100px">

                <a class="navbar-brand logo h2  text-dark" href="{{route('deli#homePage')}}">
                    <img src="{{asset('images/2090259-removebg-preview.png')}}" class="logo">
                   NS Shop Delivery
                </a>

            </div>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">


                   <form action="{{route('deli#homePage')}}" method="GET" id="submit">
                    @csrf
                   <div class="searchContainer">
                    <div class="searchIcon">
                        <button class="searchIcon" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                        <input type="text" class=" searchBar" placeholder="Search order code" name="key" value="{{request('key')}}">
                    <div class="cleanIcon">
                        <i class="fa-solid fa-xmark"></i>
                     </div>


                   </div>

                </form>




                <div class=" login  " style="width: 400px">
                    <div class="userProfile">
                       <div class="d-flex align-items-center ">
                            @if (Auth::user()->image == null)
                        <div class="" style="width: 30px">
                            @if (Auth::user()->gender == 'male')
                                <img src="{{asset('images/default male.avif')}}" class="rounded-circle" width="100%">
                            @else
                                <img src="{{asset('images/girl photo.jpg')}}" class="rounded-circle" width="100%">
                            @endif
                        </div>
                        @else
                        <div class="" style="width: 30px;">
                            <img src="{{asset('storage/'.Auth::user()->image)}}" class=" rounded-circle" width="100%" height="35px">
                        </div>
                        @endif

                        <div class="ms-2 text-white userText">
                           <small class=" d-block"> Hello {{Str::words(Auth::user()->name,3)}}</small>
                            <small>Order & Account</small>
                        </div>
                       </div>
                       <div class="userList ">

                            <div class="d-flex mb-2">
                                <i class="fa-regular fa-face-smile-beam icon"></i>
                                <a href="{{route('deli#profilePage')}}"><span class="ms-3">Manage My Account</span></a>
                            </div>



                        <div class="d-flex mb-2">
                            <i class="fa-solid fa-arrow-right-from-bracket icon"></i>
                            <form action="{{route('logout')}}" method="POST" >
                                @csrf
                                <input type="submit" value="Logout" class="logout">
                                </form>
                        </div>
                       </div>
                    </div>

                    <div class="text-white ms-3">
                        <a href="{{route('chatify')}}" class="position-relative text-white">
                            <i class="fa-brands fa-facebook-messenger"></i>
                            <span class=" badge-pill ms-3  rounded-circle text-white bg-danger text-center" >{{$message_count}}</span>
                        </a>

                    </div>
                    <div class=" text-white ms-4">
                        <a href="{{route('user#notiPage')}}" class="position-relative ">
                            <i class="fa-solid fa-bell text-white " ></i>
                            <span class=" badge-pill ms-3  rounded-circle text-white bg-danger text-center" >{{$deli_count}}</span>
                        </a>
                    </div>
                    <div class="lang text-white ms-4">
                        <i class="fa-solid fa-earth-americas"></i>
                        <div class="langiList ">
                            <a class="d-flex mb-1 position-relative" href="{{route('user#notiPage')}}">
                                <img src="{{asset('images/united-kingdom.png')}}" height="20px" width="20px" class="mt-1">
                                <span class="ms-4">English</span>
                            </a>
                            <a class="d-flex mb-2 position-relative" href="{{route('user#ordernotiPage')}}">
                                <img src="{{asset('images/myanmar.png')}}" height="20px" width="20px" class="mt-1">
                                <span class="ms-4">Myanmar</span>

                            </a>
                        </div>
                    </div>

                   
                </div>

            </div>

        </div>
    </nav>
    <!-- Close Header -->

    @yield('text')

    <!-- Start Footer -->
    <footer class="bg-dark" id="tempaltemo_footer">
        <div class="container">
            <div class="row">

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-success border-bottom pb-3 border-light logo">NS Shop</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li>
                            <i class="fas fa-map-marker-alt fa-fw"></i>
                            Magway Chauk Myanmar
                        </li>
                        <li>
                            <i class="fa fa-phone fa-fw"></i>
                            <a class="text-decoration-none" href="tel:010-020-0340">O9 956197161</a>
                        </li>
                        <li>
                            <i class="fa fa-envelope fa-fw"></i>
                            <a class="text-decoration-none" href="mailto:info@company.com">nyisittmarn235278@gmail.com</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Products</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none" href="#">Luxury</a></li>
                        <li><a class="text-decoration-none" href="#">Sport Wear</a></li>
                        <li><a class="text-decoration-none" href="#">Men's Shoes</a></li>
                        <li><a class="text-decoration-none" href="#">Women's Shoes</a></li>
                        <li><a class="text-decoration-none" href="#">Popular Dress</a></li>
                        <li><a class="text-decoration-none" href="#">Gym Accessories</a></li>
                        <li><a class="text-decoration-none" href="#">Sport Shoes</a></li>
                    </ul>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Further Info</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none" href="#">Home</a></li>
                        <li><a class="text-decoration-none" href="#">About Us</a></li>
                        <li><a class="text-decoration-none" href="#">Shop Locations</a></li>
                        <li><a class="text-decoration-none" href="#">FAQs</a></li>
                        <li><a class="text-decoration-none" href="#">Contact</a></li>
                    </ul>
                </div>

            </div>


        </div>



    </footer>
    <!-- End Footer -->

    <!-- Start Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('assets/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/templatemo.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>

    @yield('script')
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

        // phone script
        function formatPhoneNumber(input) {
        // Remove non-numeric characters
        let phoneNumber = input.value.replace(/\D/g, '');

        // Ensure the phone number starts with "09"
        if (!phoneNumber.startsWith('09')) {
            phoneNumber = '09' + phoneNumber;
        }

        // Update the input value
        input.value = phoneNumber;
    }

        $(document).ready(function(){
            $('.searchBar').on('input',function(){
                var cleanIcon = $(this).siblings('.cleanIcon');
            if ($(this).val().trim() !== '') {
                cleanIcon.css('display', 'block');
            } else {
                cleanIcon.css('display', 'none');
            }
            })

            $('.cleanIcon').click(function(){
                $('.searchBar').val('');
                $(this).css('display', 'none');
            })
        })
    </script>


    <!-- End Script -->
</body>

</html>

