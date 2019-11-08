<?php
    namespace Config;

    Class ConfigController{
        private $url;
        private $urlConjunto;
        private $urlController;
        private $urlMetodo;
        private static $formato;
        private $class;
        private $paginas;

        public function __construct(){
            if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))){
                $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
                $this->clearUrl(); // limpa a url
                // SEPARA OS VALORES EM ARRAY
                $this->urlConjunto = explode("/", $this->url);

                // tratar o controller
                if (isset($this->urlConjunto[0])){
                    $this->urlController = $this->prepararController($this->urlConjunto[0]);
                }else{
                    $this->urlController = CONTROLLER;
                }

                // tratar o método
                if (isset($this->urlConjunto[1])){
                    $this->urlMetodo = $this->urlConjunto[1];
                }else{
                    $this->urlMetodo = "index";
                }

                // Trata o parâmetro
                if (isset($this->urlConjunto[2])){
                    $this->urlParametro = $this->urlConjunto[2];
                }else{
                    $this->urlParametro = null;
                }
            }else{
                $this->urlController = CONTROLLER;
                $this->urlMetodo = METHOD;
                $this->urlParametro = null;
            }
            /*echo "<br/>Controller: " .$this->urlController ."<br />Método: " .$this->urlMetodo
                ."<br />Parametro: " .$this->urlParametro;
				exit;
            $senha = password_hash("123456", PASSWORD_DEFAULT);			
			echo "Senha: ".$senha ."<br />";
			exit;*/
            /*
            echo "Confirmacao: " . md5($senha . date('Y-m-d H:i')) ."<br />";
            echo "Data: " .date('Y-m-d H:i:s') ."<br />";*/			


        }

        public function carregar(){
            $listarPg = new \App\site\models\Pagina();
            $this->paginas = $listarPg->listarPaginas($this->urlController, $this->urlMetodo);
            if ($this->paginas) {
                $this->class = "\\App\\site\\controllers\\" . $this->urlController;
                if (class_exists($this->class)) {
                    $this->carregarMetodo();
                } else {
                    $this->urlController = ERROR404;
                    $this->carregar();
                }
            }else {
                $this->urlController = ERROR404;
                $this->urlMetodo = "index";
                $this->carregar();
            }
        }

        private function clearUrl(){
            // elimina as tags
            $this->url = strip_tags($this->url);
            // elimina espaços
            $this->url = trim($this->url);
            // elimina barra no final
            $this->url = rtrim($this->url, "/");

            self::$formato = array();
            self::$formato['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
            self::$formato['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr--------------------------------';
            $this->url = strtr(utf8_decode($this->url), utf8_decode(self::$formato['a']), self::$formato['b']);
        }

        public function prepararController($urlController){
            //$urlController = strtolower($urlController);
            //$urlController = explode("-", $urlController);
            //$urlController = implode(" ", $urlController);
            //$urlController = ucwords($urlController);
            //$urlController = str_replace(" ", "", $urlController);
            $urlController = str_replace(" ", "", ucwords(implode(" ", explode("-", strtolower($urlController)))));
            return $urlController;
        }

        private function carregarMetodo(){
            $classLoad = new $this->class;
            if (method_exists($classLoad, $this->urlMetodo)) {
                if ($this->urlParametro !== null) {
                    $classLoad->{$this->urlMetodo}($this->urlParametro);
                } else {
                    $classLoad->{$this->urlMetodo}();
                }
            }else{
                $this->urlController = CONTROLLER;
                $this->urlMetodo = METHOD;
                $this->carregar();
            }
        }
    }
