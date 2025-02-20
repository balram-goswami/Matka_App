<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    <meta name="description" content="Matka App - Login Page">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#625AFA">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above tags *must* come first in the head, any other head content must come *after* these tags -->
    <!-- Title -->
    <title>Matka App - Login Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="img/icons/icon-72x72.png">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" href="img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/icons/icon-180x180.png">
    <!-- CSS Libraries -->
    @include('Include.Style')
</head>

<body>
    <!-- Preloader-->
    <div class="preloader" id="preloader">
        <div class="spinner-grow text-secondary" role="status">
            <div class="sr-only"></div>
        </div>
    </div>
    <!-- Login Wrapper Area-->
    <div class="login-wrapper d-flex align-items-center justify-content-center text-center">
        <!-- Background Shape-->
        <div class="background-shape"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10 col-lg-8"><img class="big-logo" src="..\themeAssets\img\matka\matka.png" alt="" >
                    <!-- Register Form-->
                    <div class="register-form mt-5">
                        <form action="{{ route('login.store') }}" method="POST" class="login mb-3"
                            id="formAuthentication">
                            @csrf
                            <div class="form-group text-start mb-4"><span>User Name</span>
                                <label for="name"><i class="ti ti-user"></i></label>
                                <input class="form-control" type="name" id="name" name="name" placeholder="Enter User Name">
                            </div>
                            <div class="form-group text-start mb-4"><span>Password</span>
                                <label for="password"><i class="ti ti-key"></i></label>
                                <input class="form-control" id="password" type="password" name="password" placeholder="Password">
                            </div>
                            <button class="btn btn-warning btn-lg w-100" type="submit">Log In</button>
                        </form>
                    </div>
                    <!-- Login Meta-->
                    <!-- <div class="login-meta-data"><a class="forgot-password d-block mt-3 mb-1" href="{{ ('forgot-password.index') }}">Forgot Password?</a>
                        <p class="mb-0">Don’t have any account?<a class="mx-1" href="{{ route('registerpage') }}">SignUp</a></p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- All JavaScript Files-->
    @include('Include.Script')
</body>

</html>