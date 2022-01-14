@extends('adminlte.layouts.app')
@section('htmlheader_title')
@endsection

@push('plugin-styles')
  
  <!-- payment method css -->
  <style type="text/css">
    .paymentWrap {
      padding: 0px;
    }

    .paymentWrap .paymentBtnGroup {
      max-width: 800px;
      margin: auto;
      border: 0.5px dashed #ccc;
    }

    .paymentWrap .paymentBtnGroup .paymentMethod {
      padding: 40px;
      box-shadow: none;
      position: relative;
    }

    .paymentWrap .paymentBtnGroup .paymentMethod.active {
      outline: none !important;
    }

    .paymentWrap .paymentBtnGroup .paymentMethod.active .method {
      border-color: #4cd264;
      outline: none !important;
      box-shadow: 0px 3px 22px 0px #7b7b7b;
    }

    .paymentWrap .paymentBtnGroup .paymentMethod .method {
      position: absolute;
      right: 3px;
      top: 3px;
      bottom: 3px;
      left: 3px;
      background-size: contain;
      background-position: center;
      background-repeat: no-repeat;
      border: 2px solid transparent;
      transition: all 0.5s;
    }

    .paymentWrap .paymentBtnGroup .paymentMethod .method.visa {
      background-image: url("");
    }

    .paymentWrap .paymentBtnGroup .paymentMethod .method.master-card {
      background-image: url("{{ asset('img/card_icon.png') }}");
    }

    .paymentWrap .paymentBtnGroup .paymentMethod .method.amex {
      background-image: url("http://www.paymentscardsandmobile.com/wp-content/uploads/2015/08/Amex-icon.jpg");
    }

    .paymentWrap .paymentBtnGroup .paymentMethod .method.vishwa {
      background-image: url("http://i.imgur.com/VkiM7PL.jpg");
    }

    .paymentWrap .paymentBtnGroup .paymentMethod .method.ez-cash {
      background-image: url("{{ asset('img/cod_icon.jpg') }}");
    }


    .paymentWrap .paymentBtnGroup .paymentMethod .method:hover {
      border-color: #4cd264;
      outline: none !important;
    }
  </style>

  <style type="text/css">

    .ui-tooltip{
      display:none !important;
    }

    .ui-helper-hidden-accessible {
      display:none !important;
    }
    .my_row{
      margin-left: 0 !important;
      margin-right: 0 !important;
    }

    .resend_btn{
      margin-bottom: 20px;
      float: right;
    }

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


    /*---------------------------------------------
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
      <div class="my_row">
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

        @if (session('resend_btn'))
          @if(session('resend_btn') == 1)
            <a class="resend_btn btn btn-warning" href="{{ route('resend_order', session('order_id')) }}">Resend Notification</a>
          @endif
        @endif
      </div>
      <div class="row align-items-start justify-content-start pt-5">
        <div class="col-lg-4 d-lg-flex flex-lg-column align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
          <!-- <img src="assets/img/hero-img.png" class="img-fluid" alt=""> -->

          <div class="wrap-contact100">
            <form action="{{ route('make_order_post') }}" method="POST" id="bidding_form" data-parsley-validate="">
              {{ csrf_field() }}
              <div class="" data-validate="Pickup Location is required">
                <label for="exampleTextarea">@lang('adminlte.pickup_location'):</label>
                <input class="form-control" type="text" id="pickup_autocomplete" name="pickup_address" placeholder="@lang('adminlte.pickup_location')" value="{{ auth()->user()->restaurant_location }}" required="">
                <input type="hidden" id="pickup_latitude" name="pickup_latitude" value="{{ auth()->user()->latitude }}">
                <input type="hidden" id="pickup_longitude" name="pickup_longitude" value="{{ auth()->user()->longitude }}">
              </div>
              <br>
              <div class="" data-validate="Dropoff Location is required">
                <label for="exampleTextarea">@lang('adminlte.dropoff_location'):</label>
                <input class="form-control" type="text" id="dropoff_autocomplete" name="dropoff_address" placeholder="@lang('adminlte.dropoff_location')"  required="" onfocus="initAutocomplete2()">
                <input type="hidden" id="dropoff_latitude" name="dropoff_latitude">
                <input type="hidden" id="dropoff_longitude" name="dropoff_longitude">
              </div>
              <br>
              <div class="" >
                <label for="exampleTextarea">@lang('adminlte.total_distance'):</label>
                <input class="form-control" type="text" name="total_distance" placeholder="@lang('adminlte.total_distance')" readonly="" id="total_distance">
                <input type="hidden" name="total_distance_value" value="">
              </div>
              <br>
              <div class="" data-validate="Name is required">
                <label for="exampleTextarea">@lang('adminlte.customer_name'):</label>
                <input class="form-control" type="text" name="customer_name"  required="" placeholder="@lang('adminlte.customer_name')">
              </div>
              <br>
              <div class="">
                <label for="exampleTextarea">@lang('adminlte.customer_number'):</label>
                <input class="form-control" type="text" name="customer_number"  data-parsley-type="digits" required="" placeholder="@lang('adminlte.customer_number')">
              </div>
              <br>
              <div class="" >
                <label for="exampleTextarea">@lang('adminlte.order_amount'):</label>
                <input class="form-control" type="text" name="order_amount"  required="" id="order_amount" placeholder="@lang('adminlte.order_amount')" min="1" data-parsley-type="number" onchange="setGrandTotal()">
              </div>
              <br>
              <div class="" >
                <label for="exampleTextarea">@lang('adminlte.delivery_fee'):</label>
                <input class="form-control" type="text" name="delivery_fee" placeholder="@lang('adminlte.delivery_fee')" readonly="" id="delivery_fee">
              </div>
              <br>
              <div class="" >
                <label for="exampleTextarea">@lang('adminlte.grand_total'):</label>
                <input class="form-control" type="text" name="grand_total" placeholder="@lang('adminlte.grand_total')" readonly="" id="grand_total">
              </div>
              <br>
              <div class="">
                <label for="exampleTextarea">@lang('adminlte.order_description'):</label>
                <textarea class="form-control"  required="" name="order_description" id="exampleTextarea" rows="3" placeholder="@lang('adminlte.order_description')"></textarea>
              </div>
              <br>
              <div class="validate-input">
                <label for="exampleTextarea">@lang('adminlte.address'):</label>
                <textarea class="form-control"  required="" name="address" id="exampleTextarea" rows="3" placeholder="H # 4, Floor # 1"></textarea>
              </div>
              <br>
              <div class="paymentWrap">
                <label for="exampleTextarea">Payment Method:</label>
                <div class="btn-group paymentBtnGroup btn-group-justified" data-toggle="buttons">
                  <label class="btn paymentMethod" style="background-color: transparent;">
                    <div class="method master-card"></div>
                      <input type="radio" name="payment_method" value="card"> 
                  </label>
                  <label class="btn paymentMethod active" style="background-color: transparent;">
                    <div class="method ez-cash"></div>
                      <input type="radio" name="payment_method" value="cash" checked="checked"> 
                  </label>
               
                </div>        
              </div>

              <div class="container-contact100-form-btn">
                <input type="submit" value="@lang('adminlte.submit')" class="btn btn-success" id="submit_btn" style="display: block; line-height: 30px; width: 100%; margin-bottom: 10px;">

              </div>
            </form>
          </div>
        </div>
        <div class="map-responsive col-lg-8 d-lg-flex flex-lg-column justify-content-center order-1 order-lg-2 hero-img" id="map" data-aos="fade-up">

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
          $("#submit_btn").on('click', function(e){
              e.preventDefault();
              var form = $("#bidding_form");
              // alert('here');
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

        var placeSearch, autocomplete, autocomplete2, map;
        let directionsRenderer; //= new google.maps.DirectionsRenderer();
        let directionsService; //= new google.maps.DirectionsService();


        function initAutocomplete2() {

          autocomplete2 = new google.maps.places.Autocomplete(
              document.getElementById('dropoff_autocomplete'), {types: ['establishment']});
          autocomplete2.addListener('place_changed', fillInAddress2);
        }

        function fillInAddress2() {
          // Get the place details from the autocomplete object.
          var place = autocomplete2.getPlace();

            document.getElementById("dropoff_autocomplete").value = place.formatted_address;
            document.getElementById("dropoff_latitude").value = place.geometry.location.lat();
            document.getElementById("dropoff_longitude").value = place.geometry.location.lng();
            initmap_dropoff();
        }


        function initmap_dropoff(){
          var initialLat = $('#dropoff_latitude').val();
          var initialLong = $('#dropoff_longitude').val();

          initialLat = initialLat?initialLat:26.32180100000001;
          initialLong = initialLong?initialLong:50.215458999999996;

          var latlng = new google.maps.LatLng(initialLat, initialLong);
          var options = {
              zoom: 13,
              center: latlng,
              mapTypeId: google.maps.MapTypeId.ROADMAP
          };

          //map = new google.maps.Map(document.getElementById("map"), options);

          //geocoder = new google.maps.Geocoder();


          var marker = new google.maps.Marker({
              map: map,
              draggable: true,
              position: latlng,
              title: "Dropoff"
          });

          google.maps.event.addListener(marker, 'dragend', function(marker){

            geocodePosition(marker.latLng, "#dropoff_autocomplete");
            var latLng = marker.latLng;
            var currentLatitude = latLng.lat();
            var currentLongitude = latLng.lng();
            $("#dropoff_latitude").val(currentLatitude);
            $("#dropoff_longitude").val(currentLongitude);

            getDirectionAndDistance();
          });

          getDirectionAndDistance();

        }

        function getDirectionAndDistance() {


          directionsRenderer.setMap(null);

          // directionsRenderer.setMap(map); // Existing map object displays directions
          // Create route from existing points used for markers

          // Locations of landmarks
          var p_Lat = $('#pickup_latitude').val();
          var p_Long = $('#pickup_longitude').val();

          var d_Lat = $('#dropoff_latitude').val();
          var d_Long = $('#dropoff_longitude').val();

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

                // var route = response.routes[0].legs[0];

                // var p_marker = new google.maps.Marker({
                //     position: route.start_location,
                //     map: map,
                //     title: 'Pickup'
                // });

                // var d_marker = new google.maps.Marker({
                //     position: route.end_location,
                //     map: map,
                //     title: 'Dropoff'
                // });

                directionsRenderer.setDirections(response); // Add route to the map
                var directionsData = response.routes[0].legs[0]; // Get data about the mapped route
                if (!directionsData) {
                  window.alert('Directions request failed');
                  return;
                }
                else {
                  // console.log(directionsData.distance);
                  document.getElementById('total_distance').value = "Distance: " + directionsData.distance.text;
                  var total_distance = (directionsData.distance.value / 1000).toFixed(2);

                  $('#total_distance_value').val(total_distance)

                  var mini_distance_charges = 0;
                  var mini_distance = 0;
                  var charges_per_km = 0;
                  var delivery_fee = 0;

                  @if($user->mini_distance_charges == null)
                    mini_distance_charges = {{ $setting->mini_distance_charges }};
                  @else
                    mini_distance_charges = {{ $user->mini_distance_charges }};
                  @endif

                  @if($user->mini_distance_charges == null)
                    mini_distance = {{ $setting->mini_distance }};
                  @else
                    mini_distance = {{ $user->mini_distance }};
                  @endif

                  @if($user->mini_distance_charges == null)
                    charges_per_km = {{ $setting->charges_per_km }};
                  @else
                    charges_per_km = {{ $user->charges_per_km }};
                  @endif

                  if(total_distance <= mini_distance){
                    delivery_fee = mini_distance_charges.toFixed(2);
                  }
                  else
                  {
                    difference = (total_distance - mini_distance).toFixed(2);
                    delivery_fee = ((charges_per_km * difference) + mini_distance_charges).toFixed(2);
                  }


                  document.getElementById('delivery_fee').value = delivery_fee;

                  setGrandTotal();
                }
              }
            });
        }

        function setGrandTotal() {

          var delivery_fee = parseFloat($('#delivery_fee').val());
          var order_amount = parseFloat($('#order_amount').val());

          if(order_amount != undefined)
          {
            var grand_total = (order_amount + delivery_fee).toFixed(2);

            document.getElementById('grand_total').value = grand_total;  
          }
          
        }

        function initmap(pickup_set){
          directionsRenderer = new google.maps.DirectionsRenderer(
            {
                suppressMarkers: true
            });
          directionsService = new google.maps.DirectionsService();

          if(pickup_set == true)
          {
            var initialLat = $('#pickup_latitude').val();
            var initialLong = $('#pickup_longitude').val();
          }
          else
          {
            var initialLat = {{ auth()->user()->latitude }};
            var initialLong = {{ auth()->user()->longitude }};
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

          geocoder = new google.maps.Geocoder();

          marker = new google.maps.Marker({
              map: map,
              draggable: true,
              position: latlng,
              title: "Pickup"
          });

          google.maps.event.addListener(marker, 'dragend', function(marker){

            geocodePosition(marker.latLng, "#pickup_autocomplete");
            var latLng = marker.latLng;
            currentLatitude = latLng.lat();
            currentLongitude = latLng.lng();
            $("#pickup_latitude").val(currentLatitude);
            $("#pickup_longitude").val(currentLongitude);
          });


        }

        function geocodePosition(pos, inputbox)
        {
           geocoder = new google.maps.Geocoder();
           geocoder.geocode
            ({
                latLng: pos
            },
                function(results, status)
                {
                    if (status == google.maps.GeocoderStatus.OK)
                    {
                        $(inputbox).val(results[0].formatted_address);
                    }
                    else
                    {
                      alert('Cannot determine address at this location.');
                      $(inputbox).val('');
                    }
                }
            );
        }


        function initAutocomplete() {
          initmap(false);
          autocomplete = new google.maps.places.Autocomplete(
              document.getElementById('pickup_autocomplete'), {types: ['establishment']});

          autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
          // Get the place details from the autocomplete object.
          var place = autocomplete.getPlace();

          document.getElementById("pickup_autocomplete").value = place.formatted_address;
          document.getElementById("pickup_latitude").value = place.geometry.location.lat();
          document.getElementById("pickup_longitude").value = place.geometry.location.lng();

          initmap(true);
        }
  </script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjtafaFLOKXsTCj8gwlDIySjFlewpiv5c&libraries=places&callback=initAutocomplete"
        async defer></script>
@endpush

