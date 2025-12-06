<?php
require_once __DIR__ . '/../core/db.php'; 

class User {
    
    private $db_connection;

    public function __construct() {
        $this->db_connection = Database::getInstance()->getConnection(); 
    }

    // [MÉTODO CREATE EXISTENTE...]
    public function create($data) {
        // Validação de dados (MANTENHA ISSO)
        if ($data['senha'] !== $data['repita-senha']) {
            return false;
        }

        try {
            // A. Crie o HASH da senha por segurança
            $hashed_password = password_hash($data['senha'], PASSWORD_DEFAULT);
            
            // B. Prepare a query SQL
            $stmt = $this->db_connection->prepare("INSERT INTO users (nome, cpf, email, senha) VALUES (?, ?, ?, ?)");
            
            // C. Bind dos parâmetros (ssss = 4 strings)
            $stmt->bind_param("ssss", $data['nome'], $data['cpf'], $data['email'], $hashed_password);
            
            // D. Executa a inserção e retorna o resultado (true ou false)
            $result = $stmt->execute();
            return $result;
            
        } catch (Exception $e) {
            error_log("Erro ao cadastrar usuário: " . $e->getMessage());
            return false;
        }
    }

    // NOVO MÉTODO PARA AUTENTICAÇÃO
    public function authenticate($email, $password) {
        try {
            // 1. Consulta o usuário pelo email
            $stmt = $this->db_connection->prepare("SELECT id, email, senha FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                // 2. Verifica se a senha fornecida corresponde ao hash no banco
                if (password_verify($password, $user['senha'])) {
                    return $user; // Login bem-sucedido
                }
            }
            
            return false; // Usuário não encontrado ou senha incorreta

        } catch (Exception $e) {
            error_log("Erro durante a autenticação: " . $e->getMessage());
            return false;
        }
    }
}
?>