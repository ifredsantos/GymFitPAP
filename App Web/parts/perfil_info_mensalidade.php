<?php
    // ==================================================
    // Este script é carregado para a pagina do perfil via request de ajax
    // É chamado quando o utilizador clica em uma mensalidade que quer ver como por ex Janeiro/2019
    // Deverá mostrar os detalhes da mensalidade como o nome da mesma bem como o preço e o desconto caso exista
    // Deverá ser calculado um total a pagar e por fim um botão para cancelar a mensalidade e para a pagar
    // ==================================================

    include("../config.php");

    if(isset($_GET['mes'], $_GET['ano'], $_GET['cod_aquisicao']) && !empty($_GET['mes']) && !empty($_GET['ano'])) {
        if(!isset($_SESSION['cod_user'])) {
            header('Location: '.APP_URL.'home/msg/acesso-restrito');
        }
        
        // Variáveis recebidas pelo request do ajax
        $mes = $_GET['mes'];
        $ano = $_GET['ano'];
        $codAquisicao = $_GET['cod_aquisicao'];

        $html = "";

        // Busca a informação pretendida
        $param = [
            ":cod_utilizador" => $_SESSION['cod_user'],
            ":mes" => $mes,
            ":ano" => $ano,
            ":cod_aquisicao" => $codAquisicao
        ];
        $buscaInfMensalidade = $gst->exe_query("
        SELECT cod_mensalidadePagamento, nome_mensalidade, preco, nome_desconto, valor_desconto, 
        valor_pago, MP.mes, MP.ano, MP.data_pagamento, cancelado, fatura, S.data_pagamento AS data_pagamento_seguro 
        FROM mensalidades_aquisicoes MAQ 
            INNER JOIN mensalidades_pagamentos MP ON MAQ.cod_aquisicao = MP.aquisicao 
            INNER JOIN mensalidades M ON MAQ.mensalidade = M.cod_mensalidade 
            INNER JOIN mensalidades_descontos MD ON MAQ.desconto = MD.cod_desconto 
            INNER JOIN seguros S ON MP.cod_utilizador = S.utilizador 
        WHERE MAQ.utilizador = :cod_utilizador AND MP.mes = :mes AND MP.ano = :ano AND aquisicao = :cod_aquisicao", $param);

        // Aguarda 1 segundo
        sleep(1);
        
        if (count($buscaInfMensalidade) > 0) {
            // Verifica se o seguro foi pago neste mês
            $ano = $buscaInfMensalidade[0]['ano'];
            $mes = $buscaInfMensalidade[0]['mes'];
            $inicioDoMes = $ano."-".$mes."-01";
            $data_pagamento_seguro = $buscaInfMensalidade[0]['data_pagamento_seguro'];
            $ultimoDiaDoMes = date("t", mktime(0,0,0,$mes,'01',$ano));
            $fimDoMes = $ano."-".$mes."-".$ultimoDiaDoMes;

            if($data_pagamento_seguro != null && strtotime($data_pagamento_seguro) >= strtotime($inicioDoMes) && 
            strtotime($data_pagamento_seguro) <= strtotime($fimDoMes) || $data_pagamento_seguro == null) {
                $txtSeguro = '<dd>
                                <span>Seguro</span>
                                <span class="price">'.preco(SEGURO).'</span>
                            </dd>';
                $seguro = SEGURO;
            } else {
                $txtSeguro = "";
                $seguro = 0.00;
            }
            
            $valorPagar = ($buscaInfMensalidade[0]['preco'] - $buscaInfMensalidade[0]['valor_desconto']) + $seguro;

            $html .= '<div class="inf-mensalidade">
                        <dl>
                            <dt>
                                <span>mensalidade</span>';

            // Se estiver por pagar
            if($buscaInfMensalidade[0]['data_pagamento'] == null && $buscaInfMensalidade[0]['valor_pago'] == null && $buscaInfMensalidade[0]['cancelado'] == "n") {
                $html .= '<span class="price">'.preco($valorPagar).' - <span style="color: orange">Por pagar</span></span>
                        </dt>';
            }

            // Se estiver pago
            else if($buscaInfMensalidade[0]['data_pagamento'] != null && $buscaInfMensalidade[0]['valor_pago'] != null && $buscaInfMensalidade[0]['cancelado'] == "n") {
                $html .= '<span class="price">'.preco($valorPagar).' - <span style="color: green">Pago</span></span>
                        </dt>';
            }

            // Se estiver cancelada
            else if($buscaInfMensalidade[0]['cancelado'] == "s") {
                $html .= '<span class="price"><s>'.preco($valorPagar).'</s> - <span style="color: red">Cancelada</span></span>
                        </dt>';
            } else {
                $html .= '<span class="price">'.preco($valorPagar).'</span>
                        </dt>';
            }

            $html .= '<dd>
                        <span>'.$buscaInfMensalidade[0]['nome_mensalidade'].'</span>
                        <span class="price">'.preco($buscaInfMensalidade[0]['preco']).'</span>
                    </dd>';

            $html .= $txtSeguro;

            if($buscaInfMensalidade[0]['valor_desconto'] > 0.00) {
            $html .= '<dd>
                        <span>'.$buscaInfMensalidade[0]['nome_desconto'].'</span>
                        <span class="price">- '.preco($buscaInfMensalidade[0]['valor_desconto']).'</span>
                    </dd>';
            }

            // Se a mensalidade já estiver paga aparece a fatura
            if($buscaInfMensalidade[0]['data_pagamento'] != null && $buscaInfMensalidade[0]['valor_pago'] != null && $buscaInfMensalidade[0]['cancelado'] == "n") {
                $html .= '<hr style="border: 1.5px solid #262626; width: 100%"><dd>
                            <span>Fatura</span>
                            <a href = "'.APP_URL.'posts/faturas/'.$buscaInfMensalidade[0]['fatura'].'.pdf" target="_blank" class="price">'.$buscaInfMensalidade[0]['fatura'].'</a>
                        </dd>';
            }

            $html .= '<div class="clearfix"></div></dl>
                    </div>';

            // Se estiver por pagar aparece os botões para cancelar ou pagar
            if($buscaInfMensalidade[0]['data_pagamento'] == null && $buscaInfMensalidade[0]['valor_pago'] == null && $buscaInfMensalidade[0]['cancelado'] == "n") {
                $html .= '<button class="button" type="button"><a onclick="document.getElementById(\'msg-space-modal-canelarMensalidade\').style.display=\'block\';">Cancelar</a></button>';

                $html .= '<div class="msg-space-modal" id="msg-space-modal-canelarMensalidade" style="display: none">
                            <div class="msg-content-modal">
                                <h2 class="text_center">Tem a certeza de deseja anular esta mensalidade?</h2>
                                <p class="text_center"><u>Atenção a este procedimento!</u> Ao anular esta mensalidade o processo será irreversivel.</p>
                                <div class="space-buttons">
                                    <button type="button" style="float: left; background-color: #efefef;">
                                        <a onclick="document.getElementById(\'msg-space-modal-canelarMensalidade\').style.display=\'none\';" style="color: black;">Fechar</a>
                                    </button>
                                    <button type="button" style="float: right; background-color: darkred;">
                                        <a style="color: #efefef;" href="'.APP_URL.'perfil.php?target=mensalidades&acao=cancelar&id='.$buscaInfMensalidade[0]['cod_mensalidadePagamento'].'">Anular mensalidade</a>
                                    </button>
                                </div>
                            </div>
                        </div>';
            }
            echo $html;
        }
        // Se não encontrar dados para a mensalidade em questão informa
        else {
            echo "<p>Não existe dados para esta data.</p>";
        }
    }
?>