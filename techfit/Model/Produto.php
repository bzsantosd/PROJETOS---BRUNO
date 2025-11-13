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
     * Lista todos os produtos
     */
    public function listarTodos($filtroCategoria = null) {
        $sql = "SELECT p.*, a.nome_administrador 
                FROM {$this->table} p
                INNER JOIN Administrador a ON p.Id_Administrador = a.Id_Administrador";
        
        if ($filtroCategoria) {
            $sql .= " WHERE p.categoria = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$filtroCategoria]);
        } else {
            $sql .= " ORDER BY p.nome_produto";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        
        return $stmt->fetchAll();
    }

    /**
     * Busca produto por ID
     */
    public function buscarPorId($id) {
        $sql = "SELECT p.*, a.nome_administrador 
                FROM {$this->table} p
                INNER JOIN Administrador a ON p.Id_Administrador = a.Id_Administrador
                WHERE p.Id_Produtos = ? LIMIT 1";
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
                WHERE Id_Produtos = ?";
        
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
     * Remove produto
     */
    public function remover($id) {
        $sql = "DELETE FROM {$this->table} WHERE Id_Produtos = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Atualiza quantidade em estoque
     */
    public function atualizarEstoque($id, $quantidade) {
        $sql = "UPDATE {$this->table} SET quantidade = quantidade + ? WHERE Id_Produtos = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$quantidade, $id]);
    }

    /**
     * Produtos com baixo estoque
     */
    public function listarBaixoEstoque($limite = 10) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE quantidade <= ? 
                ORDER BY quantidade ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limite]);
        return $stmt->fetchAll();
    }

    /**
     * Relatório de produtos por categoria
     */
    public function relatorioCategoria() {
        $sql = "SELECT categoria, COUNT(*) as total_produtos, SUM(quantidade) as total_estoque, 
                SUM(preco * quantidade) as valor_total
                FROM {$this->table} 
                GROUP BY categoria 
                ORDER BY total_produtos DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
}
?>