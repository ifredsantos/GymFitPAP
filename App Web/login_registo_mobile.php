<?php
    require "config.php";  

    $msg = "";

    if(isset($_SESSION['cod_user']) && !empty($_SESSION['cod_user']))
        header('Location: '.APP_URL.'perfil');
?>

<!DOCTYPE html>
<html lang = "pt-pt">
    <head>
        <base href="<?= APP_URL ?>">
        <meta charset = "utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="content-language" content="pt">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
        <meta name="author" content="<?= PROGRAMER_NAME ?>, <?= PROGRAMER_EMAIL ?>">
        <meta name="reply-to" content="<?= PROGRAMER_EMAIL ?>">
        <meta http-equiv="cache-control" content="private">
        <meta name="rating" content="general">
        <title>Login - <?= APP_NAME ?></title>
        <link rel="icon" href="<?= APP_URL ?>layout/altere.png" type="image/x-icon">
        <link rel="shortcut icon" href="<?= APP_URL ?>layout/altere.png" type="image/x-icon">
        <link rel = "stylesheet" type = "text/css" href = "<?= APP_URL ?>layout/css/design.css">

        <style>
            @font-face {
                font-family: 'Jura';
                src: url("fonts/Jura-Regular.ttf");
            }

            * {
                font-family: 'Jura';
            }

            .space_opcoes {
                width: calc(100% - 50px);
                position: absolute;
                left: 15px;
                bottom: 15px;
                background-color: #111111;
                border-radius: 5px;
                padding: 10px;
            }

            .space_opcoes h3 {
                text-align: center;
            }

            .space_opcoes p {
                margin-top: 5px;
                margin-bottom: 5px;
            }

            .opcoes {
                width: calc(100% - 30px);
                list-style: none;
            }

            .opcoes li {
                width: 100%;
                border-bottom: 1px solid #262626;
                padding: 15px;
                text-align: center;
            }

            .opcoes li:last-child {
                border: 0;
            }

            .opcoes li a {
                font-style: normal;
                color: #bababa;
            }
        </style>
    </head>
    
    <body style="background-color: black;" onselectstart="return false" data-spy="scroll" data-target="#myScrollspy" data-offset="50">
        <img style="width: 100%; display: block; margin-top: 50%; margin-left: auto; margin-right: auto;" src="<?= APP_URL ?>layout/logo.jpg" alt="GymFit" title="GymFit">
    
        <div class="space_opcoes">
            <h3>Bem vindo ao GymFit</h3>
            <p>Entre ou registe-se para começar</p>
            <ul class="opcoes">
                <li><a href="<?= APP_URL ?>login_mobile.php">Entrar</a></li>
                <li><a href="<?= APP_URL ?>registo.php">Registar</a></li>
            </ul>
        </div>
    </body>
</html>