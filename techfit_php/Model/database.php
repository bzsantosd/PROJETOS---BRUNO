<?php

namespace techfit_php;

use PDO;
use PDOException;

class Database {
    // Propriedades privadas para segurança e configuração
    private $host     = 'localhost'; 
    private $db_name  = 'techfit'; 
    private $user     = 'Local instance MySQL80';
    private $password = 'senaisp';
    private $conn; // A instância de conexão PDO

    /**
     * Estabelece a conexão com o banco de dados.
     * @return PDO Retorna o objeto de conexão PDO.
     */
    public function conectar() {
        $this->conn = null;
        
        // String de conexão (DSN)
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8";
        
        try {
            $this->conn = new PDO($dsn, $this->user, $this->password);
            
            // Define o modo de erro e o modo de retorno padrão
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Retorna resultados como arrays associativos
            
        } catch(PDOException $exception) {
            // Em produção, você registraria este erro em um log, em vez de exibi-lo
            throw new ("Erro de conexão com o banco de dados: " . $exception->getMessage());
        }
        
        return $this->conn;
    }

    /**
     * Retorna a conexão PDO existente, ou a cria se ainda não existir.
     * @return PDO
     */
    public function getConexao() {
        if ($this->conn === null) {
            $this->conectar();
        }
        return $this->conn;
    }
}
?>