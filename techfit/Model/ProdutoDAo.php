<?php

use Techfit\Config\Connection;

require_once 'Produto.php';
require_once 'Connection.php';

class ProdutoDAO {
    private $pdo;
    private $table = 'Produto';

    public function __construct() {
        $this->pdo = Connection::getInstance();

        $sql = "
            CREATE TABLE IF NOT EXISTS {$this->table} (
                Id_Produto INT AUTO_INCREMENT PRIMARY KEY,
                nome_produto VARCHAR(150) NOT NULL,
                descricao TEXT,
                preco DECIMAL(10,2) DEFAULT 0.00,
                estoque INT DEFAULT 0,
                Id_Administrador INT,
                CONSTRAINT fk_produto_administrador FOREIGN KEY (Id_Administrador)
                    REFERENCES Administrador (Id_Administrador)
                    ON DELETE SET NULL
                    ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";
        try {
            $this->pdo->exec($sql);
        } catch (\PDOException $e) {
            error_log("ProdutoDAO::__construct - erro criar tabela: " . $e->getMessage());
        }
    }

    // CREATE
    public function criarProduto(Produto $produto) {
        $stmt = $this->pdo->prepare("
            INSERT INTO {$this->table} (nome_produto, descricao, preco, estoque, Id_Administrador)
            VALUES (:nome, :descricao, :preco, :estoque, :idAdministrador)
        ");
        try {
            $stmt->execute([
                ':nome' => $produto->getNome(),
                ':categoria' => $produto->getCategoria(),
                ':quantidade' => $produto->getQuantidade(),
                ':estoque' => $produto->getIdEstoque(),
                ':idAdministrador' => $produto->getIdAdministrador()
            ]);
            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            error_log("ProdutoDAO::criarProduto - " . $e->getMessage());
            return false;
        }
    }

    // READ - todos
    public function listarTodos() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY Id_Produto DESC");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[] = (new Produto($this->pdo))->fromRow($row);
        }
        return $result;
    }

    // READ - por ID
    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE Id_Produto = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (new Produto($this->pdo))->fromRow($row) : null;
    }

    // READ - por nome (opcional)
    public function buscarPorNome($nome) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE nome_produto LIKE :nome");
        $stmt->execute([':nome' => "%{$nome}%"]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[] = (new Produto($this->pdo))->fromRow($row);
        }
        return $result;
    }

    // UPDATE
    public function atualizarProduto($id, Produto $produto) {
        $stmt = $this->pdo->prepare("
            UPDATE {$this->table}
            SET nome_produto = :nome,
                descricao = :descricao,
                preco = :preco,
                estoque = :estoque,
                Id_Administrador = :idAdministrador
            WHERE Id_Produto = :id
        ");
        try {
            return $stmt->execute([
                ':nome' => $produto->getNome(),
                ':categoria' => $produto->getCategoria(),
                ':quantidade' => $produto->getQuantidade(),
                ':estoque' => $produto->getIdEstoque(),
                ':idAdministrador' => $produto->getIdAdministrador()
            ]);
        } catch (\PDOException $e) {
            error_log("ProdutoDAO::atualizarProduto - " . $e->getMessage());
            return false;
        }
    }

    // DELETE
    public function excluirProduto($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE Id_Produto = :id");
        try {
            return $stmt->execute([':id' => $id]);
        } catch (\PDOException $e) {
            error_log("ProdutoDAO::excluirProduto - " . $e->getMessage());
            return false;
        }
    }
}
?>
