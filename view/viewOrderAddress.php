<div class="d-sm-inline-flex d-flex w-100 flex-column">
<h1 class="mt-4 mb-3 ml-5"><i class="fa fa-location-dot"></i> Adresse de livraison</h3>
    <div class="d-flex flex-row pr-4 pl-4">
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
            <div class="container-fluid register-box col-5 border rounded d-flex flex-column align-items-center p-3">
                <h3 class="mb-3"><b>Votre compte</b></h3>
                <form method="post" action="choiceaddress" class="d-flex flex-column w-75">
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="firstname">Prénom</label>
                        <input type="text" name="firstname" value="<?= $firstname ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="surname">Nom</label>
                        <input type="text" name="surname" value="<?= $surname ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="email">Adresse mail</label>
                        <input type="email" name="email" value="<?= $email ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="phone">Téléphone</label>
                        <input type="number" name="phone" value="<?= $phone ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="add1">Adresse</label>
                        <input type="text" name="add1" value="<?= $add1 ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="add2">Complément d'adresse</label>
                        <input type="text" name="add2" value="<?= $add2 ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="city">Ville</label>
                        <input type="text" name="city" value="<?= $city ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="postcode">Code postal</label>
                        <input type="number" name="postcode" value="<?= $postcode ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-center">
                        <button class="btn align-items-end" type="submit">Utiliser cette addresse.</button>
                    </div>
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
        <div class="container-fluid register-box col-5 border rounded d-flex flex-column align-items-center p-3">
                <h3 class="mb-3"><b>Nouvelle adresse</b></h3>
                <form method="post" action="choiceaddress" class="d-flex flex-column w-75">
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="firstname">Prénom</label>
                        <input type="text" name="firstname" value="<?= $firstname ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="surname">Nom</label>
                        <input type="text" name="surname" value="<?= $surname ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="email">Adresse mail</label>
                        <input type="email" name="email" value="<?= $email ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="phone">Téléphone</label>
                        <input type="number" name="phone" value="<?= $phone ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="add1">Adresse</label>
                        <input type="text" name="add1" value="<?= $add1 ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="add2">Complément d'adresse</label>
                        <input type="text" name="add2" value="<?= $add2 ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="city">Ville</label>
                        <input type="text" name="city" value="<?= $city ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="postcode">Code postal</label>
                        <input type="number" name="postcode" value="<?= $postcode ?>">
                    </div>
                    <div class="d-flex flex-row justify-content-center">
                        <button class="btn align-items-end" type="submit">Utiliser cette addresse.</button>
                    </div>
                </form>
            </div>
    </div>
</div>