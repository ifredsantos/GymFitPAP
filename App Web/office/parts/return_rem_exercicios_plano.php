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
            SELECT cod_exercicio, nome_exercicio, num_reps, num_series, duracao FROM plano_exercicios 
                INNER JOIN exercicios ON plano_exercicios.exercicio = exercicios.cod_exercicio 
            WHERE plano = :cod_plano", $param);
            
            if(count($buscaExercicios) > 0) {
                for($i=0; $i < count($buscaExercicios); $i++) {
                    echo '<option value="'.$buscaExercicios[$i]["cod_exercicio"].'">'.$buscaExercicios[$i]["cod_exercicio"] . " - " . $buscaExercicios[$i]["nome_exercicio"] . " | " . $buscaExercicios[$i]["num_reps"] . " reps X " . $buscaExercicios[$i]["num_series"].' series</option>';
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