<?php
// Inclua o Model necessário
require_once ROOT_PATH . '/app/models/User.php';

class UserController {
    
    // Método para exibir a View de Cadastro
    public function showRegisterForm() {
        $this->loadView('cadastro');
    }

    // Método para processar o formulário de Cadastro
    public function register($post_data) {
        $userModel = new User();
        $success = $userModel->create($post_data);
        
        if ($success) {
            // Se o cadastro foi bem-sucedido, redireciona para o login
            // Note: O cliente verá a modal de sucesso no cadastro.html e só depois será redirecionado.
            header('Location: /techfit_php/public/login.html?registered=success'); 
            exit;
        } else {
            $error_message = "Erro ao cadastrar. Tente novamente.";
            $this->loadView('cadastro', ['error' => $error_message]);
        }
    }

    // NOVO MÉTODO PARA PROCESSAR O LOGIN
    public function login($post_data) {
        $userModel = new User();
        
        // No seu login.html, o campo é nomeado 'usuario'. O User.php espera 'email'.
        // O campo 'usuario' será usado como 'email' no backend.
        $user = $userModel->authenticate($post_data['usuario'], $post_data['senha']); 

        if ($user) {
            // Inicia a sessão e armazena dados do usuário (ex: ID)
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            
            // SUCESSO: Redireciona para a área interna do site (Dashboard ou Planos)
            header('Location: /techfit_php/public/Planos.html'); 
            exit;
        } else {
            // FALHA: Redireciona de volta para a tela de login com uma mensagem de erro
            header('Location: /techfit_php/public/login.html?error=invalid'); 
            exit;
        }
    }
    
    // Função auxiliar simples para carregar a View
    private function loadView($viewName, $data = []) {
        extract($data); 
        include ROOT_PATH . "/app/views/{$viewName}.html"; 
    }
}