@extends('adminlte.layouts.app')
@section('htmlheader_title')
@endsection
@push('plugin-styles')
  <style type="text/css">
    .my_row{
      margin-left: 0 !important;
      margin-right: 0 !important;
    }
  </style>
@endpush

@section('main-content')

	  <div class="box">

      <div class="box-header">

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
        </div>
        <div class="table-responsive">
          <table id="mydatatable" class="table table-bordered table-striped">

            <thead>

              <tr>

                <th>@lang('adminlte.serial_no')</th>

                @if(auth()->user()->isAdmin == 1)
                  <th>@lang('adminlte.restaurant')</th>
                @endif

                <th>@lang('adminlte.customer_name') </th>

                <th>@lang('adminlte.customer_number')</th>

                <!-- <th>@lang('adminlte.customer_address')</th> -->

                <th>@lang('adminlte.pickup_location')</th>

                <th>@lang('adminlte.dropoff_location')</th>

                <th>@lang('adminlte.order_description')</th>

                <!-- <th>@lang('adminlte.order_amount') </th> -->

                <th>@lang('adminlte.delivery_fee') </th>

                <th>@lang('adminlte.status')</th>

                <th>@lang('adminlte.created_at')</th>

                <th>@lang('adminlte.actions')</th>

              </tr>

            </thead>

            <tbody>
              @if(count($data) > 0)
                @foreach($data as $key => $u)
                  <tr>
                    <td>{{ count($data) - $key }}</td>

                    @if(auth()->user()->isAdmin == 1)
                      <td>{{ $u->restaurant_name }}</td>
                    @endif
                    <td>{{ $u->customer_name }} </td>

                    <td>{{ $u->customer_number }}</td>

                    <!-- <td>{{ $u->customer_address }}</td> -->

                    <!-- <td>{{ $u->pickup_address }}</td> -->
                    <td>
                      {{\Illuminate\Support\Str::words($u->pickup_address, $words = 5, $end='...')   }}
                    </td>

                    <!-- <td>{{ $u->dropoff_address }}</td> -->
                    <td style="width:100px">
                      {{\Illuminate\Support\Str::words($u->dropoff_address, $words = 5, $end='...')   }}
                    </td>

                    <!-- <td>{{ $u->order_description }}</td> -->

                    <td>
                      {{\Illuminate\Support\Str::words($u->order_description, $words = 10, $end='...')   }}
                    </td>

                    <!-- <td>SAR {{ number_format($u->order_amount, 2) }} </td> -->

                    <td>SAR {{ number_format($u->delivery_fee, 2) }} </td>
                    <td>

                      @if($u->status == 'Completed')
                        <span class="label label-success">
                          @lang('adminlte.completed')
                        </span>
                      @elseif($u->status == 'Pending')
                        <span class="label label-warning">
                          @lang('adminlte.pending')
                        </span>
                      @else
                        <span class="label label-info">
                          {{ $u->status }}
                        </span>
                      @endif
                    </td>
                    <td>
                      <span hidden="">{{ $u->created_at }}</span>
                      <!-- {{ \Carbon\Carbon::createFromTimeStamp(strtotime($u->created_at))->diffForHumans() }} -->
                      {{ date('d-m-y', strtotime($u->created_at)) }} &nbsp;
                      {{ date('g:i a', strtotime($u->created_at)) }}
                    </td>

                    <td>
                      <a href="{{ route('order_details', encrypt($u->id) ) }}" target="_blank"> <span class="label label-info"> @lang('adminlte.view') </span></a>

                      @if($u->status == 'Pending')
                        <a href="{{ route('resend_order', $u->id ) }}"> <span class="label label-primary"> @lang('adminlte.resend_notification') </span></a>
                      @endif
                    </td>

                  </tr>

                @endforeach
              @else
                <tr>
                  <td colspan="8">No order exists in db.</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>

      </div>

      <!-- /.box-body -->

    </div>

    <!-- /.box -->

@endsection

