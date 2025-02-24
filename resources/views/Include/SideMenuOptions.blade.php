<div class="offcanvas offcanvas-start suha-offcanvas-wrap" tabindex="-1" id="suhaOffcanvas"
    aria-labelledby="suhaOffcanvasLabel">
    <!-- Close button-->
    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    <!-- Offcanvas body-->
    <div class="offcanvas-body">
        <!-- Sidenav Profile-->
        <div class="sidenav-profile">
            <div class="user-profile"><img src="../themeAssets/img/bg-img/9.jpg" alt=""></div>
            <div class="user-info">
                <h5 class="user-name mb-1 text-white">{{ $user->name }}</h5>
                <p class="available-balance text-white">Balance :
                    @if (isset($wallet->balance))
                    <span class="counter">{{ $wallet->balance }}</span>
                    @endif
                </p>
            </div>
            <div class="user-info">

                @if(isset($exposer) && $exposer->sum('subadmin_amount') > 0)
                <p class="available-balance text-white">Exposure :
                    <span class="counter">{{ $exposer->sum('subadmin_amount') }}</span>
                </p>
                @endif
            </div>
        </div>
        @php
        $homePage = getThemeOptions('homePage');
        @endphp
        <!-- Sidenav Nav-->
        <ul class="sidenav-nav ps-0">
            <li><a href="{{ route('profile') }}"><i class="ti ti-user"></i>My Profile</a></li>
            <li><a href="{{ route('myBids') }}"><i class="ti ti-bell-ringing lni-tada-effect"></i>My Bids</a></li>
            <li><a href="{{ route('transaction') }}"><i class="ti ti-adjustments-horizontal"></i>Transaction</a></li>
            <li><a href="{{ $homePage['chartUrl'] ?? '#'}}" target="_blank"><i class="ti ti-adjustments-horizontal"></i>Results</a></li>
            <li>
                <div class="card settings-card">
                    <div class="card-body">
                        <!-- Single Settings-->
                        <div class="single-settings d-flex align-items-center justify-content-between">
                            <div class="title"><i class="ti ti-moon"></i><span>Night Mode</span></div>
                            <div class="data-content">
                                <div class="toggle-button-cover">
                                    <div class="button r">
                                        <input class="checkbox" id="darkSwitch" type="checkbox">
                                        <div class="knobs"></div>
                                        <div class="layer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <br>
            <li><a href="{{ route('pwsChange') }}"><i class="ti ti-adjustments-horizontal"></i>Change Password</a></li>
            <li><a href="{{ route('auth.logout') }}"><i class="ti ti-logout"></i>Sign Out</a></li>
        </ul>
    </div>
</div>