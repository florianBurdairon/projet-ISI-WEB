<?php

require_once "model/model.php";
require_once "model/product.php";

class OrderItem extends Model {
    private $id;
    private $order_id;
    private $product_id;
    private $quantity;

    private $product;

    public function __construct($data)
    {
        $this->id = $data["id"];
        $this->order_id = $data["order_id"];
        $this->product_id = $data["product_id"];
        $this->quantity = $data["quantity"];

        $this->product = Product::select_product_by_id($this->product_id);
    }

    public static function select_items_by_order($order_id)
    {
        $query = "SELECT * FROM order_items WHERE order_id = '".$order_id."'";
        $arr = self::fetchAll($query);
        
        $ret = array();
        foreach($arr as $orderItem)
            array_push($ret, new OrderItem($orderItem));
        return $ret;
    }
}