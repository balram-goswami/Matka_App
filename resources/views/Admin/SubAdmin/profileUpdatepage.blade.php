<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                {{Form::open(array('route' => array('users.update', $user->user_id), 'method' => 'PUT'))}}

                <div class="row mb-3" hidden>
                    <label class="col-sm-2 col-form-label" for="photo">Photo</label>
                    <div class="col-md-10 imageUploadGroup">
                        <img src="{{asset($user->photo)}}" class="file-upload" id="photo-img" style="width: 100px; height: 100px;">
                        <button type="button" data-eid="photo" class="btn btn-success setFeaturedImage">Select image</button>
                        <button type="button" data-eid="photo" class="btn btn-warning removeFeaturedImage">Remove image</button>
                        <input type="hidden" name="photo" id="photo" value="">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">name</label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            id="basic-default-company"
                            value="{{$user->name??old('name')}}"
                            required>
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
                                required>
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
                                class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row mb-3" hidden>
                    <label class="col-sm-2 col-form-label" for="basic-default-email">Role</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                            <input name="role" value="subadmin">
                        </div>
                    </div>
                </div>

                <label class="col-sm-2 col-form-label" for="basic-default-company">Bank Details</label>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">Bank Name</label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            name="bank_name"
                            class="form-control"
                            id="basic-default-company"
                            value="{{$user->bank_name??old('bank_name')}}"
                            required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">AC Holder Name</label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            name="ac_holder_name"
                            class="form-control"
                            id="basic-default-company"
                            value="{{$user->ac_holder_name??old('ac_holder_name')}}"
                            required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">AC Number</label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            name="ac_number"
                            class="form-control"
                            id="basic-default-company"
                            value="{{$user->ac_number??old('ac_number')}}"
                            required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">IFSC Code</label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            name="ifsc_code"
                            class="form-control"
                            id="basic-default-company"
                            value="{{$user->ifsc_code??old('ifsc_code')}}"
                            required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">UPI Id 1</label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            name="upi_one"
                            class="form-control"
                            id="basic-default-company"
                            value="{{$user->upi_one??old('upi_one')}}"
                            required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">UPI Id 2</label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            name="upi_two"
                            class="form-control"
                            id="basic-default-company"
                            value="{{$user->upi_two??old('upi_two')}}"
                            required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">UPI Id 3</label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            name="upi_three"
                            class="form-control"
                            id="basic-default-company"
                            value="{{$user->upi_three??old('upi_three')}}"
                            required>
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