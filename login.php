<?php
session_start();
if(isset($_POST["action"]) && $_POST["action"] == "login_check"){

    require "model/database.php";
    require "model/login_bd.php";
    require "model/customers_db.php";

    $error_count = 0;
    $_SESSION["error"] = array();

    if(isset($_POST["email"]) && $_POST["email"] != '' && isset($_POST["password"]) && $_POST["password"] != ''){
        $db_password_hash = select_login_by_email($_POST["email"]);
        if($db_password_hash){
            $password_hash = sha1(iconv("UTF-8", "ASCII", $_POST["password"]));
            if($password_hash == $db_password_hash){
                $_SESSION["user"] = select_customer_by_email($_POST["email"])[0];
                $_SESSION["user"]["username"] = select_username_by_id($_POST["email"]);
                unset($_SESSION["error"]);
                header("Location: index.php".$_SESSION["backToPage"]);
            }
            else{
                $_SESSION["error"][$error_count] = "wrong_password";
                $error_count++;
                header("Location: index.php?action=loginpage");
            }
        }
        else{
            $_SESSION["error"][$error_count] = "wrong_email";
            $error_count++;
            header("Location: index.php?action=loginpage");
        }
    }
    else{
        if(!isset($_POST["email"]) || $_POST["email"] == ''){
            $_SESSION["error"][$error_count] = "missing_email";
            $error_count++;
        }
        if(!isset($_POST["password"]) || $_POST["password"] == ''){
            $_SESSION["error"][$error_count] = "missing_password";
            $error_count++;
        }
        header("Location: index.php?action=loginpage");
    }
}
else{
    header("Location: index.php".$_SESSION["backToPage"]);
}
?>