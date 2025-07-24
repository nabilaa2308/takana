<?php
class transaksi_detail
{
    public $connect;
    public function __construct()
    {
        $this->connect = connect();
    }

    public function getByTransaksi($id_transaksi)
    {
        $query = $this->connect->prepare("
            SELECT td.*, m.nama AS nama_menu
            FROM transaksi_detail td
            JOIN menu m ON td.id_menu = m.id
            WHERE td.id_transaksi = ?
        ");
        $query->execute([$id_transaksi]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create()
    {

        $id_transaksi = $_POST['id_transaksi'];
        $id_menu = $_POST['id_menu'];
        $jumlah = $_POST['jumlah'];

        // Ambil harga dari tabel menu berdasarkan id_menu
        $stmt = $this->connect->prepare("SELECT harga FROM menu WHERE id = :id_menu");
        $stmt->execute(['id_menu' => $id_menu]);
        $menu = $stmt->fetch();

        if (!$menu) {
            echo "<script>alert('Menu tidak ditemukan'); history.back();</script>";
            exit;
        }

        $harga = $menu['harga'];
        $total_harga = $harga * $jumlah;

        // Simpan ke transaksi_detail
        $stmt = $this->connect->prepare("INSERT INTO transaksi_detail (id_transaksi, id_menu, jumlah, harga, total_harga) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_transaksi, $id_menu, $jumlah, $harga, $total_harga]);

        // Update total_bayar di tabel transaksi
        $stmt = $this->connect->prepare("SELECT SUM(total_harga) as total FROM transaksi_detail WHERE id_transaksi = ?");
        $stmt->execute([$id_transaksi]);
        $total = $stmt->fetch()['total'];

        $stmt = $this->connect->prepare("UPDATE transaksi SET total_bayar = ? WHERE id = ?");
        $stmt->execute([$total, $id_transaksi]);

        echo "window.location.href='?page=transaksi_detail&id=$id_transaksi';</script>";
    }

    function delete()
    {
        $id = $_GET['id'] ?? null;

        // Ambil id_transaksi sebelum delete
        $stmt = $this->connect->prepare("SELECT id_transaksi FROM transaksi_detail WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();

        if (!$row) {
            setFlash('error', 'Data tidak ditemukan');
            echo "<script>window.history.back()</script>";
            return;
        }

        $id_transaksi = $row['id_transaksi'];

        // Delete data
        $query = $this->connect->prepare("DELETE FROM transaksi_detail WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();

        // Update total bayar
        $this->updateTotalBayar($id_transaksi);

        setFlash('success', 'Item berhasil dihapus');
        echo "<script>window.location.href='?page=transaksi_detail&id=$id_transaksi'</script>";
    }

    function updateTotalBayar($id_transaksi)
    {
        $query = $this->connect->prepare("SELECT SUM(total_harga) as total FROM transaksi_detail WHERE id_transaksi = :id");
        $query->bindParam(':id', $id_transaksi);
        $query->execute();
        $total = $query->fetch()['total'] ?? 0;

        $update = $this->connect->prepare("UPDATE transaksi SET total_bayar = :total WHERE id = :id");
        $update->bindParam(':total', $total);
        $update->bindParam(':id', $id_transaksi);
        $update->execute();
    }
}
