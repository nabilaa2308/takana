<?php
class auth
{
    public $connect;
    public function __construct()
    {
        $this->connect = connect();
    }

    function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = $this->connect->prepare("SELECT * FROM user where username = :username");
        $query->bindParam(':username', $username);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        if ($data !== false) {
            if ($password === $data['password']) {
                $_SESSION['login'] = [
                    'id' => $data['id'],
                    'username' => $data['username']
                ];
                return true;
            } else {
                setFlash('error', 'Username/Password tidak sesuai.');
                return false;
            }
        } else {
            setFlash('error', 'Data tidak ditemukan.');
            return false;
        }
        // echo "<script>window.location.href='login.php'</script>";
    }
}
