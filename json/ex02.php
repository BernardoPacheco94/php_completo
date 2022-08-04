<?php

$json = '[
    {
        "nome":"Gabriel",
        "parentesco":"Filho",
        "idade":0
    },
    {
        "nome":"Bernardo",
        "parentesco":"Pai",
        "idade":27
    }
    ]';

$dados = json_decode($json, true);//o true impede que vire um objeto.

var_dump($dados);
echo "<hr>";
print_r($dados);
