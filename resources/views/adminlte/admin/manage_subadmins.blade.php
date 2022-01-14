@extends('adminlte.layouts.app')

@section('htmlheader_title')

@endsection

@section('main-content')

	  <div class="box">

      <div class="box-header">

        <!-- <h3 class="box-title">Data Table With Full Features</h3> -->

      </div>

      <!-- /.box-header -->

      <div class="box-body">
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
        <div class="col-md-12">
          <a style="margin: 10px 20px;" href="#" data-toggle="modal" data-target="#newModal" class="pull-right btn btn-success"><i title="Add Sub-Admin" class=" fa fa-plus"></i> &nbsp; @lang('adminlte.add_subadmin') </a>
        </div>
<table id="mydatatable" class="table table-bordered table-striped">

            <thead>

            <tr>

              <th>@lang('adminlte.name') </th>

              <th>@lang('adminlte.username')</th>

              <th>@lang('adminlte.email')</th>

              <th>@lang('adminlte.region')</th>

              <th>@lang('adminlte.email_status')</th>

              <th>@lang('adminlte.account_status')</th>

              <th>@lang('adminlte.actions')</th>

            </tr>

            </thead>

            <tbody>

            @if(count($users) > 0)

              @foreach($users as $u)

                <tr>

                  <td>{{ $u->name }} </td>

                  <td>{{ $u->username }}</td>

                  <td>{{ $u->email }}</td>

                  <td>{{ $u->region }}</td>

                  <td>

                    @if($u->verified == 1)

                      <span class="label label-success">

                        Verified

                      </span>

                    @else

                      <span class="label label-danger">

                        Unverified

                      </span>

                    @endif

                  </td>

                  <td>

                    @if($u->active == 1)

                      <span class="label label-success">

                        Active

                      </span>

                    @else

                      <span class="label label-danger">

                        Disabled

                      </span>

                    @endif

                  </td>

                  <!-- <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($u->created_at))->diffForHumans() }}</td> -->

                  <td><a href="#" onclick='LinksModal( {{ $u->id }} )'> <span class="label label-info"> @lang('adminlte.update') </span></a></td>

                </tr>

              @endforeach

            @else

              <tr>

                <td colspan="5">No subadmin exists in db.</td>

              </tr>

            @endif



            </tbody>



          </table>
      </div>

      <!-- /.box-body -->

    </div>

    <!-- /.box -->

    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newModal">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                        <span class="sr-only">Close</span>

                    </button>

                    <h5 class="modal-title">@lang('adminlte.add_subadmin')</h5>

                </div>

                <div class="modal-body">

                    <div class="row sameheight-container">

                        <div class="col-md-12">

                            <div class="card card-block sameheight-item" >

                                <form class="" role="form" action="{{ route('add_subadmin') }}" method="POST" enctype="multipart/form-data">

                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="" for="project">@lang('adminlte.select_region')</label>
                                            <select name="region" class="form-control" required="" id="region">
                                              <option value="" selected=""> -- </option>
                                              <option value="Al Bahah"> Al Bahah </option>
                                              <option value="Al Jawf"> Al Jawf </option>
                                              <option value="Mecca"> Mecca </option>
                                              <option value="Riyadh"> Riyadh </option>
                                              <option value="Eastern Province"> Eastern Province </option>
                                              <option value="Jizan"> Jizan </option>
                                              <option value="Medina"> Medina </option>
                                              <option value="Qasim"> Qasim </option>
                                              <option value="Tabuk"> Tabuk </option>
                                              <option value="Ha'il"> Ha'il </option>
                                              <option value="Narjan"> Narjan </option>
                                              <option value="Northern Borders"> Northern Borders </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="" for="remarks"> @lang('adminlte.name') </label>
                                            <input type="text" name="name" placeholder="@lang('adminlte.name')" class="form-control" required="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="" for="username"> @lang('adminlte.username') </label>
                                            <input type="text" placeholder="@lang('adminlte.username')" name="username" class="form-control" required="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="" for="email"> @lang('adminlte.email') </label>
                                            <input type="email" name="email" placeholder="email" class="form-control" required="">
                                        </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-12 form-group">
                                          <label class="" for="password"> @lang('adminlte.password_min') </label>
                                          <input type="password" minlength="8" name="password" class="form-control" placeholder="@lang('adminlte.password')" required="">
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-12 form-group">
                                        <label class="txt1" for="password_confirmation">@lang('adminlte.confirm_password')</label>
                                        <input type="password" name="password_confirmation" class="form-control" minlength="8" placeholder="@lang('adminlte.confirm_password')"required="" />
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="form-group col-lg-12">
                                        <button style="float: right" type="submit" class="btn btn-success">@lang('adminlte.submit')</button>
                                        <a style="float: right; margin-right: 5px" href="#" data-dismiss="modal" class="btn btn-primary">@lang('adminlte.cancel')</a>
                                      </div>
                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>



            </div>

        </div>

    </div>

    <div class="modal fade" id="updateModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Manage Sub-Admin</h4>
          </div>
          <div class="modal-body" id="model_body">
          </div>
        </div>
      </div>
    </div>
@endsection

@push('plugin-scripts')
  <script type="text/javascript">
    function LinksModal(user_id)
    {
      var data= {'user_id':user_id, '_token':'{{csrf_token()}}' };

      $.post('{{ route('edit_account_status_modal') }}', data , function(response) {

          $("#model_body").html(response);
          $('#updateModal').modal('show');
      });
    }
  </script>
@endpush
