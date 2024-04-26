<?php
    if(acessoPrivadoAoEstablecimento()) {
        $buscaPlanosTreinoPadrao = $gst->exe_query("
        SELECT planos.*, COUNT(cod_plano_exercicio) AS NUM_EXERCICIOS FROM planos 
            INNER JOIN plano_exercicios ON planos.cod_plano = plano_exercicios.plano 
        WHERE tipo = 1 
        GROUP BY planos.cod_plano");

        $param = [":cod_cliente" => $_SESSION['cod_user']];
        $buscaPlanosTreinoPersonalizados = $gst->exe_query("
        SELECT planos.*, COUNT(cod_plano_exercicio) AS NUM_EXERCICIOS FROM planos 
            INNER JOIN plano_exercicios ON planos.cod_plano = plano_exercicios.plano 
            INNER JOIN planos_clientes ON planos.cod_plano = planos_clientes.plano 
        WHERE cliente = :cod_cliente", $param);

        if(count($buscaPlanosTreinoPadrao) > 0 && $buscaPlanosTreinoPadrao[0]["cod_plano"] != "" || count($buscaPlanosTreinoPersonalizados) > 0 && $buscaPlanosTreinoPersonalizados[0]["cod_plano"] != "") {
            if(count($buscaPlanosTreinoPadrao) > 0 && $buscaPlanosTreinoPadrao[0]["cod_plano"] != "") {
?>
<div class="space_planos_treinos">
    <?php
        for($i = 0; $i < count($buscaPlanosTreinoPadrao); $i++) {
            $plano = $buscaPlanosTreinoPadrao[$i];
    ?>
    <a style="font-style: normal" href="<?= APP_URL ?>perfil.php?target=plano_exercicios&id_plano=<?= $plano['cod_plano'] ?>">
        <div class="space_plano_treino">
            <img src="<?= APP_URL ?>posts/planos/<?= $plano['img_plano'] ?>">
            <div class="space_plano_treino_txt">
                <h3 style="margin-bottom: 5px;"><?= $plano['nome_plano'] ?></h3>
                <p class="text_left" style="margin-bottom: 5px;"><b>Nº de exercícios: </b><?= $plano['NUM_EXERCICIOS'] ?></p>
                <p class="text_left" style="margin-bottom: 5px;"><b>Duração média: </b> <?= pttime($plano['duracao']) ?> H</p>
            </div>
        </div>
    </a>
    <?php
        }
    ?>
</div>

<?php
            }
    if(count($buscaPlanosTreinoPersonalizados) > 0 && $buscaPlanosTreinoPersonalizados[0]["cod_plano"] != "") {
?>
<div class="space_planos_treinos">
    <?php
        for($i = 0; $i < count($buscaPlanosTreinoPersonalizados); $i++) {
            $planoPers = $buscaPlanosTreinoPersonalizados[$i];
    ?>
    <a style="font-style: normal" href="<?= APP_URL ?>perfil.php?target=plano_exercicios&id_plano=<?= $planoPers['cod_plano'] ?>">
        <div class="space_plano_treino">
            <img src="<?= APP_URL ?>posts/planos/<?= $planoPers['img_plano'] ?>">
            <div class="space_plano_treino_txt">
                <h3 style="margin-bottom: 5px;"><?= $planoPers['nome_plano'] ?></h3>
                <p class="text_left" style="margin-bottom: 5px;"><b>Nº de exercícios: </b><?= $planoPers['NUM_EXERCICIOS'] ?></p>
                <p class="text_left" style="margin-bottom: 5px;"><b>Duração média: </b> <?= pttime($planoPers['duracao']) ?> H</p>
            </div>
        </div>
    </a>
    <?php
        }
    ?>
</div>
<?php
    }
        } else {
            echo '<p style="color: red" class="text_center">Sem planos de treino para sí.</p>';
        }
    } else {
?>

<img style="display: block; margin: auto; width: 50%;" src="<?= APP_URL ?>layout/wifi.png">
<h3 class="text_center" style="margin-bottom: 5px; color: red">Acesso restrito</h3>
<p class="text_center" style="margin-bottom: 5px;">Esta área está restrita apenas para uso no ginásio.</p>
<p class="text_center" style="margin-bottom: 5px;"><b>Conecte-se ao WiFi do GymFit.</b></p>

<?php
    }
?>