<?php
require_once 'model/customer.php';
require_once 'model/login.php';
require_once 'model/order.php';
require_once 'model/orderItem.php';
require_once 'view/view.php';

class AdminController
{
    public function logout()
    {
        unset($_SESSION["admin"]);
        unset($_SESSION["shoppingcart"]);
        $_SESSION["backToPage"] = "";
        header("Location: ".ROOT."home");
    }
    
    public function select_orders(){
        $orders = Order::select_orders();
        $view = new View("Admin", "Console d'administration");
        $view->generate(array("orders" => $orders));
    }

    public function select_order_by_id($id){
        $order = Order::select_order_by_id($id);
        $orderitems = OrderItem::select_items_by_order($order->get_id());
        $view = new View("Order", "Console d'administration");
        $view->generate(array("order" => $order, "orderitems" => $orderitems));
    }

    public function validate($id){
        $order = Order::select_order_by_id($id);
        $res = $order->change_status("10");
        if($res) header("Location: ".ROOT.BACKTOPAGE);
        else throw new Exception("Numéro de commande invalide");
    }
}