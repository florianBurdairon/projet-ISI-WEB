<div>
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid ">

            <h1 class="mt-4">Confirmer le paiement :</h1>

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
                            <p>Prix total de l'article : <?php echo $quantity * $price ?>€</p>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <p> Prix total de la commande : <?= $total ?></p>
                <p> Vous avez choisi de payer par <?= $paymenttype ?>.</p>
                <p> Pour cela, veuillez suivre ces consignes :</p>
                <p><?= $guidelines ?></p>
                <a href="paid"> Payer </a>

        </div>
    </div>
</div>