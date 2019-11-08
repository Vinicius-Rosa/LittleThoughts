<?php
session_start();
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>:: Listar Usuário ::</title>
</head>
<body>
<p>Para cadastrar, <a href="formCadUser.php">clique aqui</a></p>
<?php

    if (isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }

    include "Conn.php";
    $status =1;
    $conectar = new Conn();
    $sql = "SELECT * FROM `user` WHERE status = :status";

    $listar = $conectar->getConn()->prepare($sql);
    $listar->bindParam(":status", $status, PDO::PARAM_STR);
    $listar->execute();

    while ($linha = $listar->fetch(PDO::FETCH_ASSOC)){
        echo "<p>ID: {$linha['id']}</p>";
        echo "<p>Nome: {$linha['nome']}</p>";
        echo "<p>E-mail: {$linha['email']}</p>";
        echo "<p>Data: " .date("d-m-Y H:i:s", strtotime($linha['data_criacao'])) ."</p>";
        echo "<p><a href='visualizarUser.php?id={$linha['id']}'>Visualizar</a> ";
        echo "<a href='editarUser.php?id={$linha['id']}'>Editar</a> ";
        echo "<a href='apagarUser.php?id={$linha['id']}'>Apagar</a></p>";
        echo "<hr />";
    }
?>

</body>
</html>