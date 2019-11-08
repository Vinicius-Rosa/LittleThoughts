<body onload="animeScroll()">
    <main>
        <div class="container">
            <div class="header">
                <h1 class="anime">Little Thoughts</h1>
                <div class="img anime"><img src="<?=URL?>assets/img/logo.png" alt="Logo"></div>
            </div>
            <div class="form">
                <div id="error" class="help-block"></div>
                <form id="form_cad" method="post" action="<?=URL?>cadastro/exeCadastroAjax">
                    <input class="anime" name="login_user" type="text" placeholder="Usuário">
                    <input class="anime" name="email_user" type="email" placeholder="Email">
                    <input class="anime" name="password_user" type="password" placeholder="Senha">
                    <input class="anime" name="password_confirm" type="password" placeholder="Repita a senha">

                    <button class="anime" type="submit">Cadastrar</button>
                    <a href="<?=URL?>login/index" class="anime">Já possui um cadastro? Login!</a>
                </form>
            </div>
        </div>
    </main>