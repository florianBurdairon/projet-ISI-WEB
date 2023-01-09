<?php
session_start();

$isIndex = true;
require "model/database.php";
require "model/products_db.php";
require "model/orders_db.php";

// No shopping cart existing
if(!isset($_SESSION["shoppingcart"])) 
{
    $_SESSION["shoppingcart"] = array();

    // If we have a connected user, we link the SESSION and the database
    if (isset($_SESSION["user"])) 
    {
        insert_order($_SESSION["user"]["id"]);
        $order = select_current_order($_SESSION["user"]["id"]);
        $_SESSION["shoppingcart"]["id"] = $order["id"];
    }
}

if (isset($_POST["operation"]) && isset($_POST["product_id"]))
{
    if ($_POST["operation"] == "add")
    {   
        // If we have a new product to add
        if(isset($_POST["product_id"]))
        {
            $product = select_product($_POST["product_id"]);

            // Is the product already in the shopping cart?
            $isAlreadyIn = false;
            foreach($_SESSION["shoppingcart"]["products"] as $o)
            {
                if ($o["id"] == $_POST["product_id"])
                    $isAlreadyIn = true;
            }

            // It's not : we add it
            if (!$isAlreadyIn)
            {
                $_SESSION["shoppingcart"]["products"][$_POST["product_id"]] = array();
                $_SESSION["shoppingcart"]["products"][$_POST["product_id"]] = select_product($_POST["product_id"]);
                $_SESSION["shoppingcart"]["products"][$_POST["product_id"]]["quantity"] = $_POST["quantity"];
                $_SESSION["shoppingcart"]["products"][$_POST["product_id"]][6] = $_POST["quantity"]; #SQL duplication

                // If we have a connected user, we add it to the database
                if (isset($_SESSION["user"])) 
                {
                    insert_product_in_order(
                        $_SESSION["shoppingcart"]["id"], 
                        $_POST["product_id"], 
                        $_POST["quantity"]);
                }
            }
            // It is : we update it
            else
            {
                $newQuantity = $_SESSION["shoppingcart"]["products"][$_POST["product_id"]]["quantity"] + $_POST["quantity"];
                $_SESSION["shoppingcart"]["products"][$_POST["product_id"]]["quantity"] = $newQuantity;
                $_SESSION["shoppingcart"]["products"][$_POST["product_id"]][6] = $newQuantity; #SQL duplication

                // If we have a connected user, we update it in the database
                if (isset($_SESSION["user"])) 
                {
                    update_product_in_order(
                        $_SESSION["shoppingcart"]["id"], 
                        $_POST["product_id"], 
                        $newQuantity);
                }
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

            unset($_SESSION["shoppingcart"]["products"][$_POST["product_id"]]);
        }
    }
}

// We don't want to do operation on a single product
else if (isset($_POST["operation"]) && isset($_SESSION["user"]))
{
    // Insert the current "session ONLY" shopping cart in the database
    if ($_POST["operation"] == "insertshoppingcart")
    {
        // The shopping cart isn't already in the database
        if (!isset($_SESSION["shoppingcart"]["id"]))
        {
            // New shopping cart in the database
            insert_order($_SESSION["user"]["id"]);
            $order = select_current_order($_SESSION["user"]["id"]);
            $_SESSION["shoppingcart"]["id"] = $order["id"];

            foreach($_SESSION["shoppingcart"]["products"] as $product)
            {
                insert_product_in_order($order["id"], $product["id"], $product["quantity"]);
            }
        }
    }

    // Load the current "database ONLY" shopping cart in the session 
    else if ($_POST["operation"] == "loadshoppingcart")
    {
        // We overwrite the current shopping cart
        unset($_SESSION["shoppingcart"]);
        $_SESSION["shoppingcart"] = array();

        // Select current shopping cart
        $order = select_current_order($_SESSION["user"]["id"]);
        $_SESSION["shoppingcart"]["id"] = $order["id"];

        $products = select_products_in_order($order["id"]);
        foreach($products as $product)
        {
            $_SESSION["shoppingcart"]["products"][$product["id"]] = $product;
        }
    }
}

// Back to last page
header("Location: index.php".$_SESSION["backToPage"]);
?>