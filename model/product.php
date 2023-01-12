<?php
require_once "model.php";
require_once "category.php";

class Product extends Model{
    private $id;
    private $cat_id;
    private $name;
    private $description;
    private $image;
    private $price;
    private $quantity;

    private $cat;

    public function __construct($data) {
        $this->id = $data["id"];
        $this->cat_id = $data["cat_id"];
        $this->name = $data["name"];
        $this->description = $data["description"];
        $this->image = $data["image"];
        $this->price = $data["price"];
        $this->quantity = $data["quantity"];
        
        $this->cat = Category::select_category_by_id($this->cat_id);
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_cat_id()
    {
        return $this->cat_id;
    }

    public function get_cat()
    {
        return $this->cat;
    }
    
    public function get_name()
    {
        return $this->name;
    }
    
    public function get_description()
    {
        return $this->description;
    }
    
    public function get_image()
    {
        return $this->image;
    }
    
    public function get_price()
    {
        return $this->price;
    }
    
    public function get_quantity()
    {
        return $this->quantity;
    }

    public static function select_products()
    {
        $query = "SELECT * FROM products";
        $arr = self::fetchAll($query);

        $ret = array();
        foreach($arr as $product)
            array_push($ret, new Product($product));
        return $ret;
    }

    /*
    * $cat is a Category instance
    */
    public static function select_products_by_category($cat)
    {
        $query = "SELECT DISTINCT c.id AS cat_id, p.name, p.description, p.image, p.price, p.quantity, p.id FROM products p, categories c WHERE p.cat_id=c.id AND c.name='".$cat->get_name()."'";
        $arr = self::fetchAll($query);

        $ret = array();
        foreach($arr as $product)
            array_push($ret, new Product($product));
        return $ret;
    }

    /*
    * $id is an int
    */
    public static function select_product_by_id($id)
    {
        $query = "SELECT * FROM products WHERE id = '".$id."'";
        $arr = self::fetchAll($query);
        $ret = new Product($arr[0]);
        return $ret;
    }
}