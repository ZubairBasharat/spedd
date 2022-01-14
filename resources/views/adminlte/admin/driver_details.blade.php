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
            Driver Information
          </h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered">
            <tr>
              <th>@lang('adminlte.actions')</th>
              <td>
                @if($data->active == 1)
                  Enabled &nbsp;
                  <a href="{{ route('toggle_account_status', encrypt($data->id)) }}" class="btn btn-danger btn-sm">Disable</a>
                @else
                  Disabled &nbsp;
                  <a href="{{ route('toggle_account_status', encrypt($data->id)) }}" class="btn btn-success btn-sm">Enable</a>
                @endif

                <a href="{{ route('edit_driver', encrypt($data->id)) }}" class="btn btn-warning btn-sm pull-right">@lang('adminlte.update')</a>
              </td>
            </tr>
            <tr>
              <th>@lang('adminlte.name')</th>
              <td>{{ $data->name }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.phone_number')</th>
              <td>{{ $data->mobile_no }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.citizen_type')</th>
              <td>{{ $data->citizen_type }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.is_driver_online')</th>
              <td>
                @if($data->is_driver_online == 1)
                  <label class="label label-success"> Yes </label>
                @else
                  <label class="label label-danger"> No </label>
                @endif
              </td>
            </tr>
            <tr>
              <th>@lang('adminlte.is_driver_busy')</th>
              <td>
                @if($data->is_driver_busy == 1)
                  <label class="label label-success"> Yes </label>
                @else
                  <label class="label label-danger"> No </label>
                @endif
              </td>
            </tr>
            <tr>
              <th>@lang('adminlte.current_latitude')</th>
              <td>
                @if($data->is_driver_online == 1)
                  {{ $data->current_lat }}
                @else
                  ---
                @endif

              </td>
            </tr>
            <tr>
              <th>@lang('adminlte.current_longitude')</th>
              <td>
                @if($data->is_driver_online == 1)
                  {{ $data->current_lang }}
                @else
                  ---
                @endif
              </td>
            </tr>
            <tr>
              <th>@lang('adminlte.city')</th>
              <td>{{ $data->city }}</td>
            </tr>
            <tr>
              <th>Machine Number</th>
              <td>{{ $data->machine_number }}</td>
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
            <tr>
              <th>Date of Joining</th>
              <td>{{ date('d-m-Y', strtotime($data->created_at)) }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Driver Statistics</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered">
            <tr>
              <th>@lang('adminlte.total_delivered_orders')</th>
              <td>{{ $data->statistics->total_orders }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.total_earnings')</th>
              <td>SAR {{ number_format($data->statistics->total_delivery_fee, 2) }}</td>
            </tr>
            <!-- <tr>
              <th>@lang('adminlte.total_order_amount')</th>
              <td>SAR {{ number_format($data->statistics->total_order_amount, 2) }}</td>
            </tr>
            <tr>
              <th>@lang('adminlte.grand_total')</th>
              <td>SAR {{ number_format($data->statistics->total_grand_amount, 2) }}</td>
            </tr> -->
            <tr>
              <th>Wallet</th>
              <td>SAR {{ number_format($data->wallet, 2) }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

  @if($order != null)
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info" style="margin-bottom: 5px;">
          <div class="box-header">
            <h3 class="box-title">Order Details</h3>
          </div>
          <div class="box-body " style="padding: 0;">
            <table class="table">
              <tr>
                <th>@lang('adminlte.active_order_id')</th>
                <td>
                  {{ $data->active_order_id }}
                </td>
              </tr>
              <tr>
                <th>@lang('adminlte.restaurant_name')</th>
                <td>{{ $order->restaurant_name }}</td>
              </tr>
              <tr>
                <th>@lang('adminlte.pickup_location')</th>
                <td>{{ $order->pickup_address }}</td>
              </tr>
              <tr>
                <th>@lang('adminlte.dropoff_location')</th>
                <td>{{ $order->dropoff_address }}</td>
              </tr>
              <tr>
                <th>@lang('adminlte.total_distance')</th>
                <td>{{ $order->distance }}</td>
              </tr>
              <tr>
                <th>@lang('adminlte.order_amount')</th>
                <td>SAR {{ $order->order_amount }}</td>
              </tr>
              <tr>
                <th>@lang('adminlte.delivery_fee')</th>
                <td>SAR {{ $order->delivery_fee }}</td>
              </tr>
              <tr>
                <th>@lang('adminlte.grand_total')</th>
                <td>SAR {{ $order->grand_total }}</td>
              </tr>

            </table>
          </div>
        </div>
      </div>
    </div>
  @endif
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

