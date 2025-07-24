<?php
$_SESSION['title'] = "Transaksi Detail";

$id_transaksi = $_GET['id'] ?? null;
$detail = new transaksi_detail();
$menu = new menu();
$data_menu = $menu->getData();
$data_detail = $detail->getByTransaksi($id_transaksi);

$total_semua = 0;
?>

<!-- Main Content -->
<main class="container">
    <div class="header-bar">
        <button class="btn-back" onclick="window.location.href='?page=transaksi'">← Kembali</button>
        <h1>Data Transaksi Detail</h1>
        <button class="btn-add" onclick="showModal('create')">+ Tambah</button>
    </div>

    <!-- Modal Tambah/Edit -->
    <div id="modalMenu" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Tambah Menu</h2>
            <form method="POST" id="formData" action="?page=transaksi_detail&action=create&id=<?= $id_transaksi ?>" enctype="multipart/form-data">
                <input type="hidden" name="id" id="editIndex">
                <input type="hidden" name="id_transaksi" value="<?= $_GET['id'] ?>">

                <label for="id_menu">Pilih Menu</label>
                <select name="id_menu" id="menuInput" required>
                    <option value="">-- Pilih Menu --</option>
                    <?php foreach ($data_menu as $m): ?>
                        <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nama']) ?> - Rp<?= number_format($m['harga'], 0, ',', '.') ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="jumlah">Jumlah</label>
                <input type="number" name="jumlah" id="jumlahInput" min="1" required>

                <div class="form-actions">
                    <button type="submit">Simpan</button>
                    <button type="button" onclick="closeModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Menu</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($data_detail) > 0): $no = 1;
                foreach ($data_detail as $item): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $item['nama_menu'] ?></td>
                        <td>Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                        <td><?= $item['jumlah'] ?></td>
                        <td>Rp<?= number_format($item['total_harga'], 0, ',', '.') ?></td>
                        <td>
                            <button class="btn-delete" onclick="hapusData(<?= $item['id'] ?>, <?= $id_transaksi ?>)">Hapus</button>
                        </td>
                    </tr>
                    <?php $total_semua += $item['total_harga']; ?>
                <?php endforeach;
            else: ?>
                <tr>
                    <td colspan="5">Belum ada menu dalam transaksi ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" style="text-align: right;">Total</th>
                <th>Rp<?= number_format($total_semua, 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>
</main>
<script>
    const modal = document.getElementById("modalMenu");
    const form = document.getElementById("formData");
    const modalTitle = document.getElementById("modalTitle");

    function showModal() {
        modal.style.display = 'block';
    }

    function closeModal() {
        modal.style.display = "none";
        form.reset();
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }

    function hapusData(id, id_transaksi) {
        Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            text: "Tindakan ini tidak bisa dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `?page=transaksi_detail&action=delete&id=${id}&id_transaksi=${id_transaksi}`;
            }
        });
    }
</script>