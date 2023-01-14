<?php
require_once 'model/customer.php';
require_once 'model/login.php';
require_once 'view/view.php';

class AccountController
{
    public function login()
    {
        $error_count = 0;
        $_SESSION["error"]["login"] = array();

        if(isset($_POST["username"]) && $_POST["username"] != '' && isset($_POST["raw_password"]) && $_POST["raw_password"] != ''){
            $db_login = Login::select_login_by_username($_POST["username"]);
            $login = new Login($_POST);
            if($db_login){
                if($login->get_password() == $db_login->get_password()){
                    $_SESSION["user"] = serialize($db_login->get_customer());
                    unset($_SESSION["error"]["login"]);
                    unset($_SESSION["autofill"]["login"]);

                    // Update shoppingcart with user infos
                    if (isset($_SESSION["shoppingcart"]))
                    {
                        $old = Order::check_if_order_for_customer($db_login->get_customer());
                        if ($old)
                        {
                            $_SESSION["shoppingcart"] = serialize($old);
                        }
                        else {
                            $order = unserialize($_SESSION["shoppingcart"]);
                            $order->set_customer($db_login->get_customer());

                            $_SESSION["shoppingcart"] = serialize($order);
                        }
                    }

                    header("Location: ".ROOT."home");
                }
                else{
                    $_SESSION["error"]["login"][$error_count] = "wrong_password";
                    $error_count++;
                    $_SESSION["autofill"]["login"]["username"] = $_POST["username"];
                    header("Location: loginpage");
                }
            }
            else{
                $_SESSION["error"]["login"][$error_count] = "wrong_username";
                $error_count++;
                $_SESSION["autofill"]["register"]["username"] = $_POST["username"];
                header("Location: loginpage");
            }
        }
        else{
            if(!isset($_POST["username"]) || $_POST["username"] == ''){
                $_SESSION["error"]["login"][$error_count] = "missing_username";
                $error_count++;
            }
            if(!isset($_POST["raw_password"]) || $_POST["raw_password"] == ''){
                $_SESSION["error"]["login"][$error_count] = "missing_password";
                $error_count++;
                $_SESSION["autofill"]["login"]["username"] = $_POST["username"];
            }
            header("Location: loginpage");
        }
    }

    public function register()
    {
        $error_count = 0;
        $_SESSION["error"]["register"] = array();

        try{
            $customer = new Customer($_POST);
            $login = null;
            if(!isset($_POST["username"]) || $_POST["username"] == '' || $_POST["raw_password"] || $_POST["raw_password"] == '' || !isset($_POST["raw_password2"]) || $_POST["raw_password2"] == '' || $_POST["raw_password"] != $_POST["raw_password2"]) new Exception();
            if(!Customer::check_if_email_already_used($_POST["email"]) && !Login::check_if_username_already_used($_POST["username"])){
                if($customer->insert()){
                    $login_infos = array("username" => $_POST["username"], "raw_password" => $_POST["raw_password"], "customer_id" => $customer->get_id());
                    $login = new Login($login_infos);
                    if($login->insert()){
                        $_SESSION["user"] = serialize($customer);
                        unset($_SESSION["error"]["register"]);
                        unset($_SESSION["autofill"]["register"]);

                        // Update shoppingcart with user infos
                        if (isset($_SESSION["shoppingcart"]))
                        {
                            $order = unserialize($_SESSION["shoppingcart"]);
                            $order->set_customer($customer);
                        }

                        header("Location: ".ROOT."home");
                    }
                    else{
                        $_SESSION["error"]["register"][$error_count] = "error_insert_login";
                        $error_count++;
                        $_SESSION["autofill"]["register"] = $_POST;
                        header("Location: registerpage");
                    }
                }
                else{
                    $_SESSION["error"]["register"][$error_count] = "error_insert_customer";
                    $error_count++;
                    $_SESSION["autofill"]["register"] = $_POST;
                    header("Location: registerpage");
                }
            }
            else{
                if(Customer::check_if_email_already_used($_POST["email"])){
                    $_SESSION["error"]["register"][$error_count] = "email_already_used";
                    $error_count++;
                }
                if(Login::check_if_username_already_used($_POST["username"])){
                    $_SESSION["error"]["register"][$error_count] = "username_already_used";
                    $error_count++;
                }
                $_SESSION["autofill"]["register"] = serialize($customer);
                $_SESSION["autofill"]["login"]["username"] = $_POST["username"];
                header("Location: registerpage");
            }
        }
        catch(Exception $e){
            if(!isset($_POST["email"]) || $_POST["email"] == ''){
                $_SESSION["error"]["register"][$error_count] = "missing_email";
                $error_count++;
            }
            if(!isset($_POST["raw_password"]) || $_POST["raw_password"] == ''){
                $_SESSION["error"]["register"][$error_count] = "missing_password";
                $error_count++;
            }
            if((!isset($_POST["raw_password2"]) || $_POST["raw_password2"] == '') && (isset($_POST["raw_password"]) && $_POST["raw_password"] != '')){
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
            if(!isset($_POST["phone"]) || $_POST["phone"] == ''){
                $_SESSION["error"]["register"][$error_count] = "missing_phone";
                $error_count++;
            }
            if($_POST["raw_password"] == $_POST["raw_password2"] && (!isset($_POST["password2"]) || $_POST["password2"] == '') && (isset($_POST["password"]) && $_POST["password"] != '')){
                $_SESSION["error"]["register"][$error_count] = "different_password";
                $error_count++;
            }
            $_SESSION["autofill"]["register"] = $_POST;
            header("Location: registerpage");
        }
    }

    public function logout()
    {
        unset($_SESSION["user"]);
        unset($_SESSION["shoppingcart"]);
        header("Location: ".ROOT."home");
    }

    public function loginpage()
    {
        $errors = array();
        if(isset($_SESSION["error"]["login"])){
            if(is_array($_SESSION["error"]["login"])){
                foreach($_SESSION["error"]["login"] as $error){
                    $errors[$error] = true;
                }
            }
            else{
                $errors[$_SESSION["error"]["login"]] = true;
            }
        }

        $autofill = isset($_SESSION["autofill"]["login"]) ? $_SESSION["autofill"]["login"] : array();

        $view = new View("Login", "Connexion");
        $view->generate(array("errors" => $errors, "autofill" => $autofill));
    }

    public function registerpage()
    {
        $errors = array();
        if(isset($_SESSION["error"]["register"])){
            if(is_array($_SESSION["error"]["register"])){
                foreach($_SESSION["error"]["register"] as $error){
                    $errors[$error] = true;
                }
            }
            else{
                $errors[$_SESSION["error"]["register"]] = true;
            }
        }

        $autofill = isset($_SESSION["autofill"]["register"]) ? $_SESSION["autofill"]["register"] : array();

        $view = new View("Register", "Inscription");
        $view->generate(array("errors" => $errors, "autofill" => $autofill));
    }

    public function infos()
    {
        $login = Login::select_login_by_customer_id(unserialize($_SESSION["user"])->get_id());
        $view = new View("Account", "Mon compte");
        $view->generate(array("login" => $login));
    }
}