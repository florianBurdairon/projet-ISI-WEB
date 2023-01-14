<div class="d-sm-inline-flex d-flex" id="wrapper">
    <div class="border-end bg-white col-lg-2 col-md-3 col-sm-3" id="sidebar-wrapper">
        <h2>Nos offres</h2>
        <nav>
            <ul>
                <?php
                foreach($categories as $cat)
                {
                    $id = $cat->get_id();
                    $name = $cat->get_name();
                    $path = ROOT."products/cat/".$id;
                    echo "<li><a href='$path'>$name</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Produits<?php if(isset($category)) echo(" - ".$category->get_name());?></h1>
            <?php
            // Itération sur les résultats de la requête SQL -> Produits
            if(isset($products)){
                foreach ($products as $product) {
                    $id = $product->get_id();
                    $img = $product->get_image();
                    $name = $product->get_name();
                    $desc = $product->get_description();
                    $price =$product->get_price();
                    ?>

                    <!-- HTML -->
                    <div class="d-flex flex-column flex-lg-row flex-md-row flex-sm-column align-items-center border rounded mb-5">
                        <div class="border-end bg-white col-5 col-lg-3 col-md-4 col-sm-5 m-2">
                            <img class="rounded-circle w-100" src="<?= ROOT ?>assets/productimages/<?= $img ?>" alt="<?= $img ?>">
                        </div>
                        <div class="d-flex flex-column align-items-center align-items-md-start align-items-lg-start">
                            <h3><?= $name ?></h3>
                            <p class="text-md-left text-sm-center"><?= $desc ?></p>
                            <p>Prix : <?= $price ?>€</p>

                            <form class="d-flex flex-column align-items-center" method="post" action="<?= ROOT ?>shoppingcart/insert">
                                <input type="hidden" name="product_id" value="<?= $id ?>">
                                <div>
                                    <label for="quantity">Quantity :</label>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1">
                                </div>
                                <button type="submit">Ajouter au panier</button>
                            </form>
                        </div>
                    </div>

                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>