<?php

use Hcode\Model\Cart;
use \Hcode\Model\Order;
use Hcode\Model\OrderStatus;
use \Hcode\Model\User;
use Hcode\Page;
use \Hcode\PageAdmin;

//rota de acesso a pedidos
$app->get("/admin/orders", function(){
	User::verifyLogin();
	
	$page = new PageAdmin();

	$page->setTpl('orders',[
		"orders" => Order::listAll()
	]);
});

$app->get('/admin/orders/:idorder/status', function($idorder){
    User::verifyLogin();

    $order = new Order;

    $order->get($idorder);

    $page = new PageAdmin();

    $page->setTpl('order-status',[
        'order' => $order->getData(),
        'status' => OrderStatus::listAll(),
        'msgError' => Order::getError(),
        'msgSuccess' => Order::getMsgSuccess()
    ]);
});

$app->post('/admin/orders/:idorder/status', function($idorder){
    User::verifyLogin();
    
    if(!isset($_POST['idstatus']) || !(int)$_POST['idstatus'] > 0)
    {
        Order::setError('Houve falha ao alterar o status');
        header("Location: /admin/orders/".$idorder."/status");
        exit;
    }

    $order = new Order;    

    $order->get($idorder);

    $order->setidstatus((int)$_POST['idstatus']);

    $order->save();

    Order::setMsgSuccess('Status atualizado!');
        header("Location: /admin/orders/".$idorder."/status");
        exit;

});

$app->get('/admin/orders/:idorder/delete', function($idorder){
    User::verifyLogin();

    $order = new Order;

    $order->get((int)$idorder);

    $order->delete();

    header('Location: /admin/orders');
    exit;
});


$app->get('/admin/orders/:idorder', function($idorder){
    User::verifyLogin();

    $order = new Order;

    $order->get((int)$idorder);

    
    $cart = new Cart;

    $cart->get((int)$order->getData()['idcart']);
    
    
    $page = new PageAdmin();

    $page->setTpl('order',[
        'order'=>$order->getData(),
        'cart'=>$cart->getData(),//verificar se não vai haver diferenca
        'products' => $cart->getProducts()
    ]);
});

