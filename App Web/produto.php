<?php
    include("config.php");

    $msg = "";
    $erros = 0;

    //RewriteRule ^produto/(.*)/(.*) produto.php?codigo=$1&produto=$2 [NC,L]
    if(isset($_GET['codigo']) && !empty($_GET['codigo'])) {
        $getCodigo = sqlinjectionfilter($_GET['codigo']);

        $buscaProduto = mysqli_query($connect, sprintf("
        SELECT ref, nome_produto, descricao_produto, stock, nome_marca, nome_categoria, PVP, sabor, tamanho, cor, desconto, peso, fotos 
        FROM produtos 
            INNER JOIN produtos_categorias ON produtos.cod_categoria = produtos_categorias.cod_categoria 
            INNER JOIN produtos_marcas ON produtos.cod_marca = produtos_marcas.cod_marca 
        WHERE cod_produto = %s", $getCodigo));
        if(mysqli_num_rows($buscaProduto) > 0) {
            $produto = mysqli_fetch_assoc($buscaProduto);
            $ref = $produto['ref'];
            $nome = $produto['nome_produto'];
            $descricao = $produto['descricao_produto'];
            $stock = $produto['stock'];
            $marca = $produto['nome_marca'];
            $categoria = $produto['nome_categoria'];
            $preco = $produto['PVP'];

            $sabor = $produto['sabor'];
            $tamanho = $produto['tamanho'];
            $cor = $produto['cor'];

            $sabores = $tamanhos = $cores = "";

            $buscaOpcoesProd = mysqli_query($connect, sprintf("
            SELECT sabor, tamanho, cor 
            FROM produtos 
            WHERE ref = '%s'", $ref
            ));
            if(mysqli_num_rows($buscaOpcoesProd) > 0) {
                while($opcoes = mysqli_fetch_assoc($buscaOpcoesProd)) {
                    $sabores = $sabores . $opcoes['sabor'].";";
                    $tamanhos = $tamanhos . $opcoes['tamanho'].";";
                    $cores = $cores . $opcoes['cor'].";";
                }
            }

            $desconto = $produto['desconto'];
            $peso = $produto['peso'];
            $fotos = $produto['fotos'];
        }
    }
?>

<!DOCTYPE html>

<html lang = "pt-pt">
    <head>
        <base href="<?= APP_URL ?>">
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta property="og:url" content="<?= APP_URL ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content=" - <?= APP_NAME ?>">
        <meta property="og:description" content="">
        <meta name="robots" content="index,nofollow">
        <meta http-equiv="content-language" content="pt">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="cache-control" content="private">
        <meta name="rating" content="general">
		<title><?= $nome ?></title>
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

            <div id="area-consulta" style="float: left; width: calc(100% - 80px); margin-left: 20px; margin-top: 70px; margin-bottom: 20px;">
                <div class="space-ver-produto">
                    <img class="foto-principal" src="posts/produtos/<?= getFotoPrincipal($fotos) ?>" alt="" srcset="">

                    <div class="space-outras-fotos">
                        <?php
                            $foto = explode(";", $fotos);
                            for($i=0; $i < count($foto); $i++) {
                                if($i > 0)
                                    echo '<img src="posts/produtos/'.$foto[$i].'">';
                            }
                        ?>
                    </div>

                    <div class="space-produto-extra-info">
                        <?php
                            if($stock >= 10) {
                                echo '<div class="bola green"></div><p>Em stock</p>';
                            } else if($stock > 0) {
                                echo '<div class="bola blue"><p></div><p>Poucas unidades</p>';
                            } else {
                                echo '<div class="bola red"></div><p>Sem stock</p>';
                            }

                            if($desconto != 0) {
                                echo '<img src="layout/discount.svg"><p>'.$desconto.'% de desconto</p>';
                            }
                        ?>
                    </div>

                    <?php
                        if($descricao != "") {
                    ?>
                    <div class="space-produto-texto">
                        <?php
                            $paragDesc = explode(";", $descricao);
                            for($i=0; $i < count($paragDesc); $i++) {
                                echo "<p>".$paragDesc[$i]."</p>";
                            }
                        ?>
                    </div>
                    <?php
                        }
                    ?>
                </div>

                <div class="space-opcoes-produto">
                    <p class="marca"><?= $marca ?></p>
                    <h3 class="nome"><?= $nome ?></h3>
                    <p class="preco"><?= preco($preco) ?></p>
                    <hr>
                    <p class="marca">Opções</p>

                    <form class="space-produtos-opcoes" action="parts/carrinho.php" method="post">
                        <?php
                            if($sabores != "") {
                                echo '<div class="opcao"><p>Sabor:</p><select name="sabor">';
                                $sabor = explode(";", $sabores);
                                for($i=0; $i < count($sabor); $i++) {
                                    echo '<option value="'.$sabor[$i].'">'.$sabor[$i].'</option>';
                                }
                                echo '</select></div>';
                            }
                            if($tamanhos != "") {
                                echo '<div class="opcao"><p>Tamanho:</p><select name="tamanho">';
                                $tamanho = explode(";", $tamanhos);
                                for($i=0; $i < count($tamanho); $i++) {
                                    echo '<option value="'.$tamanho[$i].'">'.$tamanho[$i].'</option>';
                                }
                                echo '</select></div>';
                            }
                            if($cores != "") {
                                echo '<div class="opcao"><p>Cor:</p><select name="cor">';
                                $cor = explode(";", $cores);
                                for($i=0; $i < count($cor); $i++) {
                                    echo '<option value="'.$cor[$i].'">'.$cor[$i].'</option>';
                                }
                                echo '</select></div>';
                            }
                        ?>
                        <input type="hidden" name="produto" value=<?= $getCodigo ?>>
                        <input type="hidden" name="backurl" value="produto/<?= $getCodigo ?>/<?= $nome ?>">

                        <input class="btn-submit" type="submit" name="acao" value="Adicionar ao carrinho">
                    </form>
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