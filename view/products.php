<?php 
    include "components/head.php";
    include "components/header.php";
?>
<div class="d-sm-inline-flex d-flex" id="wrapper">
    <?php include "components/aside.php";?>
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Produits<?php if(isset($category)) echo(" - ".$category);?></h1>
            <?php
            // Itération sur les résultats de la requête SQL
            if(isset($products)){
                foreach ($products as $product) {
                    $name = $product['name'];
                    echo "<p>$name</p>";
                }
            }
            
            ?>
        </div>
    </div>
</div>
<?php include "components/footer.php"; ?>