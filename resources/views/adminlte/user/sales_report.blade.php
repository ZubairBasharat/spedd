@extends('adminlte.layouts.app')

@section('htmlheader_title')
@endsection
@push('plugin-style')
  <style type="text/css">
    .select2-default {
      color: #999 !important;
      width: auto !important;
    }
  </style>

@endpush
@section('main-content')
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">@lang('adminlte.search_parameters')</h3>
      </div>
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

      <div class="box-body">
        <form action="{{ route('sales_report_post') }}" method="post">
          {{ csrf_field() }}
          <div class="row">
            <div class="form-group col-sm-6">
              <label for="from_date">@lang('adminlte.from_date')</label>
              <input type="date" class="form-control" id="from_date" name="from_date" >
            </div>

            <div class="form-group col-sm-6">
              <label for="to_date">@lang('adminlte.to_date')</label>
              <input type="date" class="form-control" id="to_date" name="to_date">
            </div>
          </div>
          <div class="row">
            <!-- <div class="form-group col-sm-6">
              <label for="region">Region </label>
              <select class="form-control select2" id="region" name="region[]" multiple="">
                @if(isset($regions))
                  @foreach($regions as $region)
                    <option value="{{ $region }}"> {{ $region }} </option>
                  @endforeach
                @endif
              </select>
            </div> -->
            @if($restaurants != null)
              <div class="form-group col-sm-12">
                <label for="restaurant">@lang('adminlte.restaurant') </label>
                <select style="width: 100%" class="form-control select2" id="restaurant" name="restaurant[]" multiple="">
                    @foreach($restaurants as $restaurant)
                      <option value="{{ $restaurant->id }}"> {{ $restaurant->name }} </option>
                    @endforeach
                </select>
              </div>
            @endif

          </div>
          <div class="row">
            <div class="col-sm-12">
              <input type="submit" name="submit" value="@lang('adminlte.generate_report')" class="btn btn-success pull-right">
            </div>
          </div>

        </form>
      </div>
    </div>

    @if(isset($data))
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">@lang('adminlte.report_generated') <br><br>
            <small> @lang('adminlte.from_date'):
              <span style="color: blue;">{{ date("d-m-Y",strtotime($minDate)) }}</span>
            </small> &nbsp;
            <small> @lang('adminlte.to_date'):
              <span style="color: green;">{{ date("d-m-Y",strtotime($maxDate)) }} </span>
            </small>
          </h3>
        </div>

        <div class="box-body">
          <div class="table-responsive">
            <table id="mydatatable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <!-- if not restaurant show name -->
                  @if(auth()->user()->user_type != 2)
                    <th>@lang('adminlte.restaurant_name') </th>
                  @endif

                  <th>@lang('adminlte.region')</th>

                  <th>@lang('adminlte.total_orders')</th>

                  <th>@lang('adminlte.total_sale')</th>

                  <th>@lang('adminlte.total_order_amount') </th>

                  <th>@lang('adminlte.total_delivery_fee')</th>
                </tr>
              </thead>
              <tbody>
                @if(count($data) > 0)
                  @foreach($data as $u)
                    <tr>
                      <!-- if not restaurant show name -->
                      @if(auth()->user()->user_type != 2)
                        <td>{{ $u->name }} </td>
                      @endif
                      <td>{{ $u->region }}</td>
                      <td>{{ $u->total_orders }}</td>
                      <td>{{ $u->grand_total }}</td>
                      <td>{{ $u->order_amount }}</td>
                      <td>{{ $u->delivery_fee }}</td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="5">No details has been found.</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    @endif


@endsection

