<?php

namespace App\site\controllers;

 if (!defined('URL')){
     header("location: /");
     exit();
 }

class Login {
    private $dados;

    public function index() {

        $this->dados["includes"] = array(
                "styles" => array(
                    URL."assets/css/reset.css",
                    URL."assets/css/index.css"),
                "scripts" => array(
                    URL."assets/js/jquery-3.4.1.min.js",
                    URL."assets/js/index.js",
                    URL."assets/js/util.js",
                    URL."assets/js/login.js")
            );

        $carregarView = new \Config\ConfigView("login/index", $this->dados);
        $carregarView->renderizar();
    }

    public function exeLoginAjax(){
        $user = $_POST["login"];
        $password = $_POST["password"];

        $json = array();
        $json["status"] = 1;
        $json["errorList"] = array();

        if(empty($user)){
            $json["status"] = 0;
            $json["errorList"]["error"] = "Usuário não pode ser nulo!";
        }else{
            $getUserData = new \Site\models\User();
            $userData = $getUserData->get_user_data($user);
            if($userData){
                if(md5($password) == $userData[0]["password_user"]){
                    $_SESSION["id_user"] = $userData[0]["id_user"];
                    $_SESSION["password_user"] = $userData[0]["password_user"];
                    $_SESSION["login_user"] = $userData[0]["login_user"];
                    $_SESSION["email_user"] = $userData[0]["email_user"];
                }else{
                    $json["status"] = 0;
                    $json["errorList"]["error"] = "Usuário ou senha incorretos!";
                }
            }else{
                $json["status"] = 0;
                $json["errorList"]["error"] = "Usuário ou senha incorretos!";
            }
        }
        echo json_encode($json);
    }

    public function logout(){
        session_unset();
        header("Location: ".URL."login/index");
    }
}
