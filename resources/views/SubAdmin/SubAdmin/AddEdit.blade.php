<div class="container-xxl flex-grow-1 container-p-y">
  <!-- Basic Bootstrap Table -->
  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h4 class="fw-bold py-3 mb-0 pull-left">{{ $user->user_id?'Edit Player':'The name and password will be generated automatically.'}}  </h4>
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap">
        {{Form::open(array('route' => 'users.store', 'method' => 'POST'))}}
        <div class="row mb-3" hidden>
          <label class="col-sm-2 col-form-label" for="basic-default-email">Role</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
            <input
                type="text"
                name="role"
                id="basic-default-email"
                value="player"
                class="form-control">
            </div>
          </div>
        </div>

        <div class="row mb-3" hidden>
          <label class="col-sm-2 col-form-label" for="basic-default-email">parent</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <input name="parent" value="{{$parentId->user_id}}">
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-email">Add Points</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <input
                type="text"
                name="balance"
                class="form-control">
            </div>
          </div>
        </div>
        <label class="col-sm-3 col-form-label">Admin to SubAdmin Game Ratio</label>
        <div class="row mb-3">
          <label class="col-sm-4 col-form-label" for="basic-default-email">Toss Game win ratio</label>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="text"
                name="admin_cut_toss_game"
                placeholder="Player Win Rate"
                value="{{$user->admin_cut_toss_game??old('admin_cut_toss_game')}}"
                class="form-control">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="text"
                name="user_cut_toss_game"
                value="{{$user->user_cut_toss_game??old('user_cut_toss_game')}}"
                placeholder="Sub Admin Rate"
                class="form-control">
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-4 col-form-label" for="basic-default-email">crossing Game win ratio</label>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="text"
                placeholder="Player Win Rate"
                name="admin_cut_crossing"
                value="{{$user->admin_cut_crossing??old('admin_cut_crossing')}}"
                class="form-control">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="text"
                placeholder="Sub Admin Rate"
                name="user_cut_crossing"
                value="{{$user->user_cut_crossing??old('user_cut_crossing')}}"
                class="form-control">
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-4 col-form-label" for="basic-default-email">harf Game win ratio</label>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="text"
                placeholder="Player Win Rate"
                name="admin_cut_harf"
                value="{{$user->admin_cut_harf??old('admin_cut_harf')}}"
                class="form-control">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="text"
                placeholder="Sub Admin Rate"
                name="user_cut_harf"
                value="{{$user->user_cut_harf??old('user_cut_harf')}}"
                class="form-control">
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-4 col-form-label" for="basic-default-email">ODD EVEN Game win ratio</label>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="text"
                placeholder="Player Win Rate"
                name="admin_cut_odd_even"
                value="{{$user->admin_cut_odd_even??old('admin_cut_odd_even')}}"
                class="form-control">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="text"
                placeholder="Sub Admin Rate"
                name="user_cut_odd_even"
                value="{{$user->user_cut_odd_even??old('user_cut_odd_even')}}"
                class="form-control">
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-4 col-form-label" for="basic-default-email">Jodi Game win ratio</label>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="text"
                placeholder="Player Win Rate"
                name="admin_cut_jodi"
                value="{{$user->admin_cut_jodi??old('admin_cut_jodi')}}"
                class="form-control">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="text"
                placeholder="Sub Admin Rate"
                name="user_cut_jodi"
                value="{{$user->user_cut_jodi??old('user_cut_jodi')}}"
                class="form-control">
            </div>
          </div>
        </div>

        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!--/ Basic Bootstrap Table -->
</div>