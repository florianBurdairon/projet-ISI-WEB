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
            throw new Exception("Aucun prénom saisi");

        if (isset($data["surname"]) && $data["surname"] != "")
            $this->surname = $data["surname"];
        else if (isset($data["lastname"]) && $data["lastname"] != "")
            $this->surname = $data["lastname"];
        else
            throw new Exception("Aucun nom saisi");

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
            throw new Exception("Aucun numéro de téléphone saisi");

        if (isset($data["email"]) && $data["email"] != "")
            $this->email = $data["email"];
        else
            throw new Exception("Aucune adresse email saisi");

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
            throw new Exception("Aucun identifiant pour  ".$this->forname." ".$this->surname);
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
                    VALUES ('".$this->forname."', '".$this->surname."', '".$this->add1."', '".$this->add2."', '".$this->add3."', '".$this->postcode."', '".$this->phone."', '".$this->email."', 1)";
        $ret = self::insert_get_id($query);
        $this->id = $ret;

        return $ret;
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

        return sizeof($arr)>0;
    }
}
