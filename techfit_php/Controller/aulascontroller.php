<?php

namespace TESTE;
use PDO;

require_once __DIR__ . "\\Model\\aulas.php"; 


class aulas {

    // Renomeamos a variável para refletir a nova classe do Model
    private $Aulas;

    public function __construct() {
        $this->Aulas = new Aulas(); 
    }

    public function ler() {
        return $this->Aulas->ler();
    }

    // Método para ATUALIZAR (dados de um administrador)
    public function atualizar($nome, $horario, $professor) {
        $this->Aulas->atualizar($nome, $horario, $professor);
    }

    // Método para DELETAR
    public function deletar($nome) {
        $this->Aulas->deletar($nome); 
    }
    
    // Método para EDITAR (se tiver função diferente de atualizar)
    public function editar($nome, $horario, $professor) {
        $this->Aulas->editar($nome, $horario, $professor);    
    }

    // Método para BUSCAR por um critério específico
    public function buscar($nome) {
        return $this->Aulas->buscar($nome); 
    }
}