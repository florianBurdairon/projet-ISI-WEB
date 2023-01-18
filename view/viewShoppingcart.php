<div class="d-sm-inline-flex d-flex w-100" id="wrapper">
    <div class="border-end border-right bg-white col-lg-2 col-md-3 col-sm-3" id="sidebar-wrapper">
        <h2>Nos offres</h2>
        <nav>
            <ul>
                <?php
                foreach($categories as $cat)
                {
                    $id = $cat->get_id();
                    $name = $cat->get_name();
                    $path = ROOT."products/cat/".$id;
                    echo "<li><a href='$path'>$name</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid ">

            <h1 class="mt-4">Panier</h1>

            <?php
                if (isset($orderitems))
                {
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

                        <!-- HTML -->

                        <div class="d-flex flex-column flex-lg-row flex-md-row flex-sm-column align-items-center border rounded mb-5">
                            <div class="border-end bg-white col-5 col-lg-3 col-md-4 col-sm-5 m-2">
                                <img class="rounded-circle w-100" src="<?= ROOT ?>assets/productimages/<?= $img ?>" alt="<?= $img ?>">
                            </div>
                            <div class="d-flex flex-column align-items-center align-items-md-start align-items-lg-start">
                                <h3><?= $name ?></h3>
                                <p class="text-md-left text-sm-center"><?= $desc ?></p>
                                <p>Prix : <?= number_format($price, 2) ?>€</p>
                                <p>Quantité : <?= $quantity ?></p>
                                <p>Prix total : <?= number_format($quantity * $price, 2) ?>€</p>

                                <form class="d-flex flex-column align-items-center" method="post" action="<?= ROOT ?>shoppingcart/delete">
                                    <input type="hidden" name="product_id" value="<?= $id ?>">
                                    <button type="submit">Retirer du panier</button>
                                </form>
                            </div>
                        </div>


                        <?php
                    }

                    echo "<p> Prix total de la commande : ".number_format($total, 2)."€</p>";
                    echo "<a href=\"".ROOT."shoppingcart/pay/selectaddress\"> Payer </a>";
                }
                else
                {
                    ?>
                    
                    <p>Aucun produit dans le panier.</p>

                    <?php
                }
            ?>

        </div>
    </div>
</div>