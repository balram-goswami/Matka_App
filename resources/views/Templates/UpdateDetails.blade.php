@include('Include.HeaderMenu')

<div class="login-wrapper d-flex align-items-center justify-content-center text-center">
    <!-- Background Shape-->
    <div class="background-shape"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-lg-8">

                <!-- Register Form-->
                <div class="register-form mt-5">
                    {{ Form::open(['route' => ['users.update', $user->user_id], 'method' => 'PUT']) }}
                    @csrf
                    <!-- <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="photo">Photo</label>
                        <div class="col-md-10 imageUploadGroup">
                            <img src="{{ asset($user->photo) }}" class="file-upload" id="photo-img"
                                style="width: 100px; height: 100px;">
                            <button type="button" data-eid="photo" class="btn btn-success setFeaturedImage">Select
                                image</button>
                            <button type="button" data-eid="photo" class="btn btn-warning removeFeaturedImage">Remove
                                image</button>
                            <input type="hidden" name="photo" id="photo" value="">
                        </div>
                    </div> -->

                    <div class="form-group text-start mb-4">
                        <span>Email Id</span>
                        <label for="email"><i class="ti ti-mail"></i></label>
                        <input class="form-control" id="email" name="email" type="email"
                            placeholder="Enter Email Id" value="{{ $user->email ?? old('email') }}"
                            style="border-color: white;">
                    </div>
                    <div class="form-group text-start mb-4">
                        <span>Phone</span>
                        <label for="email"><i class="ti ti-phone"></i></label>
                        <input class="form-control" id="phone" name="phone" type="tel"
                            placeholder="Phone Number" value="{{ $user->phone ?? old('phone') }}"
                            style="border-color: white;">
                    </div>
                    <input hidden id="role" name="role" value="{{ $user->role }}">

                    <div class="form-group text-start mb-4">
                        <span>Bank Name</span>
                        <label for="email"><i class="ti ti-arrow-right"></i></label>
                        <input class="form-control" id="bank_name" name="bank_name" type="text"
                            placeholder="Enter Bank Name" style="border-color: white;" value="{{ $user->bank_name}}">
                    </div>
                    <div class="form-group text-start mb-4">
                        <span>A/C Holder Name</span>
                        <label for="email"><i class="ti ti-arrow-right"></i></label>
                        <input class="form-control" id="ac_holder_name" name="ac_holder_name" type="text"
                            placeholder="Enter A/C Holder Name" style="border-color: white;" value="{{ $user->ac_holder_name }}">
                    </div>
                    <div class="form-group text-start mb-4">
                        <span>A/c Number</span>
                        <label for="email"><i class="ti ti-arrow-right"></i></label>
                        <input class="form-control" id="ac_number" name="ac_number" type="text"
                            placeholder="Enter A/c Number" style="border-color: white;" value="{{ $user->ac_number}}">
                    </div>
                    <div class="form-group text-start mb-4">
                        <span>IFSC Number</span>
                        <label for="email"><i class="ti ti-arrow-right"></i></label>
                        <input class="form-control" id="ifsc_code" name="ifsc_code" type="text"
                            placeholder="Enter IFSC Number" style="border-color: white;" value="{{ $user->ifsc_code}}">
                    </div>
                    <div class="form-group text-start mb-4">
                        <span>PayTm Id</span>
                        <label for="email"><i class="ti ti-arrow-right"></i></label>
                        <input class="form-control" id="upi_one" name="upi_one" type="text"
                            placeholder="Enter Your PayTm Id" style="border-color: white;" value="{{ $user->upi_one }}">
                    </div>
                    <div class="form-group text-start mb-4">
                        <span>Google Pay Id</span>
                        <label for="email"><i class="ti ti-arrow-right"></i></label>
                        <input class="form-control" id="upi_two" name="upi_two" type="text"
                            placeholder="Enter Your Google Pay Id" style="border-color: white;" value="{{ $user->upi_two}}">
                    </div>
                    <div class="form-group text-start mb-4">
                        <span>PhonePe Id</span>
                        <label for="email"><i class="ti ti-arrow-right"></i></label>
                        <input class="form-control" id="upi_three" name="upi_three" type="text"
                            placeholder="Enter Your PhonePe Id" style="border-color: white;" value="{{ $user->upi_three }}">
                    </div>

                    <button class="btn btn-warning btn-lg w-100" type="submit">Update</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
<br>


@include('Include.FooterMenu')
