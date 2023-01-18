<?php

class View{
    private $file;
    private $title;
    private $action;

    public function __construct($action, $title)
    {
        $this->file = "view/view".$action.".php";
        $this->action = $action;
        $this->title = $title." - Web4shop";
    }

    public function generate($data)
    {
        if(!($this->action == "Login" || $this->action == "Register" || $this->action == "Error")){
            $uri_param = explode('/', $_SERVER['REQUEST_URI']);
            $newBackToPage = "";
            if(isset($_GET["controller"]) && $_GET["controller"] != ""){
                $newBackToPage .= $_GET["controller"];
                if(isset($_GET["action"]) && $_GET["action"] != ""){
                    $newBackToPage .= "/".$_GET["action"];
                    if(isset($_GET["id"]) && $_GET["id"] != "") $newBackToPage .= "/".$_GET["id"];
                } 
            }
            $_SESSION["backToPage"] = $newBackToPage;
        }
        $user = isset($_SESSION["user"]) ? unserialize($_SESSION["user"]) : null;
        $content = $this->generateFile($this->file, $data, $user);
        $view = $this->generateFile('view/layout.php', array('title' => $this->title, 'content' => $content, 'action' => $this->action), $user);
        echo $view;
    }

    public function generateFile($file, $data, $user)
    {
        if (file_exists($file))
        {
            extract($data);
            ob_start();

            require $file;

            return ob_get_clean();
        }
        else
        {
            throw new Exception("Fichier ".$file." non trouvé");
        }
    }
}