<?php
    if(acessoPrivadoAoEstablecimento()) {
?>
<div class="space_bib_exercicios">
<?php
    if(isset($_GET['id'])) {
        $cod_tipo_exercicio = $_GET['id'];
        
        $param = [
            ":cod_tipo_ex" => $cod_tipo_exercicio
        ];
        $buscaExercicios = $gst->exe_query("
        SELECT cod_exercicio, nome_exercicio, EX.img, video, cod_tipo_exercicio, nome_tipo 
        FROM exercicios EX 
            INNER JOIN tipos_exercicios ON EX.tipo = tipos_exercicios.cod_tipo_exercicio 
        WHERE tipo = :cod_tipo_ex", $param);

        if(count($buscaExercicios) > 0) {
            echo '<p class="text_left"><a href="'.APP_URL.'perfil/biblioteca_exercicios">Biblioteca de exercícios</a>&nbsp&nbsp/&nbsp '.$buscaExercicios[0]['nome_tipo'].'</a></p><br>';
            echo '<h3 class="text_center">Exercícios para ' . $buscaExercicios[0]['nome_tipo'] . '</h3><br>';

            for($i = 0; $i < count($buscaExercicios); $i++) {
                $tipoExercicio = $buscaExercicios[$i];
?>
    <a style="font-style: normal" href="<?= APP_URL . "perfil.php?target=exercicio&id=" . $tipoExercicio['cod_exercicio'] ?>">
        <div class="space_exercicio">
            <img class="img_exercicio" src="<?= APP_URL ?>posts/biblioteca_exercicios/img/<?= $tipoExercicio['img'] ?>">
            <div class="space_text_execicio">
                <p><?= $tipoExercicio['nome_exercicio'] ?></p>
            </div>
            <div class="icons">
                <?php
                    if($tipoExercicio['video'] != "")
                        echo '<img class="icon" src="' . APP_URL . 'layout/play-button.png" alt="Ver vídeo" title="Ver vídeo">';
                ?>
            </div>
        </div>
    </a>
<?php
            }
        } else {
            // Não existe exercícios nesta categoria
        }
    } else {
        header('Location: ' . APP_URL . "perfil/biblioteca_exercicios");
    }
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