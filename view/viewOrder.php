<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Commande N°<?= $order->get_id() ?></h1>
            <div class="d-flex flex-column flex-lg-row flex-md-row flex-sm-column align-items-center border rounded mb-5">
                <div class="border-end bg-white col-5 col-lg-3 col-md-4 col-sm-5 m-2">
                    <h3>Informations sur la commande</h3>
                    <p>Numéro de commande : <?= $order->get_id() ?></p>
                    <p>Type de paiement : <?= $order->get_payment_type() ?></p>
                    <p>Date : 
                        <?php 
                            $date = DateTime::createFromFormat('Y-m-d', $order->get_date());
                            echo $date->format('d/m/Y');
                            $status = "";
                            switch($order->get_status()){
                                case 0:
                                    $status = "panier";
                                    break;
                                case 1:
                                    $status = "en attente du paiement";
                                    break;
                                case 2:
                                case 3:
                                    $status = "en attente de validation";
                                    break;
                                case 10:
                                    $status = "commande validée";
                                    break;
                            }
                        ?>
                    </p>
                    <p>Status : <?= $status ?></p>
                    <p>Montant total : <?= number_format($order->get_total(), 2) ?>€</p>

                    <?php if($order->get_status() > 1 && !isset($_SESSION["admin"])):?>
                        <a href="<?= ROOT."shoppingcart/generatepdf/".$order->get_id() ?>" target="_blank">Générer la commande sous forme d'un pdf</a>
                    <?php elseif(isset($_SESSION["admin"]) && $order->get_status() != 10):?>
                        <a href="<?= ROOT."admin/validate/".$order->get_id() ?>" target="_blank">Valider la commande</a>
                    <?php endif; ?>
                </div>
                <div class="d-flex flex-column align-items-center align-items-md-start align-items-lg-start">
                    <h3>Adresse de livraison</h3>
                    <?php $address = $order->get_delivery_add(); ?>
                    <p>Nom : <?= $address->get_surname() ?></p>
                    <p>Prénom : <?= $address->get_forname() ?></p>
                    <p>Email : <?= $address->get_email() ?></p>
                    <p>Téléphone : <?= $address->get_phone() ?></p>
                    <p>Adresse : <?= $address->get_add1() ?></p>
                    <p>Complément d'adresse : <?= $address->get_add2() ?></p>
                    <p>Ville : <?= $address->get_city() ?></p>
                    <p>Code postal : <?= $address->get_postcode() ?></p>
                </div>
            </div>
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
                            <h3><?= $name ?></h3>
                            <p class="text-md-left text-sm-center"><?php echo $desc ?></p>
                            <p>Prix : <?= number_format($price, 2) ?>€</p>
                            <p>Quantité : <?= $quantity ?></p>
                            <p>Prix total : <?= number_format($quantity*$price, 2) ?>€</p>
                        </div>
                    </div>
                    <?php
                }
            ?>

        </div>
    </div>
</div>