<?php
require_once 'model/order.php';
require_once 'view/view.php';

class ShoppingcartController
{
    public function select()
    {
        if (isset($_SESSION["shoppingcart"]))
        {
            $orderitems = $_SESSION["shoppingcart"]->get_items();
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
        // Create a new shopping cart
        if (!isset($_SESSION["shoppingcart"]))
        {
            $data = array();
            if (isset($_SESSION["user"]))
            {
                $data["customer"] = $_SESSION["user"];
                $data["registered"] = 1;
            }
            $_SESSION["shoppingcart"] = new Order($data);
        }
    }
}
