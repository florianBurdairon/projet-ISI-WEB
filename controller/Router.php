<?php
require_once 'controller/AccountController.php';
require_once 'controller/HomeController.php';
require_once 'controller/ProductsController.php';
require_once 'controller/ShoppingcartController.php';
require_once 'controller/AdminController.php';
require_once 'view/view.php';

class Router
{
    private $ctrlHome;
    private $ctrlAccount;
    private $ctrlProducts;
    private $ctrlShoppingcart;
    private $ctrlAdmin;

    public function __construct()
    {
        $this->ctrlHome = new HomeController();
        $this->ctrlProducts = new ProductsController();
        $this->ctrlAccount = new AccountController();
        $this->ctrlShoppingcart = new ShoppingcartController();
        $this->ctrlAdmin = new AdminController();
    }

    // Traite une requête entrante
    public function routingRequest()
    {
        try {
            if (isset($_GET['controller']) && $_GET['controller'] != '') {
                if($_GET['controller'] != 'account') {
                    unset($_SESSION["error"]);
                    unset($_SESSION["autofill"]);
                }
                if ($_GET['controller'] == 'home') {
                    $this->ctrlHome->index();
                } 
                elseif ($_GET['controller'] == 'products') {
                    if(isset($_GET['action']) && $_GET['action'] != ""){
                        if($_GET['action'] == 'cat'){
                            $cat_id = null;
                            if(isset($_GET["id"]) && $_GET["id"] != ""){
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
                            else throw new Exception("Utilisateur déjà connecté");
                        }
                        elseif($_GET['action'] == 'login'){
                            if(!isset($_SESSION["user"])){
                                $this->ctrlAccount->login();
                            }
                            else throw new Exception("Utilisateur déjà connecté");
                        }
                        elseif($_GET['action'] == 'registerpage'){
                            if(!isset($_SESSION["user"])){
                                $this->ctrlAccount->registerpage();
                            }
                            else throw new Exception("Utilisateur déjà connecté");
                        }
                        elseif($_GET['action'] == 'register'){
                            if(!isset($_SESSION["user"])){
                                $this->ctrlAccount->register();
                            }
                            else throw new Exception("Utilisateur déjà connecté");
                        }
                        elseif($_GET['action'] == 'logout'){
                            if(isset($_SESSION["user"])){
                                $this->ctrlAccount->logout();
                            }
                            else throw new Exception("Aucun utilisateur connecté");
                        }
                        elseif($_GET['action'] == 'infos'){
                            if(isset($_SESSION["user"])){
                                $this->ctrlAccount->infos();
                            }
                            else throw new Exception("Aucun utilisateur connecté");
                        }
                        elseif($_GET['action'] == 'orders'){
                            if(isset($_SESSION["user"])){
                                if(isset($_GET["id"]) && $_GET["id"] != ""){
                                    $this->ctrlAccount->select_order_by_id($_GET["id"]);
                                }
                                else{
                                    $this->ctrlAccount->select_orders();
                                }
                            }
                            else throw new Exception("Aucun utilisateur connecté");
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
                        elseif($_GET['action'] == 'pay'){
                            if (isset($_GET['id']) && $_GET["id"] != "") {
                                if ($_GET['id'] == 'selectaddress'){
                                    $this->ctrlShoppingcart->select_address();
                                }
                                elseif ($_GET["id"] == "choiceaddress") {
                                    $this->ctrlShoppingcart->save_address();
                                }
                                elseif ($_GET["id"] == "paymentchoice") {
                                    $this->ctrlShoppingcart->payment_choice();
                                }
                                elseif ($_GET["id"] == "paypal" || $_GET["id"] == "check") {
                                    $this->ctrlShoppingcart->paypage();
                                }
                                elseif ($_GET["id"] == "paid"){
                                    $this->ctrlShoppingcart->paid();
                                }
                            }
                        }
                        elseif($_GET["action"] == 'generatepdf'){
                            if (isset($_GET["id"]) && $_GET["id"] != ""){
                                $this->ctrlShoppingcart->generate_pdf($_GET["id"]);
                            }
                        }
                    }
                    else
                        $this->ctrlShoppingcart->select();
                }
                elseif ($_GET['controller'] == 'admin') {
                    if(isset($_GET['action']) && $_GET['action'] != ""){
                        if($_GET['action'] == 'orders'){
                            if(isset($_SESSION["user"])){
                                if(isset($_GET["id"]) && $_GET["id"] != ""){
                                    $this->ctrlAdmin->select_order_by_id($_GET["id"]);
                                }
                                else{
                                    $this->ctrlAdmin->select_orders();
                                }
                            }
                            else throw new Exception("Aucun utilisateur connecté");
                        }
                        elseif($_GET['action'] == 'validate'){
                            if(isset($_SESSION["user"])){
                                if(isset($_GET["id"]) && $_GET["id"] != ""){
                                    $this->ctrlAdmin->validate($_GET["id"]);
                                }
                                else{
                                    $this->ctrlAdmin->select_orders();
                                }
                            }
                            else throw new Exception("Aucun utilisateur connecté");
                        }
                        else throw new Exception("Action non valide");
                    }
                    else{
                        $this->ctrlProducts->select();
                    }
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
