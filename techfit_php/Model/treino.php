<?php
namespace techfit_php;
use PDO;

class treino { //atributos
    private $id;
    private $nome;
    private $horario;
    private $data;
    private $repeticoes;

    public function __construct($id, $nome, $horario, $data, $repeticoes) { //metodo construtor
        $this->id = $id;
        $this->nome = $nome;
        $this->horario = $horario;
        $this->data = $data;
        $this->repeticoes = $repeticoes;
    }
    public function getId() 
    { 
        return $this->id;
    }   
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
    public function getData()
    {
        return $this->data;
    }
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
    public function getRepeticoes()
    {
        return $this->repeticoes;
    }
    public function setRepeticoes($repeticoes)
    {
        $this->repeticoes = $repeticoes;

        return $this;
    }
}