<?php

require_once "model/model.php";
require_once "model/customer.php";

class Login extends Model{
    private $id;
    private $customer_id;
    private $username;

    private $customer;
    private $password;

    /**
     * Create a new Login
     * Obligatory : customer/customer_id, username, password/raw_password
     */
    public function __construct($data) {
        if (isset($data["id"]))
            $this->id = $data["id"];

        if (isset($data["customer"]))
        {
            $this->customer = $data["customer"];
            $this->customer_id = $this->customer->get_id();
        }
        else if (isset($data["customer_id"]))
        {
            $this->customer_id = $data["customer_id"];
            $this->customer = Customer::select_customer_by_id($data["customer_id"]);
        }
        
        if (isset($data["username"]))
            $this->username = $data["username"];
        else
            throw new Exception("No username for this login");

        if (isset($data["password"]))
            $this->password = $data["password"];
        else if (isset($data["raw_password"])) {
            $this->password = sha1(iconv("UTF-8", "ASCII", $data["raw_password"]));
        }
        else
            throw new Exception("No password for this login");
    }

    public function get_id()
    {
        if (isset($this->id))
            return $this->id;
        else
            throw new Exception("No ID for login of ".$this->username.". You need to insert it in the database first");
    }

    public function get_customer_id()
    {
        if (isset($this->customer_id))
            return $this->customer_id;
        else
            throw new Exception("No Customer ID for login of ".$this->username.". You need to insert it in the database first");
    }

    public function get_username()
    {
        return $this->username;
    }

    public function get_password()
    {
        return $this->password;
    }

    public function get_customer()
    {
        if (isset($this->customer))
            return $this->customer;
        else
            throw new Exception("No Customer for login of ".$this->username.". You need to insert it in the database first");
    }

    public static function select_login_by_username($username)
    {
        $query = "SELECT * FROM logins WHERE username = '".$username."'";
        $arr = self::fetchAll($query);
        if (count($arr) > 0)
        {
            $ret = new Login($arr[0]);
            return $ret;
        }
        else
            return false;
    }

    /*function insert_login($customer_id, $username, $password){
        $hashed_password = sha1(iconv("UTF-8", "ASCII", $password));
        $query = "INSERT INTO logins (customer_id, username, password) 
                    VALUES ('".$customer_id."', '".$username."', '".$hashed_password."')";
        $ret = self::execute($query);
        
        // If count == 0 : Error
        $count = 0;
        if($ret)
            $count = $ret->rowCount();
        return $count;
    }*/

    public function insert()
    {
        $query = "INSERT INTO logins (customer_id, username, password)
                    VALUES ('".$this->customer_id."', '".$this->username."', '".$this->password."')";
        $ret = self::execute($query);
        
        // If count == 0 : Error
        $count = 0;
        if($ret)
            $count = $ret->rowCount();

        // Temporary solution, must look for better
        $query = "SELECT id FROM logins WHERE customer_id = '".$this->customer_id."'";
        $arr = self::fetchAll($query);
        $this->id = $arr[0];

        return $count;
    }

    public static function check_if_username_already_used($username){
        $query = "SELECT * FROM logins WHERE username = '".$username."'";
        $arr = self::fetchAll($query);
        $ret = $arr->rowCount() > 0;
        return $ret;
    }
}