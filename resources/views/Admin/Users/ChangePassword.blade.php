<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Password Change</h5>
                <div class="card-body">
                    {{Form::open(array('route' => array('users.update', $user->user_id), 'method' => 'PUT', 'onsubmit' => 'return validatePassword()'))}}
                    <div class="form-floating" hidden>
                        <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" required>
                        <input type="text" class="form-control" id="name" name="role" value="{{$user->role}}" required>
                        <input type="text" class="form-control" id="name" name="status" value="{{$user->status}}" required>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="oldPassword" name="oldpassword" required>
                        <label for="oldPassword">Current Password</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="newPassword" name="password" required>
                        <label for="newPassword">New Password</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="confirmPassword" name="confermpassword" required>
                        <label for="confirmPassword">Confirm New Password</label>
                        <div id="passwordHelp" class="form-text text-danger" style="display: none;">
                            Passwords do not match!
                        </div>
                    </div>
                    <div class="row justify-content-end mt-3">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function validatePassword() {
        var oldPassword = document.getElementById("oldPassword").value;
        var newPassword = document.getElementById("newPassword").value;
        var confirmPassword = document.getElementById("confirmPassword").value;

        if (newPassword !== confirmPassword) {
            document.getElementById("passwordHelp").style.display = "block";
            return false;
        } else {
            document.getElementById("passwordHelp").style.display = "none";
        }

        return true;
    }
</script>