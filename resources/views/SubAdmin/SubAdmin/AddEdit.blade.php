<div class="container-xxl flex-grow-1 container-p-y">
  <!-- Basic Bootstrap Table -->
  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h4 class="fw-bold py-3 mb-0 pull-left">{{ $user->user_id?'Edit Player':'User Name will be generated automatically.'}} </h4>
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap">
        {{Form::open(array('route' => 'users.store', 'method' => 'POST'))}}
        @php
        $username = generateUsername();
        @endphp

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-company">User Name</label>
          <div class="col-sm-10">
            <input
              type="text"
              name="name"
              readonly
              class="form-control"
              id="basic-default-company"
              value="{{$user->name ?? $username}}"
              required>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-email">Password</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <input
                type="text"
                name="password"
                placeholder="Enter Password "
                id="basic-default-email"
                class="form-control">
            </div>
          </div>
        </div>
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
          <label class="col-sm-3 col-form-label" for="basic-default-email">Toss Game win Rate</label>
          <div class="col-sm-3">
            <div class="input-group input-group-merge">
              <input
                type="number"
                name="toss_game_rate"
                value="{{$user->toss_game_rate ?? '1.95'}}"
                max="1.95"
                class="form-control"
                id="toss_game_rate"
                step="0.01">
            </div>
          </div>
          <label class="col-sm-3 col-form-label" for="basic-default-email">Toss Game User commission %</label>
          <div class="col-sm-3">
            <div class="input-group input-group-merge">
              <input
                type="number"
                name="toss_game_commission"
                value="{{$user->toss_game_commission ?? '0'}}"
                class="form-control"
                id="toss_game_commission">
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label" for="basic-default-email">Crossing Game Win Rate</label>
          <div class="col-sm-3">
            <div class="input-group input-group-merge">
              <input
                type="number"
                name="crossing_game_rate"
                value="{{$user->crossing_game_rate ?? '95' }}"
                class="form-control"
                max="95"
                id="crossing_game_rate">
            </div>
          </div>
          <label class="col-sm-3 col-form-label" for="basic-default-email">Crossing Game User commission %</label>
          <div class="col-sm-3">
            <div class="input-group input-group-merge">
              <input
                type="number"
                name="crossing_commission"
                value="{{$user->crossing_commission ?? '0' }}"
                class="form-control"
                id="crossing_commission">
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-3 col-form-label" for="basic-default-email">Harf Game Win Rate</label>
          <div class="col-sm-3">
            <div class="input-group input-group-merge">
              <input
                type="number"
                name="harf_game_rate"
                value="{{$user->harf_game_rate ?? '9.5'}}"
                class="form-control"
                max="9.5"
                id="harf_game_rate"
                step="0.01">
            </div>
          </div>
          <label class="col-sm-3 col-form-label" for="basic-default-email">Harf Game User commission %</label>
          <div class="col-sm-3">
            <div class="input-group input-group-merge">
              <input
                type="number"
                name="harf_commission"
                value="{{ $user->harf_commission ?? '0'}}"
                class="form-control"
                id="harf_commission">
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-3 col-form-label" for="basic-default-email">ODD EVEN Game Win Rate</label>
          <div class="col-sm-3">
            <div class="input-group input-group-merge">
              <input
                type="number"
                name="oddEven_game_rate"
                value="{{$user->oddEven_game_rate ?? '1.95'}}"
                class="form-control"
                id="oddEven_game_rate"
                max="1.95"
                step="0.01">
            </div>
          </div>
          <label class="col-sm-3 col-form-label" for="basic-default-email">ODD EVEN Game User commission %</label>
          <div class="col-sm-3">
            <div class="input-group input-group-merge">
              <input
                type="number"
                name="oddEven_commission"
                value="{{$user->oddEven_commission ?? '0'}}"
                class="form-control"
                id="oddEven_commission">
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-3 col-form-label" for="basic-default-email">Jodi Game Win Rate</label>
          <div class="col-sm-3">
            <div class="input-group input-group-merge">
              <input
                type="number"
                name="jodi_game_rate"
                value="{{$user->jodi_game_rate ?? '95'}}"
                class="form-control"
                id="jodi_game_rate"
                max="95">
            </div>
          </div>
          <label class="col-sm-3 col-form-label" for="basic-default-email">Jodi Game User commission %</label>
          <div class="col-sm-3">
            <div class="input-group input-group-merge">
              <input
                type="number"
                name="jodi_commission"
                value="{{$user->jodi_commission ?? '0'}}"
                class="form-control"
                id="jodi_commission">
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