<?php
class Database {
    private $host = "localhost";
    private $db_name = "carbon_footprint";
    private $username = "root";
    private $password = "";
    private $conn;
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
        } catch(PDOException $exception) {
            error_log("Bağlantı hatası: " . $exception->getMessage());
            die("Veritabanı bağlantısı kurulamadı. Lütfen daha sonra tekrar deneyin.");
        }

        return $this->conn;
    }
}
?>
