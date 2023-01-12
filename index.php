<?php
$skipfirst = true;
$root = "";
foreach($_REQUEST as $param){
    if ($param != "" && !$skipfirst) $root .= "../";
    $skipfirst = false;
}
define('ROOT', $root);
require_once "controller/Router.php";
$router = new Router();
$router->routingRequest();

