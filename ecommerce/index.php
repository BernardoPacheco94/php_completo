<?php

session_start();
require_once("vendor/autoload.php");

use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;

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
$app->post("/admin/forgot", function () {
	$user = User::getForgot($_POST["email"]);

	header('Location: /admin/forgot/sent');
	exit;
});

//Rota email de reset de senha enviado
$app->get("/admin/forgot/sent", function () {
	$page = new PageAdmin(
		[
			"header" => false,
			"footer" => false
		]
	);

	$page->setTpl("forgot-sent");
});


//Rota de reset de senha
$app->get("/admin/forgot/reset", function () {
	$user = User::validForgotDecrypt($_GET["code"]);

	$page = new PageAdmin(
		[
			"header" => false,
			"footer" => false
		]
	);

	$page->setTpl("forgot-reset", array(
		"name" => $user["desperson"],
		"code" => $_GET["code"]
	));
});


//rota de captura da senha para reset
$app->post("/admin/forgot/reset", function () {
	$forgot = User::validForgotDecrypt($_POST["code"]);
	User::setForgotUser($forgot["idrecovery"]);


	$user = new User;

	$user->get((int)$forgot["iduser"]);

	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [
		"cost" => 10
	]);

	$user->setPassWord($password);


	$page = new PageAdmin(
		[
			"header" => false,
			"footer" => false
		]
	);

	$page->setTpl("forgot-reset-success");
});

//rota para admin - categorias
$app -> get("/admin/categories", function(){
	
	$categories = Category::listAll();
	
	$page = new PageAdmin();

	$page->setTpl("categories", [
		'categories' => $categories
	]);
});


//rota para criar categoria
$app->get("/admin/categories/create", function(){
	$page = new PageAdmin();
	
	$page->setTpl("categories-create");
});

$app->post("/admin/categories/create", function(){
	$category = new Category;
	$category->setData($_POST);
	$category->save();

	header('Location: /admin/categories');
	exit;
});


//rota para deletar categoria
$app->get("/admin/categories/:idcategory/delete", function($idcategory){
	$category = new Category;
	
	$category->get((int)$idcategory);
	
	$category->delete();
	
	header('Location: /admin/categories');
	exit;
});

$app->run();
