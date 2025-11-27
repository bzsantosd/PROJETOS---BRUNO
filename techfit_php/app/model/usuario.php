<?php
namespace techfit_php;

class usuario { //atributos
    private $idusuario; 
    private $nome;
    private $email;
    private $senha;
    private $datacadastro;
    private $ativo;

    public function __construct($idusuario, $nome, $email, $senha, $datacadastro, $ativo) { //metodo construtor
        $this->idusuario = $idusuario;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->datacadastro = $datacadastro;
        $this->ativo = $ativo;
    }
    public function getIdusuario() //getters e setters
    {
        return $this->idusuario;
    }
    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;

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
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getSenha()
    {
        return $this->senha;
    }
 
    public function setSenha($senha)
    {
        $this->senha = $senha;

        return $this;
    }
 
    public function getDatacadastro()
    {
        return $this->datacadastro;
    }
 
    public function setDatacadastro($datacadastro)
    {
        $this->datacadastro = $datacadastro;

        return $this;
    }
    public function getAtivo()
    {
        return $this->ativo;
    }
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;

        return $this;
    }
    
}