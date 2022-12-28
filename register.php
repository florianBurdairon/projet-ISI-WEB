<?php
session_start();
if(isset($_POST["action"]) && $_POST["action"] == "register_check"){

    require "model/database.php";
    require "model/login_bd.php";
    require "model/customers_db.php";

    $error_count = 0;
    

    if(isset($_POST["email"]) 
        && isset($_POST["password"])
        && isset($_POST["password2"]) 
        && isset($_POST["firstname"]) 
        && isset($_POST["surname"]) 
        && isset($_POST["username"]) 
        && isset($_POST["city"]) 
        && isset($_POST["postcode"]) 
        && isset($_POST["phone"])){
        if($_POST["password"] == $_POST["password"]){
            $newCustomer = array();
            $newCustomer["email"] = $_POST["email"];
            $newCustomer["firstname"] = $_POST["firstname"];
            $newCustomer["surname"] = $_POST["surname"];
            $newCustomer["city"] = $_POST["city"];
            $newCustomer["postcode"] = $_POST["postcode"];
            $newCustomer["phone"] = $_POST["phone"];
            var_dump($newCustomer);
            insert_customer($newCustomer);
            $customer = select_customer_by_email($newCustomer["email"]);
            if($customer[0]["id"]){
                if(insert_login($customer[0]["id"], $_POST["username"], $_POST["password"])){
                    $_SESSION["user"] = select_customer_by_email($_POST["email"])[0];
                    $_SESSION["user"]["username"] = $_POST["username"];
                    header("Location: index.php".$_SESSION["backToPage"]);
                }
                else{
                    header("Location: index.php?action=registerpage");
                }
            }
            else{
                header("Location: index.php?action=registerpage");
            }
        }
        else{
            header("Location: index.php?action=registerpage");
        }
    }
    else{
        header("Location: index.php?action=registerpage");
    }
}
else{
    header("Location: index.php".$_SESSION["backToPage"]);
}
?>