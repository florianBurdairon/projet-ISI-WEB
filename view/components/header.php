<body>
<header>
    <!-- Navigation sur le site -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark justify-content-start">

        <!-- Bouton pour ouvrir la navigation quand elle a été fermée (pour trop petit écran) -->
        <button class="navbar-toggler mr-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Logo -->
        <a class="navbar-brand" href="index.php">Web 4 Shop</a>

        <!-- Liens -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navigation sur le site -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link <?php if($action == "home") echo "active" ?>" href="?action=home">Accueil</a></li>
                <li class="nav-item"><a class="nav-link <?php if($action == "select_products") echo "active" ?>" href="?action=select_products">Produits</a></li>
            </ul>

            <div class="dropdown-divider"></div>

            <!-- Navigation sur les informations de session -->
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link <?php if($action == "shoppingcart") echo "active" ?>" href="?action=shoppingcart">Panier</a></li>
                <!--<li class="nav-item"><a class="nav-link" href="account.php">Mon compte</a></li>-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Bonjour <?= $name?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="?action=account">Accéder à mon compte</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="?action=logout">Se déconnecter</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>