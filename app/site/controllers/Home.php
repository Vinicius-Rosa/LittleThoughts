<?php

namespace App\site\controllers;

 if (!defined('URL')){
     header("location: /");
     exit();
 }

class Home {
    private $dados;

    public function index() {

    	if(!isset($_SESSION["id_user"])){
    		header("Location: ".URL."login/index");
    	}

    	$this->dados["includes"] = array(
                "styles" => array(
                    URL."assets/css/reset.css",
                    URL."assets/css/home.css"),
            );

        $carregarView = new \Config\ConfigView("home/index", $this->dados);
        $carregarView->renderizar();
    }
}
