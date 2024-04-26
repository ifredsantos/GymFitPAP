<?php
    require '../../config.php';

    if(isset($_GET['cod']) && $_GET['cod'] != "") {
        $param = [":cod_plano" => $_GET['cod']];
        
        $buscaInfPlano = $gst->exe_query("
        SELECT nome_plano FROM planos WHERE cod_plano = :cod_plano", $param);
        if(count($buscaInfPlano) > 0) {
            $infPlano = $buscaInfPlano[0];
?>

<div class="form-group">
    <label for="nome">Nome plano</label>
    <input name="nome" type="text" class="form-control" value="<?= $infPlano['nome_plano'] ?>" readonly>
</div>

<div class="form-group">
    <label for="cliente">Clientes</label>
    <select name="cliente" class="form-control" required>
        <?php
            $buscaClientes = $gst->exe_query("
            SELECT cod_utilizador, nome FROM utilizadores WHERE tipo_utilizador = 3");
            
            if(count($buscaClientes) > 0) {
                for($i=0; $i < count($buscaClientes); $i++) {
                    echo '<option value="'.$buscaClientes[$i]["cod_utilizador"].'">'.$buscaClientes[$i]["cod_utilizador"] . " - " . $buscaClientes[$i]["nome"].'</option>';
                }
            }
        ?>                                            
    </select>
</div>

<input type="hidden" name="cod_plano" value="<?= $_GET['cod'] ?>">

<?php
        }
    }
?>