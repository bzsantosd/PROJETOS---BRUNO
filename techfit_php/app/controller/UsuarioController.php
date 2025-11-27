<?php

namespace techfit_php;

require_once __DIR__. "\\..\\Model\\usuarioDAO.php";
require_once __DIR__. "\\..\\Model\\usuario.php";

class UsuarioController {
    private $dao;

    public function __construct() {
        $this->dao = new UsuarioDAO();
    }

    //lista todas as bebidas 
    public function ler() {
        return $this->dao->lerUsuarios();

    }

    //cadastra nova bebida

    public function criar($idusuario, $nome, $email, $senha, $datacadastro, $ativo) {
        $id = time();
        $usuario = new Usuario($idusuario, $nome, $email, $senha, $datacadastro, $ativo);
        $this->dao->criarUsuarios($usuario);

    }

    // atualiza bebida existente

    public function atualizar($email, $senha, $ativo) {
        $this->dao->atualizarUsuarios($email, $senha, $ativo);
    }

    public function deletar($nome) {
            $this->dao->excluirUsuario($nome);
        
        }
    
    public function editar($email, $senha, $ativo, $nome) {
        $this->dao->editarUsuario($email, $senha, $ativo, $nome);    
    }
    public function buscar($nome) {
        return $this->dao->buscarporemail($nome);
    }
}

?>