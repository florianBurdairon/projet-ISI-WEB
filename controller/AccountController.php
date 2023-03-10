<?php
require_once 'model/customer.php';
require_once 'model/login.php';
require_once 'model/admin.php';
require_once 'model/order.php';
require_once 'model/orderItem.php';
require_once 'view/view.php';
require_once "fpdf/fpdf.php";

/**
 * Class AccountController
 * Manage every action on the account :
 *  - login
 *  - register
 *  - logout
 *  - show infos on "My account"
 *  - show orders on "My orders"
 */
class AccountController
{
    public function login()
    {
        $error_count = 0;
        $_SESSION["error"]["login"] = array();

        $password_pattern = "/^(?=.*\d)(?=.*[+*!&?#|_])(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";

        // Is there a valid input (no empty)
        if(isset($_POST["username"]) && $_POST["username"] != '' && isset($_POST["raw_password"]) && $_POST["raw_password"] != '' && preg_match($password_pattern, $_POST["raw_password"]))
        {
            // Is the person trying to connect an admin ?
            $admin = Admin::check_if_admin($_POST["username"], $_POST["raw_password"]);
            if($admin){
                $_SESSION["admin"] = serialize($admin);
                unset($_SESSION["error"]["login"]);
                unset($_SESSION["autofill"]["login"]);
                unset($_SESSION["shoppingcart"]);
                header("Location: ".ROOT."home");
            }
            // Else, it is a customer
            else{
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

                        header("Location: ".ROOT.BACKTOPAGE);
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

        $password_pattern = "/^(?=.*\d)(?=.*[+*!&?#|_])(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";
        $phone_pattern = "/^(?:(?:\+|00)33|0)(?:\s*)[1-9](?:[\s.-]*\d{2}){4}$/";
        $postcode_pattern = "/^$|^[0-9]{5}/";

        // Try to catch any error on account creation
        try{
            $customer = new Customer($_POST);
            $login = null;
            if(!isset($_POST["username"]) || $_POST["username"] == '' || !isset($_POST["raw_password"]) || $_POST["raw_password"] == '' || !isset($_POST["raw_password2"]) || $_POST["raw_password2"] == '' || $_POST["raw_password"] != $_POST["raw_password2"]) throw new Exception();
            if(!preg_match($password_pattern, $_POST["raw_password"]) || !preg_match($password_pattern, $_POST["raw_password2"]) || !preg_match($phone_pattern, $_POST["phone"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || !preg_match($postcode_pattern, $_POST["postcode"])) throw new Exception();
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

                        header("Location: ".ROOT.BACKTOPAGE);
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
            if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                $_SESSION["error"]["register"][$error_count] = "wrong_email";
                $error_count++;
            }
            if(!isset($_POST["raw_password"]) || $_POST["raw_password"] == ''){
                $_SESSION["error"]["register"][$error_count] = "missing_password";
                $error_count++;
            }
            if(!preg_match($password_pattern, $_POST["raw_password"])){
                $_SESSION["error"]["register"][$error_count] = "wrong_password";
                $error_count++;
            }
            if((!isset($_POST["raw_password2"]) || $_POST["raw_password2"] == '') && (isset($_POST["raw_password"]) && $_POST["raw_password"] != '')){
                $_SESSION["error"]["register"][$error_count] = "missing_password2";
                $error_count++;
            }
            if(!preg_match($password_pattern, $_POST["raw_password2"])){
                $_SESSION["error"]["register"][$error_count] = "wrong_password2";
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
            if(!preg_match($phone_pattern, $_POST["phone"])){
                $_SESSION["error"]["register"][$error_count] = "wrong_phone";
                $error_count++;
            }
            if($_POST["raw_password"] == $_POST["raw_password2"] && (!isset($_POST["password2"]) || $_POST["password2"] == '') && (isset($_POST["password"]) && $_POST["password"] != '')){
                $_SESSION["error"]["register"][$error_count] = "different_password";
                $error_count++;
            }
            if(!preg_match($postcode_pattern, $_POST["postcode"])){
                $_SESSION["error"]["register"][$error_count] = "wrong_postcode";
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
        $_SESSION["backToPage"] = "";
        header("Location: ".ROOT."home");
    }

    // Page to login
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

    // Page to register
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

    public function select_orders(){
        $orders = Order::select_orders_by_customer_id(unserialize($_SESSION["user"])->get_id());
        $view = new View("OrderList", "Mes commandes");
        $view->generate(array("orders" => $orders));
    }

    public function select_order_by_id($id){
        $order = Order::select_order_by_id_customer_id($id, unserialize($_SESSION["user"])->get_id());
        $orderitems = OrderItem::select_items_by_order($order->get_id());

        if (isset($_POST["id"]))
        {
            $pdf = $order->generate_pdf();
            $pdf->Output();
        }

        $view = new View("Order", "D??tails de la commande");
        $view->generate(array("order" => $order, "orderitems" => $orderitems));
    }
}