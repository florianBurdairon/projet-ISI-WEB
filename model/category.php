<?php

require_once "model.php";

class Category extends Model {

    private $id;
    private $name;

    public function __construct($data)
    {
        $this->id = $data["id"];
        $this->name = $data["name"];
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
    * Return all categories in the database
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
}