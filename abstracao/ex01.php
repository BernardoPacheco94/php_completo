<?php

interface Veiculo
{
    public function acelerar($velocidade);
    public function freiar($velocidade);
    public function trocarMarcha($marcha);
}


abstract class Automovel implements Veiculo
{
    public function acelerar($velocidade)
    {
        echo 'Acelerou ' . $velocidade . ' km/h <br>';
    }

    public function freiar($velocidade)
    {
        echo "O veículo que estava a $velocidade km/h, freiou <br>";
    }

    public function trocarMarcha($marcha)
    {
        echo "O veiculo está rodando na $marcha ª marcha";
    }
}

class DelRey extends Automovel
{
    public function empurrar()
    {
        echo 'Foi empurrado';
    }
}

$carro = new DelRey;

$carro->acelerar(150);
$carro->empurrar();
