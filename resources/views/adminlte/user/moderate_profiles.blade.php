@extends('adminlte.layouts.app')



@section('htmlheader_title')



@endsection





@section('main-content')

	  <div class="box">

      <div class="box-header">

        <!-- <h3 class="box-title">Data Table With Full Features</h3> -->

        

      </div>

      <!-- /.box-header -->

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

        <table id="mydatatable" class="table table-bordered table-striped">

          <thead>

          <tr>

            <th>Name </th>

            <th>Username</th>

            <th>Email</th>

            <th>Email Status</th> <!-- email is verified or not -->

            <th>Account Status</th> <!-- account is activated or not, two cases 1) email is not verified 2) user is soft deleted -->

            <th>Created At</th>

            <th>Action</th>

          </tr>

          </thead>

          <tbody>

          @if(count($users) > 0)

            @foreach($users as $u)

              <tr>

                <td>{{ $u->name }} </td>

                <td>{{ $u->username }}</td>

                <td>{{ $u->email }}</td>

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

                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($u->created_at))->diffForHumans() }}</td>

                <td>

                  <!-- <a href="{{ route('user_profile', encrypt($u->id)) }}" target="_blank"> <span class="label label-info"> View Profile </span></a> -->

                  <a href="{{ route('assign_parent', encrypt($u->id)) }}" > <span class="label label-warning"> Add In Your Team </span></a>

                </td>

              </tr>

            @endforeach

          @else

            <tr>

              <td colspan="8">No such user exists in db.</td>  

            </tr>

          @endif

          

          </tbody>

          <tfoot>

          <tr>

            <th>Name </th>

            <th>Username</th>

            <th>Email</th>

            <th>Email Status</th> <!-- email is verified or not -->

            <th>Account Status</th> <!-- account is activated or not, two cases 1) email is not verified 2) user is soft deleted -->

            <th>Created At</th>

            <th>Action</th>

          </tr>

          </tfoot>

        </table>

      </div>

      <!-- /.box-body -->

    </div>

    <!-- /.box -->





    <div class="modal fade" id="updateModal">

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

              <span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title">Manage User's Heirarchy </h4>

          </div>

          <div class="modal-body" id="model_body">

            

          </div>

        </div>

        <!-- /.modal-content -->

      </div>

      <!-- /.modal-dialog -->

    </div>

    <!-- /.modal -->

@endsection

