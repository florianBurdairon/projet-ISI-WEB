<?php
require_once 'model/category.php';
require_once 'model/product.php';
require_once 'model/review.php';
require_once 'view/view.php';

class ProductsController
{
    public function select()
    {
        $category = null;
        $products = Product::select_products();
        $categories = Category::select_categories();
        $view = new View("Products", "Produits");
        $view->generate(array('categories' => $categories, 'category' => $category, 'products' => $products));
    }

    public function select_by_cat($category)
    {
        $products = null;
        $products = Product::select_products_by_category($category);
        $categories = Category::select_categories();
        $view = new View("Products", "Produits");
        $view->generate(array('categories' => $categories, 'category' => $category, 'products' => $products));
    }

    public function select_by_id($id)
    {
        $param = array();
        $param["categories"] = Category::select_categories();
        $param["product"] = Product::select_product_by_id($id);
        $param["reviews"] = Review::select_reviews_by_product_id($id);

        $view = new View("Product", "Produit");
        $view->generate($param);
    }
}