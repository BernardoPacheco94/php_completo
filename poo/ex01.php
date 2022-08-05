<?php

class Carro
{
    private $modelo;
    private $motor;
    private $ano;


    public function getModelo()//getter
    {
        return $this->modelo;
    }
    
    public function getMotor():float
    {
        return $this->motor;
    }
    
    public function getAno():int
    {
        return $this->ano;
    }

    public function setModelo($modelo) //setter
    {
        $this->modelo = $modelo;
    }    

    public function setMotor($motor)
    {
        $this->motor = $motor;
    }

    public function setAno($ano)
    {
        $this->ano = $ano;
    }


    public function exibir()
    {
        return array(
            "modelo"=>$this->getModelo(),
            "motor"=>$this->getMotor(),
            "ano"=>$this->getAno()
        );
    }
}

$camaro = new Carro;
$camaro->setModelo('Camaro');
$camaro->setAno(2017);
$camaro->setMotor(4.8);

var_dump($camaro->exibir());
