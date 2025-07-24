<?php
$_SESSION['title'] = "Menu";

$id = $_GET['id'] ?? NULL;
$menu = new menu();
$data = $menu->getData();
$get_id = $menu->getById($id);

$kategori = new kategori();
$data_kategori = $kategori->getData();
?>

<!-- Main Content -->
<main class="container">
    <div class="header-bar">
        <h1>Data Menu</h1>
        <button class="btn-add" onclick="showModal('create')">+ Tambah</button>
    </div>

    <!-- Modal Tambah/Edit -->
    <div id="modalMenu" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Tambah Menu</h2>
            <form method="POST" id="formData" action="?page=menu&action=create" enctype="multipart/form-data">
                <input type="hidden" name="id" id="editIndex">
                <label>Nama Menu</label>
                <input type="text" name="nama" id="menuInput" placeholder="Nama Menu" required />

                <label>Kategori</label>
                <select name="id_kategori" id="kategoriInput" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($data_kategori as $kat): ?>
                        <option value="<?= $kat['id'] ?>"><?= htmlspecialchars($kat['nama']) ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Deskripsi</label>
                <textarea name="deskripsi" id="deskripsiInput" placeholder="Deskripsi Menu" required></textarea>

                <label>Harga</label>
                <input type="number" name="harga" id="hargaInput" placeholder="Harga Menu" required />

                <label>Diskon (%)</label>
                <input type="number" name="diskon" id="diskonInput" placeholder="Diskon" value="0" min="0" max="100" />

                <label>Gambar</label>
                <input type="file" name="gambar" id="gambarInput" accept="image/*" onchange="previewImage(event)" />
                <img id="gambarPreview" src="" style="max-width: 100px; display: none; margin-top: 5px;" />
                <input type="hidden" name="gambar_lama" id="gambarLama">

                <label>Status</label>
                <select name="status" id="statusInput" required>
                    <option value="">Pilih Status Menu</option>
                    <option value="Tersedia">Tersedia</option>
                    <option value="Habis">Habis</option>
                </select>

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
                <th>Kategori</th>
                <th>Nama Menu</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Diskon</th>
                <th>Gambar</th>
                <th>Status</th>
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
                    <td><?= $dt['nama_kategori'] ?></td>
                    <td><?= $dt['nama'] ?></td>
                    <td><?= $dt['deskripsi'] ?></td>
                    <td>Rp<?= number_format($dt['harga'], 0, ',', '.') ?></td>
                    <td><?= $dt['diskon'] ?>%</td>
                    <td>
                        <img src="uploads/<?= $dt['gambar'] ?>" alt="gambar" width="80" height="60">
                    </td>
                    <td><?= $dt['status'] ?></td>
                    <td>
                        <button class="btn-edit" onclick='editForm(<?= json_encode($dt, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>Edit</button>
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
    const modal = document.getElementById("modalMenu");
    const form = document.getElementById("formData");
    const modalTitle = document.getElementById("modalTitle");
    const preview = document.getElementById('gambarPreview');

    function showModal(action = 'create', data = {}) {

        if (action === 'create') {
            modalTitle.innerText = "Tambah Menu";
            form.action = "?page=menu&action=create";
            document.getElementById("editIndex").value = "";
            document.getElementById("menuInput").value = "";
            document.getElementById("kategoriInput").value = "";
            document.getElementById("deskripsiInput").value = "";
            document.getElementById("hargaInput").value = "";
            document.getElementById("diskonInput").value = "";
            document.getElementById("gambarInput").value = "";
            document.getElementById("statusInput").value = "";

            document.getElementById("gambarPreview").style.display = "none";
            document.getElementById("gambarLama").value = "";

        } else if (action === 'update') {
            modalTitle.innerText = "Edit Menu";
            form.action = "?page=menu&action=update";
            document.getElementById("editIndex").value = data.id || '';
            document.getElementById("menuInput").value = data.nama || '';
            document.getElementById("kategoriInput").value = data.id_kategori || '';
            document.getElementById("deskripsiInput").value = data.deskripsi || '';
            document.getElementById("hargaInput").value = data.harga || '';
            document.getElementById("diskonInput").value = data.diskon || 0;
            document.getElementById("statusInput").value = data.status || '';
        }

        if (data.gambar) {
            preview.src = 'uploads/' + data.gambar;
            preview.style.display = 'block';
            document.getElementById("gambarLama").value = data.gambar;
        } else {
            preview.style.display = 'none';
            preview.src = '';
            document.getElementById("gambarLama").value = '';
        }

        modal.style.display = 'block';
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('gambarPreview');
            preview.src = reader.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function closeModal() {
        modal.style.display = "none";
        form.reset();
        document.getElementById("gambarInput").value = "";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }

    function editForm(data) {
        showModal('update', data);
        modal.style.display = 'block';
    }

    function hapusData(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus menu ini?',
            text: "Tindakan ini tidak bisa dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '?page=menu&action=delete&id=' + id;
            }
        });
    }
</script>