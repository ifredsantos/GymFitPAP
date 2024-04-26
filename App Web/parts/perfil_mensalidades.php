<?php
    $mesAtual = date("m");
    $anoAtual = date("Y");
    $dataAtual = date("Y-m-d");

    $param = [
        ":cod_utilizador" => $_SESSION['cod_user']
    ];
    $buscaClienteAquisicao = $gst->exe_query("
    SELECT U.cod_utilizador, MAQ.cod_aquisicao, MAQ.mensalidade 
    FROM mensalidades_aquisicoes MAQ 
        INNER JOIN utilizadores U ON MAQ.utilizador = U.cod_utilizador
    WHERE MAQ.atual='s' AND cod_utilizador = :cod_utilizador 
    ORDER BY U.cod_utilizador", $param);

    if(count($buscaClienteAquisicao) > 0) {
        for($i = 0; $i < count($buscaClienteAquisicao); $i++) {
            /* echo "<pre>";
            var_dump($usersNotPay);
            echo "</pre>"; */
            $codUser = $buscaClienteAquisicao[0]['cod_utilizador'];
            $codAquisicao = $buscaClienteAquisicao[0]['cod_aquisicao'];
            $mensalidadeUser = $buscaClienteAquisicao[0]['mensalidade'];
            
            $param = [
                ":cod_aquisicao" => $codAquisicao,
                ":mes_atual" => $mesAtual,
                ":mes_seguinte" => $mesAtual + 1
            ];
            $verificaExisteRegisto = $gst->exe_query("
            SELECT MP.cod_utilizador, MP.mes, M.cod_mensalidade  
            FROM mensalidades_pagamentos MP 
                INNER JOIN mensalidades_aquisicoes MAQ ON MP.cod_utilizador = MAQ.utilizador
                INNER JOIN mensalidades M ON MAQ.mensalidade = M.cod_mensalidade
            WHERE MP.aquisicao = :cod_aquisicao AND MP.mes = :mes_atual OR
            MP.aquisicao = :cod_aquisicao AND MP.mes = :mes_seguinte", $param);

            if(count($verificaExisteRegisto) == 0 && $mensalidadeUser != 1) {
                $param = [
                    ":cod_utilizador" => $codUser,
                    ":cod_aquisicao" => $codAquisicao,
                    ":mes_atual" => $mesAtual,
                    ":ano_atual" => $anoAtual
                ];
                $regPorPagar = $gst->exe_non_query("
                INSERT INTO mensalidades_pagamentos(cod_utilizador, aquisicao, mes, ano) VALUES 
                (
                    :cod_utilizador,
                    :cod_aquisicao,
                    :mes_atual,
                    :ano_atual
                )", $param);
            }
        }
    }
?>

<ul id="menu-mensalidades">
    <?php
        $mesAtual = date("m");
        $anoAtual = date("Y");

        $param = [
            ":cod_utilizador" => $_SESSION['cod_user']
        ];
        $buscaMensalidadesUtilizador = $gst->exe_query("
        SELECT mes, ano, aquisicao 
        FROM mensalidades_pagamentos
            INNER JOIN mensalidades_aquisicoes ON mensalidades_pagamentos.cod_utilizador = mensalidades_aquisicoes.utilizador 
        WHERE cod_utilizador = :cod_utilizador AND mensalidades_aquisicoes.mensalidade <> 1 AND atual LIKE 's' 
        ORDER BY ano DESC, mes DESC 
        LIMIT 12", $param);
        if(count($buscaMensalidadesUtilizador) > 0) {
            for($i = 0; $i < count($buscaMensalidadesUtilizador); $i++) {
                $mes = $buscaMensalidadesUtilizador[$i]['mes'];
                $ano = $buscaMensalidadesUtilizador[$i]['ano'];
                $codAquisicao = $buscaMensalidadesUtilizador[$i]['aquisicao'];
                echo '<li onclick="getDadosMensalidade(\''.$mes.'\', \''.$ano.'\', \''.$codAquisicao.'\')">
                            <p>'.meses($mes).'</p>
                            <p>'.$ano.'</p>
                    </li>';
            }
        }
    ?>
</ul>

<div id="result"></div>

<div class="clearfix"></div>
<br>

<?php
    // Verificar se o utilizador tem uma mensalidade selecionada
    $param = [
        ":cod_utilizador" => $_SESSION['cod_user']
    ];
    $verificaMensalidade = $gst->exe_query("
    SELECT M.cod_mensalidade, M.nome_mensalidade, M.preco 
    FROM mensalidades_aquisicoes MAQ 
        INNER JOIN mensalidades M ON MAQ.mensalidade = M.cod_mensalidade 
    WHERE MAQ.utilizador = :cod_utilizador AND MAQ.atual LIKE 's' AND MAQ.mensalidade <> 1", $param);
    
    // Se não existir mensalidade selecionada
    if(count($buscaMensalidadesUtilizador) == 0) {
?>
<h3 style="text-align: center; color: #fff; margin-bottom: 15px;">Mensalidades</h3>
<div class="perfil-mensalidades">
    <p class="text_center">Seja bem vindo ao sistema de mensalidades da sua área de cliente.</p>
    <p class="text_center">Aqui terá acesso às mensalidades anteriores e ao seu estado bem como a mensalidade atual por pagar.</p>
    <p class="text_center">Começe por escolher a sua mensalidade, é facil!</p>
    <form action="<?= APP_URL ?>perfil/mensalidades" method="post">
        <label for="mensalidade">Mensalidade:<br>
            <select name="mensalidade">
                <?php
                    $buscaMensalidades = $gst->exe_query("
                    SELECT * FROM mensalidades 
                    WHERE cod_mensalidade <> 1", $param);
                    if(count($buscaMensalidades) > 0) {
                        for($i = 0; $i < count($buscaMensalidades); $i++) {
                            echo '<option value="'.$buscaMensalidades[$i]['cod_mensalidade'].'">'.$buscaMensalidades[$i]['nome_mensalidade'].' - '.preco($buscaMensalidades[$i]['preco']).'</option>';
                        }
                    }
                ?>
            </select>
        </label>
        <input type="hidden" name="acao" value="escolhe-primeira-mensalidade">
        <input type="submit" style="margin-top: 15px; width: 200px; border-radius: 10px;" value="Selecionar mensalidade">
        <br>
        <p class="text_center" style="font-size: 12px;">Algum possivel desconto apenas será aplicado no establecimento.</p>
    </form>
</div>
<?php
    } else {
?>
<h3 style="text-align: center; color: #fff; margin-bottom: 15px;">Alterar mensalidade<s></s></h3>
<div class="perfil-mensalidades">
    <p class="text_center">Alterar a sua mensalidade atual é facil, é só selecionar!</p>
    <p class="text_center">Se já tem uma mensalidade para este mês mas não é a pretendida simplesmente cancele e escolha uma nova.</p>
    <p class="text_center"><b>Nota: </b>A atualização da mensalidade do mês atual so pode ser realizada até à data máxima de pagamento. (dia <?= DIAPAGAMENTO ?> de cada mês)</p>
    <form action="<?= APP_URL ?>perfil/mensalidades" method="post">
        <label for="mensalidade">Mensalidade:<br>
            <?php
                $param = [
                    ":utilizador" => $_SESSION['cod_user'],
                    ":mes_atual" => $mesAtual,
                    ":ano_atual" => $anoAtual
                ];
                $buscaAtualPorPagar = $gst->exe_query("
                SELECT mes, ano FROM mensalidades_pagamentos 
                WHERE cod_utilizador = :utilizador 
                AND mes = :mes_atual AND ano = :ano_atual 
                AND data_pagamento IS NULL AND cancelado LIKE 'n'", $param);
                
                if(count($buscaAtualPorPagar) > 0) {
                    $dadosAtualPorPagar = $buscaAtualPorPagar[0];
                    $dataLimiteAtualPorPagar = $dadosAtualPorPagar['ano']."-".sprintf("%02d", $dadosAtualPorPagar['mes'])."-".DIAPAGAMENTO;
                    
                    if($dataAtual <= $dataLimiteAtualPorPagar) {
                        echo "<select name=\"mensalidade\" id=\"mensalidade\" onchange=\"alterarMensalidadeOpExtra()\">";
                    } else {
                        echo "<select name=\"mensalidade\" id=\"mensalidade\">";
                    }
                } else {
                    echo "<select name=\"mensalidade\" id=\"mensalidade\">";
                }
            ?>
            
                <option value="<?= $verificaMensalidade[0]['cod_mensalidade'] ?>"><?= $verificaMensalidade[0]['nome_mensalidade'] ?> - (atual)</option>
                <?php
                    $param = [
                        ":cod_mensalidade" => $verificaMensalidade[0]['cod_mensalidade']
                    ];
                    $buscaMensalidades = $gst->exe_query("
                    SELECT * FROM mensalidades 
                    WHERE cod_mensalidade <> 1 AND cod_mensalidade <> :cod_mensalidade", $param);
                    if(count($buscaMensalidades) > 0) {
                        for($i = 0; $i < count($buscaMensalidades); $i++) {
                            echo '<option value="'.$buscaMensalidades[$i]['cod_mensalidade'].'">'.$buscaMensalidades[$i]['nome_mensalidade'].' - '.preco($buscaMensalidades[$i]['preco']).'</option>';
                        }
                    }
                ?>
            </select>

            <div id="alterarMensalidadeAtual" style="display: none; margin-top: 15px; margin-bottom: 15px;">
                <input type="checkbox" name="alterarMensalidadeAtual" style="width: 20px; height: 15px;">Tornar a mensalidade deste mês
                <p><small>Esta opção irá alterar o tipo de mensalidade para o mês atual</small></p>
            </div>
        </label>
        <input type="hidden" name="acao" value="muda-mensalidade">
        <input type="submit" style="margin-top: 15px; width: 200px; border-radius: 10px;" value="Selecionar mensalidade">
        <br>
        <p class="text_center" style="font-size: 12px;">Algum possivel desconto apenas será aplicado no establecimento.</p>
        
        <script>
            function alterarMensalidadeOpExtra() {
                var selectMensalidade = document.getElementById('mensalidade');
                var chkboxOpExtra = document.getElementById('alterarMensalidadeAtual');

                if(chkboxOpExtra.style.display == 'none') {
                    chkboxOpExtra.style.display = 'block';
                }
            }
        </script>
    </form>
</div>

<?php
    }
?>

<script src="js/ajax.js"></script>