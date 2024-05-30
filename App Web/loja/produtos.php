<?php
    require '../config.php';
    include_once 'app/cl_produtos.php';

    $produtos = new Produtos();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Loja - Produtos</title>
</head>
<body>
    <p><a href="?filtro=preco&ordem=asc">Preço ascendente</a></p>
    <p><a href="?filtro=preco&ordem=desc">Preço descendente</a></p>

    <?php
        $filtro = $ordem = "";
        $filtrosDisponiveis = array('nome', 'preco', 'data');
        $ordensDisponiveis = array('desc', 'asc');
    
        if(isset($_GET['filtro'], $_GET['ordem']) && !empty($_GET['ordem']) && !empty($_GET['filtro']))
        {
            if(in_array($_GET["filtro"], $filtrosDisponiveis))
            {
                $filtro = $_GET['filtro'];
            }
            if(in_array($_GET["ordem"], $ordensDisponiveis))
            {
                $ordem = $_GET['ordem'];
            }
        }

        $data = $produtos->obterProdutos($filtro, $ordem);
        if($data != null)
        {
            foreach($data as $item)
            {
                echo "<p>".$item['prod_nome']."</p>";
            }
        }
        else
        {
            echo '<p style="color: red">Sem produtos</p>';
        }
    ?>
</body>
</html>