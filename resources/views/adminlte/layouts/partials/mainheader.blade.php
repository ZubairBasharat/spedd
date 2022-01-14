<!-- Main Header -->

<header class="main-header" >
    <!-- Logo -->

    <a href="{{ url('/home') }}" class="logo" >

        <!-- mini logo for sidebar mini 50x50 pixels -->

        <span class="logo-mini"><b>S</b>&nbsp;</span>

        <!-- logo for regular state and mobile devices -->
        <img src="{{ URL::to('/assets/logos/logo_white.png') }}" width="80px" class="img-responsive logo-lg text-center" style="padding: 10px; display: inline-block;">
        <!-- <span class="logo-lg"><b>Speed</b>&nbsp; </span> -->

    </a>

    <!-- Header Navbar -->

    <nav class="navbar navbar-static-top" role="navigation">

        <!-- Sidebar toggle button-->

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>

        </a>

        <!-- Navbar Right Menu -->
        @auth
        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                @if(auth()->user()->user_type == 5)

                    <?php $assigned_restaurants = \App\Library\Common\MyLib::getSubAdminRestaurants(auth()->user()->id); ?>
                    <li class="dropdown notifications-menu" style="border-right: 1px solid #367fa9;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-lg fa-building" style="padding-bottom: 9px;"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Choose Restaurant</li>
                            <li>
                                <ul class="menu">
                                    @foreach($assigned_restaurants as $key => $r)
                                        <li class="{{ ( auth()->user()->selected_restaurant == $r->id) ? 'active_restaurant' : '' }}">
                                            <a class="{{ ( auth()->user()->selected_restaurant == $r->id) ? 'active_restaurant_anchor' : '' }}" href="{{ route('change_subadmin_restaurant', encrypt($r->id)) }}">
                                                {{ $r->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu" style="border-right: 1px solid #367fa9;">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-lg fa-globe" style="padding-bottom: 9px;"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Choose Language</li>
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="{{ route('change_locale', 'en') }}">
                                        <i class="fa fa-globe text-aqua"></i> English
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('change_locale', 'ar') }}">
                                        <i class="fa fa-globe text-aqua"></i> عربي
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>


                <!-- Tasks Menu -->

                <!-- <li class="dropdown tasks-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <i class="fa fa-flag-o"></i>

                        <span class="label label-danger">9</span>

                    </a>

                    <ul class="dropdown-menu">

                        <li class="header">{{ trans('adminlte_lang::message.tasks') }}</li>

                        <li>

                            <ul class="menu">

                                <li>

                                    <a href="#">

                                        <h3>

                                            {{ trans('adminlte_lang::message.tasks') }}

                                            <small class="pull-right">20%</small>

                                        </h3>

                                        <div class="progress xs">

                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">

                                                <span class="sr-only">20% {{ trans('adminlte_lang::message.complete') }}</span>

                                            </div>

                                        </div>

                                    </a>

                                </li>

                            </ul>

                        </li>

                        <li class="footer">

                            <a href="#">{{ trans('adminlte_lang::message.alltasks') }}</a>

                        </li>

                    </ul>

                </li> -->

                @if (Auth::guest())

                    <!-- <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>

                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li> -->

                @else

                    <!-- User Account Menu -->

                    <li class="dropdown user user-menu" id="user_menu">

                        <!-- Menu Toggle Button -->

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                            @if(auth()->user()->profile_picture != null)

                                <img src="{{ auth()->user()->profile_picture }}" class="img-circle" style="max-width: 30px; max-height: 30px;" />

                            @else

                                <img src="{{ URL::to('/usersimages/avatar.jpg') }}" class="img-circle" alt="User Image" style="max-width: 30px; max-height: 30px;" />

                            @endif

                            <!-- hidden-xs hides the username on small devices so only the image appears. -->

                            <span class="hidden-xs">{{ Auth::user()->name }} </span>

                        </a>

                        <ul class="dropdown-menu">

                            <!-- The user image in the menu -->

                            <li class="user-header">

                                @if(auth()->user()->profile_picture != null)

                                    <img src="{{ auth()->user()->profile_picture }}" class="img-circle"  />

                                @else

                                    <img src="{{ URL::to('/usersimages/avatar.jpg') }}" class="img-circle" alt="User Image" />

                                @endif



                                <p>

                                    {{ Auth::user()->name }}



                                </p>

                            </li>

                            <!-- Menu Body -->
                            <!--
                            <li class="user-body">
                            	 <div class="col-xs-12 ">
                                    <a href="#">Text 1: <span style="color: #c7a53e !important; font-size: 12px !important;"> <strong> ABC </strong> </span></a>
                                </div>
                                <div class="col-xs-12 ">
                                    <a href="#">Text 2: <span style="color: #c7a53e !important; font-size: 12px !important;"> <strong> XYZ </strong> </span></a>
                                </div>
                            </li>
                            -->

                            <!-- Menu Footer-->

                            <li class="user-footer">

                                <div class="pull-left">

                                    <a href="{{ route('user_profile') }}" class="btn btn-default btn-flat" style="background-color: transparent !important;">@lang('adminlte.profile')</a>

                                </div>

                                <div class="pull-right">

                                    <a  style="background-color: transparent !important;" href="{{ url('/logout') }}" class="btn btn-default btn-flat" id="logout"

                                       onclick="event.preventDefault();

                                                 document.getElementById('logout-form').submit();">

                                        @lang('adminlte.log_out')

                                    </a>



                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">

                                        {{ csrf_field() }}

                                        <input type="submit" value="@lang('adminlte.log_out')" style="display: none;">

                                    </form>



                                </div>

                            </li>

                        </ul>

                    </li>

                @endif



                <!-- Control Sidebar Toggle Button -->

                <!-- <li>

                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>

                </li> -->

            </ul>

        </div>
        @endauth
    </nav>

</header>

