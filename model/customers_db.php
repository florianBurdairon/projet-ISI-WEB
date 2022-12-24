<?php
    function select_customer($email){
        global $db;
        $query = "SELECT customers.*, logins.username FROM customers NATURAL JOIN logins WHERE customers.email = '".$email."'";
        $sth = $db->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        return $results;
    }
?>