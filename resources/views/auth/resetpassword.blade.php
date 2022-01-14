<!DOCTYPE html>
<html lang="en">
<head>
    <title>CYF | Reset Password </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="{{URL::to('login_assets/images/icons/favicon.ico') }}"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{URL::to('/login_assets/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{URL::to('/login_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{URL::to('/login_assets/fonts/iconic/css/material-design-iconic-font.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{URL::to('/login_assets/vendor/animate/animate.css')}}">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="{{URL::to('/login_assets/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{URL::to('/login_assets/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{URL::to('/login_assets/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="{{URL::to('/login_assets/vendor/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{URL::to('/login_assets/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::to('/login_assets/css/main.css')}}">
<!--===============================================================================================-->
</head>
<body>
    
    <div class="limiter">
        <!-- <div class="container-login100" style="background-image: url('login_assets/images/bg-01.jpg');"> -->
        <div class="container-login100" style="background-color: #F1D4F1;">
            <div class="wrap-login100">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="login100-form validate-form" method="POST" action="{{route('reset_password')}}">
                   
                    {{ csrf_field() }}

                            
                    <input type="hidden" name="token" value="{{ $token }}">

                    
                    <span class="login100-form-logo">
                       <!--  <i class="zmdi zmdi-landscape"></i> -->
                       <img src="{{URL::to('assets/logos/logo.png')}}" style="max-width: 250px;">
                    </span>

                    <span class="login100-form-title p-b-34 p-t-27">
                        Reset Password
                    </span>

                    <div class="wrap-input100 validate-input" data-validate = "Enter email">
                        <input class="input100" type="text" name="email" placeholder="Email"  value="{{ old('email') }}">
                        <span class="focus-input100" data-placeholder="&#xf207;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="password" placeholder="Enter New Password">
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Confirm Password">
                        <input class="input100" type="password" name="password_confirmation" placeholder="Confirm Password">
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Reset
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    





    
<!--===============================================================================================-->
    <script src="{{URL::to('/login_assets/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{URL::to('/login_assets/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{URL::to('/login_assets/vendor/bootstrap/js/popper.js')}}"></script>
    <script src="{{URL::to('/login_assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{URL::to('/login_assets/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{URL::to('/login_assets/vendor/daterangepicker/moment.min.js')}}"></script>
    <script src="{{URL::to('/login_assets/vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{URL::to('/login_assets/vendor/countdowntime/countdowntime.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{URL::to('/login_assets/js/main.js')}}"></script>

</body>
</html>