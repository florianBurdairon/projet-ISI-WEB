<div class="d-sm-inline-flex d-flex w-100">
    <div class="container-fluid w-100">
        <h1 class="mt-4 mb-3 ml-5"><i class="fa fa-user"></i> Connexion</h1>
        <div class="d-flex justify-content-center w-100">
            <form class="register-box p-3 border rounded col-8 col-md-3 d-flex flex-column" method="post" action="login">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" value="<?php if(isset($autofill["username"])) echo $autofill["username"]; ?>">
                <?php if(isset($errors["missing_username"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir un nom d'utilisateur.</div>";?>
                <?php if(isset($errors["wrong_username"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Nom d'utilisateur inconnu. <a href=\"".ROOT."account/registerpage\">S'inscrire</a></div>";?>

                <label class="mt-3" for="raw_password">Mot de passe</label>
                <input type="password" class="password" name="raw_password" pattern="^(?=.*\d)(?=.*[+*!&?#|_])(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$">
                <small class="password-info">Le mot de passe doit contenir au minimum 8 caractères dont chacun des caractères suivant : minuscule, majuscule, chiffre, caractère spécial (&,!,_,[,],|,?,*,+)</small>
                <?php if(isset($errors["missing_password"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir le mot de passe.</div>";?>
                <?php if(isset($errors["wrong_password"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Mot de passe incorrect.</div>";?>

                <button class="btn mt-5" type="submit">Se connecter</button>
            </form>
        </div>
    </div>
</div>