<?php

function soma(int ...$valores):string{//o :string informa o tipo de retorno
    return array_sum($valores);
}

echo var_dump(soma(30, 2.65, 64));