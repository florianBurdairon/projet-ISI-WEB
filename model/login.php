<?php

require_once "model/model.php";
require_once "model/customer.php";

class Login extends Model{
    private $id;
    private $customer_id;
    private $username;
    private $password;

    private $customer;
    private $hashed_password;

    public function __construct($data) {
        $this->id = $data["id"];

        if (isset($data["customer_id"]))
        {
            $this->customer_id = $data["customer_id"];
            $this->customer = Customer::select_customer_by_id($data["customer_id"]);
        }
        else if (isset($data["customer"]))
        {
            $this->customer = $data["customer"];
            $this->customer_id = $this->customer->get_id();
        }
        $this->username = $data["username"];
        $this->password = $data["password"];

        if (isset($data["hashed_password"]))
            $this->hashed_password = $data["hashed_password"];
        else {
            $this->hashed_password = sha1(iconv("UTF-8", "ASCII", $this->password));
        }
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_customer_id()
    {
        return $this->customer_id;
    }

    public function get_username()
    {
        return $this->username;
    }

    public function get_hashed_password()
    {
        return $this->hashed_password;
    }

    public function get_customer()
    {
        return $this->customer;
    }

    public static function select_login_by_username($username)
    {
        $query = "SELECT * FROM logins WHERE username = '".$username."'";
        $arr = self::fetchAll($query);
        $ret = new Login($arr[0]);
        return $ret;
    }

    function insert_login($customer_id, $username, $password){
        $hashed_password = sha1(iconv("UTF-8", "ASCII", $password));
        $query = "INSERT INTO logins (customer_id, username, password) 
                    VALUES ('".$customer_id."', '".$username."', '".$hashed_password."')";
        $ret = self::execute($query);
        
        // If count == 0 : Error
        $count = 0;
        if($ret)
            $count = $ret->rowCount();
        return $count;
    }

    public function insert()
    {
        $query = "INSERT INTO logins (customer_id, username, password)
                    VALUES ('".$this->customer_id."', '".$this->username."', '".$this->hashed_password."')";
        $ret = self::execute($query);
        
        // If count == 0 : Error
        $count = 0;
        if($ret)
            $count = $ret->rowCount();
        return $count;
    }
}
