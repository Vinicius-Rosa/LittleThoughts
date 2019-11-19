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

    public function get_last_history(){

        $listar = new \Site\models\helper\ModelsRead();

        $listar->exeReadEspecifico("SELECT *
                          FROM {$this->tabela}
                          ORDER BY id_history DESC LIMIT :limit", "limit=1");
        $this->result['history'] = $listar->getResult();
        return $this->result['history'];
    }

    public function get_histories_month($month){
        $user = $_SESSION["id_user"];
        $mes = $month;

        $listar = new \Site\models\helper\ModelsRead();

        $listar->exeReadEspecifico("SELECT *
                          FROM {$this->tabela}
                          WHERE user_history=:user
                            AND month(data_criacao)=:mes
                          ORDER BY id_history DESC", "user=$user&mes=$mes");
        $this->result['histories'] = $listar->getResult();
        return $this->result['histories'];
    }
}

