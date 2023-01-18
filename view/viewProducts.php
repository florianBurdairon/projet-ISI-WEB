<div class="d-sm-inline-flex d-flex w-100">
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
    <div class="w-100">
        <div class="container-fluid w-100">
            <h1 class="mt-4 mb-3 ml-5">Produits<?php if(isset($category)) echo(" - ".$category->get_name());?></h1>

            <div class="container d-flex flex-wrap justify-content-center">
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

                        <div class="product-box col-5 d-flex flex-column flex-lg-row flex-md-row flex-sm-column align-items-center border rounded mb-4 mr-5 pt-3 pb-3">
                            <div class="d-flex flex-column align-items-center bg-white col-4">
                                <img class="product-img w-100 mb-2" src="<?= ROOT ?>assets/productimages/<?= $img ?>" alt="<?= $img ?>">
                                <h3><b><?= $price ?>€</b></h3>
                            </div>
                            <div class="d-flex flex-column align-items-center align-items-md-start align-items-lg-start">
                                <h4><b><?= $name ?></b></h4>
                                <p class="text-md-left text-sm-center"><?= $desc ?></p>

                                <form class="d-flex flex-column align-items-center" method="post" action="<?= ROOT ?>shoppingcart/insert">
                                    <input type="hidden" name="product_id" value="<?= $id ?>">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <input class="col-4" type="number" id="quantity" name="quantity" value="1" min="1">
                                        <button class="btn ml-4 mr-2" type="submit"><i class="fa fa-cart-plus"></i></button>
                                    </div>
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
</div>