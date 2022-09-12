<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;

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
