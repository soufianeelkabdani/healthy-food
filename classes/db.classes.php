<?php

class DB {
    private $host = 'localhost';
    private $dbname = 'healthy-food';
    private $user = 'root';
    private $password = '';
    private $pdo;

    public function connect() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
        );
        try {
            $pdo = new PDO($dsn, $this->user, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit();
        }
    }

    public function getPdo() {
        if (!$this->pdo) {
            $this->pdo = $this->connect();
        }
        return $this->pdo;
    }
}
?>
