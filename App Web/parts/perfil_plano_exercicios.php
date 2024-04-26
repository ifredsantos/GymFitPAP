<?php
    if(acessoPrivadoAoEstablecimento()) {
        $param = [
            ":id_plano" => $_GET['id_plano']
        ];
        $buscaPlanoExercicios = $gst->exe_query("
        SELECT P.nome_plano, E.cod_exercicio, E.nome_exercicio, E.img, ET.nome_tipo, PEX.num_reps, PEX.num_series, PEX.duracao 
        FROM plano_exercicios PEX 
            INNER JOIN exercicios E ON PEX.exercicio = E.cod_exercicio 
            INNER JOIN tipos_exercicios ET ON E.tipo = ET.cod_tipo_exercicio 
            INNER JOIN planos P ON PEX.plano = P.cod_plano 
        WHERE PEX.plano = :id_plano", $param);
        if(count($buscaPlanoExercicios) > 0) {
?>
<p class="text_left"><a href="<?= APP_URL ?>perfil/planos">Planos</a>&nbsp&nbsp/&nbsp <?= $buscaPlanoExercicios[0]["nome_plano"] ?></p>
<br>
<h3 class="text_center"><?= $buscaPlanoExercicios[0]["nome_plano"] ?></h3>
<br>
<div class="space_planos_treinos">
    <?php
        for($i = 0; $i < count($buscaPlanoExercicios); $i++) {
            $plano_exercicio = $buscaPlanoExercicios[$i];

            $reps = $plano_exercicio['num_reps'];
            $series = $plano_exercicio['num_series'];
            $duracao = $plano_exercicio['duracao'];

            if($reps != "" && $series == "")
                $series = 1;

    ?>
    <a style="font-style: normal" href="<?= APP_URL ?>perfil.php?target=exercicio&id=<?= $plano_exercicio['cod_exercicio'] ?>&plano=<?= $_GET['id_plano'] ?>">
        <div class="space_plano_treino">
            <img src="<?= APP_URL ?>posts/biblioteca_exercicios/img/<?= $plano_exercicio['img'] ?>">
            <div class="space_plano_treino_txt">
                <h3 style="margin-bottom: 5px;"><?= $plano_exercicio['nome_exercicio'] ?></h3>
                <?php
                    if($reps != "" && $series != "") {
                ?>
                <p class="text_left" style="margin-bottom: 5px;"><b>Quantidade: </b><?= $reps ?> reps X <?= $series ?> séries</p>
                <?php
                    }
                    if($duracao != "00:00:00" && $duracao != "") {
                ?>
                <p class="text_left" style="margin-bottom: 5px;"><b>Duração: </b> <?= pttime($duracao) ?> H</p>
                <?php
                    }
                ?>
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
?>

<img style="display: block; margin: auto; width: 50%;" src="<?= APP_URL ?>layout/wifi.png">
<h3 class="text_center" style="margin-bottom: 5px; color: red">Acesso restrito</h3>
<p class="text_center" style="margin-bottom: 5px;">Esta área está restrita apenas para uso no ginásio.</p>
<p class="text_center" style="margin-bottom: 5px;"><b>Conecte-se ao WiFi do GymFit.</b></p>

<?php
    }
?>