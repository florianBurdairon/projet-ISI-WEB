<?php
    function select_current_order($customer_id)
    {
        global $db;
        $query = "SELECT id, status, total FROM orders WHERE customer_id = '".$customer_id."' AND status != 10";
        $sth = $db->prepare($query);
        $sth->execute();
        $order = $sth->fetchAll();
        return $order[0];
    }

    function insert_order($customer_id)
    {
        global $db;
        $query = "INSERT INTO orders (customer_id, registered, status, session) VALUES ('".$customer_id."', '1', '0', \"abc\")";
        $sth = $db->prepare($query);
        $sth->execute();
    }

    function insert_product_in_order($order_id, $product_id, $quantity)
    {
        global $db;
        $query = "INSERT INTO orderitems (order_id, product_id, quantity) VALUES ('".$order_id."', '".$product_id."', '".$quantity."')";
        $sth = $db->prepare($query);
        $sth->execute();
    }
    
    function update_product_in_order($order_id, $product_id, $quantity)
    {
        global $db;
        $query = "UPDATE orderitems SET quantity = '".$quantity."' WHERE order_id = '".$order_id."' AND product_id = '".$product_id."'";
        $sth = $db->prepare($query);
        $sth->execute();
    }

    function delete_product_in_order($order_id, $product_id)
    {
        global $db;
        $query = "DELETE FROM orderitems WHERE order_id='".$order_id."' AND product_id='".$product_id."'";
        $sth = $db->prepare($query);
        $sth->execute();
    }

    function select_products_in_order($order_id)
    {
        // TO DO*
        return $order_id;
    }
?>