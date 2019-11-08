<?php
    session_start();
    require "Conn.php";

    $limite = 1;

    // procurando o usuário
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    if (!empty($id)){
        $conectar = new Conn();
        $sql = "DELETE FROM `user` WHERE `id` = :id LIMIT :limit";
        $apagar = $conectar->getConn()->prepare($sql);
        $apagar->bindParam(":id", $id, PDO::PARAM_INT);
        $apagar->bindParam(":limit", $limite, PDO::PARAM_INT);

        if ($apagar->execute()){
            $_SESSION['msg'] = "<p style='color: green'>Registro apagado com sucesso</p>";
        }else{
            $_SESSION['msg'] = "<p style='color: red'>Registro não foi apagado com sucesso!</p>";
        }
    }else{
        $_SESSION['msg'] = "<p style='color: red'>Registro não informado ou não encontrado!</p>";
    }
    header("location: listarUser.php");
