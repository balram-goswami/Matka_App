<div class="container-xxl flex-grow-1 container-p-y">
   <!-- Basic Bootstrap Table -->
   <div class="card mb-4">
   		<div class="card-header d-flex justify-content-between align-items-center">
		   <h4 class="fw-bold py-3 mb-0 pull-left">{{ $user->user_id?'Edit':'Add'}} User </h4>
		   <a class="text-muted float-end" href="{{ route('users.index') }}"><button type="button" class="btn btn-primary">Cancel</button></a>
		</div>
		<div class="card-body">
			<div class="table-responsive text-nowrap">
          @if($user->user_id)
            {{Form::open(array('route' => array('users.update', $user->user_id), 'method' => 'PUT'))}}
          @else
            {{Form::open(array('route' => 'users.store', 'method' => 'POST'))}}
          @endif


          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-company">name</label>
            <div class="col-sm-10">
              <input
                type="text"
                name="name"
                class="form-control"
                id="basic-default-company"
                value="{{$user->name??old('name')}}"
                required >
            </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-email">email</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <input
                  type="text"
                  name="email"
                  id="basic-default-email"
                  class="form-control"
                  value="{{$user->email??old('email')}}"
                  required >
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-email">Phone Number</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <input
                  type="text"
                  name="phone"
                  id="basic-default-email"
                  class="form-control"
                  value="{{$user->phone??old('phone')}}">
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="basic-default-email">Password</label>
            <div class="col-sm-10">
              <div class="input-group input-group-merge">
                <input
                  type="text"
                  name="password"
                  id="basic-default-email"
                  class="form-control"
                  >
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