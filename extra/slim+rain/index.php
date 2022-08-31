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
    $tpl -> assign(array(
        "hello" => "Hello World",
        "present" => "Me chamo Bernardo Pacheco",
        "occupation" => "Sou desenvovedor Front-End",
        "about" => "Sobre mim",
        "from" => "Sou natural de Santa Maria - RS",
        "born" => "Nascido em Dezembro/1994",
        "rooter" => "Entusiasta da tecnologia",
        "experience" => "Experiências",
        "xp_descript" => "Atuação na área de tecnologia, prestando suporte a softwares, pela empresa",
        "company" => "Sistemas & Informação"
    ));
    $tpl -> draw('index');
});

$app -> run();