<?php

require_once("config.php");

// session_unset($_SESSION); - > encerra a sessao
// session_destroy() - > Limpa completamente a sessao

echo $_SESSION["nome"];//utiliza a info na sessao, criado no exemplo 01

