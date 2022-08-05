<?php

setlocale(LC_ALL, "pt_BR", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('America/Sao_Paulo');

$hora = date("H: i", time());


echo ucwords( strftime("%A: %d/%B/%y ".$hora));