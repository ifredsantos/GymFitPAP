<?php
    if(acessoPrivadoAoEstablecimento()) {
    if(isset($_GET['target'], $_GET['id']) && $_GET['target'] == "exercicio" && $_GET['id'] != "") {
        $param = [
            ":cod_ex" => $_GET['id']
        ];
        $buscaExercicio = $gst->exe_query("
        SELECT EX.cod_exercicio, EX.nome_exercicio, EX.img, EX.video, nome_tipo, cod_tipo_exercicio 
        FROM exercicios EX 
            INNER JOIN tipos_exercicios ON EX.tipo = tipos_exercicios.cod_tipo_exercicio 
        WHERE cod_exercicio = :cod_ex", $param);

        if(count($buscaExercicio) > 0) {
            $exercicio = $buscaExercicio[0];

            if(!isset($_GET['plano'])) {
?>
<p class="text_left"><a href="<?= APP_URL ?>perfil/biblioteca_exercicios">Biblioteca de exercícios</a>&nbsp&nbsp/&nbsp <a href="<?= APP_URL ?>perfil.php?target=exercicios&id=<?= $exercicio['cod_tipo_exercicio'] ?>"><?= $exercicio['nome_tipo'] ?></a>&nbsp&nbsp/&nbsp <?= $exercicio["nome_exercicio"] ?></p>
<?php
            } else {
                $param = [
                    ":cod_plano" => $_GET['plano']
                ];
                $buscaInfPlano = $gst->exe_query("
                SELECT nome_plano FROM planos WHERE cod_plano = :cod_plano", $param);
                if(count($buscaInfPlano) > 0) {
                    $nomePlano = $buscaInfPlano[0]["nome_plano"];
?>
<p class="text_left"><a href="<?= APP_URL ?>perfil/planos">Planos</a>&nbsp&nbsp/&nbsp <a href="<?= APP_URL ?>perfil.php?target=plano_exercicios&id_plano=<?= $_GET['plano'] ?>"><?= $nomePlano ?></a>&nbsp&nbsp/&nbsp <?= $exercicio["nome_exercicio"] ?></p>
<?php
                }
            }
?>
<br>
<div class="space_mostra1_ex">
    <h3 class="text_center"><?= $exercicio["nome_exercicio"] ?></h3>
    <br>
    <?php
        if($exercicio['video'] != "") {
    ?>
    <div class="space_mostra1_ex_vid">
        <video controls loop controlsList="nodownload">
            <source src="<?= APP_URL ?>posts/biblioteca_exercicios/video/<?= $exercicio['video'] ?>" type="video/mp4">
            O seu browser não suporta vídeo.
        </video>
    </div>
    <?php
        }
        if($exercicio['video'] == "") {
    ?>
    <div class="space_mostra1_ex_img" style="width: 100%;">
    <?php
        } else {
    ?>
    <div class="space_mostra1_ex_img">
    <?php
        }
    ?>
        <img src="<?= APP_URL ?>posts/biblioteca_exercicios/img/<?= $exercicio['img'] ?>" alt="<?= $exercicio['nome_exercicio'] ?>" title="<?= $exercicio['nome_exercicio'] ?>">
        <div class="space_mostra1_ex_img_text">
            <p class="text_left"><b>Categoria: </b><?= $exercicio['nome_tipo'] ?></p>
        </div>
    </div>
</div>
<?php
        } else {
?>
<p><a href="<?= APP_URL ?>perfil/biblioteca_exercicios">Biblioteca de exercícios</a></p>
<br>
<p style="color: red" class="text_center">Exercício não encontrado.</p>
<?php
        }
    }
    } else {
?>

<img style="display: block; margin: auto; width: 50%;" src="<?= APP_URL ?>layout/wifi.png">
<h3 class="text_center" style="margin-bottom: 5px; color: red">Acesso restrito</h3>
<p class="text_center" style="margin-bottom: 5px;">Esta área está restrita apenas para uso no ginásio.</p>
<p class="text_center" style="margin-bottom: 5px;"><b>Conecte-se ao WiFi do GymFit e tente.</b></p>

<?php
    }
?>