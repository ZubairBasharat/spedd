<!DOCTYPE html>
<!--
Landing page based on Pratt: http://blacktie.co/demo/pratt/
-->
<html lang="en">
<head>
    

    <title>Landing Page</title>

    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/all-landing.css') }}" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

</head>

<body data-spy="scroll" data-target="#navigation" data-offset="50">

<div id="app" v-cloak>
    <!-- Fixed navbar -->
    <div id="navigation" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><b>adminlte-laravel</b></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#home" class="smoothScroll">{{ trans('adminlte_lang::message.home') }}</a></li>
                    <li><a href="#desc" class="smoothScroll">{{ trans('adminlte_lang::message.description') }}</a></li>
                    <li><a href="#showcase" class="smoothScroll">{{ trans('adminlte_lang::message.showcase') }}</a></li>
                    <li><a href="#contact" class="smoothScroll">{{ trans('adminlte_lang::message.contact') }}</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                        <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    @else
                        <li><a href="/home">{{ Auth::user()->name }}</a></li>
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>


    <section id="home" name="home">
        <div id="headerwrap">
            <div class="container">
                <div class="row centered">
                    <!-- <div class="col-lg-12">
                        <h1>Acacha <b><a href="https://github.com/acacha/adminlte-laravel">adminlte-laravel</a></b></h1>
                        <h3>A <a href="https://laravel.com/">Laravel</a> {{ trans('adminlte_lang::message.laravelpackage') }}
                            scaffolding/boilerplate {{ trans('adminlte_lang::message.to') }} <a href="https://almsaeedstudio.com/preview">AdminLTE</a> {{ trans('adminlte_lang::message.templatewith') }}
                            <a href="http://getbootstrap.com/">Bootstrap</a> 3.0 {{ trans('adminlte_lang::message.and') }} <a href="http://blacktie.co/demo/pratt/">Pratt</a> Landing page</h3>
                        <h3><a href="{{ url('/register') }}" class="btn btn-lg btn-success">{{ trans('adminlte_lang::message.gedstarted') }}</a></h3>
                    </div> -->
                    <div class="col-lg-2">
                        
                    </div>
                    <div class="col-lg-8">
                        <img class="img-responsive" src="{{ asset('/img/app-bg.png') }}" alt="">
                    </div>
                    <div class="col-lg-2">
                        
                    </div>
                </div>
            </div> <!--/ .container -->
        </div><!--/ #headerwrap -->
    </section>



   
    <footer>
        <div id="c">
            <div class="container">
                <p>
                    <a href="https://github.com/acacha/adminlte-laravel"></a><b>Gaming Lounge</b></a>.<br/>
                    <strong>Copyright &copy; 2019 <a href="https://claimtofameentertainment.com/gaming">Gaming Lounge</a>.</strong> 
                    <br/>
                </p>

            </div>
        </div>
    </footer>

</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ url (mix('/js/app-landing.js')) }}"></script>
<script>
    $('.carousel').carousel({
        interval: 3500
    })
</script>
</body>
</html>
