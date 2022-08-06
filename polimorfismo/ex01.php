<?php

abstract class Animal
{
    public function falar ()
    {
        return "som";
    }

    public function andar ()
    {
        return "Anda";
    }
}

class Cachorro extends Animal
{
    public function falar()//mesmo método da classe falar
    {
        return "Late";
    }
}

$pluto = new Cachorro;

echo "Cachorro: <br>";
echo $pluto->falar()."<br>";
echo $pluto->andar();
echo "<hr>";

class Gato extends Animal
{
    public function falar()
    {
        return "Mia";
    }   
}
$simba = new Gato;
echo "Gato: <br>";
echo $simba->falar()."<br>";
echo $simba->andar();

class Passaro extends Animal
{
    public function falar()
    {
        return "Gorgojeia";
    }
    
    public function andar()
    {
        return "Voa e ".parent::andar();
    }
}

echo "<hr>";

$pipiu = new Passaro;

echo "Pássaro: <br>";
echo $pipiu->falar()."<br>";
echo $pipiu->andar();
