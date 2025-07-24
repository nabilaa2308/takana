<?php
class menu
{
    public $connect;
    public function __construct()
    {
        $this->connect = connect();
    }

    function getById($id)
    {
        // prepare query sql
        $query = $this->connect->prepare("Select * from menu where id = :id");
        $query->bindParam(':id', $id);  //sanitize parameter for sql
        $query->execute(); // execute the query
        $data = $query->fetchAll(PDO::FETCH_ASSOC); //retrieve single data
        return $data;
    }

    function getData()
    {
        try {
            $query = $this->connect->prepare("SELECT m.*, k.nama AS nama_kategori FROM menu m JOIN kategori k ON m.id_kategori = k.id ORDER BY m.id");
            $query->execute(); // execute the query
            return $query->fetchAll(PDO::FETCH_ASSOC); //retrieve the data
        } catch (PDOException $e) {
            return []; // balikkan array kosong saat gagal
        }
    }

    function create()
    {
        $data = $_POST;
        $gambar = $this->uploadGambar($_FILES['gambar']);
        try {
            $query = $this->connect->prepare("INSERT INTO menu (id_kategori, nama, deskripsi, harga, diskon, gambar, status) VALUES (:id_kategori, :nama, :deskripsi, :harga, :diskon, :gambar, :status)");
            $query->bindParam(':id_kategori', $data['id_kategori']);
            $query->bindParam(':nama', $data['nama']);
            $query->bindParam(':deskripsi', $data['deskripsi']);
            $query->bindParam(':harga', $data['harga']);
            $query->bindParam(':diskon', $data['diskon']);
            $query->bindParam(':gambar', $gambar);
            $query->bindParam(':status', $data['status']);
            $query->execute();

            setFlash('success', 'Data Berhasil Disimpan');
            echo "<script>window.location.href='?page=menu'</script>";
        } catch (PDOException $e) {
            echo "Gagal menyimpan data: " . $e->getMessage();
        }
    }

    function update()
    {
        $data = $_POST;
        $isUploadNewImage = !empty($_FILES['gambar']['name']);
        $gambarBaru = $isUploadNewImage ? $this->uploadGambar($_FILES['gambar']) : $data['gambar_lama'];

        // Jika upload gambar baru dan gambar lama bukan default, hapus gambar lama
        if ($isUploadNewImage && $data['gambar_lama']) {
            $this->deleteImageIfExists($data['gambar_lama']);
        }
        try {
            $query = $this->connect->prepare("UPDATE menu SET id_kategori = :id_kategori, nama = :nama, deskripsi = :deskripsi, harga = :harga, diskon = :diskon, gambar = :gambar, status = :status WHERE id = :id");
            $query->bindParam(':id', $data['id']);
            $query->bindParam(':id_kategori', $data['id_kategori']);
            $query->bindParam(':nama', $data['nama']);
            $query->bindParam(':deskripsi', $data['deskripsi']);
            $query->bindParam(':harga', $data['harga']);
            $query->bindParam(':diskon', $data['diskon']);
            $query->bindParam(':gambar', $gambarBaru);
            $query->bindParam(':status', $data['status']);
            $query->execute();

            setFlash('success', 'Data Berhasil Diupdate');
            echo "<script>window.location.href='?page=menu'</script>";
        } catch (PDOException $e) {
            echo "Gagal update data: " . $e->getMessage();
        }
    }

    function delete()
    {
        $id = $_GET['id'] ?? NULL;

        $query = $this->connect->prepare("SELECT gambar FROM menu WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        $data = $query->fetch();

        // Hapus file jika bukan default
        if ($data && $data['gambar'] && $data['gambar'] !== 'default.png') {
            $filePath = 'uploads/' . $data['gambar'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        try {
            $query = $this->connect->prepare("DELETE FROM menu WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();

            setFlash('success', 'Data Berhasil Dihapus');
            echo "<script>window.location.href='?page=menu'</script>";
        } catch (PDOException $e) {
            echo "Gagal hapus data: " . $e->getMessage();
        }
    }

    function uploadGambar($file)
    {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = time() . "_" . basename($file["name"]);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $fileName;
        }
    }

    function deleteImageIfExists($filename)
    {
        $filePath = 'uploads/' . $filename;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    function menuHome()
    {
        try {
            $query = $this->connect->prepare("
            SELECT m.*, k.nama AS nama_kategori 
            FROM menu m 
            JOIN kategori k ON m.id_kategori = k.id 
            WHERE m.status = 'Tersedia' 
            ORDER BY m.id
        ");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getTotal()
    {
        $query = $this->connect->query("SELECT COUNT(*) FROM menu");
        return $query->fetchColumn();
    }
}
