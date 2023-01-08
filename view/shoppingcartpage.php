<?php
    require "components/head.php";
    require "components/header.php";
?>
<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Panier</h1>

            <?php

                if (isset($_SESSION["shoppingcart"]))
                {
                    foreach($_SESSION["shoppingcart"] as $product)
                    {
                        echo "<p>".$product["product_id"]."</p>";
                        echo "<p>".$product["quantity"]."</p>";
                    }
                }
            ?>

        </div>
    </div>
</div>
<?php include "components/footer.php"; ?>