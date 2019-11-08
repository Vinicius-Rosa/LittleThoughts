<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>:: Visualizar Usuário ::</title>
</head>
<body>

<?php

    include "Conn.php";
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    $limite = 1;
    $conectar = new Conn();
    $sql = "SELECT * FROM `user` WHERE id = :id LIMIT :limit";

    $listar = $conectar->getConn()->prepare($sql);
    $listar->bindParam(":id", $id, PDO::PARAM_INT);
    $listar->bindParam(":limit", $limite, PDO::PARAM_INT);
    $listar->execute();
    $linha = $listar->fetch(PDO::FETCH_ASSOC);
    ?>

    <div style="width: 50%; border: dashed"><?php
    echo "<p>ID: {$linha['id']}</p>";
    echo "<p>Nome: {$linha['nome']}</p>";
    echo "<p>E-mail: {$linha['email']}</p>";
    echo "<p>Data: " .date("d-m-Y H:i:s", strtotime($linha['data_criacao'])) ."</p>";?>
    </div>

</body>
</html>