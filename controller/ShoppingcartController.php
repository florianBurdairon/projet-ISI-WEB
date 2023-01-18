<?php
require_once 'model/order.php';
require_once 'view/view.php';
require_once 'fpdf/fpdf.php';

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

            $view = new View("Shoppingcart", "Panier");
            if (sizeof($orderitems) > 0)
            {
                $view->generate(array('orderitems' => $orderitems, 'total' => $order->get_total(), 'categories' => $categories));
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
        
        $view = new View("OrderAddress", "Panier");
        $view->generate($param);
    }

    public function save_address()
    {
        if (!isset($_SESSION["shoppingcart"]) || sizeof(unserialize($_SESSION["shoppingcart"])->get_items()) < 1)
            throw new Exception("Impossible de sauvegarder une adresse de livraison pour une commande qui n'existe pas");

        $deladd = new DeliveryAdd($_POST);
        $deladd->insert();
        $order = unserialize($_SESSION["shoppingcart"]);
        $order->change_address($deladd);
        $_SESSION["shoppingcart"] = serialize($order);

        header("Location: ".ROOT."shoppingcart/pay/paymentchoice");
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
