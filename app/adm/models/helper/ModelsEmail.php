<?php

namespace App\adm\models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ModelsEmail{
    private $result;
    private $dados;
    private $formato;
    
    function getResult()
    {
        return $this->result;
    }

        
    public function valEmail($email)
    {
        $this->dados = (string) $email;
        $this->formato = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';
        
        if(preg_match($this->formato, $this->dados)){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: E-mail inválido!</div>";
            $this->result = false;
        }
    }
}
