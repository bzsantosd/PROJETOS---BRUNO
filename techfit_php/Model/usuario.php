<?php
namespace techfit_php;

class usuario { //atributos
    private $nome;
    private $cpf;
    private $email;
    private $senha;
    private $plano;

    public function __construct($nome, $cpf, $email, $senha, $plano) { //metodo construtor
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->senha = $senha;
        $this->plano = $plano;
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
    public function getCpf()
    {
        return $this->cpf;
    }
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;

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
    public function getPlano()
    {
        return $this->plano;
    }
    public function setPlano($plano)
    {
        $this->plano = $plano;

        return $this;
    }
}