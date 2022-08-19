<?php
require_once "config.php";
session_start();

$data = $_SESSION['Usuario'];
$idUsuario = $data['idusuario'];


if(isset($_POST['btn_salvar']))
{
    $titulo = $_POST['input_titulo'];
    $conteudo = $_POST['textarea_modal'];
    $id = $_POST['input_id'];

    $anotacao = new  Anotacao;

    $anotacao->updateAnotacao($titulo, $conteudo, $id);

    header('Location: index.php');
    
}

if(isset($_POST['btn_excluir']))
{
    $id = $_POST['input_id'];
    
    $delecao = new Anotacao;
    $delecao->deleteAnotacao($id);
    header('Location: index.php');
}
