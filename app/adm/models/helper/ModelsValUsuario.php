<?php

namespace App\adm\models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ModelsValUsuario{

    private $usuario;
    private $result;
    private $editarUnico;
    private $id;

    function getResult()
    {
        return $this->result;
    }

    public function valUsuario($usuario, $editarUnico = null, $id = null)
    {
        $this->usuario = (string) $usuario;
        $this->editarUnico = $editarUnico;
        $this->id = $id;
        $valUsuario = new \App\adm\Models\helper\ModelsRead();
        if(!empty($this->editarUnico) AND ($this->editarUnico == true)){
            $valUsuario->exeReadEspecifico("SELECT id FROM user WHERE user =:usuario AND id <>:id LIMIT :limit", "usuario={$this->usuario}&limit=1&id={$this->id}");
        }else{
            $valUsuario->exeReadEspecifico("SELECT id FROM user WHERE user =:usuario LIMIT :limit", "usuario={$this->usuario}&limit=1");
        }        
        $this->result = $valUsuario->getResult();
        if (!empty($this->result)) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Este usuário já está cadastrado!</div>";
            $this->result = false;
        } else {
            $this->valCaracterUsuario();
        }
    }

    private function valCaracterUsuario()
    {
        if (stristr($this->usuario, "'")) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Caracter ( ' ) utilizado no usuário inválido!</div>";
            $this->result = false;
        } else {
            if (stristr($this->usuario, " ")) {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Proibido utilizar espaço em branco no usuário!</div>";
                $this->result = false;
            } else {
                $this->valTamUsuario();
            }
        }
    }

    private function valTamUsuario()
    {
        if ((strlen($this->usuario)) < 5) {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O usuário deve ter no mínimo 5 caracteres!</div>";
            $this->result = false;
        } else {
            $this->result = true;
        }
    }

}
