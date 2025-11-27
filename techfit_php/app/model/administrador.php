<?php
namespace techfit_php;

class Administrador { //atributos
    private $nome; 
    private $setor;
    private $email;
    private $senha;

    public function __construct($nome, $setor, $email, $senha) { //metodo construtor
        $this->nome = $nome;
        $this->setor = $setor;
        $this->email = $email;
        $this->senha = $senha;
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
    public function getSetor()
    {
        return $this->setor;
    }
    public function setSetor($setor)
    {
        $this->setor = $setor;

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
 
}