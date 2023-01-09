<?php
    if(!isset($enableComponents) || !isset($_SESSION["backToPage"])){
        session_start();
        header("Location: ../../index.php".$_SESSION["backToPage"]);
        exit();
    }
?>
<div class="border-end bg-white col-lg-2 col-md-3 col-sm-3" id="sidebar-wrapper">
    <h2>Nos offres</h2>
    <nav>
        <ul>
            <?php
            foreach($categories as $cat)
            {
                $name = $cat["name"];
                $path = "?action=select_products&category=".$name;
                echo "<li><a href='$path'>$name</a></li>";
            }
            ?>
        </ul>
    </nav>
</div>