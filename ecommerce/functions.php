<?php

use Hcode\Model\User;
use Hcode\Model\Cart;

function formatPrice($price)
{
    return number_format($price,2,',','.');
}

function checkLogin($inadmin=true)
{
    return User::checkLogin($inadmin);
}

function getUserName()
{
    $user = User::getFromSession();
    $user->get($user->getiduser());

    return $user->getdesperson();
}

// function getCartPrice()
// {
//     $cart = Cart::getFromSession();

//     return ($cart->getProductsTotals()['vlprice']);
// }

// function getCartQty()
// {
//     $cart = Cart::getFromSession();

//     return ($cart->getProductsTotals()['nrqtd']);
// }