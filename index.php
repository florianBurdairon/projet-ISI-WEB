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
require "model/login_bd.php";
require "model/customers_db.php";

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
        if(!isset($_SESSION["user"])) {
            header("Location: index.php");
            $_SESSION["backToPage"] = "";
        }
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

    case "login":
        if(isset($_SESSION["user"])) header("Location: index.php".$_SESSION["backToPage"]);

        $error_count = 0;
        $_SESSION["error"]["login"] = array();

        if(isset($_POST["email"]) && $_POST["email"] != '' && isset($_POST["password"]) && $_POST["password"] != ''){
            $db_password_hash = select_login_by_email($_POST["email"]);
            if($db_password_hash){
                $password_hash = sha1(iconv("UTF-8", "ASCII", $_POST["password"]));
                if($password_hash == $db_password_hash){
                    $_SESSION["user"] = select_customer_by_email($_POST["email"])[0];
                    $_SESSION["user"]["username"] = select_username_by_id($_POST["email"]);
                    unset($_SESSION["error"]["login"]);
                    header("Location: index.php".$_SESSION["backToPage"]);
                }
                else{
                    $_SESSION["error"]["login"][$error_count] = "wrong_password";
                    $error_count++;
                    $_SESSION["autofill"]["login"] = $_POST["email"];
                    header("Location: index.php?action=loginpage");
                }
            }
            else{
                $_SESSION["error"]["login"][$error_count] = "wrong_email";
                $error_count++;
                $_SESSION["autofill"]["register"]["email"] = $_POST["email"];
                header("Location: index.php?action=loginpage");
            }
        }
        else{
            if(!isset($_POST["email"]) || $_POST["email"] == ''){
                $_SESSION["error"]["login"][$error_count] = "missing_email";
                $error_count++;
            }
            if(!isset($_POST["password"]) || $_POST["password"] == ''){
                $_SESSION["error"]["login"][$error_count] = "missing_password";
                $error_count++;
                $_SESSION["autofill"]["login"] = $_POST["email"];
            }
            header("Location: index.php?action=loginpage");
        }
        break;

    case "register":
        $error_count = 0;
        $_SESSION["error"]["register"] = array();
        $newCustomer = array();
        $newCustomer["email"] = $_POST["email"];
        $newCustomer["firstname"] = $_POST["firstname"];
        $newCustomer["surname"] = $_POST["surname"];
        $newCustomer["username"] = $_POST["username"];
        $newCustomer["city"] = $_POST["city"];
        $newCustomer["postcode"] = $_POST["postcode"];
        $newCustomer["phone"] = $_POST["phone"];

        if(isset($_POST["email"]) && $_POST["email"] != ''
            && isset($_POST["password"]) && $_POST["password"] != ''
            && isset($_POST["password2"]) && $_POST["password2"] != ''
            && isset($_POST["firstname"]) && $_POST["firstname"] != ''
            && isset($_POST["surname"]) && $_POST["surname"] != ''
            && isset($_POST["username"]) && $_POST["username"] != ''
            && isset($_POST["city"]) && $_POST["city"] != ''
            && isset($_POST["postcode"]) && $_POST["postcode"] != ''
            && isset($_POST["phone"]) && $_POST["phone"] != ''){
            if(select_customer_by_email($_POST["email"]) == null){
                if($_POST["password"] == $_POST["password2"]){
                    insert_customer($newCustomer);
                    $customer = select_customer_by_email($newCustomer["email"]);
                    if($customer[0]["id"]){
                        if(insert_login($customer[0]["id"], $_POST["username"], $_POST["password"])){
                            $_SESSION["user"] = select_customer_by_email($_POST["email"])[0];
                            $_SESSION["user"]["username"] = $_POST["username"];
                            unset($_SESSION["error"]["register"]);
                            unset($_SESSION["autofill"]["register"]);
                            header("Location: index.php".$_SESSION["backToPage"]);
                        }
                        else{
                            $_SESSION["error"]["register"][$error_count] = "error_insert_login";
                            $error_count++;
                            $_SESSION["autofill"]["register"] = $newCustomer;
                            header("Location: index.php?action=registerpage");
                        }
                    }
                    else{
                        $_SESSION["error"]["register"][$error_count] = "error_insert_customer";
                        $error_count++;
                        $_SESSION["autofill"]["register"] = $newCustomer;
                        header("Location: index.php?action=registerpage");
                    }
                }
                else{
                    $_SESSION["error"]["register"][$error_count] = "different_password";
                    $error_count++;
                    $_SESSION["autofill"]["register"] = $newCustomer;
                    header("Location: index.php?action=registerpage");
                }
            }
            else{
                $_SESSION["error"]["register"][$error_count] = "email_already_used";
                $error_count++;
                $_SESSION["autofill"]["register"] = $newCustomer;
                $_SESSION["autofill"]["login"] = $newCustomer["email"];
                header("Location: index.php?action=registerpage");
            }
        }
        else{
            if(!isset($_POST["email"]) || $_POST["email"] == ''){
                $_SESSION["error"]["register"][$error_count] = "missing_email";
                $error_count++;
            }
            if(!isset($_POST["password"]) || $_POST["password"] == ''){
                $_SESSION["error"]["register"][$error_count] = "missing_password";
                $error_count++;
            }
            if((!isset($_POST["password2"]) || $_POST["password2"] == '') && (isset($_POST["password"]) && $_POST["password"] != '')){
                $_SESSION["error"]["register"][$error_count] = "missing_password2";
                $error_count++;
            }
            if(!isset($_POST["firstname"]) || $_POST["firstname"] == ''){
                $_SESSION["error"]["register"][$error_count] = "missing_firstname";
                $error_count++;
            }
            if(!isset($_POST["surname"]) || $_POST["surname"] == ''){
                $_SESSION["error"]["register"][$error_count] = "missing_surname";
                $error_count++;
            } 
            if(!isset($_POST["username"]) || $_POST["username"] == ''){
                $_SESSION["error"]["register"][$error_count] = "missing_username";
                $error_count++;
            } 
            if(!isset($_POST["city"]) || $_POST["city"] == ''){
                $_SESSION["error"]["register"][$error_count] = "missing_city";
                $error_count++;
            } 
            if(!isset($_POST["postcode"]) || $_POST["postcode"] == ''){
                $_SESSION["error"]["register"][$error_count] = "missing_postcode";
                $error_count++;
            } 
            if(!isset($_POST["phone"]) || $_POST["phone"] == ''){
                $_SESSION["error"]["register"][$error_count] = "missing_phone";
                $error_count++;
            }
            $_SESSION["autofill"]["register"] = $newCustomer;
            header("Location: index.php?action=registerpage");
        }
        break;

    case "logout":
        if(isset($_SESSION["user"])){  
            unset($_SESSION["user"]);
        }
        header("Location: index.php".$_SESSION["backToPage"]);
        break;

    default:
        $title = "Accueil - Web 4 Shop";
        $categories = select_categories();
        $_SESSION["backToPage"] = "?action=home";
        include "view/home.php";
        break;
    
}

