<div class="container-xxl flex-grow-1 container-p-y">
  <!-- Basic Bootstrap Table -->
  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h4 class="fw-bold py-3 mb-0 pull-left">{{ $user->user_id?'Edit User':'The name and password will be generated automatically.'}}</h4>
      <!-- <a class="text-muted float-end" href="{{ route('users.index') }}"><button type="button" class="btn btn-primary">Cancel</button></a> -->
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap">
        @if($user->user_id)
        {{Form::open(array('route' => array('users.update', $user->user_id), 'method' => 'PUT'))}}
        <input hidden
          type="text"
          name="status"
          value="{{$user->status}}">
        @else
        {{Form::open(array('route' => 'users.store', 'method' => 'POST'))}}
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-email">Add Points</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <input
                type="text"
                name="balance"
                placeholder="Add more Points"
                class="form-control">
            </div>
          </div>
        </div>
        @endif
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


        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="basic-default-email">Role</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <select name="role" id="role" class="form-control">
                <option value="">Select Option</option>
                @foreach(userTypes() as $roleKey => $roleValue)
                <option value="{{$roleKey}}" {{$roleKey == $user->role?'selected':''}}>{{$roleValue}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>


        <label class="col-sm-3 col-form-label">Admin to SubAdmin Game Ratio</label>
        <div class="row mb-3">
          <label class="col-sm-4 col-form-label" for="basic-default-email">Toss Game win ratio</label>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="number"
                name="admin_cut_toss_game"
                placeholder="Admin Percent"
                value="{{$user->admin_cut_toss_game ?? '1.95'}}"
                max="1.95"
                class="form-control"
                id="admin_cut_toss_game"
                step="0.01">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="number"
                name="user_cut_toss_game"
                value="{{$user->user_cut_toss_game ?? '0.00'}}"
                placeholder="Sub Admin Percent"
                class="form-control"
                id="user_cut_toss_game"
                readonly
                step="0.01">
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-4 col-form-label" for="basic-default-email">Crossing Game Win Ratio</label>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="number"
                placeholder="Admin Percent"
                name="admin_cut_crossing"
                value="{{$user->admin_cut_crossing ?? '95' }}"
                class="form-control"
                max="95"
                id="admin_cut_crossing"
                step="0.01">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="number"
                placeholder="Sub Admin Percent"
                name="user_cut_crossing"
                value="{{$user->user_cut_crossing ?? '0' }}"
                class="form-control"
                id="user_cut_crossing"
                readonly
                step="0.01">
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-4 col-form-label" for="basic-default-email">Harf Game Win Ratio</label>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="number"
                placeholder="Admin Percent"
                name="admin_cut_harf"
                value="{{$user->admin_cut_harf ?? '9.5'}}"
                class="form-control"
                max="9.5"
                id="admin_cut_harf"
                step="0.01">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="number"
                placeholder="Sub Admin Percent"
                name="user_cut_harf"
                value="{{ $user->user_cut_harf ?? '0'}}"
                class="form-control"
                id="user_cut_harf"
                readonly
                step="0.01">
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-4 col-form-label" for="basic-default-email">ODD EVEN Game Win Ratio</label>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="number"
                placeholder="Admin Percent"
                name="admin_cut_odd_even"
                value="{{$user->admin_cut_odd_even ?? '1.95'}}"
                class="form-control"
                id="admin_cut_odd_even"
                max="1.95"
                step="0.01">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="number"
                placeholder="Sub Admin Percent"
                name="user_cut_odd_even"
                value="{{$user->user_cut_odd_even ?? '0'}}"
                class="form-control"
                id="user_cut_odd_even"
                readonly
                step="0.01">
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-4 col-form-label" for="basic-default-email">Jodi Game Win Ratio</label>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="number"
                placeholder="Admin Percent"
                name="admin_cut_jodi"
                value="{{$user->admin_cut_jodi ?? '9.5'}}"
                class="form-control"
                id="admin_cut_jodi"
                max="9.5"
                step="0.01">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="input-group input-group-merge">
              <input
                type="number"
                placeholder="Sub Admin Percent"
                name="user_cut_jodi"
                value="{{$user->user_cut_jodi ?? '0'}}"
                class="form-control"
                id="user_cut_jodi"
                readonly
                step="0.01">
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

<script>
  // Function to calculate user cut based on admin cut and total
  function calculateUserCut(adminInput, userInput, total) {
    const adminCut = parseFloat(adminInput.value);
    const userCut = total - adminCut;
    userInput.value = userCut.toFixed(2);
  }

  // Get all input elements
  const adminCutTossGameInput = document.getElementById('admin_cut_toss_game');
  const userCutTossGameInput = document.getElementById('user_cut_toss_game');
  const adminCutCrossingInput = document.getElementById('admin_cut_crossing');
  const userCutCrossingInput = document.getElementById('user_cut_crossing');
  const adminCutHarfInput = document.getElementById('admin_cut_harf');
  const userCutHarfInput = document.getElementById('user_cut_harf');
  const adminCutOddEvenInput = document.getElementById('admin_cut_odd_even');
  const userCutOddEvenInput = document.getElementById('user_cut_odd_even');
  const adminCutJodiInput = document.getElementById('admin_cut_jodi');
  const userCutJodiInput = document.getElementById('user_cut_jodi');

  // Set initial values for each game type
  calculateUserCut(adminCutTossGameInput, userCutTossGameInput, 1.95);
  calculateUserCut(adminCutCrossingInput, userCutCrossingInput, 95);
  calculateUserCut(adminCutHarfInput, userCutHarfInput, 9.5);
  calculateUserCut(adminCutOddEvenInput, userCutOddEvenInput, 1.95);
  calculateUserCut(adminCutJodiInput, userCutJodiInput, 9.5);

  // Add event listeners to update user cut when admin cut changes
  adminCutTossGameInput.addEventListener('input', function() {
    calculateUserCut(adminCutTossGameInput, userCutTossGameInput, 1.95);
  });
  adminCutCrossingInput.addEventListener('input', function() {
    calculateUserCut(adminCutCrossingInput, userCutCrossingInput, 95);
  });
  adminCutHarfInput.addEventListener('input', function() {
    calculateUserCut(adminCutHarfInput, userCutHarfInput, 9.5);
  });
  adminCutOddEvenInput.addEventListener('input', function() {
    calculateUserCut(adminCutOddEvenInput, userCutOddEvenInput, 1.95);
  });
  adminCutJodiInput.addEventListener('input', function() {
    calculateUserCut(adminCutJodiInput, userCutJodiInput, 9.5);
  });
</script>