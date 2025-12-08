<?php

namespace TESTE;
use PDO;

require_once __DIR__ . "\\Model\\plano.php"; 


class plano {

    private $plano;

    public function __construct() {
        $this->plano = new plano(); 
    }

    public function ler() {
        return $this->plano->ler();
    }

    public function atualizar($nome, $horario, $professor) {
        $this->plano->atualizar($nome, $horario, $professor);
    }

    // Método para DELETAR
    public function deletar($nome) {
        $this->plano->deletar($nome); 
    }
    
    public function editar($nome, $horario, $professor) {
        $this->plano->editar($nome, $horario, $professor);    
    }

    public function buscar($nome) {
        return $this->plano->buscar($nome); 
    }
}