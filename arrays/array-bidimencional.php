<?php

$pessoas = array();

array_push(
    $pessoas,
    array(
        'nome' => 'Gabriel',
        'parentesco' => 'Filho',
        'idade' => 0
    ),
    array(
        'nome' => 'Bernardo',
        'parentesco' => 'Pai',
        'idade' => 27
    )
);

print_r($pessoas);
echo "<br>";
print_r($pessoas[0]);