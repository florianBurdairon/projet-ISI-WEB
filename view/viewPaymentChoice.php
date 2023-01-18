<div>

    <p>Choisissez votre moyen de paiement pour <?= $number ?> article<?php if ($number >1) {?>s<?php } ?> au prix de <?= number_format($total, 2) ?>€</p>
    <a href="paypal">Payer par Paypal</a>
    <a href="check">Payer par chèque</a>

</div>