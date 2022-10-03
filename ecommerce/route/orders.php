<?php

use \Hcode\Model\Order;
use \Hcode\Model\User;
use \Hcode\PageAdmin;

//rota de acesso a pedidos
$app->get("/admin/orders", function(){
	User::verifyLogin();
	
	$page = new PageAdmin();

	$page->setTpl('orders',[
		"orders" => Order::listAll()
	]);
});

