<?php
require_once 'model/order.php';
require_once 'view/view.php';

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
            throw new Exception("Can not delete products from non-existing shopping cart");
        
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
        $param = array();
        if (isset($_SESSION["user"]))
        {
            $customer = unserialize($_SESSION["user"]);
            $customer_address = DeliveryAdd::create_address_from_customer($customer);
            $param["customer_address"] = $customer_address;
        }
        
        $view = new View("OrderAddress", "Panier");
        $view->generate($param);
    }

    public function save_address()
    {

    }
}
