@extends('layouts.app')

@section('body')
 <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url ('') }}">Gaming Lounge v2.0 </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
               
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{route('userprofile')}}"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        
                        <li class="divider"></li>
                        <li><a href="{{ route ('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li >
                            <a href="{{ route ('dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li {{ (Request::is('*placeorder') ? 'class="active"' : '') }}>
                            <a href="{{ route ('placeorder') }}"><i class="fa fa-bar-chart-o fa-fw"></i> Follow Gammers</a>
                        </li>
                        <li {{ (Request::is('*printbill') ? 'class="active"' : '') }}>
                            <a href="{{ route ('printbill') }}"><i class="fa fa-table fa-fw"></i> Upcoming Events</a>
                        </li>
                        <li {{ (Request::is('*printbill') ? 'class="active"' : '') }}>
                            <a href="{{ route ('printbill') }}"><i class="fa fa-table fa-fw"></i> Create Event</a>
                        </li>
                        
                        <li >
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Lookups<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li {{ (Request::is('*additem') ? 'class="active"' : '') }}>
                                    <a href="{{ route ('additem') }}">Add Item</a>
                                </li>
                                <li {{ (Request::is('*addcustomer') ? 'class="active"' : '') }}>
                                    <a href="{{ route ('addcustomer' ) }}">Add Customer</a>
                                </li>
                                
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
			 <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('page_heading')</h1>
                </div>
                <!-- /.col-lg-12 -->
           </div>
			<div class="row">  
				@yield('section')

            </div>
            <!-- /#page-wrapper -->
        </div>
    </div>

    <style type="text/css">
        .active{
            color: green !important;
        }
    </style>
@stop

