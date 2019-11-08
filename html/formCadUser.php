<?php
session_start();
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>:: Formulário de cadastro de Usuário ::</title>
</head>
<body>
<?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    if (!empty($dados['enviar'])) {
        unset($dados['enviar']);
        var_dump($dados);
        include "Conn.php";
        $conectar = new Conn();

        $tabela = "user";
        $nome = $dados['nome'];
        $email = $dados['email'];
        $senha = $dados['senha'];

        $sql = "INSERT INTO {$tabela} 
              (`nome`, `email`, `senha`, `data_criacao`, `status`) VALUES
               (:nome,:email,MD5(:senha),NOW(),1)";
        $cadastrar = $conectar->getConn()->prepare($sql);

        $cadastrar->bindParam(":nome", $nome, PDO::PARAM_STR);
        $cadastrar->bindParam(":email", $email, PDO::PARAM_STR);
        $cadastrar->bindParam(":senha", $senha, PDO::PARAM_STR);

        $cadastrar->execute();

        if ($cadastrar->rowCount()){
            $_SESSION['msg'] = "<p style='color: green'>Registro cadastrado com sucesso</p>";
        }else{
            $_SESSION['msg'] = "<p style='color: red'>Registro não foi cadastrado com sucesso!</p><p>ERROR:"
                .$cadastrar->errorInfo()[2] ."</p>";
        }
        header("location: listarUser.php");
    }
?>
    <form name="" action="" method="post">
        <p>
            <label for="iNome">Nome:</label>
            <input name="nome" id="iNome" type="text" />
        </p>
        <p>
            <label for="iEmail">E-mail:</label>
            <input name="email" id="iEmail" type="email" />
        </p>
        <p>
            <label for="isenha">Senha:</label>
            <input name="senha" id="iSenha" type="password" />
        </p>
        <p>
            <button name="enviar" id="iEnviar" type="submit" value="enviar">Enviar</button>
        </p>
    </form>
</body>
</html>