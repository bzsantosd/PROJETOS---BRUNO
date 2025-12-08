<?php
namespace techfit_php;


class produto { //atributos
    private $nome;
    private $valor;
    private $qtde;
    private $estoque;
    private $id;

    public function __construct($nome, $valor, $qtde, $estoque, $id) { //metodo construtor
        $this->nome = $nome;
        $this->valor = $valor;
        $this->qtde = $qtde;
        $this->estoque = $estoque;
        $this->id = $id;
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
    public function getValor()
    {
        return $this->valor;
    }
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }
    public function getQtde()
    {
        return $this->qtde;
    }
    public function setQtde($qtde)
    {
        $this->qtde = $qtde;

        return $this;
    }
    public function getEstoque()
    {
        return $this->estoque;
    }
    public function setEstoque($estoque)
    {
        $this->estoque = $estoque;

        return $this;
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
}