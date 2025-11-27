<?php

namespace techfit_php;

use techfit_php\Administrador;
use techfit_php\administradorDAO;

require_once __DIR__. "\\..\\Model\\administradorDAO.php";
require_once __DIR__. "\\..\\Model\\administrador.php";


class administradorController {
    private $dao;

    public function __construct() {
        $this->dao = new administradorDAO();
    }

    //lista todas as bebidas 
    public function ler() {
        return $this->dao->lerAdministradores();

    }

    //cadastra nova bebida

    public function criar($nome,$setor,$email,$senha) {
        $id = time();
        $administrador = new Administrador( $nome, $setor, $email, $senha);
        $this->dao->criaradministradores($administrador);

    }

    // atualiza bebida existente

    public function atualizar($email, $senha, $ativo) {
        $this->dao->atualizarAdministradores($email, $senha, $ativo);
    }

    public function deletar($nome) {
            $this->dao->excluirAdministrador($nome);
        
        }
    
    public function editar($email, $senha, $ativo, $nome) {
        $this->dao->editarAdministrador($email, $senha, $ativo, $nome);    
    }
    public function buscar($email) {
        return $this->dao->buscarporemail($email);
    }
}

?>