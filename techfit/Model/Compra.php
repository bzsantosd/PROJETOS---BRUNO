<?php
class Compra {
    private $pdo;
    private $table = 'Compra';

    private $id;
    private $nomeComprador;
    private $email;
    private $cpf;
    private $endereco;
    private $contato;
    private $idAdministrador;

    public function __construct($pdo, $nomeComprador = null, $email = null, $cpf = null, $endereco = null, $contato = null, $idAdministrador = null) {
        $this->pdo = $pdo;
        $this->nomeComprador = $nomeComprador;
        $this->email = $email;
        $this->cpf = $cpf;
        $this->endereco = $endereco;
        $this->contato = $contato;
        $this->idAdministrador = $idAdministrador;
    }

    // Getters / Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }

    public function getNomeComprador() { return $this->nomeComprador; }
    public function setNomeComprador($nome) { $this->nomeComprador = $nome; return $this; }

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

    // Preenche objeto a partir de uma linha do banco
    public function fromRow(array $row) {
        $this->id = $row['Id_Compra'] ?? $row['id'] ?? null;
        $this->nomeComprador = $row['nome_comprador'] ?? $row['nome'] ?? null;
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

    // Cadastra nova compra
    public function cadastrar($nomeComprador = null, $email = null, $cpf = null, $endereco = null, $contato = null, $idAdministrador = 1) {
        $nomeComprador = $nomeComprador ?? $this->nomeComprador;
        $email = $email ?? $this->email;
        $cpf = $cpf ?? $this->cpf;
        $endereco = $endereco ?? $this->endereco;
        $contato = $contato ?? $this->contato;
        $idAdministrador = $idAdministrador ?? $this->idAdministrador ?? 1;

        // validações básicas (ajuste conforme regra de negócio)
        if (!$email || !$cpf) {
            return ['sucesso' => false, 'mensagem' => 'Email e CPF são obrigatórios!'];
        }

        $sql = "INSERT INTO {$this->table} (nome_comprador, email, cpf, endereco, contato, Id_Administrador)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        try {
            $resultado = $stmt->execute([$nomeComprador, $email, $cpf, $endereco, $contato, $idAdministrador]);
            $this->id = $this->pdo->lastInsertId();
            $this->nomeComprador = $nomeComprador;
            $this->email = $email;
            $this->cpf = $cpf;
            $this->endereco = $endereco;
            $this->contato = $contato;
            $this->idAdministrador = $idAdministrador;

            return [
                'sucesso' => $resultado,
                'id' => $this->id,
                'mensagem' => 'Compra cadastrada com sucesso!'
            ];
        } catch (\PDOException $e) {
            error_log("Erro ao cadastrar compra: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro ao cadastrar: ' . $e->getMessage()];
        }
    }

    // Recupera compra por ID (retorna objeto Compra ou null)
    public function buscarPorId($id) {
        $sql = "SELECT c.*, ad.nome_administrador 
                FROM {$this->table} c
                LEFT JOIN Administrador ad ON c.Id_Administrador = ad.Id_Administrador
                WHERE c.Id_Compra = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (new self($this->pdo))->fromRow($row) : null;
    }

    // Lista todas as compras (retorna array de objetos Compra)
    public function listarTodos() {
        $sql = "SELECT * FROM {$this->table} ORDER BY Id_Compra DESC";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[] = (new self($this->pdo))->fromRow($row);
        }
        return $result;
    }

    // Atualiza compra (ajuste campos conforme necessidade)
    public function atualizar($id, $nomeComprador, $email, $endereco, $contato) {
        $sql = "UPDATE {$this->table}
                SET nome_comprador = ?, email = ?, endereco = ?, contato = ?
                WHERE Id_Compra = ?";
        $stmt = $this->pdo->prepare($sql);
        try {
            $resultado = $stmt->execute([$nomeComprador, $email, $endereco, $contato, $id]);
            return ['sucesso' => $resultado, 'mensagem' => 'Compra atualizada!'];
        } catch (\PDOException $e) {
            error_log("Erro ao atualizar compra: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar: ' . $e->getMessage()];
        }
    }

    // Remove compra
    public function remover($id) {
        $sql = "DELETE FROM {$this->table} WHERE Id_Compra = ?";
        $stmt = $this->pdo->prepare($sql);
        try {
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            error_log("Erro ao remover compra: " . $e->getMessage());
            return false;
        }
    }
}
?>
