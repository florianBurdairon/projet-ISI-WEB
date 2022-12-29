<?php
    if(!isset($isIndex)){
        header("Location: ../index.php".$_SESSION["backToPage"]);
        exit();
    }
    $enableComponents = true;
    
    require "components/head.php";
    require "components/header.php";
    $errors = array();
    if(isset($_SESSION["error"]["login"])){
        if(is_array($_SESSION["error"]["login"])){
            foreach($_SESSION["error"]["login"] as $error){
                $errors[$error] = true;
            }
        }
        else{
            $errors[$_SESSION["error"]["login"]] = true;
        }
    }
?>
<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Connexion</h1>
            <form method="post" action="login.php">
                <input type="hidden" name="action" value="login_check">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?php if(isset($_SESSION["autofill"]["login"])) echo $_SESSION["autofill"]["login"]; ?>">
                <?php if(isset($errors["missing_email"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir une adresse email.</div>";?>
                <?php if(isset($errors["wrong_email"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Adresse email inconnue. <a href=\"?action=registerpage\">S'inscrire</a></div>";?>
                <br>
                <label for="password">Mot de passe</label>
                <input type="password" name="password">
                <?php if(isset($errors["missing_password"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Veuillez saisir le mot de passe.</div>";?>
                <?php if(isset($errors["wrong_password"])) echo "<div class=\"alert alert-danger\" role=\"alert\">Mot de passe incorrect.</div>";?>
                <br>
                <button type="submit">Se connecter</button>
            </form>
        </div>
    </div>
</div>
<?php include "components/footer.php"; ?>