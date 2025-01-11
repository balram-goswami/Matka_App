<!DOCTYPE html>
@php $setting = getThemeOptions('header') @endphp
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="<?php echo assetPath(''); ?>" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ isset($setting['meta_title']) ? $setting['meta_title'] : 'Forgot Password | Max The Gurukul' }}</title>

    <meta name="keyword" content="{{ isset($setting['meta_keyword']) ? $setting['meta_keyword'] : 'Max The Gurukul' }}" />

    <meta name="description"
        content="{{ isset($setting['meta_description']) ? $setting['meta_description'] : 'Max The Gurukul' }}" />

    <!-- Favicon -->
    @if (isset($setting['headerfavicon']) && $setting['headerfavicon'])
        <link rel="icon" type="image/x-icon" href="<?php echo asset($setting['headerfavicon']); ?>" />
    @else
        <link rel="icon" type="image/x-icon" href="<?php echo assetPath('img/favicon/favicon.ico'); ?>" />
    @endif

    @Include('Common.Style')
    <link rel="stylesheet" href="<?php echo assetPath('vendor/css/pages/page-auth.css'); ?>" />

</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="https://maxthegurukul.com" class="app-brand-link gap-2">
                                @if (isset($setting['headerlogo']) && $setting['headerlogo'])
                                    <img style="max-width: 110px;" src="<?php echo asset($setting['headerlogo']); ?>" alt class="h-auto" />
                                @else
                                    <span>MaxTheGurukul</span>
                                @endif
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Forgot Password? 🔒</h4>
                        <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
                        <div class="col-md-12">
                            @if (Session::has('info'))
                                <div class="alert alert-primary alert-dismissible" role="alert">
                                    {{ Session::get('info') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    {{ Session::get('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (Session::has('danger'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ Session::get('danger') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (Session::has('warning'))
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    {{ Session::get('warning') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                        </div>
                        <?php echo Form::open(['route' => ['forgot-password.store'], 'method' => 'post', 'class' => 'mb-3', 'id' => 'formAuthentication']); ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" required name="email"
                                placeholder="Enter your email" autofocus />
                        </div>
                        <button class="btn btn-primary d-grid w-100">Send Reset Link</button>
                        </form>
                        <div class="text-center">
                            <a href="<?php echo route('login.index'); ?>" class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                Back to login
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>

    <!-- / Content -->
    @Include('Common.Script')
</body>

</html>
