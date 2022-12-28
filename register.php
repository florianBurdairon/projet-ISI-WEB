<?php
session_start();
if(isset($_POST["action"]) && $_POST["action"] == "register_check"){

    require "model/database.php";
    require "model/login_bd.php";
    require "model/customers_db.php";

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
}
else{
    header("Location: index.php".$_SESSION["backToPage"]);
}
?>