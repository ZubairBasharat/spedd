<head>
    <!-- Copyright 2017 AdminLTE -->
    <meta charset="UTF-8">

    <title>
      @if(isset($title))
        {{ $title }}
      @else
        Speed
      @endif
    </title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="google" content="notranslate">

    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('login_assets/images/icons/apple-touch-icon.png')}}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('login_assets/images/icons/favicon-32x32.png')}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('login_assets/images/icons/favicon-16x16.png')}}">
	<link rel="manifest" href="{{asset('login_assets/images/icons/site.webmanifest')}}">
    <link rel="icon" type="image/png" href="{{asset('login_assets/images/icons/favicon.ico')}}"/>



    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- CSRF Token -->

    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css" />



    <link href="{{ asset('/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />



    <link href="{{ asset('/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />



    <link rel="stylesheet" type="text/css" href="{{asset('login_assets/fonts/font-awesome-4.7.0public/css/font-awesome.min.css')}}">



    <link rel="stylesheet" type="text/css" href="{{asset('login_assets/fonts/iconicpublic/css/material-design-iconic-font.min.css')}}">



    <link href="{{ asset('css/assembly.min.css') }}" rel="stylesheet" type="text/css" />



    <link href="{{ asset('css/mapbox-gl.css') }}" rel="stylesheet" type="text/css" />



    <link href="{{ asset('css/mapbox-gl-geocoder.css') }}" rel="stylesheet" type="text/css" />



    <link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />


    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" type="text/css" />


    <link href="{{ asset('css/tree.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/parsley.css') }} ">


    <link href="{{ asset('css/all.css') }}" rel="stylesheet" type="text/css" />



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->






    <style type="text/css">
        .active_restaurant{
            background: mediumaquamarine !important;
        }

        .active_restaurant_anchor {
            color: aliceblue !important;
        }
        
        .my-info-box{
            background: #ecf0f5 !important;
        }
    </style>

    <script>

        //See https://laracasts.com/discuss/channels/vue/use-trans-in-vuejs

        window.trans = @php

            // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable

            $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());

            $trans = [];

            foreach ($lang_files as $f) {

                $filename = pathinfo($f)['filename'];

                $trans[$filename] = trans($filename);

            }

            $trans['adminlte_lang_message'] = trans('adminlte_lang::message');

            echo json_encode($trans);

        @endphp

    </script>

</head>

