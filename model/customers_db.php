<?php
    if(!isset($isIndex) || !isset($_SESSION["backToPage"])){
        session_start();
        header("Location: ../index.php".$_SESSION["backToPage"]);
        exit();
    }

    function select_customer_by_email($email){
        global $db;
        $query = "SELECT * FROM customers WHERE email = '".$email."'";
        $sth = $db->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        return $results;
    }

    function insert_customer($newCustomer){
        global $db;
        $count = 0;
        $query = "INSERT INTO customers (forname, surname, add1, add2, add3, postcode, phone, email, registered) 
                    VALUES ('".$newCustomer["firstname"]."', '".$newCustomer["surname"]."', 'ligne add1', 'ligne add2', '".$newCustomer["city"]."', '".$newCustomer["postcode"]."', '".$newCustomer["phone"]."', '".$newCustomer["email"]."', 1)";
        $sth = $db->prepare($query);
        if($sth->execute()){
            $count = $sth->rowCount();
        }
        else{
        }
        return $count;
    }
?>