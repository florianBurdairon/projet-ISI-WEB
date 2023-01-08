<?php
session_start();

require "model/database.php";
require "model/categories_db.php";
require "model/products_db.php";

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

    case "shoppingcartpage":
        $title = "Panier - Web 4 Shop";
        $_SESSION["backToPage"] = "?action=shoppingcartpage";
        if (isset($_SESSION["shoppingcart"]))
            $products = $_SESSION["shoppingcart"]["products"];

        include "view/shoppingcartpage.php";
        break;

    case "account":
        $title = "Mon compte - Web 4 Shop";
        $_SESSION["backToPage"] = "?action=account";
        include "view/account.php";
        break;

    case "loginpage":
        $title = "Connexion - Web 4 Shop";
        include "view/loginpage.php";
        break;

    case "registerpage":
        $title = "Inscription - Web 4 Shop";
        include "view/registerpage.php";
        break;

    case "logout":
        header("Location: logout.php");
        break;

    default:
        $title = "Accueil - Web 4 Shop";
        $categories = select_categories();
        $_SESSION["backToPage"] = "?action=home";
        include "view/home.php";
        break;
    
}

