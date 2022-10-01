
<?php

use Hcode\Model\Cart;
use \Hcode\Model\Category;
use \Hcode\Model\Product;
use \Hcode\Page;
use \Hcode\Model\Address;
use \Hcode\Model\User;
use Hcode\Model\Order;
use Hcode\Model\OrderStatus;

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

	$address = new Address();

	$cart = Cart::getFromSession();

	// if (isset($_GET['zipcode'])) {
	// 	$_GET['zipcode'] = $cart->getdeszipcode();
	// }

	if (isset($_GET['zipcode'])) {
		$address->loadFromCEP($_GET['zipcode']);
		$cart->setdeszipcode($_GET['zipcode']); //atualiza o cep caso seja alterado
		$cart->save();
		$cart->getCalculateTotal();
	}


	if (!$address->getdesaddress()) $address->setdesaddress('');
	if (!$address->getdescomplement()) $address->setdescomplement('');
	if (!$address->getdesdistrict()) $address->setdesdistrict('');
	if (!$address->getdescity()) $address->setdescity('');
	if (!$address->getdescountry()) $address->setdescountry('');
	if (!$address->getdeszipcode()) $address->setdeszipcode('');
	if (!$address->getdesstate()) $address->setdesstate('');


	$page = new Page();

	$page->setTpl("checkout", [
		'cart' => $cart->getData(),
		'address' => $address->getData(),
		'products' => $cart->getProducts(),
		'error' => Address::getMsgError()
	]);
});


$app->post("/checkout", function () {

	User::verifyLogin(false);

	if (!isset($_POST['zipcode']) || $_POST['zipcode'] === '') {
		Address::setMsgError('Informe o CEP');

		header('Location: /checkout');
		exit;
	}
	if (!isset($_POST['desaddress']) || $_POST['desaddress'] === '') {
		Address::setMsgError('Informe o endereço');

		header('Location: /checkout');
		exit;
	}
	if (!isset($_POST['desdistrict']) || $_POST['desdistrict'] === '') {
		Address::setMsgError('Informe o bairro');

		header('Location: /checkout');
		exit;
	}
	if (!isset($_POST['descity']) || $_POST['descity'] === '') {
		Address::setMsgError('Informe a cidade');

		header('Location: /checkout');
		exit;
	}

	$user = User::getFromSession();
	$address = new Address;

	$_POST['deszipcode'] = $_POST['zipcode'];
	$_POST['idperson'] = $user->getidperson();

	$address->setData($_POST);
	$address->save();

	$order = new Order;

	$cart = Cart::getFromSession();

	$totals = $cart->getProductsTotals();

	$order->setData([
		'idcart' => $cart->getidcart(),
		'idaddress' => $address->getidaddress(),
		'iduser' => $user->getiduser(),
		'idstatus' => OrderStatus::EM_ABERTO,
		'vltotal' => $totals['vlprice'] + $cart->getvlfreight()
	]);


	$order->save();
	header('Location: /order/' . $order->getidorder());
	exit;
});

$app->get('/login', function () {

	$page = new Page();

	$page->setTpl("login", [
		'error' => User::getError(),
		'errorRegister' => User::getErrorRegister(),
		'registerValues' => (isset($_SESSION['registerValues'])) ? $_SESSION['registerValues'] : [
			'name' => '',
			'email' => '',
			'phone' => ''
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

	if (!isset($_POST['name']) || $_POST['name'] == '') {
		User::setErrorRegister('Preencha o nome.');
		header('Location: /login');
		exit;
	}

	if (!isset($_POST['email']) || $_POST['email'] == '') {
		User::setErrorRegister('Preencha o email.');
		header('Location: /login');
		exit;
	}

	if (!isset($_POST['password']) || $_POST['password'] == '') {
		User::setErrorRegister('Preencha a senha.');
		header('Location: /login');
		exit;
	}

	if (User::checkLoginExist($_POST['email'])) {
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

$app->get("/profile", function () {

	User::verifyLogin(false);

	$user = User::getFromSession();
	$user->get($user->getiduser()); //joga os dados user+person no objeto

	$page = new Page();

	$page->setTpl("profile", [
		'user' => $user->getData(),
		'profileMsg' => User::getMsgSuccess(),
		'profileError' => User::getError()
	]);
});

$app->post("/profile", function () {
	User::verifyLogin(false);

	if (!isset($_POST['desperson']) || $_POST['desperson'] === '') {
		User::setError('Preencha o nome.');
		header('Location: /profile');
		exit;
	}

	if (!isset($_POST['desemail']) || $_POST['desemail'] === '') {
		User::setError('Preencha o email.');
		header('Location: /profile');
		exit;
	}

	$user = User::getFromSession();
	$user->get($user->getiduser());


	if ($_POST['desemail'] !== $user->getdesemail()) //email alterado
	{
		if (User::checkLoginExist($_POST['desemail']) === true) {
			User::setError('Email já cadastrado');
			header('Location: /profile');
			exit;
		}
	}

	$_POST['inadmin'] = $user->getinadmin();
	$_POST['despassword'] = $user->getdespassword(); //camadas de segurança, para que essas propriedades não sejam alteradas, venham do proprio objeto
	$_POST['deslogin'] = $_POST['desemail'];

	$user->setData($_POST);

	$user->update();

	User::setMsgSuccess('Cadastro alterado!');

	header('Location: /profile');
	exit;
});

$app->get("/order/:idorder", function ($idorder) {
	User::verifyLogin(false);

	$order = new Order;

	$order->get((int)$idorder);

	$page = new Page();

	$page->setTpl('payment', [
		'order' => $order->getData()
	]);
});

$app->get("/boleto/:idorder", function ($idorder) {

	User::verifyLogin(false);


	$order = new Order;

	$order->get((int)$idorder);

	// DADOS DO BOLETO PARA O SEU CLIENTE
	$dias_de_prazo_para_pagamento = 10;
	$taxa_boleto = 5.00;
	$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
	$valor_cobrado = $order->getvltotal(); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
	$valor_cobrado = str_replace(",", ".", $valor_cobrado);
	$valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

	$dadosboleto["nosso_numero"] = $order->getidorder();  // Nosso numero - REGRA: Máximo de 8 caracteres!
	$dadosboleto["numero_documento"] = $order->getidorder();	// Num do pedido ou nosso numero
	$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
	$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
	$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
	$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

	// DADOS DO SEU CLIENTE
	$dadosboleto["sacado"] = $order->getdesperson();
	$dadosboleto["endereco1"] = $order->getdesaddress().", ".$order->getdesdistrict();
	$dadosboleto["endereco2"] = $order->getdescity()." - ".$order->getdesstate()." CEP: ".mask("##.###-###",$order->getdeszipcode());

	// INFORMACOES PARA O CLIENTE
	$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja Hcode E-commerce";
	$dadosboleto["demonstrativo2"] = "Taxa bancária - R$ 5,00";
	$dadosboleto["demonstrativo3"] = "";
	$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
	$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
	$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: suporte@hcode.com.br";
	$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto Loja Hcode E-commerce - www.hcode.com.br";

	// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
	$dadosboleto["quantidade"] = "";
	$dadosboleto["valor_unitario"] = "";
	$dadosboleto["aceite"] = "";
	$dadosboleto["especie"] = "R$";
	$dadosboleto["especie_doc"] = "";


	// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


	// DADOS DA SUA CONTA - ITAÚ
	$dadosboleto["agencia"] = "1690"; // Num da agencia, sem digito
	$dadosboleto["conta"] = "48781";	// Num da conta, sem digito
	$dadosboleto["conta_dv"] = "2"; 	// Digito do Num da conta

	// DADOS PERSONALIZADOS - ITAÚ
	$dadosboleto["carteira"] = "175";  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

	// SEUS DADOS
	$dadosboleto["identificacao"] = "Hcode Treinamentos";
	$dadosboleto["cpf_cnpj"] = "24.700.731/0001-08";
	$dadosboleto["endereco"] = "Rua Ademar Saraiva Leão, 234 - Alvarenga, 09853-120";
	$dadosboleto["cidade_uf"] = "São Bernardo do Campo - SP";
	$dadosboleto["cedente"] = "HCODE TREINAMENTOS LTDA - ME";

	// NÃO ALTERAR!
	include("res/boletophp/include/funcoes_itau.php");
	include("res/boletophp/include/layout_itau.php");
});

$app->get("/profile/orders", function(){
	User::verifyLogin(false);

	$user = User::getFromSession();

	$page = new Page();

	$page->setTpl("profile-orders",[
		'orders'=>$user->getOrders()
	]);
});

$app->get("/profile/orders/:idorder", function($idorder){
	User::verifyLogin(false);

	$order = new Order;

	$order->get((int)$idorder);

	$cart = new Cart;

	$cart->get((int)$order->getidcart());

	$page = new Page();

	$page->setTpl("profile-orders-detail",[
		'order' => $order->getData(),
		'cart'=>$cart->getData()
	]);
});





?>