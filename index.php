<?php
include 'config/confiq.php';
include 'helper/FlashSession.php';
include 'page/dashboard/menu/menu.php';
include 'page/dashboard/kategori/kategori.php';
include 'page/dashboard/metode_pembayaran/metode_pembayaran.php';
include 'page/dashboard/transaksi/transaksi.php';

$kategori = new kategori();
$dataKategori = $kategori->getData();
$menu = new menu();
$dataMenu = $menu->menuHome();
$metode_pembayaran = new metode_pembayaran();
$pembayaran = $metode_pembayaran->getData();
$transaksi = new transaksi();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $transaksi->createWithDetail();
}

function generateKodeInv()
{
  $now = new DateTime();
  $kode = 'INV' . $now->format('ymdHis');
  return $kode;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>TAKANA</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/website/img/favicon.png" rel="icon">
  <link href="assets/website/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/website/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/website/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/website/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/website/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/website/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/website/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Yummy
  * Template URL: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/website/img/logo.png" alt=""> -->
        <h1 class="sitename">TAKANA</h1>
        <span></span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home<br></a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#menu">Menu</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="#pemesanan">Pesan Sekarang</a>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

      <div class="container">
        <div class="row gy-4 justify-content-center justify-content-lg-between">
          <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <h1 data-aos="fade-up">Enjoy Your <br>Delicious Food</h1>
            <p data-aos="fade-up" data-aos-delay="100"></p>
            <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
              <a href="#book-a-table" class="btn-get-started">Pesan Sekarang</a>
            </div>
          </div>
          <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
            <img src="assets/local/ayam2.png" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Tentang Kami</h2>
        <p><span>Kenali Lebih Dekat</span> <span class="description-title">Takana</span></p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">
          <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/website/img/about.jpg" class="img-fluid mb-4" alt="Warung Ayam Geprek">
            <div class="book-a-table">
              <h3>Info Lebih Lanjut</h3>
              <p>+62 852 6584 2019</p>
            </div>
          </div>
          <div class="col-lg-5" data-aos="fade-up" data-aos-delay="250">
            <div class="content ps-0 ps-lg-5">
              <p class="fst-italic">
                Warung Ayam Geprek kami menyajikan cita rasa khas ayam geprek dengan berbagai pilihan level pedas, topping, dan sambal khas rumahan.
              </p>
              <ul>
                <li><i class="bi bi-check-circle-fill"></i> <span>Rasa pedas nikmat, bisa pilih level 1–10 sesuai selera.</span></li>
                <li><i class="bi bi-check-circle-fill"></i> <span>Harga terjangkau, cocok untuk mahasiswa dan keluarga.</span></li>
                <li><i class="bi bi-check-circle-fill"></i> <span>Lokasi strategis dekat kampus dan pusat aktivitas warga.</span></li>
              </ul>
              <p>
                Kami percaya bahwa makanan lezat tidak harus mahal. Warung kami berdiri sejak 2021 dan telah menjadi favorit pelanggan di sekitar daerah ini. Semua bahan dipilih dengan cermat untuk menjaga kualitas dan kelezatan tiap sajian.
              </p>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Menu Section -->
    <section id="menu" class="menu section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Menu Kami</h2>
        <p><span>Cek Menu</span> <span class="description-title">Takana</span></p>
      </div><!-- End Section Title -->

      <div class="container">

        <!-- Dynamic Tab Headers -->
        <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
          <?php foreach ($dataKategori as $index => $kat): ?>
            <li class="nav-item">
              <a class="nav-link <?= $index === 0 ? 'active show' : '' ?>" data-bs-toggle="tab" data-bs-target="#menu-<?= $kat['id'] ?>">
                <h4><?= htmlspecialchars($kat['nama']) ?></h4>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>

        <!-- Dynamic Tab Contents -->
        <div class="tab-content" data-aos="fade-up" data-aos-delay="200">
          <?php foreach ($dataKategori as $index => $kat): ?>
            <div class="tab-pane fade <?= $index === 0 ? 'active show' : '' ?>" id="menu-<?= $kat['id'] ?>">

              <div class="tab-header text-center">
                <p>Menu</p>
                <h3><?= htmlspecialchars($kat['nama']) ?></h3>
              </div>

              <div class="row gy-5">
                <?php
                $filteredMenu = array_filter($dataMenu, function ($item) use ($kat) {
                  return $item['id_kategori'] == $kat['id'];
                });

                if (empty($filteredMenu)) {
                  echo '<div class="col-12 text-center"><em>Belum ada menu tersedia untuk kategori ini</em></div>';
                }

                foreach ($filteredMenu as $item):
                ?>
                  <div class="col-lg-4 menu-item">
                    <a href="page/dashboard/uploads/<?= htmlspecialchars($item['gambar']) ?>" class="glightbox">
                      <img src="page/dashboard/uploads/<?= htmlspecialchars($item['gambar']) ?>" class="menu-img img-fluid" alt="<?= htmlspecialchars($item['nama']) ?>">
                    </a>
                    <h4><?= htmlspecialchars($item['nama']) ?></h4>
                    <p class="ingredients">
                      <?= htmlspecialchars($item['deskripsi']) ?>
                    </p>
                    <p class="price">
                      Rp <?= number_format($item['harga'] - $item['diskon'], 0, ',', '.') ?>
                    </p>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

      </div>
    </section>

    <!-- Menu Pemesanan Section -->
    <section id="pemesanan" class="book-a-table section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Pemesanan Makanan</h2>
        <p><span>Pesan</span> <span class="description-title">Menu Favoritmu</span></p>
      </div>

      <div class="container">
        <div class="row g-0" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-4 reservation-img" style="background-image: url(assets/website/img/reservation.jpg);"></div>

          <div class="col-lg-8 d-flex align-items-center reservation-form-bg" data-aos="fade-up" data-aos-delay="200">
            <form method="POST" class="php-email-form">
              <input type="hidden" name="kode_inv" value="<?= generateKodeInv() ?>">
              <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">

              <div class="row gy-4">
                <div class="col-lg-6 col-md-6">
                  <input type="text" name="nama_pembeli" class="form-control" placeholder="Nama Pembeli" required>
                </div>
                <div class="col-lg-6 col-md-6">
                  <input type="text" name="nomor_hp" class="form-control" placeholder="No. HP" required>
                </div>
                <div class="col-lg-12">
                  <select name="id_metode_pembayaran" class="form-control" required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <?php foreach ($pembayaran as $mtd): ?>
                      <option value="<?= $mtd['id'] ?>"><?= htmlspecialchars($mtd['nama']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <hr class="my-4">

              <h5 class="mb-2">Pilih Menu</h5>
              <div id="menu-wrapper">
                <div class="row gy-2 menu-row">
                  <div class="col-md-6">
                    <select name="menu_id[]" class="form-control" required>
                      <option value="">-- Pilih Menu --</option>
                      <?php foreach ($dataMenu as $mn): ?>
                        <option value="<?= $mn['id'] ?>"><?= htmlspecialchars($mn['nama']) ?> - Rp<?= number_format($mn['harga'], 0, ',', '.') ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <input type="number" name="jumlah[]" min="1" class="form-control" placeholder="Jumlah" required>
                  </div>
                  <div class="col-md-2 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-menu">Hapus</button>
                  </div>
                </div>
              </div>

              <div class="text-end mt-3">
                <button type="button" id="add-menu" class="btn btn-secondary btn-sm">+ Tambah Menu</button>
              </div>

              <div class="text-center mt-4">
                <button type="button" class="btn btn-danger" id="open-confirm">Pesan Sekarang</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal Konfirmasi -->
      <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Konfirmasi Pesanan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
              <p><strong>Kode INV:</strong> <span id="konf-inv"></span></p>
              <p><strong>Nama:</strong> <span id="konf-nama"></span></p>
              <p><strong>No. HP:</strong> <span id="konf-hp"></span></p>
              <p><strong>Metode Pembayaran:</strong> <span id="konf-metode"></span></p>
              <hr>
              <h6>Detail Pesanan:</h6>
              <ul id="konf-menu-list"></ul>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary" id="submitForm">Pesan Sekarang</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p><span>Need Help?</span> <span class="description-title">Contact Us</span></p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="mb-5">
          <iframe style="width: 100%; height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7077010303683!2d101.45315317363018!3d0.4266556995691627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5a5559d765f0d%3A0x79df409125e180b1!2sAyam%20Geprek%20TAKANA!5e0!3m2!1sid!2sid!4v1753344694088!5m2!1sid!2sid" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div><!-- End Google Maps -->

        <div class="row gy-4">

          <div class="col-md-6">
            <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
              <i class="icon bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Alamat</h3>
                <p>Perum Gading Marpoyan, Blok G3 No.4, Siak Hulu, Pekanbaru</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="300">
              <i class="icon bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Phone</h3>
                <p>+62 852 6584 2019</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="400">
              <i class="icon bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email</h3>
                <p>info@example.com</p>
              </div>
            </div>
          </div><!-- End Info Item -->

          <div class="col-md-6">
            <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="500">
              <i class="icon bi bi-clock flex-shrink-0"></i>
              <div>
                <h3>Jam Buka<br></h3>
                <p><strong>Setiap Hari:</strong>10:00 - 22:00</p>
              </div>
            </div>
          </div><!-- End Info Item -->

        </div>

        <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="600">
          <div class="row gy-4">

            <div class="col-md-6">
              <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
            </div>

            <div class="col-md-6 ">
              <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
            </div>

            <div class="col-md-12">
              <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
            </div>

            <div class="col-md-12">
              <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
            </div>

            <div class="col-md-12 text-center">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your message has been sent. Thank you!</div>

              <button type="submit">Send Message</button>
            </div>

          </div>
        </form><!-- End Contact Form -->

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer dark-background">

    <div class="container">
      <div class="row gy-3">
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-geo-alt icon"></i>
          <div class="address">
            <h4>Alamat</h4>
            <p>Perum Gading Marpoyan,</p>
            <p>Blok G3 No.4</p>
            <p>Siak Hulu, Pekanbaru</p>
            <p></p>
          </div>

        </div>

        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-telephone icon"></i>
          <div>
            <h4>Kontak</h4>
            <p>
              <strong>Phone:</strong> <span>+62 852 6584 2019</span><br>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-clock icon"></i>
          <div>
            <h4>Jam Buka</h4>
            <p>
              <strong>Setiap Hari:</strong> <span>10:00 - 22:00</span><br>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <h4>Sosial Media</h4>
          <div class="social-links d-flex">
            <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">TAKANA</strong> <span></span></p>
      <div class="credits">
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/website/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/website/vendor/php-email-form/validate.js"></script>
  <script src="assets/website/vendor/aos/aos.js"></script>
  <script src="assets/website/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/website/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/website/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/website/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- JavaScript untuk tambah menu -->
  <script>
    document.getElementById("add-menu").addEventListener("click", function() {
      const wrapper = document.getElementById("menu-wrapper");
      const newRow = wrapper.querySelector(".menu-row").cloneNode(true);
      newRow.querySelectorAll("input, select").forEach(el => el.value = '');
      newRow.classList.add("mt-3");
      wrapper.appendChild(newRow);
    });

    document.addEventListener("click", function(e) {
      if (e.target.classList.contains("remove-menu")) {
        const rows = document.querySelectorAll(".menu-row");
        if (rows.length > 1) {
          e.target.closest(".menu-row").remove();
        }
      }
    });
  </script>

  <script>
    document.getElementById("open-confirm").addEventListener("click", function() {
      const form = document.querySelector(".php-email-form");

      // Ambil data dari form
      const inv = form.kode_inv.value;
      const nama = form.nama_pembeli.value;
      const hp = form.nomor_hp.value;
      const metodeSelect = form.id_metode_pembayaran;
      const metode = metodeSelect.options[metodeSelect.selectedIndex].text;

      const menuList = document.querySelectorAll(".menu-row");
      const konfList = document.getElementById("konf-menu-list");
      konfList.innerHTML = ""; // Kosongkan dulu

      menuList.forEach(row => {
        const menuSelect = row.querySelector("select");
        const jumlah = row.querySelector("input").value;
        const menuNama = menuSelect.options[menuSelect.selectedIndex].text;
        if (menuSelect.value && jumlah) {
          const li = document.createElement("li");
          li.textContent = `${menuNama} × ${jumlah}`;
          konfList.appendChild(li);
        }
      });

      // Isi modal
      document.getElementById("konf-inv").textContent = inv;
      document.getElementById("konf-nama").textContent = nama;
      document.getElementById("konf-hp").textContent = hp;
      document.getElementById("konf-metode").textContent = metode;

      // Tampilkan modal
      const modal = new bootstrap.Modal(document.getElementById("konfirmasiModal"));
      modal.show();

      // Saat konfirmasi di klik
      document.getElementById("submitForm").onclick = function(e) {
        form.submit();
      };
    });
  </script>

  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script>
      Swal.fire('Berhasil!', 'Pesanan berhasil dibuat.', 'success');
    </script>
  <?php endif; ?>


</body>

</html>