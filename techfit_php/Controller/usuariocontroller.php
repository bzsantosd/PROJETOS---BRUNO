<?php

namespace TESTE;
use PDO;

require_once __DIR__ . "\\Model\\treino.php"; 


class usuario {

    private $usuario;

    public function __construct() {
        $this->usuario = new usuario(); 
    }

    public function ler() {
        return $this->usuario->ler();
    }

    public function atualizar($nome, $cpf, $email, $senha, $plano) {
        $this->usuario->atualizar($nome, $cpf, $email, $senha, $plano);
    }

    // Método para DELETAR
    public function deletar($nome) {
        $this->usuario->deletar($nome); 
    }
        public function editar($nome, $cpf, $email, $senha, $plano) {
        $this->usuario->editar($nome, $cpf, $email, $senha, $plano);    
    }

    public function buscar($nome) {
        return $this->usuario->buscar($nome); 
    }
}