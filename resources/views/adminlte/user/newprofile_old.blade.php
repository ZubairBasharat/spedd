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

  @if(auth()->user()->user_type == 5)
    @if(auth()->user()->selected_restaurant == 0 || auth()->user()->selected_restaurant == null)
      <div class="row">
        <div class="alert alert-info">
            <i class="fa fa-bell-o"></i> &nbsp;
            You dont have selected any restaurant for monitoring. Please select a restaurant from top navbar.
        </div>
      </div>
    @endif
  @endif

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
            <span class="info-box-text">@lang('adminlte.total_orders')</span>
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
            <span class="info-box-text">@lang('adminlte.completed_orders')</span>
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
            <span class="info-box-text">@lang('adminlte.ongoing_orders')</span>
          </a>
          <span class="info-box-number"> {{ number_format($ongoing_orders) }}<small>&nbsp;</small></span>
        </div>
      </div>
    </div>
  </div>
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

  @if(auth()->user()->user_type == 1)
    <div class="row">
      <div class="col-md-6">
        <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Top Drivers</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="chart-responsive">
                    <canvas id="pieChart" height="150"></canvas>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <ul class="chart-legend clearfix">
                    <li>
                    	<i class="fa fa-circle-o text-red"></i>
                    	<a href="{{ route('driver_details', encrypt($pie_chart_data[0]['driver_id'])) }}">
                    	 {{ $pie_chart_data[0]['label'] }} </a>
                    </li>
                    <li>
                    	<i class="fa fa-circle-o text-green"></i>
                    	<a href="{{ route('driver_details', encrypt($pie_chart_data[1]['driver_id'])) }}">
                    	 {{ $pie_chart_data[1]['label'] }} </a>
                    </li>
                    <li><i class="fa fa-circle-o text-yellow"></i>
                    	<a href="{{ route('driver_details', encrypt($pie_chart_data[2]['driver_id'])) }}">
                    	 {{ $pie_chart_data[2]['label'] }} </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
      </div>

      <div class="col-md-6">
        <div class="box box-warning">
          <div class="box-header with-border">
              <h3 class="box-title">Delivery of the Day</h3>
            </div>
            <div class="box-body">
              	<div class="row">
              	  <div class="col-md-6">
              	  	<?php $valid_data = 0;?>
              	  	<?php if (isset($top_sale)) {if ($top_sale != null) {$valid_data = 1;}}?>
	                  <h5 class="widget-user-desc">Restaurant: {{ ($valid_data) ? $top_sale->restaurant_name : '' }} </h5>

	                  <h5 class="widget-user-desc">Deliverd by: {{ ($valid_data) ? $top_sale->driver_name : '' }} </h5>
	                  <h5 class="widget-user-desc">Datetime: {{ ($valid_data) ? date("d-m-y",strtotime($top_sale->created_at)) . ' ' . date('g:i A', strtotime($top_sale->created_at)) : '' }} </h5>
	                </div>
	                <div class="">
	                	@if($valid_data && $top_sale->profile_picture != null)
		                	<img class="img-circle pull-right top_purchased_img" width="75px" src="{{ ($valid_data) ? $top_sale->profile_picture : '' }}" alt="Restaurant Logo">
		                @endif
		            	</div>
              	</div>
	              <div class="box-footer top-box-footer">
	                <div class="row">
	                  <div class="col-sm-4 border-right">
	                    <div class="description-block">
	                      <h5 class="description-header">{{ ($valid_data) ? $top_sale->order_amount : '' }}</h5>
	                      <span class="description-text">Order Amount</span>
	                    </div>
	                  </div>
	                  <!-- /.col -->
	                  <div class="col-sm-4 border-right">
	                    <div class="description-block">
	                      <h5 class="description-header">{{ ($valid_data) ? $top_sale->delivery_fee : '' }}</h5>
	                      <span class="description-text">Delivery Fee</span>
	                    </div>
	                  </div>
	                  <div class="col-sm-4">
	                    <div class="description-block">
	                      <h5 class="description-header">{{ ($valid_data) ? $top_sale->grand_total : '' }}</h5>
	                      <span class="description-text">Grand Total</span>
	                    </div>
	                  </div>
	                </div>
	            	</div>
            </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title"> Daily Orders</h3>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="lineChart" style="height:250px"></canvas>
                </div>
              </div>
          </div>
      </div>
      <div class="col-lg-6">
        <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Weekly Orders</h3>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="areaChart" style="height:250px"></canvas>
                </div>
              </div>
          </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"> Daily Sales</h3>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="lineChartDaily2" style="height:250px"></canvas>
                </div>
              </div>
          </div>
      </div>
      <div class="col-lg-6">
        <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Weekly Sales</h3>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="areaChartWeekly2" style="height:250px"></canvas>
                </div>
              </div>
          </div>
      </div>
    </div>
  @endif


  @push('plugin-scripts')
    <script src="{{ asset('/js/Chart.js') }} " type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function () {
      	@if(auth()->user()->user_type == 1)
	        // -------------
	        // - PIE CHART -
	        // -------------

	        // Get context with jQuery - using jQuery's .get() method.
	        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
	        var pieChart       = new Chart(pieChartCanvas);
	        var PieData        = <?php echo json_encode($pie_chart_data); ?>;

	        var pieOptions     = {
	          // Boolean - Whether we should show a stroke on each segment
	          segmentShowStroke    : true,
	          // String - The colour of each segment stroke
	          segmentStrokeColor   : '#fff',
	          // Number - The width of each segment stroke
	          segmentStrokeWidth   : 1,
	          // Number - The percentage of the chart that we cut out of the middle
	          percentageInnerCutout: 50, // This is 0 for Pie charts
	          // Number - Amount of animation steps
	          animationSteps       : 100,
	          // String - Animation easing effect
	          animationEasing      : 'easeOutBounce',
	          // Boolean - Whether we animate the rotation of the Doughnut
	          animateRotate        : true,
	          // Boolean - Whether we animate scaling the Doughnut from the centre
	          animateScale         : false,
	          // Boolean - whether to make the chart responsive to window resizing
	          responsive           : true,
	          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
	          maintainAspectRatio  : false,
	          // String - A legend template
	          legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
	          // String - A tooltip template
	          tooltipTemplate      : '<%=value %> Deliveries - <%=label%> '
	        };

	        // Create pie or douhnut chart
	        // You can switch between pie and douhnut using the method below.
	        pieChart.Doughnut(PieData, pieOptions);
	        // -----------------
	        // - END PIE CHART -
	        // -----------------

	        var areaChartOptions = {
	          //Boolean - If we should show the scale at all
	          showScale               : true,
	          //Boolean - Whether grid lines are shown across the chart
	          scaleShowGridLines      : false,
	          //String - Colour of the grid lines
	          scaleGridLineColor      : 'rgba(0,0,0,.05)',
	          //Number - Width of the grid lines
	          scaleGridLineWidth      : 1,
	          //Boolean - Whether to show horizontal lines (except X axis)
	          scaleShowHorizontalLines: true,
	          //Boolean - Whether to show vertical lines (except Y axis)
	          scaleShowVerticalLines  : true,
	          //Boolean - Whether the line is curved between points
	          bezierCurve             : true,
	          //Number - Tension of the bezier curve between points
	          bezierCurveTension      : 0.3,
	          //Boolean - Whether to show a dot for each point
	          pointDot                : false,
	          //Number - Radius of each point dot in pixels
	          pointDotRadius          : 4,
	          //Number - Pixel width of point dot stroke
	          pointDotStrokeWidth     : 1,
	          //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
	          pointHitDetectionRadius : 20,
	          //Boolean - Whether to show a stroke for datasets
	          datasetStroke           : true,
	          //Number - Pixel width of dataset stroke
	          datasetStrokeWidth      : 2,
	          //Boolean - Whether to fill the dataset with a color
	          datasetFill             : true,
	          //String - A legend template
	          legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
	          //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
	          maintainAspectRatio     : true,
	          //Boolean - whether to make the chart responsive to window resizing
	          responsive              : true
	        }

	        var dailySalesData = {
	          labels  : <?php echo json_encode($daily_sales['labels']); ?>,
	          datasets: [

	            {
	              label               : 'Purchases',
	              fillColor           : 'rgba(60,141,188,0.9)',
	              strokeColor         : 'rgba(60,141,188,0.8)',
	              pointColor          : '#3b8bba',
	              pointStrokeColor    : 'rgba(60,141,188,1)',
	              pointHighlightFill  : '#fff',
	              pointHighlightStroke: 'rgba(60,141,188,1)',
	              data                : <?php echo json_encode($daily_sales['sales_data']); ?>
	            }
	          ]
	        }

	        var dailyOrdersData = {
	          labels  : <?php echo json_encode($daily_orders['labels']); ?>,
	          datasets: [

	            {
	              label               : 'Purchases',
	              fillColor           : 'rgba(60,141,188,0.9)',
	              strokeColor         : 'rgba(60,141,188,0.8)',
	              pointColor          : '#3b8bba',
	              pointStrokeColor    : 'rgba(60,141,188,1)',
	              pointHighlightFill  : '#fff',
	              pointHighlightStroke: 'rgba(60,141,188,1)',
	              data                : <?php echo json_encode($daily_orders['sales_data']); ?>
	            }
	          ]
	        }

	        var weeklySalesData = {
	          labels  : <?php echo json_encode($weekly_sales['labels']); ?>,
	          datasets: [

	            {
	              label               : 'Purchases',
	              fillColor           : 'rgba(60,141,188,0.9)',
	              strokeColor         : 'rgba(60,141,188,0.8)',
	              pointColor          : '#3b8bba',
	              pointStrokeColor    : 'rgba(60,141,188,1)',
	              pointHighlightFill  : '#fff',
	              pointHighlightStroke: 'rgba(60,141,188,1)',
	              data                : <?php echo json_encode($weekly_sales['sales_data']); ?>
	            }
	          ]
	        }

	        var weeklyOrdersData = {
	          labels  : <?php echo json_encode($weekly_orders['labels']); ?>,
	          datasets: [

	            {
	              label               : 'Purchases',
	              fillColor           : 'rgba(60,141,188,0.9)',
	              strokeColor         : 'rgba(60,141,188,0.8)',
	              pointColor          : '#3b8bba',
	              pointStrokeColor    : 'rgba(60,141,188,1)',
	              pointHighlightFill  : '#fff',
	              pointHighlightStroke: 'rgba(60,141,188,1)',
	              data                : <?php echo json_encode($weekly_orders['sales_data']); ?>
	            }
	          ]
	        }

	        //-------------
	        //- Weekly Orders CHART - AREA CHART
	        //--------------
	        var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
	        var areaChart       = new Chart(areaChartCanvas)
	        areaChart.Line(weeklyOrdersData, areaChartOptions)

	        //-------------
	        //- Daily Orders CHART -
	        //--------------
	        var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
	        var lineChart                = new Chart(lineChartCanvas)
	        var lineChartOptions         = areaChartOptions
	        lineChartOptions.datasetFill = true
	        lineChart.Line(dailyOrdersData, lineChartOptions)


	        //-------------
	        //- Daily Sales CHART -
	        //--------------
	        var lineChartCanvas          = $('#lineChartDaily2').get(0).getContext('2d')
	        var lineChart                = new Chart(lineChartCanvas)
	        var lineChartOptions         = areaChartOptions
	        lineChartOptions.datasetFill = true
	        lineChart.Line(dailySalesData, lineChartOptions)


	        //-------------
	        //- Weekly Sales CHART - AREA CHART
	        //--------------
	        var areaChartCanvas = $('#areaChartWeekly2').get(0).getContext('2d')
	        var areaChart       = new Chart(areaChartCanvas)
	        areaChart.Line(weeklySalesData, areaChartOptions)
			  @endif
      });
    </script>

    <script type="text/javascript">
      function initmap(){
          // var initialLat = {{ auth()->user()->latitude }};
          // var initialLong = {{ auth()->user()->longitude }};

          // initialLat = initialLat?initialLat:23.8342296;
          // initialLong = initialLong?initialLong:36.0465745;

          // var latlng = new google.maps.LatLng(initialLat, initialLong);
          // var options = {
          //     zoom: 5,
          //     center: latlng,
          //     mapTypeId: google.maps.MapTypeId.ROADMAP
          // };

          // map = new google.maps.Map(document.getElementById("map"), options);



          var address = "Saudi Arabia";
          @if(auth()->user()->user_type == 2 || auth()->user()->user_type == 4)
            address = "{{ auth()->user()->region }}";
          @endif

          var zoom = 6;
          @if(auth()->user()->user_type == 2)
            zoom = 10;
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
                icon: {
                  url: "{{asset('img/marker_red.png')}}"
                }
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

              marker = new google.maps.Marker({
                position: new google.maps.LatLng(restaurant_markers[i]['latLng'][0], restaurant_markers[i]['latLng'][1]),
                map: map,
                icon: {
                  url: "{{asset('img/marker_restaurant.png')}}"
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
    </script>

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

