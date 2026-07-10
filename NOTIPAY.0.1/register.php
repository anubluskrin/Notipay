<?php
session_start();
include 'connect.php';


if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // cek user sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah digunakan!');</script>";
    } else {
        mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="hero-vid">
      <video loop autoplay muted plays-inline class="hero-video">
        <source src="assets/hero-1.mp4" type="video/mp4">
      </video>


<div class="back-login">
  <div class ="center-login">
    <div class ="content-login">
  <h3 class="text-center" style="color : white">REGISTER</h3>

  <form method="post">
    <div class="mb-2">
      <label></label>
      <input type="text" name="username" required placeholder="Username" class="form-control">
    </div>
    <div class="mb-4">
      <label></label>
      <input type="password" name="password" required placeholder="Password" class="form-control">
    </div>

  <div class=d-grid>
    <button type="submit" name="register" class="btn back-btn mt-4 mb-2">Daftar</button>
    <p style="color : white">Sudah punya akun ? <a href="login.php">login disini</a></p>
  </div>
  </form>
  </div>
</div>
</div>

</body>
</html>
