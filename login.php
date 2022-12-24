<?php
session_start();
if(isset($_POST["action"]) && $_POST["action"] == "login_check"){

    require "model/database.php";
    require "model/login_bd.php";
    require "model/customers_db.php";

    if(isset($_POST["email"]) && isset($_POST["password"])){
        $db_password_hash = select_login($_POST["email"]);
        $password_hash = sha1(iconv("UTF-8", "ASCII", $_POST["password"]));
        if($password_hash == $db_password_hash){
            $_SESSION["user"] = select_customer($_POST["email"])[0];
            header("Location: index.php".$_SESSION["backToPage"]);
        }
        else{
            header("Location: index.php?action=loginpage");
        }
    }
}
else{
    header("Location: index.php".$_SESSION["backToPage"]);
}
?>