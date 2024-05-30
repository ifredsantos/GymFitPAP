<?php
    require_once '../parts/cl_gestor.php';

    class Produtos extends Gestor
    {
    //     public $codigo;
    //     public $nome;
    //     public $descricao;
    //     public $marca;
    //     public $img;
    //     public $desconto;
    //     public $stock;
    //     public $categoria;
    //     public $subCategoria;

        function obterProdutos($filtro, $ordem)
        {
            $sqlOrdem = "";

            if($filtro && $ordem != "")
            {
                if($filtro == "preco")
                    $filtro = "prod_pvp";
                    
                $sqlOrdem = " ORDER BY $filtro $ordem";
            }
            
            $gst = new Gestor();
            $query = $gst->exe_query("
            SELECT P.*, PM.marca_nome AS marca, PC.catg_nome AS categoria, PSC.subCatg_nome AS sub_categoria FROM produtos P 
                INNER JOIN produtos_categorias PC ON P.prod_catg = PC.cod_prod_catg 
                INNER JOIN produtos_sub_categorias PSC ON P.prod_subCatg = PSC.cod_prod_subCatg 
                INNER JOIN produtos_marcas PM ON P.prod_marca = PM.cod_prod_marca $sqlOrdem");

            if(count($query) == 0)
            {
                $query = null;
            }
            return $query;
        }
    }
?>