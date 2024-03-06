<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    {{-- bootstrap link --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        *{
            margin: 0;
            padding: 0;
            outline: none;
            font-family: 'Poppins', sans-serif;
        }
        body{

            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 110vh;
            background-image: linear-gradient(to bottom right, rgb(127, 122, 122), rgb(167, 167, 119),rgb(129, 79, 79));
        }
        .container{
            width: 430px;
            background: #fff;
            border-radius: 5px;
            text-align: center;
            padding: 20px 35px 30px 35px;
        }
        .container header{
            font-size: 35px;
            font-weight: 500;
            margin-bottom: 30px
        }
        .form-outer{
            width: 100%;
            overflow: hidden;
        }
        .form-outer form{
            display: flex;
            width: 400%;
        }
        form .page{
            width: 25%;
            transition: margin-left 0.3s;
        }
        .page .title{
            text-align: left;
            font-size: 25px;
            font-weight: 500
        }
        .field{
            width: 330px;
            height: 45px;
            margin:20px 0 60px 5px;
        }
        .container .step{
            position: relative
           align-items: center;
           width: 100%;
        }
        .step:last-child .bullet:before,.bullet:after{
            display: none;
        }
        .bullet::before,.bullet::after{
            position: absolute;
            content: "";
            right: -75px;
            top: 10px;
            height: 3px;
            width:60px;
            background: #262626;
            transition: .3s ease-in-out;
        }

        .bullet.active:after,.bullet.active::before{
           background: white

        }

        .bullet{
            height: 25px;
            width: 25px;
            border: 2px solid black;
            border-radius: 50%;
            display: inline-block;
            line-height: 25px;
            position: relative;
            transition: .2s;
        }
        .bullet.active{
            border-color: #d43f8d;
            background: #d43f8d;

        }
        .bullet span{
            position: absolute;
            left: 50%;
            transform: translateX(-50%)
        }
        .bullet.active span{
            display: none;
        }
        .step .check{
            position: absolute;
            top: 270px;
            transform: translate(-130%,-50%);
            display: none;
            transition: 0.2s
        }
        .step .check.active{
            display: inline;
            color: white;
        }
        .step .text.active{
            color: #d43f8d;
        }

    </style>
</head>
<body>
    <div class="container">
        <a href="{{route('welcome')}}" class="float-end">
            <i class="fa-solid fa-xmark text-dark fa-2x"></i>
        </a>
        <div class="text-center"><img src="{{asset('images/2090259-removebg-preview.png')}}" class="w-25"></div>
        <header class="">Create your account</header>
        <div class="bar d-flex my-3">
            <div class="step">
                <div class="text fw-bolder">Name</div>
                <div class="bullet mt-2 ">
                    <span><i class="fa-solid fa-user"></i></span>
                </div>
                <span class="check"><i class="fa-solid fa-check"></i></span>
            </div>
            <div class="step">
                <div class="text fw-bolder">Content</div>
                <div class="bullet mt-2">
                    <span><i class="fa-solid fa-envelope"></i></span>
                </div>
                <span class="check"><i class="fa-solid fa-check"></i></span>
            </div>
            <div class="step">
                <div class="text fw-bolder">Password</div>
                <div class="bullet mt-2">
                    <span><i class="fa-solid fa-lock"></i></span>
                </div>
                <span class="check"><i class="fa-solid fa-check"></i></span>
            </div>

        </div>
        <div class="form-outer text-start">
            <form action="{{route('register')}}" method="POST">
                @csrf
                <div class="page page1">
                    <div class="title">Basic info:</div>
                    <div class="field ">
                       <div class=" mb-2">Name</div>
                       <input type="text" name="name" class="form-control @error('name') is-invalid  @enderror" placeholder="Enter name">
                       @error('name')
                        <small class="text-danger">{{$message}}</small>
                       @enderror
                    </div>

                    <div class="field">
                        <div class=" mb-2">Gender</div>
                        <select name="gender" class="form-control @error('gender') is-invalid   @enderror">
                            <option value="">Choose gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        @error('gender')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                     </div>

                     <div class="mb-3">
                        <button class="btn btn-dark rounded w-50 next" type="button">{{__('welcome.next')}}</button>
                     </div>
                     <div>Have you already been Account? <a href="{{route('loginPage')}}">{{__('welcome.login')}}</a></div>
                </div>

                <div class="page">
                    <div class="title">Content info:</div>
                    <div class="field">
                       <label class=" mb-2">Email</label>
                       <input type="email" name="email" class="form-control @error('email') is-invalid  @enderror" placeholder="Enter email">
                       @error('email')
                        <small class="text-danger">{{$message}}</small>
                       @enderror
                    </div>

                    <div class="field">
                        <label class=" mb-2">Phone</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid   @enderror" oninput="formatPhoneNumber(this)" placeholder="Enter phone">
                        @error('phone')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                     </div>

                     <div class="field btns">
                        <button class="prev-1  btn btn-success rounded" type="button">{{__('welcome.previous')}}</button>
                        <button class="next-1  btn btn-dark rounded w-25" type="button">{{__('welcome.next')}}</button>
                     </div>
                </div>

                <div class="page">
                    <div class="title">Password info:</div>
                    <div class="field">
                       <label class=" mb-2">Password</label>
                       <input type="password" name="password" class="form-control @error('password') is-invalid  @enderror" placeholder="Enter password">
                       @error('password')
                       <small class="text-danger">{{$message}}</small>
                       @enderror
                    </div>

                    <div class="field">
                        <label class=" mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Enter confirm password">
                        @error('password_confirmation')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                     </div>

                     <div class="field btns">
                        <button class="prev-2  btn btn-success rounded " type="button">{{__('welcome.previous')}}</button>
                        <button class=" btn btn-dark rounded w-50" type="submit">{{__('welcome.create')}}</button>
                     </div>
                </div>


            </form>
        </div>
    </div>

    <script>
      $(document).ready(function(){
        $page = $('.page1');
        $next = $('.next');
        $next1 = $('.next-1')
        $prev1 = $('.prev-1')
        $prev2 = $('.prev-2')
        let progressText = document.querySelectorAll('.step .text');
        let progressCheck = document.querySelectorAll('.step .check')
        let bullet = document.querySelectorAll('.step .bullet')
        let current=1
        $next.click(function(){
            $page.css('margin-left','-25%')
            bullet[current -1].classList.add('active');
            progressCheck[current -1].classList.add('active');
            progressText[current -1].classList.add('active');
            current +=1
        })
        $next1.click(function(){
            $page.css('margin-left','-50%')
            bullet[current -1].classList.add('active');
            progressCheck[current -1].classList.add('active');
            progressText[current -1].classList.add('active');
            current +=1
        })
        $prev1.click(function(){
            $page.css('margin-left','0')
            bullet[current -2].classList.remove('active');
            progressCheck[current -2].classList.remove('active');
            progressText[current -2].classList.remove('active');
            current -=1
        })
        $prev2.click(function(){
            $page.css('margin-left','-25%')
            bullet[current -2].classList.remove('active');
            progressCheck[current -2].classList.remove('active');
            progressText[current -2].classList.remove('active');
            current -=1
        })
      })

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
    </script>
</body>
</html>
