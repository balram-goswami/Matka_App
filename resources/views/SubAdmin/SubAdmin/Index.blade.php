@php
$currentUser = getCurrentUser();
@endphp

@if($currentUser->status === 'BlockByAdmin')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">

                        <div class="card-body">
                            <h5 class="card-title text-primary">User Name: {{ $currentUser->name }} 🎉</h5>
                            <h5 class="card-title text-primary">Your account and your all Players account has been blocked by the admin. Please contact the admin for assistance in unblocking it.</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@else
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        @if($pwdMsg->created_at->eq($pwdMsg->updated_at))
                        <div class="card-body" id="passwordAlert">
                            <h5 class="card-title danger" style="color: red;">
                                Hello {{$currentUser->name}}, please change your password before continuing to use your account. If done, ignore.
                            </h5>
                        </div>

                        <script>
                            setTimeout(function() {
                                document.getElementById("passwordAlert").style.display = "none";
                            }, 5000);
                        </script>
                        @endif
                    </div>

                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Welcome {{ $currentUser->name }} 🎉</h5>
                            <h5 class="card-title text-primary">Balance: {{ number_format($wallet->balance, 2) ?? 'NA' }}</h5>
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
            <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-6">
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
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-5">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Wallet Balance</h6>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="mb-0">Rs: {{ number_format($wallet->balance, 2) ?? 'NA' }}</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-5">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0"><a href="{{ route('viewPlayers') }}">Total Players</a></h6>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="mb-0">{{ count($players) }}</h6>
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

            <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h3 class="mb-1">Game Ratio</h3>
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
                                        <h6 class="mb-0">Toss Game Rate</h6>
                                        <h6 class="mb-0">Commission %</h6>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="mb-0">{{ $currentUser->toss_game_rate ?? 'NA' }} X</h6>
                                        <h6 class="mb-0">{{ $currentUser->toss_game_commission ?? 'NA' }} %</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-5">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Crossing Rate</h6>
                                        <h6 class="mb-0">Commission %</h6>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="mb-0">{{ $currentUser->crossing_game_rate ?? 'NA' }} X</h6>
                                        <h6 class="mb-0">{{ $currentUser->crossing_commission ?? 'NA' }} %</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-5">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Harf Rate</h6>
                                        <h6 class="mb-0">Commission %</h6>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="mb-0">{{ $currentUser->harf_game_rate ?? 'NA' }} X</h6>
                                        <h6 class="mb-0">{{ $currentUser->harf_commission ?? 'NA' }} %</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center mb-5">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Jodi Rate</h6>
                                        <h6 class="mb-0">Commission %</h6>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="mb-0">{{ $currentUser->jodi_game_rate ?? 'NA' }} X</h6>
                                        <h6 class="mb-0">{{ $currentUser->jodi_commission ?? 'NA' }} %</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-football"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">ODD EVEN Rate</h6>
                                        <h6 class="mb-0">Commission %</h6>
                                    </div>
                                    <div class="user-progress">
                                        <h6 class="mb-0">{{ $currentUser->oddEven_game_rate ?? 'NA' }} X</h6>
                                        <h6 class="mb-0">{{ $currentUser->oddEven_commission ?? 'NA' }} %</h6>
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

@endif