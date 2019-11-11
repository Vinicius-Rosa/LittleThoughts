<?php

namespace App\site\controllers;

 if (!defined('URL')){
     header("location: /");
     exit();
 }

class Cadastro {
    private $dados;
    private $json;

    public function index() {

        $this->dados["includes"] = array(
                "styles" => array(
                    URL."assets/css/reset.css",
                    URL."assets/css/cadastro.css"),
                "scripts" => array(
                    URL."assets/js/jquery-3.4.1.min.js",
                    URL."assets/js/index.js",
                    URL."assets/js/util.js",
                    URL."assets/js/cadastro.js")
            );

        $carregarView = new \Config\ConfigView("cadastro/index", $this->dados);
        $carregarView->renderizar();
    }

    public function exeCadastroAjax(){

        if(!isset($_POST["login_user"])){
            header("Location: ".URL."login/index");
        }

        $this->dados["login_user"] = $_POST["login_user"];
        $this->dados["email_user"] = $_POST["email_user"];
        $this->dados["password_user"] = $_POST["password_user"];
        $this->dados["password_confirm"] = $_POST["password_confirm"];

        $this->json = array();
        $this->json["status"] = 1;
        $this->json["errorList"] = array();

        if($this->valData()){
            $insertUser = new \Site\models\helper\ModelsCreate();
            $insertUser->exeCreate("users", $this->dados);
            if(!$insertUser->getResult()){
                $this->json["status"] = 0;
                $this->json["errorList"]["error"] = "Ocorreu algum erro desconhecido!";
            }
        }
        echo json_encode($this->json);
    }

    private function valData(){
        if(empty($this->dados["login_user"]) or empty($this->dados["email_user"]) or empty($this->dados["password_user"]) or empty($this->dados["password_confirm"])){
            $this->json["errorList"]["error"] = "Favor, preencha todos os campos!";
            $this->json["status"] = 0;
            return false;
        }else{
            $getUsers = new \Site\models\User();
            $users = $getUsers->get_users();

            foreach ($users as $user){
                if($user["login_user"] == $this->dados["login_user"]){
                    $this->json["status"] = 0;
                    $this->json["errorList"]["error"] = "Este usuário já está em uso!";
                    return false;
                    break;
                }
                if($user["email_user"] == $this->dados["email_user"]){
                    $this->json["status"] = 0;
                    $this->json["errorList"]["error"] = "Este email já está em uso!";
                    return false;
                    break;
                }
            }

            if($this->dados["password_user"] != $this->dados["password_confirm"]){
                $this->json["status"] = 0;
                $this->json["errorList"]["error"] = "As senhas não conferem!";
                return false;
            }else{
                unset($this->dados["password_confirm"]);
                $this->dados["password_user"] = md5($this->dados["password_user"]);
            }
            return true;
        }
    }
}
