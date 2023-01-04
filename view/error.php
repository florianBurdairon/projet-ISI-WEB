<?php
    if(!isset($isIndex) || !isset($_SESSION["backToPage"])){
        session_start();
        header("Location: ../index.php".$_SESSION["backToPage"]);
        exit();
    }
    $enableComponents = true;
    
    $title="Error";
    $action="error";

    include "components/head.php";
    include "components/header.php";
?>
<h2>Error</h2>
<br>
<p><?=$error_message?></p>
<br>
<p><a href="<?=$_SESSION["backToPage"]?>">Back</a></p>
<?php include "components/footer.php";