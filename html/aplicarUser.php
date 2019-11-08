<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>:: Usuário ::</title>
</head>
<body>
<?php

    include "User.php";

    $nome = "João das Couves";
    $idade = 23;
    $peso = 70.0;
    $altura = 1.75;

    $pessoaAntes = new User();

    $pessoaAntes->setUser($nome, $idade, $peso, $altura);
    echo $pessoaAntes->getUser();
    echo "<br />";
    echo "IMC antes: {$pessoaAntes->getImc()}";

    $pessoaHoje = clone $pessoaAntes;
    $pessoaHoje->setIdade(24);
    $pessoaHoje->setPeso(85);

    echo "<hr />";
    echo $pessoaHoje->getUser();
    echo "<br />";
    echo "IMC antes: {$pessoaHoje->getImc()}";
?>

</body>
</html>