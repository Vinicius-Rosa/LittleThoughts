<?php

namespace App\adm\models;

if (!defined('URL')){
    header("location: /");
    exit();
}

class Auth {

    private $dados;
    private $result;
    private $msg;
    private $rowCount;

    public function autenticar(array $dados) {
        $this->dados = $dados;
        $this->validar();
        if ($this->result){
            $validarAcesso = new \App\adm\models\helper\ModelsRead();
            $validarAcesso->exeReadEspecifico("SELECT user.id, user.data_criacao, user.nome, user.email, user.senha, user.imagem, 
                    user.adm_niveis_acesso_id,
                    nivac.ordem	ordem_nivac
                    FROM user
                    INNER JOIN adm_niveis_acesso nivac ON nivac.id=user.adm_niveis_acesso_id
                    WHERE user =:usuario LIMIT :limit", "usuario={$this->dados['user']}&limit=1");
            $this->result = $validarAcesso->getResult();
            if ($validarAcesso->getRowCount() == 1) {
                //var_dump($Visulizar->getResultado());
                $this->validarSenha();
            }else {
                $this->result = false;
                $this->msg = "
                        <div class='alert alert-danger' role='alert'>
                          Login e/ou senhas incorretos!
                        </div>
                        ";
            }
        }
    }

    public function validar(){
        $this->dados = array_map('strip_tags', $this->dados);
        $this->dados = array_map('trim', $this->dados);
        if (in_array('', $this->dados)){
            $this->result = false;
            $this->msg = "
                        <div class='alert alert-danger' role='alert'>
                          Login e/ou senhas incorretos!
                        </div>
                        ";
        }else{
            $this->result = true;
        }
    }

    private function validarSenha(){
        if (password_verify($this->dados['senha'], $this->result[0]['senha'])) {
			$_SESSION['user_data_criacao'] = $this->result[0]['data_criacao'];
			$_SESSION['user_id'] = $this->result[0]['id'];
            $_SESSION['user_nome'] = $this->result[0]['nome'];
            $_SESSION['user_email'] = $this->result[0]['email'];
            $_SESSION['user_imagem'] = $this->result[0]['imagem'];
            $_SESSION['adm_niveis_acesso_id'] = $this->result[0]['adm_niveis_acesso_id'];
            $_SESSION['ordem_nivac'] = $this->result[0]['ordem_nivac'];
            $this->result = true;
        } else {
            $this->msg = "<div class='alert alert-danger'>Erro: Usuário ou a senha incorreto!</div>";
            $this->result = false;
        }
    }

    function getResult() {
        return $this->result;
    }

    function getMsg() {
        return $this->msg;
    }

    function getRowCount() {
        return $this->rowCount;
    }

}
