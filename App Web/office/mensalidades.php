<?php
    include("../config.php");
    include("verifica-acesso.php");

    $msg = "";

    // Informações de data
    $dataAtual = date("Y-m-d");
    $diaAtual = date("d");
    $mesAtual = date("m");
    $anoAtual = date("Y");
    $dataMinPagamento = $anoAtual."-".($mesAtual-1)."-15";
    $dataMaxPagamento = date('Y-m-'. DIAPAGAMENTO);
    // ==================================================




    // ==================================================
    // Pagamento de uma mensalidade
    // ==================================================
    if(isset($_POST['acao']) && $_POST['acao'] == "pagarMensalidade") {
        $valorPago = $_POST['valor'];
        $codMP = $_POST['mensalidadePagamentoID'];
        $existeSeguro = $_POST['existeSeguro'];

        // Verifica se irá enviar um email de faturação posteriormente
        if(isset($_POST['enviaEmail']) && $_POST['enviaEmail'] == "on") {
            $enviaEmail = "s";
        } else {
            $enviaEmail = "n";
        }
        
        $param = [
            ":valor_pago" => $valorPago,
            ":cod_mensalidade_pagamento" => $codMP
        ];

        // Faz um update no qual o cliente já pagou a mensalidade
        $pagamento = $gst->exe_non_query("
        UPDATE mensalidades_pagamentos 
        SET valor_pago = :valor_pago, data_pagamento = NOW()
        WHERE cod_mensalidadePagamento = :cod_mensalidade_pagamento", $param);

        if($pagamento) {
            $msg .= MSGsuccess("Sucesso", "Mensalidade paga com sucesso", "");

            // Consulta informações relativamente ao utilizador em questão e a mensalidade
            // para que postriormente seja criada uma fatura e um possivel email
            $param = [
                ":cod_mensalidade_pagamento" => $codMP
            ];
            $buscaInf = $gst->exe_query("
            SELECT U.cod_utilizador, U.nome, U.email, U.telefone, U.genero, 
            MP.valor_pago, MP.mes, MP.ano, MP.data_pagamento, 
            M.nome_mensalidade, M.preco, 
            MD.nome_desconto, MD.valor_desconto 
            FROM utilizadores U 
                INNER JOIN mensalidades_aquisicoes MAQ ON U.cod_utilizador = MAQ.utilizador 
                INNER JOIN mensalidades M ON MAQ.mensalidade = M.cod_mensalidade 
                INNER JOIN mensalidades_descontos MD ON MAQ.desconto = MD.cod_desconto 
                INNER JOIN mensalidades_pagamentos MP ON MP.cod_utilizador = U.cod_utilizador 
            WHERE MP.cod_mensalidadePagamento = :cod_mensalidade_pagamento AND MAQ.atual LIKE 's'", $param);
            $dados = $buscaInf[0];
            
            // Adquire os dados da consulta anterior
            $codClient = $dados['cod_utilizador'];
            $nomeCliente = $dados['nome'];
            $mesPagamento = $dados['mes'];
            $anoPagamento = $dados['ano'];
            $dataPagamento = $dados['data_pagamento'];
            $telefone = $dados['telefone'];

            $nomeMensalidade = $dados['nome_mensalidade'];
            $precoMensalidade = $dados['preco'];

            $nomeDesconto = $dados['nome_desconto'];
            $valorDesconto = $dados['valor_desconto'];

            $valorPago = $dados['valor_pago'];

            $valorPagar = $precoMensalidade + SEGURO - $valorDesconto;
            $valorPorPagar = $valorPagar - $valorPago;
            // ==================================================


            
            // Se não existir seguro
            $param = [
                ":utilizador" => $codClient
            ];
            $seguro = $gst->exe_non_query("UPDATE seguros SET data_pagamento = NOW() WHERE utilizador = :utilizador", $param);

            if($seguro) {
                $msg .= MSGsuccess("Sucesso", "Seguro pago com sucesso", "");
            } else {
                $msg .= MSGdanger("Ocorreu um erro", "Ocorreu um erro ao pagar o seguro", "");
            }
            // ==================================================  
            
            

            // Cria um nº de fatura
            $numFatura = "COMP ".$mesPagamento.mt_rand(1, 99999);

            // Cria uma um ficheiro de faturação com os dados obtidos anteriormente
            criaFatura($mesPagamento, $anoPagamento, $nomeCliente, $telefone, $numFatura, 
            $dataPagamento, $valorPagar, $valorPago, $valorPorPagar, $nomeMensalidade, 
            $precoMensalidade, $nomeDesconto, $valorDesconto, $existeSeguro);
            
            // Realiza um update com o nº da fatura
            $param = [
                ":fatura" => $numFatura,
                ":cod_mensalidade_pagamento" => $codMP
            ];
            $guardaUpFatura = $gst->exe_non_query("
            UPDATE mensalidades_pagamentos 
            SET fatura = :fatura 
            WHERE cod_mensalidadePagamento = :cod_mensalidade_pagamento", $param);
            // ==================================================



            // Se escolheu a opção de enviar email de faturação
            if($enviaEmail == 's') {
                // Prepara o texto do email
                $email_assunto = "Envio de comprovativo de pagamento: ".$numFatura." de ".meses($dados['mes'])."/".encortaAno($dados['ano']);
                
                if($dados['genero'] == "m") {
                    $email_msg1 = "Sr. ".$dados['nome'];
                } else {
                    $email_msg1 = "Sra. ".$dados['nome'];
                }

                $email_msg2 = "Informamos que foi realizado o pagamento da mensalidade com sucesso!
                <h3>Dados</h3>
                <p>Data de pagamento: ".ptdate($dados['data_pagamento'])."<br>
                Valor pago: ".preco($dados['valor_pago'])."<br>
                Tipo transação: Pagamento no estabelecimento</p>";
                $email_msg3 = "Enviamos em anexo o comprovativo de pagamento do mês de <b>".meses($dados['mes'])." de ".$dados['ano']."</b> que, 
                durante 12 meses, estará também disponível na Área de Cliente, <a href=\"". APP_URL ."/perfil/mensalidades\">aqui</a>, para consulta ou download.
                <p>Para alterar as proximas mensalidades ou consultar os detalhes da mesma também poderá aceder à sua Área de Cliente.</p>";
                
                $email_msg4 = "Caso tenha alguma questão use o <a href=\"". APP_URL."#contactos" . "\">formulário de contactos</a>.<br>
                Ficamos muito gratos por têlo connosco.
                <p>Consulte o seu comprovativo de pagamento aqui <a href='".APP_URL_OFFICE.CAM_FATURAS.$numFatura.".pdf'>aqui</a>.</p>
                <p style=\"font-size: 9px;\">Para visualizar a sua fatura precisa de ter a versão 6 ou superior do <a href=\"https://www.acrobat.com/\">Acrobat Reader</a>.<br>
                Este e-mail foi gerado automaticamente. Por favor não responda para este endereço.</p>";

                // Cria o conteudo do email com o design
                $txt_email = emailDefault($email_assunto, $email_msg1, $email_msg2, 
                $email_msg3, $email_msg4);

                // Envia email de faturação
                if(enviaEmail($dados['email'], $dados['nome'], $email_assunto, 
                $txt_email, CAM_FATURAS."$numFatura.pdf", "") == true) {
                    $msg .= MSGinfo("Sucesso", "Comprovativo de pagamento enviado com sucesso", "");
                } else {
                    $msg .= MSGdanger("Ocorreu um erro", "Ocorreu um erro ao enviar o comprovativo de pagamento", "");
                }
            }
        } else {
            $msg .= MSGdanger("Ocorreu um erro", "Ocorreu um erro a pagar a mensalidade", "");
        }
    }
    // ==================================================




    // ==================================================
    // Anular uma mensalidade e/ou aquisão atual do utilizador
    // ==================================================
    if(isset($_POST['acao']) && $_POST['acao'] == "anularMensalidade") {
        $codUtilizador = $_POST['clienteID'];
        $mensalidadeID = $_POST['mensalidadeID'];

        $param = [":cod_mensPagamento" => $mensalidadeID];
        $cancelaMensalidade = $gst->exe_non_query("
        UPDATE mensalidades_pagamentos SET cancelado = 's'WHERE cod_mensalidadePagamento = :cod_mensPagamento", $param);
    
        if($cancelaMensalidade)
            $msg .= MSGinfo("Sucesso", "A mensalidade pretendida foi cancelada", "");
        else
            $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel cancelar a mensalidade pretendida", "");
    }
    // ==================================================




    // ==================================================
    // Gestão de mensalidades
    // ==================================================
    // Busca os dados dos utilizadores e as suas mensalidades atuais
    $buscaClientes = $gst->exe_query("
    SELECT U.cod_utilizador, MAQ.cod_aquisicao, MAQ.mensalidade 
    FROM mensalidades_aquisicoes MAQ 
        INNER JOIN utilizadores U ON MAQ.utilizador = U.cod_utilizador ");

    if(count($buscaClientes) > 0) {
        for($i = 0; $i < count($buscaClientes); $i++) {
            $usersNotPay = $buscaClientes[$i];
            $codUser = $usersNotPay['cod_utilizador'];
            $codAquisicao = $usersNotPay['cod_aquisicao'];
            $mensalidadeUser = $usersNotPay['mensalidade'];

            // Verifica se tem seguro 
            $param = [
                ":cod_utilizador" => $codUser
            ];
            $verificaExisteSeguro = $gst->exe_query("
            SELECT * FROM seguros WHERE utilizador = :cod_utilizador", $param);
            
            // Se não existir seguro regista da base de dados para postriormente ser atualizado com o pagamento
            if(count($verificaExisteSeguro) == 0) {
                $param = [
                    ":cod_user" => $codUser,
                    ":ano" => $anoAtual
                ];
                $seguroPre = $gst->exe_non_query("
                INSERT INTO seguros (utilizador, ano)
                VALUES (:cod_user, :ano)", $param);
            }
                
            $param = [
                ":cod_aquisicao" => $codAquisicao,
                ":mes_atual" => $mesAtual
            ];

            // Verifica se os utilizadores anteriores tem registo de mensalidade para o mês atual
            $verificaExisteRegisto = $gst->exe_query("
            SELECT MP.cod_utilizador, MP.mes, M.cod_mensalidade, MP.cancelado 
            FROM mensalidades_pagamentos MP 
                INNER JOIN mensalidades_aquisicoes MAQ ON MP.cod_utilizador = MAQ.utilizador
                INNER JOIN mensalidades M ON MAQ.mensalidade = M.cod_mensalidade
            WHERE MP.aquisicao = :cod_aquisicao AND MP.mes = :mes_atual", $param);
            //echo "<pre>";
            //var_dump($verificaExisteRegisto);
            //echo "</pre>";

            for($x = 0; $x < count($verificaExisteRegisto); $x++)
            {
                // Caso não tenha registo de mensalidade para o mês atual vai criar um registo
                if(count($verificaExisteRegisto) == 0 && $mensalidadeUser != 1 && $verificaExisteRegisto[$x]["cancelado"] == 'n') {
                    $param = [
                        ":cod_user" => $codUser,
                        ":cod_aquisicao" => $codAquisicao,
                        ":mes_atual" => $mesAtual,
                        ":ano_atual" => $anoAtual
                    ];
                    $regPorPagar = $gst->exe_non_query("
                    INSERT INTO mensalidades_pagamentos(cod_utilizador, aquisicao, mes, ano) 
                    VALUES (:cod_user, :cod_aquisicao, :mes_atual, :ano_atual)", $param);
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang = "pt-pt">
	<head>
        <base href="<?= APP_URL_OFFICE ?>" />
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="content-language" content="pt">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
        <meta name="author" content="Fredinson, fredinsondev@gmail.com">
        <meta name="reply-to" content="fredinsondev@gmail.com">
        <meta http-equiv="cache-control" content="private">
        <title>Office - <?= APP_NAME; ?></title>
        <link rel = "stylesheet" type = "text/css" href = "layout/css/design.css">
        <script src="js/jquery-1.11.1.min.js"></script>
        <link href="layout/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="js/bootstrap.min.js"></script>
        <script src="js/js_mod_tables.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
        <link rel="icon" href="layout/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="layout/favicon.ico" type="image/x-icon">
	</head>
    
    <body>
        <header>
            <div class = "top-bar">
                <a href = "<?= APP_URL ?>"><h1><?= APP_NAME; ?> - Office</h1></a>
                
                <div class = "top-bar-icons">
                    <img src = "layout/user.png" alt = "User" onclick="abrePopUp()">
                </div>
            </div>
            
            <?php include("parts/inf_user.php") ?>
        </header>
        
        <article>
            <?php include ("parts/header.php"); ?>
            
            <!-- Cabeçalho de hiperligações -->
            <div class = "col-md-10 offset-md-2">
            <?php
                if($msg != "")  { ?>
            <div class="msg-space-modal" id="msg-space-modal">
                <div class="msg-content-modal">
                    <br>
                    <?= $msg ?>
                </div>
            </div>
            <?php } ?>
                <div class = "trace-link col-xs-12 col-sm-12 col-md-12">
                    <p><a id = "trace-link-main" href = "mensalidades">Mensalidades</a></p>
                </div>
            </div>

            <div class = "col-md-10 offset-md-2">
                <div class="panel panel-default panel-table">
                    <!-- Cabeçalho de pesquisas -->
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-6">
                                <form method="post" action="mensalidades">
                                    <div id="custom-search-input">
                                        <div class="input-group col-md-12">
                                            <input name="pesquisa"
                                                   type="text"
                                                   class="form-control"
                                                   placeholder="Pesquisar">
                                            <input type="hidden" name="acao" value="pesquisar">
                                            <span class="input-group-btn">
                                                <button class="btn btn-info btn-lg" type="button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col col-xs-6 text-right">
                                <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#pagarMensalidade" style="height: 42px; display:none">Adicionar pagamento</button>
                            </div>
                        </div>
                    </div>

                    <!-- Formulário para pagar a mensalidade de um cliente -->
                    <div class="modal fade" id="pagarMensalidade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">Pagamento de mensalidade</h3>
                                </div>
                                <div class="modal-body">
                                    <form name="pagarMensalidade" action="mensalidades" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="mensalidade">Mensalidade</label>
                                                <input name="mensalidade" 
                                                       id="mensalidade" 
                                                       type="text" 
                                                       class="form-control" 
                                                       placeholder="Mensalidade"
                                                       readonly
                                                       required>
                                            </div>
                                            
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="desconto">Desconto</label>
                                                <input name="desconto"
                                                       id="desconto"
                                                       type="text" 
                                                       class="form-control" 
                                                       placeholder="Desconto"
                                                       readonly
                                                       required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="valor">Valor a pagar</label>
                                                <input name="valor" 
                                                    id="valor"
                                                    type="number" 
                                                    step="any" 
                                                    class="form-control" 
                                                    placeholder="Valor a pagar"
                                                    required>
                                            </div>
                                            
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="mes">Mês</label>
                                                <input name="mes"
                                                       id="mes"
                                                       type="text" 
                                                       class="form-control" 
                                                       placeholder="Mês"
                                                       readonly
                                                       required>
                                            </div>
                                        </div>

                                        <!-- <div class="clearfix"></div>
                                        <br>
                                        <div class="form-group">
                                            <label for="nome">Seguro por pagar</label>
                                            <input name="nome" 
                                                   id = "nome" 
                                                   type="checkbox" 
                                                   class="form-control" 
                                                   readonly
                                                   required>
                                        </div> -->

                                        <div class="clearfix"></div>
                                        <br>
                                        <div class="form-group">
                                            <label for="nome">Nome de cliente</label>
                                            <input name="nome" 
                                                   id = "nome" 
                                                   type="text" 
                                                   class="form-control" 
                                                   placeholder="Nome de cliente"
                                                   readonly
                                                   required>
                                        </div>
                                        
                                        <div class="form-group" id="ckb_existeSeguro" style="display: none;">
                                            <input style="width: 15px; height: 15px; float: left; margin-right: 5px;" 
                                                type="checkbox" 
                                                class="form-control" 
                                                checked="checked" disabled>
                                            <span>Pagar seguro</span>
                                        </div>

                                        <div class="form-group">
                                            <input style="width: 15px; height: 15px; float: left; margin-right: 5px;" 
                                                type="checkbox" 
                                                name="enviaEmail" 
                                                id="enviaEmail" 
                                                class="form-control" 
                                                checked="checked">
                                            <span>Enviar comprovativo de pagamento</span>
                                        </div>
                                        
                                        <div class="modal-footer clearfix">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Fechar</button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <input type="hidden" id="mensalidadePagamentoID" name="mensalidadePagamentoID">
                                                    <input type="hidden" name="existeSeguro" id="existeSeguro">
                                                    <input type="hidden" name="acao" value="pagarMensalidade">
                                                    <button type="submit" class="btn btn-default btn-hover-green" data-action="save" role="button">Pagar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulário de anular a mensalidade atual de um utilizador -->
                    <div class="modal fade" id="anularMensalidade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">Anular uma mensalidade</h3>
                                </div>
                                <div class="modal-body">
                                    <form name="anularMensalidade" action="mensalidades" method="post" enctype="multipart/form-data">
                                        <h4>Deseja realmente anular a mensalidade desde utilizador?</h4>
                                        <p>Esta ação será irreversivel.</p>

                                        <div class="modal-footer clearfix">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Não</button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <input type="hidden" id="clienteID" name="clienteID">
                                                    <input type="hidden" id="mensalidadeID" name="mensalidadeID">
                                                    <input type="hidden" name="acao" value="anularMensalidade">
                                                    <button type="submit" class="btn btn-default btn-hover-green" data-action="save" role="button">Sim</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabela -->
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-list text-center">
                            <!-- Cabeçalho da tabela -->
                            <thead>
                                <tr>
                                    <th><em class="fa fa-cog"></em></th>
                                    <th>Nome</th>
                                    <th>Mensalidade</th>
                                    <th>Desconto</th>
                                    <th>Total a pagar</th>
                                    <th>Estado</th>
                                    <th>Mês</th>
                                    <th>Data pagamento</th>
                                </tr>
                            </thead>

                            <!-- Corpo da tabela -->
                            <tbody>
                            <?php
                                $quantidade = 10;
                                $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
                                $inicio = ($quantidade * $pagina) - $quantidade;
                                
                                // Se existir pesquisa
                                if(isset($_POST['acao']) && $_POST['acao'] == "pesquisar")
                                {
                                    if(isset($_POST['acao']))
                                        $pesquisa = $_POST['pesquisa'];
                                    else if(isset($_GET['pesquisa']))
                                        $pesquisa = $_GET['pesquisa'];
                                    
                                    $pesq_nome = '%'.$pesquisa.'%';
                                    
                                    $sqlPesquisa = sprintf("WHERE 
                                        U.cod_utilizador = '%s' OR 
                                        U.nome LIKE '%s' OR 
                                        M.nome_mensalidade LIKE '%s' OR 
                                        D.nome_desconto LIKE '%s' OR 
                                        MP.mes = '%s' OR 
                                        MP.ano = '%s'", $pesquisa, $pesq_nome, $pesquisa, $pesquisa, $pesquisa, $pesquisa);
                                    if($pesquisa == "")
                                        $sqlPesquisa = "";
                                }
                                else {
                                    $sqlPesquisa = "";
                                }
                                
                                // Busca as informações do cliente bem como a sua mensalidade e descontos
                                $buscaClientes = $gst->exe_query("
                                SELECT MP.cod_mensalidadePagamento, 
                                U.cod_utilizador, U.nome, 
                                M.nome_mensalidade, M.preco, 
                                D.nome_desconto, D.valor_desconto, 
                                MP.valor_pago, MP.mes, MP.ano, MP.data_pagamento, MP.cancelado 
                                FROM mensalidades_pagamentos MP  
                                    INNER JOIN mensalidades_aquisicoes MAQ ON MP.aquisicao = MAQ.cod_aquisicao 
                                    INNER JOIN mensalidades M ON MAQ.mensalidade = M.cod_mensalidade 
                                    INNER JOIN mensalidades_descontos D ON MAQ.desconto = D.cod_desconto 
                                    INNER JOIN utilizadores U ON U.cod_utilizador = MP.cod_utilizador 
                                $sqlPesquisa ORDER BY MP.mes DESC, MP.ano DESC, U.nome 
                                LIMIT $inicio, $quantidade");
                                
                                // Conta o total de utilizadores que tiverem um mensalidade atual
                                $contaClientes = $gst->exe_query("
                                SELECT MP.cod_mensalidadePagamento 
                                FROM mensalidades_pagamentos MP  
                                    INNER JOIN mensalidades_aquisicoes MAQ ON MP.aquisicao = MAQ.cod_aquisicao 
                                    INNER JOIN mensalidades M ON MAQ.mensalidade = M.cod_mensalidade 
                                    INNER JOIN mensalidades_descontos D ON MAQ.desconto = D.cod_desconto 
                                    INNER JOIN utilizadores U ON U.cod_utilizador = MP.cod_utilizador 
                                $sqlPesquisa ORDER BY MP.mes DESC, U.nome");
                                $resultados = count($contaClientes);

                                // Inicio do sistema de paginação
                                $totalPagina = ceil($resultados/$quantidade); // Páginas a serem mostradas ex 1 | 2 | 3
                                $exibir = 10; // Nº de clientes a exibir por página
                                $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
                                $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
                                
                                if($resultados > 0) {
                                    for($i = 0; $i < count($buscaClientes); $i++) {
                                        $infCliente = $buscaClientes[$i];

                                        // Informações do utilizador
                                        $codCliente = $infCliente['cod_utilizador'];
                                        $codMensalidadePagamento = $infCliente['cod_mensalidadePagamento'];
                                        $nome = $infCliente['nome'];
                                        $nomeMensalidade = $infCliente['nome_mensalidade'];
                                        $nomeDesconto = $infCliente['nome_desconto'];
                                        $descontoMensalidade = $infCliente['valor_desconto'];
                                        $ano = $infCliente['ano'];
                                        $mes = $infCliente['mes'];
                                        $valorPagar = $infCliente['preco'] - $infCliente['valor_desconto'];
                                        $data_pagamento = $infCliente['data_pagamento'];

                                        // Verifica se o utilizador tem o seguro em dia
                                        $param = [
                                            ":cod_user" => $codCliente,
                                            ":ano" => $anoAtual
                                        ];
                                        $verificaSeguro = $gst->exe_query("
                                        SELECT data_pagamento FROM seguros WHERE utilizador = :cod_user AND ano = :ano", $param);
                                        $dataPagamentoSeguro = $verificaSeguro[0]['data_pagamento'];

                                        if($verificaSeguro[0]["data_pagamento"] != "" || $verificaSeguro[0]["data_pagamento"] != null) {
                                            $existeSeguro = 's';
                                        } else {
                                            $existeSeguro = 'n';
                                        }
                            ?>
                                <tr>
                                    <?php
                                        $dataMinimaPagamento = $infCliente['ano'] . "-" . ($infCliente['mes']-1) . "-" . DIAPAGAMENTO;
                                        $dataLimitePagamento = $infCliente['ano'] . "-" . sprintf("%02d", $infCliente['mes']) . "-" . DIAPAGAMENTO;
                                    ?>
                                    <td align="center">
                                        <?php
                                            if($data_pagamento == null && $infCliente['cancelado'] == 'n') {
                                        ?>
                                        <a data-toggle="modal" data-target="#pagarMensalidade" 
                                        onclick="preparaCliente('<?= $codMensalidadePagamento ?>', '<?= $nome ?>', '<?= str_replace(',', '.', $valorPagar+SEGURO) ?>', '<?= $nomeMensalidade ?>', '<?= $nomeDesconto ?>', '<?= $mes ?>', '<?= $existeSeguro ?>')" class="btn btn-default">
                                        <em class="fa fa-pencil"></em></a>
                                        <?php
                                            } else {
                                        ?>
                                        <a class="btn btn-default" disabled>
                                        <em class="fa fa-pencil"></em></a>
                                        <?php
                                            }
                                            if($infCliente['data_pagamento'] == null && $infCliente['cancelado'] != 's') {
                                        ?>
                                        <a data-toggle="modal" data-target="#anularMensalidade" onclick="removeMensalidadeCliente('<?= $codCliente ?>', '<?= $codMensalidadePagamento ?>')" class="btn btn-danger"><em class="fa fa-trash"></em></a>
                                        <?php
                                            }
                                        ?>
                                    </td>
                                    <td><?= $nome ?></td>
                                    <?php
                                        if($existeSeguro == 's') {
                                            // Verifica se o seguro foi pago neste mês
                                            $inicioDoMes = $ano."-".$mes."-01";
                                            $ultimoDiaDoMes = date("t", mktime(0,0,0,$mes,'01',$ano));
                                            $fimDoMes = $ano."-".$mes."-".$ultimoDiaDoMes;

                                            if(strtotime($data_pagamento) >= strtotime($inicioDoMes) && strtotime($data_pagamento) <= strtotime($fimDoMes)) {
                                                echo "<td>$nomeMensalidade + Seguro</td>";

                                            } else {
                                                echo "<td>$nomeMensalidade</td>";
                                            }
                                        } else
                                            echo "<td>$nomeMensalidade + Seguro</td>";
                                        echo "<td>$nomeDesconto</td>";
                                    ?>
                                    <?php
                                        // Se o utilizador não realizou o pagamento e a data ultrapassar o limite de pagamento
                                        if($dataAtual > $dataLimitePagamento && $data_pagamento == null && $infCliente['cancelado'] == 'n') {
                                            if($existeSeguro == 'n') {
                                                echo "<td style=\"color: red;\">".preco($valorPagar)." + ".preco(SEGURO)."</td>";
                                            } else {
                                                echo "<td style=\"color: red;\">".preco($valorPagar)."€</td>";
                                            }

                                            echo "<td style=\"color: red;\">Em atraso</td>";
                                            echo "<td>".meses($infCliente['mes'])."/".encortaAno($infCliente['ano'])."</td>";
                                            echo "<td></td>";
                                        }
                                        // Se o utilizador pagou 
                                        else if($infCliente['data_pagamento'] != null) {
                                            echo "<td>".preco($infCliente['valor_pago'])."</td>";

                                            echo "<td style=\"color: green;\">Pago</td>";
                                            echo "<td>".meses($infCliente['mes'])."/".encortaAno($infCliente['ano'])."</td>";
                                            echo "<td>".ptdate($infCliente['data_pagamento'])."</td>";
                                        }
                                        // Se o utilizador cancelou 
                                        else if($infCliente['cancelado'] == 's') {
                                            echo "<td><s>".preco($infCliente['preco'] - $infCliente['valor_desconto'])."</s></td>";

                                            echo "<td>Cancelado</td>";
                                            echo "<td>".meses($infCliente['mes'])."/".encortaAno($infCliente['ano'])."</td>";
                                            echo "<td>Cancelado</td>";
                                        }
                                        // Pendente de pagamento
                                        else {
                                            if($existeSeguro == 'n') {
                                                echo "<td style=\"color: darkorange\">".preco($valorPagar)." + ".preco(SEGURO)."</td>";
                                            } else {
                                                echo "<td style=\"color: darkorange\">".preco($valorPagar)."€</td>";
                                            }

                                            echo "<td style=\"color: orange;\">Pendente</td>";
                                            echo "<td>".meses($infCliente['mes'])."/".encortaAno($infCliente['ano'])."</td>";
                                            echo "<td style=\"color: orange;\">Pendente</td>";
                                        }
                                    ?>
                                </tr>
                            <?php
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Rodapé da tabela -->
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col col-xs-3">Página <?= $pagina ?> de <?php if($totalPagina == 0) echo "1"; else echo $totalPagina; ?>
                            </div>
                            
                            <div class="col col-xs-3">
                                <?php
                                    if(isset($_POST['action']) && $_POST['action'] == "pesquisar" && $_POST['pesquisa'] != "")
                                    {
                                ?>
                                <p>Pesquisa por: <b><?= $_POST['pesquisa'] ?></b></p>
                                <?php
                                    }
                                    else if(isset($_GET['pesquisa']) && $_GET['pesquisa'] != "")
                                    {
                                ?>
                                <p>Pesquisa por: <b><?= $_GET['pesquisa'] ?></b></p>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                <p>Número de resultados: <?= $resultados ?></p>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="col col-xs-6">
                                <ul class="pagination hidden-xs pull-right">
                                    <?php
                                        if(isset($_POST['action']))
                                            $pesquisa = $_POST['pesquisa'];
                                        else if(isset($_GET['pesquisa']))
                                            $pesquisa = $_GET['pesquisa'];
                                        else
                                            $pesquisa = "";
                                    
                                        echo "<li><a href=\"mensalidades/1/$pesquisa\">&laquo;</a></li>";
                                        echo "<li><a href=\"mensalidades/$anterior/$pesquisa\">&lsaquo;</a></li>";
                                    
                                        for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                                            if($i > 0)
                                                echo "<li><a href=\"mensalidades/$i/$pesquisa\">$i</a></li>";
                                        }

                                        echo "<li><a href=\"mensalidades/$pagina/$pesquisa\"><strong>$pagina</strong></a></li>";

                                        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                                            if($i <= $totalPagina)
                                                echo "<li><a href=\"mensalidades/$i/$pesquisa\">$i</a></li>";
                                        }
                                        echo "<li><a href=\"mensalidades/$posterior/$pesquisa\">&rsaquo;</a></li>";
                                        echo "<li><a href=\"mensalidades/$totalPagina/$pesquisa\">&raquo;</a></li>";
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        
        <footer>
            
        </footer>
        <script src="js/main.js"></script>
    </body>
</html>