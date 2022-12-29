<?php
    if(!isset($isIndex)){
        header("Location: ../index.php".$_SESSION["backToPage"]);
        exit();
    }
    $enableComponents = true;
    
    include "components/head.php";
    include "components/header.php";
?>
<h2>Error</h2>
<br>
<p><?=$error_message?></p>
<br>
<p><a href=".">Back</a></p>
<?php include "components/footer.php";