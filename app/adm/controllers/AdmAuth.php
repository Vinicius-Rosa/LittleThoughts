<?php

namespace App\adm\controllers;

if (!defined('URL')){
    header("location: /");
    exit();
}

class AdmAuth {
    private $dados;

    public function auth() {
        $this->dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($this->dados['sendLogin'])) {
            unset($this->dados['sendLogin']);
            //var_dump($this->dados);
            $login = new \App\adm\models\Auth();
            $login->autenticar($this->dados);
            if ($login->getResult()) {
                $urlDestino = URL . 'adm-home/index';
                header("Location: $urlDestino");
            }else {
                $_SESSION['msg'] = $login->getMsg();
                $this->dados['formRetorno'] = $this->dados;
            }
        }

        $carregarView = new \Config\ConfigView("auth/login", $this->dados);
        $carregarView->renderizarAuth();
    }

    public function logout() {
        $_SESSION['msg'] = "
                <div class='alert alert-primary' role='alert'>
                  Usuário {$_SESSION['user_nome']} deslogado com sucesso!
                </div>
                        ";
        unset($_SESSION['user_id'], $_SESSION['user_nome'], $_SESSION['user_email'],
            $_SESSION['user_imagem'], $_SESSION['adm_niveis_acesso_id'], $_SESSION['ordem_nivac']);

        $urlDestino = URL . 'adm-auth/auth';
        header("Location: $urlDestino");
    }
}
