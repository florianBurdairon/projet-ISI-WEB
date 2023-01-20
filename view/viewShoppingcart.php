<div class="d-sm-inline-flex d-flex w-100">
    <div class="border-right bg-white col-lg-2 col-md-3 col-sm-3">
        <h2 class="mt-2">Nos offres</h2>
        <nav>
            <ul class="list-unstyled ml-4">
                <?php
                foreach($categories as $cat)
                {
                    $id = $cat->get_id();
                    $name = ucfirst("les ".$cat->get_name());
                    $path = ROOT."products/cat/".$id;
                    echo "<li class=\"m-1\"><a href='$path' class=\"li-offers\">$name</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>
    <div class="w-100">
        <div class="container-fluid w-100">
            <h1 class="mt-4 mb-3 ml-5"><i class="fa fa-cart-shopping"></i> Panier</h1>

            <?php
                if (isset($orderitems))
                {
                    ?>

                    <div class="container d-flex justify-content-between align-items-center mb-4 border col-9 p-2 rounded price-shadow">
                        <h3> Prix total de la commande : <?= number_format($total, 2) ?>€</h3>
                        <a class="border rounded" href="<?= ROOT ?>shoppingcart/pay/selectaddress"><i class="btn fa fa-dollar-sign"> Payer</i></a>
                    </div>

                    <div class="container d-flex flex-wrap justify-content-center">

                    <?php
                    foreach($orderitems as $orderitem)
                    {
                        $product = $orderitem->get_product();
                        $id = $product->get_id();
                        $img = $product->get_image();
                        $name = $product->get_name();
                        $desc = $product->get_description();
                        $price = $product->get_price();
                        $quantity = $orderitem->get_quantity();
                        ?>

                        <div class="product-box col-5 d-flex flex-column flex-lg-row flex-md-row flex-sm-column align-items-center justify-content-between border rounded mb-4 mr-3 ml-3 pt-3 pb-3">
                            <div class="d-flex flex-column align-items-center bg-white col-4">
                                <img class="product-img w-100 mb-2" src="<?= ROOT ?>assets/productimages/<?= $img ?>" alt="<?= $img ?>">
                            </div>
                            <div class="d-flex flex-column align-items-center align-items-md-start align-items-lg-start">
                                <h3><?= $name ?></h3>
                                <p>Prix unitaire : <?= number_format($price, 2) ?>€</p>
                                <p><?= $quantity ?> exemplaire<?php if($quantity > 1) echo "s" ?></p>
                            </div>
                            <div class="d-flex flex-column align-items-end bd-highlight mb-3 h-100">
                                <h3 class="mt-2 p-2 bd-highlight"><b><?= number_format($quantity * $price, 2) ?>€</b></h3>
                                <form class="d-flex flex-column align-items-center mt-auto p-2 bd-highlight" method="post" action="<?= ROOT ?>shoppingcart/delete">
                                    <input type="hidden" name="product_id" value="<?= $id ?>">
                                    <button class="btn" type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </div>


                        <?php
                    }

                    echo "</div>";

                }
                else
                {
                    ?>
                    
                    <h4>Aucun produit dans le panier.</h4>

                    <?php
                }
            ?>

        </div>
    </div>
</div>