<?php



require_once("config.php");

session_regenerate_id();//gera um novo id de sessao.

echo session_id();

