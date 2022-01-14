<!-- Left side column. contains the logo and sidebar -->

<aside class="main-sidebar">



    <!-- sidebar: style can be found in sidebar.less -->

    <section class="sidebar">



        <!-- Sidebar user panel (optional) -->

        @if (! Auth::guest())



            <div class="user-panel">

                <div class="pull-left image">

                    @if(auth()->user()->profile_picture != null)


                        <img src="{{ auth()->user()->profile_picture }}" class="img-circle"  />

                    @else

                        <img src="{{ URL::to('/usersimages/avatar.jpg') }}" class="img-circle" alt="User Image" />

                    @endif

                </div>

                <div class="pull-left info">

                    <p>{{ Auth::user()->name }}</p>

                    <!-- Status -->
                    <?php $usertype = "";?>
                    @if(auth()->user()->isAdmin == 1)
                        <?php $usertype = "Super Admin";?>
                    @elseif(auth()->user()->user_type == 2)
                        <?php $usertype = "Restaurant";?>
                    @elseif(auth()->user()->user_type == 4)
                        <?php $usertype = "Sub Admin | Region";?>
                    @elseif(auth()->user()->user_type == 5)
                        <?php $usertype = "Sub Admin | Restaurant";?>
                    @endif

                    <a href="#"><i class="fa fa-circle text-success"></i> {{ $usertype }} </a>
                </div>

            </div>

        @endif

        <!-- Sidebar Menu -->

        <ul class="sidebar-menu">

            <li class="header"> @lang('adminlte.main_navigation')  </li>

            <?php $visible = false;?>

            <!-- Optionally, you can add icons to the links -->

            <li class="{{ (request()->is('user/profile*')) ? 'active' : '' }}"><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span> @lang('adminlte.dashboard') </span></a></li>

            <!-- <li><a href="#"><i class='fa fa-link'></i> <span>Menu 1</span></a></li> -->

            @if(auth()->user() != null)
                @if(auth()->user()->user_type == 2)
                    <li class="{{ (request()->is('make/order*')) ? 'active' : '' }}"><a href="{{ route('make_order') }}"><i class='fa fa-first-order'></i> <span> @lang('adminlte.make_order') </span></a></li>
                    <li class="{{ (request()->is('add_item*')) ? 'active' : '' }}"><a href="{{route('add_item')}}"><i class='fa fa-first-order'></i> <span> @lang('adminlte.items') </span></a></li>
                @endif
            @endif

            <li class="{{ (request()->is('orders/dashboard*')) ? 'active' : '' }}"><a href="{{ route('orders_dashboard') }}"><i class='fa fa-tachometer'></i> <span> @lang('adminlte.orders') </span></a></li>

            <li class="{{ (request()->is('sale/report*')) ? 'active' : '' }}"><a href="{{ route('sales_report') }}"><i class='fa fa-exchange'></i> <span> @lang('adminlte.sales_report') </span></a></li>


            @if(auth()->user() != null)
                @if(auth()->user()->user_type == 1 || auth()->user()->user_type == 4)

                    <li class="{{ (request()->is('admin/manage/restaurant*')) ? 'active' : '' }}"><a href="{{ route('manage_restaurants') }}"><i class='fa fa-building'></i> <span>  @lang('adminlte.restaurants') </span></a></li>

                    <li class="{{ (request()->is('admin/manage/driver*')) ? 'active' : '' }}"><a href="{{ route('manage_drivers') }}"><i class='fa fa-users'></i> <span>  @lang('adminlte.drivers') </span></a></li>



                    @if(auth()->user()->user_type == 1)
                        <li class="{{ (request()->is('manage/finance*')) ? 'active' : '' }}"><a href="{{ route('manage_finance_settings') }}"><i class='fa fa-bar-chart'></i> <span> @lang('adminlte.finance_settings') </span></a></li>

                        <li class="{{ (request()->is('manage/sub_admins*')) ? 'active' : '' }}"><a href="{{ route('manage_subadmins') }}"><i class='fa fa-legal'></i> <span> @lang('adminlte.sub_admin') | @lang('adminlte.region') </span></a></li>

                        <li class="{{ (request()->is('manage/subadmin/restaurant*')) ? 'active' : '' }}"><a href="{{ route('manage_restaurant_subadmins') }}"><i class='fa fa-legal'></i> <span> @lang('adminlte.sub_admin') | @lang('adminlte.restaurant') </span></a></li>


                    @endif
                @endif
            @endif

        </ul><!-- /.sidebar-menu -->

    </section>

    <!-- /.sidebar -->

</aside>

