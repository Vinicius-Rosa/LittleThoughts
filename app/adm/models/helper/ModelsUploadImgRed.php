<?php

namespace App\adm\models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ModelsUploadImgRed{
    private $dadosImagem;
    private $diretorio;
    private $nomeImg;
    private $result;
    private $imagem;
    private $largura;
    private $altura;
    private $imgRedimens;
            
    function getResult()
    {
        return $this->result;
    }

        public function uploadImagem(array $imagem, $diretorio, $nomeImg, $largura, $altura )
    {
        $this->dadosImagem = $imagem;
        $this->diretorio = $diretorio;
        $this->nomeImg = $nomeImg;
        $this->largura = $largura;
        $this->altura = $altura;
        $this->validarImagem();
        if($this->imagem){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A extensão da imagem é inválida. Selecione um imagem JPEG ou PNG!</div>";
            $this->result = false;
        }
    }
    
    private function validarImagem()
    {
        switch ($this->dadosImagem['type']){
            case 'image/jpeg';
            case 'image/pjpeg';
                $this->imagem = imagecreatefromjpeg($this->dadosImagem['tmp_name']);
                $this->redimensImg();
                $this->valDiretorio();
                imagejpeg($this->imgRedimens, $this->diretorio . $this->nomeImg);
                break;
            case 'image/png':
            case 'image/x-png';
                $this->Imagem = imagecreatefrompng($this->dadosImagem['tmp_name']);
                $this->redimensImg();
                $this->valDiretorio();
                imagepng($this->imgRedimens, $this->diretorio . $this->nomeImg);
                break;
        }
    }
    
    private function valDiretorio()
    {
        if(!file_exists($this->diretorio) && !is_dir($this->diretorio)){
            mkdir($this->diretorio, 0755);
        }
    }
    
    private function redimensImg()
    {
        $largura_original = imagesx($this->imagem);
        $altura_original = imagesy($this->imagem);
        
        $this->imgRedimens = imagecreatetruecolor($this->largura, $this->altura);
        
        imagecopyresampled($this->imgRedimens, $this->imagem, 0, 0, 0, 0, $this->largura, $this->altura, $largura_original, $altura_original);
    }
}
