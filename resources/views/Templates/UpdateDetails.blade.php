@include('Include.HeaderMenu')

<div class="login-wrapper d-flex align-items-center justify-content-center text-center">
    <div class="background-shape"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-lg-8">
                <div class="register-form mt-5">
                    {{ Form::open(['route' => ['users.update', $user->user_id], 'method' => 'PUT']) }}
                    @csrf
                    <div class="form-group text-start mb-4" hidden>
                        <label for="status"><i class="ti ti-user"></i></label>
                        <input class="form-control" id="status" name="status" type="text"
                            value="{{ $user->status ?? old('status') }}"
                            style="border-color: white;">
                    </div>
                    <div class="form-group text-start mb-4" hidden>
                        <label for="status"><i class="ti ti-user"></i></label>
                        <input class="form-control" id="parent" name="parent" type="text"
                            value="{{ $user->parent}}"
                            style="border-color: white;">
                    </div>
                    <input type="text" name="toss_game_rate" value="{{$user->toss_game_rate}}" hidden />
                    <input type="text" name="crossing_game_rate" value="{{$user->crossing_game_rate}}" hidden />
                    <input type="text" name="harf_game_rate" value="{{$user->harf_game_rate}}" hidden />
                    <input type="text" name="oddEven_game_rate" value="{{$user->oddEven_game_rate}}" hidden />
                    <input type="text" name="jodi_game_rate" value="{{$user->jodi_game_rate}}" hidden />
                    <input type="text" name="toss_game_commission" value="{{$user->toss_game_commission}}" hidden />
                    <input type="text" name="crossing_commission" value="{{$user->crossing_commission}}" hidden />
                    <input type="text" name="harf_commission" value="{{$user->harf_commission}}" hidden />
                    <input type="text" name="oddEven_commission" value="{{$user->oddEven_commission}}" hidden />
                    <input type="text" name="jodi_commission" value="{{$user->jodi_commission}}" hidden />

                    <div class="form-group text-start mb-4">
                        <span>Name</span>
                        <label for="name"><i class="ti ti-user"></i></label>
                        <input class="form-control" id="name" name="name" type="text"
                            placeholder="Enter Name" value="{{ $user->name ?? old('name') }}"
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