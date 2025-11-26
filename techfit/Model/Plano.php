<?php

class Plano {
    private $pdo;
    private $table = 'Plano';

    private $id;
    private $nomePlano;
    private $email;
    private $cpf;
    private $endereco;
    private $contato;
    private $idAdministrador;

    public function __construct($pdo, $nomePlano = null, $email = null, $cpf = null, $endereco = null, $contato = null, $idAdministrador = null) {
        $this->pdo = $pdo;
        $this->nomePlano = $nomePlano;
        $this->email = $email;
        $this->cpf = $cpf;
        $this->endereco = $endereco;
        $this->contato = $contato;
        $this->idAdministrador = $idAdministrador;
    }

    // Getters / Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }

    public function getNomePlano() { return $this->nomePlano; }
    public function setNomePlano($nome) { $this->nomePlano = $nome; return $this; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; return $this; }

    public function getCpf() { return $this->cpf; }
    public function setCpf($cpf) { $this->cpf = $cpf; return $this; }

    public function getEndereco() { return $this->endereco; }
    public function setEndereco($endereco) { $this->endereco = $endereco; return $this; }

    public function getContato() { return $this->contato; }
    public function setContato($contato) { $this->contato = $contato; return $this; }

    public function getIdAdministrador() { return $this->idAdministrador; }
    public function setIdAdministrador($idAdministrador) { $this->idAdministrador = $idAdministrador; return $this; }

    public function fromRow(array $row) {
        $this->id = $row['Id_Plano'] ?? $row['id'] ?? null;
        $this->nomePlano = $row['nome_plano'] ?? $row['nome'] ?? null;
        $this->email = $row['email'] ?? null;
        $this->cpf = $row['cpf'] ?? null;
        $this->endereco = $row['endereco'] ?? null;
        $this->contato = $row['contato'] ?? null;
        $this->idAdministrador = $row['Id_Administrador'] ?? $row['id_administrador'] ?? null;
        return $this;
    }

    // Busca por email
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? $row : false;
    }

    // Busca por CPF
    public function buscarPorCpf($cpf) {
        $sql = "SELECT * FROM {$this->table} WHERE cpf = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$cpf]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? $row : false;
    }

    // Busca por email e cpf
    public function buscarPorEmailCpf($email, $cpf) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? AND cpf = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email, $cpf]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? $row : false;
    }

    // Cadastra novo plano
    public function cadastrar($nomePlano = null, $email = null, $cpf = null, $endereco = null, $contato = null, $idAdministrador = 1) {
        $nomePlano = $nomePlano ?? $this->nomePlano;
        $email = $email ?? $this->email;
        $cpf = $cpf ?? $this->cpf;
        $endereco = $endereco ?? $this->endereco;
        $contato = $contato ?? $this->contato;
        $idAdministrador = $idAdministrador ?? $this->idAdministrador ?? 1;

        if (!$nomePlano) {
            return ['sucesso' => false, 'mensagem' => 'Nome do plano é obrigatório!'];
        }

        $sql = "INSERT INTO {$this->table} (nome_plano, email, cpf, endereco, contato, Id_Administrador)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        try {
            $resultado = $stmt->execute([$nomePlano, $email, $cpf, $endereco, $contato, $idAdministrador]);
            $this->id = $this->pdo->lastInsertId();
            $this->nomePlano = $nomePlano;
            $this->email = $email;
            $this->cpf = $cpf;
            $this->endereco = $endereco;
            $this->contato = $contato;
            $this->idAdministrador = $idAdministrador;

            return [
                'sucesso' => $resultado,
                'id' => $this->id,
                'mensagem' => 'Plano cadastrado com sucesso!'
            ];
        } catch (\PDOException $e) {
            error_log("Erro ao cadastrar plano: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro ao cadastrar: ' . $e->getMessage()];
        }
    }

    // Recupera plano por ID (retorna objeto Plano ou null)
    public function buscarPorId($id) {
        $sql = "SELECT p.*, ad.nome_administrador
                FROM {$this->table} p
                LEFT JOIN Administrador ad ON p.Id_Administrador = ad.Id_Administrador
                WHERE p.Id_Plano = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (new self($this->pdo))->fromRow($row) : null;
    }

    // Lista todos os planos (retorna array de objetos Plano)
    public function listarTodos() {
        $sql = "SELECT * FROM {$this->table} ORDER BY Id_Plano DESC";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[] = (new self($this->pdo))->fromRow($row);
        }
        return $result;
    }

    // Atualiza plano
    public function atualizar($id, $nomePlano, $email, $endereco, $contato) {
        $sql = "UPDATE {$this->table}
                SET nome_plano = ?, email = ?, endereco = ?, contato = ?
                WHERE Id_Plano = ?";
        $stmt = $this->pdo->prepare($sql);
        try {
            $resultado = $stmt->execute([$nomePlano, $email, $endereco, $contato, $id]);
            return ['sucesso' => $resultado, 'mensagem' => 'Plano atualizado!'];
        } catch (\PDOException $e) {
            error_log("Erro ao atualizar plano: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar: ' . $e->getMessage()];
        }
    }

    // Remove plano
    public function remover($id) {
        $sql = "DELETE FROM {$this->table} WHERE Id_Plano = ?";
        $stmt = $this->pdo->prepare($sql);
        try {
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            error_log("Erro ao remover plano: " . $e->getMessage());
            return false;
        }
    }
}
?>

