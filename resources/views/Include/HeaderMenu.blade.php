@php
$headerOption = getThemeOptions('header');
$homePage = getThemeOptions('homePage');
@endphp

<div class="header-area" id="headerArea">
    <div class="container h-100 d-flex align-items-center justify-content-between d-flex rtl-flex-d-row-r">
        <!-- Logo Wrapper -->
         @if(isset($headerOption['headerlogo']))
        <div class="logo-wrapper"><a href=""><img src="{{ publicPath($headerOption['headerlogo']) }}" alt="headerLogo" style="height: 50px;"></a>
            @else
            <div class="logo-wrapper"><a href=""><img src="..\themeAssets\img\matka\matka.png" alt="headerLogo" style="height: 50px;"></a>
        @endif
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


