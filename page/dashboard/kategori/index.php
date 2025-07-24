<?php
$_SESSION['title'] = "Kategori";

$id = $_GET['id'] ?? NULL;
$kategori = new kategori();
$data = $kategori->getData();
$get_id = $kategori->getById($id);
?>

<!-- Main Content -->
<main class="container">
    <div class="header-bar">
        <h1>Data Kategori</h1>
        <button class="btn-add" onclick="showModal('create')">+ Tambah</button>
    </div>

    <!-- Modal Tambah/Edit -->
    <div id="modalKategori" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Tambah Kategori</h2>
            <form method="POST" id="formData" action="?page=kategori&action=create">
                <input type="hidden" name="id" id="editIndex">
                <label>Nama Kategori</label>
                <input type="text" name="nama" id="kategoriInput" placeholder="Nama Kategori" required />
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
                <th>Nama Kategori</th>
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
    const modal = document.getElementById("modalKategori");
    const form = document.getElementById("formData");
    const modalTitle = document.getElementById("modalTitle");

    function showModal(action = 'create', id = '', nama = '') {
        if (action === 'create') {
            modalTitle.innerText = "Tambah Kategori";
            form.action = "?page=kategori&action=create";
            document.getElementById("editIndex").value = "";
            document.getElementById("kategoriInput").value = "";
        } else if (action === 'update') {
            modalTitle.innerText = "Edit Kategori";
            form.action = "?page=kategori&action=update";
            document.getElementById("editIndex").value = id;
            document.getElementById("kategoriInput").value = nama;
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
            title: 'Yakin ingin menghapus kategori ini?',
            text: "Tindakan ini tidak bisa dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '?page=kategori&action=delete&id=' + id;
            }
        });
    }
</script>