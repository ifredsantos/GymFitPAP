<?php
    include("config.php");
?>

<!DOCTYPE html>

<html lang = "pt-pt">
    <head>
        <base href="<?= APP_URL ?>">
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="content-language" content="pt">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
        <meta name="author" content="Fredinson, fredinsondev@gmail.com">
        <meta name="reply-to" content="fredinsondev@gmail.com">
        <meta http-equiv="cache-control" content="private">
        <meta name="rating" content="general">
		<title>Página não encontrada - <?= APP_NAME ?></title>
        <link rel="icon" href="layout/altere.png" type="image/x-icon">
        <link rel="shortcut icon" href="layout/altere.png" type="image/x-icon">
        <link rel = "stylesheet" type = "text/css" href = "layout/css/design.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    </head>
    
    <body onselectstart="return false" data-spy="scroll" data-target="#myScrollspy" data-offset="50">
        <header id = "#myScrollspy">
            <?php include ("parts/header.php"); ?>
        </header>
        
        <article style="padding-top: 100px;">
            <img  style="border-radius: 0" src="layout/warning.gif" class="gato">
            <br>
            <h3 style="text-align: center;">Não tem acesso a esta pasta ou página</h3>
            <section style="position: fixed; bottom: 45px; width: 100%;" class = "gradCinBlack"></section>
        </article>
        
        <footer style="position: fixed; bottom: 0; width: 100%;">
            <?php include("_parts/footer.php"); ?>
        </footer>
        <script src = "js/modal.js"></script>
    </body>
</html>            