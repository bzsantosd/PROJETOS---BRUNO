<?php
use Techfit\Config\Connection;

require_once 'Compra.php';
require_once 'Connection.php';

class CompraDAO {
    private $pdo;
    private $table = 'Compra';

    public function __construct() {
        $this->pdo = Connection::getInstance();

        $sql = "
            CREATE TABLE IF NOT EXISTS {$this->table} (
                Id_Compra INT AUTO_INCREMENT PRIMARY KEY,
                nome_comprador VARCHAR(100) NOT NULL,
                email VARCHAR(255),
                cpf VARCHAR(14) NOT NULL,
                endereco VARCHAR(255),
                contato VARCHAR(100),
                Id_Administrador INT,
                CONSTRAINT fk_compra_administrador FOREIGN KEY (Id_Administrador)
                    REFERENCES Administrador (Id_Administrador)
                    ON DELETE SET NULL
                    ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";
        try {
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            // opcional: logar o erro
            error_log("CompraDAO::__construct - erro criar tabela: " . $e->getMessage());
        }
    }

    // CREATE
    public function criarCompra(Compra $compra) {
        $stmt = $this->pdo->prepare("
            INSERT INTO {$this->table} (nome_comprador, email, cpf, endereco, contato, Id_Administrador)
            VALUES (:nome, :email, :cpf, :endereco, :contato, :idAdministrador)
        ");
        try {
            $stmt->execute([
                ':nome' => $compra->getNomeComprador(),
                ':email' => $compra->getEmail(),
                ':cpf' => $compra->getCpf(),
                ':endereco' => $compra->getEndereco(),
                ':contato' => $compra->getContato(),
                ':idAdministrador' => $compra->getIdAdministrador()
            ]);
            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            error_log("Erro criarCompra: " . $e->getMessage());
            return false;
        }
    }

    // READ - todos
    public function listarTodos() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY Id_Compra DESC");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[] = (new Compra($this->pdo))->fromRow($row);
        }
        return $result;
    }

    // READ - por email
    public function buscarPorEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (new Compra($this->pdo))->fromRow($row) : null;
    }

    // UPDATE
    public function atualizarCompra($id, Compra $compra) {
        $stmt = $this->pdo->prepare("
            UPDATE {$this->table}
            SET nome_comprador = :nome,
                email = :email,
                cpf = :cpf,
                endereco = :endereco,
                contato = :contato,
                Id_Administrador = :idAdministrador
            WHERE Id_Compra = :id
        ");
        try {
            return $stmt->execute([
                ':nome' => $compra->getNomeComprador(),
                ':email' => $compra->getEmail(),
                ':cpf' => $compra->getCpf(),
                ':endereco' => $compra->getEndereco(),
                ':contato' => $compra->getContato(),
                ':idAdministrador' => $compra->getIdAdministrador(),
                ':id' => $id
            ]);
        } catch (\PDOException $e) {
            error_log("Erro atualizarCompra: " . $e->getMessage());
            return false;
        }
    }

    public function excluirCompra($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE Id_Compra = :id");
        try {
            return $stmt->execute([':id' => $id]);
        } catch (\PDOException $e) {
            error_log("Erro excluirCompra: " . $e->getMessage());
            return false;
        }
    }
}
?>