<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Little Thoughts</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:300i,400,400i,500,500i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Sue+Ellen+Francisco&display=swap" rel="stylesheet"> 

    <?php 
        if(isset($this->dados["includes"])){
            foreach ($this->dados["includes"]["styles"] as $styles){
    ?>
                <link rel="stylesheet" href="<?= $styles ?>">
    <?php
            }
        }
    ?>
</head>