<!DOCTYPE html>
@php $setting = getThemeOptions('header') @endphp
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="<?php echo assetPath(''); ?>" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ isset($setting['meta_title']) ? $setting['meta_title'] : 'Dashboard | King' }}</title>

    <meta name="keyword" content="{{ isset($setting['meta_keyword']) ? $setting['meta_keyword'] : 'King' }}" />

    <meta name="description"
        content="{{ isset($setting['meta_description']) ? $setting['meta_description'] : 'King' }}" />

    <!-- Favicon -->
    @if (isset($setting['headerfavicon']) && $setting['headerfavicon'])
    <link rel="icon" type="image/x-icon" href="<?php echo asset($setting['headerfavicon']); ?>" />
    @endif

    @Include('Common.Style')
    @laravelPWA
</head>

<body>
    @php $currentUser = getCurrentUser(); @endphp
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="javascript:void(0);" class="app-brand-link">
                        @if (isset($setting['headerlogo']) && $setting['headerlogo'])
                        <img src="<?php echo asset($setting['headerlogo']); ?>" style="max-width: 110px;" alt class="h-auto" />
                        @else
                        <span>King App </span>
                        @endif
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    @foreach (getMenus() as $menu)
                    @if (in_array($currentUser->role, $menu['role']))
                    <li class="menu-item {{ \Request::route()->getName() == $menu['route'] ? 'active' : '' }}">
                        <a href="{{ route($menu['route']) }}" class="menu-link">
                            <i class="menu-icon {{ $menu['icon'] }}"></i>
                            <div data-i18n="Analytics">{{ $menu['title'] }}</div>
                        </a>
                    </li>
                    @endif
                    @endforeach

                    @foreach (postTypes() as $postKey => $postValue)
                    @if (in_array($currentUser->role, $postValue['role']))
                    <li class="menu-item" style="">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon <?php echo $postValue['icon']; ?>"></i>
                            <div data-i18n="Layouts"><?php echo $postValue['title']; ?></div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="<?php echo route('post.index', ['postType' => $postKey]); ?>" class="menu-link">
                                    <div data-i18n="Without menu">View</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo route('post.create', ['postType' => $postKey]); ?>" class="menu-link">
                                    <div data-i18n="Without navbar">Add</div>
                                </a>
                            </li>
                            @if (!empty($postValue['taxonomy']))
                            @foreach ($postValue['taxonomy'] as $taxonomyKey => $taxonomyValue)
                            <li class="menu-item">
                                <a href="<?php echo route('taxonomy.index', ['postType' => $postKey, 'taxonomy' => $taxonomyKey]); ?>" class="menu-link">
                                    <div data-i18n="Without navbar"><?php echo $taxonomyValue['title']; ?></div>
                                </a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        @if (isset($setting['headerlogo']))
                                        <img src="{{ publicPath($setting['headerlogo']) }}" alt class="w-px-40 h-auto rounded-circle" />
                                        @else
                                        <img src="<?php echo assetPath('..\themeAssets\img\King\King.png'); ?>" alt class="w-px-40 h-auto rounded-circle" />
                                        @endif
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        @if (isset($setting['headerlogo']))
                                                        <img src="{{ publicPath($setting['headerlogo']) }}" alt
                                                            class="w-px-40 h-auto rounded-circle" />
                                                        @else
                                                        <img src="<?php echo assetPath('img/avatars/1.png'); ?>" alt
                                                            class="w-px-40 h-auto rounded-circle" />
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">{{ $currentUser->name }}</span>
                                                    <small class="text-muted">{{ $currentUser->role }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <!-- <li>
                                        <a class="dropdown-item" href="<?php echo route('themes.index'); ?>">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo route('clear-cache'); ?>">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Clear Cache</span>
                                        </a>
                                    </li> -->
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('changePassword') }}">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Change Password</span>
                                        </a>
                                        <a class="dropdown-item" href="{{ route('auth.logout') }}">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="col-md-12">
                        @if (Session::has('info'))
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="alert alert-primary alert-dismissible" role="alert">
                                {{ Session::get('info') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
                        @if (Session::has('success'))
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
                        @if (Session::has('danger'))
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ Session::get('danger') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
                        @if (Session::has('warning'))
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                {{ Session::get('warning') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>