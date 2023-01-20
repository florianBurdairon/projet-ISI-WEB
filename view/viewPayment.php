<div class="d-sm-inline-flex d-flex w-100">
    <div class="container-fluid w-100">
        <h1 class="mt-4 mb-3 ml-5"><i class="fa fa-dollar"></i> Payer</h1>

        <div class="d-flex flex-row align-items-center justify-content-center w-100 mb-0">
            
            <div class="order-box col-5 d-flex flex-column align-items-center border rounded mb-0 mr-3 ml-3 pt-3 pb-3 h-100">
                <div class="p-2 w-100 d-flex flex-column align-items-center">
                    <h5 class="mb-3"><b><i class="fa fa-circle-info"></i> Informations</b></h5>
                    <div>
                        <p class="mb-2">Paiement par <?= $paymenttype ?></p>
                        <p class="mb-2"><b> <?= $guidelines ?></b></p>
                        <p class="mb-2">Date : <?= date('d/m/Y') ?></p>
                        <p class="mb-0">Montant total : <?= number_format($total, 2) ?>€</p>
                    </div>
                </div>
            </div>

            <div class="order-box col-5 d-flex flex-column align-items-center border rounded mb-0 mr-3 ml-3 pt-3 pb-3 h-100">
                <h5 class="mb-3"><b><i class="fa fa-location-dot"></i> Adresse de livraison</b></h5>
                <div class="w-100 d-flex flex-row justify-content-around">
                    <div>
                        <p class="mb-2">Nom : <?= $address->get_surname() ?></p>
                        <p class="mb-2">Prénom : <?= $address->get_forname() ?></p>
                        <p class="mb-2">Email : <?= $address->get_email() ?></p>
                        <p class="mb-2">Téléphone : <?= $address->get_phone() ?></p>
                    </div>
                    <div>
                        <p class="mb-2">Adresse : <?= $address->get_add1() ?></p>
                        <p class="mb-2">Complément d'adresse : <?= $address->get_add2() ?></p>
                        <p class="mb-2">Ville : <?= $address->get_city() ?></p>
                        <p class="mb-2">Code postal : <?= $address->get_postcode() ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-3 d-flex justify-content-center">
            <a class="btn border rounded larger-text" href="paid"><b><i class="fa fa-dollar"></i> Payer <?= number_format($total, 2) ?>€</b></a>
        </div>

        <hr class="hr mt-5" />

        <div class="mb-3 mt-3 d-flex justify-content-center">
            <h2>Contenu de la commande</h2>
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
                    </div>
                </div>


                <?php
            }
        ?>
        </div>

    </div>
</div>