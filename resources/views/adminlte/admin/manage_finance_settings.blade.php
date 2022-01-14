@extends('adminlte.layouts.app')
@section('htmlheader_title')
@endsection
@section('main-content')

	  <div class="box">
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
      <div class="box-body">

        <form form="horizontal" action="{{ route('manage_finance_settings_post') }}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{encrypt($data->id)}}">
          <div class="row">
            <div class="form-group col-md-6">
                <label for="email_status" class="control-label">@lang('adminlte.currency')</label>
                <input type="text" class="form-control" name="currency" value="{{ $data->currency }}" required="">
            </div>

            <div class="form-group col-md-6">
              <label for="active" class="control-label">@lang('adminlte.tax_on_restaurant_order')</label>
              <input type="text" class="form-control" name="tax_on_restaurant_order" value="{{ $data->tax_on_restaurant_order }}" required="">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
                <label for="email_status" class="control-label">@lang('adminlte.min_distance')</label>
                <input type="text" class="form-control" name="mini_distance" value="{{ $data->mini_distance }}" required="">
            </div>

            <div class="form-group col-md-6">
              <label for="active" class="control-label">@lang('adminlte.min_distance_charges')</label>
              <input type="text" class="form-control" name="mini_distance_charges" value="{{ $data->mini_distance_charges }}" required="">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
                <label for="email_status" class="control-label">@lang('adminlte.charges')</label>
                <input type="text" class="form-control" name="charges_per_km" value="{{ $data->charges_per_km }}" required="">
            </div>

            <div class="form-group col-md-6">
              <label for="active" class="control-label">@lang('adminlte.driver_subscription_fee')</label>
              <input type="text" class="form-control" name="driver_subscription_fee" value="{{ $data->driver_subscription_fee }}" required="">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
                <label for="email_status" class="control-label">@lang('adminlte.delivery_fee')</label>
                <input type="text" class="form-control" name="delivery_fee" value="{{ $data->delivery_fee }}" required="">
            </div>
            <div class="form-group col-md-6">
                <label for="max_due_amount" class="control-label">Maximum Due Amount</label>
                <input type="text" class="form-control" name="max_due_amount" value="{{ $data->max_due_amount }}" required="">
            </div>

          </div>
          <div class="row">
            <div class="form-group col-md-12">
                <label for="submit" class="control-label">&nbsp;</label>
                <input type="submit" class="btn btn-primary pull-right my-2" value="@lang('adminlte.update')">
            </div>
          </div>

        </form>
      </div>
    </div>

@endsection

@push('plugin-scripts')
  <script type="text/javascript">

  </script>
@endpush