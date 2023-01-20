<?php
require_once 'model/category.php';
require_once 'view/view.php';

/**
 * Class HomeController
 * Manage the home of the website
 */
class HomeController
{
    public function index()
    {
        $categories = Category::select_categories();
        $view = new View("Home", "Accueil");
        $view->generate(array('categories' => $categories));
    }
}
