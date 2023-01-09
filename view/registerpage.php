<?php
    if(!isset($isIndex) || !isset($_SESSION["backToPage"])){
        session_start();
        header("Location: ../index.php".$_SESSION["backToPage"]);
        exit();
    }
    $enableComponents = true;

    require "components/head.php";
    require "components/header.php";
    $errors = array();
    if(isset($_SESSION["error"]["register"])){
        if(is_array($_SESSION["error"]["register"])){
            foreach($_SESSION["error"]["register"] as $error){
                $errors[$error] = true;
            }
        }
        else{
            $errors[$_SESSION["error"]["register"]] = true;
        }
    }
?>
<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Inscription</h1>
            <?php if(isset($errors["error_insert_login"]) || isset($errors["error_insert_customer"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Une erreur s'est produites.</div>";?>
            <form method="post" action="">
                <input type="hidden" name="action" value="register">
                <label for="firstname">Prénom</label>
                <input type="text" name="firstname" value="<?php if(isset($_SESSION["autofill"]["register"]["firstname"])) echo $_SESSION["autofill"]["register"]["firstname"]; ?>">
                <?php if(isset($errors["missing_firstname"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre prénom.</div>";?>
                <br>
                <label for="surname">Nom</label>
                <input type="text" name="surname" value="<?php if(isset($_SESSION["autofill"]["register"]["surname"])) echo $_SESSION["autofill"]["register"]["surname"]; ?>">
                <?php if(isset($errors["missing_surname"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre nom.</div>";?>
                <br>
                <label for="username">Pseudo</label>
                <input type="text" name="username" value="<?php if(isset($_SESSION["autofill"]["register"]["username"])) echo $_SESSION["autofill"]["register"]["username"]; ?>">
                <?php if(isset($errors["missing_username"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre adresse email.</div>";?>
                <br>
                <label for="email">Adresse mail</label>
                <input type="email" name="email" value="<?php if(isset($_SESSION["autofill"]["register"]["email"])) echo $_SESSION["autofill"]["register"]["email"]; ?>">
                <?php if(isset($errors["missing_email"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre adresse email.</div>";?>
                <?php if(isset($errors["email_already_used"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Adresse email déjà utilisée. <a href=\"?action=loginpage\">Se connecter</a></div>";?>
                <br>
                <label for="password">Mot de passe</label>
                <input type="password" name="password">
                <?php if(isset($errors["missing_password"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir un mot de passe.</div>";?>
                <br>
                <label for="password_confirmation">Confirmation mot de passe</label>
                <input type="password" name="password2">
                <?php if(isset($errors["missing_password2"]) && !isset($errors["missing_password"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez re-saisir le mot de passe.</div>";?>
                <?php if(isset($errors["different_password"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Mots de passe différents.</div>";?>
                <br>
                <label for="phone">Téléphone</label>
                <input type="number" name="phone" value="<?php if(isset($_SESSION["autofill"]["register"]["phone"])) echo $_SESSION["autofill"]["register"]["phone"]; ?>">
                <?php if(isset($errors["missing_phone"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre numéro de téléphone.</div>";?>
                <br>
                <label for="city">Ville</label>
                <input type="text" name="city" value="<?php if(isset($_SESSION["autofill"]["register"]["city"])) echo $_SESSION["autofill"]["register"]["city"]; ?>">
                <?php if(isset($errors["missing_city"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre ville.</div>";?>
                <br>
                <label for="postcode">Code postal</label>
                <input type="number" name="postcode" value="<?php if(isset($_SESSION["autofill"]["register"]["postcode"])) echo $_SESSION["autofill"]["register"]["postcode"]; ?>">
                <?php if(isset($errors["missing_postcode"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre code postal.</div>";?>
                <br>
                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>
</div>
<?php include "components/footer.php"; ?>