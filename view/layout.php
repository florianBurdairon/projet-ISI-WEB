<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" ; charset="utf-8" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= ROOT ?>assets/css/style.css">
        <title><?= $title?></title>
    </head>
    <body>
        <header>
            <!-- Navigation sur le site -->
            <nav class="navbar navbar-expand-sm navbar-dark bg-dark justify-content-start">

                <!-- Bouton pour ouvrir la navigation quand elle a été fermée (pour trop petit écran) -->
                <button class="navbar-toggler mr-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Logo -->
                <a class="navbar-brand" href="<?= ROOT ?>home">Web 4 Shop</a>

                <!-- Liens -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Navigation sur le site -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link <?php if($action == "Home") echo "active" ?>" href="<?= ROOT ?>home">Accueil</a></li>
                        <li class="nav-item"><a class="nav-link <?php if($action == "Products") echo "active" ?>" href="<?= ROOT ?>products">Produits</a></li>
                    </ul>

                    <div class="dropdown-divider"></div>

                    <!-- Navigation sur les informations de session -->
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link <?php if($action == "Shoppingcart") echo "active" ?>" href="<?= ROOT ?>shoppingcart">Panier</a></li>
                        <!--<li class="nav-item"><a class="nav-link" href="account.php">Mon compte</a></li>-->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php 
                                if($user != null) echo "Bonjour ".$user->get_surname();
                                else echo "Connexion/Inscription";
                            ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <?php if($user != null):?>
                                    <a class="dropdown-item" href="<?= ROOT ?>account/infos">Accéder à mon compte</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= ROOT ?>account/orders">Accéder à mes commandes</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= ROOT ?>account/logout">Se déconnecter</a>
                                <?php else : ?>
                                    <a class="dropdown-item" href="<?= ROOT ?>account/loginpage">Se connecter</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= ROOT ?>account/registerpage">S'inscrire</a>
                                <?php endif; ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <?= $content ?>

        <footer class="fixed-bottom text-light bg-secondary d-flex justify-content-center">
            <p>Ce site a été développé par BERNARD Alban et BURDAIRON Florian</p>
            <p></p>
        </footer>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>