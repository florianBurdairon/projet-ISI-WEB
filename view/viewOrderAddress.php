<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <?php if (isset($customeradd)) { 
            $firstname = $customeradd->get_forname();
            $surname = $customeradd->get_surname();
            $email = $customeradd->get_email();
            $phone = $customeradd->get_phone();
            $add1 = $customeradd->get_add1();
            $add2 = $customeradd->get_add2();
            $city = $customeradd->get_city();
            $postcode = $customeradd->get_postcode();
            
            ?>
            <div class="container-fluid">
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
        <?php 
        } 
        if (isset($deliveryadd))
        {
            $firstname = $deliveryadd->get_forname();
            $surname = $deliveryadd->get_surname();
            $email = $deliveryadd->get_email();
            $phone = $deliveryadd->get_phone();
            $add1 = $deliveryadd->get_add1();
            $add2 = $deliveryadd->get_add2();
            $city = $deliveryadd->get_city();
            $postcode = $deliveryadd->get_postcode();
        } else 
        {
            $firstname = "";
            $surname = "";
            $email = "";
            $phone = "";
            $add1 = "";
            $add2 = "";
            $city = "";
            $postcode = "";
        }
        ?>
        <div class="container-fluid">
            <h1 class="mt-4">Entrer une nouvelle addresse</h1>
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
    </div>
</div>