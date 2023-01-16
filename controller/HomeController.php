<?php
require_once 'model/category.php';
require_once 'view/view.php';

class HomeController
{
    public function index()
    {
        $categories = Category::select_categories();
        $view = new View("Home", "Accueil");
        $view->generate(array('categories' => $categories));
    }
}
