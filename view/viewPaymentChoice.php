<div class="d-sm-inline-flex d-flex w-100 flex-column">
    <div class="container-fluid">
        <h1 class="mt-4 mb-3 ml-5"><i class="fa fa-cart-shopping"></i> Mode de paiement</h3>

        <p>Veuillez choisir votre moyen de payer pour <?= $number ?> article<?php if ($number >1) {?>s<?php } ?> au prix de <?= number_format($total, 2) ?>€ :</p>
        <a class="btn btn-light" href="paypal"><i class="fa-brands fa-paypal"></i> Paypal</a>
        <a class="btn btn-light" href="check"><i class="fa fa-money-check"></i> Chèque</a>
    </div>

</div>