<?php

echo "Date ".date("d/m/Y H:i:s");

echo "<hr>";

echo "Timestamp: ".time();

echo "<hr>";

echo "Strtotime: ".strtotime("1994/12/31")." => Data convertida para timestamp";

echo "<hr>";

echo "Date com timestamp: ".date("D/M/Y",788828400);

echo "<hr>";

$tempo = strtotime("+1 day");

echo date("d/m/y",$tempo);