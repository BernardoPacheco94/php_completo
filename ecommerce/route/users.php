<?php
use \Hcode\Model\User;
use \Hcode\PageAdmin;

//rota lista de usuarios
$app->get("/admin/users", function () //lista users
{
	User::verifyLogin();

	$search = (isset($_GET['search'])) ? $_GET['search'] : '';
	$page = (isset($_GET['page'])) ? $_GET['page'] : 1;

	if($search != '')
	{
		$pagination = User::getPageSearch($search, $page);

	} else{
		$pagination = User::getPage($page);
	}
	

	$pages = [];

	for ($i=1; $i <= $pagination['pages'] ; $i++) 
	{
		array_push($pages, [
			'href' =>'/admin/users?'.http_build_query([
				'page'=>$i,
				'search'=>$search
			]),
			'text' => $i
		]);
	}

	$pageAdmin = new PageAdmin();
	$pageAdmin->setTpl("users", array(
		"users" => $pagination['data'],
		"search" => $search,
		"pages" => $pages		
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
