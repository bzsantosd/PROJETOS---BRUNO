<?php
namespace techfit_php;


class Aulas { //atributos
    private $nome;
    private $horario;
    private $professor;

    public function __construct($nome, $horario, $professor) { //metodo construtor
        $this->nome = $nome;
        $this->horario = $horario;
        $this->professor = $professor;
    }
    public function getNome() //getters e setters
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }
    public function getHorario()
    {
        return $this->horario;
    }
    public function setHorario($horario)
    {
        $this->horario = $horario;

        return $this;
    }
    public function getProfessor()
    {
        return $this->professor;
    }
    public function setProfessor($professor)
    {
        $this->professor = $professor;

        return $this;
    }
 
}