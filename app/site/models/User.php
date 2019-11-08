<?php

namespace Site\models;

if (!defined('URL')){
    header("location: /");
    exit();
}

class User{

    private $tabela = "users";
    private $result;

    public function get_user_data($login){

        $listar = new \Site\models\helper\ModelsRead();

        $listar->exeReadEspecifico("SELECT *
                          FROM {$this->tabela}
                          WHERE login_user=:login", "login=$login");
        $this->result['user'] = $listar->getResult();
        return $this->result['user'];
    }

    public function get_users(){

        $listar = new \Site\models\helper\ModelsRead();

        $listar->exeReadEspecifico("SELECT *
                          FROM {$this->tabela}");
        $this->result['users'] = $listar->getResult();
        return $this->result['users'];
    }
}

