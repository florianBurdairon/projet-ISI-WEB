<?php
require_once 'model/category.php';
require_once 'model/product.php';
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
}