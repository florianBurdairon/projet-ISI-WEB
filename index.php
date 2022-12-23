<?php
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

$name = "Florian";

switch($action){
    case "home":
        $title = "Accueil - Web 4 Shop";
        $categories = select_categories();
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
            include "view/products.php";
        }
        else{
            $products = select_products();
            include "view/products.php";
        }
        break;

    case "shoppingcart":
        $title = "Panier - Web 4 Shop";
        include "view/shoppingcart.php";
        break;

    case "account":
        $title = "Mon compte - Web 4 Shop";
        include "view/account.php";
        break;

    case "login":
        $title = "Connexion - Web 4 Shop";
        include "view/login.php";
        break;

    case "register":
        $title = "Inscription - Web 4 Shop";
        include "view/register.php";
        break;

    case "logout":
        header("Location: .?action=home");
        break;

    default:
        $title = "Accueil - Web 4 Shop";
        $categories = select_categories();
        include "view/home.php";
        break;
    
}

