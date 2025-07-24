<?php
session_start();
include '../../page/dashboard/kategori/kategori.php';
include '../../page/dashboard/metode_pembayaran/metode_pembayaran.php';
include '../../page/dashboard/menu/menu.php';
include '../../page/dashboard/transaksi/transaksi.php';
include '../../page/dashboard/transaksi_detail/transaksi_detail.php';
include '../../config/confiq.php';
include '../../helper/FlashSession.php';
include '../../helper/authGuard.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../assets/dashboard/css/style.css" />
</head>

<body>

    <?php
    include 'layout/navbar.php';
    ?>

    <main>
        <?php
        $page = $_GET['page'] ?? NULL;

        if ($page == 'kategori') {
            $kategori = new kategori();

            $action = $_GET['action'] ?? NULL;
            if ($action == 'create') {
                $kategori->create();
            } elseif ($action == 'update') {
                $kategori->update();
            } elseif ($action == 'delete') {
                $kategori->delete();
            } else {
                include '../dashboard/kategori/index.php';
            }
        } elseif ($page == 'metode-pembayaran') {
            $kategori = new metode_pembayaran();

            $action = $_GET['action'] ?? NULL;
            if ($action == 'create') {
                $kategori->create();
            } elseif ($action == 'update') {
                $kategori->update();
            } elseif ($action == 'delete') {
                $kategori->delete();
            } else {
                include '../dashboard/metode_pembayaran/index.php';
            }
        } elseif ($page == 'menu') {
            $kategori = new menu();

            $action = $_GET['action'] ?? NULL;
            if ($action == 'create') {
                $kategori->create();
            } elseif ($action == 'update') {
                $kategori->update();
            } elseif ($action == 'delete') {
                $kategori->delete();
            } else {
                include '../dashboard/menu/index.php';
            }
        } elseif ($page == 'transaksi') {
            $kategori = new transaksi();

            $action = $_GET['action'] ?? NULL;
            if ($action == 'create') {
                $kategori->create();
            } elseif ($action == 'update') {
                $kategori->update();
            } elseif ($action == 'delete') {
                $kategori->delete();
            } else {
                include '../dashboard/transaksi/index.php';
            }
        } elseif ($page == 'transaksi_detail') {
            $kategori = new transaksi_detail();

            $action = $_GET['action'] ?? NULL;
            if ($action == 'create') {
                $kategori->create();
            } elseif ($action == 'delete') {
                $kategori->delete();
            } else {
                include '../dashboard/transaksi_detail/index.php';
            }
        } else {
            include '../dashboard/home/index.php';
        }
        ?>
    </main>
    <script src="../../assets/dashboard/js/index.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>