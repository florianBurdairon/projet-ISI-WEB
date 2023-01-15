<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <?php if (isset($customer_address)) {
                $firstname = $customer_address->get_forname();
                $surname = $customer_address->get_surname();
                $email = $customer_address->get_email();
                $phone = $customer_address->get_phone();
                $add1 = $customer_address->get_add1();
                $add2 = $customer_address->get_add2();
                $city = $customer_address->get_city();
                $postcode = $customer_address->get_postcode();
                
                ?>
                <h1 class="mt-4">Utiliser l'addresse du compte </h1>
                <form method="post" action="choiceaddress">
                    <label for="firstname">Prénom</label>
                    <input type="text" name="firstname" value="<?= $firstname ?>">
                    <br>
                    <label for="surname">Nom</label>
                    <input type="text" name="surname" value="<?= $surname ?>">
                    <br>

                    <label for="email">Adresse mail</label>
                    <input type="email" name="email" value="<?= $email ?>">
                    <br>

                    <label for="phone">Téléphone</label>
                    <input type="number" name="phone" value="<?= $phone ?>">
                    <br>
                    <label for="add1">Adresse</label>
                    <input type="text" name="add1" value="<?= $add1 ?>">
                    <br>
                    <label for="add2">Comlément d'adresse</label>
                    <input type="text" name="add2" value="<?= $add2 ?>">
                    <br>
                    <label for="city">Ville</label>
                    <input type="text" name="city" value="<?= $city ?>">
                    <br>
                    <label for="postcode">Code postal</label>
                    <input type="number" name="postcode" value="<?= $postcode ?>">
                    <br>
                    <button type="submit">Enregistrer cette addresse.</button>
                </form>
            </div>
        <?php } ?>
        <div class="container-fluid">
            <h1 class="mt-4">Entrer une nouvelle addresse</h1>
            <form method="post" action="choiceaddress">

                <label for="firstname">Prénom</label>
                <input type="text" name="firstname">
                <br>
                <label for="surname">Nom</label>
                <input type="text" name="surname">
                <br>

                <label for="email">Adresse mail</label>
                <input type="email" name="email">
                <br>

                <label for="phone">Téléphone</label>
                <input type="number" name="phone"">
                <br>
                <label for="add1">Adresse</label>
                <input type="text" name="add1">
                <br>
                <label for="add2">Comlément d'adresse</label>
                <input type="text" name="add2">
                <br>
                <label for="city">Ville</label>
                <input type="text" name="city">
                <br>
                <label for="postcode">Code postal</label>
                <input type="number" name="postcode">
                <br>
                <button type="submit">Enregistrer cette addresse.</button>
            </form>
        </div>
    </div>
</div>