<?php

use \Hcode\Model\User;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\Category;
use Hcode\Model\Product;

//rota para admin - categorias
$app -> get("/admin/categories", function(){
	User::verifyLogin();
	
	$categories = Category::listAll();
	
	$page = new PageAdmin();

	$page->setTpl("categories", [
		'categories' => $categories
	]);
});


//rota para criar categoria
$app->get("/admin/categories/create", function(){
	User::verifyLogin();
	$page = new PageAdmin();
	
	$page->setTpl("categories-create");
});

$app->post("/admin/categories/create", function(){
	User::verifyLogin();
	$category = new Category;
	$category->setData($_POST);
	$category->save();

	header('Location: /admin/categories');
	exit;
});


//rota para deletar categoria
$app->get("/admin/categories/:idcategory/delete", function($idcategory){
	User::verifyLogin();
	$category = new Category;
	
	$category->get((int)$idcategory);
	
	$category->delete();
	
	header('Location: /admin/categories');
	exit;
});

// Rota para edição de categoria
$app->get("/admin/categories/:idcategory", function($idcategory){
	User::verifyLogin();
	
	$category = new Category;
	$category->get((int)$idcategory);
	
	$page = new PageAdmin();

	$page->setTpl("categories-update", [
		'category'=>$category->getData()
	]);

});

//Rota para salvar categoria editada
$app->post("/admin/categories/:idcategory", function($idcategory){
	User::verifyLogin();
	
	$category = new Category;
	$category->get((int)$idcategory);
	$category->setData($_POST);
	$category->save();

	header('Location: /admin/categories');
	exit;
});



//visualizar categoria e editar
$app->get("/admin/categories/:idcategory/products", function($idcategory)
{
	User::verifyLogin();

	$category = new Category;
	
	$category->get((int)$idcategory);
	
	$page = new PageAdmin();
	
	$page->setTpl("categories-products",[
		'category' => $category->getData(),
		'productsRelated'=>$category->getCategoryProducts(),
		'productsNotRelated'=>$category->getCategoryProducts(false)
	]);
});


//adicionar produto a uma categoria
$app->get("/admin/categories/:idcategory/products/:idproduct/add", function($idcategory, $idproduct)
{
	User::verifyLogin();

	$category = new Category;
	
	$category->get((int)$idcategory);
	
	$product = new Product;

	$product->get((int)$idproduct);

	$category->addProduct($product);

	header('Location: /admin/categories/'.$idcategory.'/products');
	exit;
});

//remover produto a uma categoria
$app->get("/admin/categories/:idcategory/products/:idproduct/remove", function($idcategory, $idproduct)
{
	User::verifyLogin();

	$category = new Category;
	
	$category->get((int)$idcategory);

	$product = new Product;

	$product->get((int)$idproduct);

	$category->removeProduct($product);


	header('Location: /admin/categories/'.$idcategory.'/products');
	exit;	
});