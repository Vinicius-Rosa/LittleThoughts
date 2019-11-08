<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>:: Abrindo conexão ::</title>
</head>
<body>
<?php
    include "Conn.php";

    $conectar = new Conn();
    $conectar->getConn();

    var_dump($conectar);
?>

</body>
</html>