<?php
require_once 'controller/AccountController.php';
require_once 'controller/HomeController.php';
require_once 'controller/ProductsController.php';
require_once 'controller/ShoppingcartController.php';
require_once 'view/view.php';

class Router
{
    private $ctrlHome;
    private $ctrlAccount;
    private $ctrlProducts;
    private $ctrlShoppingcart;

    public function __construct()
    {
        $this->ctrlHome = new HomeController();
        $this->ctrlProducts = new ProductsController();
        $this->ctrlAccount = new AccountController();
        $this->ctrlShoppingcart = new ShoppingcartController();
    }

    // Traite une requête entrante
    public function routingRequest()
    {
        try {
            if (isset($_GET['controller']) && $_GET['controller'] != '') {
                if ($_GET['controller'] == 'home') {
                    $this->ctrlHome->index();
                } 
                elseif ($_GET['controller'] == 'products') {
                    if(isset($_GET['action']) && $_GET['action'] != ""){
                        if($_GET['action'] == 'cat'){
                            $cat_id = null;
                            if(isset($_GET["id"])){
                                $cat_id = $_GET["id"];
                                $category = Category::select_category_by_id($cat_id);
                                if($category != null){
                                    $this->ctrlProducts->select_by_cat($category);
                                }
                                else throw new Exception("Catégorie non valide");
                            } 
                            else throw new Exception("Catégorie manquante");
                        }
                        else throw new Exception("Action non valide");
                    }
                    else{
                        $this->ctrlProducts->select();
                    }
                } 
                elseif ($_GET['controller'] == 'account') {
                    if(isset($_GET['action']) && $_GET['action'] != ""){
                        if($_GET['action'] == 'loginpage'){
                            if(!isset($_SESSION["user"])){
                                $this->ctrlAccount->loginpage();
                            }
                            else throw new Exception("Action non valide");
                        }
                        elseif($_GET['action'] == 'login'){
                            if(!isset($_SESSION["user"])){
                                $this->ctrlAccount->login();
                            }
                            else throw new Exception("Action non valide");
                        }
                        elseif($_GET['action'] == 'logout'){
                            if(isset($_SESSION["user"])){
                                $this->ctrlAccount->logout();
                            }
                            else throw new Exception("Action non valide");
                        }
                        else throw new Exception("Action non valide");
                    }
                    else throw new Exception("Action non valide");
                } 
                elseif ($_GET['controller'] == 'shoppingcart') {
                    if (isset($_GET['action']) && $_GET['action'] != "")
                    {
                        if ($_GET['action'] == 'insert'){
                            $this->ctrlShoppingcart->insert();
                        }
                        elseif($_GET['action'] == 'delete'){
                            $this->ctrlShoppingcart->delete();
                        }
                    }
                    else
                        $this->ctrlShoppingcart->select();
                }
                else throw new Exception("Action non valide");
            } else {
                // aucune action définie : affichage de l'accueil
                $this->ctrlHome->index();
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    // Affiche une erreur
    private function error($msgError)
    {
        $view = new View("Error", "Erreur");
        $view->generate(array('msgError' => $msgError));
    }
}
