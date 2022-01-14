

<form action="{{ route('moderate_profiles') }}" method="post">
      
  {{ csrf_field() }}
  <div class="box box-default">
    
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <input type="hidden" name="user_id" value="{{encrypt($user->id)}}">
        
                    <div class="form-group">
                      <label for="facebook_link" class="col-sm-2 control-label">Facebook</label>

                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="facebook_link" name="facebook_link" readonly value="{{ $user->facebook_link }}" style="margin-bottom: 10px !important;">
                      </div>
                    </div>

                    <div class="form-group" >
                      <label for="youtube_link" class="col-sm-2 control-label">Youtube</label>

                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="youtube_link" name="youtube_link" readonly value="{{ $user->youtube_link }}" style="margin-bottom: 10px !important;">
                      </div>
                    </div>

                    <div class="form-group" >
                      <label for="twitter_link" class="col-sm-2 control-label">Twitter</label>

                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="twitter_link" name="twitter_link" readonly value="{{ $user->twitter_link }}" style="margin-bottom: 10px !important;">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="twitch_link" class="col-sm-2 control-label">Twitch</label>

                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="twitch_link" name="twitch_link" readonly value="{{ $user->twitch_link }}" style="margin-bottom: 10px !important;">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="mixer_link" class="col-sm-2 control-label">Mixer</label>

                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="mixer_link" name="mixer_link" readonly value="{{ $user->mixer_link }}" style="margin-bottom: 10px !important;">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="steam_link" class="col-sm-2 control-label">Steam</label>

                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="steam_link" name="steam_link" readonly value="{{ $user->steam_link }}" style="margin-bottom: 10px !important;">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="instagram_link" class="col-sm-2 control-label">Instagram</label>

                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="instagram_link" name="instagram_link" readonly value="{{ $user->instagram_link }}" style="margin-bottom: 10px !important;">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="soundcloud_link" class="col-sm-2 control-label">SoundCloud</label>

                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="soundcloud_link" name="soundcloud_link" readonly value="{{ $user->soundcloud_link }}" style="margin-bottom: 10px !important;">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="patreon_link" class="col-sm-2 control-label">Patreon</label>

                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="patreon_link" name="patreon_link" value="{{ $user->patreon_link }}" readonly style="margin-bottom: 10px !important;">
                      </div>
                    </div>



                    <div class="form-group">
                      <label for="website_link" class="col-sm-2 control-label">Website</label>

                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="website_link" name="website_link" value="{{ $user->website_link }}" readonly style="margin-bottom: 10px !important;">
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="email_status" class="col-sm-2 control-label">Email </label>

                      <div class="col-sm-10">
                        <select class="form-control " id="email_status" name="email_status" style="margin-bottom: 10px !important;">
                            <option value="1" @if($user->verified == 1 ) selected @endif> Verified </option>
                            <option value="0" @if($user->verified == 0 ) selected @endif> Unverified </option>

                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="active" class="col-sm-2 control-label">Account </label>

                      <div class="col-sm-10">
                        <select class="form-control " id="active" name="active">
                            <option value="1" @if($user->active == 1 ) selected @endif> Active</option>
                            <option value="0" @if($user->active == 0 ) selected @endif> Disabled</option>

                        </select>
                      </div>
                    </div>
 
      </div>
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