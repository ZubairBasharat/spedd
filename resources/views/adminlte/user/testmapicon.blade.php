@extends('adminlte.layouts.app')

@section('htmlheader_title')

@endsection

@push('plugin-styles')
  <style type="text/css">

  	.top-box-footer{
		padding-bottom: 3px;
	}

	.top_purchased_img{
		display: inline-block;
		margin: 15px 20px;
		border: 1px solid;
		border-radius: 50%;
	}

    .content-header{
      display: none;
    }

    .ui-tooltip{
      display:none !important;
    }

    .ui-helper-hidden-accessible {
      display:none !important;
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

  
  <!-- Map-->
  <div class="box box-success">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="pad">
            <!-- Map will be created here -->
            <div id="map" style="height: 600px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>



  @push('plugin-scripts')
    
    <script type="text/javascript">
      function initmap(){
          var address = "Saudi Arabia";
          @if(auth()->user()->user_type == 2 || auth()->user()->user_type == 4)
            address = "{{ auth()->user()->region }}";
          @endif

          var zoom = 6;
          @if(auth()->user()->user_type == 2)
            zoom = 6;
          @endif

          @if(auth()->user()->user_type == 4)
            zoom = 8;
          @endif



          const map = new google.maps.Map(document.getElementById("map"), {
            zoom: zoom,
          });
          const geocoder = new google.maps.Geocoder();

          geocoder.geocode({ address: address }, (results, status) => {
            if (status === "OK") {
              map.setCenter(results[0].geometry.location);
            }
          });

          var infowindow = new google.maps.InfoWindow();
          var marker, i;

          var markers = [];
          @if(isset($markers))
            markers = <?php echo json_encode($markers); ?>;
          @endif

          var restaurant_markers = [];
          @if(isset($restaurant_markers))
            restaurant_markers = <?php echo json_encode($restaurant_markers); ?>;
          @endif
          // console.log(markers);

          for (i = 0; i < markers.length; i++) {
            if(markers[i]['busy'] == 1)
            {
              const contentString = '<p> <b> '+markers[i]['name']+' </b> </p> <p> Online & Busy. </p>'
                + '<a href="'+'{{ env('APP_URL') }}'+'/driver/details/'+markers[i]['id_encrypted']+'">More </a>';

                

              marker = new google.maps.Marker({
                position: new google.maps.LatLng(markers[i]['latLng'][0], markers[i]['latLng'][1]),
                map: map,
              });

              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  infowindow.setContent(contentString);
                  infowindow.open(map, marker);
                }
              })(marker, i));
            }
            else
            {
              const contentString = '<p> <b> '+markers[i]['name']+' </b> </p> <p> Online & Available. </p>'
                + '<a href="'+'{{ env('APP_URL') }}'+'/driver/details/'+markers[i]['id_encrypted']+'">More </a>';

              marker = new google.maps.Marker({
                position: new google.maps.LatLng(markers[i]['latLng'][0], markers[i]['latLng'][1]),
                map: map,
                icon: {
                  url: "{{asset('img/marker_green.png')}}"
                }
              });

              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  infowindow.setContent(contentString);
                  infowindow.open(map, marker);
                }
              })(marker, i));
            }
          }

          for (i = 0; i < restaurant_markers.length; i++) {
              const contentString = '<p> <b> '+restaurant_markers[i]['name']+' </b> </p>'
                + '<a href="'+'{{ env('APP_URL') }}'+'/restaurant/details/'+restaurant_markers[i]['id_encrypted']+'">More </a>';

                var div = $("<div></div>");
                var svg = '<svg width="32px" height="43px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><image href="'+restaurant_markers[i]['profile_picture']+'" x="0" y="0"  height="32px" width="43px"/></svg>';
                
                div.append(svg);

                var dd = $("<canvas height='50px' width='50px'></cancas>");
                // console.log(dd);
                var svgHtml = div[0].innerHTML;

                canvg(dd[0], svgHtml);
                var imgSrc = dd[0].toDataURL("image/png");

                /*
                  var img = '<div class="img--container" style="width: 512px; height: 512px;background-image: url("https://lh3.googleusercontent.com/proxy/vJ2UN4vUl9FKcAX_M_NwBVIugH5JI7bwmQFderr8DEaSN-OPC18dshTARn1to3uNmeFIAwnMYDanpTauuIfyXQ7WnDDLaRqB0lP3MM_1LXh9SSznxYj4C7fDmxcRoR2QqW5PxsKEG2TV"); background-repeat: no-repeat;  background-size: 512px;"> <img class="image-2" src="https://images.unsplash.com/photo-1610641987870-d6d8998274a4?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MXwxNDU4OXwwfDF8cmFuZG9tfHx8fHx8fHw&ixlib=rb-1.2.1&q=80&w=150" style="width: 100%; display: block; object-fit: none; object-position: center center; " /></div>';
                */

              marker = new google.maps.Marker({
                position: new google.maps.LatLng(restaurant_markers[i]['latLng'][0], restaurant_markers[i]['latLng'][1]),
                map: map,

                title: restaurant_markers[i]['name'],
                // icon: { url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg), scaledSize: new google.maps.Size(150, 150) },

                icon: {
                  size: new google.maps.Size(32, 43),
                  url: imgSrc,
                  scaledSize: new google.maps.Size(32, 43)
                },
                optimized: false
                
              });

              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  infowindow.setContent(contentString);
                  infowindow.open(map, marker);
                }
              })(marker, i));
          }
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/canvg/1.3/canvg.js"></script>
    @if(Session::has('locale'))
      @if(Session::get('locale') == 'ar')
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjtafaFLOKXsTCj8gwlDIySjFlewpiv5c&libraries=places&language=ar&callback=initmap"
          async defer></script>
      @else
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjtafaFLOKXsTCj8gwlDIySjFlewpiv5c&libraries=places&callback=initmap"
          async defer></script>
      @endif
    @else
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjtafaFLOKXsTCj8gwlDIySjFlewpiv5c&libraries=places&callback=initmap"
          async defer></script>
    @endif
  @endpush


@endsection

