@extends('adminlte.layouts.app')
@section('htmlheader_title')
@endsection

@push('plugin-styles')

@endpush
@section('main-content')
  <div class="row">
    <div class="col-md-7">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">
            Restaurant Information
          </h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered">
            <tr>
              <th>@lang('adminlte.restaurant_name')</th>
              <td>{{ $data->name }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.restaurant_type')</th>
              <td>{{ $data->restaurant_type }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.min_distance')</th>
              <td>{{ $data->mini_distance }} KM</td>
            </tr>
            <tr>
              <th>@lang('adminlte.min_distance_charges')</th>
              <td>SAR {{ $data->mini_distance_charges }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.charges')</th>
              <td>SAR {{ $data->charges_per_km }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.location')</th>
              <td>{{ $data->restaurant_location }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.latitude')</th>
              <td>{{ $data->latitude }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.longitude')</th>
              <td>{{ $data->longitude }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.region')</th>
              <td>{{ $data->region }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.city')</th>
              <td>{{ $data->city }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.commercial_reg_no')</th>
              <td>{{ $data->commercial_reg_no }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="box box-primary" style="margin-bottom: 5px;">
        <div class="box-header">
          <h3 class="box-title">Sales Statistics</h3>
        </div>
        <div class="box-body " style="padding: 0;">
          <table class="table">
            <tr>
              <th>@lang('adminlte.total_orders')</th>
              <td>{{ $sales->total_orders }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.grand_total')</th>
              <td>{{ ($sales->grand_total == null)? '--': 'SAR ' . $sales->grand_total }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.order_amount')</th>
              <td>{{ ($sales->order_amount == null)? '--': 'SAR '. $sales->order_amount }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.delivery_fee')</th>
              <td>{{ ($sales->delivery_fee == null)? '--': 'SAR '. $sales->delivery_fee }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="box box-danger" style="margin-bottom: 5px;">
        <div class="box-header">
          <h3 class="box-title">Account Information</h3>
        </div>
        <div class="box-body " style="padding: 0;">
          <table class="table">
            <tr>
              <th>@lang('adminlte.username')</th>
              <td>{{ $data->username }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.email')</th>
              <td>{{ $data->email }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.email_status')</th>
              <td>{{ ($data->verified == 1)? 'Verified': 'Unverified' }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.account_status')</th>
              <td>{{ ($data->active == 1)? 'Active': 'Inactive' }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Contact Information</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered">
            <tr>
              <th>@lang('adminlte.phone_number')</th>
              <td>{{ $data->phone_number }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.store_manager_name')</th>
              <td>{{ $data->store_manager_name }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.store_manager_number')</th>
              <td>{{ $data->store_manager_number }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-body table-responsive">
          
        </div>
      </div>
    </div>
  </div> -->
@endsection

@push('plugin-scripts')

  <script type="text/javascript">
      $(document).ready(function() {

      });
  </script>


  
@endpush

