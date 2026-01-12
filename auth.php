<?php
class Auth {

    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    /* ---------- LOGIN ---------- */
    public function login($username, $password) {

        $username = mysqli_real_escape_string($this->conn, $username);

        $query = mysqli_query(
            $this->conn,
            "SELECT * FROM login WHERE username='$username' LIMIT 1"
        );

        if (mysqli_num_rows($query) == 1) {

            $user = mysqli_fetch_assoc($query);

            if (password_verify($password, $user['password'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                return true;
            }
        }

        return false;
    }

    /* ---------- CHECK LOGIN ---------- */
    public function check() {
        return isset($_SESSION['user_id']);
    }

    /* ---------- LOGOUT ---------- */
    public function logout() {
        session_unset();
        session_destroy();
    }
}
