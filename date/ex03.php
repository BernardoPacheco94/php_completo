<?php

date_default_timezone_set('America/Sao_Paulo');

$dt = new DateTime();
$periodo = new DateInterval("P28D");

echo $dt->format("d/m/Y H:i:s");

echo "<hr>";

$dt->add($periodo);
echo "Adicionado 28 dias => ".$dt->format("d/m/Y H:i:s");