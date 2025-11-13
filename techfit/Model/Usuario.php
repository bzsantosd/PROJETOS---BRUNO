<?php
// Model/Produto.php

class Produto {
    private $pdo;
    private $table = 'Produtos';

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Cadastra novo produto
     */
    public function cadastrar($nome, $preco, $categoria, $quantidade, $idAdministrador, $idEstoque = 1) {
        $sql = "INSERT INTO {$this->table} 
                (nome_produto, preco, categoria, quantidade, Id_Administrador, Id_Estoque) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        
        try {
            $resultado = $stmt->execute([
                $nome, 
                $preco, 
                $categoria, 
                $quantidade, 
                $idAdministrador, 
                $idEstoque
            ]);
            
            return [
                'sucesso' => $resultado,
                'id' => $this->pdo->lastInsertId(),
                'mensagem' => 'Produto cadastrado com sucesso!'
            ];
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar produto: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro ao cadastrar produto.'];
        }
    }

    /**
     * Lista todos os produtos ativos
     */
    public function listarTodos($filtroCategoria = null) {
        $sql = "SELECT p.*, e.nome_estoque, u.nome AS cadastrado_por 
                FROM {$this->table} p
                INNER JOIN Estoque e ON p.Id_Estoque = e.Id_Estoque
                INNER JOIN Usuarios u ON p.Id_Administrador = u.Id_Usuario
                WHERE p.ativo = 1";
        
        if ($filtroCategoria) {
            $sql .= " AND p.categoria = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$filtroCategoria]);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        
        return $stmt->fetchAll();
    }

    /**
     * Busca produto por ID
     */
    public function buscarPorId($id) {
        $sql = "SELECT * FROM {$this->table} WHERE Id_Produto = ? AND ativo = 1 LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Atualiza produto
     */
    public function atualizar($id, $nome, $preco, $categoria, $quantidade) {
        $sql = "UPDATE {$this->table} 
                SET nome_produto = ?, preco = ?, categoria = ?, quantidade = ?
                WHERE Id_Produto = ?";
        
        $stmt = $this->pdo->prepare($sql);
        
        try {
            $resultado = $stmt->execute([$nome, $preco, $categoria, $quantidade, $id]);
            return ['sucesso' => $resultado, 'mensagem' => 'Produto atualizado!'];
        } catch (PDOException $e) {
            error_log("Erro ao atualizar: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar produto.'];
        }
    }

    /**
     * Remove produto (soft delete)
     */
    public function remover($id) {
        $sql = "UPDATE {$this->table} SET ativo = 0 WHERE Id_Produto = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Atualiza quantidade em estoque
     */
    public function atualizarEstoque($id, $quantidade) {
        $sql = "UPDATE {$this->table} SET quantidade = quantidade + ? WHERE Id_Produto = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$quantidade, $id]);
    }
}
?>