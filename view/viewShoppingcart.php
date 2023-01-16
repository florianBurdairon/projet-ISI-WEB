<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
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
                                <h3><?php echo $name ?></h3>
                                <p class="text-md-left text-sm-center"><?php echo $desc ?></p>
                                <p>Prix : <?php echo $price ?>€</p>
                                <p>Quantité : <?php echo $quantity ?></p>
                                <p>Prix total : <?php echo $quantity * $price ?>€</p>

                                <form class="d-flex flex-column align-items-center" method="post" action="<?= ROOT ?>shoppingcart/delete">
                                    <input type="hidden" name="product_id" value="<?php echo $id ?>">
                                    <button type="submit">Retirer du panier</button>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                }
                else
                {
                    echo "Pas de panier déjà existant.";
                }
            ?>

        </div>
    </div>
</div>