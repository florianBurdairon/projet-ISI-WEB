<?php
    require "components/head.php";
    require "components/header.php";
?>
<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Inscription</h1>
            <form method="post" action="register.php">
                <input type="hidden" name="action" value="register_check">
                <label for="firstname">Prénom</label>
                <input type="text" name="firstname">
                <br>
                <label for="surname">Nom</label>
                <input type="text" name="surname">
                <br>
                <label for="username">Pseudo</label>
                <input type="text" name="username">
                <br>
                <label for="email">Adresse mail</label>
                <input type="email" name="email">
                <br>
                <label for="password">Mot de passe</label>
                <input type="password" name="password">
                <br>
                <label for="password_confirmation">Confirmation mot de passe</label>
                <input type="password" name="password_confirmation">
                <br>
                <label for="phone">Téléphone</label>
                <input type="number" name="phone">
                <br>
                <label for="city">Ville</label>
                <input type="text" name="city">
                <br>
                <label for="postcode">Code postal</label>
                <input type="number" name="postcode">
                <br>
                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>
</div>
<?php include "components/footer.php"; ?>