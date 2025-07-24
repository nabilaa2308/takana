<?php
$username = $_SESSION['login']['username'];

$menu = new menu();
$transaksi = new transaksi();

$menuCount = $menu->getTotal();
$transaksiCount = $transaksi->getTotal();

?>

<main class="container">
  <h1>Dashboard</h1>
  <div class="box">
    Selamat Datang,<br>
    Kamu Login Sebagai <strong><?= htmlspecialchars($username) ?></strong>
  </div>
  <div class="card-wrapper" style="display: flex; gap: 20px; margin-top: 30px;">
    <div class="card" style="flex:1; background:#f5f5f5; padding:20px; border-radius:10px; text-align:center;">
      <h3>Jumlah Menu</h3>
      <p style="font-size: 24px; font-weight: bold;"><?= $menuCount ?></p>
    </div>
    <div class="card" style="flex:1; background:#f5f5f5; padding:20px; border-radius:10px; text-align:center;">
      <h3>Jumlah Transaksi</h3>
      <p style="font-size: 24px; font-weight: bold;"><?= $transaksiCount ?></p>
    </div>
  </div>
</main>