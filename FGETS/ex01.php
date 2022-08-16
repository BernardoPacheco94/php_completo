<?php

$filename = "usuarios.csv";

if (file_exists($filename)) {
    $file = fopen($filename, "r");

    $headers = explode(",", fgets($file));

    $data = array();

    while ($row = fgets($file)) {
        $rowData = explode(",", $row);//separa cada valor
        $linha = array();//cria o array vazio da linha

        for ($i = 0; $i < count($headers); $i++) {//percorre as colunas
            $linha[$headers[$i]] = $rowData[$i];//inclui o valor de cada posição no array linha
        }

        array_push($data, $linha);//coloca o array linha no array geral
    }

    fclose($file);

    echo json_encode($data);
}
