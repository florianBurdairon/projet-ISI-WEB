<div class="d-flex d-sm-inline-flex w-100">
    <div class="border-right bg-white col-lg-2 col-md-3 col-sm-3">
        <h2 class="mt-2">Nos offres</h2>
        <nav>
            <ul class="list-unstyled ml-4">
                <?php
                foreach($categories as $cat)
                {
                    $id = $cat->get_id();
                    $name = ucfirst("les ".$cat->get_name());
                    $path = ROOT."products/cat/".$id;
                    echo "<li class=\"m-1\"><a href='$path' class=\"li-offers\">$name</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>

    <div class="container-fluid">
        <h1 class="mt-4">Bienvenue sur Web4Shop</h1>
        <p>Cliquez sur la liste de gauche pour découvrir nos offres. Nous avons en stock une large gamme de produits.</p>
    </div>
</div>