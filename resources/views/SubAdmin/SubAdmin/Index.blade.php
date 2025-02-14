@php
$currentUser = getCurrentUser();
@endphp

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        @if (session('password_change_alert'))
                        <div class="card-body" id="passwordAlert">
                            <h5 class="card-title danger" style="color: red;">
                                {{ session('password_change_alert') }}
                            </h5>
                        </div>

                        <script>
                            setTimeout(function() {
                                document.getElementById("passwordAlert").style.display = "none";
                            }, 3000); // Hides the message after 5 seconds
                        </script>
                        @endif
                    </div>
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Welcome {{ $currentUser->name }} 🎉</h5>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4" style="margin-bottom: 10px;">
                            <img src="..\themeAssets\img\matka\matka.png" height="140" alt="View Badge User"
                                data-app-dark-img="..\themeAssets\img\matka\matka.png"
                                data-app-light-img="..\themeAssets\img\matka\matka.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Order Statistics -->
            <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h3 class="mb-1">{{ $currentUser->name }}</h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-6">
                            <div class="d-flex flex-column align-items-center gap-1">
                                <h3 class="mb-1"></h3>
                            </div>
                            <br>
                        </div>
                        <ul class="p-0 m-0">
                            <li class="d-flex align-items-center mb-5">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Personal Details</h6>
                                        <small>Name:- {{ $currentUser->name}}</small><br>
                                        <small>Email:- {{ $currentUser->email}}</small><br>
                                        <small>Phone no:- {{ $currentUser->phone}}</small><br>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-5">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Bank Details</h6>
                                        <small>Bank Name:- {{ $currentUser->bank_name}}</small><br>
                                        <small>Bank Holder Name:- {{ $currentUser->ac_holder_name}}</small><br>
                                        <small>AC no.:- {{ $currentUser->ac_number}}</small><br>
                                        <small>{{ $currentUser->ifsc_code}}</small>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-5">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">UPI Details</h6>
                                        <small>UPI 1 :- {{ $currentUser->upi_one}}</small><br>
                                        <small>UPI 1 :- {{ $currentUser->upi_two}}</small><br>
                                        <small>UPI 1 :- {{ $currentUser->upi_three}}</small><br>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <a class="dropdown-item btn btn-info" href="{{ route('profileUpdatepage')}}"><i class="bx bx-edit-alt me-1"></i> Update Profile</a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h3 class="mb-1">Other Info</h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-6">
                            <div class="d-flex flex-column align-items-center gap-1">
                                <h3 class="mb-1"></h3>
                            </div>
                            <br>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h3 class="mb-1">Wallet Details</h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-6">
                            <div class="d-flex flex-column align-items-center gap-1">
                                <h3 class="mb-1"></h3>
                            </div>
                            <br>
                        </div>
                        <ul class="p-0 m-0">
                            <li class="d-flex align-items-center mb-5">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Wallet Balance</h6>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="mb-0">Rs- {{ $wallet->balance ?? 'NA' }}</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-5">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Total Players</h6>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="mb-0">{{ count($players) }}</h6>
                                    </div>
                                </div>
                            </li>


                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>