<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between d-flex rtl-flex-d-row-r">
        <!-- Logo Wrapper -->
        <div class="logo-wrapper"><a href=""><img src="{{$headerOption['headerlogo']}}" alt="headerLogo" style="height: 50px;"></a>
        </div>
        <div class="navbar-logo-container d-flex align-items-center">
            <!-- Cart Icon -->
            <div class="cart-icon-wrap"><i class="ti ti-wallet"></i>
            @if(isset($wallet->balance))
            <span>{{ $wallet->balance}}</span>
            @endif
        </div>
            <!-- User Profile Icon -->
            <div class="user-profile-icon ms-2"><a href="{{ route('profile')}}"><img src="../themeAssets/img/bg-img/9.jpg" alt=""></a>
            </div>
            <!-- Navbar Toggler -->
            <div class="suha-navbar-toggler ms-2" data-bs-toggle="offcanvas" data-bs-target="#suhaOffcanvas"
                aria-controls="suhaOffcanvas">
                <div><span></span><span></span><span></span></div>
            </div>
        </div>
    </div>
</div>


@include('Include.SideMenuOptions')


<!-- PWA Install Alert -->
<div class="toast pwa-install-alert shadow bg-white" role="alert" aria-live="assertive" aria-atomic="true"
    data-bs-delay="5000" data-bs-autohide="true">
    <div class="toast-body">
        <div class="content d-flex align-items-center mb-2"><img src="../themeAssets/img/icons/icon-72x72.png" alt="">
            <h6 class="mb-0">Add to Home Screen</h6>
            <button class="btn-close ms-auto" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
        </div><span class="mb-0 d-block">Click the<strong class="mx-1">Add to Home Screen</strong>button &amp;
            enjoy
            it like a regular app.</span>
    </div>
</div>
