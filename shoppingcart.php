<?php
session_start();

$isIndex = true;
require "model/database.php";
require "model/products_db.php";
require "model/orders_db.php";

$productsCount = 0;

if(isset($_SESSION["shoppingcart"]))
    unset($_SESSION["shoppingcart"]);

// If there is already a shopping cart 
if(isset($_SESSION["shoppingcart"]))
{
    $productsCount = sizeof($_SESSION["shoppingcart"]["products"]);
}
else // No shopping cart existing
{
    $_SESSION["shoppingcart"] = array();

    // If we have a connected user, we link the SESSION and the database
    if (isset($_SESSION["user"])) 
    {
        insert_order($_SESSION["user"]["id"]);
        $order = get_current_order($_SESSION["user"]["id"])[0];
        $_SESSION["shoppingcart"]["id"] = $order["id"];
    }
    else
    {
        $_SESSION["shoppingcart"]["id"] = "-1";
    }
}

// If we add a new product
if(isset($_POST["product_id"]))
{
    // Add it to the session
    $_SESSION["shoppingcart"]["products"][$productsCount] = array();
    $_SESSION["shoppingcart"]["products"][$productsCount] = get_product($_POST["product_id"]);
    $_SESSION["shoppingcart"]["products"][$productsCount]["quantity"] = $_POST["quantity"];

    // If we have a connected user, we add it to the database
    if (isset($_SESSION["user"])) 
    {
        insert_product_in_order(
            $_SESSION["shoppingcart"]["id"], 
            $_POST["product_id"], 
            $_POST["quantity"]);
    }
}



// Back to last page
header("Location: index.php".$_SESSION["backToPage"]);

?>