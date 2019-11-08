<?php
namespace App\site\models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Pagina{
    private $result;
    private $urlController;
    private $urlMetodo;

    public function listarPaginas($urlController = null, $urlMetodo = null){
        $this->urlController = (string) $urlController;
        $this->urlMetodo = (string) $urlMetodo;
        $listar = new \Site\models\helper\ModelsRead();
        $listar->exeReadEspecifico('SELECT pag.id_pag
                FROM page pag
                WHERE pag.controller =:controller AND pag.method =:metodo
                LIMIT :limit',
				"controller={$this->urlController}&metodo={$this->urlMetodo}&limit=1");

        $this->result = $listar->getResult();
        return $this->result;
    }
}

