<?php

use Techfit\Config\Connection;

require_once 'Usuario.php';
require_once 'Connection.php';

class UsuarioDAO {
    private $pdo;
    private $table = 'Usuario';

    public function __construct() {
        $this->pdo = Connection::getInstance();

        $sql = "
            CREATE TABLE IF NOT EXISTS {$this->table} (
                Id_Usuario INT AUTO_INCREMENT PRIMARY KEY,
                nome_usuario VARCHAR(100) NOT NULL,
                email VARCHAR(255) UNIQUE,
                senha VARCHAR(255) NOT NULL,
                cpf VARCHAR(14),
                contato VARCHAR(100),
                Id_Administrador INT,
                CONSTRAINT fk_usuario_adm FOREIGN KEY (Id_Administrador)
                    REFERENCES Administrador (Id_Administrador)
                    ON DELETE SET NULL
                    ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";
        try {
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            error_log("UsuarioDAO::__construct - erro criar tabela: " . $e->getMessage());
        }
    }

    // CREATE
    public function criarUsuario(Usuario $usuario) {
        $stmt = $this->pdo->prepare("
            INSERT INTO {$this->table} (nome_usuario, email, senha, cpf, contato, Id_Administrador)
            VALUES (:nome, :email, :senha, :cpf, :contato, :idAdministrador)
        ");
        try {
            $stmt->execute([
                ':nome' => $usuario->getNome(),
                ':email' => $usuario->getEmail(),
                ':senha' => $usuario->getSenha(),
                ':cpf' => $usuario->getCpf(),
                ':contato' => $usuario->getContato(),
            ]);
            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            error_log("UsuarioDAO::criarUsuario - " . $e->getMessage());
            return false;
        }
    }

    // READ - todos
    public function listarTodos() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY nome_usuario");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[] = (new Usuario($this->pdo))->fromRow($row);
        }
        return $result;
    }

    // READ - por ID
    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE Id_Usuario = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (new Usuario($this->pdo))->fromRow($row) : null;
    }

    // READ - por email
    public function buscarPorEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (new Usuario($this->pdo))->fromRow($row) : null;
    }

    // READ - por CPF
    public function buscarPorCpf($cpf) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE cpf = :cpf LIMIT 1");
        $stmt->execute([':cpf' => $cpf]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (new Usuario($this->pdo))->fromRow($row) : null;
    }

    // UPDATE
    public function atualizarUsuario($id, Usuario $usuario) {
        $stmt = $this->pdo->prepare("
            UPDATE {$this->table}
            SET nome_usuario = :nome,
                email = :email,
                senha = :senha,
                cpf = :cpf,
                contato = :contato,
                Id_Administrador = :idAdministrador
            WHERE Id_Usuario = :id
        ");
        try {
            return $stmt->execute([
                ':nome' => $usuario->getNome(),
                ':email' => $usuario->getEmail(),
                ':senha' => $usuario->getSenha(),
                ':cpf' => $usuario->getCpf(),
                ':contato' => $usuario->getContato(),
                ':id' => $id
            ]);
        } catch (\PDOException $e) {
            error_log("UsuarioDAO::atualizarUsuario - " . $e->getMessage());
            return false;
        }
    }

    // DELETE
    public function excluirUsuario($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE Id_Usuario = :id");
        try {
            return $stmt->execute([':id' => $id]);
        } catch (\PDOException $e) {
            error_log("UsuarioDAO::excluirUsuario - " . $e->getMessage());
            return false;
        }
    }
}
?>
