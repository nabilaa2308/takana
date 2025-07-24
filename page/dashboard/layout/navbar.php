  <?php
    $username = $_SESSION['login']['username'];
    ?>
  <nav class="navbar">
      <div class="logo">
          <img src="../../../assets/local/logo2.png" alt="Laravel Logo" />
      </div>
      <ul class="nav-links">
          <li class="<?= $page == 'dashboard' ? 'active' : '' ?>"><a href="index.php?page=dashboard">Dashboard</a></li>
          <li class="<?= $page == 'metode-pembayaran' ? 'active' : '' ?>"><a href="index.php?page=metode-pembayaran">Metode Pembayaran</a></li>
          <li class="<?= $page == 'kategori' ? 'active' : '' ?>"><a href="index.php?page=kategori">Kategori</a></li>
          <li class="<?= $page == 'menu' ? 'active' : '' ?>"><a href="index.php?page=menu">Menu</a></li>
          <li class="<?= $page == 'transaksi' ||  $page == 'transaksi_detail' ? 'active' : '' ?>"><a href="index.php?page=transaksi">Transaksi</a></li>
      </ul>
      <div class="user-menu-container">
          <div class="user-menu" onclick="toggleDropdown()">
              <?= $username ?> ▼
          </div>
          <div id="dropdown" class="dropdown-content">
              <a href="../../../logout.php">Logout</a>
          </div>
      </div>
  </nav>

  <script>
      function toggleDropdown() {
          const dropdown = document.getElementById("dropdown");
          dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
      }

      // Optional: close dropdown if click outside
      document.addEventListener("click", function(event) {
          const dropdown = document.getElementById("dropdown");
          const userMenu = document.querySelector(".user-menu");

          if (!userMenu.contains(event.target)) {
              dropdown.style.display = "none";
          }
      });
  </script>