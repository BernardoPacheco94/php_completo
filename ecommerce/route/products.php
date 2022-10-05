<?php

use \Hcode\Model\Product;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

//Rota para listar os produtos
$app->get("/admin/products", function(){
    User::verifyLogin();

    $products = Product::listAll();

    $page = new PageAdmin();

    $page->setTpl("products", [
        "products"=>$products
    ]);
});


//Rota para pagina criar produto
$app->get("/admin/products/create", function(){
    User::verifyLogin();

    $page = new PageAdmin();

    $page->setTpl("products-create");
    
});

//Rota para salvar o produto
$app->post("/admin/products/create", function(){
    User::verifyLogin();

    $products = new Product;

    $products->setData($_POST);

    $products->save();

    $products->setPhoto($_FILES['file']);

    header('Location: /admin/products');
    exit;
});

//rota para pagina de edição
$app->get("/admin/products/:idproduct", function($idproduct){
    User::verifyLogin();

    $product = new Product;

    $product->get((int)$idproduct);

    $page = new PageAdmin();

    $page->setTpl("products-update",[
        'product'=> $product->getData()
    ]);

});

//rota para salvar produto editado
$app->post("/admin/products/:idproduct", function($idproduct){
    User::verifyLogin();
    
    $products = new Product;
    $products->get((int)$idproduct);
    $products->setData($_POST);

    $products->save();

    $products->setPhoto($_FILES["file"]);
    
    header('Location: /admin/products');
    exit;
});

//rota para deletar produto
$app->get("/admin/products/:idproduct/delete", function($idproduct){
    User::verifyLogin();
    
    $product = new Product;
    $product->get((int)$idproduct);

    $product->delete();

    header('Location: /admin/products');
    exit;
});