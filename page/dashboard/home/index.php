<?php
$username = $_SESSION['login']['username'];
?>

<main class="container">
  <h1>Dashboard</h1>
  <div class="box">
    Selamat Datang,<br> 
    Kamu Login Sebagai <strong><?= htmlspecialchars($username) ?></strong>
  </div>
</main>