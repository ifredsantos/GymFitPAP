<html lang="pt-pt">
    <head>
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="<?= PROGRAMER_NAME ?>, <?= PROGRAMER_EMAIL ?>">
        <meta name="reply-to" content="<?= PROGRAMER_EMAIL ?>">
        <title>Site em construção</title>
        <style>
            *
            {
                font-family: arial;
            }
        </style>
    </head>
    
    <body>
        <h1 style="text-align: center;">Site em construção</h1>
        <p style="text-align: center;">Pedimos desculpa mas esta aplicação web encontra-se em construção, volte mais tarde</p>
        <p style="text-align: center;">O seu IP <?php $ip = $_SERVER['REMOTE_ADDR']; echo $ip; ?> não está na lista de programadores.</p>
    </body>
</html>