<?php
// Config/Database.php

class Database {
    private $host = 'localhost';
    private $db_name = 'techfit';  // ✅ Nome do seu banco
    private $username = 'root';
    private $password = 'senaisp'; // ⚠️ ALTERE AQUI se tiver senha
    private $charset = 'utf8mb4';
    private $pdo;

    /**
     * Obtém a conexão PDO (Singleton)
     */
    public function getConnection() {
        if ($this->pdo === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
                
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::ATTR_PERSISTENT         => false
                ];

                $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
                
            } catch (PDOException $e) {
                error_log("Erro de Conexão: " . $e->getMessage());
                die("Erro ao conectar ao banco de dados. Verifique suas credenciais.");
            }
        }
        
        return $this->pdo;
    }

    /**
     * Fecha a conexão explicitamente
     */
    public function closeConnection() {
        $this->pdo = null;
    }
}
?>