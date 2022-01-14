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
      </div>
      <?php
$edit = 0;
if (isset($restaurant)) {
	$edit = 1;
}
?>
      <div class="row align-items-start justify-content-start pt-5">
        <div class="col-lg-12" data-aos="fade-up">
          <!-- <img src="assets/img/hero-img.png" class="img-fluid" alt=""> -->
          <div class="wrap-contact100">
            <form action="{{ route('save_restaurant') }}" method="POST" id="bidding_form" data-parsley-validate="" enctype="multipart/form-data">
              {{ csrf_field() }}
              @if($edit)
                <input type="hidden" name="restaurant_id" value="{{ encrypt($restaurant->id) }}">
              @endif
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleTextarea">@lang('adminlte.restaurant_name')</label>
                   <input type="text" class="form-control" placeholder="@lang('adminlte.full_name')" name="name" value="{{ ($edit) ? $restaurant->name : old('name') }}" autofocus required="" />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleTextarea">@lang('adminlte.phone_number')</label>
                    <input type="text" class="form-control" placeholder="@lang('adminlte.phone_number')" value="{{ ($edit) ? $restaurant->phone_number : old('phone_number') }}" name="phone_number"  required=""/>
                  </div>
                </div>
              </div>

              <div class="row">

                @if($edit)
                  <div class="col-md-6 form-group has-feedback">
                    <label for="exampleTextarea">@lang('adminlte.email')</label>
                    <input type="email" class="form-control" placeholder="@lang('adminlte.email')" name="email" value="{{ ($edit) ? $restaurant->email : old('email') }}" readonly="" required="" />
                  </div>

                  <div class="col-md-6 form-group has-feedback">
                    <label for="exampleTextarea">@lang('adminlte.username')</label>
                    <input type="text" class="form-control" placeholder="@lang('adminlte.username')" name="username" value="{{ ($edit) ? $restaurant->username : old('username') }}" required="" readonly="" />
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
                  <label for="exampleTextarea">@lang('adminlte.country')</label>
                  <input type="text" class="form-control" placeholder="Country" name="country" value="Saudi Arabia" readonly="" required="" />
                </div>

                <div class="col-md-6 form-group has-feedback">
                  <label for="exampleTextarea">@lang('adminlte.city')</label>
                  <input type="text" class="form-control" placeholder="@lang('adminlte.city')" value="{{ ($edit) ? $restaurant->city : old('city') }}" name="city" required="" />
                </div>

                <div class="col-xs-12 col-md-6 form-group has-feedback">
                  <label for="exampleTextarea">@lang('adminlte.region')</label>
                  <input type="text" class="form-control" placeholder="@lang('adminlte.region')" name="region" value="{{ ($edit) ? $restaurant->region : old('region') }}" required="" />
                </div>

                <div class="col-xs-12 col-md-6 form-group has-feedback">
                  <label for="exampleTextarea">@lang('adminlte.location')</label>
                  <input type="text" class="form-control" placeholder="@lang('adminlte.location')" name="location" required="" onfocus="initAutocomplete()" id="autocomplete" value="{{ ($edit) ? $restaurant->restaurant_location : '' }}" />
                  <input type="hidden" value="{{ ($edit) ? $restaurant->latitude : '' }}" name="latitude" id="latitude">
                  <input type="hidden" value="{{ ($edit) ? $restaurant->longitude : '' }}" name="longitude" id="longitude">
                </div>
                <div class="col-md-6 form-group has-feedback">
                  <label for="exampleTextarea">@lang('adminlte.commercial_reg_no')</label>
                  <input type="text" class="form-control" placeholder="@lang('adminlte.commercial_reg_no')" name="commercial_reg_no" value="{{ ($edit) ? $restaurant->commercial_reg_no : old('commercial_reg_no') }}" required="" />
                </div>

                <div class="col-md-6 form-group has-feedback">
                    <label for="restaurant_type">@lang('adminlte.restaurant_type')</label>
                    <input type="text" name="restaurant_type" class="form-control" value="{{ ($edit) ? $restaurant->restaurant_type : old('restaurant_type') }}" placeholder="@lang('adminlte.restaurant_type')" required=""/>
                </div>

                @if($edit)
                  <div class="col-lg-6" >
                    <div class="col-lg-8">
                      <label for="exampleTextarea">Change Logo</label>
                      <input class="form-control" type="file" name="profile_picture" placeholder="@lang('adminlte.restaurant_logo')"  id="image" >
                    </div>
                    <div class="col-lg-4">
                      <img src="{{ $restaurant->profile_picture }}" alt="no image" class="img-responsive coupon_small_img">
                    </div>
                  </div>
                @else
                  <div class="col-lg-6" >
                  <label for="exampleTextarea">@lang('adminlte.restaurant_logo')</label>
                  <input class="form-control" type="file" name="profile_picture" placeholder="@lang('adminlte.restaurant_logo')" >
                </div>
                @endif

                <div class="col-md-6">
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
     var placeSearch, autocomplete;

        function initAutocomplete() {
          autocomplete = new google.maps.places.Autocomplete(
              document.getElementById('autocomplete'), {types: ['establishment']});
          autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
          var place = autocomplete.getPlace();

            document.getElementById("autocomplete").value = place.formatted_address;
            document.getElementById("latitude").value = place.geometry.location.lat();
            document.getElementById("longitude").value = place.geometry.location.lng();
        }
    </script>

@endpush

