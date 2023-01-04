<?php
session_start();
$isIndex = true;

if(isset($_POST["action"])){
    $action = htmlspecialchars($_POST["action"]);
} 
elseif(isset($_GET["action"])){
    $action = htmlspecialchars($_GET["action"]);
}
else {
    $action = "home";
}

$name = null;
if(isset($_SESSION["user"])) $name = $_SESSION["user"]["username"];

if(!isset($_SESSION["backToPage"])) $_SESSION["backToPage"] = "";

require "model/database.php";
require "model/categories_db.php";
require "model/products_db.php";

if($action != "registerpage"){
    unset($_SESSION["error"]["register"]);
    if (isset($_SESSION["autofill"]["register"]["email"])) $newEmail = $_SESSION["autofill"]["register"]["email"];
    unset($_SESSION["autofill"]["register"]);
    if (isset($newEmail)) $_SESSION["autofill"]["register"]["email"] = $newEmail;
} 

if($action != "loginpage"){
    unset($_SESSION["error"]["login"]);
    if ($action != "registerpage") unset($_SESSION["autofill"]["login"]);
} 

switch($action){
    case "home":
        $title = "Accueil - Web 4 Shop";
        $categories = select_categories();
        $_SESSION["backToPage"] = "?action=home";
        include "view/home.php";
        break;

    case "select_products":
        $title = "Produits - Web 4 Shop";
        $category = null;
        if(isset($_POST["category"])) $category = $_POST["category"];
        elseif(isset($_GET["category"])) $category = $_GET["category"];
        $categories = select_categories();
        if(isset($category)){
            $products = select_products_by_category($category);
            $_SESSION["backToPage"] = "?action=select_products&category=".$category;
            include "view/products.php";
        }
        else{
            $products = select_products();
            $_SESSION["backToPage"] = "?action=select_products";
            include "view/products.php";
        }
        break;

    case "shoppingcart":
        $title = "Panier - Web 4 Shop";
        $_SESSION["backToPage"] = "?action=shoppingcart";
        include "view/shoppingcart.php";
        break;

    case "account":
        if(!isset($_SESSION["user"])) header("Location: index.php".$_SESSION["backToPage"]);
        $title = "Mon compte - Web 4 Shop";
        $_SESSION["backToPage"] = "?action=account";
        include "view/account.php";
        break;

    case "loginpage":
        if(isset($_SESSION["user"])) header("Location: index.php".$_SESSION["backToPage"]);
        $title = "Connexion - Web 4 Shop";
        include "view/loginpage.php";
        break;

    case "registerpage":
        if(isset($_SESSION["user"])) header("Location: index.php".$_SESSION["backToPage"]);
        $title = "Inscription - Web 4 Shop";
        include "view/registerpage.php";
        break;

    case "logout":
        if(!isset($_SESSION["user"])) header("Location: index.php".$_SESSION["backToPage"]);
        header("Location: logout.php");
        break;

    default:
        header("Location: index.php".$_SESSION["backToPage"]);
        break;
    
}

