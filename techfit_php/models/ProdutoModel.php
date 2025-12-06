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
            // s = string, d = decimal/double, s = string, s = string
            $stmt->bind_param("sdss", $nome, $preco, $descricao, $imagem);
            $result = $stmt->execute();
            
            if ($result) {
                error_log("✅ Produto criado com sucesso! ID: " . $this->conn->insert_id);
            } else {
                error_log("❌ Erro ao criar produto: " . $stmt->error);
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("❌ Exceção ao criar produto: " . $e->getMessage());
            return false;
        }
    }
    
    public function editar($id, $nome, $preco, $descricao, $imagem) {
        try {
            $stmt = $this->conn->prepare("UPDATE produtos SET nome=?, preco=?, descricao=?, imagem=? WHERE id=?");
            // s = string, d = decimal, s = string, s = string, i = integer
            // CORRIGIDO: eram 5 parâmetros mas só 4 tipos definidos
            $stmt->bind_param("sdssi", $nome, $preco, $descricao, $imagem, $id);
            $result = $stmt->execute();
            
            if ($result) {
                error_log("✅ Produto editado com sucesso! ID: " . $id);
            } else {
                error_log("❌ Erro ao editar produto: " . $stmt->error);
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("❌ Exceção ao editar produto: " . $e->getMessage());
            return false;
        }
    }
    
    public function deletar($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM produtos WHERE id=?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            
            if ($result) {
                error_log("✅ Produto deletado com sucesso! ID: " . $id);
            } else {
                error_log("❌ Erro ao deletar produto: " . $stmt->error);
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("❌ Exceção ao deletar produto: " . $e->getMessage());
            return false;
        }
    }
}
?>