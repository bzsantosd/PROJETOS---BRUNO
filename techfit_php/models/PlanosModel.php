<?php
require_once __DIR__ . '/../core/db.php';

class PlanosModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function buscarTodos() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM planos ORDER BY id DESC");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar planos: " . $e->getMessage());
            return [];
        }
    }
    
    public function buscarPorId($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM planos WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Erro ao buscar plano: " . $e->getMessage());
            return null;
        }
    }
    
    public function criar($titulo, $valor, $beneficios) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO planos (titulo, valor, beneficios) VALUES (?, ?, ?)");
            // s = string, d = decimal, s = string
            $stmt->bind_param("sds", $titulo, $valor, $beneficios);
            $result = $stmt->execute();
            
            if ($result) {
                error_log("✅ Plano criado com sucesso! ID: " . $this->conn->insert_id);
            } else {
                error_log("❌ Erro ao criar plano: " . $stmt->error);
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("❌ Exceção ao criar plano: " . $e->getMessage());
            return false;
        }
    }
    
    public function editar($id, $titulo, $valor, $beneficios) {
        try {
            $stmt = $this->conn->prepare("UPDATE planos SET titulo=?, valor=?, beneficios=? WHERE id=?");
            // s = string, d = decimal, s = string, i = integer
            // CORRIGIDO: eram 4 parâmetros mas 5 tipos definidos
            $stmt->bind_param("sdsi", $titulo, $valor, $beneficios, $id);
            $result = $stmt->execute();
            
            if ($result) {
                error_log("✅ Plano editado com sucesso! ID: " . $id);
            } else {
                error_log("❌ Erro ao editar plano: " . $stmt->error);
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("❌ Exceção ao editar plano: " . $e->getMessage());
            return false;
        }
    }
    
    public function deletar($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM planos WHERE id=?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            
            if ($result) {
                error_log("✅ Plano deletado com sucesso! ID: " . $id);
            } else {
                error_log("❌ Erro ao deletar plano: " . $stmt->error);
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("❌ Exceção ao deletar plano: " . $e->getMessage());
            return false;
        }
    }
}
?>