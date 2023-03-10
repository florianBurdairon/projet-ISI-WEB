<?php

require_once "model/model.php";
require_once "model/product.php";

class OrderItem extends Model {
    private $id;
    private $order_id;
    private $product_id;
    private $quantity;

    private $product;

    /**
     * Create a new OrderItem
     * Obligatory : order/order_id, product/product_id, quantity
     */
    public function __construct($data)
    {
        if (isset($data["id"]))
            $this->id = $data["id"];
        
        if (isset($data["order"]))
            $this->order_id = $data["order"]->get_id();
        else if (isset($data["order_id"]))
            $this->order_id = $data["order_id"];
        else
            throw new Exception("Aucune commande ou panier associé");
        
        if (isset($data["product"]))
        {
            $this->product = $data["product"];
            $this->product_id = $this->product->get_id();
        }
        else if (isset($data["product_id"]))
        {
            $this->product_id = $data["product_id"];
            $this->product = Product::select_product_by_id($this->product_id);
        }
        else
            throw new Exception(("Aucun produit associé"));

        if (isset($data["quantity"]))
            $this->quantity = $data["quantity"];
        else
            throw new Exception("Aucune quantité saisie");
    }

    public function get_id()
    {
        if (isset($this->id))
            return $this->id;
        else
            throw new Exception("Aucun identifiant associé");
    }

    public function get_order_id()
    {
        return $this->order_id;
    }

    public function get_product_id()
    {
        return $this->product_id;
    }

    public function get_product()
    {
        return $this->product;
    }

    public function get_quantity()
    {
        return $this->quantity;
    }

    public static function select_items_by_order($order_id)
    {
        $query = "SELECT * FROM orderitems WHERE order_id = '".$order_id."'";
        $arr = self::fetchAll($query);
        
        $ret = array();
        foreach($arr as $orderItem)
            array_push($ret, new OrderItem($orderItem));
        return $ret;
    }

    public function update_quantity($newValue)
    {
        $this->quantity = $newValue;
    }

    public function insert()
    {
        $query = "INSERT INTO orderitems (order_id, product_id, quantity)
                    VALUES ('".$this->order_id."', '".$this->product_id."', '".$this->quantity."')";
        
        $ret = self::insert_get_id($query);
        $this->id = $ret;
        
        return $ret;
    }

    public function update_in_db()
    {
        $query = "UPDATE orderitems SET quantity = '".$this->quantity."' WHERE id = '".$this->id."'";
        self::execute($query);
    }

    public function delete_from_db()
    {
        $query = "DELETE FROM orderitems WHERE id = '".$this->id."'";
        self::execute($query);
    }
}