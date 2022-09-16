
<?php

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

//Rota para visualizar categoria
$app->get("/categories/:idcategoria", function($idcategory){
	$category = new Category;
	
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	
	$pagination = $category->getProductsPage($page);
	
	$pages = [];
	
	for ($i=1; $i <= $pagination['pages'] ; $i++) { 
		array_push($pages,[
			'link'=> '/categories/'.$category->getidcategory().'?page='.$i,
			'page'=> $i
		]);
	}

	var_dump($pagination);
	exit;
	
	$category->get((int)$idcategory);


	$page = new Page;
	
	$page->setTpl("category",[
		'category' => $category->getData(),
		'products'=> $pagination['data']
	]);
});

?>