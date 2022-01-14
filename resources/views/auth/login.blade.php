<!DOCTYPE html>

<html lang="en">

<head>

    <title>Speed | Login </title>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

<!--===============================================================================================-->

    <link rel="icon" type="image/png" href="{{ asset('login_assets/images/icons/favicon.ico') }}"/>

<!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/bootstrap/css/bootstrap.min.css') }} ">

<!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }} ">

<!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/fonts/iconic/css/material-design-iconic-font.min.css') }} ">

<!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/animate/animate.css') }} ">

<!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/css-hamburgers/hamburgers.min.css') }} ">

<!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/animsition/css/animsition.min.css') }} ">

<!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/select2/select2.min.css') }} ">

<!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/daterangepicker/daterangepicker.css') }} ">

<!--===============================================================================================-->

    <link rel="stylesheet" type="text/css" href="{{ asset('css/parsley.css') }} ">

    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/css/util.css') }} ">

    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/css/main.css') }} ">

<!--===============================================================================================-->

<style type="text/css">
    .lang_list{
        margin-top: -50px;
        margin-right: -45px;
        float: right;
    }
    .lang_list li{
        display: inline-block;
        padding: 0px 5px;
    }
    .lang_link{
        font-size: 11px;
        color: #fff;
        text-decoration: underline;
    }
    .lang_list .active{
        color: #41b7d2;
    }

</style>

</head>

<body>

    <?php
$users = App\Library\Common\MyLib::getUsersList();
?>

    <div class="limiter">

        <!-- <div class="container-login100" style="background-image: url('public/login_assets/images/bg-01.jpg');"> -->

        <div class="container-login100" style="background-color: #F1D4F1;">

            <div class="wrap-login100">

                <ul class="lang_list">
                    <li><a href="{{ route('show_login_form', 'en') }}" class="lang_link active">English</a></li>
                    <li style="border-left: 1px solid #fff;"><a href="{{ route('show_login_form', 'ar') }}" class="lang_link">Arabic</a></li>
                </ul>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif



                <form class="login100-form validate-form" method="POST" action="{{route('login')}}">



                    {{ csrf_field() }}

                    <span class="login100-form-logo">

                       <!--  <i class="zmdi zmdi-landscape"></i> -->

                       <img src="{{URL::to('public/assets/logos/logo_white.png')}}" style="max-width: 150px;">

                    </span>



                    <span class="login100-form-title p-b-34 p-t-27">

                        @lang('adminlte.login')

                    </span>



                    <div class="wrap-input100 validate-input" data-validate = "Enter username">

                        <input class="input100" type="text" name="username" placeholder="@lang('adminlte.username')">

                        <span class="focus-input100" data-placeholder="&#xf207;"></span>

                    </div>



                    <div class="wrap-input100 validate-input" data-validate="Enter password">

                        <input class="input100" type="password" name="password" placeholder="@lang('adminlte.password')">

                        <span class="focus-input100" data-placeholder="&#xf191;"></span>

                    </div>



                    <div class="contact100-form-checkbox">

                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">

                        <label class="label-checkbox100" for="ckb1">

                            @lang('adminlte.remember_me')

                        </label>

                    </div>



                    <div class="container-login100-form-btn">

                        <button class="login100-form-btn">

                            @lang('adminlte.login')

                        </button>

                    </div>



                    <div class="text-center p-t-50">

                        <a href="#" data-toggle="modal" data-target="#forgotpasswordmodal" class="txt1 pull-left"> @lang('adminlte.forgot_your_password') </a>

                        <a href="#" data-toggle="modal" data-target="#signupmodal" class="txt1 pull-right"> @lang('adminlte.sign_up') </a>

                    </div>
                    <div class="text-center p-t-50">

                        <a href="#" data-toggle="modal" data-target="#resendemailmodal" class="txt1 pull-left"> @lang('adminlte.resend_account_activation_email') </a>

                    </div>

                </form>

            </div>

        </div>

    </div>




<div class="modal fade" id="resendemailmodal">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-body " style="background: -webkit-linear-gradient(top, #39393a, #054f92) !important;">

                <form class="form-horizontal" action="{{ route('resend_activation_email') }}" method="POST" style="margin-top: 20px !important;" >



                    {{ csrf_field() }}





                    <div class="row">

                        <div class="col-md-4">



                            <label class="txt1" for="email">@lang('adminlte.email')</label>



                        </div>



                        <div class="col-md-8">

                            <input type="email" name="email" class="form-control"/>

                        </div>



                    </div>
                    <br/>
                    <div class="row">

                        <div class="form-group col-lg-12">

                            <button style="float: right" type="submit" class="btn btn-success ">@lang('adminlte.resend_account_activation_email')</button>



                            <a style="float: right; margin-right: 5px" href="#" data-dismiss="modal" class="btn btn-primary">@lang('adminlte.cancel')</a>



                        </div>



                    </div>



                </form>

            </div>

        </div>

        <!-- /.modal-content -->

    </div>

      <!-- /.modal-dialog -->

</div>

<div class="modal fade" id="forgotpasswordmodal">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-body " style="background: -webkit-linear-gradient(top, #39393a, #054f92) !important;">

                <form class="form-horizontal" action="{{ route('password.email') }}" method="POST" style="margin-top: 20px !important;" >



                    {{ csrf_field() }}





                    <div class="row">

                        <div class="col-md-4">



                            <label class="txt1" for="email">@lang('adminlte.email')</label>



                        </div>



                        <div class="col-md-8">

                            <input type="email" name="email" class="form-control"/>

                        </div>



                    </div>



                    <br/>



                    <div class="row">



                        <div class="form-group col-lg-12">



                            <button style="float: right" type="submit" class="btn btn-success "  onClick="this.form.submit(); this.disabled=true; this.value='Sending…';">@lang('adminlte.email')</button>



                            <a style="float: right; margin-right: 5px" href="#" data-dismiss="modal" class="btn btn-primary">@lang('adminlte.cancel')</a>



                        </div>



                    </div>



                </form>

            </div>

        </div>

        <!-- /.modal-content -->

    </div>

      <!-- /.modal-dialog -->

</div>





<div class="modal fade mymodal" id="signupmodal" style="">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-body " style="background: -webkit-linear-gradient(top, #39393a, #054f92) !important;">

                @if (session('status'))

                    <div class="alert alert-success">

                        {{ session('status') }}

                    </div>

                @endif



                @if (count($errors) > 0)

                    <div class="alert alert-danger">

                        <ul>

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif
                <form class="form-horizontal" action="{{ route('user_register') }}" method="POST" id="bidding_form" data-parsley-validate="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <label class="txt1" for="name">@lang('adminlte.restaurant_name')</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="@lang('adminlte.restaurant_name')" required=""/>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="txt1" for="name">@lang('adminlte.restaurant_type')</label>
                            <input type="text" name="restaurant_type" class="form-control" value="{{ old('restaurant_type') }}" placeholder="@lang('adminlte.restaurant_type')" required=""/>
                        </div>
                        <div class="col-md-6">
                            <label class="txt1" for="name">@lang('adminlte.phone_number')</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}" class="form-control" placeholder="@lang('adminlte.phone_number')" required=""/>
                        </div>
                    </div>
                    <br/>
                    <div class="row">

                        <div class="col-md-6">
                            <label class="txt1" for="name">@lang('adminlte.store_manager_name')</label>
                            <input type="text" name="store_manager_name" value="{{ old('store_manager_name') }}" class="form-control" placeholder="@lang('adminlte.store_manager_name')" required=""/>
                        </div>
                        <div class="col-md-6">
                            <label class="txt1" for="name">@lang('adminlte.store_manager_number')</label>
                            <input type="text" name="store_manager_number" value="{{ old('store_manager_number') }}" class="form-control" placeholder="@lang('adminlte.store_manager_number')" data-parsley-type="digits"  required=""/>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="txt1" for="email">@lang('adminlte.email')</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="@lang('adminlte.email')" required=""/>
                        </div>
                        <div class="col-md-6">
                            <label class="txt1" for="username">@lang('adminlte.username')</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="@lang('adminlte.username')" required=""/>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="txt1" for="password">@lang('adminlte.password')</label>
                            <input type="password" minlength="8" name="password" class="form-control" minlength="8"  placeholder="@lang('adminlte.password_min')" required="" />
                        </div>
                        <div class="col-md-6">
                            <label class="txt1" for="password_confirmation">@lang('adminlte.confirm_password')</label>
                            <input type="password" name="password_confirmation" class="form-control" minlength="8" placeholder="@lang('adminlte.confirm_password')"required="" />
                        </div>
                    </div>
                    <br/>
                    <div class="row">

                        <div class="col-md-6">
                            <label class="txt1" for="name">@lang('adminlte.country')</label>
                            <input type="text" name="country" class="form-control" value="Saudi Arabia" required="" readonly="" />
                        </div>
                        <div class="col-md-6">
                            <label class="txt1" for="city">@lang('adminlte.city')</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city') }}" placeholder="@lang('adminlte.city')" required=""/>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="txt1" for="region">@lang('adminlte.region')</label>
                            <select class="form-control" name="region" required="">
                                <option value=""> -- </option>
                                <option value="Al Bahah" {{ (old("region") == "Al Bahah" ? "selected":"") }}> Al Bahah </option>
                                <option value="Al Jawf" {{ (old("region") == "Al Jawf" ? "selected":"") }}> Al Jawf </option>
                                <option value="Mecca" {{ (old("region") == "Mecca" ? "selected":"") }}> Mecca </option>
                                <option value="Riyadh" {{ (old("region") == "Riyadh" ? "selected":"") }}> Riyadh </option>
                                <option value="Eastern Province" {{ (old("region") == "Eastern Province" ? "selected":"") }}> Eastern Province </option>
                                <option value="Jizan" {{ (old("region") == "Jizan" ? "selected":"") }}> Jizan </option>
                                <option value="Medina" {{ (old("region") == "Medina" ? "selected":"") }}> Medina </option>
                                <option value="Qasim" {{ (old("region") == "Qasim" ? "selected":"") }}> Qasim </option>
                                <option value="Tabuk" {{ (old("region") == "Tabuk" ? "selected":"") }}> Tabuk </option>
                                <option value="Ha'il" {{ (old("region") == "Ha'il" ? "selected":"") }}> Ha'il </option>
                                <option value="Narjan" {{ (old("region") == "Narjan" ? "selected":"") }}> Narjan </option>
                                <option value="Northern Borders" {{ (old("region") == "Northern Borders" ? "selected":"") }}> Northern Borders </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="txt1" for="city">@lang('adminlte.restaurant_location')</label>
                            <input type="text" name="restaurant_location" id="autocomplete" class="form-control" placeholder="@lang('adminlte.restaurant_location')" onfocus="initAutocomplete()" required=""/>
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="txt1" for="name">@lang('adminlte.commercial_reg_no')</label>
                            <input type="text" name="commercial_reg_no" value="{{ old('commercial_reg_no') }}" class="form-control" placeholder="@lang('adminlte.commercial_reg_no')" required=""/>
                        </div>
                        <div class="col-md-6">
                            <label class="txt1" for="name">@lang('adminlte.restaurant_logo')</label>
                            <input type="file" name="profile_picture" class="form-control" placeholder="Restaurant Logo"/>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <button style="float: right" type="submit" class="btn btn-success "  id="submit_btn"  >@lang('adminlte.sign_up')</button>
                            <a style="float: right; margin-right: 5px" href="#" data-dismiss="modal" class="btn btn-primary">@lang('adminlte.cancel')</a>
                        </div>
                    </div>
                </form>

            </div>

        </div>

        <!-- /.modal-content -->

    </div>

      <!-- /.modal-dialog -->

</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0gM2XxUXHXZXHO3MVrjeGHpHYeOyII-M&libraries=places&callback=initAutocomplete"
        async defer></script>
<!--===============================================================================================-->

    <!-- <script src="{{ asset('login_assets/vendor/jquery/jquery-3.2.1.min.js') }}  "></script> -->

<!--===============================================================================================-->

    <script src="{{ asset('login_assets/vendor/animsition/js/animsition.min.js') }}  "></script>

<!--===============================================================================================-->

    <script src="{{ asset('login_assets/vendor/bootstrap/js/popper.js') }}  "></script>

    <script src="{{ asset('login_assets/vendor/bootstrap/js/bootstrap.min.js') }}  "></script>

<!--===============================================================================================-->

    <script src="{{ asset('login_assets/vendor/select2/select2.min.js') }}  "></script>

<!--===============================================================================================-->

    <script src="{{ asset('login_assets/vendor/daterangepicker/moment.min.js') }} "></script>

    <script src="{{ asset('login_assets/vendor/daterangepicker/daterangepicker.js') }} "></script>

<!--===============================================================================================-->

    <script src="{{ asset('login_assets/vendor/countdowntime/countdowntime.js') }} "></script>

<!--===============================================================================================-->

    <script src="{{ asset('/js/parsley.min.js') }} "></script>

    <script src="{{ asset('login_assets/js/main.js') }} "></script>
    <style>
        .pac-container {
            z-index: 10000 !important;
        }
    </style>

    <script type="text/javascript">
        @if (session('open_register'))
            @if(session('open_register') == true)
                $(window).on('load',function(){
                    $('#signupmodal').modal('show');
                });
            @endif
        @endif
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#submit_btn").on('click', function(e){
                e.preventDefault();
                var form = $("#bidding_form");

                //var form = $(this);

                form.parsley().validate();

                if (form.parsley().isValid()){
                    // alert('valid');
                    form.submit();
                }
            });
        });
    </script>
    <script type="text/javascript">

        var placeSearch, autocomplete;

        function initAutocomplete() {
          autocomplete = new google.maps.places.Autocomplete(
              document.getElementById('autocomplete'), {types: ['establishment']});
          autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
          var place = autocomplete.getPlace();

            document.getElementById("autocomplete").value = place.formatted_address;
            document.getElementById("latitude").value = place.geometry.location.lat();
            document.getElementById("longitude").value = place.geometry.location.lng();
        }

        $(document).ready(function(){

            function alignModal(){

                var modalDialog = $(this).find(".modal-dialog");

                /* Applying the top margin on modal dialog to align it vertically center */

                modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));

            }

            // Align modal when it is displayed

            $(".modal").on("shown.bs.modal", alignModal);



            // Align modal when user resize the window

            $(window).on("resize", function(){

                $(".modal:visible").each(alignModal);

            });


        });



</script>



</body>

</html>