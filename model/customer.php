<?php
require_once "model.php";

class Customer extends Model{
    private $id;
    private $forname;
    private $surname;
    private $add1;
    private $add2;
    private $add3;
    private $postcode;
    private $phone;
    private $email;
    private $registered;

    public function __construct($data) {
        $this->id = $data["id"];
        $this->forname = $data["forname"];
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
        $this->registered = $data["registered"];
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

    public function get_registered()
    {
        return $this->registered;
    }

    public function insert()
    {
        $query = "INSERT INTO customers (forname, surname, add1, add2, add3, postcode, phone, email, registered)
                    VALUES ('".$this->forname."', '".$this->surname."', '".$this->add1."', '".$this->add2."', '".$this->add3."', '".$this->postcode."', '".$this->phone."', '".$this->email.", 1)";
        $ret = self::execute($query);
        
        // If count == 0 : Error
        $count = 0;
        if($ret)
            $count = $ret->rowCount();
        return $count;
    }

    public static function select_customer_by_id($id){
        $query = "SELECT * FROM customers WHERE id = '".$id."'";
        $arr = self::fetchAll($query);
        $ret = new Customer($arr[0]);
        return $ret;
    }

    public static function insert_customer($newCustomer){
        $query = "INSERT INTO customers (forname, surname, add1, add2, add3, postcode, phone, email, registered) 
                    VALUES ('".$newCustomer["forname"]."', '".$newCustomer["surname"]."', 'ligne add1', 'ligne add2', '".$newCustomer["city"]."', '".$newCustomer["postcode"]."', '".$newCustomer["phone"]."', '".$newCustomer["email"]."', 1)";
        $ret = self::execute($query);
        
        // If count == 0 : Error
        $count = 0;
        if($ret)
            $count = $ret->rowCount();
        return $count;
    }
}
