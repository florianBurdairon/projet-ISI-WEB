<?php
session_start();

$isIndex = true;
require "model/database.php";
require "model/products_db.php";
require "model/orders_db.php";
$productsCount = 0;

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
        $order = select_current_order($_SESSION["user"]["id"])[0];
        $_SESSION["shoppingcart"]["id"] = $order["id"];
    }
    else
    {
        $_SESSION["shoppingcart"]["id"] = "-1";
    }
}

if (isset($_POST["operation"]) && isset($_POST["product_id"]))
{
    if ($_POST["operation"] == "add")
    {   
        // If we have a new product to add
        if(isset($_POST["product_id"]))
        {
            // Add it to the session
            $_SESSION["shoppingcart"]["products"][$productsCount] = array();
            $_SESSION["shoppingcart"]["products"][$productsCount] = get_product($_POST["product_id"]);
            $_SESSION["shoppingcart"]["products"][$productsCount]["quantity"] = $_POST["quantity"];
            $_SESSION["shoppingcart"]["products"][$productsCount][6] = $_POST["quantity"]; #SQL duplication

            // If we have a connected user, we add it to the database
            if (isset($_SESSION["user"])) 
            {
                insert_product_in_order(
                    $_SESSION["shoppingcart"]["id"], 
                    $_POST["product_id"], 
                    $_POST["quantity"]);
            }
        }
    }
    else if ($_POST["operation"] == "delete")
    {
        // If we have a new product to remove
        if(isset($_POST["product_id"]))
        {
            // If we have a connected user, we remove it from the database
            if (isset($_SESSION["user"])) 
            {
                delete_product_in_order(
                    $_SESSION["shoppingcart"]["id"], 
                    $_POST["product_id"]);
            }

            // delete it from the session
            $index = -1;
            for ($i = 0; $i < sizeof($_SESSION["shoppingcart"]["products"]); $i++)
            {
                if ($_SESSION["shoppingcart"]["products"][$i]["id"] == $_POST["product_id"])
                {
                    $index = $i;
                }
            }
            unset($_SESSION["shoppingcart"]["products"][$index]);
        }
    }
}

// Back to last page
header("Location: index.php".$_SESSION["backToPage"]);
?>