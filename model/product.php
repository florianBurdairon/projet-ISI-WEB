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

    /**
     * Create a new Product
     * Obligatory : id, cat/cat_id, name, description, image, price, quantity
     */
    public function __construct($data) {
        if (isset($data["id"]))
            $this->id = $data["id"];
        else
            throw new Exception("No ID set");
        
        if (isset($data["name"]))
            $this->name = $data["name"];
        else
            throw new Exception("No name set");
        
        if (isset($data["cat_id"]))
        {
            $this->cat_id = $data["cat_id"];
            $this->cat = Category::select_category_by_id($this->cat_id);
        }
        else if (isset($data["cat"]))
        {
            $this->cat = $data["cat"];
            $this->cat_id = $this->cat->get_id();
        }
        else
            throw new Exception("No category set for product ".$this->name.".");

        if (isset($data["description"]))
            $this->description = $data["description"];
        else
            throw new Exception("No description set for product ".$this->name.".");

        if (isset($data["image"]))
            $this->image = $data["image"];
        else
            throw new Exception("No image set for product ".$this->name.".");

        if (isset($data["price"]))
            $this->price = $data["price"];
        else
            throw new Exception("No price set for product ".$this->name.".");
        
        if (isset($data["quantity"]))
            $this->quantity = $data["quantity"];
        else
            throw new Exception("No quantity set for product ".$this->name.".");
    }

    public function get_id()
    {
        if (isset($this->id))
            return $this->id;
        else
            throw new Exception("No ID for product ".$this->name.". You need to insert it in the database first");
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
        $query = "SELECT * FROM products WHERE cat_id='".$cat->get_id()."'";
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