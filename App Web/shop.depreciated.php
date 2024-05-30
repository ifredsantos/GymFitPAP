<?php
    include("config.php");

    $msg = "";
    $erros = 0;
?>

<!DOCTYPE html>

<html lang = "pt-pt">
    <head>
        <base href="<?= APP_URL ?>">
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="shop, loja, suplementação, vestuário, roupa, roupa gymfit, roupa de ginásio, gymfit, ginásio, ginásio em condeixa, condeixa, ginásio gymfit">
        <meta name="description" content="">
        <meta property="og:url" content="<?= APP_URL ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?= APP_NAME ?> - Loja">
        <meta property="og:description" content="">
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="content-language" content="pt">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
        <meta name="author" content="Fredinson, fredinsondev@gmail.com">
        <meta name="reply-to" content="fredinsondev@gmail.com">
        <meta http-equiv="cache-control" content="private">
        <meta name="rating" content="general">
		<title><?= APP_NAME ?> - Loja</title>
        <link rel="icon" href="layout/altere.png" type="image/x-icon">
        <link rel="shortcut icon" href="layout/altere.png" type="image/x-icon">
        <link rel = "stylesheet" type = "text/css" href = "layout/css/design.css">
        <link rel = "stylesheet" type = "text/css" href = "layout/css/shop_design.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    
    <body onselectstart="return false" data-spy="scroll" data-target="#myScrollspy" data-offset="50">
        <header id = "#myScrollspy">
            <?php include ("parts/header.php"); ?>
        </header>
        
        <article>
            <?php
                if($msg != "")  { ?>
            <div class="msg-space-modal" id="msg-space-modal">
                <div class="msg-content-modal">
                    <?= $msg; ?>
                </div>
            </div>
            <?php } ?>
            <div id="menu-vertical" style="margin-top: 70px;">
                <ul class = "menuCategorias">
                    <li><a href = "">Vestuário</a>
                        <ul>
                            <a href = ""><li>T-Shirt</li></a>
                            <a href = ""><li>Alças</li></a>
                            <a href = ""><li>Camisolão</li></a>
                            <a href = ""><li>Calções</li></a>
                            <a href = ""><li>Luvas</li></a>
                        </ul>
                    </li>
                    <li><a href = "">Suplementos</a>
                        <ul>
                            <a href = ""><li>Próteina</li></a>
                            <a href = ""><li>Ganho de massa/Gainers</li></a>
                            <a href = ""><li>BCAA e aminoácidos</li></a>
                            <a href = ""><li>Pré-Treino e desempenho</li></a>
                            <a href = ""><li>Pós-Workout</li></a>
                        </ul>
                    </li>
                    <li><a href = "">Acessórios</a></li>
                </ul>
            </div>

            <div id="area-consulta" style="margin-top: 70px;">
                <img src="layout/camisolas_gymfit.jpg" style="width: 50%; display: block; margin: auto; border-radius: 50%;">
                <div class="loja-apresentacao-texto" style="text-align: center; width: 50%; display: block; margin: 20px auto;">
                    <h3 class="text_center">A nossa marca</h3>
                    <p class="text_center">Descubra as nossas roupas GymFit e outros produtos!</p>
                    <br>
                    <button type="button" class="button"><a href="#" style="font-size: 14px">Descubra a nossa gama</a></button>
                </div>
                <hr style="width: 80%;">
                <br>
                <div class="space-categorias">
                    <div class="space-categoria">
                        <img src="layout/musculacao.jpg" alt="Vestuário" title="Vestuário">
                    
                        <div class="space-categoria-text">
                            <p>Vestuário</p>
                        </div>
                    </div>

                    <div class="space-categoria">
                        <img src="layout/musculacao.jpg" alt="Suplementos" title="Suplementos">
                    
                        <div class="space-categoria-text">
                            <p>Suplementos</p>
                        </div>
                    </div>

                    <div class="space-categoria">
                        <img src="layout/musculacao.jpg" alt="Acessórios" title="Acessórios">
                    
                        <div class="space-categoria-text">
                            <p>Acessórios</p>
                        </div>
                    </div>
                </div>
                <br>
                <hr style="width: 80%;">
                <br>
                <h2 class="text_center">Mais vendidos</h2>
                <br>
                <div class="space-produtos">
                    <?php
                        $buscaRefUnicas = mysqli_query($connect, "
                        SELECT DISTINCT ref FROM produtos");
                        if(mysqli_num_rows($buscaRefUnicas) > 0) {
                            while($uniqRef = mysqli_fetch_assoc($buscaRefUnicas)) {
                                $buscaProdMaisVend = mysqli_query($connect, sprintf("
                                SELECT ref, cod_produto, nome_produto, PVP, fotos, nome_marca 
                                FROM produtos 
                                    INNER JOIN produtos_marcas ON produtos.cod_marca = produtos_marcas.cod_marca 
                                WHERE ref = '%s' 
                                ORDER BY cod_produto ASC 
                                LIMIT 1", $uniqRef['ref']
                                ));

                                if(mysqli_num_rows($buscaProdMaisVend) > 0) {
                                    while($prod = mysqli_fetch_assoc($buscaProdMaisVend)) {
                                        /*echo "<pre>";
                                        var_dump($prod);
                                        echo "</pre>";*/
                                        $codigo = $prod['cod_produto'];
                                        $nome = $prod['nome_produto'];
                                        $preco = $prod['PVP'];
                                        $marca = $prod['nome_marca'];
                                        $foto = getFotoPrincipal($prod['fotos']);
                    ?>
                    <a href="produto/<?= $codigo ?>/<?= $nome ?>">
                        <div class="space-produtos-prod">
                            <img src="posts/produtos/<?= $foto ?>" alt="<?= $nome ?>" title="<?= $nome ?>">
                            <p class="prod-label"><?= $marca ?></p>
                            <h3 class="prod-name"><?= $nome ?></h3>
                            <hr>
                            <p class="prod-price"><?= preco($preco) ?></p>
                        </div>
                    </a>
                    <?php
                                    }
                                }
                            }
                        }
                    ?>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class = "gradCinBlack"></div>
        </article>
        
        <footer>
            <?php include("parts/footer.php"); ?>
        </footer>
    </body>
</html>