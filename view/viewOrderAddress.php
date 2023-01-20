<div class="d-sm-inline-flex d-flex w-100 flex-column">
<h1 class="mt-4 mb-3 ml-5"><i class="fa fa-location-dot"></i> Adresse de livraison</h3>
    <div class="d-flex flex-column flex-md-row pr-4 pl-4">
        <?php if (isset($customeradd)) { 
            $firstname = $customeradd->get_forname();
            $surname = $customeradd->get_surname();
            $email = $customeradd->get_email();
            $phone = $customeradd->get_phone();
            $add1 = $customeradd->get_add1();
            $add2 = $customeradd->get_add2();
            $city = $customeradd->get_city();
            $postcode = $customeradd->get_postcode();
            if($firstname != "" && $surname != "" && $email != "" && $phone != "" && $add1 != "" && $city != "" && $postcode != ""):
            ?>
            <div class="container-fluid register-box d-inline-flex border rounded d-flex flex-column align-items-center p-3 mr-2 ml-2 mb-4">
                <h3 class="mb-3"><b>Votre compte</b></h3>
                <form method="post" action="usecustomeraddress" class="d-flex flex-column w-75">
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="firstname">Prénom</label>
                        <input type="text" name="firstname" value="<?= $firstname ?>" disabled>
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="surname">Nom</label>
                        <input type="text" name="surname" value="<?= $surname ?>" disabled>
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="email">Adresse mail</label>
                        <input type="email" name="email" value="<?= $email ?>" disabled>
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="phone">Téléphone</label>
                        <input type="number" name="phone" value="<?= $phone ?>" disabled>
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="add1">Adresse</label>
                        <input type="text" name="add1" value="<?= $add1 ?>" disabled>
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="add2">Complément d'adresse</label>
                        <input type="text" name="add2" value="<?= $add2 ?>" disabled>
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="city">Ville</label>
                        <input type="text" name="city" value="<?= $city ?>" disabled>
                    </div>
                    <div class="d-flex flex-row justify-content-between pb-2">
                        <label for="postcode">Code postal</label>
                        <input type="number" name="postcode" value="<?= $postcode ?>" disabled>
                    </div>
                    <div class="d-flex flex-row justify-content-center">
                        <button class="btn align-items-end" type="submit">Utiliser cette addresse</button>
                    </div>
                </form>
            </div>
        <?php 
            endif;
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
        <div class="container-fluid register-box d-inline-flex border rounded d-flex flex-column align-items-center p-3 mr-2 ml-2 mb-4">
            <h3 class="mb-3"><b>Nouvelle adresse</b></h3>
            <form method="post" action="choiceaddress" class="d-flex flex-column w-75">
                <div class="d-flex flex-row justify-content-between pb-2">
                    <label for="firstname">Prénom</label>
                    <div class="d-flex flex-column">
                        <input type="text" name="firstname" value="<?= $firstname ?>">
                        <?php if(isset($errors["missing_firstname"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre prénom.</div>";?>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-between pb-2">
                    <label for="surname">Nom</label>
                    <div class="d-flex flex-column">
                        <input type="text" name="surname" value="<?= $surname ?>">
                        <?php if(isset($errors["missing_surname"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre nom.</div>";?>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-between pb-2">
                    <label for="email">Adresse mail</label>
                    <div class="d-flex flex-column">
                        <input type="email" name="email" value="<?= $email ?>">
                        <?php if(isset($errors["missing_email"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre adresse email.</div>";?>
                        <?php if(isset($errors["wrong_email"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Adresse email incorrect.</div>";?>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-between pb-2">
                    <label for="phone">Téléphone</label>
                    <div class="d-flex flex-column">
                        <input type="text" name="phone" pattern="^(?:(?:\+|00)33|0)(?:\s*)[1-9](?:[\s.-]*\d{2}){4}$" value="<?= $phone ?>">
                        <?php if(isset($errors["missing_phone"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre numéro de téléphone.</div>";?>
                        <?php if(isset($errors["wrong_phone"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Numéro de téléphone incorrect.</div>";?>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-between pb-2">
                    <label for="add1">Adresse</label>
                    <div class="d-flex flex-column">
                        <input type="text" name="add1" value="<?= $add1 ?>">
                        <?php if(isset($errors["missing_add1"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre adresse.</div>";?>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-between pb-2">
                    <label for="add2">Complément d'adresse</label>
                    <div class="d-flex flex-column">
                        <input type="text" name="add2" value="<?= $add2 ?>">
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-between pb-2">
                    <label for="city">Ville</label>
                    <div class="d-flex flex-column">
                        <input type="text" name="city" value="<?= $city ?>">
                        <?php if(isset($errors["missing_city"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre ville.</div>";?>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-between pb-2">
                    <label for="postcode">Code postal</label>
                    <div class="d-flex flex-column">
                        <input type="number" pattern="^$|^[0-9]{5}$" name="postcode" value="<?= $postcode ?>">
                        <?php if(isset($errors["missing_postcode"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre code postal.</div>";?>
                        <?php if(isset($errors["wrong_postcode"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Code postal incorrect.</div>";?>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-center">
                    <button class="btn align-items-end" type="submit">Utiliser cette addresse</button>
                </div>
            </form>
        </div>
    </div>
</div>