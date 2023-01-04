<?php
    if(!isset($enableComponents) || !isset($_SESSION["backToPage"])){
        session_start();
        header("Location: ../../index.php".$_SESSION["backToPage"]);
        exit();
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html" ; charset="utf-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="<?="view/css/style.css"?>">
    <title><?= $title?></title>
</head>
