<?php
require_once "config.php";
session_start();

$data = $_SESSION['Usuario'];
$idUsuario = $data['idusuario'];


if(isset($_POST['btn_salvar']))
{
    $titulo = $_POST['input_titulo'];
    $conteudo = $_POST['textarea_modal'];

    $anotacao = new  Anotacao;

    $anotacao->novaAnotacao($titulo, $conteudo);

    header("Location: ..".DIRECTORY_SEPARATOR."index.php");

}