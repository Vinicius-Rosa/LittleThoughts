<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>:: Acertando data / hora ::</title>
</head>
<body>
<?php

    echo "Fuso Horário: " .ini_get("date.timezone") ."<br />";
    echo "Data/hora: " .date("Y-m-d H:i:s");
?>

</body>
</html>