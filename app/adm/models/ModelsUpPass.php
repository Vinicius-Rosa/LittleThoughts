<?php

namespace App\adm\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ModelsUpPass{

    private $dadosId;
    private $dados;
    private $result;
	private $tabela = "user";

    function getResult()
    {
        return $this->result;
    }

    public function valUsuario($dadosId)
    {
        $this->dadosId = (int) $dadosId;
        $validaUsuario = new \App\adm\Models\helper\ModelsRead();
        $validaUsuario->exeReadEspecifico("SELECT user.id FROM {$this->tabela} user                
                WHERE user.id =:id LIMIT :limit", "id=" . $this->dadosId ."&limit=1");
        $this->dadosUsuario = $validaUsuario->getResult();
        if (!empty($this->dadosUsuario)) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não encontrado!</div>";
            $this->result = false;
        }
    }

    public function editSenha(array $dados)
    {
        $this->dados = $dados;
        $valCampoVazio = new \App\adm\Models\helper\ModelsCampoVazio();
        $valCampoVazio->validarDados($this->dados);
        if ($valCampoVazio->getResult()) {
            $valSenha = new \App\adm\Models\helper\ModelsValSenha();
            $valSenha->valSenha($this->dados['senha']);
            if ($valSenha->getResult()) {
                $this->updateEditSenha();
            } else {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }
    
    private function updateEditSenha(){
        $this->valUsuario($this->dados['id']);
        if ($this->result) {
            $this->dados['senha'] = password_hash($this->dados['senha'], PASSWORD_DEFAULT);
            $this->dados['data_modificacao'] = date("Y-m-d H:i:s");
            $upAtualSenha = new \App\adm\Models\helper\ModelsUpdate();
            $upAtualSenha->exeUpdate($this->tabela, $this->dados, "WHERE id =:id", "id={$this->d['id']}");
            if ($upAtualSenha->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Senha atualizada com sucesso!</div>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A senha não foi atualizada!</div>";
                $this->result = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A senha não foi atualizada!</div>";
            $this->result = false;
        }
    }

}
