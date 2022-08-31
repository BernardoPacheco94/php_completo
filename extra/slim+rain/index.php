<?php

require_once ("vendor".DIRECTORY_SEPARATOR."autoload.php");

use Rain\Tpl;

// config
$config = array(
    "tpl_dir"       => "tpl/",
    "cache_dir"     => "cache/"
);

Tpl::configure( $config );


$app = new \Slim\Slim();

$app -> get('/', function(){
    $tpl = new Tpl;
    $tpl -> assign("hello", "Hello World");
    $tpl -> draw('index');
});

$app -> run();