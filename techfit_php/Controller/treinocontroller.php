<?php

namespace TESTE;
use PDO;

require_once __DIR__ . "\\Model\\treino.php"; 


class treino {

    private $treino;

    public function __construct() {
        $this->treino = new treino(); 
    }

    public function ler() {
        return $this->treino->ler();
    }

    public function atualizar($id, $nome, $horario, $data, $repeticoes) {
        $this->treino->atualizar($id, $nome, $horario, $data, $repeticoes);
    }

    // Método para DELETAR
    public function deletar($nome) {
        $this->treino->deletar($nome); 
    }
        public function editar($id, $nome, $horario, $data, $repeticoes) {
        $this->treino->editar($id, $nome, $horario, $data, $repeticoes);    
    }

    public function buscar($nome) {
        return $this->treino->buscar($nome); 
    }
}