<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Connexion</h1>
            <form method="post" action="login">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" value="<?php if(isset($autofill["username"])) echo $autofill["username"]; ?>">
                <?php if(isset($errors["missing_username"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir un nom d'utilisateur.</div>";?>
                <?php if(isset($errors["wrong_username"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Nom d'utilisateur inconnu. <a href=\"".ROOT."account/registerpage\">S'inscrire</a></div>";?>
                <br>
                <label for="raw_password">Mot de passe</label>
                <input type="password" name="raw_password">
                <?php if(isset($errors["missing_password"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir le mot de passe.</div>";?>
                <?php if(isset($errors["wrong_password"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Mot de passe incorrect.</div>";?>
                <br>
                <button type="submit">Se connecter</button>
            </form>
        </div>
    </div>
</div>