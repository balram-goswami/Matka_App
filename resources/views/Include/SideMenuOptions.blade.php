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
                <h5 class="user-name mb-1 text-white">{{$user->name}}</h5>
                <p class="available-balance text-white">Balance :- 
                    @if(isset($wallet->balance))
                    <span class="counter">{{ $wallet->balance }}</span>
                    @endif
                </p>
            </div>
        </div>
        <!-- Sidenav Nav-->
        <ul class="sidenav-nav ps-0">
            <li><a href="{{ route('profile')}}"><i class="ti ti-user"></i>My Profile</a></li>
            <li><a href="notifications.html"><i class="ti ti-bell-ringing lni-tada-effect"></i>Notifications<span
                        class="ms-1 badge badge-warning">3</span></a></li>
            
            <li><a href="settings.html"><i class="ti ti-adjustments-horizontal"></i>Settings</a></li>
            <li><a href="{{ route('auth.logout')}}"><i class="ti ti-logout"></i>Sign Out</a></li>
        </ul>
    </div>
</div>
