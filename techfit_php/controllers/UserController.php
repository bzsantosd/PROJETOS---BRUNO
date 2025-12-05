<?php
// Inclua o Model necessário
require_once ROOT_PATH . '/app/models/User.php';

class UserController {
    
    // Método para exibir a View de Cadastro
    public function showRegisterForm() {
        // Nenhuma lógica de dados é necessária, apenas carrega a View.
        $this->loadView('cadastro');
    }

    // Método para processar o formulário de Cadastro
    public function register($post_data) {
        // 1. Chamar o Model para lidar com a persistência dos dados
        $userModel = new User();
        $success = $userModel->create($post_data);
        
        // 2. Decidir qual View carregar com base no resultado
        if ($success) {
            // Se o cadastro foi bem-sucedido, redireciona para o login
            header('Location: /login'); 
        } else {
            // Se falhou, recarrega a View de cadastro com uma mensagem de erro
            $error_message = "Erro ao cadastrar. Tente novamente.";
            $this->loadView('cadastro', ['error' => $error_message]);
        }
    }
    
    // Função auxiliar simples para carregar a View
    private function loadView($viewName, $data = []) {
        // Torna o array $data disponível como variáveis na View (ex: $error)
        extract($data); 
        // Inclui o arquivo HTML correspondente
        include ROOT_PATH . "/app/views/{$viewName}.html"; 
    }
}
class User {
    
    // Simulação de conexão com o Banco de Dados (substitua pela lógica real)
    private $db_connection;

    public function __construct() {
        // Lógica de inicialização de conexão com o BD (PDO, mysqli, etc.)
        // Exemplo: $this->db_connection = new PDO(...);
    }

    // Método para criar um novo usuário no BD
    public function create($data) {
        // Validação de dados (ex: verificar senhas, formato de e-mail)
        if ($data['senha'] !== $data['repita-senha']) {
            return false;
        }

        // Lógica de inserção no banco de dados
        // Exemplo: 
        /* $stmt = $this->db_connection->prepare("INSERT INTO users (nome, cpf, email, senha) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$data['nome'], $data['cpf'], $data['email'], password_hash($data['senha'], PASSWORD_DEFAULT)]);
        return $result;
        */
        
        // POR ENQUANTO, apenas retorna sucesso para continuar o fluxo
        return true; 
    }
}