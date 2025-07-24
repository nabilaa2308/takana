<?php
header('Content-Type: application/json');

require_once '../../config/confiq.php';
require_once '../../helper/FlashSession.php';
require_once '../dashboard/transaksi/transaksi.php';

$id = $_GET['id'] ?? 0;
$transaksiModel = new transaksi();
$transaksiData = $transaksiModel->getById($id);
$detailData = $transaksiModel->getDetailById($id);

if (!$transaksiData || count($transaksiData) === 0) {
    echo json_encode([
        'error' => true,
        'message' => 'Transaksi tidak ditemukan.'
    ]);
    exit;
}

$transaksi = $transaksiData[0];

ob_start();
?>
<div style="font-family: monospace;">
    <h3 style="text-align:center;">Ayam Geprek Takana</h3>
    <hr>
    <p>Invoice: <?= htmlspecialchars($transaksi['kode_inv']) ?></p>
    <p>Tanggal: <?= date('d-m-Y', strtotime($transaksi['tanggal'])) ?></p>
    <p>Nama: <?= htmlspecialchars($transaksi['nama_pembeli']) ?></p>
    <p>Metode Pembayaran: <?= htmlspecialchars($transaksi['nama']) ?></p>
    <p>Nomor WA: <?= htmlspecialchars($transaksi['nomor_hp']) ?></p>
    <p>Alamat: <?= htmlspecialchars($transaksi['alamat']) ?></p>
    <hr>
    <?php
    $total = 0;
    foreach ($detailData as $row):
        $harga = $row['harga'];
        $jumlah = $row['jumlah'];
        $diskon = (int) ($row['diskon'] ?? 0);
        $hargaDiskon = $harga - ($harga * $diskon / 100);
        $subtotal = $hargaDiskon * $jumlah;
        $total += $subtotal;
    ?>
        <p>
            <?= htmlspecialchars($row['nama']) ?> x<?= $jumlah ?>
            <?php if ($diskon > 0): ?>
                <br><small>Diskon <?= $diskon ?>% (Rp<?= number_format($hargaDiskon, 0, ',', '.') ?>/pcs)</small>
            <?php endif; ?>
            <span style="float:right">Rp<?= number_format($subtotal, 0, ',', '.') ?></span>
        </p>
    <?php endforeach; ?>
    <hr>
    <p><strong>Total <span style="float:right">Rp<?= number_format($total, 0, ',', '.') ?></span></strong></p>
    <hr>
    <p style="text-align:center;">Terima kasih </p>
</div>
<?php
$isiStruk = ob_get_clean();

$tanggal = date('d-m-Y', strtotime($transaksi['tanggal']));

// Format pesan WA
$pesanWa = "*AYAM GEPREK TAKANA*\n";
$pesanWa .= "=====================\n";
$pesanWa .= "*Invoice:* {$transaksi['kode_inv']}\n";
$pesanWa .= "*Tanggal:* {$tanggal}\n";
$pesanWa .= "*Pelanggan:* {$transaksi['nama_pembeli']}\n";
$pesanWa .= "*Metode Pembayaran:* {$transaksi['nama']}\n";
$pesanWa .= "*Nomor Hp:* {$transaksi['nomor_hp']}\n";
$pesanWa .= "*Alamat:* {$transaksi['alamat']}\n";
$pesanWa .= "=====================\n";

$pesanWa .= "*Detail Pesanan:*\n";
$total = 0;
foreach ($detailData as $row) {
    $harga = $row['harga'];
    $jumlah = $row['jumlah'];
    $diskon = (int) ($row['diskon'] ?? 0);
    $hargaDiskon = $harga - ($harga * $diskon / 100);
    $subtotal = $hargaDiskon * $jumlah;
    $total += $subtotal;

    $pesanWa .= "- {$row['nama']} x{$jumlah}";
    if ($diskon > 0) {
        $pesanWa .= " (Diskon {$diskon}%)";
    }
    $pesanWa .= " = Rp" . number_format($subtotal, 0, ',', '.') . "\n";
}
$pesanWa .= "=====================\n";
$pesanWa .= "*Total:* Rp" . number_format($total, 0, ',', '.') . "\n";
$pesanWa .= "Terima kasih";

echo json_encode([
    'error' => false,
    'html' => $isiStruk,
    'pesan' => $pesanWa,
    'nomor' => $transaksi['nomor_hp']
]);
