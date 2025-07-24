<?php
$_SESSION['title'] = "Metode Pembayaran";

$id = $_GET['id'] ?? NULL;
$metode_pembayaran = new metode_pembayaran();
$data = $metode_pembayaran->getData();
$get_id = $metode_pembayaran->getById($id);
?>


<!-- Main Content -->
<main class="container">
    <div class="header-bar">
        <h1>Data Metode Pembayaran</h1>
        <button class="btn-add" onclick="showModal('create')">+ Tambah</button>
    </div>

    <!-- Modal Tambah/Edit -->
    <div id="modalMetodePembayaran" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Tambah Metode Pembayaran</h2>
            <form method="POST" id="formData" action="?page=metode-pembayaran&action=create">
                <input type="hidden" name="id" id="editIndex">
                <label>Nama Metode Pembayaran</label>
                <input type="text" name="nama" id="MetodePembayaranInput" placeholder="Nama Metode Pembayaran" required />
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
                <th>Nama Metode Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php
        if (count($data) > 0) {
            $no = 1;
            foreach ($data as $dt):
        ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($dt['nama']) ?></td>
                    <td>
                        <button class="btn-edit" onclick="editForm(<?= $dt['id'] ?>, '<?= htmlspecialchars($dt['nama'], ENT_QUOTES) ?>')">Edit</button>
                        <button class="btn-delete" onclick="hapusData(<?= $dt['id'] ?>)">Hapus</button>
                    </td>
                </tr>
            <?php
            endforeach;
        } else {
            ?>
            <tr>
                <td colspan="3">Data tidak ditemukan</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</main>
<script>
    const modal = document.getElementById("modalMetodePembayaran");
    const form = document.getElementById("formData");
    const modalTitle = document.getElementById("modalTitle");

    function showModal(action = 'create', id = '', nama = '') {
        if (action === 'create') {
            modalTitle.innerText = "Tambah Metode Pembayaran";
            form.action = "?page=metode-pembayaran&action=create";
            document.getElementById("editIndex").value = "";
            document.getElementById("MetodePembayaranInput").value = "";
        } else if (action === 'update') {
            modalTitle.innerText = "Edit Metode Pembayaran";
            form.action = "?page=metode-pembayaran&action=update";
            document.getElementById("editIndex").value = id;
            document.getElementById("MetodePembayaranInput").value = nama;
        }

        modal.style.display = "block";
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

    function editForm(id, nama) {
        showModal('update', id, nama);
    }

    function hapusData(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus Metode Pembayaran ini?',
            text: "Tindakan ini tidak bisa dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '?page=metode-pembayaran&action=delete&id=' + id;
            }
        });
    }
</script>