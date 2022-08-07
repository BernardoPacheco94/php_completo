<?php

interface Veiculo
{
    public function acelerar($velocidade);
    public function freiar($velocidade);
    public function trocarMarcha($marcha);
}

class DelRey extends Automovel
{
    public function empurrar()
    {
        echo 'Foi empurrado';
    }
}