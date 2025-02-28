<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    <meta name="description" content="Matka App - Login Page">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#625AFA">
    <title>Matka App - Login Page</title>
    <link rel="icon" href="img/icons/icon-72x72.png">
    <!-- CSS Libraries -->
    @include('Include.Style')
    @php
    $homePage = getThemeOptions('homePage');
    $logo = getThemeOptions('header');
    @endphp
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
                <div class="col-10 col-lg-8">
                    @if(isset($logo['headerlogo']))
                    <img class="big-logo" src="{{ publicPath($logo['headerlogo']) }}" alt="">
                    @else
                    <img class="big-logo" src="..\themeAssets\img\matka\matka.png" alt="">
                    @endif

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
                            <button class="btn btn-warning btn-lg w-100" style="background-color: #FFB80C; color: white;" type="submit">Log In</button>
                        </form>
                    </div>

                    @isset($homePage['waLink'])
                    <a href="{{ $homePage['waLink'] }}" class="btn btn-warning btn-lg w-100" style="background-color: #30A844; color: white;">
                        <i class="fa-brands fa-whatsapp"></i> Sign Up With WhatsApp Id
                    </a>
                    @endisset
                    <!-- Login Meta-->
                    <!-- <div class="login-meta-data"><a class="forgot-password d-block mt-3 mb-1" href="{{ ('forgot-password.index') }}">Forgot Password?</a>
                        <p class="mb-0">Don’t have any account?<a class="mx-1" href="{{ route('registerpage') }}">SignUp</a></p>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    @isset($homePage['copyright'])
    <footer class="text-center" style="background-color: black;">
        @if(isset($logo['headerlogo']))
        <img src="{{ publicPath($logo['headerlogo']) }}" alt="Website Logo" style="width: 50px; height: auto;">
        @else
        <img src="..\themeAssets\img\matka\matka.png" alt="Website Logo" style="width: 50px; height: auto;">
        @endif
        <p class="mt-2" style="color: #fff;">&copy; {{ $homePage['copyright'] }}</p>
    </footer>
    @endisset
    <!-- All JavaScript Files-->
    @include('Include.Script')
</body>

</html>