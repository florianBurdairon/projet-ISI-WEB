<?php
require_once 'model/order.php';
require_once 'view/view.php';

class ShoppingcartController
{
    public function select()
    {
        if (isset($_SESSION["shoppingcart"]))
        {
            $orderitems = unserialize($_SESSION["shoppingcart"])->get_items();
            $view = new View("Shoppingcart", "Panier");
            $view->generate(array('orderitems' => $orderitems));
        }
        else
        {
            $view = new View("Shoppingcart", "Panier");
            $view->generate(array());
        }
    }

    public function insert()
    {
        // Create a new shopping cart if no existing yet
        if (!isset($_SESSION["shoppingcart"]))
        {
            $data = array();
            if (isset($_SESSION["user"]))
            {
                $data["customer"] = unserialize($_SESSION["user"]);
                $data["registered"] = 1;
            }
            $order = new Order($data);
            $order->insert();
            $_SESSION["shoppingcart"] = serialize($order);
        }

        // Insert the product from $_POST
        if(isset($_POST["product_id"]) && isset($_POST["quantity"])){
            $data = array("order_id" => unserialize($_SESSION["shoppingcart"])->get_id(), "product_id" => $_POST["product_id"], "quantity" => $_POST["quantity"]);
            $item = new OrderItem($data);
            $order = unserialize($_SESSION["shoppingcart"]);
            $order->add_or_update_item($item);
            $_SESSION["shoppingcart"] = serialize($order);
        }

        // Redirect to precedent page
        /**
         * #######  ###     ####   ###
         *    #    #   #    #   # #   #
         *    #    #   #    #   # #   #
         *    #    #   #    #   # #   #
         *    #     ###     ####   ###
         */
        $this->select();
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
            $_SESSION["shoppingcart"] = serialize($order);
        }
        
        // Redirect to shopping cart
        /**
         * #######  ###     ####   ###
         *    #    #   #    #   # #   #
         *    #    #   #    #   # #   #
         *    #    #   #    #   # #   #
         *    #     ###     ####   ###
         */
        $this->select();
    }
}
