<?php
    include("../config.php");
    include("verifica-acesso.php");
?>

<!DOCTYPE html>
<html lang = "pt-pt">
	<head>
        <base href="<?= APP_URL_OFFICE ?>" />
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="content-language" content="pt">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
        <meta name="author" content="Fredinson, fredinsondev@gmail.com">
        <meta name="reply-to" content="fredinsondev@gmail.com">
        <meta http-equiv="cache-control" content="private">
        <title>Office - <?= APP_NAME; ?></title>
        <link rel = "stylesheet" type = "text/css" href = "layout/css/design.css">
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="js/js_mod_tables.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
        <link rel="icon" href="layout/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="layout/favicon.ico" type="image/x-icon">
	</head>
    
    <body>
        <header>
            <div class = "top-bar">
                <a href = "../"><h1><?= APP_NAME; ?> - Office</h1></a>
                
                <div class = "top-bar-icons">
                    <img src = "layout/user.png" alt = "User" onclick="abrePopUp()">
                </div>
            </div>
            
            <?php include("parts/inf_user.php") ?>
        </header>
        
        <article>
            <?php include ("parts/header.php"); ?>
            <div class = "col-md-10 offset-md-2">
                <br><br><br><br>
                <br><br><br><br>
                <br><br><br><br>
                <h3 style="text-align: center;">A página que está a procurar não está disponível!</h3>
                <p style="text-align: center; margin-top: 5px;">Pode usar o menu do lado esquerdo para navegar</p>
            </div>
        </article>
        
        <footer>
            
        </footer>
        <script src="js/main.js"></script>
    </body>
</html>