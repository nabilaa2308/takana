<?php
$_SESSION['title'] = "Transaksi";

$id = $_GET['id'] ?? NULL;

$transaksi = new transaksi();
$data = $transaksi->getData();
$get_id = $transaksi->getById($id);

$metode = new metode_pembayaran();
$data_metode = $metode->getData();

?>

<!-- Main Content -->
<main class="container">
    <div class="header-bar">
        <h1>Data Transaksi</h1>
        <button class="btn-add" onclick="showModal('create')">+ Tambah</button>
    </div>

    <!-- Modal Tambah/Edit -->
    <div id="modalTransaksi" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Tambah Transaksi</h2>
            <form method="POST" id="formData" action="?page=transaksi&action=create">
                <input type="hidden" name="id" id="editIndex">

                <label>Kode Invoice</label>
                <input type="text" name="kode_inv" id="kodeInvInput" readonly style="background-color: gray;" />

                <label>Tanggal</label>
                <input type="text" name="tanggal" id="tanggalInput" readonly style="background-color: gray;" />

                <label>Nama Pembeli</label>
                <input type="text" name="nama_pembeli" id="namaInput" required />

                <label>Nomor HP</label>
                <input type="text" name="nomor_hp" id="nomorHpInput" required />

                <label>Metode Pembayaran</label>
                <select name="id_metode_pembayaran" id="metodeInput" required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <?php foreach ($data_metode as $mtd): ?>
                        <option value="<?= $mtd['id'] ?>"><?= htmlspecialchars($mtd['nama']) ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Alamat</label>
                <input type="text" name="alamat" id="alamatInput" required />

                <div id="fieldEditOnly" style="display: none;">
                    <input type="hidden" name="total_bayar" id="totalBayarInput" readonly style="background-color: gray;" />

                    <label>Status</label>
                    <select name="status" id="statusInput">
                        <option value="Proses">Proses</option>
                        <option value="Pengantaran Pesanan">Pengantaran Pesanan</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit">Simpan</button>
                    <button type="button" onclick="closeModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Pembeli</th>
                <th>No HP</th>
                <th>Metode</th>
                <th>Total Bayar</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php if (count($data) > 0): $no = 1;
            foreach ($data as $dt): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $dt['kode_inv'] ?></td>
                    <td><?= $dt['nama_pembeli'] ?></td>
                    <td><?= $dt['nomor_hp'] ?></td>
                    <td><?= $dt['nama_metode'] ?></td>
                    <td>Rp<?= number_format($dt['total_bayar'], 0, ',', '.') ?></td>
                    <td><?= $dt['status'] ?></td>
                    <td>
                        <button class="btn-detail" onclick="window.location.href='?page=transaksi_detail&id=<?= $dt['id'] ?>'">Detail</button>
                        <?php if ($dt['status'] === 'Proses'): ?>
                            <button class="btn-edit" onclick='editForm(<?= json_encode($dt) ?>)'>Edit</button>
                            <button class="btn-delete" onclick="hapusData(<?= $dt['id'] ?>)">Hapus</button>
                        <?php else: ?>
                            <button class="btn-hubungi" onclick='showStrukModal(<?= json_encode($dt) ?>)'>Struk</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach;
        else: ?>
            <tr>
                <td colspan="8">Data tidak ditemukan</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div id="modalStruk" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeStrukModal()">&times;</span>
            <h2>Struk Transaksi</h2>
            <div id="strukContent">
                <!-- Diisi dengan JavaScript -->
            </div>
            <a id="whatsappBtn" class="btn-wa" href="#" target="_blank" style="display: none;">Kirim ke WhatsApp</a>
        </div>
    </div>
</main>
<script>
    const modal = document.getElementById("modalTransaksi");
    const form = document.getElementById("formData");
    const modalTitle = document.getElementById("modalTitle");

    function generateKodeInv() {
        const now = new Date();
        const pad = (n) => n.toString().padStart(2, '0');
        const kode = 'INV' + now.getFullYear().toString().slice(-2) +
            pad(now.getMonth() + 1) + pad(now.getDate()) +
            pad(now.getHours()) + pad(now.getMinutes()) + pad(now.getSeconds());
        return kode;
    }

    function showModal(action = 'create', data = {}) {
        if (action === 'create') {
            modalTitle.innerText = "Tambah Transaksi";
            form.action = "?page=transaksi&action=create";

            document.getElementById("editIndex").value = "";
            document.getElementById("kodeInvInput").value = generateKodeInv();
            document.getElementById("tanggalInput").value = new Date().toLocaleDateString('sv-SE'); // yyyy-mm-dd
            document.getElementById("namaInput").value = "";
            document.getElementById("nomorHpInput").value = "";
            document.getElementById("alamatInput").value = "";
            document.getElementById("metodeInput").value = "";

        } else if (action === 'update') {
            modalTitle.innerText = "Edit Transaksi";
            form.action = "?page=transaksi&action=update";

            document.getElementById("editIndex").value = data.id || '';
            document.getElementById("kodeInvInput").value = data.kode_inv || '';
            document.getElementById("tanggalInput").value = data.tanggal || '';
            document.getElementById("namaInput").value = data.nama_pembeli || '';
            document.getElementById("nomorHpInput").value = data.nomor_hp || '';
            document.getElementById("alamatInput").value = data.alamat || '';
            document.getElementById("metodeInput").value = data.id_metode_pembayaran || '';
            document.getElementById("totalBayarInput").value = data.total_bayar || '0';
            document.getElementById("statusInput").value = data.status || 'Proses';

            fieldEditOnly.style.display = "block";
        }

        modal.style.display = 'block';
    }

    function closeModal() {
        modal.style.display = "none";
        form.reset();
    }

    function editForm(data) {
        showModal('update', data);
    }

    function hapusData(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus transaksi ini?',
            text: "Tindakan ini tidak bisa dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '?page=transaksi&action=delete&id=' + id;
            }
        });
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
<script>
    function showStrukModal(data) {
        const modalStruk = document.getElementById("modalStruk");
        const strukContent = document.getElementById("strukContent");
        const whatsappBtn = document.getElementById("whatsappBtn");

        fetch('get_struk.php?id=' + data.id)
            .then(res => res.json())
            .then(response => {
                strukContent.innerHTML = response.html;

                const nomor = response.nomor.startsWith('0') ?
                    '62' + response.nomor.slice(1) :
                    response.nomor;

                whatsappBtn.href = `https://wa.me/${nomor}?text=${encodeURIComponent(response.pesan + "\n\nPesanan Anda sedang dalam Proses Pengantaran!")}`;
                whatsappBtn.style.display = "inline-block";

                modalStruk.style.display = "block";
            })
            .catch(err => {
                strukContent.innerHTML = "<p>Gagal memuat struk.</p>";
            });
    }

    function closeStrukModal() {
        document.getElementById("modalStruk").style.display = "none";
    }
</script>