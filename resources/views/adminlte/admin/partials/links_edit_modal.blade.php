<form form="horizontal" action="{{ route('update_account_status_post') }}" method="post">



  {{ csrf_field() }}

  <div class="box box-default">


    <!-- /.box-header -->

    <div class="box-body">

      <div class="row">

        <input type="hidden" name="user_id" value="{{encrypt($user->id)}}">
        <div class="form-group">
            <label for="email_status" class="control-label">Email Status</label>
            <select class="form-control " id="email_status" name="email_status" style="margin-bottom: 10px !important;">
                <option value="1" @if($user->verified == 1 ) selected @endif> Verified </option>
                <option value="0" @if($user->verified == 0 ) selected @endif> Unverified </option>
            </select>
        </div>

        <div class="form-group">
          <label for="active" class="control-label">Account Status</label>
            <select class="form-control " id="active" name="active">
                <option value="1" @if($user->active == 1 ) selected @endif> Active</option>
                <option value="0" @if($user->active == 0 ) selected @endif> Disabled</option>
            </select>
        </div>
      </div>

      {{-- if restaurant --}}
      @if($user->user_type == 2)
        <div class="row">
          <div class="form-group">
              <label for="email_status" class="control-label">Min Distance</label>
              <input type="text" class="form-control" name="mini_distance" value="{{ $user->mini_distance }}" placeholder="Leave empty to use default settings." >
          </div>

          <div class="form-group">
            <label for="active" class="control-label">Min Distance Charges</label>
            <input type="text" class="form-control" name="mini_distance_charges" value="{{ $user->mini_distance_charges }}" placeholder="Leave empty to use default settings.">
          </div>
        </div>

        <div class="row">
          <div class="form-group">
              <label for="email_status" class="control-label">Charges (Per KM)</label>
              <input type="text" class="form-control" name="charges_per_km" value="{{ $user->charges_per_km }}" placeholder="Leave empty to use default settings.">
          </div>
        </div>
      @endif

      {{-- if restaurant - subadmin --}}
      @if($user->user_type == 5)
        <div class="row">
          <div class="form-group">
              <label for="email_status" class="control-label">Restaurants</label>
              <select style="width: 100%;" name="restaurants[]" class="form-control select3" required="" id="restaurants_update" multiple="">
                <option value="" disabled=""> -- </option>
                @foreach($restaurants as $key => $r)
                  <option value="{{ $r->id }}" {{ in_array($r->id, $selected_restaurants_ids) ? 'selected':'' }}> {{ $r->name }}</option>
                @endforeach
              </select>
          </div>
        </div>
      @endif

      <!-- /.row -->

    </div>

    <!-- /.box-body -->

    <div class="modal-footer">

        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

        <button type="submit" class="btn btn-primary">Save changes</button>

    </div>

  </div>

  <!-- /.box -->

</form>


<script type="text/javascript">
    $(document).ready(function() {
      // $('.select2').select2();
      $('#restaurants_update').select2();

    });


</script>