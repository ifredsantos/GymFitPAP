<?php
    include("../config.php");
    include("verifica-acesso.php");

    $dataAtual = date("Y-m-d");
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
        <script src="js/jquery-1.11.1.min.js"></script>
        <link href="layout/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="js/bootstrap.min.js"></script>
        <script src="js/js_mod_tables.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
        <link rel="icon" href="layout/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="layout/favicon.ico" type="image/x-icon">
	</head>
    
    <body>
        <header>
            <div class = "top-bar">
                <a href = "<?= APP_URL; ?>"><h1><?= APP_NAME; ?> - Office</h1></a>
                
                <div class = "top-bar-icons">
                    <img src = "layout/user.png" alt = "User" onclick="abrePopUp()">
                </div>
            </div>
            
            <?php include("parts/inf_user.php") ?>
        </header>
        
        <article>
            <?php include ("parts/header.php"); ?>
            
            <div class = "col-md-10 offset-md-2">
                <div class = "trace-link col-xs-12 col-sm-12 col-md-12">
                    <p><a id = "trace-link-main" href = "produtos">Produtos</a></p>
                </div>
            </div>
            <div class = "col-md-10 offset-md-2">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-6">
                                <form name="pesquisa" method="post" action="produtos">
                                    <div id="custom-search-input">
                                        <div class="input-group col-md-12">
                                            <input name="pesquisa"
                                                   type="search"
                                                   class="form-control"
                                                   placeholder="Pesquisar">
                                            <input type="hidden" name="action" value="pesquisar">
                                            <span class="input-group-btn">
                                                <button class="btn btn-info btn-lg" type="button">
                                                    <i class="glyphicon glyphicon-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col col-xs-6 text-right">
                                <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#adicionarProdutos" style="height: 42px;">Adicionar produtos</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal fade" id="adicionarProdutos" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">Adicionar Produtos</h3>
                                </div>
                                <div class="modal-body">
                                    <form name="addTpEvento" action="tables" method="post" enctype="multipart/form-data">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-list">
                            <thead>
                                <tr>
                                    <th><em class="fa fa-cog"></em></th>
                                    <th>Referência</th>
                                    <th>Nome</th>
                                    <th>Stock</th>
                                    <th>Marca</th>
                                    <th>PVP</th>
                                    <th>Sabor</th>
                                    <th>Tamanho</th>
                                    <th>Cor</th>
                                    <th>Desconto</th>
                                    <th>Peso</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $quantidade = 10;
                                $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
                                $inicio = ($quantidade * $pagina) - $quantidade;
                                
                                
                                if(isset($_POST['action']) && $_POST['action'] == "pesquisar")
                                {
                                    $pesquisa = $_POST['pesquisa'];
                                    
                                    $sqlPesquisa = "WHERE P.ref LIKE '$pesquisa' OR P.nome_produto LIKE '%$pesquisa%' OR P.descricao_produto LIKE '%$pesquisa%' OR PM.nome_marca LIKE '$pesquisa' OR PC.nome_categoria LIKE '$pesquisa' OR P.sabor LIKE '%$pesquisa%'";
                                    if($pesquisa == "")
                                        $sqlPesquisa = "";
                                }
                                else
                                    $sqlPesquisa = "";
                                
                                $buscaProdutos = "SELECT P.ref, P.nome_produto, P.descricao_produto, P.stock, 
                                PM.nome_marca, 
                                PC.nome_categoria, 
                                P.preco_fornecedor, P.PVP, P.sabor, P.tamanho, P.cor, P.desconto, P.peso, P.fotos, P.visitas
                                FROM produtos P
                                    INNER JOIN produtos_marcas PM ON P.cod_marca = PM.cod_marca
                                    INNER JOIN produtos_categorias PC ON P.cod_categoria = PC.cod_categoria
                                $sqlPesquisa LIMIT $inicio,$quantidade";
                                $exBuscaProdutos = mysqli_query($connect, $buscaProdutos);
                                $resultados = mysqli_num_rows($exBuscaProdutos);
                                
                                $numBuscaProdutos = "SELECT COUNT P.ref, P.nome_produto, P.descricao_produto, P.stock, 
                                PM.nome_marca, 
                                PC.nome_categoria, 
                                P.preco_fornecedor, P.PVP, P.sabor, P.tamanho, P.cor, P.desconto, P.peso, P.fotos, P.visitas
                                FROM produtos P
                                    INNER JOIN produtos_marcas PM ON P.cod_marca = PM.cod_marca
                                    INNER JOIN produtos_categorias PC ON P.cod_categoria = PC.cod_categoria
                                $sqlPesquisa";

                                $totalPagina = ceil($resultados/$quantidade);
                                                                
                                $exibir = 10;
                                $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
                                $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
                                
                                if($resultados > 0) {
                                    while($infProd = mysqli_fetch_assoc($exBuscaProdutos)) {   
                                        $sabores = $infProd['sabor'];
                                        $cores = $infProd['cor'];
                                        $tamanhos = $infProd['tamanho'];
                                        
                                        $sabor = explode(";", $sabores);
                                        $cor = explode(";", $cores);
                                        $tamanho = explode(";", $tamanhos);
                                        
                                        $PVP = $infProd['PVP'] - $infProd['PVP'] * ($infProd['desconto']/100);
                            ?>
                                <tr>
                                    <td align="center">
                                        <a class="btn btn-default"><em class="fa fa-pencil"></em></a>
                                        <a class="btn btn-danger"><em class="fa fa-trash"></em></a>
                                    </td>
                                    <!--<td class="hidden-xs">1</td>-->
                                    <td><?= $infProd['ref'] ?></td>
                                    <td><?= $infProd['nome_produto'] ?></td>
                                    <td><?= $infProd['stock'] ?></td>
                                    <td><?= $infProd['nome_marca'] ?></td>
                                    <td><?= preco($PVP) ?></td>
                                    <td>
                                        <?php
                                            if($sabores != "")
                                            {
                                                for($i = 0; $i < count($sabor) ; $i ++)
                                                {
                                                    echo "$sabor[$i]";
                                                }
                                            } else {echo "ND";}
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($tamanhos != "")
                                            {
                                                for($i = 0; $i < count($tamanho) ; $i ++)
                                                {
                                                    echo "$tamanho[$i]";
                                                }
                                            } else {echo "ND";}
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($cores != "")
                                            {
                                                for($i = 0; $i < count($cor) ; $i ++)
                                                {
                                                    echo "$cor[$i]";
                                                }
                                            } else {echo "ND";}
                                        ?>
                                    </td>
                                    <td><?= $infProd['desconto'] ?>%</td>
                                    <td>
                                        <?php
                                            if($infProd['peso'] != 0)
                                                echo $infProd['peso']." g";
                                            else
                                                echo "ND";
                                        ?>    
                                    </td>
                                </tr>
                            <?php
                                    }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Rodapé da tabela -->
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col col-xs-3">Página <?= $pagina ?> de <?= $totalPagina ?>
                            </div>
                            
                            <div class="col col-xs-3">
                                <?php
                                    if(isset($_POST['action']) && $_POST['action'] == "pesquisar" && $_POST['pesquisa'] != "")
                                    {
                                ?>
                                <p>Pesquisa por: <b><?= $_POST['pesquisa'] ?></b></p>
                                <?php
                                    }
                                    else if(isset($_GET['pesquisa']) && $_GET['pesquisa'] != "")
                                    {
                                ?>
                                <p>Pesquisa por: <b><?= $_GET['pesquisa'] ?></b></p>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                <p>Número de resultados: <?= $resultados ?></p>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="col col-xs-6">
                                <ul class="pagination hidden-xs pull-right">
                                    <?php
                                        if(isset($_POST['action']))
                                            $pesquisa = $_POST['pesquisa'];
                                        else if(isset($_GET['pesquisa']))
                                            $pesquisa = $_GET['pesquisa'];
                                        else
                                            $pesquisa = "";
                                    
                                        echo "<li><a href=\"produtos/1/$pesquisa\">&laquo;</a></li>";
                                        echo "<li><a href=\"produtos/$anterior/$pesquisa\">&lsaquo;</a></li>";
                                    
                                        for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                                            if($i > 0)
                                                echo "<li><a href=\"produtos/$i/$pesquisa\">$i</a></li>";
                                        }

                                        echo "<li><a href=\"produtos/$pagina/$pesquisa\"><strong>$pagina</strong></a></li>";

                                        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                                            if($i <= $totalPagina)
                                                echo "<li><a href=\"produtos/$i/$pesquisa\">$i</a></li>";
                                        }
                                        echo "<li><a href=\"produtos/$posterior/$pesquisa\">&rsaquo;</a></li>";
                                        echo "<li><a href=\"produtos/$totalPagina/$pesquisa\">&raquo;</a></li>";
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                                }
                    ?>
                </div>
            </div>
            
            <div class = "col-md-10 offset-md-2">
                <div class = "trace-link col-xs-12 col-sm-12 col-md-12">
                    <p><a id = "trace-link-main" href = "produtos">Produtos</a> / Categorias</p>
                </div>
            </div>
        </article>
        
        <footer>
            
        </footer>
        <script src="_js/main.js"></script>
    </body>
</html>