<?php
require_once __DIR__ . "/../models/UsuarioModel.php";

class UsuarioController {
    private $model;
    
    public function __construct() {
        $this->model = new UsuarioModel();
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /Login.html");
            exit;
        }
        
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        
        if (empty($email) || empty($senha)) {
            die("Preencha todos os campos! <a href='/Login.html'>Voltar</a>");
        }
        
        $user = $this->model->login($email, $senha);
        
        if ($user) {
            $_SESSION['user'] = $user;
            
            if ($user['tipo'] === 'admin') {
                header("Location: /adm.html");
            } else {
                header("Location: /pág.inicial.html");
            }
            exit;
        } else {
            die("Email ou senha incorretos. <a href='/Login.html'>Tentar novamente</a>");
        }
    }
    
    public function cadastro() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /cadastro.html");
            exit;
        }
        
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        
        if (empty($nome) || empty($email) || empty($senha)) {
            die("Preencha todos os campos! <a href='/cadastro.html'>Voltar</a>");
        }
        
        if (strlen($senha) < 6) {
            die("A senha deve ter no mínimo 6 caracteres! <a href='/cadastro.html'>Voltar</a>");
        }
        
        $resultado = $this->model->cadastrar($nome, $email, $senha);
        
        if ($resultado['success']) {
            header("Location: /Login.html");
            exit;
        } else {
            die($resultado['message'] . " <a href='/cadastro.html'>Voltar</a>");
        }
    }
    
    public function logout() {
        session_destroy();
        header("Location: /Login.html");
        exit;
    }
}
?>
<!-- 
class UserController {

    public function login() {
        $model = new UserModel();
        $user = $model->login($_POST['email'], $_POST['senha']);

        if ($user) {
            $_SESSION['user'] = $user;

            if ($user['tipo'] == 'admin') {
                header("Location: /adm.html");
            } else {
                header("Location: /pág.inicial.html");
            }

        } else { 
            echo "Email ou senha incorretos.";
        }
    }

    public function cadastro() {
        $model = new UserModel();
        $model->cadastrar($_POST['nome'], $_POST['email'], $_POST['senha']);
        header("Location: /Login.html");
    }
}
?> -->