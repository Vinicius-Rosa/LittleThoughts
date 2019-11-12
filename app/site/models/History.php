<?php

namespace Site\models;

if (!defined('URL')){
    header("location: /");
    exit();
}

class History{

    private $tabela = "historys";
    private $result;

    public function get_user_historys(){

        $user = $_SESSION["id_user"];

        $listar = new \Site\models\helper\ModelsRead();

        $listar->exeReadEspecifico("SELECT *
                          FROM {$this->tabela}
                          WHERE user_history=:user
                          ORDER BY id_history DESC", "user=$user");
        $this->result['historys'] = $listar->getResult();
        return $this->result['historys'];
    }
}

