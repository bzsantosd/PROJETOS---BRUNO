<?php
require_once __DIR__ . '/../core/db.php';

class UserModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function login($email, $senha) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                if ($senha === $user['senha']) {
                    unset($user['senha']);
                    return $user;
                }
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Erro no login: " . $e->getMessage());
            return false;
        }
    }
    
    public function cadastrar($nome, $email, $senha) {
        try {
            // Verifica se email já existe
            $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return ['success' => false, 'message' => 'Email já cadastrado'];
            }
            
            $senhaHash = $senha;
            $stmt = $this->conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, 'cliente')");
            $stmt->bind_param("sss", $nome, $email, $senhaHash);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Cadastrado com sucesso'];
            } else {
                return ['success' => false, 'message' => 'Erro ao cadastrar'];
            }
        } catch (Exception $e) {
            error_log("Erro no cadastro: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro no sistema'];
        }
    }
    
    public function buscarTodos() {
        try {
            $stmt = $this->conn->prepare("SELECT id, nome, email, tipo, created_at FROM usuarios ORDER BY id DESC");
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
            $stmt = $this->conn->prepare("SELECT id, nome, email, tipo FROM usuarios WHERE id = ?");
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
                $stmt = $this->conn->prepare("UPDATE usuarios SET nome=?, email=?, tipo=?, senha=? WHERE id=?");
                $stmt->bind_param("ssssi", $nome, $email, $tipo, $senha, $id);
            } else {
                // Se não, mantém a senha atual
                $stmt = $this->conn->prepare("UPDATE usuarios SET nome=?, email=?, tipo=? WHERE id=?");
                $stmt->bind_param("sssi", $nome, $email, $tipo, $id);
            }
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao editar usuário: " . $e->getMessage());
            return false;
        }
    }
    
    public function deletar($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = ?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao deletar: " . $e->getMessage());
            return false;
        }
    }
}
?>