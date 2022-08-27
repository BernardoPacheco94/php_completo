<?php

$cep = '97050700';
$link = "https://viacep.com.br/ws/$cep/json/";

$ch = curl_init($link);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//Params: 1-lib 2-opção do que fazer com curl 3 true or false
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);// aceita https


$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

print_r($data['logradouro']);

