<?php
$con = mysqli_connect("localhost", "root", "", "angkringan");

function query($query)
{
    global $con;
    $result = mysqli_query($con, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function registrasi($data)
{
    global $con;

    $username = strtolower(stripcslashes($data["username"]));
    $password = mysqli_real_escape_string($con, $data["password"]);
    $password2 = mysqli_real_escape_string($con, $data["password2"]);

    $result = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "
	<script>
	alert('Username sudah terdaftar');
	</script>";
        return false;
    }

    if ($password !== $password2) {
        echo "
	<script>
	alert('Konfirmasi Password tidak sesuai');
	</script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($con, "INSERT INTO users VALUES('','$username','$password')");

    return mysqli_affected_rows($con);
}
