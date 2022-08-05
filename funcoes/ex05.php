<?php

$a = 10;

function trocaValor(&$b){//o & permite alterar o valor da variável que será passada
    return $b+=50;
}

echo trocaValor($a);
echo "<hr>";
echo ($a);//somente altera o valor dentro da função
echo "<hr>";
echo trocaValor($a);
echo "<hr>";
echo trocaValor($a);