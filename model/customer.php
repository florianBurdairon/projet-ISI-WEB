<?php
require_once "model/model.php";

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

    /**
     * Create a new Customer
     * Obligatory : forname/firstname, surname/lastname, phone, email
     */
    public function __construct($data) {
        if (isset($data["id"]))
            $this->id = $data["id"];
        
        if (isset($data["forname"]) && $data["forname"] != "")
            $this->forname = $data["forname"];
        else if (isset($data["firstname"]) && $data["firstname"] != "")
            $this->forname = $data["firstname"];
        else
            throw new Exception("No forname/firstname set");

        if (isset($data["surname"]) && $data["surname"] != "")
            $this->surname = $data["surname"];
        else if (isset($data["lastname"]) && $data["lastname"] != "")
            $this->surname = $data["lastname"];
        else
            throw new Exception("No surname/lastname set for forname ".$this->forname);

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

        if (isset($data["postcode"]))
            $this->postcode = $data["postcode"];
            
        if (isset($data["phone"]) && $data["phone"] != "")
            $this->phone = $data["phone"];
        else
            throw new Exception("No phone set for forname ".$this->forname);

        if (isset($data["email"]) && $data["email"] != "")
            $this->email = $data["email"];
        else
            throw new Exception("No email set for forname ".$this->forname);

        if (isset($data["registered"]) && $data["registered"] != "")
            $this->registered = $data["registered"];
        else
            $this->registered = "1";
    }

    public function get_id()
    {
        if (isset($this->id))
            return $this->id;
        else
            throw new Exception("No ID for Customer ".$this->forname.". You need to insert it in the database first");
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
        $arr = self::execute($query);
        
        // If count == 0 : Error
        $count = 0;
        if($arr)
            $count = $arr->rowCount();

        // Temporary solution, must look for better
        $query = "SELECT id FROM customers WHERE email = '".$this->email."'";
        $arr = self::fetchAll($query);
        $this->id = $arr[0];

        return $count;
    }

    public static function select_customer_by_id($id){
        $query = "SELECT * FROM customers WHERE id = '".$id."'";
        $arr = self::fetchAll($query);
        $ret = new Customer($arr[0]);
        return $ret;
    }

    public static function check_if_email_already_used($email){
        $query = "SELECT * FROM customers WHERE email = '".$email."'";
        $arr = self::fetchAll($query);
        $ret = $arr->rowCount() > 0;
        return $ret;
    }

    /*
    public static function insert_customer($newCustomer){
        $query = "INSERT INTO customers (forname, surname, add1, add2, add3, postcode, phone, email, registered) 
                    VALUES ('".$newCustomer["forname"]."', '".$newCustomer["surname"]."', 'ligne add1', 'ligne add2', '".$newCustomer["city"]."', '".$newCustomer["postcode"]."', '".$newCustomer["phone"]."', '".$newCustomer["email"]."', 1)";
        $ret = self::execute($query);
        
        // If count == 0 : Error
        $count = 0;
        if($ret)
            $count = $ret->rowCount();
        return $count;
    }*/
}
