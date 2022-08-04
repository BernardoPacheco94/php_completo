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

echo json_encode($pessoas);