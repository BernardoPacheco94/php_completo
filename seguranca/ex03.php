<?php

$pasta = "arquivos";
$permissao = "0755";

if (!is_dir($pasta)) mkdir($pasta, $permissao);
echo 'Diretório criado';

