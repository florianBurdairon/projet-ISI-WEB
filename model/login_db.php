<?php
    if(!isset($isIndex) || !isset($_SESSION["backToPage"])){
        session_start();
        header("Location: ../index.php".$_SESSION["backToPage"]);
        exit();
    }

    function select_login_by_email($email){
        global $db;
        $query = "SELECT logins.password FROM customers JOIN logins ON logins.customer_id = customers.id WHERE customers.email = '".$email."'";
        $sth = $db->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        if(isset($results[0][0])) $result = $results[0][0];
        else $result = null;
        return $result;
    }

    function select_username_by_id($email){
        global $db;
        $query = "SELECT logins.username FROM customers JOIN logins ON logins.customer_id = customers.id WHERE customers.email = '".$email."'";
        $sth = $db->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        $result = $results[0][0];
        return $result;
    }

    function insert_login($customer_id, $username, $password){
        global $db;
        $count = 0;
        $hash_password = sha1(iconv("UTF-8", "ASCII", $password));
        $query = "INSERT INTO logins (customer_id, username, password) 
                    VALUES ('".$customer_id."', '".$username."', '".$hash_password."')";
        $sth = $db->prepare($query);
        if($sth->execute()){
            $count = $sth->rowCount();
        }
        return $count;
    }
?>