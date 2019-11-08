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
                    <a href="<?php echo URL . 'user/moreUser/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
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
        <form method="POST" action="" enctype="multipart/form-data"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control" placeholder="Digite o nome completo" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Tratamento</label>
                    <input name="tratamento" type="text" class="form-control" placeholder="Como gostaria de ser tratado" value="<?php
                    if (isset($valorForm['tratamento'])) {
                        echo $valorForm['tratamento'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label><span class="text-danger">*</span> E-mail</label>
                    <input name="email" type="text" class="form-control" placeholder="Seu melhor e-mail" value="<?php
                    if (isset($valorForm['email'])) {
                        echo $valorForm['email'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Usuário</label>
                    <input name="user" type="text" class="form-control" id="nome" placeholder="Digite o usuário" value="<?php
                    if (isset($valorForm['user'])) {
                        echo $valorForm['user'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">*</span> Senha</label>
                    <input name="senha" type="password" class="form-control" id="nome" placeholder="Senha com mínimo 6 caracteres" value="<?php
                    if (isset($valorForm['senha'])) {
                        echo $valorForm['senha'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nível de Acesso</label>
                    <select name="adm_niveis_acesso_id" id="adm_niveis_acesso_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->dados['select']['nivac'] as $nivac) {
                            extract($nivac);
                            if ($valorForm['adm_niveis_acesso_id'] == $id_nivac) {
                                echo "<option value='$id_nivac' selected>$nome_nivac</option>";
                            } else {
                                echo "<option value='$id_nivac'>$nome_nivac</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="adm_situacao_id" id="adm_situacao_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ($valorForm['adm_situacao_id'] == $id_sit) {
                                echo "<option value='$id_sit' selected>$nome_sit</option>";
                            } else {
                                echo "<option value='$id_sit'>$nome_sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input name="imagem_antiga" type="hidden" value="<?php
                    if (isset($valorForm['imagem_antiga'])) {
                        echo $valorForm['imagem_antiga'];
                    } elseif (isset($valorForm['imagem'])) {
                        echo $valorForm['imagem'];
                    }
                    ?>">

                    <label><span class="text-danger">*</span> Foto (150x150)</label>
                    <input name="imagem_nova" type="file" onchange="previewImagem();">
                </div>
                <div class="form-group col-md-6">
                    <?php
                    if (isset($valorForm['imagem']) AND ! empty($valorForm['imagem'])) {
                        $imagem_antiga = URL . 'assets/img/usuario/' . $valorForm['id'] . '/' . $valorForm['imagem'];
                    } elseif (isset($valorForm['imagem_antiga']) AND ! empty($valorForm['imagem_antiga'])) {
                        $imagem_antiga = URL . 'assets/img/usuario/' . $valorForm['id'] . '/' . $valorForm['imagem_antiga'];
                    } else {
                        $imagem_antiga = URL . 'assets/img/usuario/preview_img.png';
                    }
                    ?>
                    <img src="<?php echo $imagem_antiga; ?>" alt="Imagem do Usuário" id="preview-user" class="img-thumbnail" style="width: 150px; height: 150px;">
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="editUsuario" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
