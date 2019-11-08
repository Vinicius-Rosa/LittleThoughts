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
        if (isset($this->dados['form'])) {
            $valorForm = $this->dados['form'];
        }
        if (isset($this->dados['form'][0])) {
            $valorForm = $this->dados['form'][0];
        }
        //var_dump($this->dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Usuário</h2>
            </div>

            <?php
            if ($this->dados['botao']['vis_usuario']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URL . 'adm-user/moreUser/' . $this->dados['form']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
                </div>
                <?php
            }
            ?>

        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="">   
            <input name="id" type="hidden" value="<?php echo $this->dados['form']; ?>">

            <div class="form-group">
                <label>Senha</label>
                <input name="senha" type="password" class="form-control" placeholder="Senha com mínimo 6 caracteres">
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditSenha" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>