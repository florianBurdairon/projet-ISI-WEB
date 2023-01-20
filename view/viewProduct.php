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
        <h1 class="mt-4 mb-3 ml-5"><i class="fa fa-shop"></i> Produit</h1>

        <div class="container d-flex flex-wrap justify-content-center">
            <?php
            // Itération sur les résultats de la requête SQL -> Produits
            if(isset($product)){
                $id = $product->get_id();
                $img = $product->get_image();
                $name = $product->get_name();
                $desc = $product->get_description();
                $price =$product->get_price();
                ?>

                <div class="product-box col-12 col-md-5 d-flex flex-row align-items-center justify-content-between border rounded mb-4 mr-3 ml-3 pt-3 pb-3">
                    <div class="d-flex flex-column col-4 align-items-center">
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
            ?>
        </div>

        <hr class="hr mt-5" />

        <div class="mb-3 mt-3 d-flex justify-content-center">
            <h2>Commentaires</h2>
        </div>

        <div class="container d-flex flex-wrap justify-content-center">
            <?php
            if (isset($reviews)){
                foreach ($reviews as $review) {
                    ?>
                    <div class="review-box col-10 col-md-5 d-flex flex-column border rounded p-3 m-3">
                        <div class="d-flex flex-row justify-content-between">
                            <h4> <?= $review->get_title() ?></h4>
                            <p><i class="fa fa-star"></i> <?= $review->get_stars() ?>/5</p>
                        </div>
                        <div class="d-flex flex-column">
                            <h5 class="ml-4"><?= $review->get_name_user() ?></h5>
                            <p><?= $review->get_description() ?></p>
                        </div>
                    </div>

                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>