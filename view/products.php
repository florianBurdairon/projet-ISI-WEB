<?php 
    include "components/head.php";
    include "components/header.php";
?>
<div class="d-sm-inline-flex d-flex" id="wrapper">
    <?php include "components/aside.php";?>
    <div><!-- class="col-lg-8 col-md-7 col-sm-6 col-xs-5" id="page-content-wrapper">-->
        <div class="container-fluid">
            <h1 class="mt-4">Produits<?php if(isset($category)) echo(" - ".$category);?></h1>
            <?php
            //echo var_dump($_SESSION["shoppingcart"]["products"]);
            // Itération sur les résultats de la requête SQL -> Produits
            if(isset($products)){
                foreach ($products as $product) {
                    $id = $product['id'];
                    $img = $product['image'];
                    $name = $product['name'];
                    $desc = $product['description'];
                    $price =$product['price'];
                    ?>

                    <!-- HTML -->

                    <div class="d-flex flex-column flex-lg-row flex-md-row flex-sm-column align-items-center border rounded mb-5">
                        <div class="border-end bg-white col-5 col-lg-3 col-md-4 col-sm-5 m-2">
                            <img class="rounded-circle w-100" src="view/productimages/<?php echo $img ?>" alt="<?php echo $img ?>">
                        </div>
                        <div class="d-flex flex-column align-items-center align-items-md-start align-items-lg-start">
                            <h3><?php echo $name ?></h3>
                            <p class="text-md-left text-sm-center"><?php echo $desc ?></p>
                            <p>Prix : <?php echo $price ?>€</p>
                            <p class="font-italic">
                                <?php
                                if (isset($_SESSION["shoppingcart"]))
                                {
                                    if (isset($_SESSION["shoppingcart"]["products"][$id]))
                                    {
                                        echo "Ce produit est déjà présent ".$_SESSION["shoppingcart"]["products"][$id]["quantity"]." fois dans votre panier.";
                                    }
                                }
                                ?>
                            </p>
                            <form class="d-flex flex-column align-items-center" method="post" action="shoppingcart.php">
                                <input type="hidden" name="operation" value="add">
                                <input type="hidden" name="product_id" value="<?php echo $id ?>">
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
<?php include "components/footer.php"; ?>