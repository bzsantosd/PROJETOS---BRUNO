<?php
use Techfit\Config\Connection;

require_once 'Plano.php';
require_once 'Connection.php';

class PlanoDAO {
    private $pdo;
    private $table = 'Plano';

    public function __construct() {
        $this->pdo = Connection::getInstance();

        $sql = "
            CREATE TABLE IF NOT EXISTS {$this->table} (
                Id_Plano INT AUTO_INCREMENT PRIMARY KEY,
                nome_plano VARCHAR(100) NOT NULL,
                email VARCHAR(255),
                cpf VARCHAR(14),
                endereco VARCHAR(255),
                contato VARCHAR(100),
                Id_Administrador INT,
                CONSTRAINT fk_plano_administrador FOREIGN KEY (Id_Administrador)
                    REFERENCES Administrador (Id_Administrador)
                    ON DELETE SET NULL
                    ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";
        try {
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            error_log("PlanoDAO::__construct - erro criar tabela: " . $e->getMessage());
        }
    }

    // CREATE
    public function criarPlano(Plano $plano) {
        $stmt = $this->pdo->prepare("
            INSERT INTO {$this->table} (nome_plano, email, cpf, endereco, contato, Id_Administrador)
            VALUES (:nome, :email, :cpf, :endereco, :contato, :idAdministrador)
        ");
        try {
            $stmt->execute([
                ':nome' => $plano->getNomePlano(),
                ':email' => $plano->getEmail(),
                ':cpf' => $plano->getCpf(),
                ':endereco' => $plano->getEndereco(),
                ':contato' => $plano->getContato(),
                ':idAdministrador' => $plano->getIdAdministrador()
            ]);
            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            error_log("PlanoDAO::criarPlano - " . $e->getMessage());
            return false;
        }
    }

    // READ - todos
    public function listarTodos() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY Id_Plano DESC");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[] = (new Plano($this->pdo))->fromRow($row);
        }
        return $result;
    }

    // READ - por email
    public function buscarPorEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (new Plano($this->pdo))->fromRow($row) : null;
    }

    // READ - por ID
    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE Id_Plano = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (new Plano($this->pdo))->fromRow($row) : null;
    }

    // UPDATE
    public function atualizarPlano($id, Plano $plano) {
        $stmt = $this->pdo->prepare("
            UPDATE {$this->table}
            SET nome_plano = :nome,
                email = :email,
                cpf = :cpf,
                endereco = :endereco,
                contato = :contato,
                Id_Administrador = :idAdministrador
            WHERE Id_Plano = :id
        ");
        try {
            return $stmt->execute([
                ':nome' => $plano->getNomePlano(),
                ':email' => $plano->getEmail(),
                ':cpf' => $plano->getCpf(),
                ':endereco' => $plano->getEndereco(),
                ':contato' => $plano->getContato(),
                ':idAdministrador' => $plano->getIdAdministrador(),
                ':id' => $id
            ]);
        } catch (\PDOException $e) {
            error_log("PlanoDAO::atualizarPlano - " . $e->getMessage());
            return false;
        }
    }

    // DELETE
    public function excluirPlano($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE Id_Plano = :id");
        try {
            return $stmt->execute([':id' => $id]);
        } catch (\PDOException $e) {
            error_log("PlanoDAO::excluirPlano - " . $e->getMessage());
            return false;
        }
    }
}
?>