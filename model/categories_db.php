<?php
    function select_categories() {
        global $db;
        $query = "SELECT categories.name FROM categories";
        $sth = $db->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        return $results;
    }
?>