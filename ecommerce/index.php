<?php

session_start();
require_once("vendor/autoload.php");

use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function () {

	$page = new Page();

	$page->setTpl("index");
});


//rota pagina admin
$app->get("/admin", function () {

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("index");
});


//Rota fazer login
$app->get("/admin/login", function () {
	$page = new PageAdmin(
		[
			"header" => false,
			"footer" => false
		]
	); //desalbilita o construtor(header) e destrutor (footer)

	$page->setTpl("login");
});


//rota para pagina de admin
$app->post("/admin/login", function () {
	User::login($_POST["login"], $_POST["password"]);

	header('Location: /admin');
	exit;
});


// rota para logut
$app->get("/admin/logout", function () {
	User::logout();

	header('Location: /admin/login');
	exit;
});


//rota lista de usuarios
$app->get("/admin/users", function () //lista users
{
	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdmin();
	$page->setTpl("users", array(
		"users" => $users
	));
});

// rota cria usuarios
$app->get("/admin/users/create", function () {
	User::verifyLogin();

	$page = new PageAdmin();
	$page->setTpl("users-create");
});


//rota deleta usuarios ** antes de listar por causa da ordem da url
$app->get("/admin/users/:iduser/delete", function ($iduser) {
	User::verifyLogin();

	$user = new User;

	$user->get((int)$iduser);
	$user->delete();

	header('Location: /admin/users');
	exit;
});


//rota carrega usuario para update
$app->get("/admin/users/:iduser", function ($iduser) {
	User::verifyLogin();

	$user = new User;
	$user->get((int)$iduser);

	$page = new PageAdmin();
	$page->setTpl("users-update", array(
		"user" => $user->getData()
	));
});


//rota cria usuario
$app->post("/admin/users/create", function () {
	User::verifyLogin();

	$user = new User;

	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

	$user->setData($_POST);

	$user->save();

	var_dump($user);

	header('Location: /admin/users');
	exit;
});


// rota edita usuario
$app->post("/admin/users/:iduser", function ($iduser) {
	User::verifyLogin();

	$user = new User;

	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

	$user->get((int)$iduser);
	$user->setData($_POST);
	$user->update();

	header("Location: /admin/users");
	exit;
});

// rota para email-recuperar senha
$app->get("/admin/forgot", function () {
	$page = new PageAdmin(
		[
			"header" => false,
			"footer" => false
		]
	);

	$page->setTpl("forgot");
});

// Rota para envio do email para recuperar senha
$app->post("/admin/forgot", function(){
	$user = User::getForgot($_POST["email"]);

	header('Location: /admin/forgot/sent');
	exit;
});

$app->get("/admin/forgot/sent", function(){
	$page = new PageAdmin(
		[
			"header" => false,
			"footer" => false
		]
	);

	$page->setTpl("forgot-sent");
});


$app->run();
