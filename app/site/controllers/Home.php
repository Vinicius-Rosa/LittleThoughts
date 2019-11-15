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
                "scripts" => array(
                    URL."assets/js/jquery-3.4.1.min.js",
                    "//cdn.ckeditor.com/4.13.0/standard/ckeditor.js",
                    URL."assets/js/loading.js",
                    URL."assets/js/readmore.js",
                    URL."assets/js/util.js",
                    URL."assets/js/home.js")
            );

        $listar = new \Site\models\History();
        $this->dados["historys"] = $listar->get_user_historys();

        $carregarView = new \Config\ConfigView("home/index", $this->dados);
        $carregarView->renderizar();
    }

    public function addHistoryAjax() {
        $text = $_POST["codigo"];

        $json["error"] = 1;

        $this->dados["user_history"] = $_SESSION["id_user"];
        $this->dados["codigo_fonte"] = $text;
        $this->dados["data_criacao"] = date("Y-m-d H-i:s");

        $inserir = new \Site\models\helper\ModelsCreate();
        $inserir->exeCreate("historys", $this->dados);

        $listar = new \Site\models\History();
        $json["historys"] = $listar->get_user_historys();

        $json["qtd"] = count($json["historys"]);


        if(!$inserir->getResult()){
            $json["error"] = 0;
        }

       echo json_encode($json);

    }
}
