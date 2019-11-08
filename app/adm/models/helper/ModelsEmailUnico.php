<?php

namespace App\adm\models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ModelsEmailUnico{
    private $email;
    private $result;
    private $editarUnico;
    private $id;
            
    function getResult()
    {
        return $this->result;
    }
        
    public function valEmailUnico($email, $editarUnico = null, $id = null)
    {
        $this->email = (string) $email;
        $this->editarUnico = $editarUnico;
        $this->id = $id;
        $valEmailUnico = new \App\adm\models\helper\ModelsRead();
        if(!empty($this->editarUnico) AND ($this->editarUnico == true)){
            $valEmailUnico->exeReadEspecifico("SELECT id FROM user WHERE email =:email AND id <>:id LIMIT :limit", "email={$this->email}&limit=1&id={$this->id}");
        }else{
            $valEmailUnico->exeReadEspecifico("SELECT id FROM user WHERE email =:email LIMIT :limit", "email={$this->email}&limit=1");
        }        
        $this->result = $valEmailUnico->getResult();
        if (!empty($this->result)) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Este e-mail já está cadastrado!</div>";
            $this->result = false;
        } else {
            $this->result = true;
        }
    }
}
