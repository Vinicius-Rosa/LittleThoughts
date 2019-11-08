<?php

class User
{
    private $nome;
    private $idade;
    private $peso;
    private $altura;

    public function setUser(string $nome, int $idade, float $peso, float $altura)
    {
        $this->nome = $nome;
        $this->idade = $idade;
        $this->peso = $peso;
        $this->altura = $altura;
    }

    public function getUser(){
        return "{$this->nome} tem {$this->idade} anos";
    }

    private function calcImc(){
        return $this->peso / pow($this->altura,2);
    }

    public function setIdade($idade){
        $this->idade = $idade;
    }

    public function setPeso($peso){
        $this->peso = $peso;
    }

    public function getImc(){
        return $this->calcImc();
    }

}