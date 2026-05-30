<?php
class Database {
    private string $host = "localhost";
    private string $user = "root";
    private string $password = "";
    private string $dbname = "rpg_game";

    public mysqli $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        
        if ($this->connection->connect_error) {
            die("Koneksi Database Gagal: " . $this->connection->connect_error);
        }
    }
}
?>