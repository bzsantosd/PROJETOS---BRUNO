<?php

namespace TESTE;
use PDO;

require_once __DIR__ . "\\Model\\produto.php"; 


class Produto {

    private $produto;

    public function __construct() {
        $this->produto = new produto(); 
    }

    public function ler() {
        return $this->produto->ler();
    }

    public function atualizar($nome, $valor, $qtde, $estoque, $id) {
        $this->produto->atualizar($nome, $valor, $qtde, $estoque, $id);
    }

    // Método para DELETAR
    public function deletar($nome) {
        $this->produto->deletar($nome); 
    }
        public function editar($nome, $valor, $qtde, $estoque, $id) {
        $this->produto->editar($nome, $valor, $qtde, $estoque, $id);    
    }

    public function buscar($nome) {
        return $this->produto->buscar($nome); 
    }
}