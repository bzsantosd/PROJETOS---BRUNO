<?php


class Produto {
    private $pdo;
    private $table = 'Produto';

    private $id;
    private $nome;
    private $categoria;
    private $quantidade;
    private $idAdministrador;
    private $idEstoque;

    public function __construct($pdo, $nome = null, $categoria = null, $quantidade = null, $idAdministrador = null, $idEstoque = null) {
        $this->pdo = $pdo;
        $this->nome = $nome;
        $this->categoria = $categoria;
        $this->quantidade = $quantidade;
        $this->idAdministrador = $idAdministrador;
        $this->idEstoque = $idEstoque;
    }

    // Getters / Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; return $this; }

    public function getNome() { return $this->nome; }
    public function setNome($nome) { $this->nome = $nome; return $this; }

    public function getCategoria() { return $this->categoria; }
    public function setCategoria($categoria) { $this->categoria = $categoria; return $this; }

    public function getQuantidade() { return $this->quantidade; }
    public function setQuantidade($quantidade) { $this->quantidade = $quantidade; return $this; }

    public function getIdEstoque() { return $this->idEstoque; }
    public function setIdEstoque($idEstoque) { $this->idEstoque = $idEstoque; return $this; }

    public function getIdAdministrador() { return $this->idAdministrador; }
    public function setIdAdministrador($idAdministrador) { $this->idAdministrador = $idAdministrador; return $this; }

    public function fromRow(array $row) {
        $this->id = $row['Id_Plano'] ?? $row['id'] ?? null;
        $this->nome = $row['nome'] ?? $row['nome'] ?? null;
        $this->categoria = $row['categoria'] ?? null;
        $this->quantidade = $row['quantidade'] ?? null;
        $this->idAdministrador = $row['Id_Administrador'] ?? $row['id_administrador'] ?? null;
        $this->idEstoque = $row['Id_Estoque'] ?? $row['id_estoque'] ?? null;
        return $this;
    }

    // Busca por nome
    public function buscarporNome($nome) {
        $sql = "SELECT * FROM {$this->table} WHERE nome = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? $row : false;
    }

    // Busca por CPF
    public function buscarporQuantidade($quantidade) {
        $sql = "SELECT * FROM {$this->table} WHERE quantidade = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$quantidade]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? $row : false;
    }

    // Busca por email e cpf
    public function buscarporNomequantidade($nome, $quantidade) {
        $sql = "SELECT * FROM {$this->table} WHERE nome = ? AND quantidade = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome, $quantidade]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? $row : false;
    }

    // Cadastra novo plano
    public function cadastrar($id = null, $nome = null, $categoria = null, $quantidade = null, $idAdministrador = 1, $idEstoque = null) {
        $id = $id ?? $this->id;
        $nome = $nome ?? $this->nome;
        $categoria = $categoria ?? $this->categoria;
        $quantidade = $quantidade ?? $this->quantidade;
        $idEstoque = $idEstoque ?? $this->idEstoque;
        $idAdministrador = $idAdministrador ?? $this->idAdministrador ?? 1;

        if (!$nome) {
            return ['sucesso' => false, 'mensagem' => 'Nome do produto é obrigatório!'];
        }

        $sql = "INSERT INTO {$this->table} (nome, categoria, quantidade, Id_Administrador, Id_Estoque)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        try {
            $resultado = $stmt->execute([$nome, $categoria, $quantidade, $idAdministrador, $idEstoque]);
            $this->id = $this->pdo->lastInsertId();
            $this->nome = $nome;
            $this->categoria = $categoria;
            $this->quantidade = $quantidade;
            $this->idEstoque = $idEstoque;
            $this->idAdministrador = $idAdministrador;

            return [
                'sucesso' => $resultado,
                'id' => $this->id,
                'mensagem' => 'Produto cadastrado com sucesso!'
            ];
        } catch (\PDOException $e) {
            error_log("Erro ao cadastrar produto: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro ao cadastrar: ' . $e->getMessage()];
        }
    }

    // Recupera produto por ID (retorna objeto Produto ou null)
    public function buscarPorId($id) {
        $sql = "SELECT p.*, ad.nome_administrador
                FROM {$this->table} p
                LEFT JOIN Administrador ad ON p.Id_Administrador = ad.Id_Administrador
                WHERE p.Id_Produto = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (new self($this->pdo))->fromRow($row) : null;
    }

    // Lista todos os planos (retorna array de objetos Plano)
    public function listarTodos() {
        $sql = "SELECT * FROM {$this->table} ORDER BY Id_Produto DESC";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[] = (new self($this->pdo))->fromRow($row);
        }
        return $result;
    }

    // Atualiza plano
    public function atualizar($id, $nome, $categoria, $quantidade, $idAdministrador, $idEstoque) {
        $sql = "UPDATE {$this->table}
                SET nome = ?, categoria = ?, quantidade = ?, Id_Administrador = ?, Id_Estoque = ?
                WHERE Id_Produto = ?";
        $stmt = $this->pdo->prepare($sql);
        try {
            $resultado = $stmt->execute([$nome, $categoria, $quantidade, $idAdministrador, $idEstoque, $id]);
            return ['sucesso' => $resultado, 'mensagem' => 'Produto atualizado!'];
        } catch (\PDOException $e) {
            error_log("Erro ao atualizar produto: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar: ' . $e->getMessage()];
        }
    }

    // Remove produto
    public function remover($id) {
        $sql = "DELETE FROM {$this->table} WHERE Id_Produto = ?";
        $stmt = $this->pdo->prepare($sql);
        try {
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            error_log("Erro ao remover produto: " . $e->getMessage());
            return false;
        }
    }
}
?>

