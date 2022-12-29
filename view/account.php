<?php
    if(!isset($isIndex) || !isset($_SESSION["backToPage"])){
        session_start();
        header("Location: ../index.php".$_SESSION["backToPage"]);
        exit();
    }
    $enableComponents = true;
    
    require "components/head.php";
    require "components/header.php";
?>
<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Mon compte</h1>
        </div>
    </div>
</div>
<?php include "components/footer.php"; ?>