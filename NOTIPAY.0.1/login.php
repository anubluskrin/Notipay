<?php
include 'connect.php';
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    
    if (mysqli_num_rows($user) == 1) {
        $data = mysqli_fetch_assoc($user);

        if (password_verify($password, $data['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['username'] = $data['username'];

            echo "<script>window.location='main.php';</script>";
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
<div class="hero-vid">
      <video loop autoplay muted plays-inline class="hero-video">
        <source src="assets/vid-2.mp4" type="video/mp4">
      </video>

<div class="back-login">
  <div class="center-login">
    <div class="content-login">
  <h3 class="text-center" style="color: white">LOGIN</h3>

  <form method="post">
    <div class="mb-2">
      <label for="username"></label>
      <input type="text" name="username" placeholder="Username" required class="form-control">
    </div>

    <div class="mb-4">
      <label for="pass"></label>
      <input type="password" name="password" placeholder="Password" required class="form-control">
    </div>

  <div class="d-grid">
    <button type="submit" name="login" class="mt-3 btn back-btn mb-2">Login</button>
    <p style="color : white">Belum punya Akun ? <a href="register.php" style="color : #a085ffff">Daftar disini</a></p>
  </div>

  </form>
    </div>
  </div>
</div>

</body>
</html>
