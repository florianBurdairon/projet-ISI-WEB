<?php
    function get_current_order($customer_id)
    {
        global $db;
        $query = "SELECT id, status, total FROM orders WHERE customer_id = '".$customer_id."' AND status != 10";
        $sth = $db->prepare($query);
        $sth->execute();
        $order = $sth->fetchAll();
        return $order;
    }

    function insert_order($customer_id)
    {
        global $db;
        $query = "INSERT INTO orders (customer_id, registered, status, session) VALUES ('".$customer_id."', '1', '0', \"abc\")";
        $sth = $db->prepare($query);
        return $sth->execute();
    }

    function insert_product_in_order($order_id, $product_id, $quantity)
    {
        global $db;
        $query = "INSERT INTO orderitems (order_id, product_id, quantity) VALUES ('".$order_id."', '".$product_id."', '".$quantity."')";
        $sth = $db->prepare($query);
        return $sth->execute();
    }
?>