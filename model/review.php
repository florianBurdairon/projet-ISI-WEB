<?php

class Review extends Model {

    private $product_id;
    private $product;
    private $name_user;
    private $stars;
    private $title;
    private $description;

    public function __construct($data)
    {
        if (isset($data["id_product"])){
            $this->product_id = $data["id_product"];
            $this->product = Product::select_product_by_id($data["id_product"]);
        }
        elseif (isset($data["product"])) {
            $this->product = $data["product"];
            $this->product_id = $this->product->get_id();
        }
        else
            throw new Exception("Impossible de créer un commentaire sur un produit inexistant");

        if (isset($data["name_user"]))
            $this->name_user = $data["name_user"];
        else
            throw new Exception("Impossible de créer un commentaire sans rédacteur");

        if (isset($data["stars"]))
            $this->stars = $data["stars"];
        else
            $this->stars = 0;
        
        if (isset($data["title"]))
            $this->title = $data["title"];
        
        if (isset($data["description"]))
            $this->description = $data["description"];
    }

    public function get_product_id()
    {
        if (isset($this->product_id))
            return $this->product_id;
        else
            throw new Exception("Aucun produit défini");
    }
    
    public function get_name_user()
    {
        if (isset($this->name_user))
            return $this->name_user;
        else
            throw new Exception("Aucun utilisateur défini");
    }
    
    public function get_stars()
    {
        if (isset($this->stars))
            return $this->stars;
        else
            throw new Exception("Aucune notation définie");
    }

    public function get_title()
    {
        if (isset($this->title))
            return $this->title;
        else
            throw new Exception("Aucun titre défini");
    }

    public function get_description()
    {
        if (isset($this->description))
            return $this->description;
        else
            throw new Exception("Aucune description définie");
    }

    public static function select_reviews_by_product_id($product_id) {
        
        $query = "SELECT * FROM reviews WHERE id_product = ".$product_id."";
        $arr = self::fetchAll($query);
        
        $ret = array();
        foreach($arr as $review)
            array_push($ret, new Review($review));
        return $ret;
    }
}