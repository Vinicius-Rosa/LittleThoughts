<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>:: Usuário ::</title>
</head>
<body>
<?php

    include "Conn.php";
    $conectar = new Conn();
    //$conectar->getConn();

    $tabela = "user";
    $nome = "João das Couves";
    $email = "joao@gmail.com";
    $senha = "123";


    $sql = "INSERT INTO {$tabela} 
              (`nome`, `email`, `senha`, `data_criacao`) VALUES
               (:nome,:email,MD5(:senha),NOW())";
    $cadastrar = $conectar->getConn()->prepare($sql);

    $cadastrar->bindParam(":nome", $nome, PDO::PARAM_STR);
    $cadastrar->bindParam(":email", $email, PDO::PARAM_STR);
    $cadastrar->bindParam(":senha", $senha, PDO::PARAM_STR);

    $cadastrar->execute();

    if ($cadastrar->rowCount())
        echo "Cadastrado com sucesso!";
    else
        echo "ERROR: " .$cadastrar->errorInfo()[2];

?>

</body>
</html>