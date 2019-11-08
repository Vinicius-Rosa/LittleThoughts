    <?php
        require "./vendor/autoload.php";
        require "./Config/Config.php";

        use Config\ConfigController as Home;
        $url = new Home();
        $url->carregar();
