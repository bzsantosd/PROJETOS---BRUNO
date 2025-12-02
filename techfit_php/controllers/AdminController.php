<?php
require_once __DIR__ . '/../models/UserModel.php';

class AdminController {
    private $model;
    
    public function __construct() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        $this->model = new UserModel();
    }
    
    public function listarUsuarios() {
        $usuarios = $this->model->buscarTodos();
        include __DIR__ . '/../views/admin/listaUsuarios.php';
    }
    
    public function editarUsuarioForm($id) {
        $usuario = $this->model->buscarPorId($id);
        
        if (!$usuario) {
            die("Usuário não encontrado!");
        }
        
        include __DIR__ . '/../views/admin/editarUsuario.php';
    }
    
    public function editarUsuarioSalvar() {
        $id = $_POST['id'] ?? 0;
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $tipo = $_POST['tipo'] ?? 'cliente';
        $senha = $_POST['senha'] ?? '';
        
        if (empty($nome) || empty($email)) {
            die("Nome e email são obrigatórios! <a href='/admin/usuarios/editar?id=$id'>Voltar</a>");
        }
        
        // Atualiza com ou sem senha
        if ($this->model->editar($id, $nome, $email, $tipo, $senha)) {
            header("Location: /admin/usuarios?msg=editado");
        } else {
            die("Erro ao editar usuário!");
        }
        exit;
    }
    
    public function deletarUsuario($id) {
        // Impede que o admin delete a si mesmo
        if ($id == $_SESSION['user']['id']) {
            die("Você não pode deletar sua própria conta! <a href='/admin/usuarios'>Voltar</a>");
        }
        
        if ($this->model->deletar($id)) {
            header("Location: /admin/usuarios?msg=deletado");
        } else {
            die("Erro ao deletar usuário!");
        }
        exit;
    }
}
?>
