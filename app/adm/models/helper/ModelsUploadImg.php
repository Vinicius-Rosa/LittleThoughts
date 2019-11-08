<?php

namespace App\adm\models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ModelsUploadImg
{
    private $dadosImagem;
    private $diretorio;
    private $nomeImg;
    private $resultado;
    private $imagem;
            
    function getResult()
    {
        return $this->result;
    }

        public function uploadImagem(array $imagem, $diretorio, $nomeImg )
    {
        $this->dadosImagem = $imagem;
        $this->diretorio = $diretorio;
        $this->nomeImg = $nomeImg;
        $this->validarImagem();
    }
    
    private function validarImagem()
    {
        switch ($this->dadosImagem['type']){
            case 'image/jpeg';
            case 'image/pjpeg';
                $this->imagem = imagecreatefromjpeg($this->DadosImagem['tmp_name']);
                break;
            case 'image/png':
            case 'image/x-png';
                $this->imagem = imagecreatefrompng($this->DadosImagem['tmp_name']);
                break;
        }
        if($this->imagem){
            $this->valDiretorio();
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A extensão da imagem é inválida. Selecione um imagem JPEG ou PNG!</div>";
            $this->result = false;
        }
    }
    
    private function valDiretorio()
    {
        if(!file_exists($this->diretorio) && !is_dir($this->diretorio)){
            mkdir($this->diretorio, 0755);
        }
        $this->realizarUpload();
    }
    
    private function realizarUpload()
    {
        if(move_uploaded_file($this->dadosImagem['tmp_name'], $this->diretorio . $this->nomeImg)){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi realizar o upload da imagem!</div>";
            $this->result = false;
        }
    }
}
