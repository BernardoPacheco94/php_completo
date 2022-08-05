<?php

require_once("config.php");

echo "session_save_path - Exibe o caminho de armazenamento da sessao: ".session_save_path();

echo "<hr>";

echo session_status();

echo "<hr>";

switch(session_status()){
    case PHP_SESSION_DISABLED:
        echo 'Sessão está desabilitada';
    break;

    case PHP_SESSION_NONE:
        echo 'Ainda não existem sessões';
    break;

    case PHP_SESSION_ACTIVE:
        echo 'Sessao iniciada';
    break;
}