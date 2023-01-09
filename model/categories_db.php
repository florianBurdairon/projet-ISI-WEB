<?php
    if(!isset($isIndex) || !isset($_SESSION["backToPage"])){
        session_start();
        header("Location: ../index.php".$_SESSION["backToPage"]);
        exit();
    }

    function select_categories() {
        global $db;
        $query = "SELECT categories.name FROM categories";
        $sth = $db->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        return $results;
    }
?>