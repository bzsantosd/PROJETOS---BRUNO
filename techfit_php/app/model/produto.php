<?php
namespace techfit_php;

class Produto { //atributos
    private $idProduto; 
    private $nome;
    private $descrição;
    private $preco;
    private $quantidadeestoque;

    public function __construct($idProduto, $nome, $descrição, $preco, $quantidadeestoque) { //metodo construtor
        $this->idProduto = $idProduto;
        $this->nome = $nome;
        $this->descrição = $descrição;
        $this->preco = $preco;
        $this->quantidadeestoque = $quantidadeestoque;
    }
    public function getIdProduto() //getters e setters
    {
        return $this->idProduto;
    }
    public function setIdProduto($idProduto)
    {
        $this->idProduto = $idProduto;

        return $this;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }
    public function getDescrição()
    {
        return $this->descrição;
    }
    public function setDescrição($descrição)
    {
        $this->descrição = $descrição;

        return $this;
    }

    public function getPreco()
    {
        return $this->preco;
    }
 
    public function setPreco($preco)
    {
        $this->preco = $preco;

        return $this;
    }
 
    public function getQuantidadeestoque()
    {
        return $this->quantidadeestoque;
    }
 
    public function setQuantidadeestoque($quantidadeestoque)
    {
        $this->quantidadeestoque = $quantidadeestoque;

        return $this;
    }
    
    
}