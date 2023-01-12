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
        $content = $this->generateFile($this->file, $data);
        $view = $this->generateFile('view/layout.php', array('title' => $this->title, 'content' => $content, 'action' => $this->action));
        echo $view;
    }

    public function generateFile($file, $data)
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
            throw new Exception("File ".$file." not found");
        }
    }
}