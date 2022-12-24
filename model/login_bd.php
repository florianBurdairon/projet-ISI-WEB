<?php
    function select_login($email){
        global $db;
        $query = "SELECT logins.password FROM customers NATURAL JOIN logins WHERE customers.email = '".$email."'";
        $sth = $db->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        $result = $results[0][0];
        return $result;
    }
?>