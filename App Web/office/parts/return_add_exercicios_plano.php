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
    <label for="exercicio">Exercícios</label>
    <select name="exercicio" class="form-control" required>
        <?php
            $buscaExercicios = $gst->exe_query("
            SELECT cod_exercicio, nome_exercicio, nome_tipo FROM exercicios 
                INNER JOIN tipos_exercicios ON exercicios.tipo = tipos_exercicios.cod_tipo_exercicio");
            
            if(count($buscaExercicios) > 0) {
                for($i=0; $i < count($buscaExercicios); $i++) {
                    echo '<option value="'.$buscaExercicios[$i]["cod_exercicio"].'">'.$buscaExercicios[$i]["cod_exercicio"] . " - " . $buscaExercicios[$i]["nome_exercicio"] . " | " . $buscaExercicios[$i]["nome_tipo"] .'</option>';
                }
            }
        ?>                                            
    </select>
</div>

<div class="form-group">
    <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
        <label for="num_reps">Nº de repetições</label>
        <input name="num_reps" type="number" class="form-control" placeholder="Insira o nº de repetições">
    </div>
    
    <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
        <label for="num_series">Nº de séries</label>
        <input name="num_series" type="number" class="form-control" placeholder="Insira o nº de séries">
    </div>

    <div class="clearfix"></div>
</div>

<div class="form-group">
    <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
        <label for="duracao">Duração</label>
        <input name="duracao" type="time" class="form-control">
    </div>
    
    <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
    </div>

    <div class="clearfix"></div>
</div>

<input type="hidden" name="cod_plano" value="<?= $_GET['cod'] ?>">

<?php
        }
    }
?>