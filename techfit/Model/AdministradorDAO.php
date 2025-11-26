<?php

use Techfit\Config\Connection;

require_once 'Administrador.php';
require_once 'Connection.php';

class AdministradorDAO {
    private $pdo;
    private $table = 'Administrador';

    public function __construct() {
        $this->pdo = Connection::getInstance();

        $sql = "
            CREATE TABLE IF NOT EXISTS {$this->table} (
                Id_Administrador INT AUTO_INCREMENT PRIMARY KEY,
                nome_administrador VARCHAR(100),
                carga_horaria INT NOT NULL,
                salario DECIMAL(10,2),
                email VARCHAR(255)
            )
        ";
        try {
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
        }
    }

    // CREATE
    public function criarAdministrador(Administrador $admin) {
        $stmt = $this->pdo->prepare("
            INSERT INTO {$this->table} (nome_administrador, carga_horaria, salario, email)
            VALUES (:nome, :carga, :salario, :email)
        ");
        $stmt->execute([
            ':nome' => $admin->getNome(),
            ':carga' => $admin->getCargaHoraria(),
            ':salario' => $admin->getSalario(),
            ':email' => $admin->getEmail()
        ]);
        return $this->pdo->lastInsertId();
    }

    // READ - todos
    public function listarTodos() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY nome_administrador");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[] = (new Administrador($this->pdo))->fromRow($row);
        }
        return $result;
    }

    // READ - por email
    public function buscarPorEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (new Administrador($this->pdo))->fromRow($row) : null;
    }

    // UPDATE
    public function atualizarAdministrador($id, Administrador $admin) {
        $stmt = $this->pdo->prepare("
            UPDATE {$this->table}
            SET nome_administrador = :nome,
                carga_horaria = :carga,
                salario = :salario,
                email = :email
            WHERE Id_Administrador = :id
        ");
        return $stmt->execute([
            ':nome' => $admin->getNome(),
            ':carga' => $admin->getCargaHoraria(),
            ':salario' => $admin->getSalario(),
            ':email' => $admin->getEmail(),
            ':id' => $id
        ]);
    }
    public function excluirAdministrador($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE Id_Administrador = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>
