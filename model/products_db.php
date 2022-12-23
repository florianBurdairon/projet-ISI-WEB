<?php
    function select_products()
    {
        global $db;
        $query = "SELECT DISTINCT c.name AS cat, p.name, p.description, p.image, p.price, p.quantity FROM products p, categories c WHERE p.cat_id=c.id";
        $sth = $db->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        return $results;
    }

    function select_products_by_category($cat)
    {
        global $db;
        $query = "SELECT DISTINCT c.name AS cat, p.name, p.description, p.image, p.price, p.quantity FROM products p, categories c WHERE p.cat_id=c.id AND c.name='".$cat."'";
        $sth = $db->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        return $results;
    }
?>