<?php

class Conn
{
    public static $host = "127.0.0.1";
    public static $dbname = "projetobase_teste";
    public static $user = "root";
    public static $pass = "";
    public static $conexao = null;

    private static function conectar(){
        try{
            if (self::$conexao == null) {
                self::$conexao = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$dbname
                    .";charset=utf8", self::$user, self::$pass);
            }
        }catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
        return self::$conexao;
    }

    public function getConn(){
        return self::conectar();
    }
}