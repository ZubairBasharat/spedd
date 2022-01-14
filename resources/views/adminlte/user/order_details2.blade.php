@extends('adminlte.layouts.app')
@section('htmlheader_title')
@endsection

@push('plugin-styles')

  <style type="text/css">

    .nav-tabs-custom > .tab-content{
      height: 100% !important;
    }


    .map-responsive{
        overflow:hidden;
        padding-bottom:100%;
        position:relative;
        height:0;
    }
    .map-responsive iframe{
        left:0;
        top:0;
        height:100%;
        width:98%;
        position:absolute;
    }

    .wrap-input100 {
      width: 100%;
      position: relative;
      border-bottom: 2px solid #d9d9d9;
      padding-bottom: 13px;
      margin-bottom: 1rem;
    }

    .label-input100 {
      font-family: Raleway;
      font-size: 13px;
      color: #666666;
      line-height: 1.5;
      padding-left: 5px;
    }

    .input100 {
      display: block;
      width: 100%;
      background: transparent;
      font-family: 'Raleway';
      font-size: 1.2rem;
      color: #333333;
      line-height: 1.2;
      padding: 0 5px;
    }

    .focus-input100 {
      position: absolute;
      display: block;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      pointer-events: none;
    }

    .focus-input100::before {
      content: "";
      display: block;
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;

      -webkit-transition: all 0.4s;
      -o-transition: all 0.4s;
      -moz-transition: all 0.4s;
      transition: all 0.4s;

      background: #7f7f7f;
    }


    /*---------------------------------------------*/
    input.input100 {
      height: 40px;
    }


    textarea.input100 {
      min-height: 110px;
      padding-top: 9px;
      padding-bottom: 13px;
    }


    .input100:focus + .focus-input100::before {
      width: 100%;
    }

    .has-val.input100 + .focus-input100::before {
      width: 100%;
    }

    /*------------------------------------------------------------------
    [ Button ]*/
    .container-contact100-form-btn {
      display: -webkit-box;
      display: -webkit-flex;
      display: -moz-box;
      display: -ms-flexbox;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding-top: 13px;
    }

    .wrap-contact100-form-btn {
      width: 100%;
      display: block;
      position: relative;
      z-index: 1;
      border-radius: 25px;
      overflow: hidden;
      margin: 0 auto;
    }



    /*------------------------------------------------------------------
    [ Responsive ]*/

    @media (max-width: 576px) {
      .wrap-contact100 {
        padding: 72px 15px 65px 15px;
      }
    }



    @media (max-width: 992px) {
      .alert-validate::before {
        visibility: visible;
        opacity: 1;
      }
    }
  </style>

@endpush
@section('main-content')
  <div class="row">
    <div class="col-md-3">
      <!-- Profile Image -->
      <div class="box box-success">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="{{ $restaurant->profile_picture }}" alt="Logo">
          @if($restaurant->profile_picture != null)

          @endif

          <h3 class="profile-username text-center">{{ $restaurant->name }}</h3>

          <p class="text-muted text-center">{{ $restaurant->restaurant_type }}</p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>@lang('adminlte.grand_total')</b> <a class="pull-right">SAR: {{ number_format($order->grand_total, 2) }}</a>
            </li>
            <li class="list-group-item">
              <b>@lang('adminlte.order_amount')</b> <a class="pull-right">SAR: {{ number_format($order->order_amount, 2) }}</a>
            </li>
            <li class="list-group-item">
              <b>@lang('adminlte.delivery_fee')</b> <a class="pull-right">SAR: {{ number_format($order->delivery_fee, 2) }}</a>
            </li>
            <li class="list-group-item">
              <b>@lang('adminlte.total_distance')</b> <a class="pull-right"> {{ str_replace_first('Distance:', '', $order->distance) }}</a>
            </li>
            

          </ul>

          @if($order->status == 'Completed')
            <a href="#" class="btn btn-success btn-block"><b>@lang('adminlte.completed')</b></a>
          @else
            <a href="#" class="btn btn-primary btn-block"><b>@lang('adminlte.ongoing')</b></a>
          @endif
        </div>
      </div>

      <!-- About Me Box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title text-center">@lang('adminlte.about_order')</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <strong><i class="fa fa-book margin-r-5"></i> @lang('adminlte.order_description') </strong>

          <p class="text-muted">
            {{ $order->order_description }}
          </p>

          <hr>

          <strong><i class="fa fa-map-marker margin-r-5"></i> @lang('adminlte.pickup_location')</strong>

          <p class="text-muted">{{ $order->pickup_address }}</p>

          <hr>

          <strong><i class="fa fa-map-marker margin-r-5"></i> @lang('adminlte.dropoff_location')</strong>

          <p class="text-muted">{{ $order->dropoff_address }}</p>

          <hr>
          <strong><i class="fa fa-plus-circle margin-r-5"></i> Created At</strong>
          <p class="text-muted">
            @if($order->created_at)
              {{ date('d-m-y', strtotime($order->created_at)) }} &nbsp; 
              {{ date('g:i a', strtotime($order->created_at)) }}
            @else
              &nbsp; 
            @endif 
          </p>

          <hr>
          <strong><i class="fa fa-truck margin-r-5"></i> Picked At</strong>
          <p class="text-muted">
            @if($order->picked_at)
              {{ date('d-m-y', strtotime($order->picked_at)) }} &nbsp; 
              {{ date('g:i a', strtotime($order->picked_at)) }}
            @else
              &nbsp; 
            @endif 
          </p>

          <hr>
          <strong><i class="fa fa-check-circle margin-r-5"></i> Completed At</strong>
          <p class="text-muted">
            @if($order->completed_at)
              {{ date('d-m-y', strtotime($order->completed_at)) }} &nbsp; 
              {{ date('g:i a', strtotime($order->completed_at)) }}
            @else
              &nbsp; 
            @endif 
          </p>
          
        </div>
        <!-- /.box-body -->
      </div>
    </div>

    <div class="col-md-9">
      <div class="col-md-12 no-padding">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab">@lang('adminlte.map')</a></li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="activity">
              <!-- map -->
              <div class="post">
                <div class="map-responsive" id="map" data-aos="fade-up">
                </div>
              </div>
              <!-- /.map -->
            </div>
          </div>
          <!-- /.tab-content -->
        </div>
      </div>
      <div class="col-md-12 no-padding">
        <!-- About Customer Box -->
        <div class="col-md-6 ">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title text-center">@lang('adminlte.about_customer')</h3>
            </div>
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> @lang('adminlte.customer_name') </strong>
              <p class="text-muted">
                {{ $order->customer_name }}
              </p>
              <hr>

              <strong><i class="fa fa-book margin-r-5"></i> @lang('adminlte.customer_number') </strong>
              <p class="text-muted">
                {{ $order->customer_number }}
              </p>
              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> @lang('adminlte.customer_address') </strong>
              <p class="text-muted">
                {{ $order->customer_address }}
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <!-- About Driver Box -->
          @if($driver != null)
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title text-center">
                  About Driver
                </h3>
              </div>
              <div class="box-body">
                <strong><i class="fa fa-user margin-r-5"></i> @lang('adminlte.name') </strong>
                <p class="text-muted">
                  {{ $driver->name }}
                </p>
                <hr>

                <strong><i class="fa fa-envelope margin-r-5"></i> @lang('adminlte.email') </strong>
                <p class="text-muted">
                  {{ $driver->email }}
                </p>
                <hr>

                <strong><i class="fa fa-book margin-r-5"></i> 
                  @lang('adminlte.phone_number')
                </strong>
                <p class="text-muted">
                  {{ $driver->mobile_no }}
                </p>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>

    
      
    <!-- /.col -->
  </div>
@endsection

@push('plugin-scripts')

  <script type="text/javascript">
      $(document).ready(function() {
          //getDirectionAndDistance();
      });
  </script>

  <script type="text/javascript">

        var placeSearch, autocomplete, autocomplete2, map;
        let directionsRenderer; //= new google.maps.DirectionsRenderer();
        let directionsService; //= new google.maps.DirectionsService();

        function getDirectionAndDistance() {

          directionsRenderer = new google.maps.DirectionsRenderer();
          directionsService = new google.maps.DirectionsService();
          directionsRenderer.setMap(null);

          // directionsRenderer.setMap(map); // Existing map object displays directions
          // Create route from existing points used for markers

          // Locations of landmarks

          var p_Lat = {{ $order->pickup_latitude }};
          var p_Long = {{ $order->pickup_longitude }};

          var d_Lat = {{ $order->dropoff_latitude }};
          var d_Long = {{ $order->dropoff_longitude }};

          var pickup_latlng = new google.maps.LatLng(p_Lat, p_Long);
          var dropoff_latlng = new google.maps.LatLng(d_Lat, d_Long);

          const route = {
              origin: pickup_latlng,
              destination: dropoff_latlng,
              travelMode: 'DRIVING'
          }

          // alert(route);

          directionsService.route(route,
            function(response, status) { // anonymous function to capture directions
              if (status !== 'OK') {
                window.alert('Directions request failed due to ' + status);
                return;
              } else {
                directionsRenderer.setMap(map);
                directionsRenderer.setDirections(response); // Add route to the map
                var directionsData = response.routes[0].legs[0]; // Get data about the mapped route
                if (!directionsData) {
                  window.alert('Directions request failed');
                  return;
                }
              }
            });
        }

        function initmap(pickup_set){


          if(pickup_set == true)
          {
            var initialLat = $('#pickup_latitude').val();
            var initialLong = $('#pickup_longitude').val();
          }
          else
          {
            var initialLat = {{ $order->pickup_latitude }};
            var initialLong = {{ $order->pickup_longitude }};
          }


          initialLat = initialLat?initialLat:26.32180100000001;
          initialLong = initialLong?initialLong:50.215458999999996;

          var latlng = new google.maps.LatLng(initialLat, initialLong);
          var options = {
              zoom: 17,
              center: latlng,
              mapTypeId: google.maps.MapTypeId.ROADMAP
          };

          map = new google.maps.Map(document.getElementById("map"), options);

          //geocoder = new google.maps.Geocoder();

          // marker = new google.maps.Marker({
          //     map: map,
          //     draggable: false,
          //     position: latlng,
          //     title: "Pickup"
          // });

          getDirectionAndDistance();
        }

        function initAutocomplete() {
          initmap(false);
        }

  </script>

  @if(Session::has('locale'))
    @if(Session::get('locale') == 'ar')
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjtafaFLOKXsTCj8gwlDIySjFlewpiv5c&libraries=places&language=ar&callback=initAutocomplete"
        async defer></script>
    @else
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjtafaFLOKXsTCj8gwlDIySjFlewpiv5c&libraries=places&callback=initAutocomplete"
        async defer></script>
    @endif
  @else
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjtafaFLOKXsTCj8gwlDIySjFlewpiv5c&libraries=places&callback=initAutocomplete"
        async defer></script>
  @endif
@endpush

