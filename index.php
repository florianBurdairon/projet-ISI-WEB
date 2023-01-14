<?php
session_start();
//Génère la position de la racine du site pour permettre de ne pas mettre les fichiers à la racine
$skipfirst = true;
$root = "";
$uri = explode('?', $_SERVER['REQUEST_URI']);
foreach($_GET as $param){
    if ($param != "" && (!$skipfirst || substr($uri[0],-1) == '/')) $root .= "../";
    $skipfirst = false;
}
define('ROOT', $root);
$backToPage = isset($_SESSION["backToPage"]) ? $_SESSION["backToPage"] : "/";
define('BACKTOPAGE', $backToPage);

require_once "controller/Router.php";
$router = new Router();
$router->routingRequest();