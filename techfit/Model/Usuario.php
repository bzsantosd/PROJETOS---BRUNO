<?php


class Usuario {
    private $pdo;
    private $table = 'Usuario';

    private $id;
    private $nome;
    private $email;
    private $senha;
    private $cpf;
    private $contato;


    public function __construct($pdo, $nome = null, $email = null, $senha = null, $cpf = null, $contato = null) {
        $this->pdo = $pdo;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->cpf = $cpf;
        $this->contato = $contato;
    }

    // Getters / Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }

    public function getNome() { return $this->nome; }
    public function setNome($nome) { $this->nome = $nome; return $this; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; return $this; }

    public function getSenha() { return $this->senha; }
    public function setSenha($senha) { $this->senha = $senha; return $this; }

    public function getCpf() { return $this->cpf; }
    public function setCpf($cpf) { $this->cpf = $cpf; return $this; }

    public function getContato() { return $this->contato; }
    public function setContato($contato) { $this->contato = $contato; return $this; }

    // Mapear linha do banco para objeto
    public function fromRow(array $row) {
        $this->id = $row['Id_Usuario'] ?? $row['id'] ?? null;
        $this->nome = $row['nome_usuario'] ?? $row['nome'] ?? null;
        $this->email = $row['email'] ?? null;
        $this->senha = $row['senha'] ?? null;
        $this->cpf = $row['cpf'] ?? null;
        $this->contato = $row['contato'] ?? null;
        return $this;
    }

    // Consultas
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? $row : false;
    }

    public function buscarPorCpf($cpf) {
        $sql = "SELECT * FROM {$this->table} WHERE cpf = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$cpf]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? $row : false;
    }

    public function buscarPorEmailSenha($email, $senha) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) return false;
        return ($row['senha'] === $senha) ? $row : false;
    }

    // CRUD
    public function cadastrar($nome = null, $email = null, $senha = null, $cpf = null, $contato = null, $idAdministrador = 1) {
        $nome = $nome ?? $this->nome;
        $email = $email ?? $this->email;
        $senha = $senha ?? $this->senha;
        $cpf = $cpf ?? $this->cpf;
        $contato = $contato ?? $this->contato;
        $idAdministrador = $idAdministrador ?? $this->idAdministrador ?? 1;

        if (!$nome || !$email || !$senha) {
            return ['sucesso' => false, 'mensagem' => 'Nome, email e senha são obrigatórios.'];
        }

        if ($this->buscarPorEmail($email)) {
            return ['sucesso' => false, 'mensagem' => 'Email já cadastrado.'];
        }

        if ($cpf && $this->buscarPorCpf($cpf)) {
            return ['sucesso' => false, 'mensagem' => 'CPF já cadastrado.'];
        }

        $sql = "INSERT INTO {$this->table} (nome_usuario, email, senha, cpf, contato, Id_Administrador)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        try {
            $ok = $stmt->execute([$nome, $email, $senha, $cpf, $contato, $idAdministrador]);
            $this->id = $this->pdo->lastInsertId();
            $this->nome = $nome;
            $this->email = $email;
            $this->senha = $senha;
            $this->cpf = $cpf;
            $this->contato = $contato;
            return ['sucesso' => $ok, 'id' => $this->id, 'mensagem' => 'Usuário cadastrado com sucesso.'];
        } catch (\PDOException $e) {
            error_log("Usuario::cadastrar - " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro ao cadastrar: ' . $e->getMessage()];
        }
    }

    public function login($email, $senha) {
        $row = $this->buscarPorEmailSenha($email, $senha);
        if (!$row) return ['sucesso' => false, 'mensagem' => 'Credenciais inválidas.'];
        $user = (new self($this->pdo))->fromRow($row);
        return ['sucesso' => true, 'usuario' => ['id' => $user->getId(), 'nome' => $user->getNome(), 'email' => $user->getEmail()]];
    }

    public function listarTodos() {
        $sql = "SELECT * FROM {$this->table} ORDER BY nome_usuario";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[] = (new self($this->pdo))->fromRow($row);
        }
        return $result;
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM {$this->table} WHERE Id_Usuario = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (new self($this->pdo))->fromRow($row) : null;
    }

    public function atualizar($id, $nome, $email, $contato) {
        $sql = "UPDATE {$this->table} SET nome_usuario = ?, email = ?, contato = ? WHERE Id_Usuario = ?";
        $stmt = $this->pdo->prepare($sql);
        try {
            $ok = $stmt->execute([$nome, $email, $contato, $id]);
            return ['sucesso' => $ok, 'mensagem' => 'Usuário atualizado.'];
        } catch (\PDOException $e) {
            error_log("Usuario::atualizar - " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar: ' . $e->getMessage()];
        }
    }

    public function remover($id) {
        $sql = "DELETE FROM {$this->table} WHERE Id_Usuario = ?";
        $stmt = $this->pdo->prepare($sql);
        try {
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            error_log("Usuario::remover - " . $e->getMessage());
            return false;
        }
    }
}
?>
