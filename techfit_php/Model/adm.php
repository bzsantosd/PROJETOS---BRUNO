<?php
namespace techfit_php;


class admin { //atributos
    private $nome; 
    private $cargo;
    private $email;
    private $senha;

    public function __construct($nome, $cargo, $email, $senha) { //metodo construtor
        $this->nome = $nome;
        $this->cargo = $cargo;
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
    public function getcargo()
    {
        return $this->cargo;
    }
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

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