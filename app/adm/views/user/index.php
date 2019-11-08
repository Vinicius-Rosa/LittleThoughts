<?php

if (!defined('URL')){
    header("location: /");
    exit();
}?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
        <div>Bem vindo!</div>
    </div>
    <div class="table-responsive">
        <?php
            if ($this->dados['botao']['cad_usuario']){?>
                <a href="<?php echo URL . 'adm-user/addUser'; ?>">
                    <div class="p-2">
                        <button class="btn btn-outline-success btn-sm">
                            Cadastrar
                        </button>
                    </div>
                </a>
        <?php
            }
        if (empty($this->dados['listUser'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum usuário encontrado!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
        }
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th class="d-none d-sm-table-cell">E-mail</th>
                    <th class="d-none d-lg-table-cell">Situação</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($this->dados['listUser'] as $usuario) {
                    extract($usuario);
                    ?>
                    <tr>
                        <th><?php echo $id; ?></th>
                        <td><?php echo $nome; ?></td>
                        <td class="d-none d-sm-table-cell"><?php echo $email; ?></td>
                        <td class="d-none d-lg-table-cell">
                            <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $nome_sit; ?></span>
                        </td>
                        <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->dados['botao']['vis_usuario']) {
                                        echo "<a href='". URL . "adm-user/moreUser/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                    }
                                    if ($this->dados['botao']['edit_usuario']) {
                                        echo "<a href='". URL . "adm-user/upUser/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                    }
                                    if ($this->dados['botao']['del_usuario']) {
                                        echo "<a href='". URL . "adm-user/delUser/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                    }
                                    ?>
                                </span>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
    </div>
</main>