<?php
namespace techfit_php;


class plano { //atributos
    private $plano;
    private $valor;
    private $beneficios;
    private $pagamento;

    public function __construct($plano, $valor, $beneficios, $pagamento) { //metodo construtor
        $this->plano = $plano;
        $this->valor = $valor;
        $this->beneficios = $beneficios;
        $this->pagamento = $pagamento;
    }
    public function getPlano() //getters e setters
    {
        return $this->plano;
    }
    public function setPlano($plano)
    {
        $this->plano = $plano;
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
    public function getBeneficios()
    {
        return $this->beneficios;
    }
    public function setBeneficios($beneficios)
    {
        $this->beneficios = $beneficios;
        return $this;
    }
 
    public function getPagamento()          
    {
        return $this->pagamento;
    }
    public function setPagamento($pagamento)
    {
        $this->pagamento = $pagamento;
        return $this;
    }
}