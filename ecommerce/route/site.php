
<?php

use Hcode\Model\Cart;
use \Hcode\Model\Category;
use \Hcode\Model\Product;
use \Hcode\Page;

$app->get('/', function () {

	$products = Product::listAll();

	
	$page = new Page();

	$page->setTpl("index", [
		'products'=>Product::checkList($products)
	]);
});

//Rota para visualizar categoria limitando produtos por pagina
$app->get("/categories/:idcategoria", function($idcategory){
	$category = new Category();
	
	$category->get((int)$idcategory);

	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	$pagination = $category->getProductsPage($page);

	$pages = [];

	for ($i=1; $i <= $pagination['pages'] ; $i++) { 
		array_push($pages, [
			'link' => '/categories/'.$idcategory.'?page='.$i,
			'page' => $i
		]);
	}

	$page = new Page;

	$page->setTpl("category",[
		'category' => $category->getData(),
		'products'=> $pagination['data'],
		'pages'=>$pages
	]);
});

// Rota para detalhes de um produto
$app->get("/products/:desurl", function($desurl){
	$product = new Product;

	$product->getFromURL($desurl);

	$page = new Page();

	$page->setTpl("product-detail",[
		'product'=>$product->getData(),
		'categories'=>$product->getCategories()
	]);
});

// Rota para visualizar o carrinho de compras
$app->get('/cart',function(){
	
	$cart = Cart::getFromSession();

	// var_dump($cart->getProducts());
	// exit;
	
	$page = new Page();

	$page->setTpl('cart', [
		'cart'=>$cart->getData(),
		'products'=>$cart->getProducts()
	]);
});

$app->get('/cart/:idproduct/add', function($idproduct){
	
	$product = new Product;

	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();


	$qtd = isset($_GET['qtd']) ? (int)$_GET['qtd'] : 1;

	for ($i=0; $i < $qtd ; $i++) { 		
		$cart->addProduct($product);
	}


	header('Location: /cart');
	exit;
});

$app->get('/cart/:idproduct/minus', function($idproduct){
	$product = new Product;

	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();

	$cart->removeProduct($product);

	header('Location: /cart');
	exit;
});

$app->get('/cart/:idproduct/removeall', function($idproduct){
	$product = new Product;

	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();

	$cart->removeProduct($product, true);

	header('Location: /cart');
	exit;
});

$app->post('/cart/freight', function(){
	$cart = Cart::getFromSession();

	$cart->setFreight($_POST['zipcode']);

	header('Location: /cart');
	exit;
});
?>