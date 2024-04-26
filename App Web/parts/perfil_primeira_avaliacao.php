<?php
    $existe1analise = $existe1objetivo = false;

    $param = [":utilizador" => $_SESSION['cod_user']];
    $verificaExiste1analise = $gst->exe_query("
    SELECT data_analise FROM utilizadores_analises WHERE utilizador = :utilizador", $param);

    $verificaExiste1objetivo = $gst->exe_query("
    SELECT data_registo FROM utilizadores_objetivos WHERE utilizador = :utilizador", $param);

    if(count($verificaExiste1analise) > 0)
        $existe1analise = true;

    if(count($verificaExiste1objetivo) > 0)
        $existe1objetivo = true;

    if(isset($_POST['acao']) && $_POST['acao'] == "primeira_avaliacao") {
        if(!$existe1analise) {
            $altura = $_POST['altura'];
            $peso = $_POST['peso'];
            //$perimetro_abdominal = $_POST['perimetro_abdominal'];
            //$pressao_arterial = $_POST['pressao_arterial'];
            $perimetro_abdominal = 0.00;
            $pressao_arterial = 0.00;

            if($altura != "" && $peso != "") {
                $param = [
                    ":peso" => $peso,
                    ":altura" => $altura,
                    ":per_abdominal" => $perimetro_abdominal,
                    ":pressao_arterial" => $pressao_arterial,
                    ":utilizador" => $_SESSION['cod_user']
                ];

                $registaPrimeiraAnalise = $gst->exe_non_query("
                INSERT INTO utilizadores_analises (peso, altura, perimetro_abdominal, pressao_arterial, utilizador, data_analise)
                VALUES (:peso, :altura, :per_abdominal, :pressao_arterial, :utilizador, NOW())", $param);

                if(!$registaPrimeiraAnalise) {
                    echo MSGdanger("Ocorreu um erro", "Não foi possivel realizar a sua 1ª análise", "");
                }
            }
        }
    }
    if(isset($_POST['acao']) && $_POST['acao'] == "definir_primeiro_objetivo") {
        $peso_alvo = $_POST['peso_alvo'];
        $data_alvo = $_POST['data_alvo'];
        $objetivo = "Perder Peso";

        if(!$existe1objetivo) {
            $param = [
                ":utilizador" => $_SESSION['cod_user'],
                ":obj" => $objetivo,
                ":peso_alvo" => $peso_alvo,
                ":data_alvo" => $data_alvo
            ];
            $regista1obj = $gst->exe_non_query("
            INSERT INTO utilizadores_objetivos (utilizador, objetivo, peso_alvo, data_alvo, atual, cumprido, data_registo)
            VALUES (:utilizador, :obj, :peso_alvo, :data_alvo, 's', 'n', NOW())", $param);
            
            if($regista1obj)
                header('Location: '.APP_URL.'perfil/objetivos&msg=objetivo1-sucesso');
            else
                echo MSGdanger("Ocorreu um erro", "Não foi possivel definir o seu 1º objetivo", "");
        }
    }
?>

<?php
    if(isset($_POST['acao']) && $_POST['acao'] != "primeira_avaliacao" || !isset($_POST['acao'])) {
        if(!$existe1analise) {
?>
<h3 style="text-align: center; color: #fff; margin-bottom: 15px;">1ª Avaliação</h3>
<div class="perfil-objetivos">
    <p class="text_center">Antes de definir qualquer objetivo proceda a 1ª avaliação.</p>
    <form action="<?= APP_URL ?>perfil/primeira_avaliacao" method="post">
        <br>
        <p style="text-align: center; font-weight: bold;">Primeira análise</p>
        <hr>
        <label class="label-center" for="altura">Altura (em metros): *<br>
            <input type="number" name="altura" min="0.10" max="3.00" step="0.01" placeholder="1.79" required>
        </label>
        
        <label class="label-center" for="peso">Peso (em quilogramas): *<br>
            <input type="number" name="peso" min="10" max="800" step="0.001" placeholder="80" required>
        </label>

        <!-- <label class="label-center" for="perimetro_abdominal">Perímetro abdominal (em centímetros):<br>
            <input type="number" name="perimetro_abdominal" min="10" max="800" step="1" placeholder="90">
        </label>

        <label class="label-center" for="pressao_arterial">Pressão arterial (em mmHg):<br>
            <input type="number" name="pressao_arterial" min="10" max="400" step="1"  placeholder="95">
        </label> -->

        <input type="hidden" name="acao" value="primeira_avaliacao">
        <input type="submit" style="margin-top: 15px; width: 200px; border-radius: 10px;" value="Enviar análise">
    </form>

    <script>
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1;
        var yyyy = today.getFullYear();
        if(dd<10){
                dd='0'+dd
            } 
            if(mm<10){
                mm='0'+mm
            } 

        today = yyyy+'-'+mm+'-'+dd;
        document.getElementById("data_alvo").setAttribute("min", today);
    </script>
</div>
<?php
        }
    }
?>

<div>
    <?php
        $param = [":utilizador" => $_SESSION['cod_user']];
        $busca1analise = $gst->exe_query("
        SELECT *, U.genero, FLOOR(DATEDIFF(NOW(), U.data_nascimento) / 365) AS idade FROM utilizadores_analises UA 
            INNER JOIN utilizadores U ON UA.utilizador = U.cod_utilizador 
        WHERE utilizador = :utilizador ORDER BY data_analise DESC LIMIT 1", $param);

        if(count($busca1analise) > 0) {
            $dados1analise = $busca1analise[0];
            
            $genero = $dados1analise['genero'];
            if($genero == 'm')
                $valorgenero = 1;
            else
                $valorgenero = 0;
            
            $idade = $dados1analise['idade'];
            $peso = $dados1analise['peso'];
            $altura = $dados1analise['altura'];
            $perimetro_abdominal = $dados1analise['perimetro_abdominal'];
            $pressao_arterial = $dados1analise['pressao_arterial'];

            $alturaQuadrado = pow($altura, 2);

            $imc = $peso / $alturaQuadrado;

            // (1,20 x IMC) + (0,23 x idade) – (10,8 x sexo) – 5.4
            $massa_gorda = (1.20 * $imc) + (0.23 * $idade) - (10.8 * $valorgenero) - 5.4;

            // Classificações
            $classIMC = $classMassaGorda = "";

            if($genero == 'm') {
                if($imc < 17.2)
                    $classIMC = "Magreza";
                else if($imc >= 17.2 && $imc < 24.5)
                    $classIMC = "Normal";
                else if($imc >= 24.5 && $imc < 28)
                    $classIMC = "Sobrepeso";
                else
                    $classIMC = "Obesidade";

                if($massa_gorda <= 10)
                    $classMassaGorda = "Atleta";
                else if($massa_gorda > 10 && $massa_gorda <= 18)
                    $classMassaGorda = "Ideal";
                else if($massa_gorda > 18 && $massa_gorda <= 25)
                    $classMassaGorda = "Elevada";
                else
                    $classMassaGorda = "Muito elevada";
            }
            if($genero == 'f') {
                if($imc < 16.6)
                    $classIMC = "Magreza";
                else if($imc >= 16.6 && $imc < 24.6)
                    $classIMC = "Normal";
                else if($imc >= 24.6 && $imc < 28.6)
                    $classIMC = "Sobrepeso";
                else
                    $classIMC = "Obesidade";
                
                if($massa_gorda <= 20)
                    $classMassaGorda = "Atleta";
                else if($massa_gorda > 20 && $massa_gorda <= 25)
                    $classMassaGorda = "Ideal";
                else if($massa_gorda > 25 && $massa_gorda <= 35)
                    $classMassaGorda = "Elevada";
                else
                    $classMassaGorda = "Muito elevada";
            }

            $peso_minimo = $alturaQuadrado * 18.5;
            $peso_maximo = $alturaQuadrado * 25;
            $peso_ideal = $peso_minimo + (($peso_maximo - $peso_minimo) / 2);

            echo '<h3 style="text-align: center; color: #fff; margin-bottom: 15px;">Resultado da 1ª análise</h3>';
            echo '<div class="perfil-objetivos">';

            echo '<p class="text_center" style="margin-bottom: 5px">Abaixo encontra-se algumas informações mais detalhadas:</p>';
            echo '<p class="text_center" style="margin-bottom: 5px"><b>IMC: </b>'.round($imc, 2).' Kg/m<sup>2</sup></p>
                <p class="text_center" style="margin-bottom: 5px"><b>Classificação do IMC: </b>'.$classIMC.'</p>
                <p class="text_center" style="margin-bottom: 5px"><b>Peso mínimo: </b>'.round($peso_minimo, 0).' Kg</p>
                <p class="text_center" style="margin-bottom: 5px"><b>Peso máximo: </b>'.round($peso_maximo, 0).' Kg</p>
                <p class="text_center" style="margin-bottom: 5px"><b>Peso ideal: </b>'.round($peso_ideal, 0).' Kg</p>
                <p class="text_center" style="margin-bottom: 5px"><b>Massa gorda: </b>'.round($massa_gorda, 0).'%</p>';
            echo '</div>';
    ?>
</div>

<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Itens', 'Percentagem'],
          ['Massa Magra',     <?= round((100 - $massa_gorda), 0) ?>],
          ['Massa Gorda',      <?= round($massa_gorda, 0) ?>]
        ]);

        var options = {
          title: 'Massa gorda VS Massa magra',
          pieHole: 0.5,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
</script>

<div class="space_perfil_grafico">
    <div id="donutchart" class="grafico"></div>
</div>

<?php
        }
?>

<?php
    if(!$existe1objetivo && isset($_POST['acao']) && $_POST['acao'] != "definir_primeiro_objetivo") {
?>
<div id="frm_aceitar_desafio">
    <hr style="margin-bottom: 11px;">
    <h3 class="text_center">Aceita o desafio?</h3>
    <hr>
    <?php
        if($peso_ideal < $peso) {
            echo '<p class="text_center" style="margin-bottom: 5px">E que tal começar por perder algum peso?</p>';
            echo '<p class="text_center" style="margin-bottom: 5px">O seu peso ideal seria '.round($peso_ideal, 0).' Kg, ou seja, precisa de perder '. round($peso - $peso_ideal, 0).' Kg.</p>';
            echo '<p class="text_center" style="margin-bottom: 5px; font-size: 12px;">Tenha em conta que o seu peso ideal pode variar entre '.round($peso_minimo, 0).' Kg e '.round($peso_maximo, 0).' Kg.</p>';
        }
    ?>
    <div class="perfil-objetivos">
        <form action="<?= APP_URL ?>perfil/primeira_avaliacao" method="post">
            <label class="label-center" for="peso_alvo">Peso que pretende atingir (em quilogramas): *<br>
                <input type="number" name="peso_alvo" min="10" max="800" step="0.001" value="<?= round($peso_ideal, 0) ?>" required>
            </label>

            <label class="label-center" for="data_alvo">Data alvo: *<br>
                <input type="date" name="data_alvo" id="data_alvo" required>
            </label>
            <br>
            <input type="hidden" name="acao" value="definir_primeiro_objetivo">
            <button type="button" style="cursor: pointer; display: block; margin: auto; width: 100px; padding: 10px; color: #efefef; background-color: darkred; font-size: 16px; border-radius: 20px;" onclick="document.getElementById('frm_aceitar_desafio').style.display='none'" style="float: left; margin-top: 0; background-color: darkred; color: #efefef;">Ignorar</button>
            <br>
            <button type="submit" style="cursor: pointer; display: block; margin: auto; width: 160px; padding: 10px; color: #efefef; background-color: green; font-size: 16px; border-radius: 20px;">Definir objetivo</button>
            
            <script src="js/data_minima_atual.js"></script>
        </form>
    </div>
</div>
<?php
    }
?>