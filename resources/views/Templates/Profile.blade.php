@include('Include.HeaderMenu')

<div class="page-content-wrapper">
    <div class="container">
        <!-- Profile Wrapper-->
        <div class="profile-wrapper-area py-3">
            <!-- User Information-->
            <div class="card user-info-card">
                <div class="card-body p-4 d-flex align-items-center">
                    @if(isset($user->photo))
                    <div class="user-profile me-3"><img src="{{ publicPath($user->photo)}}" alt=""></div>
                    @else
                    <div class="user-profile me-3"><img src="../themeAssets/img/bg-img/9.jpg" alt=""></div>
                    @endif
                    <div class="user-info">
                        <p class="mb-0 text-dark">{{ $user->email}}</p>
                        <h5 class="mb-0">{{ $user->name}}</h5>
                    </div>
                </div>
            </div>
            <!-- User Meta Data-->
            <div class="card user-data-card">
                <div class="card-body">
                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                        <div class="title d-flex align-items-center"><i class="ti ti-user"></i><span>Name</span>
                        </div>
                        <div class="data-content">{{ $user->name ?? 'Not available' }}</div>
                    </div>

                    <label>Bank Account Details</label>
                    <br>
                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                        <div class="title d-flex align-items-center"><i class="ti ti-user"></i><span>Bank Name</span>
                        </div>
                        <div class="data-content">{{ $user->bank_name ?? 'Not available' }}</div>
                    </div>
                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                        <div class="title d-flex align-items-center"><i class="ti ti-user"></i><span>A/C Holder Name</span>
                        </div>
                        <div class="data-content">{{ $user->ac_holder_name ?? 'Not available' }}</div>
                    </div>
                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                        <div class="title d-flex align-items-center"><i class="ti ti-user"></i><span>A/c Number</span>
                        </div>
                        <div class="data-content">{{ $user->ac_number ?? 'Not available' }}</div>
                    </div>
                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                        <div class="title d-flex align-items-center"><i class="ti ti-user"></i><span>IFSC Number</span>
                        </div>
                        <div class="data-content">{{ $user->ifsc_code ?? 'Not available' }}</div>
                    </div>
                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                        <div class="title d-flex align-items-center"><i class="ti ti-user"></i><span>PayTm Id</span>
                        </div>
                        <div class="data-content">{{ $user->upi_one ?? 'Not available' }}</div>
                    </div>
                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                        <div class="title d-flex align-items-center"><i class="ti ti-user"></i><span>Google Pay Id</span>
                        </div>
                        <div class="data-content">{{ $user->upi_two ?? 'Not available' }}</div>
                    </div>
                    <div class="single-profile-data d-flex align-items-center justify-content-between">
                        <div class="title d-flex align-items-center"><i class="ti ti-user"></i><span>PhonePe Id</span>
                        </div>
                        <div class="data-content">{{ $user->upi_three ?? 'Not available' }}</div>
                    </div>

                    <!-- Edit Profile-->
                    <div class="edit-profile-btn mt-3">
                        <a class="btn btn-primary btn-lg w-100"
                            href="{{ route('profileUpdate') }}"><i class="ti ti-pencil me-2"></i>Edit Profile</a>
                    </div>
                    <div class="edit-profile-btn mt-3"><a class="btn btn-primary btn-lg w-100"
                            href="{{ route('profileUpdate') }}"><i class="ti ti-pencil me-2"></i>Change Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Include.FooterMenu')