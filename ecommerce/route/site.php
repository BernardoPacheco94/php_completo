
<?php

use Hcode\Model\Cart;
use \Hcode\Model\Category;
use \Hcode\Model\Product;
use \Hcode\Page;
use \Hcode\Model\Address;
use \Hcode\Model\User;

$app->get('/', function () {

	$products = Product::listAll();


	$page = new Page();

	$page->setTpl("index", [
		'products' => Product::checkList($products)
	]);
});

//Rota para visualizar categoria limitando produtos por pagina
$app->get("/categories/:idcategoria", function ($idcategory) {
	$category = new Category();

	$category->get((int)$idcategory);

	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	$pagination = $category->getProductsPage($page);

	$pages = [];

	for ($i = 1; $i <= $pagination['pages']; $i++) {
		array_push($pages, [
			'link' => '/categories/' . $idcategory . '?page=' . $i,
			'page' => $i
		]);
	}

	$page = new Page;

	$page->setTpl("category", [
		'category' => $category->getData(),
		'products' => $pagination['data'],
		'pages' => $pages
	]);
});

// Rota para detalhes de um produto
$app->get("/products/:desurl", function ($desurl) {
	$product = new Product;

	$product->getFromURL($desurl);

	$page = new Page();

	$page->setTpl("product-detail", [
		'product' => $product->getData(),
		'categories' => $product->getCategories()
	]);
});

// Rota para visualizar o carrinho de compras
$app->get('/cart', function () {

	$cart = Cart::getFromSession();

	$cart->checkProductsQty();

	$page = new Page();

	$page->setTpl('cart', [
		'cart' => $cart->getData(),
		'products' => $cart->getProducts(),
		'totals' => $cart->getProductsTotals(),
		'error' => Cart::getMsgError()
	]);
});

$app->get('/cart/:idproduct/add', function ($idproduct) {

	$product = new Product;

	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();


	$qtd = isset($_GET['qtd']) ? (int)$_GET['qtd'] : 1;

	for ($i = 0; $i < $qtd; $i++) {
		$cart->addProduct($product);
	}


	header('Location: /cart');
	exit;
});

$app->get('/cart/:idproduct/minus', function ($idproduct) {
	$product = new Product;

	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();

	$cart->removeProduct($product);

	header('Location: /cart');
	exit;
});

$app->get('/cart/:idproduct/removeall', function ($idproduct) {
	$product = new Product;

	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();

	$cart->removeProduct($product, true);

	header('Location: /cart');
	exit;
});

$app->post('/cart/freight', function () {
	$cart = Cart::getFromSession();

	$cart->setFreight($_POST['zipcode']);

	header('Location: /cart');
	exit;
});

$app->get('/checkout', function () {
	
	User::verifyLogin(false);

	$cart = Cart::getFromSession();

	$address = new Address();

	$page = new Page();

	$page->setTpl("checkout", [
		'cart' => $cart->getData(),
		// 'address'=>$address->getData()
	]);
});

$app->get('/login', function () {

	$page = new Page();

	$page->setTpl("login", [
		'error' => User::getError(),
		'errorRegister' => User::getErrorRegister(),
		'registerValues'=> (isset($_SESSION['registerValues'])) ? $_SESSION['registerValues'] : [
			'name'=>'',
			'email'=>'',
			'phone'=>''
			]
	]);
});

$app->post('/login', function () {

	try {
		User::login($_POST['login'], $_POST['password']);
	} catch (Exception $e) {
		User::setError($e->getMessage());
	}
	header('Location: /checkout');
	exit;
});

$app->get('/logout', function () {
	User::logout();

	header('Location: /login');
	exit;
});

$app->post('/register', function () {

	$_SESSION['registerValues'] = $_POST;
	
	if(!isset($_POST['name']) || $_POST['name'] == '')
	{
		User::setErrorRegister('Preencha o nome.');
		header('Location: /login');
		exit;
	}

	if(!isset($_POST['email']) || $_POST['email'] == '')
	{
		User::setErrorRegister('Preencha o email.');
		header('Location: /login');
		exit;
	}

	if(!isset($_POST['password']) || $_POST['password'] == '')
	{
		User::setErrorRegister('Preencha a senha.');
		header('Location: /login');
		exit;
	}

	if(User::checkLoginExist($_POST['email']))
	{
		User::setErrorRegister('Email já cadastrado.');
		header('Location: /login');
		exit;
	}
	
	$user = new User;

	$user->setData([
		'inadmin' => 0,
		'desperson' => $_POST['name'],
		'deslogin' => $_POST['email'],
		'desemail' => $_POST['email'],
		'nrphone' => $_POST['phone'],
		'despassword' => $_POST['password']
	]);

	$user->save();

	User::login($_POST['email'], $_POST['password']);

	header('Location: /checkout');
	exit;
});


// rota para email-recuperar senha
$app->get("/forgot", function () {
	$page = new Page();

	$page->setTpl("forgot");
});

// Rota para envio do email para recuperar senha
$app->post("/forgot", function () {
	$user = User::getForgot($_POST["email"], false);

	header('Location: /forgot/sent');
	exit;
});

//Rota email de reset de senha enviado
$app->get("/forgot/sent", function () {
	$page = new Page();

	$page->setTpl("forgot-sent");
});


//Rota de reset de senha
$app->get("/forgot/reset", function () {
	$user = User::validForgotDecrypt($_GET["code"]);

	$page = new Page();

	$page->setTpl("forgot-reset", array(
		"name" => $user["desperson"],
		"code" => $_GET["code"]
	));
});


//rota de captura da senha para reset
$app->post("/forgot/reset", function () {
	$forgot = User::validForgotDecrypt($_POST["code"]);
	User::setForgotUser($forgot["idrecovery"]);


	$user = new User;

	$user->get((int)$forgot["iduser"]);

	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [
		"cost" => 10
	]);

	$user->setPassWord($password);


	$page = new Page();

	$page->setTpl("forgot-reset-success");
});


?>