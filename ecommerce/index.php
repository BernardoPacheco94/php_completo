<?php

session_start();
require_once("vendor/autoload.php");


$app = new \Slim\Slim();

$app->config('debug', true);

require_once ("functions.php");
require_once ("route".DIRECTORY_SEPARATOR."site.php");
require_once ("route".DIRECTORY_SEPARATOR."admin.php");
require_once ("route".DIRECTORY_SEPARATOR."users.php");
require_once ("route".DIRECTORY_SEPARATOR."passrecovery.php");
require_once ("route".DIRECTORY_SEPARATOR."categories.php");
require_once ("route".DIRECTORY_SEPARATOR."products.php");
require_once ("route".DIRECTORY_SEPARATOR."orders.php");


$app->run();
