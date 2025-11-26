<?php

use Techfit\Config\Connection;

require_once 'Aluno.php';
require_once 'Connection.php';

class AlunoDAO {
    private $pdo;
    private $table = 'Aluno';

    public function __construct() {
        $this->pdo = Connection::getInstance();

        $sql = "
            CREATE TABLE Aluno (
            email varchar (255),
            endereco varchar (255),
            contato varchar (100),
            cpf varchar (14)  not null,
            nome_aluno varchar (100) not null,
            Id_Aluno int auto_increment primary key PRIMARY KEY,
            Id_Administrador int,
            FOREIGN KEY(Id_Administrador) REFERENCES Administrador (Id_Administrador)
            )
        ";
        try {
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
        }
    }

    // CREATE
    public function criarAluno(Aluno $aluno) {
        $stmt = $this->pdo->prepare("
            INSERT INTO {$this->table} (nome_aluno, email, cpf, endereco, contato, Id_Administrador)
            VALUES (:nome, :email, :cpf, :endereco, :contato, :idAdministrador)
        ");
        $stmt->execute([
            ':nome' => $aluno->getNome(),
            ':email' => $aluno->getEmail(),
            ':cpf' => $aluno->getCpf(),
            ':endereco' => $aluno->getEndereco(),
            ':contato' => $aluno->getContato(),
            ':idAdministrador' => $aluno->getIdAdministrador()
        ]);
        return $this->pdo->lastInsertId();
    }

    // READ - todos
    public function listarTodos() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY nome_aluno");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[] = (new Aluno($this->pdo))->fromRow($row);
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
    public function atualizarAluno($id, Aluno $aluno) {
        $stmt = $this->pdo->prepare("
            UPDATE {$this->table}
            SET nome_aluno = :nome,
                email = :email,
                cpf = :cpf,
                endereco = :endereco,
                contato = :contato,
                Id_Administrador = :idAdministrador
            WHERE Id_Aluno = :id
        ");
        return $stmt->execute([
            ':nome' => $aluno->getNome(),
            ':email' => $aluno->getEmail(),
            ':cpf' => $aluno->getCpf(),
            ':endereco' => $aluno->getEndereco(),
            ':contato' => $aluno->getContato(),
            ':idAdministrador' => $aluno->getIdAdministrador(),
            ':id' => $id
        ]);
    }
    public function excluirAluno($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE Id_Aluno = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>
