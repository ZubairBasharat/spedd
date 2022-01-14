@extends('adminlte.layouts.app')
@section('htmlheader_title')
@endsection

@push('plugin-styles')

  <style type="text/css">

    .map-responsive{
        overflow:hidden;
        padding-bottom:56.25%;
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

    .contact100-form-bgbtn {
      position: absolute;
      z-index: -1;
      width: 300%;
      height: 100%;
      background: #a64bf4;
      background: -webkit-linear-gradient(left, #2791BE, #0C5469, #2791BE, #0C5469);
      background: -o-linear-gradient(left, #00dbde, #fc00ff, #00dbde, #fc00ff);
      background: -moz-linear-gradient(left, #00dbde, #fc00ff, #00dbde, #fc00ff);
      background: linear-gradient(left, #00dbde, #fc00ff, #00dbde, #fc00ff);
      top: 0;
      left: -100%;

      -webkit-transition: all 0.4s;
      -o-transition: all 0.4s;
      -moz-transition: all 0.4s;
      transition: all 0.4s;
    }

    .contact100-form-btn {
      display: -webkit-box;
      display: -webkit-flex;
      display: -moz-box;
      display: -ms-flexbox;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0 20px;
      width: 100%;
      height: 50px;

      font-family: Poppins-Medium;
      font-size: 16px;
      color: #fff;
      line-height: 1.2;
    }

    .wrap-contact100-form-btn:hover .contact100-form-bgbtn {
      left: 0;
    }

    .contact100-form-btn i {
      -webkit-transition: all 0.4s;
      -o-transition: all 0.4s;
      -moz-transition: all 0.4s;
      transition: all 0.4s;
    }
    .contact100-form-btn:hover i {
      -webkit-transform: translateX(10px);
      -moz-transform: translateX(10px);
      -ms-transform: translateX(10px);
      -o-transform: translateX(10px);
      transform: translateX(10px);
    }


    /*------------------------------------------------------------------
    [ Responsive ]*/

    @media (max-width: 576px) {
      .wrap-contact100 {
        padding: 72px 15px 65px 15px;
      }
    }



    /*------------------------------------------------------------------
    [ Alert validate ]*/

    .validate-input {
      position: relative;
    }

    .alert-validate::before {
      content: attr(data-validate);
      position: absolute;
      max-width: 70%;
      background-color: #fff;
      border: 1px solid #c80000;
      border-radius: 2px;
      padding: 4px 25px 4px 10px;
      top: 58%;
      -webkit-transform: translateY(-50%);
      -moz-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      -o-transform: translateY(-50%);
      transform: translateY(-50%);
      right: 2px;
      pointer-events: none;

      font-family: Poppins-Regular;
      color: #c80000;
      font-size: 13px;
      line-height: 1.4;
      text-align: left;

      visibility: hidden;
      opacity: 0;

      -webkit-transition: opacity 0.4s;
      -o-transition: opacity 0.4s;
      -moz-transition: opacity 0.4s;
      transition: opacity 0.4s;
    }

    .alert-validate::after {
      content: "\f06a";
      font-family: FontAwesome;
      display: block;
      position: absolute;
      color: #c80000;
      font-size: 16px;
      top: 58%;
      -webkit-transform: translateY(-50%);
      -moz-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      -o-transform: translateY(-50%);
      transform: translateY(-50%);
      right: 8px;
    }

    .alert-validate:hover:before {
      visibility: visible;
      opacity: 1;
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
  <div class="box">

    <div class="box-header">
      <!-- <h3 class="box-title">Data Table With Full Features</h3> -->
    </div>

    <!-- /.box-header -->

    <div class="box-body">
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
        <div class="map-responsive col-lg-12 d-lg-flex flex-lg-column justify-content-center order-1 order-lg-2 hero-img" id="map" data-aos="fade-up">
        </div>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
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
              zoom: 13,
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

