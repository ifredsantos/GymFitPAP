<?php
    require_once '../parts/cl_gestor.php';

    class Produto extends Gestor
    {
        public $codigo;
        public $nome;
        public $descricao;
        public $marca;
        public $img;
        public $desconto;
        public $stock;
        public $categoria;
        public $subCategoria;

        function obterProduto($codProduto)
        {
            $gst = new Gestor();
            $param = [":cod_produto" => $codProduto];
            $query = $gst->exe_query("
            SELECT P.*, PM.marcar_nome AS marca, PC.catg_nome AS categoria, PSC.subCatg_nome AS sub_categoria FROM produtos P 
                INNER JOIN produtos_categorias PC ON P.prod_catg = PC.cod_prod_catg 
                INNER JOIN produtos_sub_categorias PSC ON P.prod_subCatg = PSC.cod_prod_subCatg 
                INNER JOIN produtos_marcas PM ON P.prod_marca = PM.cod_prod_marca 
            WHERE cod_produto = :cod_produto", $param);

            return $query;
        }
    }
?>