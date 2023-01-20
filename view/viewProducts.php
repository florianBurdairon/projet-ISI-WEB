<div class="d-flex d-sm-inline-flex w-100 flex-column flex-md-row">
    <div class="border-bottom border-right bg-white d-flex flex-column col-lg-2 col-md-3 d-inline-flex">
        <h2 class="mt-2">Nos offres</h2>
        <nav>
            <ul class="d-flex flex-row flex-md-column list-unstyled ml-4">
                <?php
                foreach($categories as $cat)
                {
                    $id = $cat->get_id();
                    $name = ucfirst("les ".$cat->get_name());
                    $path = ROOT."products/cat/".$id;
                    echo "<li class=\"m-1 mr-4 mr-md-1\"><a href='$path' class=\"li-offers\">$name</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>
    <div class="container-fluid w-100">
        <h1 class="mt-4 mb-3 ml-5"><i class="fa fa-shop"></i> Produits<?php if(isset($category)) echo(" - ".$category->get_name());?></h1>

        <div class="container d-flex flex-wrap justify-content-center">
            <?php
            // Itération sur les résultats de la requête SQL -> Produits
            if(isset($products)){
                foreach ($products as $product) {
                    $id = $product->get_id();
                    $link = ROOT."products/product/".$id;
                    $img = $product->get_image();
                    $name = $product->get_name();
                    $desc = $product->get_description();
                    $price =$product->get_price();
                    ?>

                    <div class="product-box col-12 col-md-5 d-flex flex-row align-items-center justify-content-between border rounded mb-4 mr-3 ml-3 pt-3 pb-3">
                        <a href="<?= $link ?>" class="product-box-clickable d-flex flex-column col-4 align-items-center">
                            <img class="product-img w-100 mb-2" src="<?= ROOT ?>assets/productimages/<?= $img ?>" alt="<?= $img ?>">
                            <h3><b><?= $price ?>€</b></h3>
                        </a>
                        <div class="d-flex flex-column align-items-center align-items-md-start">
                            <a  href="<?= $link ?>" class="product-box-clickable d-flex flex-column align-items-center align-items-md-start">
                                <h4><b><?= $name ?></b></h4>
                                <p class="text-md-left text-sm-center"><?= $desc ?></p>
                            </a>

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