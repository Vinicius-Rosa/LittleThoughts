<?php

namespace App\adm\models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class User{

    private $result;
    private $limiteResultado = 40;
    private $id;
    private $dados;

    
    public function listarUsuario(){
        $listarUsuario = new \App\adm\Models\helper\ModelsRead();
        $listarUsuario->exeReadEspecifico("SELECT user.id, user.nome, user.email,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM user 
                INNER JOIN adm_situacao sit ON sit.id=user.adm_situacao_id
                INNER JOIN adm_cor cr ON cr.id=sit.adm_cor_id
                INNER JOIN adm_niveis_acesso nivac ON nivac.id=user.adm_niveis_acesso_id
                WHERE nivac.ordem >=:ordem
                ORDER BY id DESC LIMIT :limit", "ordem=".$_SESSION['ordem_nivac']."&limit={$this->limiteResultado}");
        $this->result = $listarUsuario->getResult();
        return $this->result;
    }

    public function verUsuario($id){
        $this->id = (int) $id;
        $verPerfil = new \App\adm\Models\helper\ModelsRead();
        $verPerfil->exeReadEspecifico("SELECT user.*,
                nivac.nome nome_nivac,
                sit.nome nome_sit,
                cr.cor cor_cr
                FROM user
                INNER JOIN adm_niveis_acesso nivac ON nivac.id=user.adm_niveis_acesso_id
                INNER JOIN adm_situacao sit ON sit.id=user.adm_situacao_id
                INNER JOIN adm_cor cr ON cr.id=sit.adm_cor_id
                WHERE user.id =:id AND nivac.ordem >=:ordem LIMIT :limit", "id=".$this->id."&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->result= $verPerfil->getResult();
        return $this->result;
    }

    function getResult()
    {
        return $this->result;
    }

    public function confirmarUser(){
        $verUsuario = new \App\adm\Models\helper\ModelsRead();
        $verUsuario->exeReadEspecifico("SELECT user.imagem FROM user
                INNER JOIN adm_niveis_acesso nivac ON nivac.id=user.adm_niveis_acesso_id
                WHERE user.id =:id AND nivac.ordem >=:ordem LIMIT :limit", "id=" . $this->id . "&ordem=" . $_SESSION['ordem_nivac'] . "&limit=1");
        $this->dados = $verUsuario->getResult();
    }

    public function apagarUsuario($id = null)
    {
        $this->id = (int) $id;
        $this->confirmarUser();
        if ($this->dados) {
            $apagarUsuario = new \App\adm\Models\helper\ModelsDelete();
            $apagarUsuario->exeDelete("user", "WHERE id =:id", "id={$this->id}");
            if ($apagarUsuario->getResult()) {
                $apagarImg = new \App\adm\Models\helper\ModelsDelete();
                $apagarImg->apagarImg('assets/img/usuario/' . $this->id . '/' . $this->dados[0]['imagem'], 'assets/img/usuario/' . $this->id);
                $_SESSION['msg'] = "<div class='alert alert-success'>Usuário excluído com sucesso!</div>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não foi apagado!</div>";
                $this->result = false;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não foi apagado!</div>";
            $this->result = false;
        }
    }


    public function cadUsuario(array $dados)
    {
        $this->dados = $dados;
        //var_dump($this->Dados);
        $this->foto = $this->dados['imagem_nova'];
        unset($this->dados['imagem_nova']);

        $valCampoVazio = new \App\adm\models\helper\ModelsCampoVazio();
        $valCampoVazio->validarDados($this->dados);

        if ($valCampoVazio->getResult()) {
            $this->valCampos();
        } else {
            $this->result = false;
        }
    }

    private function valCampos()
    {
        $valEmail = new \App\adm\models\helper\ModelsEmail();
        $valEmail->valEmail($this->dados['email']);

        $valEmailUnico = new \App\adm\Models\helper\ModelsEmailUnico();
        $valEmailUnico->valEmailUnico($this->dados['email']);

        $valUsuario = new \App\adm\models\helper\ModelsValUsuario();
        $valUsuario->valUsuario($this->dados['user']);

        $valSenha = new \App\adm\models\helper\ModelsValSenha();
        $valSenha->valSenha($this->dados['senha']);

        if (($valSenha->getResult()) AND ( $valUsuario->getResult()) AND ( $valEmailUnico->getResult()) AND ( $valEmail->getResult())) {
            $this->inserirUsuario();
        } else {
            $this->result = false;
        }
    }

    private function inserirUsuario()
    {
        $this->dados['senha'] = password_hash($this->dados['senha'], PASSWORD_DEFAULT);
        $this->dados['data_criacao'] = date("Y-m-d H:i:s");
        $slugImg = new \App\adm\Models\helper\ModelsSlug(); 
        $this->dados['imagem'] = $slugImg->nomeSlug($this->foto['name']);

        $cadUsuario = new \App\adm\models\helper\ModelsCreate();
        //var_dump($this->dados);
        //exit;
        $cadUsuario->exeCreate("user", $this->dados);
        if ($cadUsuario->getResult()) {
            if (empty($this->foto['name'])) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
                $this->result = true;
            } else {
                $this->dados['id'] = $cadUsuario->getResult();
                $this->valFoto();
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O usuario não foi cadastrado!</div>";
            $this->result = false;
        }
    }

    private function valFoto()
    {
        $uploadImg = new \App\adm\models\helper\ModelsUploadImgRed();
        $uploadImg->uploadImagem($this->foto, 'assets/img/usuario/' . $this->dados['id'] . '/', $this->dados['imagem'], 150, 150);
        if ($uploadImg->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O usuario não foi cadastrado!</div>";
            $this->result = false;
        }
    }

    public function listarCadastrar()
    {
        $listar = new \App\adm\models\helper\ModelsRead();
        $listar->exeReadEspecifico("SELECT id id_nivac, nome nome_nivac FROM adm_niveis_acesso WHERE ordem >=:ordem ORDER BY nome ASC",
            "ordem=" . $_SESSION['ordem_nivac']);

        $registro['nivac'] = $listar->getResult();

        $listar->exeReadEspecifico("SELECT id id_sit, nome nome_sit FROM adm_situacao ORDER BY nome ASC");
        $registro['sit'] = $listar->getResult();

        $this->result = ['nivac' => $registro['nivac'], 'sit' => $registro['sit']];

        return $this->result;
    }

    public function verFormCadUsuario()
    {
        $verFormCadUsuario = new \App\adm\models\helper\ModelsRead();
        $verFormCadUsuario->exeReadEspecifico("SELECT * FROM user
                WHERE id =:id LIMIT :limit", "id=1&limit=1");
        $this->result = $verFormCadUsuario->getResult();
        return $this->result;
    }

    public function altUsuario(array $dados)
    {
        $this->dados = $dados;
        //var_dump($this->Dados);
        $this->foto = $this->dados['imagem_nova'];
        $this->imgAntiga = $this->dados['imagem_antiga'];
        unset($this->dados['imagem_nova'], $this->dados['imagem_antiga']);

        $valCampoVazio = new \App\adm\models\helper\ModelsCampoVazio();
        $valCampoVazio->validarDados($this->dados);

        if ($valCampoVazio->getResult()) {
            $this->valCamposAlterar();
        } else {
            $this->result = false;
        }
    }

    private function valCamposAlterar()
    {
        $valEmail = new \App\adm\models\helper\ModelsEmail();
        $valEmail->valEmail($this->dados['email']);

        $valEmailUnico = new \App\adm\models\helper\ModelsEmailUnico();
        $editarUnico = true;
        $valEmailUnico->valEmailUnico($this->dados['email'], $editarUnico, $this->dados['id']);

        $valUsuario = new \App\adm\models\helper\ModelsValUsuario();
        $valUsuario->valUsuario($this->dados['user'], $editarUnico, $this->dados['id']);

        $valSenha = new \App\adm\models\helper\ModelsValSenha();
        $valSenha->valSenha($this->dados['senha']);

        if (($valSenha->getResult()) AND ( $valUsuario->getResult()) AND ( $valEmailUnico->getResult()) AND ( $valEmail->getResult())) {
            $this->valFotoAlterar();
        } else {
            $this->result = false;
        }
    }

    private function valFotoAlterar()
    {
        if (empty($this->foto['name'])) {
            $this->updateEditUsuario();
        } else {
            $slugImg = new \App\adm\models\helper\ModelsSlug();
            $this->dados['imagem'] = $slugImg->nomeSlug($this->foto['name']);

            $uploadImg = new \App\adm\models\helper\ModelsUploadImgRed();
            $uploadImg->uploadImagem($this->foto, 'assets/img/usuario/' . $this->dados['id'] . '/', $this->dados['imagem'], 150, 150);
            if ($uploadImg->getResult()) {
                $apagarImg = new \App\adm\models\helper\ModelsApagarImg();
                $apagarImg->apagarImg('assets/img/usuario/' . $this->dados['id'] . '/' . $this->imgAntiga);
                $this->updateEditUsuario();
            } else { 
                $this->result = false;
            }
        }
    }

    private function updateEditUsuario()
    {
        $this->dados['data_modificacao'] = date("Y-m-d H:i:s");
        $upAltSenha = new \App\adm\Models\helper\ModelsUpdate();
        $upAltSenha->exeUpdate("user", $this->dados, "WHERE id =:id", "id=" . $this->dados['id']);
        if ($upAltSenha->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Usuário atualizado com sucesso!</div>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O usuario não foi atualizado!</div>";
            $this->result = false;
        }
    }


}
