@extends('adminlte.layouts.app')



@section('htmlheader_title')

@endsection

@push('plugin-styles')
  <style type="text/css">
    .content-header{
      display: none;
    }
  </style>
  <style>
    /* width */
    ::-webkit-scrollbar {
      width: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #888;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }
  </style>
  <style type="text/css">

    .no_padding_modal_body
    {
      padding: 0px !important;
    }

    .pack_short_image
    {
      margin-bottom: 10px !important;
        height: 75px !important;
        border-radius: 0px !important;
    }

    .users-list > li {
      width: 33.33% !important;
      border-bottom: 1px solid #f4f4f4 !important;
      border-right:  1px solid #f4f4f4 !important;
    }
    .imagebox {
       float: left;
       width: 40%;
    }
    .product-box {
        border: 1px solid #337ab7;
        padding: 10px;
        margin: 15px 0;
        min-height: 218px;
        display: inline-block;
    }

    .product-main-box{
      margin-left: 0 !important;
      margin-right: 0 !important;
    }
    .contentbox-footer {
        width: 100%;
        display: inline-block;
        margin-top: 10px;
    }
    .contentbox {
        float: right;
        width: 55%;
        max-height: 150px;
        min-height: 100px;
        overflow: auto;
        display: inline-block;
    }
    .pricebox {
      font-family: arial;
      font-size: 25px;
      font-weight: bold;
      color: #4b4b4b;
      margin-left: 15px;
      margin-top: 10px;
    }
    .contentbox h2 {
      font-size: 16px;
      /* float: left; */
      color: #054f92;
      font-weight: bold;
      margin: 0px 0 10px 0;
    }
    .contentbox-footer .buynow_btn .btn {
    width: 100%;
    padding: 15px 35px;
    font-size: 16px;
    font-weight: bold;
    background: -webkit-linear-gradient(top, #39393a, #054f92) !important;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

  </style>
  <style type="text/css">
    .buy_form{
      padding: 0 20px;
    }

    .sell_form{
      padding: 0 20px;
    }

    .buy_sell_form_box{
      background: #f5f5f5;
    }

    .my_fa_icon{
      margin-top: -20px;
      margin-left: -20px;
      height: 8px;
    }

    .my_widget_name{

    }

    .pre_share_value_span{
      padding: 5px 15px;
    }
  </style>

@endpush

@section('main-content')

  <div class="row">
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
  </div>

  <div class="row">

    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-blue"><i class="fa fa-line-chart"></i></span>
        <div class="info-box-content">
          <a href="{{ route('orders_dashboard') }}">
            <span class="info-box-text">Total Orders</span>
          </a>
          <span class="info-box-number"> {{ number_format($total_orders) }}<small>&nbsp;</small></span>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box ">
        <span class="info-box-icon bg-green"><i class="fa fa-trophy"></i></span>
        <div class="info-box-content">
          <a href="{{ route('orders_dashboard') }}">
            <span class="info-box-text">Completed Orders</span>
          </a>
          <span class="info-box-number"> {{ number_format($completed_orders) }}<small>&nbsp;</small></span>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-bar-chart"></i></span>
        <div class="info-box-content">
          <a href="{{ route('orders_dashboard') }}">
            <span class="info-box-text">Ongoing Orders</span>
          </a>
          <span class="info-box-number"> {{ number_format($ongoing_orders) }}<small>&nbsp;</small></span>
        </div>
      </div>
    </div>
  </div>

  <!-- Map:  Drivers -->
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Drivers</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>

    <div class="box-body">
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="pad">
            <!-- Map will be created here -->
            <div id="world-map-markers" style="height: 450px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>


  @push('plugin-scripts')
    <!-- jvectormap  -->
    <link rel="stylesheet" href="{{asset('css/jquery-jvectormap.css')}}">

    <script src="{{asset('js/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('js/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script type="text/javascript">

      $(document).ready(function () {

        var markers = [];
        @if(isset($markers))
          markers = <?php echo json_encode($markers); ?>;
        @endif

          $('#world-map-markers').vectorMap({
            map              : 'world_mill_en',
            normalizeFunction: 'polynomial',
            hoverOpacity     : 0.7,
            hoverColor       : false,
            markersSelectable: true,
            backgroundColor  : 'transparent',
            regionStyle      : {
              initial      : {
                fill            : 'rgba(210, 214, 222, 1)',
                'fill-opacity'  : 1,
                stroke          : 'none',
                'stroke-width'  : 0,
                'stroke-opacity': 1
              },
              hover        : {
                'fill-opacity': 0.7,
                cursor        : 'pointer'
              },
              selected     : {
                fill: 'yellow'
              },
              selectedHover: {}
            },
            markerStyle      : {
              initial: {
                fill  : '#00a65a',
                stroke: '#111'
              }
            },
            markers: markers
          });
      });

    </script>
  @endpush


@endsection

