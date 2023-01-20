<div class="d-sm-inline-flex d-flex w-100">
    <div class="container-fluid">
        <h1 class="mt-4 mb-3 ml-5"><i class="fa fa-list"></i> Mes commandes</h1>

        <div class="container-fluid d-flex flex-wrap justify-content-center">
            <?php
                foreach($orders as $order)
                {
                    try{
                        $id = $order->get_id();
                        $payment_type = null;
                        try{
                            $payment_type = $order->get_payment_type();
                        }
                        catch(Exception $e){}
                        $date = DateTime::createFromFormat('Y-m-d', $order->get_date());
                        $status = "";
                        $icon = "";
                        switch($order->get_status()){
                            case 0:
                                $status = "panier";
                                break;
                            case 1:
                                $status = "en attente du paiement";
                                $icon = "fa-dollar-sign";
                                break;
                            case 2:
                            case 3:
                                $status = "en attente de validation";
                                $icon = "fa-pause";
                                break;
                            case 10:
                                $status = "commande validée";
                                $icon = "fa-check";
                                break;
                        }
                        $total = number_format($order->get_total(), 2);
                    ?>

                    <!-- HTML -->

                    <div class="order-box col-8 col-lg-3 col-md-4 d-flex flex-column flex-lg-row flex-md-row flex-sm-column align-items-center border rounded mb-4 mr-3 ml-3 pt-3 pb-3">
                        <a href="orders/<?= $id ?>" class="order-link p-2 w-100 d-flex flex-column align-items-center">
                            <h5 class="mb-3"><b> <i class="fa <?= $icon?> mr-3"></i> Commande N°<?= $id ?></b></h5>
                            <div>
                                <?php if($payment_type != null) :?>
                                <p class="mb-2">Paiement par <?= $payment_type ?></p>
                                <?php else :?>
                                <p class="mb-2">Mode de paiement non défini</p>
                                <?php endif;?>
                                <p class="mb-2">Date : <?= $date->format('d/m/Y') ?></p>
                                <p class="mb-2">Status : <?= $status ?></p>
                                <p class="mb-0">Montant total : <?= $total ?>€</p>
                            </div>
                        </a>
                    </div>
                    <?php
                    }
                    catch(Exception $e){}
                }
                if($orders==null) echo "Vous n'avez réalisé aucune commande.";
            ?>
        </div>
    </div>
</div>