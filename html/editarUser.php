<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>:: Editar Usuário ::</title>
</head>
<body>

<?php
    require "Conn.php";
    $conectar = new Conn();
    $limite = 1;

    // editando o usuário
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    var_dump($dados);
    if (!empty($dados['sendAtualizar'])){
        unset($dados['sendAtualizar']);
        $sql = "UPDATE `user` SET `nome` = :nome, `email` = :email, `senha` = MD5(:senha), `status` = :status 
                  WHERE `id` = :id LIMIT :limit";
        $atualizar = $conectar->getConn()->prepare($sql);
        $atualizar->bindParam(":nome", $dados['nome'], PDO::PARAM_STR);
        $atualizar->bindParam(":email", $dados['email'], PDO::PARAM_STR);
        $atualizar->bindParam(":senha", $dados['senha'], PDO::PARAM_STR);
        $atualizar->bindParam(":status", $dados['status'], PDO::PARAM_STR);
        $atualizar->bindParam(":id", $dados['id'], PDO::PARAM_INT);
        $atualizar->bindParam(":limit", $limite, PDO::PARAM_INT);

        if ($atualizar->execute()){
            $_SESSION['msg'] = "<p style='color: green'>Registro alterado com sucesso</p>";
        }else{
            $_SESSION['msg'] = "<p style='color: red'>Registro não foi alterado com sucesso!</p>"
                .$cadastrar->errorInfo()[2] ."</p>";
        }
    }

    // procurando o usuário
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    $sql = "SELECT * FROM `user` WHERE `id` = :id LIMIT :limit";
    $listar = $conectar->getConn()->prepare($sql);
    $listar->bindParam(":id", $id, PDO::PARAM_INT);
    $listar->bindParam(":limit", $limite, PDO::PARAM_INT);
    $listar->execute();

    $linha = $listar->fetch(PDO::FETCH_ASSOC);
?>

<form name="" action="" method="post">
    <p>
        <label for="iNome">Nome:</label>
        <input name="nome" id="iNome" type="text" value="<?= $linha['nome'] ?>"/>
        <input name="id" id="iId" type="hidden" value="<?= $linha['id'] ?>"/>
    </p>
    <p>
        <label for="iEmail">E-mail:</label>
        <input name="email" id="iEmail" type="email" value="<?= $linha['email'] ?>" />
    </p>
    <p>
        <label for="isenha">Senha:</label>
        <input name="senha" id="iSenha" type="password" />
    </p>
    <p>
        <label for="iStatus">Status:</label>
        <select name="status" id="iStatus">
            <option value="1" <?php if ($linha['status'] == 1){ echo "SELECTED"; }?>>Ativo</option>
            <option value="0" <?php if ($linha['status'] == 0){ echo "SELECTED"; }?>>Inativo</option>
        </select>
    </p>
    <p>
        <button name="sendAtualizar" id="iEnviar" type="submit" value="Atualizar">Atualizar</button>
    </p>
</form>

</body>
</html>