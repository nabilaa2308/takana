<?php
class metode_pembayaran
{
    public $connect;
    public function __construct()
    {
        $this->connect = connect();
    }

    function getById($id)
    {
        // prepare query sql
        $query = $this->connect->prepare("Select * from metode_pembayaran where id = :id");
        $query->bindParam(':id', $id);  //sanitize parameter for sql
        $query->execute(); // execute the query
        $data = $query->fetchAll(PDO::FETCH_ASSOC); //retrieve single data
        return $data;
    }

    function getData()
    {
        try {
            $query = $this->connect->prepare("SELECT * FROM metode_pembayaran ORDER BY id DESC");
            $query->execute(); // execute the query
            return $query->fetchAll(PDO::FETCH_ASSOC); //retrieve the data
        } catch (PDOException $e) {
            return []; // balikkan array kosong saat gagal
        }
    }

    function create()
    {
        $data = $_POST;
        try {
            $query = $this->connect->prepare("INSERT INTO metode_pembayaran (nama) VALUES (:nama)");
            $query->bindParam(':nama', $data['nama']);
            $query->execute();

            setFlash('success', 'Data Berhasil Disimpan');
            echo "<script>window.location.href='?page=metode-pembayaran'</script>";
        } catch (PDOException $e) {
            echo "Gagal menyimpan data: " . $e->getMessage();
        }
    }

    function update()
    {
        $data = $_POST;
        try {
            $query = $this->connect->prepare("UPDATE metode_pembayaran SET nama = :nama WHERE id = :id");
            $query->bindParam(':id', $data['id']);
            $query->bindParam(':nama', $data['nama']);
            $query->execute();

            setFlash('success', 'Data Berhasil Diupdate');
            echo "<script>window.location.href='?page=metode-pembayaran'</script>";
        } catch (PDOException $e) {
            echo "Gagal update data: " . $e->getMessage();
        }
    }

    function delete()
    {
        $id = $_GET['id'] ?? NULL;
        try {
            $query = $this->connect->prepare("DELETE FROM metode_pembayaran WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();

            setFlash('success', 'Data Berhasil Dihapus');
            echo "<script>window.location.href='?page=metode-pembayaran'</script>";
        } catch (PDOException $e) {
            echo "Gagal hapus data: " . $e->getMessage();
        }
    }
    
}
