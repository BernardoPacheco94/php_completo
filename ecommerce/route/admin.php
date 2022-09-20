<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;

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
