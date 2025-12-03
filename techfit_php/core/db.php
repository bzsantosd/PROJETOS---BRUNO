<?php
class Database {
    private static $instance = null;
    private $conn;
    
    private $host = "127.0.0.1";
    private $user = "root";
    private $pass = "senaisp";
    private $dbname = "SENAI";
    
    private function __construct() {
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
            
            if ($this->conn->connect_error) {
                throw new Exception("Erro na conexão: " . $this->conn->connect_error);
            }
            
            $this->conn->set_charset("utf8mb4");
        } catch (Exception $e) {
            die("Erro ao conectar: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
    
    private function __clone() {}
}