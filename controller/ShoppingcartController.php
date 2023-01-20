<?php
require_once 'model/order.php';
require_once 'view/view.php';
require_once 'fpdf/fpdf.php';

/**
 * Class ShoppingCartController
 * Manage every action done on the shopping cart
 *  - select
 *  - add or delete from the database
 *  - choose delivery address
 *  - pay
 *  - pdf generation
 */
class ShoppingcartController
{
    private function look_for_shoppingcart()
    {
        // Create a new shopping cart if no existing yet
        if (!isset($_SESSION["shoppingcart"]))
        {
            $old = Order::check_if_order_for_session(session_id());
            if (!$old)
            {
                $data = array();
                if (isset($_SESSION["user"]))
                {
                    $customer = unserialize($_SESSION["user"]);
                    $old = Order::check_if_order_for_customer($customer);
                    if ($old)
                    {
                        $_SESSION["shoppingcart"] = serialize($old);
                        return;
                    }
                    $data["customer"] = $customer;
                    $data["registered"] = 1;
                }
                $order = new Order($data);
                $order->insert();
                $_SESSION["shoppingcart"] = serialize($order);
            } else {
                $_SESSION["shoppingcart"] = serialize($old);
            }
        }
    }

    public function select()
    {
        self::look_for_shoppingcart();

        if (isset($_SESSION["shoppingcart"]))
        {
            $order = unserialize($_SESSION["shoppingcart"]);

            $orderitems = $order->get_items();
            $categories = Category::select_categories();
            $status = $order->get_status();

            $view = new View("Shoppingcart", "Panier");
            if (sizeof($orderitems) > 0)
            {
                $view->generate(array('orderitems' => $orderitems, 'total' => $order->get_total(), 'categories' => $categories, 'status' => $status));
            }
            else
            {
                $view->generate(array('categories' => $categories));
            }
        }
    }

    public function insert()
    {
        self::look_for_shoppingcart();

        // Insert the product from $_POST
        if(isset($_POST["product_id"]) && isset($_POST["quantity"])){
            $order = unserialize($_SESSION["shoppingcart"]);
            $data = array("order_id" => $order->get_id(), "product_id" => $_POST["product_id"], "quantity" => $_POST["quantity"]);
            $item = new OrderItem($data);
            $order->add_or_update_item($item);
            $_SESSION["shoppingcart"] = serialize($order);
        }

        // Redirect to precedent page
        header("Location: ".ROOT.BACKTOPAGE);
    }

    public function delete()
    {
        if (!isset($_SESSION["shoppingcart"]))
            throw new Exception("Impossible de supprimer un produit qui n'est pas dans le panier");
        
        // Delete the product from $_POST
        if(isset($_POST["product_id"])){
            $order = unserialize($_SESSION["shoppingcart"]);
            $product = Product::select_product_by_id($_POST["product_id"]);
            $order->delete_product($product);
            if (sizeof($order->get_items()) == 0)
            {
                unset($_SESSION["shoppingcart"]);
            }
            else {
                $_SESSION["shoppingcart"] = serialize($order);
            }
        }
        
        header("Location: ".ROOT."shoppingcart");
    }

    public function select_address()
    {
        if (!isset($_SESSION["shoppingcart"]) || sizeof(unserialize($_SESSION["shoppingcart"])->get_items()) < 1)
            throw new Exception("Impossible de choisir une adresse de livraison pour une commande qui n'existe pas");
        
        $param = array();
        if (isset($_SESSION["user"]))
        {
            $customer = unserialize($_SESSION["user"]);
            $customer_address = DeliveryAdd::create_address_from_customer($customer);
            $param["customeradd"] = $customer_address;
        }
        $order = unserialize($_SESSION["shoppingcart"]);

        try {
            $deladd = $order->get_delivery_add();
            $param["deliveryadd"] = $deladd;
        } catch (Exception $e) {}
        
        $errors = array();
        if(isset($_SESSION["error"]["order"])){
            if(is_array($_SESSION["error"]["order"])){
                foreach($_SESSION["error"]["order"] as $error){
                    $errors[$error] = true;
                }
            }
            else{
                $errors[$_SESSION["error"]["order"]] = true;
            }
        }
        $param["errors"] = $errors;

        $view = new View("OrderAddress", "Panier");
        $view->generate($param);
    }

    public function use_customer_address()
    {
        $deladd = DeliveryAdd::create_address_from_customer(unserialize($_SESSION["user"]));
        $deladd->insert();
        $order = unserialize($_SESSION["shoppingcart"]);
        $order->change_address($deladd);
        $_SESSION["shoppingcart"] = serialize($order);

        header("Location: ".ROOT."shoppingcart/pay/paymentchoice");
    }

    public function save_address()
    {
        $error_count = 0;
        $_SESSION["error"]["order"] = array();

        $phone_pattern = "/^(?:(?:\+|00)33|0)(?:\s*)[1-9](?:[\s.-]*\d{2}){4}$/";
        $postcode_pattern = "/^$|^[0-9]{5}$/";

        if (!isset($_SESSION["shoppingcart"]) || sizeof(unserialize($_SESSION["shoppingcart"])->get_items()) < 1)
            throw new Exception("Impossible de sauvegarder une adresse de livraison pour une commande qui n'existe pas");
        try{
            if(empty($_POST["firstname"]) || empty($_POST["surname"]) || empty($_POST["email"]) || empty($_POST["phone"]) || empty($_POST["add1"]) || empty($_POST["city"]) || empty($_POST["postcode"])) throw new Exception();
            if(!preg_match($phone_pattern, $_POST["phone"]) || !preg_match($postcode_pattern, $_POST["postcode"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) throw new Exception();
            $deladd = new DeliveryAdd($_POST);
            $deladd->insert();
            $order = unserialize($_SESSION["shoppingcart"]);
            $order->change_address($deladd);
            $_SESSION["shoppingcart"] = serialize($order);
            header("Location: ".ROOT."shoppingcart/pay/paymentchoice");
        }
        catch(Exception $e){
            if(!isset($_POST["email"]) || $_POST["email"] == ''){
                $_SESSION["error"]["order"][$error_count] = "missing_email";
                $error_count++;
            }
            if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                $_SESSION["error"]["order"][$error_count] = "wrong_email";
                $error_count++;
            }
            if(!isset($_POST["firstname"]) || $_POST["firstname"] == ''){
                $_SESSION["error"]["order"][$error_count] = "missing_firstname";
                $error_count++;
            }
            if(!isset($_POST["surname"]) || $_POST["surname"] == ''){
                $_SESSION["error"]["order"][$error_count] = "missing_surname";
                $error_count++;
            } 
            if(!isset($_POST["phone"]) || $_POST["phone"] == ''){
                $_SESSION["error"]["order"][$error_count] = "missing_phone";
                $error_count++;
            }
            if(!preg_match($phone_pattern, $_POST["phone"])){
                $_SESSION["error"]["order"][$error_count] = "wrong_phone";
                $error_count++;
            }
            if(!isset($_POST["add1"]) || $_POST["add1"] == ''){
                $_SESSION["error"]["order"][$error_count] = "missing_add1";
                $error_count++;
            }
            if(!isset($_POST["city"]) || $_POST["city"] == ''){
                $_SESSION["error"]["order"][$error_count] = "missing_city";
                $error_count++;
            }
            if(!isset($_POST["postcode"]) || $_POST["postcode"] == ''){
                $_SESSION["error"]["order"][$error_count] = "missing_postcode";
                $error_count++;
            }
            if(!preg_match($postcode_pattern, $_POST["postcode"])){
                $_SESSION["error"]["order"][$error_count] = "wrong_postcode";
                $error_count++;
            }
            header("Location: ".ROOT."shoppingcart/pay/selectaddress");
        }
    }

    public function payment_choice()
    {
        if (!isset($_SESSION["shoppingcart"]) || sizeof(unserialize($_SESSION["shoppingcart"])->get_items()) < 1)
            throw new Exception("Impossible de choisir une méthode de paiement pour une commande qui n'existe pas");
        
        $order = unserialize($_SESSION["shoppingcart"]);

        try {
            $add = $order->get_delivery_add_id();
        } catch (Exception $e){
            throw new Exception("Impossible de choisir une méthode de paiement pour une commande qui n'a pas encore d'adresse de livraison");
        }

        $total = $order->get_total();
        $number = sizeof($order->get_items());

        $view = new View("PaymentChoice", "Moyen de paiement");
        $view->generate(array("total" => $total, "number" => $number));
    }

    public function paypage()
    {
        if (!isset($_SESSION["shoppingcart"]) || sizeof(unserialize($_SESSION["shoppingcart"])->get_items()) < 1)
            throw new Exception("Impossible de payer pour une commande qui n'existe pas");

        $order = unserialize($_SESSION["shoppingcart"]);

        $order->set_payment_type($_GET["id"]);
        $_SESSION["shoppingcart"] = serialize($order);

        $param = array();
        $param["orderitems"] = $order->get_items();
        $param["total"] = $order->get_total();
        $param["paymenttype"] = $_GET["id"] == "paypal" ? "PayPal" : "chèque";
        $param["guidelines"] = $_GET["id"] == "paypal" ?
            " - Connectez-vous à votre compte Paypal" :
            " - Addressez votre chèque à \"Web4Shop\"";
        $param["address"] = $order->get_delivery_add();

        $view = new View("Payment", "Payer");
        $view->generate($param);
    }

    public function paid()
    {
        if (!isset($_SESSION["shoppingcart"]) || sizeof(unserialize($_SESSION["shoppingcart"])->get_items()) < 1)
            throw new Exception("Impossible de payer pour une commande qui n'existe pas");

        $order = unserialize($_SESSION["shoppingcart"]);

        try {
            $payment_type = $order->get_payment_type();
        } catch (Exception $e) {
            throw new Exception("Impossible de payer sans choisir de moyen de paiement");
        }

        $order->paid();

        $param = array();
        $param["order_id"] = $order->get_id();

        unset($_SESSION["shoppingcart"]);

        $view = new View("Paid", "Merci de votre confiance");
        $view->generate($param);
    }

    public function generate_pdf($id)
    {
        $order = Order::select_order_by_id($id);
        $pdf = $order->generate_pdf();
        $pdf->Output("I", "facture_".$order->get_id());
    }
}
