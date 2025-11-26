<?php

require_once __DIR__ . '/../Models/Aluno.php';
require_once __DIR__ . '/../Models/Administrador.php';

class AuthController {
    private $alunoModel;
    private $adminModel;

    public function __construct($pdo) {
        $this->alunoModel = new Aluno($pdo);
        $this->adminModel = new Administrador($pdo);
    }

    /**
     * Exibe o formulário de login
     */
    public function exibirLogin() {
        include __DIR__ . '/../Views/auth/login.php';
    }

    /**
     * Processa o login (Admin ou Aluno)
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->exibirLogin();
            return;
        }

        $usuario = trim($_POST['usuario'] ?? '');
        $senha = trim($_POST['senha'] ?? '');

        if (empty($usuario) || empty($senha)) {
            $_SESSION['erro_login'] = 'Preencha todos os campos!';
            $this->exibirLogin();
            return;
        }

        // Tenta login como ADMIN primeiro
        if (filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
            $resultadoAdmin = $this->adminModel->login($usuario, $senha);
            
            if ($resultadoAdmin['sucesso']) {
                session_regenerate_id(true);
                
                $_SESSION['usuario_logado'] = true;
                $_SESSION['user_id'] = $resultadoAdmin['admin']['id'];
                $_SESSION['user_nome'] = $resultadoAdmin['admin']['nome'];
                $_SESSION['user_email'] = $resultadoAdmin['admin']['email'];
                $_SESSION['user_role'] = 'admin';

                header('Location: /admin/dashboard');
                exit();
            }
        }

        // Se não for admin, tenta login como ALUNO
        $cpfLimpo = preg_replace('/[^0-9]/', '', $senha);
        $cpfFormatado = substr($cpfLimpo, 0, 3) . '.' . 
                        substr($cpfLimpo, 3, 3) . '.' . 
                        substr($cpfLimpo, 6, 3) . '-' . 
                        substr($cpfLimpo, 9, 2);

        $resultadoAluno = $this->alunoModel->login($usuario, $cpfFormatado);

        if ($resultadoAluno['sucesso']) {
            session_regenerate_id(true);
            
            $_SESSION['usuario_logado'] = true;
            $_SESSION['user_id'] = $resultadoAluno['aluno']['id'];
            $_SESSION['user_nome'] = $resultadoAluno['aluno']['nome'];
            $_SESSION['user_email'] = $resultadoAluno['aluno']['email'];
            $_SESSION['user_role'] = 'aluno';

            header('Location: /aluno/dashboard');
            exit();
        }

        $_SESSION['erro_login'] = 'Usuário ou senha incorretos!';
        $this->exibirLogin();
    }

    /**
     * Exibe formulário de cadastro de aluno
     */
    public function exibirCadastro() {
        include __DIR__ . '/../Views/auth/cadastro.php';
    }

    /**
     * Processa o cadastro de aluno
     */
    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->exibirCadastro();
            return;
        }

        $nome = htmlspecialchars(trim($_POST['nome'] ?? ''));
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
        $endereco = htmlspecialchars(trim($_POST['endereco'] ?? ''));
        $contato = htmlspecialchars(trim($_POST['contato'] ?? ''));

        if (empty($nome) || empty($email) || empty($cpf)) {
            $_SESSION['erro_cadastro'] = 'Preencha todos os campos obrigatórios!';
            $this->exibirCadastro();
            return;
        }

        if (strlen($cpf) !== 11) {
            $_SESSION['erro_cadastro'] = 'CPF inválido!';
            $this->exibirCadastro();
            return;
        }


        $cpfFormatado = substr($cpf, 0, 3) . '.' . 
                        substr($cpf, 3, 3) . '.' . 
                        substr($cpf, 6, 3) . '-' . 
                        substr($cpf, 9, 2);

        $resultado = $this->alunoModel->cadastrar($nome, $email, $cpfFormatado, $endereco, $contato);

        if ($resultado['sucesso']) {
            $_SESSION['sucesso_cadastro'] = $resultado['mensagem'];
            header('Location: /login');
            exit();
        } else {
            $_SESSION['erro_cadastro'] = $resultado['mensagem'];
            $this->exibirCadastro();
        }
    }

    /**
     * Exibe formulário de recuperação
     */
    public function exibirEsqueceuSenha() {
        include __DIR__ . '/../Views/auth/esqueceu_senha.php';
    }

    /**
     * Processa recuperação (mostra CPF do aluno)
     */
    public function recuperarSenha() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->exibirEsqueceuSenha();
            return;
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
        
        $cpfFormatado = substr($cpf, 0, 3) . '.' . 
                        substr($cpf, 3, 3) . '.' . 
                        substr($cpf, 6, 3) . '-' . 
                        substr($cpf, 9, 2);

        $aluno = $this->alunoModel->buscarPorEmailCpf($email, $cpfFormatado);

        if ($aluno) {
            $_SESSION['recuperacao_sucesso'] = true;
            $_SESSION['cpf_recuperado'] = $cpfFormatado;
            $_SESSION['mensagem_recuperacao'] = 'Sua senha de acesso é o seu CPF (somente números)';
        } else {
            $_SESSION['erro_recuperacao'] = 'Dados não encontrados!';
        }

        $this->exibirEsqueceuSenha();
    }

    /**
     * Logout
     */
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
?>