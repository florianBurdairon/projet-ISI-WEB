<?php

require_once "model/model.php";

class DeliveryAdd extends Model{
    private $id;
    private $forname;
    private $surname;
    private $add1;
    private $add2;
    private $city;
    private $postcode;
    private $phone;
    private $email;

    /**
     * Create a new Delivery Address
     * Obligatory : forname/firstname, surname/lastname, postcode, phone, email
     */
    public function __construct($data) {
        if (isset($data["id"]))
            $this->id = $data["id"];

        if (isset($data["forname"]))
            $this->forname = $data["forname"];
        else if (isset($data["firstname"]))
            $this->forname = $data["firstname"];

        if (isset($data["surname"]))
            $this->surname = $data["surname"];
        else if (isset($data["lastname"]))
            $this->surname = $data["lastname"];

        if (isset($data["add1"]))
            $this->add1 = $data["add1"];
        else
            $this->add1 = "";

        if (isset($data["add2"]))
            $this->add2 = $data["add2"];
        else
            $this->add2 = "";

        if (isset($data["add3"]))
            $this->city = $data["add3"];
        else if (isset($data["city"]))
            $this->city = $data["city"];
        else
            $this->city = "";

        $this->postcode = $data["postcode"];
        $this->phone = $data["phone"];
        $this->email = $data["email"];
    }

    public function get_id()
    {
        if (isset($this->id))
            return $this->id;
        else
            throw new Exception("No ID for delivery address of ".$this->forname.". You need to insert it in the database first");
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

    public function get_city()
    {
        return $this->city;
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

    public static function select_delivery_address_by_id($id)
    {
        $query = "SELECT * FROM delivery_addresses WHERE id = '".$id."'";
        $arr = self::fetchAll($query);
        $ret = new DeliveryAdd($arr[0]);
        return $ret;
    }

    public function insert()
    {
        $query = "INSERT INTO delivery_addresses (firstname, lastname, add1, add2, city, postcode, phone, email)
                    VALUES ('".$this->forname."', '".$this->surname."', '".$this->add1."', '".$this->add2."', '".$this->city."', '".$this->postcode."', '".$this->phone."', '".$this->email."')";
        $ret = self::insert_get_id($query);
        $this->id = $ret;

        return $ret;
    }
}