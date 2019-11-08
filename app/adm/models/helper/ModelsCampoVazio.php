<?php

namespace App\adm\models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ModelsCampoVazio
{

    private $dados;
    private $result;
    
    function getResult()
    {
        return $this->result;
    }

    
    public function validarDados(array $dados)
    {
        $this->dados = $dados;
        $this->dados = array_map('strip_tags', $this->dados);
        $this->dados = array_map('trim', $this->dados);
        if (in_array('', $this->dados)) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário preencher todos os campos!</div>";
            $this->result = false;
        } else {
            $this->result = true;
        }
    }

}
