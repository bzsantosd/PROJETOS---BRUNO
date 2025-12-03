<?php
require_once __DIR__ . '/../core/db.php';

class UsuarioModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function login($email, $senha) {
        try {
            // Validação básica
            if (empty($email) || empty($senha)) {
                return false;
            }
            
            $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                // ✅ CORRIGIDO: Usa password_verify ao invés de comparação direta
                if (password_verify($senha, $user['senha'])) {
                    unset($user['senha']); // Remove senha do retorno
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
            // ✅ CORRIGIDO: Validações mais robustas
            if (empty($nome) || empty($email) || empty($senha)) {
                return ['success' => false, 'message' => 'Todos os campos são obrigatórios'];
            }
            
            if (strlen($senha) < 6) {
                return ['success' => false, 'message' => 'A senha deve ter no mínimo 6 caracteres'];
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'message' => 'Email inválido'];
            }
            
            // Verifica se email já existe
            $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return ['success' => false, 'message' => 'Email já cadastrado'];
            }
            
            // ✅ CORRIGIDO: Hash de senha seguro
            $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
            
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
            // ✅ CORRIGIDO: Validação de ID
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id) {
                return null;
            }
            
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
            // ✅ CORRIGIDO: Validações
            if (empty($nome) || empty($email)) {
                return false;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
            
            if (!in_array($tipo, ['cliente', 'admin'])) {
                return false;
            }
            
            // Se a senha foi fornecida, atualiza com senha
            if (!empty($senha)) {
                // ✅ CORRIGIDO: Hash de senha
                $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
                $stmt = $this->conn->prepare("UPDATE usuarios SET nome=?, email=?, tipo=?, senha=? WHERE id=?");
                $stmt->bind_param("ssssi", $nome, $email, $tipo, $senhaHash, $id);
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
            // ✅ CORRIGIDO: Validação de ID
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id) {
                return false;
            }
            
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