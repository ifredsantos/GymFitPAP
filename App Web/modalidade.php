<?php
    include("config.php");

    $imgs = $nome = $desc = $msg = "";

    if(isset($_GET["nome"]) && $_GET["nome"] != "") {
        $nomeModalidade = $_GET['nome'];

        $param = [
            ":nome_modalidade" => $nomeModalidade
        ];

        $mod = $gst->exe_query("SELECT * FROM modalidades WHERE nome_modalidade = :nome_modalidade", $param);
        if (count($mod) > 0) {
            $nome = $mod[0]['nome_modalidade'];
            $desc = $mod[0]['descricao'];
            $imgs = $mod[0]['imgs'];
        }
        else    {
            $nome = "";
            $desc = "";
            $imgAp = "";
            $imgs = "";
            $msg .= "<p style = 'color: red'><br>Esta modalidade não existe</p>";
            header('location: '. APP_URL. '404');
        }
    }
    else
    {
        header('location: '. APP_URL. 'home');
    }
?>

<!DOCTYPE html>

<html lang = "pt-pt">
    <head>
        <base href="<?= APP_URL ?>" />
        <meta charset = "utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="<?= $nomeModalidade ?>, gymfit, ginásio, ginásio em condeixa, condeixa, ginásio gymfit">
        <meta name="description" content="<?= encortarTexto(removerTextoFromat($desc), 150, '...'); ?>">
        <meta property="og:url" content="<?= APP_URL ?>/modalidade/<?= $nomeModalidade ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?= $nome; ?> - <?= APP_NAME ?>">
        <meta property="og:description" content="<?= encortarTexto(removerTextoFromat($desc), 150, '...'); ?>">
        <meta name="robots" content="index,nofollow">
        <meta http-equiv="content-language" content="pt">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
        <meta name="author" content="<?= PROGRAMER_NAME ?>, <?= PROGRAMER_EMAIL ?>">
        <meta name="reply-to" content="<?= PROGRAMER_EMAIL ?>">
        <meta http-equiv="cache-control" content="private">
        <meta name="rating" content="general">
		<title><?= $nome; ?> - <?= APP_NAME ?></title>
        <link rel="icon" href="layout/altere.png" type="image/x-icon">
        <link rel="shortcut icon" href="layout/altere.png" type="image/x-icon">
        <link rel = "stylesheet" type = "text/css" href = "layout/css/design.css">
        <script></script>
    </head>
    
    <body onselectstart="return false" data-spy="scroll" data-target="#myScrollspy" data-offset="50">
        <header id = "#myScrollspy">
            <?php include("parts/header.php"); ?>
        </header>
        
        <div class="clearfix"></div>
        
        <article>
            <br>
            <?php
                $foto = explode(";", $imgs);

                if($foto[0] != "") {
            ?>
            <img id="img_apresentacao" style="width: 100%;" src="posts/modalidades/FAP/<?= $foto[0] ?>" alt="<?= $nome; ?>">
            <div class="gradCinVerCin" id="gradCinVerCin"></div>
            <?php
                } else {
                    echo '<div style="margin-top: 40px;"></div>';
                }
            ?>
            <div class="txtModalidades">
                <h1><?php echo $nome; ?></h1>
                <p><?php echo $desc; ?></p>
                
                <?php
                    if($imgs != "")    {
                ?>
                <!--<section class = "slide" id = "slide">
                    <?php
                        for($i = 0; $i < count($foto); $i++)
                        {
                            if($i != 0)
                            {
                    ?>
                    <img class="mySlides" style = "width: 100%;" src = "posts/modalidades/<?= $foto[$i] ?>" alt = "<?= $nome ."_". $i ?>">
                    <?php 
                            }
                        }
                    ?>
                    <button class="slideButton btnLeft" onclick="plusDivs(-1)">&#10094;</button>
                    <button class="slideButton btnRight" onclick="plusDivs(1)">&#10095;</button>
                    
                    <script>
                        var slideIndex = 1;
                        showDivs(slideIndex);

                        function plusDivs(n) {
                          showDivs(slideIndex += n);
                        }

                        function showDivs(n) {
                          var i;
                          var x = document.getElementsByClassName("mySlides");
                          if (n > x.length) {slideIndex = 1}    
                          if (n < 1) {slideIndex = x.length}
                          for (i = 0; i < x.length; i++) {
                             x[i].style.display = "none";  
                          }
                          x[slideIndex-1].style.display = "block";  
                        }
                    </script>
                </section>-->
                <?php }?>
                <?php echo $msg; ?>
            </div>
            <div class = "gradCinBlack"></div>
        </article>
     
        <footer>
            <p><?php include("parts/footer.php"); ?></p>
        </footer>
    </body>
</html>            