<?php
require_once 'controller/AccountController.php';
require_once 'controller/HomeController.php';
require_once 'controller/ProductsController.php';
require_once 'controller/ShoppingcartController.php';
require_once 'controller/AdminController.php';
require_once 'view/view.php';

/**
 * Class Router
 * Manage redirection and url comprehenshion
 * Switch between controllers depending on $_GET["controller"], $_GET["action"] et $_GET["id"]
 */
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
                    unset($_SESSION["autofill"]);
                }
                if($_GET['controller'] != 'account'){
                    if(($_GET["controller"] == "shoppingcart" && $_GET["action"] == "selectaddress"))
                        unset($_SESSION["error"]);
                }
                // We want to see home
                if ($_GET['controller'] == 'home') {
                    $this->ctrlHome->index();
                }
                // We do an action on products
                elseif ($_GET['controller'] == 'products' && !isset($_SESSION["admin"])) {
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
                        elseif ($_GET["action"] == 'product')
                        {
                            $id = null;
                            if(isset($_GET["id"]) && $_GET["id"] != ""){
                                $id = $_GET["id"];
                                $product = Product::select_product_by_id($id);
                                if ($product != null) {
                                    $this->ctrlProducts->select_by_id($id);
                                }
                                else throw new Exception("Produit non valide");
                            } 
                            else throw new Exception("Produit manquant");
                        }
                        else throw new Exception("Action non valide");
                    }
                    else{
                        $this->ctrlProducts->select();
                    }
                } 
                // We do an action on the account
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
                // We do an action on the shopping cart
                elseif ($_GET['controller'] == 'shoppingcart' && !isset($_SESSION["admin"])) {
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
                                elseif ($_GET["id"] == "usecustomeraddress") {
                                    $this->ctrlShoppingcart->use_customer_address();
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
                // We do an action with admin
                elseif ($_GET['controller'] == 'admin') {
                    if(isset($_SESSION["admin"])){
                        if(isset($_GET['action']) && $_GET['action'] != ""){
                            if($_GET['action'] == 'orders'){
                                if(isset($_GET["id"]) && $_GET["id"] != ""){
                                    $this->ctrlAdmin->select_order_by_id($_GET["id"]);
                                }
                                else{
                                    $this->ctrlAdmin->select_orders();
                                }
                            }
                            elseif($_GET['action'] == 'validate'){
                                if(isset($_GET["id"]) && $_GET["id"] != ""){
                                    $this->ctrlAdmin->validate($_GET["id"]);
                                }
                                else throw new Exception("Numéro de commande manquant");
                            }
                            elseif($_GET['action'] == 'logout'){
                                $this->ctrlAdmin->logout();
                            }
                            else throw new Exception("Action non valide");
                        }
                        else{
                            $this->ctrlProducts->select();
                        }
                    }
                    else throw new Exception("Vous n'êtes pas connectés ou vous n'avez pas la permission d'accéder à cette page");
                }
                else if (isset($_SESSION["admin"]))
                {
                    $this->ctrlHome->index();
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
