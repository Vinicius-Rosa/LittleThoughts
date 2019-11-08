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
        <div>Bem vindo! <span style="color:red"><?= $_SESSION['user_nome']; ?></span> Cliente desde <?= date("d-m-Y",strtotime($_SESSION['user_data_criacao'])); ?></div>
    </div>
    <div class="table-responsive">
        <!--
            O CONTEÚDO DA PÁGINA AQUI
        -->
    </div>
</main>


