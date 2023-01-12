<?php

require_once "model/model.php";

class DeliveryAdd extends Model{
    private $id;
    private $forname;
    private $surname;
    private $add1;
    private $add2;
    private $add3;
    private $postcode;
    private $phone;
    private $email;

    public function __construct($data) {
        $this->id = $data["id"];

        if (isset($data["firstname"]))
            $this->forname = $data["firstname"];
        else
            $this->forname = $data["forname"];
        if (isset($data["lastname"]))
            $this->surname = $data["lastname"];
        else
            $this->surname = $data["surname"];

        if (isset($data["add1"]))
            $this->add1 = $data["add1"];
        else
            $this->add1 = "";

        if (isset($data["add2"]))
            $this->add2 = $data["add2"];
        else
            $this->add2 = "";

        if (isset($data["add3"]))
            $this->add3 = $data["add3"];
        else
            $this->add3 = "";

        $this->postcode = $data["postcode"];
        $this->phone = $data["phone"];
        $this->email = $data["email"];
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_forname()
    {
        return $this->forname;
    }

    public function get_surname()
    {
        return $this->surname;
    }

    public function get_add1()
    {
        return $this->add1;
    }

    public function get_add2()
    {
        return $this->add2;
    }

    public function get_add3()
    {
        return $this->add3;
    }

    public function get_postcode()
    {
        return $this->postcode;
    }

    public function get_phone()
    {
        return $this->phone;
    }

    public function get_email()
    {
        return $this->email;
    }

    public static function select_delivery_add_by_id($id)
    {
        $query = "SELECT * FROM delivery_addresses WHERE id = '".$id."'";
        $arr = self::fetchAll($query);
        $ret = $arr[0];
        return $ret;
    }
}