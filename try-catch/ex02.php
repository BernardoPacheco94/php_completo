<?php

function trataNome ($name)
{
    if(!$name)
    {
        throw new Exception("Nome não informado", 1);
        
    }

    echo ucfirst($name);
    echo "<br>";
}

try {
    trataNome('Joao');
    trataNome('');
} catch (Exception $e) {
    echo $e->getMessage();
} finally {
    echo "executou o bloco try";
}