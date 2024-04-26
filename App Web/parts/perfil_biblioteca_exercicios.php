<?php
    if(acessoPrivadoAoEstablecimento()) {
?>
<div class="space_bib_exercicios">
<?php
    $buscaTipoExercicios = $gst->exe_query("
    SELECT * FROM tipos_exercicios");

    if(count($buscaTipoExercicios) > 0) {
        for($i = 0; $i < count($buscaTipoExercicios); $i++) {
            $tipoExercicio = $buscaTipoExercicios[$i];
?>
    <div class="space_bib_exercicios_img">
        <img src="<?= APP_URL ?>posts/biblioteca_exercicios/img/<?= $tipoExercicio['img'] ?>">
        <button class="space_bib_exercicios_btn" type="button"><a href="<?= APP_URL . "perfil.php?target=exercicios&id=" . $tipoExercicio['cod_tipo_exercicio'] ?>"><?= $tipoExercicio['nome_tipo'] ?></a></button>
    </div>

<?php
        }
    } else echo '<p style="color: red; text-align: center">Não existem exercícios.</p>';
?>
</div>
<?php
    } else {
?>

<img style="display: block; margin: auto; width: 50%;" src="<?= APP_URL ?>layout/wifi.png">
<h3 class="text_center" style="margin-bottom: 5px; color: red">Acesso restrito</h3>
<p class="text_center" style="margin-bottom: 5px;">Esta área está restrita apenas para uso no ginásio.</p>
<p class="text_center" style="margin-bottom: 5px;"><b>Conecte-se ao WiFi do GymFit.</b></p>

<?php
    }
?>