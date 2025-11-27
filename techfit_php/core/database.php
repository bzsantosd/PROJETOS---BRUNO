<?php

class Database {
    private $host = 'localhost';
    private $dbname = 'SENAI';
    private $username = 'root';
    private $password = 'senaisp';
    private $conn = null;
    
    /**
     * Obtém a conexão com o banco de dados
     * @return PDO
     */
    public function getConnection() {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO(
                    "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                    $this->username,
                    $this->password
                );
                
                // Configurar PDO para lançar exceções em caso de erro
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
            } catch(PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }
        
        return $this->conn;
    }
    
    /**
     * Fecha a conexão com o banco
     */
    public function closeConnection() {
        $this->conn = null;
    }
}