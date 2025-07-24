<?php
include 'config/confiq.php';
include 'page/dashboard/transaksi/transaksi.php';

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(['error' => 'ID tidak ditemukan']);
    exit;
}

$transaksi = new transaksi();
$data = $transaksi->getById($id);
$detail = $transaksi->getDetailById($id);

if (!$data || count($data) == 0) {
    echo json_encode(['error' => 'Data tidak ditemukan']);
    exit;
}

// Ambil data transaksi pertama
$data = $data[0];

// Format tanggal
$tanggal = date('d-m-Y H:i', strtotime($data['created_at']));

// Bangun HTML untuk isi struk
$html = '
    <h5 class="text-center mb-3">Struk Transaksi</h5>
    <p><strong>Nama User:</strong> ' . htmlspecialchars($data['nama_user']) . '</p>
    <p><strong>Metode Pembayaran:</strong> ' . htmlspecialchars($data['nama']) . '</p>
    <p><strong>Tanggal:</strong> ' . $tanggal . '</p>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Menu</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>';

$no = 1;
foreach ($detail as $item) {
    $html .= '<tr>
        <td>' . $no++ . '</td>
        <td>' . htmlspecialchars($item['nama_menu']) . '</td>
        <td>' . $item['jumlah'] . '</td>
        <td>Rp ' . number_format($item['harga'], 0, ',', '.') . '</td>
        <td>Rp ' . number_format($item['total_harga'], 0, ',', '.') . '</td>
    </tr>';
}

$html .= '</tbody></table>
    <div class="text-end mt-3">
        <strong>Total Harga: Rp ' . number_format($data['total_harga'], 0, ',', '.') . '</strong>
    </div>
';

echo json_encode(['html' => $html]);
