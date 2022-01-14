@extends('adminlte.layouts.app')
@section('htmlheader_title')
@endsection

@push('plugin-styles')

  <style type="text/css">

    .coupon_small_img{
      border: 1px solid;
      margin-top: 5px;
      max-width: 100px;
      max-height: 100px;
    }

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

  </style>

@endpush
@section('main-content')
  <div class="box">

    <div class="box-header">
    </div>
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
      <?php
$edit = 0;
if (isset($driver)) {
	$edit = 1;
}
?>
      <div class="row align-items-start justify-content-start pt-5">
        <div class="col-lg-12" data-aos="fade-up">
          <!-- <img src="assets/img/hero-img.png" class="img-fluid" alt=""> -->
          <div class="wrap-contact100">
            <form action="{{ route('save_driver') }}" method="POST" id="bidding_form" data-parsley-validate="" enctype="multipart/form-data">
              {{ csrf_field() }}
              @if($edit)
                <input type="hidden" name="driver_id" value="{{ encrypt($driver->id) }}">
              @endif
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleTextarea">@lang('adminlte.full_name')</label>
                   <input type="text" class="form-control" placeholder="@lang('adminlte.full_name')" name="name" value="{{ ($edit) ? $driver->name : old('name') }}" autofocus required="" />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleTextarea">@lang('adminlte.cnic_no')</label>
                    <input type="text" class="form-control" placeholder="@lang('adminlte.cnic_no')" value="{{ ($edit) ? $driver->cnic_no : old('cnic_no') }}" name="cnic_no" />
                  </div>
                </div>
              </div>

              <div class="row">

                @if($edit)
                  <div class="col-md-6 form-group has-feedback">
                    <label for="exampleTextarea">@lang('adminlte.email')</label>
                    <input type="email" class="form-control" placeholder="@lang('adminlte.email')" name="email" value="{{ ($edit) ? $driver->email : old('email') }}" readonly="" required="" />
                  </div>

                  <div class="col-md-6 form-group has-feedback">
                    <label for="exampleTextarea">@lang('adminlte.username')</label>
                    <input type="text" class="form-control" placeholder="@lang('adminlte.username')" name="username" value="{{ ($edit) ? $driver->username : old('username') }}" required="" readonly="" />
                  </div>
                @endif


                @if($edit == 0)
                  <div class="col-md-6 form-group has-feedback">
                    <label for="exampleTextarea">@lang('adminlte.email')</label>
                    <input type="email" class="form-control" placeholder="@lang('adminlte.email')" name="email" value="{{ old('email') }}" required="" />
                  </div>

                  <div class="col-md-6 form-group has-feedback">
                    <label for="exampleTextarea">@lang('adminlte.username')</label>
                    <input type="text" class="form-control" placeholder="@lang('adminlte.username')" name="username" value="{{ old('username') }}" required="" />
                  </div>

                  <div class="col-md-6 form-group has-feedback">
                    <label for="exampleTextarea">@lang('adminlte.password')</label>
                    <input type="password" class="form-control" placeholder="@lang('adminlte.password')" minlength="8"  name="password"/>
                  </div>

                  <div class="col-md-6 form-group has-feedback">
                    <label for="exampleTextarea">@lang('adminlte.confirm_password')</label>
                    <input type="password" class="form-control" placeholder="@lang('adminlte.confirm_password')" minlength="8" name="password_confirmation"/>
                  </div>
                @endif

                <div class="col-xs-12 col-md-6 form-group has-feedback">
                  <label for="exampleTextarea">@lang('adminlte.citizen_type')</label>
                  <input type="text" class="form-control" placeholder="@lang('adminlte.citizen_type')" name="citizen_type" value="{{ ($edit) ? $driver->citizen_type : old('citizen_type') }}" />
                </div>

                <div class="col-xs-12 col-md-6 form-group has-feedback">
                  <label for="exampleTextarea">@lang('adminlte.car_plate')</label>
                  <input type="text" class="form-control" placeholder="@lang('adminlte.car_plate')" name="car_plate" value="{{ ($edit) ? $driver->car_plate : old('car_plate') }}" />
                </div>

                <div class="col-xs-12 col-md-6 form-group has-feedback">
                  <label for="exampleTextarea">@lang('adminlte.car_modal_year')</label>
                  <input type="text" class="form-control" placeholder="@lang('adminlte.car_modal_year')" name="car_modal_year" value="{{ ($edit) ? $driver->car_modal_year : old('car_modal_year') }}" />
                </div>

                <div class="col-xs-12 col-md-6 form-group has-feedback">
                  <label for="exampleTextarea">@lang('adminlte.license_expire_date')</label>
                  <?php
$dateisvalid = 0;
if ($edit) {
	if ($driver->license_expire_date != null) {
		$dateisvalid = 1;
	}
}
?>
                  <input type="date" class="form-control" placeholder="@lang('adminlte.license_expire_date')" name="license_expire_date" value="{{ ($dateisvalid) ? date('Y-m-d', strtotime($driver->license_expire_date)) : old('license_expire_date') }}" />
                </div>

                <div class="col-xs-12 col-md-6 form-group has-feedback">
                  <label for="exampleTextarea">@lang('adminlte.phone_number')</label>
                  <input type="text" class="form-control" placeholder="@lang('adminlte.phone_number')" name="mobile_no" value="{{ ($edit) ? $driver->mobile_no : old('mobile_no') }}" data-parsley-type="digits"  required="" />
                </div>

                <div class="col-md-6 form-group has-feedback">
                  <label for="exampleTextarea">@lang('adminlte.city')</label>
                  <input type="text" class="form-control" placeholder="@lang('adminlte.city')" value="{{ ($edit) ? $driver->city : old('city') }}" name="city" required="" />
                </div>

                <div class="col-md-6 form-group has-feedback">
                  <label for="exampleTextarea">Wallet</label>
                  <input type="text" class="form-control" placeholder="Wallet" value="{{ ($edit) ? ($driver->wallet < 0) ? ($driver->wallet * -1): $driver->wallet : old('wallet') }}" data-parsley-type="digits" name="wallet" required="" />
                </div>

                <div class="col-md-6 form-group has-feedback">
                  <label for="exampleTextarea">Machine Number</label>
                  <input type="text" class="form-control" placeholder="Machine Number" value="{{ ($edit) ? ($driver->machine_number): old('machine_number') }}" data-parsley-type="digits" name="machine_number"/>
                </div>

                @if($edit)
                  <div class="col-lg-6" >
                    <div class="col-lg-8">
                      <label for="exampleTextarea">Change Profile Picture</label>
                      <input class="form-control" type="file" name="profile_picture" placeholder="@lang('adminlte.image')"  id="image" >
                    </div>
                    <div class="col-lg-4">
                      <img src="{{ $driver->profile_picture }}" alt="no-image" class="img-responsive coupon_small_img">
                    </div>
                  </div>
                @else
                  <div class="col-lg-6" >
                    <label for="exampleTextarea">@lang('adminlte.profile_picture')</label>
                    <input class="form-control" type="file" name="profile_picture" placeholder="@lang('adminlte.profile_picture')" >
                  </div>
                @endif
              </div>


              <!-- @if($edit)
                <div class="row">
                  <div class="col-lg-6" >
                    <div class="col-lg-8">
                      <label for="exampleTextarea">Change Profile Picture</label>
                      <input class="form-control" type="file" name="profile_picture" placeholder="@lang('adminlte.image')"  id="image" >
                    </div>
                    <div class="col-lg-4">
                      <img src="{{ $driver->profile_picture }}" alt="no-image" class="img-responsive coupon_small_img">
                    </div>
                  </div>
                  <div class="col-lg-6" >
                    <div class="col-lg-8">
                      <label for="exampleTextarea">Change Iqama ID Picture</label>
                      <input class="form-control" type="file" name="iqama_id_picture" placeholder="@lang('adminlte.iqama_id_picture')" id="image" >
                    </div>
                    <div class="col-lg-4">
                      <img src="{{ $driver->iqama_id_picture }}" alt="no-image" class="img-responsive coupon_small_img">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-lg-6" >
                    <div class="col-lg-8">
                      <label for="exampleTextarea">Change Istemara Picture</label>
                      <input class="form-control"  type="file" name="istemara_picture" placeholder="@lang('adminlte.image')"  id="image" >
                    </div>
                    <div class="col-lg-4">
                      <img src="{{ $driver->istemara_picture }}" alt="no-image" class="img-responsive coupon_small_img">
                    </div>
                  </div>
                  <div class="col-lg-6" >
                    <div class="col-lg-8">
                      <label for="exampleTextarea">Change License Picture</label>
                      <input class="form-control" type="file" name="license_picture" placeholder="@lang('adminlte.image')"  id="image" >
                    </div>
                    <div class="col-lg-4">
                      <img src="{{ $driver->license_picture }}" alt="no-image" class="img-responsive coupon_small_img">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-lg-6" >
                    <div class="col-lg-8">
                      <label for="exampleTextarea">Change Insurance Picture</label>
                      <input class="form-control" type="file" name="insurance_picture" placeholder="@lang('adminlte.image')"  id="image" >
                    </div>
                    <div class="col-lg-4">
                      <img src="{{ $driver->insurance_picture }}" alt="no-image" class="img-responsive coupon_small_img">
                    </div>
                  </div>
                  <div class="col-lg-6" >
                    <div class="col-lg-8">
                      <label for="exampleTextarea">Change Car Front Picture</label>
                      <input class="form-control" type="file" name="car_front_picture" placeholder="@lang('adminlte.image')"  id="image" >
                    </div>
                    <div class="col-lg-4">
                      <img src="{{ $driver->car_front_picture }}" alt="no-image" class="img-responsive coupon_small_img">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-lg-6" >
                    <div class="col-lg-8">
                      <label for="exampleTextarea">Change Car Back Picture</label>
                      <input class="form-control" type="file" name="car_back_picture" placeholder="@lang('adminlte.image')"  id="image" >
                    </div>
                    <div class="col-lg-4">
                      <img src="{{ $driver->car_back_picture }}" alt="no-image" class="img-responsive coupon_small_img">
                    </div>
                  </div>
                  <div class="col-lg-6" >
                    <div class="col-lg-8">
                      <label for="exampleTextarea">Change Car Left Picture</label>
                      <input class="form-control" type="file" name="car_left_picture" placeholder="@lang('adminlte.image')"  id="image" >
                    </div>
                    <div class="col-lg-4">
                      <img src="{{ $driver->car_left_picture }}" alt="no-image" class="img-responsive coupon_small_img">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-lg-6" >
                    <div class="col-lg-8">
                      <label for="exampleTextarea">Change Car Right Picture</label>
                      <input class="form-control" type="file" name="car_right_picture" placeholder="@lang('adminlte.image')"  id="image" >
                    </div>
                    <div class="col-lg-4">
                      <img src="{{ $driver->car_right_picture }}" alt="no-image" class="img-responsive coupon_small_img">
                    </div>
                  </div>
                </div>
              @else
                <div class="row">
                  <div class="col-lg-6" >
                    <label for="exampleTextarea">@lang('adminlte.profile_picture')</label>
                    <input class="form-control" type="file" name="profile_picture" placeholder="@lang('adminlte.profile_picture')" >
                  </div>
                  <div class="col-lg-6" >
                    <label for="exampleTextarea">@lang('adminlte.iqama_id_picture')</label>
                    <input class="form-control" type="file" name="iqama_id_picture" placeholder="@lang('adminlte.iqama_id_picture')" >
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-lg-6" >
                    <label for="exampleTextarea">@lang('adminlte.istemara_picture')</label>
                    <input class="form-control" type="file" name="istemara_picture" placeholder="@lang('adminlte.istemara_picture')" >
                  </div>
                  <div class="col-lg-6" >
                    <label for="exampleTextarea">@lang('adminlte.license_picture')</label>
                    <input class="form-control" type="file" name="license_picture" placeholder="@lang('adminlte.license_picture')" >
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-lg-6" >
                    <label for="exampleTextarea">@lang('adminlte.insurance_picture')</label>
                    <input class="form-control" type="file" name="insurance_picture" placeholder="@lang('adminlte.insurance_picture')" >
                  </div>
                  <div class="col-lg-6" >
                    <label for="exampleTextarea">@lang('adminlte.car_front_picture')</label>
                    <input class="form-control" type="file" name="car_front_picture" placeholder="@lang('adminlte.car_front_picture')" >
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-lg-6" >
                    <label for="exampleTextarea">@lang('adminlte.car_back_picture')</label>
                    <input class="form-control" type="file" name="car_back_picture" placeholder="@lang('adminlte.car_back_picture')" >
                  </div>
                  <div class="col-lg-6" >
                    <label for="exampleTextarea">@lang('adminlte.car_left_picture')</label>
                    <input class="form-control" type="file" name="car_left_picture" placeholder="@lang('adminlte.car_left_picture')" >
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-lg-6" >
                    <label for="exampleTextarea">@lang('adminlte.car_right_picture')</label>
                    <input class="form-control" type="file" name="car_right_picture" placeholder="@lang('adminlte.car_right_picture')" >
                  </div>
                </div>
              @endif -->

                <div class="col-md-12">
                  <input type="submit" style="margin-top: 15px;" value="@lang('adminlte.submit')" class="btn btn-success pull-right" id="submit_btn" style="">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
@endsection

@push('plugin-scripts')

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0gM2XxUXHXZXHO3MVrjeGHpHYeOyII-M&libraries=places&callback=initAutocomplete"
        async defer></script>
  <script type="text/javascript">
      $(document).ready(function() {
          $("#submit_btn").on('click', function(e){
              e.preventDefault();
              var form = $("#bidding_form");
              form.parsley().validate();
              if (form.parsley().isValid()){
                  form.submit();
              }
          });
      });
  </script>
@endpush

