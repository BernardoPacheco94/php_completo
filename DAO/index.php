<?php

require_once "config.php";
/*--CARREGA USUARIOS E MOSTRA NA TELA--*/
$user = new Usuario;
//$user->findById(4);
//echo $user;//apneas o echo, pois há o construtor toString na classe Usuario


/*--LISTA OS USUARIOS-- */
// $list = Usuario::getList();
// echo json_encode($list);

/*-LISTA USUARIOS POR UM PEDAÇO DE PALAVRA-CHAVE-- */
// $search = Usuario::search("be");
// echo json_encode($search);

/*--VALIDA USUÁRIO USUÁRIO--*/
// $user->login("gabriel","papai123");


/*--2 MANEIRAS DE FAZER INSERT-- */
//$user = Usuario::insert("aabrao","12345");//insert sem procedure
//$list = Usuario::getList();
// $user = new Usuario("jubileu", "bora");
// $user->insert();
// echo $user;

/*--UPDATE DE USUARIO--*/
$user->findById(6);//carrega o usuário pelo id
$user->update("mufasa","scar");

$lista = Usuario::getList();
echo json_encode($lista);