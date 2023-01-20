<div class="d-sm-inline-flex d-flex w-100">
    <div class="container-fluid w-100 mb-4">
        <h1 class="mt-4 mb-3 ml-5"><i class="fa fa-user-plus"></i> Créer un compte</h1>
        <?php if(isset($errors["error_insert_login"]) || isset($errors["error_insert_customer"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Une erreur s'est produites.</div>";?>
        
        
        <div class="d-flex justify-content-center w-100">
            <form class="register-box p-3 border rounded col-3 d-flex flex-column" method="post" action="register">
                <label for="firstname">Prénom</label>
                <input type="text" name="firstname" value="<?php if(isset($autofill["firstname"])) echo $autofill["firstname"]; ?>">
                <?php if(isset($errors["missing_firstname"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre prénom.</div>";?>

                <label class="mt-3" for="surname">Nom</label>
                <input type="text" name="surname" value="<?php if(isset($autofill["surname"])) echo $autofill["surname"]; ?>">
                <?php if(isset($errors["missing_surname"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre nom.</div>";?>

                <label class="mt-3" for="username">Nom d'utilisateur</label>
                <input type="text" name="username" value="<?php if(isset($autofill["username"])) echo $autofill["username"]; ?>">
                <?php if(isset($errors["missing_username"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre adresse email.</div>";?>
                <?php if(isset($errors["username_already_used"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Nom d'utilisateur déjà utilisé. <a href=\"".ROOT."account/loginpage\">Se connecter</a></div>";?>

                <label class="mt-3" for="email">Adresse mail</label>
                <input type="email" name="email" pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$" value="<?php if(isset($autofill["email"])) echo $autofill["email"]; ?>">
                <?php if(isset($errors["missing_email"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre adresse email.</div>";?>
                <?php if(isset($errors["email_already_used"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Adresse email déjà utilisée. <a href=\"".ROOT."account/loginpage\">Se connecter</a></div>";?>
                <?php if(isset($errors["wrong_email"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Adresse email incorrect.</div>";?>

                <label class="mt-3" for="raw_password">Mot de passe</label>
                <input type="password" class="password" name="raw_password" pattern="^(?=.*\d)(?=.*[+*!&?#|_])(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$">
                <small class="password-info">Le mot de passe doit contenir au minimum 8 caractères dont chacun des caractères suivant : minuscule, majuscule, chiffre, caractère spécial (&,!,_,-,[,],\,^,$,.,|,?,*,+,(,))</small>
                <?php if(isset($errors["missing_password"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir un mot de passe.</div>";?>
                <?php if(isset($errors["wrong_password"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Mot de passe incorrect.</div>";?>

                <label class="mt-3" for="raw_password2">Confirmation mot de passe</label>
                <input type="password" class="password" name="raw_password2" pattern="^(?=.*\d)(?=.*[+*!&?#|_])(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$">
                <small class="password-info">Le mot de passe doit contenir au minimum 8 caractères dont chacun des caractères suivant : minuscule, majuscule, chiffre, caractère spécial (&,!,_,-,[,],\,^,$,.,|,?,*,+,(,))</small>
                <?php if(isset($errors["missing_password2"]) && !isset($errors["missing_password"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez re-saisir le mot de passe.</div>";?>
                <?php if(isset($errors["different_password"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Mots de passe différents.</div>";?>
                <?php if(isset($errors["wrong_password2"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Mot de passe incorrect.</div>";?>

                <label class="mt-3" for="phone">Téléphone</label>
                <input type="text" name="phone" pattern="^(?:(?:\+|00)33|0)(?:\s*)[1-9](?:[\s.-]*\d{2}){4}$" value="<?php if(isset($autofill["phone"])) echo $autofill["phone"]; ?>">
                <?php if(isset($errors["missing_phone"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir votre numéro de téléphone.</div>";?>
                <?php if(isset($errors["wrong_phone"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Numéro de téléphone incorrect.</div>";?>

                <label class="mt-3" for="add1">Adresse</label>
                <input type="text" name="add1" value="<?php if(isset($autofill["add1"])) echo $autofill["add1"]; ?>">

                <label class="mt-3" for="add2">Complément d'adresse</label>
                <input type="text" name="add2" value="<?php if(isset($autofill["add2"])) echo $autofill["add2"]; ?>">

                <label class="mt-3" for="add3">Ville</label>
                <input type="text" name="add3" value="<?php if(isset($autofill["add3"])) echo $autofill["add3"]; ?>">

                <label class="mt-3" for="postcode">Code postal</label>
                <input type="number" name="postcode" pattern="^$|^[0-9]{5}$" value="<?php if(isset($autofill["postcode"])) echo $autofill["postcode"]; ?>">
                <?php if(isset($errors["wrong_postcode"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Code postal incorrect.</div>";?>

                <button class="btn mt-5" type="submit">S'inscrire</button>
            </form>
        </div>
    </div>
</div>