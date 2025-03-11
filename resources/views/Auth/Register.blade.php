<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    <meta name="description" content="King App - Register Page">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#625AFA">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above tags *must* come first in the head, any other head content must come *after* these tags -->
    <!-- Title -->
    <title>King App - Register Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap"
        rel="stylesheet">
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
                <div class="col-10 col-lg-8"><img class="big-logo" src="..\themeAssets\img\matka\king.png"
                        alt="">
                    <!-- Register Form-->
                    <div class="register-form mt-5">
                        <form action="{{ route('registernow') }}" method="POST" class="login mb-3">
                            @csrf
                            <div class="form-group text-start mb-4"><span>Name</span>
                                <label for="email"><i class="ti ti-user"></i></label>
                                <input class="form-control" id="name" name="name" type="text"
                                    placeholder="Enter Your Name" value="{{ old('name') }}"
                                    style="border-color: white;">
                            </div>
                            <div class="form-group text-start mb-4"><span>Email Id</span>
                                <label for="email"><i class="ti ti-mail"></i></label>
                                <input class="form-control" id="email" name="email" type="email"
                                    placeholder="Enter Email Id" value="{{ old('email') }}"
                                    style="border-color: white;">
                            </div>
                            <div class="form-group text-start mb-4"><span>Phone</span>
                                <label for="email"><i class="ti ti-phone"></i></label>
                                <input class="form-control" id="phone" name="phone" type="tel"
                                    placeholder="Phone Number" value="{{ old('phone') }}" style="border-color: white;">
                            </div>
                            <div class="form-group text-start mb-4">
                                <span>Password</span>
                                <label for="password"><i class="ti ti-lock"></i></label>
                                <input class="form-control" id="password" name="password" type="password" placeholder="Enter Password" style="border-color: white;">
                            </div>
                            <div class="form-group text-start mb-4">
                                <span>Confirm Password</span>
                                <label for="password_confirmation"><i class="ti ti-lock"></i></label>
                                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm Password" style="border-color: white;">
                            </div>
                            <button class="btn btn-warning btn-lg w-100" type="submit">Register</button>
                        </form>

                    </div>
                    <!-- Login Meta-->
                    <div class="login-meta-data">
                        <p class="mb-0">Do you have any account ?<a class="mx-1"
                                href="{{ route('login.index') }}">LogIn</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function validateForm() {
            const phone = document.getElementById('phone')?.value; // Optional chaining for safety
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
    
            // Check if the phone number is valid
            if (phone && (phone.length !== 10 || !/^\d{10}$/.test(phone))) {
                alert("Phone number must be exactly 10 digits.");
                return false;
            }
    
            // Check if both passwords match
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
    
            return true; // Allow form submission
        }
    </script>
    <!-- All JavaScript Files-->
    @include('Include.Script')
</body>

</html>
