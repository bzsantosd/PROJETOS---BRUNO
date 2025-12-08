<?php
require_once __DIR__ . '/../core/db.php';

use PDO;

class UsuarioModel {
    private $conn;

    public $nome;
    public $cpf;
    public $email;
    public $senha;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function criarUsuario($usuario) {
        $query = "INSERT INTO USUARIOS (ID, NOME, EMAIL, TIPO, CREATED_AT) VALUES (:nome, :cpf, :email, :senha)";

        $stmt = $this -> conn -> prepare($query);

        $stmt -> bindParam(':nome', $this->nome);
        $stmt -> bindParam(':cpf', $this->cpf);
        $stmt -> bindParam(':email', $this->email);
        $stmt -> bindParam(':senha', $this->senha);

        return $stmt -> execute();
    }

    
    public function buscarTodos() {
        try {
            $stmt = $this->conn->prepare("SELECT id, nome, email, tipo, created_at FROM users ORDER BY id DESC");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar usuários: " . $e->getMessage());
            return [];
        }
    }
    
    public function buscarPorId($id) {
        try {
            $stmt = $this->conn->prepare("SELECT id, nome, email, tipo, created_at FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Erro ao buscar usuário: " . $e->getMessage());
            return null;
        }
    }
    
    public function editar($id, $nome, $email, $tipo, $senha = '') {
        try {
            // Se a senha foi fornecida, atualiza com senha
            if (!empty($senha)) {
                $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $this->conn->prepare("UPDATE users SET nome=?, email=?, tipo=?, senha=? WHERE id=?");
                $stmt->bind_param("ssssi", $nome, $email, $tipo, $hashedPassword, $id);
            } else {
                // Se a senha está vazia, não atualiza a senha
                $stmt = $this->conn->prepare("UPDATE users SET nome=?, email=?, tipo=? WHERE id=?");
                $stmt->bind_param("sssi", $nome, $email, $tipo, $id);
            }
            
            $result = $stmt->execute();
            
            if ($result) {
                error_log("✅ Usuário editado com sucesso! ID: " . $id);
            } else {
                error_log("❌ Erro ao editar usuário: " . $stmt->error);
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("❌ Exceção ao editar usuário: " . $e->getMessage());
            return false;
        }
    }
    
    public function deletar($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            
            if ($result) {
                error_log("✅ Usuário deletado com sucesso! ID: " . $id);
            } else {
                error_log("❌ Erro ao deletar usuário: " . $stmt->error);
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("❌ Exceção ao deletar usuário: " . $e->getMessage());
            return false;
        }
    }
    
    public function buscarPorEmail($email) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Erro ao buscar usuário por email: " . $e->getMessage());
            return null;
        }
    }
}
?>