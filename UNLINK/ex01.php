<?php

$file = fopen("teste.txt","w+");

fwrite($file, "esse arquivo agora tem conteud -".date("d/m/Y H:i:s"));
fclose($file);


unlink("teste.txt");// não usado o $flie pq o que será excluído é o arquivo e não a minha variável

echo "arquivo removido";

