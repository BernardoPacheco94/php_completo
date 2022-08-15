<?php

$file = fopen("log.txt","a+");//fopen informa/cria o arquivo com o endereço a partir do horário atual

fwrite($file, date("d/m/y H:i:s \r\n"));

fclose($file);

echo 'Arquivo criado';