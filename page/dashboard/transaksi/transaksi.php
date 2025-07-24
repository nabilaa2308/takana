<?php
class transaksi
{
    public $connect;
    public function __construct()
    {
        $this->connect = connect();
    }

    function getById($id)
    {
        // prepare query sql
        $query = $this->connect->prepare("SELECT t.*, u.username AS nama_user, m.nama FROM transaksi t LEFT JOIN user u ON t.id_user = u.id LEFT JOIN metode_pembayaran m ON t.id_metode_pembayaran = m.id WHERE t.id = :id");
        $query->bindParam(':id', $id);  //sanitize parameter for sql
        $query->execute(); // execute the query
        $data = $query->fetchAll(PDO::FETCH_ASSOC); //retrieve single data
        return $data;
    }

    public function getDetailById($id)
    {
        $query = $this->connect->prepare("
            SELECT td.*, m.nama AS nama_menu
            FROM transaksi_detail td
            JOIN menu m ON td.id_menu = m.id
            WHERE td.id_transaksi = ?
        ");
        $query->execute([$id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function getData()
    {
        try {
            $query = $this->connect->prepare("SELECT t.*, u.username AS nama_user, m.nama AS nama_metode FROM transaksi t LEFT JOIN user u ON t.id_user = u.id LEFT JOIN metode_pembayaran m ON t.id_metode_pembayaran = m.id ORDER BY t.id DESC");
            $query->execute(); // execute the query
            return $query->fetchAll(PDO::FETCH_ASSOC); //retrieve the data
        } catch (PDOException $e) {
            return []; // balikkan array kosong saat gagal
        }
    }

    function create()
    {
        $data = $_POST;
        $id_user = $_SESSION['user']['id'] ?? NULL;
        $status = 'Proses';
        $total_bayar = 0;

        try {
            $query = $this->connect->prepare("INSERT INTO transaksi (id_user, kode_inv, tanggal, nama_pembeli, nomor_hp, id_metode_pembayaran, total_bayar, status) VALUES (:id_user, :kode_inv, :tanggal, :nama_pembeli, :nomor_hp, :id_metode_pembayaran, :total_bayar, :status)");
            $query->bindValue(':id_user', $id_user, $id_user !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
            $query->bindParam(':kode_inv', $data['kode_inv']);
            $query->bindParam(':tanggal', $data['tanggal']);
            $query->bindParam(':nama_pembeli', $data['nama_pembeli']);
            $query->bindParam(':nomor_hp', $data['nomor_hp']);
            $query->bindParam(':id_metode_pembayaran', $data['id_metode_pembayaran']);
            $query->bindParam(':total_bayar', $total_bayar);
            $query->bindParam(':status', $status);
            $query->execute();

            setFlash('success', 'Data Berhasil Disimpan');
            echo "<script>window.location.href='?page=transaksi'</script>";
        } catch (PDOException $e) {
            echo "Gagal menyimpan data: " . $e->getMessage();
        }
    }

    function update()
    {
        $data = $_POST;
        $id_user = $_SESSION['login']['id'];
        try {
            $query = $this->connect->prepare("UPDATE transaksi SET id_user = :id_user, kode_inv = :kode_inv, tanggal = :tanggal, nama_pembeli = :nama_pembeli, nomor_hp = :nomor_hp, id_metode_pembayaran = :id_metode_pembayaran, total_bayar = :total_bayar, status = :status WHERE id = :id");
            $query->bindParam(':id', $data['id']);
            $query->bindValue(':id_user', $id_user);
            $query->bindParam(':kode_inv', $data['kode_inv']);
            $query->bindParam(':tanggal', $data['tanggal']);
            $query->bindParam(':nama_pembeli', $data['nama_pembeli']);
            $query->bindParam(':nomor_hp', $data['nomor_hp']);
            $query->bindParam(':id_metode_pembayaran', $data['id_metode_pembayaran']);
            $query->bindParam(':total_bayar', $data['total_bayar']);
            $query->bindParam(':status', $data['status']);
            $query->execute();

            setFlash('success', 'Data Berhasil Diupdate');
            echo "<script>window.location.href='?page=transaksi'</script>";
        } catch (PDOException $e) {
            echo "Gagal update data: " . $e->getMessage();
        }
    }

    function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID transaksi tidak valid.";
            return;
        }

        try {
            $query = $this->connect->prepare("DELETE FROM transaksi WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();

            setFlash('success', 'Data Berhasil Dihapus');
            echo "<script>window.location.href='?page=transaksi'</script>";
        } catch (PDOException $e) {
            echo "Gagal hapus data: " . $e->getMessage();
        }
    }

    function createWithDetail()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $data = $_POST;
        $id_user = $_SESSION['user']['id'] ?? NULL;
        $status = 'Proses';
        $total_bayar = 0;

        try {
            // Mulai transaksi database
            $this->connect->beginTransaction();

            // Hitung total bayar dari menu yang dipilih
            $menu_ids = $data['menu_id'] ?? [];
            $jumlahs = $data['jumlah'] ?? [];

            foreach ($menu_ids as $i => $menu_id) {
                $stmt = $this->connect->prepare("SELECT harga, diskon FROM menu WHERE id = :id");
                $stmt->bindParam(':id', $menu_id);
                $stmt->execute();
                $menu = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($menu) {
                    $harga_setelah_diskon = $menu['harga'] - $menu['diskon'];
                    $total_harga = $harga_setelah_diskon * $jumlahs[$i];
                    $total_bayar += $total_harga;
                }
            }

            // Simpan ke tabel transaksi
            $query = $this->connect->prepare("INSERT INTO transaksi (id_user, kode_inv, tanggal, nama_pembeli, nomor_hp, id_metode_pembayaran, total_bayar, status) 
            VALUES (:id_user, :kode_inv, :tanggal, :nama_pembeli, :nomor_hp, :id_metode_pembayaran, :total_bayar, :status)");
            $query->bindValue(':id_user', $id_user, $id_user !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
            $query->bindParam(':kode_inv', $data['kode_inv']);
            $query->bindParam(':tanggal', $data['tanggal']);
            $query->bindParam(':nama_pembeli', $data['nama_pembeli']);
            $query->bindParam(':nomor_hp', $data['nomor_hp']);
            $query->bindParam(':id_metode_pembayaran', $data['id_metode_pembayaran']);
            $query->bindParam(':total_bayar', $total_bayar);
            $query->bindParam(':status', $status);
            $query->execute();

            // Ambil ID transaksi terakhir
            $transaksi_id = $this->connect->lastInsertId();

            // Simpan detail transaksi
            foreach ($menu_ids as $i => $menu_id) {
                $jumlah = $jumlahs[$i];

                $stmt = $this->connect->prepare("SELECT harga, diskon FROM menu WHERE id = :id");
                $stmt->bindParam(':id', $menu_id);
                $stmt->execute();
                $menu = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($menu) {
                    $harga_setelah_diskon = $menu['harga'] - $menu['diskon'];
                    $total_harga = $harga_setelah_diskon * $jumlah;

                    $detail = $this->connect->prepare("INSERT INTO transaksi_detail (id_transaksi, id_menu, jumlah, harga, total_harga)
                    VALUES (:id_transaksi, :id_menu, :jumlah, :harga, :total_harga)");
                    $detail->bindParam(':id_transaksi', $transaksi_id);
                    $detail->bindParam(':id_menu', $menu_id);
                    $detail->bindParam(':jumlah', $jumlah);
                    $detail->bindParam(':harga', $harga_setelah_diskon);
                    $detail->bindParam(':total_harga', $total_harga);
                    $detail->execute();
                }
            }

            // Commit transaksi
            $this->connect->commit();

            setFlash('success', 'Pesanan berhasil dibuat');

            // Redirect
            if ($id_user) {
                header('Location: ?page=transaksi');
                exit;
            } else {
                header('Location: index.php?success=1');
                exit;
            }
        } catch (PDOException $e) {
            $this->connect->rollBack();
            echo "Gagal menyimpan data transaksi: " . $e->getMessage();
        }
    }
}
