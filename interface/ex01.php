<?php

interface Veiculo
{
    public function acelerar($velocidade);
    public function freiar($velocidade);
    public function trocarMarcha($marcha);
}


class Civic implements Veiculo
{
    public function acelerar($velocidade)
    {
        echo 'Acelerou '.$velocidade.' km/h <br>';
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

$carro = new Civic;
$carro->acelerar(20);
$carro->freiar(50);
$carro->trocarMarcha(5);