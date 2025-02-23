@include('Include.HeaderMenu')

<div class="login-wrapper d-flex align-items-center justify-content-center text-center">
    <!-- Background Shape-->
    <div class="background-shape"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-lg-8">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @else
                <!-- Register Form-->
                <div class="register-form mt-5">
                    {{ Form::open(['route' => ['users.update', $user->user_id], 'method' => 'PUT']) }}
                    @csrf
                    <div class="form-group text-start mb-4" hidden>
                        <label for="status"><i class="ti ti-user"></i></label>
                        <input class="form-control" id="status" name="status" type="status"
                            value="{{ $user->status ?? old('status') }}"
                            style="border-color: white;">
                    </div>

                    <div class="form-group text-start mb-4" hidden>
                        <span>Name</span>
                        <label for="name"><i class="ti ti-user"></i></label>
                        <input class="form-control" id="name" name="name" type="name"
                            placeholder="Enter Name" value="{{ $user->name ?? old('name') }}"
                            style="border-color: white;">
                    </div>

                    <input hidden id="role" name="role" value="{{ $user->role }}">
                    <div class="form-group text-start mb-4" hidden>
                        <label for="status"><i class="ti ti-user"></i></label>
                        <input class="form-control" id="parent" name="parent" type="text"
                            value="{{ $user->parent}}"
                            style="border-color: white;">
                    </div>

                    <div class="form-group text-start mb-4">
                        <span>Old Password</span>
                        <label><i class="ti ti-arrow-right"></i></label>
                        <input class="form-control" id="old_password" name="old_password" type="text"
                            placeholder="Enter Old Password" style="border-color: white;">
                    </div>
                    <div class="form-group text-start mb-4">
                        <span>New PassWord</span>
                        <label><i class="ti ti-arrow-right"></i></label>
                        <input class="form-control" id="password" name="password" type="text"
                            placeholder="Enter New PassWord" style="border-color: white;">
                    </div>
                    <div class="form-group text-start mb-4">
                        <span>Confirm Password</span>
                        <label><i class="ti ti-arrow-right"></i></label>
                        <input class="form-control" id="confirm_password" name="confirm_password" type="text"
                            placeholder="Enter Confirm Password" style="border-color: white;">
                    </div>

                    <button class="btn btn-warning btn-lg w-100" type="submit">Update</button>
                    </form>

                </div>
                @endif

            </div>
        </div>
    </div>
</div>
<br><br>
<br>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector(".register-form form");
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirm_password");

        form.addEventListener("submit", function(event) {
            if (password.value !== confirmPassword.value) {
                event.preventDefault(); // Prevent form submission
                alert("New Password and Confirm Password do not match!");
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let alertBox = document.querySelector(".alert");
        if (alertBox) {
            setTimeout(function () {
                alertBox.style.transition = "opacity 0.5s";
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 500);
            }, 3000); // Hides after 3 seconds
        }
    });
</script>


@include('Include.FooterMenu')