<?php

namespace techfit_php;

use techfit_php\produto;
use techfit_php\produtoDAO;

require_once __DIR__. "\\..\\Model\\produtoDAO.php";
require_once __DIR__. "\\..\\Model\\produto.php";


class produtoController {
    private $dao;

    public function __construct() {
        $this->dao = new produtoDAO();
    }

    //lista todas as bebidas 
    public function ler() {
        return $this->dao->lerProdutos();

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