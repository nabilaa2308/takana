<?php
session_start();

include 'config/confiq.php';
include 'helper/FlashSession.php';
include 'page/auth/auth.php';

if (isset($_SESSION['login'])) {
  header('location:page/dashboard/index.php?page=dashboard');
}

if ($_POST) {
  $auth = new auth();
  if ($auth->login()) {
    setFlash('success', 'Login berhasil!');
    header('Location: page/dashboard/index.php?page=dashboard');
    exit;
  } else {
    header('Location: login.php');
    exit;
  }
}

$success = getFlash('success');
$error = getFlash('error');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/local/icon.png" rel="icon">
  <title>Login</title>
  <link rel="stylesheet" href="assets/dashboard/css/style.css" />
</head>

<body class="center-screen">

  <div class="register-form">
    <div class="logo-center">
      <img src="assets/local/logo2.png" alt="Logo" />
    </div>

    <form id="formRegister" method="POST">
      <label>Username</label>
      <input type="text" name="username" required />

      <label>Password</label>
      <input type="password" name="password" required />

      <div class="form-footer">
        <a href="#"></a>
        <button type="submit">Login</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    <?php if ($success): ?>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '<?= $success ?>',
        timer: 2000,
        showConfirmButton: false
      }).then(() => {
        window.location.href = 'page/dashboard/index.php?page=dashboard';
      });
    <?php elseif ($error): ?>
      Swal.fire({
        icon: 'error',
        title: 'Gagal Login',
        text: '<?= $error ?>',
      });
    <?php endif; ?>
  </script>

</body>

</html>