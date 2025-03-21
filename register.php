<?php
require 'function.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "
		<script>
		alert('User baru telah ditambahkan');
		</script>";
    } else {
        echo mysqli_error($con);
    }
}
?>
<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Daftar</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="center">
        <h1>Registrasi</h1>
        <form method="post">
            <div class="txt_field">
                <input type="text" name="username" id="username" required>
                <span></span>
                <label>Username</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" id="password" required>
                <span></span>
                <label>Password</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password2" id="password2" required>
                <span></span>
                <label>Confirm Password</label>
            </div>
            <input type="submit" name="register" value="Sign Up">
            <div class="signup_link">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </form>
    </div>

</body>

</html>