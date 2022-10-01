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

function getCartPrice()
{
    $cart = Cart::getFromSession();

    $vlCart = $cart->getProductsTotals()['vlprice'];

    return (formatPrice($vlCart));
}

function getCartQty()
{
    $cart = Cart::getFromSession();

    return ($cart->getProductsTotals()['nrqtd']);
}

function mask($mask, $string)
{
    $string = str_replace(" ",'',$string);
    $string = str_replace(".",'',$string);
    $string = str_replace("-",'',$string);

    for ($i=0; $i < strlen($string); $i++) { 
        $mask[strpos($mask, "#")] = $string[$i];
    }

    return $mask;
}