<?php

require_once "model/model.php";

class Category extends Model {

    private $id;
    private $name;

    /**
     * Create a new Category
     * Obligatory : id, name
     */
    public function __construct($data)
    {
        if (isset($data["id"]))
            $this->id = $data["id"];
        else
            throw new Exception("Aucun identifiant de catégorie saisi");
        
        if (isset($data["name"]))
            $this->name = $data["name"];
        else
            throw new Exception("Aucun nom de catégorie saisi");
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_name()
    {
        return $this->name;
    }

    /*
    * Return all categories in the database as an array of "Category"
    */
    public static function select_categories() {
        //$query = "SELECT categories.name FROM categories";
        $query = "SELECT * FROM categories";
        $arr = self::fetchAll($query);

        $ret = array();
        foreach($arr as $category)
            array_push($ret, new Category($category));
        return $ret;
    }

    /*
    * Return a Category instance with the corresponding $id
    */
    public static function select_category_by_id($id)
    {
        $query = "SELECT * FROM categories WHERE id = '".$id."'";
        $arr = self::fetchAll($query);
        $ret = new Category($arr[0]);
        return $ret;
    }
    
    /*
    * Return a Category instance with the corresponding $name
    */
    public static function select_category_by_name($name)
    {
        $query = "SELECT * FROM categories WHERE name = '".$name."'";
        $arr = self::fetchAll($query);
        $ret = new Category($arr[0]);
        return $ret;
    }
}