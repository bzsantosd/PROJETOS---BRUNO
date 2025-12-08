<?php

namespace TESTE;
use PDO;

require_once __DIR__ . "\\Model\\adm.php"; 


class Adm{

    // Renomeamos a variável para refletir a nova classe do Model
    private $adm;

    public function __construct() {
        $this->adm = new adm(); 
    }

    public function ler() {
        return $this->adm->ler();
    }

    // Método para ATUALIZAR (dados de um administrador)
    public function atualizar($nome, $cargo, $email, $senha) {
        $this->adm->atualizar($nome, $cargo, $email, $senha);
    }

    // Método para DELETAR
    public function deletar($nome) {
        $this->adm->deletar($nome); 
    }
    
    // Método para EDITAR (se tiver função diferente de atualizar)
    public function editar($nome, $cargo, $email, $senha) {
        $this->adm->editar($nome, $cargo, $email, $senha);    
    }

    // Método para BUSCAR por um critério específico
    public function buscar($nome) {
        return $this->adm->buscar($nome); 
    }
}