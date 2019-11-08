<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
        <div>Bem vindo!</div>
    </div>
    <div class="table-responsive"><?php
if (!empty($this->dados['dados_usuario'][0])) {
    extract($this->dados['dados_usuario'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Ver Usuário</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->dados['botao']['list_usuario']) {
                            echo "<a href='" . URL . "adm-user/index' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->dados['botao']['edit_usuario']) {
                            echo "<a href='" . URL . "adm-user/upUser/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->dados['botao']['edit_senha']) {
                            echo "<a href='" . URL . "adm-user/upUserPass/$id' class='btn btn-outline-danger btn-sm'>Editar Senha</a> ";
                        }
                        if ($this->dados['botao']['del_usuario']) {
                            echo "<a href='" . URL . "adm-user/delUser/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                </div>
            </div><hr>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <dl class="row">
                <dt class="col-sm-3">Foto</dt>
                <dd class="col-sm-9">                    
                    <?php
                    if (!empty($imagem)) {
                        echo "<img src='" . URL . "assets/img/usuario/" . $id . "/" . $imagem . "' witdh='150' height='150'>";
                    } else {
                        echo "<img src='" . URL . "assets/img/usuario/icone_usuario.png' witdh='150' height='150'>";
                    }
                    ?>
                </dd>

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Tratamento</dt>
                <dd class="col-sm-9"><?php echo $tratamento; ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $nome; ?></dd>

                <dt class="col-sm-3">E-mail</dt>
                <dd class="col-sm-9"><?php echo $email; ?></dd>

                <dt class="col-sm-3">Usuário</dt>
                <dd class="col-sm-9"><?php echo $user; ?></dd>

                <dt class="col-sm-3">Recuperar Senha</dt>
                <dd class="col-sm-9"><?php
                    if (!empty($recuperar_senha)) {
                        echo URL . "atual-senha/atual-senha?chave=" . $recuperar_senha;
                    }
                    ?></dd>

                <dt class="col-sm-3">Nível de Acesso</dt>
                <dd class="col-sm-9"><?php echo $nome_nivac; ?></dd>

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $nome_sit; ?></span>
                </dd>

                <dt class="col-sm-3">Inserido</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($data_criacao)); ?></dd>

                <dt class="col-sm-3">Alterado</dt>
                <dd class="col-sm-9"><?php
                    if (!empty($modified)) {
                        echo date('d/m/Y H:i:s', strtotime($data_modificacao));
                    }
                    ?>
                </dd>
            </dl>


        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não encontrado!</div>";
    $urlDestino = URL . 'adm-user/index';
    header("Location: $urlDestino");
}
?>
    </div>
</main>