<?php
    if(!isset($isIndex)|| !isset($_SESSION["backToPage"])){
        session_start();
        header("Location: ../index.php".$_SESSION["backToPage"]);
        exit();
    }
    
    $dsn = 'mysql:host=localhost;dbname=web4shop';
    $username = 'root';
    //$password = '';

    try {
        $db = new PDO($dsn, $username);
        //$db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = "Database Error: ";
        $error_message .= $e->getMessage();
        include 'view/error.php';
        exit();
    }
?>