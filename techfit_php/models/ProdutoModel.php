<?php
require_once __DIR__ . '/../core/db.php';

class ProductModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function buscarTodos() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM produtos ORDER BY id DESC");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar produtos: " . $e->getMessage());
            return [];
        }
    }
    
    public function buscarPorId($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Erro ao buscar produto: " . $e->getMessage());
            return null;
        }
    }
    
    public function criar($nome, $preco, $descricao, $imagem) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO produtos (nome, preco, descricao, imagem) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sdss", $nome, $preco, $descricao, $imagem);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao criar produto: " . $e->getMessage());
            return false;
        }
    }
    
    public function editar($id, $nome, $preco, $descricao, $imagem) {
        try {
            $stmt = $this->conn->prepare("UPDATE produtos SET nome=?, preco=?, descricao=?, imagem=? WHERE id=?");
            $stmt->bind_param("sdsi", $nome, $preco, $descricao, $imagem, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao editar produto: " . $e->getMessage());
            return false;
        }
    }
    
    public function deletar($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM produtos WHERE id=?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao deletar produto: " . $e->getMessage());
            return false;
        }
    }
}
?>