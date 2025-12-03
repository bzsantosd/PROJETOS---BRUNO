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
            error_log("Erro ao buscar planos: " . $e->getMessage());
            return null;
        }
    }
    
    public function criar($titulo, $valor, $beneficios) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO planos (titulo, valor, beneficios) VALUES (?, ?, ?)");
            $stmt->bind_param("sds", $titulo, $valor, $beneficios);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao criar plano: " . $e->getMessage());
            return false;
        }
    }
    
    public function editar($id, $titulo, $valor, $beneficios) {
        try {
            $stmt = $this->conn->prepare("UPDATE planos SET titulo=?, valor=?, beneficios=? WHERE id=?");
            $stmt->bind_param("sdssi", $titulo, $valor, $beneficios, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao editar plano: " . $e->getMessage());
            return false;
        }
    }
    
    public function deletar($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM planos WHERE id=?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao deletar plano: " . $e->getMessage());
            return false;
        }
    }
}
?>