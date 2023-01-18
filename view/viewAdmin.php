<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Console d'administration</h1>
            <?php
                foreach($orders as $order)
                {
                    try{
                        $id = $order->get_id();
                        $payment_type = $order->get_payment_type();
                        $date = DateTime::createFromFormat('Y-m-d', $order->get_date());
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
                        $total = number_format($order->get_total(), 2);
                    ?>

                    <!-- HTML -->

                    <a href="orders/<?= $id ?>">
                        <div class="align-items-center border rounded mb-5">
                            <p>Numéro de commande : <?= $id ?></p>
                            <p>Type de paiement : <?= $payment_type ?></p>
                            <p>Date : <?= $date->format('d/m/Y') ?></p>
                            <p>Status : <?= $status ?></p>
                            <p>Montant total : <?= $total ?>€</p>
                            <?php if($order->get_status() != 10): ?>
                            <a href="validate/<?= $id ?>">Valider la commande</a>
                            <?php endif; ?>
                        </div>
                    </a>
                    <?php
                    }
                    catch(Exception $e){}
                }
                if($orders==null) echo "Il n'y a pas encore de commandes.";
            ?>

        </div>
    </div>
</div>