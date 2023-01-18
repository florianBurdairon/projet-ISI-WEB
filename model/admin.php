<?php

require_once "model/model.php";

class Admin extends Model{
    private $id;
    private $username;

    private $password;

    /**
     * Create a new Login
     * Obligatory : customer/customer_id, username, password/raw_password
     */
    private function __construct($data) {
        if (isset($data["id"]))
            $this->id = $data["id"];
        
        if (isset($data["username"]))
            $this->username = $data["username"];

        if (isset($data["password"]))
            $this->password = $data["password"];
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_username()
    {
        return $this->username;
    }

    public function get_password()
    {
        return $this->password;
    }

    public static function check_if_admin($username, $raw_password){
        $password = sha1(iconv("UTF-8", "ASCII", $raw_password));
        $query = "SELECT * FROM admin WHERE username = '".$username."' AND password = '".$password."'";
        $arr = self::fetchAll($query);
        if (count($arr) > 0)
        {
            $ret = new Admin($arr[0]);
            return $ret;
        }
        else
            return false;
    }
}
