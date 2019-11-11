<body onload="animeScroll()">
<main>
    <div class="container">
        <div class="header">
            <h1 class="anime">Little Thoughts</h1>
            <div class="img anime"><img src="<?=URL?>assets/img/logo.png" alt="Logo"></div>
        </div>
        <div class="form">
            <div id="error" class="help-block"></div>
            <form method="post" id="form_login" >
                <input class="anime" name="login" type="text" placeholder="Usuário">
                <input class="anime" name="password" type="password" placeholder="Senha">

                <h2 class="anime"><a href="#">Esqueceu a senha?</a></h2>

                <a href="<?=URL?>cadastro/index" class="anime">Cadastre-se!</a>
                <button id="btn_login" class="anime" type="submit">Login</button>
            </form>
        </div>
    </div>
</main>