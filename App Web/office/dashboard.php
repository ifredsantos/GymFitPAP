<?php
    include("../config.php");
    include("verifica-acesso.php");

    $msg = "";

    $anoAtual = date('Y');
    $mesAtual = date('m');
    $diaAtual = date('d');

    $dataCompletaAtual = date('Y-m-d');
    $dataCompletaAtualHora = date('Y-m-d H:i:s');

    $horaAtual = date('H');
    $minutoAtual = date('i');
    $segundoAtual = date('s');

    // ==================================================
    // Página do estilo painel de controlo onde terá 
    // informações estatisticas bem como mensagens 
    // recentes entre outras funcionalidades
    // ==================================================

    // Nº total de clientes
    $buscaInfoDashBoard_NumClientes = $gst->exe_query("
    SELECT COUNT(username) AS NUM_CLIENTES FROM utilizadores");
    $DASH_numTotalClientes = $buscaInfoDashBoard_NumClientes[0]['NUM_CLIENTES'];

    // Nº de novos clientes no mês passado
    $mesAnterior = $mesAtual - 1;

    if($mesAtual != 1) {
        $dataInicio = $anoAtual."-".$mesAnterior."-01";
        $ultimoDiaDoMes = date("t", mktime(0,0,0,$mesAnterior,'01',$anoAtual));
        $dataFinal = $anoAtual."-".$mesAnterior."-".$ultimoDiaDoMes;
    } else {
        $dataInicio = ($anoAtual - 1)."-12-01";
        $ultimoDiaDoMes = date("t", mktime(0,0,0,$mesAnterior,'01',$anoAtual));
        $dataFinal = ($anoAtual - 1)."-12-".$ultimoDiaDoMes;
    }
    
    $param = [
        ":data_inicio" => $dataInicio,
        ":data_fim" => $dataFinal
    ];
    $buscaInfoDashBoard_NumNovosClientes = $gst->exe_query("
    SELECT COUNT(username) AS NUM_NOVOS_CLIENTES FROM utilizadores 
    WHERE data_adesao >= :data_inicio AND data_adesao <= :data_fim", $param);
    $DASH_numNovosClientes = $buscaInfoDashBoard_NumNovosClientes[0]['NUM_NOVOS_CLIENTES'];

    // Nº de clientes masculinos
    $buscaInfoDashBoard_NumGeneroMasculino = $gst->exe_query("
    SELECT COUNT(genero) AS NUM_MASCULINO FROM utilizadores WHERE genero LIKE 'm'");
    $DASH_numMasculino = $buscaInfoDashBoard_NumGeneroMasculino[0]['NUM_MASCULINO'];

    // Nº de clientes femininos
    $buscaInfoDashBoard_NumGeneroFeminino = $gst->exe_query("
    SELECT COUNT(genero) AS NUM_FEMININO FROM utilizadores WHERE genero LIKE 'f'");
    $DASH_numFeminino = $buscaInfoDashBoard_NumGeneroFeminino[0]['NUM_FEMININO'];

    // Nº de mensalidadades atuais
    $buscaNumMensalidadesAtuais = $gst->exe_query("
    SELECT COUNT(utilizador) AS NUM_UTILIZADORES_MENSALIDADE_ATUAIS FROM mensalidades_aquisicoes WHERE atual = 's'");
    $DASH_numUtilizadoresMensalidades = $buscaNumMensalidadesAtuais[0]["NUM_UTILIZADORES_MENSALIDADE_ATUAIS"];

    // Busca nº de utilizadores online há uma hora
    if($horaAtual != 1) {
        $data1horaAntes = $anoAtual."-".$mesAtual."-".$diaAtual." ".($horaAtual - 1).":".$minutoAtual.":".$segundoAtual;
    } else {
        $data1horaAntes = $anoAtual."-".$mesAtual."-".$diaAtual." 23:".$minutoAtual.":".$segundoAtual;
    }
    $param = [
        ":data_inicio" => $data1horaAntes,
        ":data_fim" => $dataCompletaAtualHora
    ];
    $buscaInfoDashBoard_Utilizadores1Hora = $gst->exe_query("
    SELECT COUNT(username) AS NUM_UTILIZADORES_1HORA FROM utilizadores WHERE data_ultimoAcesso >= :data_inicio AND data_ultimoAcesso <= :data_fim", $param);
    $DASH_numUtilizadores1Hora = $buscaInfoDashBoard_Utilizadores1Hora[0];

    include '../parts/inc_verifica_utilizadores_online.php';

    $utilizadoresOnline = $gst->exe_query("
    SELECT COUNT(username) AS NUM_UTILIZADORES_ONLINE 
    FROM utilizadores 
    WHERE online LIKE 's'");

    $DASH_numUtilizadoresOnline = $utilizadoresOnline[0]['NUM_UTILIZADORES_ONLINE'];

    $mes1inicio = date("Y-m-01", strtotime("-3 month"));
    $mes2inicio = date("Y-m-01", strtotime("-2 month"));
    $mes3inicio = date("Y-m-01", strtotime("-1 month"));
    $mes4inicio = date("Y-m-01");

    $mes1mes = date("m", strtotime("-3 month"));
    $mes2mes = date("m", strtotime("-2 month"));
    $mes3mes = date("m", strtotime("-1 month"));
    $mes4mes = date("m");

    $param = [
        ":data_inicio" => $mes1inicio,
        ":data_fim" => $mes2inicio
    ];
    $buscaNovosUtilizadores1mes = $gst->exe_query("
    SELECT COUNT(cod_utilizador) AS NUM_NOVOS_CLIENTES_1M FROM utilizadores WHERE data_adesao >= :data_inicio AND data_adesao < :data_fim", $param);
    $numUtilizadores1Mes = $buscaNovosUtilizadores1mes[0]["NUM_NOVOS_CLIENTES_1M"];

    $param = [
        ":data_inicio" => $mes2inicio,
        ":data_fim" => $mes3inicio
    ];
    $buscaNovosUtilizadores2mes = $gst->exe_query("
    SELECT COUNT(cod_utilizador) AS NUM_NOVOS_CLIENTES_2M FROM utilizadores WHERE data_adesao >= :data_inicio AND data_adesao < :data_fim", $param);
    $numUtilizadores2Mes = $buscaNovosUtilizadores2mes[0]["NUM_NOVOS_CLIENTES_2M"];

    $param = [
        ":data_inicio" => $mes3inicio,
        ":data_fim" => $mes4inicio
    ];
    $buscaNovosUtilizadores3mes = $gst->exe_query("
    SELECT COUNT(cod_utilizador) AS NUM_NOVOS_CLIENTES_3M FROM utilizadores WHERE data_adesao >= :data_inicio AND data_adesao < :data_fim", $param);
    $numUtilizadores3Mes = $buscaNovosUtilizadores3mes[0]["NUM_NOVOS_CLIENTES_3M"];

    $param = [
        ":data_inicio" => $mes1inicio
    ];
    $buscaNovosUtilizadores4mes = $gst->exe_query("
    SELECT COUNT(cod_utilizador) AS NUM_NOVOS_CLIENTES_4M FROM utilizadores WHERE data_adesao >= :data_inicio AND data_adesao < NOW()", $param);
    $numUtilizadores4Mes = $buscaNovosUtilizadores4mes[0]["NUM_NOVOS_CLIENTES_4M"];

    // Lubros do mês anterior
    $mesAnterior = date("Y-m-01", strtotime("-1 month"));
    $mesAnteriorMes = substr ($mesAnterior, 5, 2);
    $mesAnteriorAno = substr ($mesAnterior, 0, 4);
    
    $param = [
        ":mes" => $mesAnteriorMes,
        ":ano" => $mesAnteriorAno
    ];
    $buscaLucrosMensalidadesMesAnterior = $gst->exe_query("
    SELECT SUM(valor_pago) AS LUCRO FROM mensalidades_pagamentos WHERE mes = :mes AND ano = :ano", $param);
    $lucroMesAnterior = $buscaLucrosMensalidadesMesAnterior[0]["LUCRO"];

    // ================================================================

    // ==================================================
    // Responde a uma mensagem
    // ==================================================
    if(isset($_POST['acao']) && $_POST['acao'] == "responder_msg") {
        $id_msg = $_POST['id'];
        $utilizador = $_POST['utilizador'];
        $msg_do_utilizador = $_POST['mensagem_do_utilizador'];
        $msg_resposta = $_POST['resposta_a_mensagem'];

        $param = [
            ":cod_msg" => $id_msg
        ];
        $buscaEmail = $gst->exe_query("
        SELECT email_cliente FROM mensagens WHERE cod_msg = :cod_msg", $param);
        $email_utilizador = $buscaEmail[0]["email_cliente"];

        $email = emailDefault("Resposta à sua mensagem", "Referente a sua mensagem enviada através do formulário de contactos da página GymFit, 
        segue-se a sua mensagem bem como a sua resposta:", "Mensagem:<br>\"<i>".$msg_do_utilizador."</i>\"", "
        Resposta:<br>\"<i>".$msg_resposta."</i>\"", "Em caso de alguma dúvida disponha.");

        if(enviaEmail($email_utilizador, $utilizador, "Resposta à sua mensagem", $email, "", "")) {
            $param = [
                ":resposta" => $msg_resposta
            ];
            $update = $gst->exe_non_query("
            UPDATE mensagens SET respondida = 's', resposta = :resposta", $param);

            if($update) {
                $msg .= MSGsuccess("Sucesso", "Foi enviado um email de resposta ao utilizador em questão", "");
            } else {
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel enviar uma email de resposta ao utilizador em questão", "");
            }
        }
    }

    // ==================================================
    // Elimina um mensagem
    // ==================================================
    if(isset($_POST['acao'], $_POST['id']) && $_POST['acao'] == "apagar_msg" && $_POST['id'] != "") {
        $param = [
            ":cod_msg" => $_POST['id']
        ];
        $apagarMsg = $gst->exe_non_query("
        DELETE FROM mensagens WHERE cod_msg = :cod_msg", $param);
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
        <script type="text/javascript" src="js/loader.js"></script>

        <!-- Gráfico de novos clientes / vendas -->
        <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                ['Meses', 'Novos clientes'],
                ['<?= meses($mes1mes) ?>', <?= $numUtilizadores1Mes ?>],
                ['<?= meses($mes2mes) ?>', <?= $numUtilizadores2Mes ?>],
                ['<?= meses($mes3mes) ?>', <?= $numUtilizadores3Mes ?>],
                ['<?= meses($mes4mes) ?>', <?= $numUtilizadores4Mes ?>]
                ]);

                var options = {
                chart: {
                    title: 'Novos clientes',
                    subtitle: 'Novos clientes de <?= ptdate($mes1inicio) ?> a <?= date("d/m/Y") ?>',
                }
                };

                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        </script>

        <!-- Gráfico de géneros -->
        <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                ['Gênero', 'Nº de clientes'],
                ['Masculino', <?= $DASH_numMasculino ?>],
                ['Feminino', <?= $DASH_numFeminino ?>]
                ]);

                var options = {
                title: 'Gêneros',
                is3D: false,
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart_3d_generos'));
                chart.draw(data, options);
            }
        </script>
	</head>
    
    <body style="background-color: #ededed">
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

                <div class="space-dash-top-tabs" class="row">
                    <div class="dash-tab" style="background-color: #E24D4D;">
                        <p >Clientes / Novos (mês anterior)</p>
                        <h3><?= $DASH_numTotalClientes.' / '.$DASH_numNovosClientes ?></h3>
                    </div>

                    <div class="dash-tab" style="background-color: #FFB74D;">
                        <p>Online / Última hora</p>
                        <h3><?= $DASH_numUtilizadoresOnline ?> / <?= $DASH_numUtilizadores1Hora['NUM_UTILIZADORES_1HORA'] ?></h3>
                    </div>

                    <div class="dash-tab" style="background-color: #64B5F6;">
                        <p>Lucros do mês anterior</p>
                        <h3><?= preco($lucroMesAnterior) ?></h3>
                    </div>

                    <div class="dash-tab" style="background-color: #81C784; margin-right: 0;">
                        <p>Nº de mensalidades em curso</p>
                        <h3><?= $DASH_numUtilizadoresMensalidades ?></h3>
                    </div>
                </div>

                <div class="space_grafico" id="columnchart_material" style="float: left;"></div>
                <div class="space_grafico" id="piechart_3d_generos" style="float: right;"></div>

                <div class="modal fade" id="responderMsg" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <form action="dashboard" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                <h3 class="modal-title" id="lineModalLabel">Responder a uma mensagem</h3>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="mensagem_do_utilizador">Utilizador</label>
                                    <input type="text" 
                                           name="utilizador" 
                                           class="form-control" 
                                           readonly 
                                           id="ip_nome_utilizador">
                                </div>

                                <div class="form-group">
                                    <label>Mensagem do utilizador:</label>
                                    <textarea class="form-control" name="mensagem_do_utilizador" id="msg_a_responder" rows="6" readonly></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="resposta_a_msg">Resposta:</label>
                                    <textarea class="form-control" name="resposta_a_mensagem" rows="6"></textarea>
                                </div>

                                <div class="modal-footer clearfix">
                                    <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <input type="hidden" name="acao" value="responder_msg">
                                            <input type="hidden" name="id" id="input_id_msg">
                                            <button type="submit" class="btn btn-default btn-hover-green" role="button">Enviar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="eliminaMsg" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                <h3 class="modal-title" id="lineModalLabel">Eliminar uma mensagem</h3>
                            </div>
                            <div class="modal-body">
                                <h4 style="margin-top: 0;">Tem a certeza que deseja excluir a mensagem de <b id="nome_msg_excluir"></b>?</h4>

                                <div class="modal-footer clearfix">
                                    <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Não</button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <form action="dashboard" method="post">
                                                <input type="hidden" name="acao" value="apagar_msg">
                                                <input type="hidden" name="id" id="input_id_msg">
                                                <button type="submit" class="btn btn-default btn-hover-green" role="button">Sim</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space_msgs">
                    <div class="space_msg_header">
                        <h3>Mensagens recentes</h3>
                    </div>
                    <?php 
                        $quantidadeMSG = 5;
                        $paginaMSG = (isset($_GET['pagina_msg'])) ? (int)$_GET['pagina_msg'] : 1;
                        $inicioMSG = ($quantidadeMSG * $paginaMSG) - $quantidadeMSG;

                        // Busca as mensagens por responder
                        $buscaInfoDashBoard_NovasMensagens = $gst->exe_query("
                        SELECT * FROM mensagens WHERE respondida LIKE 'n' LIMIT $inicioMSG, $quantidadeMSG");
                        
                        $contaMensagens = $gst->exe_query("
                        SELECT COUNT(cod_msg) AS NUM_MSG FROM mensagens WHERE respondida LIKE 'n'");
                        $numTotalMsg = $contaMensagens[0]["NUM_MSG"];

                        $totalPaginaMsg = ceil($numTotalMsg/$quantidadeMSG);

                        $exibirMsg = 4;
                        $anteriorMsg = (($paginaMSG - 1) == 0) ? 1 : $paginaMSG - 1;
                        $posteriorMsg = (($paginaMSG+1) >= $totalPaginaMsg) ? $totalPaginaMsg : $paginaMSG+1;

                        if(count($buscaInfoDashBoard_NovasMensagens) > 0) {
                            for($i = 0; $i < count($buscaInfoDashBoard_NovasMensagens); $i++) {
                                $mensagem = $buscaInfoDashBoard_NovasMensagens[$i];
                    ?>
                    <div class="space_msg_body">
                        <div class="space_icons">
                            <a onclick="respondeMsg('<?= $mensagem['cod_msg'] ?>','<?= $mensagem['nome_cliente'] ?>', '<?= str_replace('\n', '', removerTextoFromat($mensagem['mensagem'])) ?>')" data-toggle="modal" data-target="#responderMsg" class="btn btn-default">
                                <em class="fa fa-reply"></em>
                            </a>
                            <a onclick="eliminaMsg('<?= $mensagem['cod_msg'] ?>', '<?= $mensagem['nome_cliente'] ?>')" data-toggle="modal" data-target="#eliminaMsg" class="btn btn-danger">
                                <em class="fa fa-trash"></em>
                            </a>
                        </div>
                        <div class="space_msg">
                            <p class="name"><?= $mensagem['nome_cliente'] ?></p>
                            <p class="date"><?= ptdatetime($mensagem['data_envio']) ?></p>
                            <br>
                            <p class="msg"><?= removerTextoFromat($mensagem['mensagem']) ?></p>
                        </div>
                    </div>

                    <script>
                        function respondeMsg(codMsg, nome_cliente, mensagem) {
                            var ip_mensagem = document.getElementById('msg_a_responder');
                            var ip_id_msg = document.getElementById('input_id_msg');
                            var ip_nome_utilizador = document.getElementById('ip_nome_utilizador');

                            ip_mensagem.innerHTML = mensagem;
                            ip_id_msg.value = codMsg;
                            ip_nome_utilizador.value = nome_cliente;
                        }
                        function eliminaMsg(codMsg, nome_Cliente) {
                            var nomeCliente = document.getElementById('nome_msg_excluir');
                            var ip_id_msg = document.getElementById('input_id_msg');
                            nomeCliente.innerHTML = nome_Cliente;
                            ip_id_msg.value = codMsg;
                        }
                    </script>

                    <?php
                            }
                        } else {
                            echo '<p style="color: green; text-align: center; margin-top: 10px; margin-bottom: 10px;">Não existem mensagens por responder</p>';
                        }
                    ?>

                    <ul class="pagination">
                        <li><a href="<?= APP_URL_OFFICE ?>dashboard.php?pagina_msg=<?= $anteriorMsg ?>">«</a></li>
                        <?php
                            for($i = $paginaMSG-$exibirMsg; $i <= $paginaMSG-1; $i++){
                                if($i > 0)
                                    echo '<li><a style="cursor: pointer" href="'.APP_URL_OFFICE.'dashboard.php?pagina_msg='.$i.'">'.$i.'</a></li>';
                            }

                            echo '<li class="active"><a style="cursor: pointer" href="'.APP_URL_OFFICE.'dashboard.php?pagina_msg='.$paginaMSG.'">'.$paginaMSG.' <span class="sr-only"></span></a></li>';

                            for($i = $paginaMSG+1; $i < $paginaMSG+$exibirMsg; $i++){
                                if($i <= $totalPaginaMsg)
                                    echo '<li><a style="cursor: pointer" href="'.APP_URL_OFFICE.'dashboard.php?pagina_msg='.$i.'">'.$i.'</a></li>';
                            }
                        ?>
                        
                        <li><a href="<?= APP_URL_OFFICE ?>dashboard.php?pagina_msg=<?= $posteriorMsg ?>">»</a></li>
                    </ul>
                </div>

                <div class="space_msgs" style="float: right;">
                    <div class="space_msg_header">
                        <h3>Aniversários de hoje</h3>
                    </div>

                    <?php
                        $quantidadeAnv = 5;
                        $paginaAnv = (isset($_GET['pagina_anv'])) ? (int)$_GET['pagina_anv'] : 1;
                        $inicioAnv = ($quantidadeAnv * $paginaAnv) - $quantidadeAnv;

                        $buscaAniversariosHoje = $gst->exe_query("
                        SELECT nome, data_nascimento FROM utilizadores LIMIT $inicioAnv, $quantidadeAnv");

                        $numAniversarios = 0;

                        if(count($buscaAniversariosHoje) > 0) {
                            $dataAtual = date("m-d");
                            
                            for($i=0; $i < count($buscaAniversariosHoje); $i++) {
                                $infUser = $buscaAniversariosHoje[$i];
                                $dataNascimento = $infUser['data_nascimento'];
                                
                                list($ano, $mes, $dia) = explode('-', $dataNascimento);
                                $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                                $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
            
                                $mesDia = $mes."-".$dia;

                                if($dataAtual == $mesDia) {
                                    $numAniversarios ++;
                                    $idade = floor((((($hoje-$nascimento)/60)/60)/24)/365.25) + 1;
                    ?>
                    <div class="space_msg_body">
                        <div class="space_msg" style="width: 100%;">
                            <p class="name"><?= $infUser['nome'] ?></p>
                            <br>
                            <p class="msg"><?= $idade ?> anos</p>
                        </div>
                    </div>
                    <?php
                                }
                            }
                        }

                        $totalPaginaAnv = ceil($numAniversarios/$quantidadeAnv);

                        $exibirAnv = 4;
                        $anteriorAnv = (($paginaAnv - 1) == 0) ? 1 : $paginaAnv - 1;
                        $posteriorAnv = (($paginaAnv+1) >= $totalPaginaAnv) ? $totalPaginaAnv : $paginaAnv+1;

                        if($numAniversarios == 0)
                            echo '<p style="color: green; border-bottom: 1px solid rgba(0,0,0,0.1); text-align: center; padding: 10px;">Sem aniversários hoje.</p>';
                    ?>

                    <ul class="pagination">
                        <li><a href="<?= APP_URL_OFFICE ?>dashboard.php?pagina_anv=<?= $anteriorAnv ?>">«</a></li>
                        <?php
                            for($i = $paginaAnv-$exibirMsg; $i <= $paginaAnv-1; $i++){
                                if($i > 0)
                                    echo '<li><a style="cursor: pointer" href="'.APP_URL_OFFICE.'dashboard.php?pagina_anv='.$i.'">'.$i.'</a></li>';
                            }

                            echo '<li class="active"><a style="cursor: pointer" href="'.APP_URL_OFFICE.'dashboard.php?pagina_anv='.$paginaAnv.'">'.$paginaAnv.' <span class="sr-only"></span></a></li>';

                            for($i = $paginaAnv+1; $i < $paginaAnv+$exibirAnv; $i++){
                                if($i <= $totalPaginaAnv)
                                    echo '<li><a style="cursor: pointer" href="'.APP_URL_OFFICE.'dashboard.php?pagina_anv='.$i.'">'.$i.'</a></li>';
                            }
                        ?>
                        
                        <li><a href="<?= APP_URL_OFFICE ?>dashboard.php?pagina_anv=<?= $posteriorAnv ?>">»</a></li>
                    </ul>
                </div>
                
                <div class="clearfix"></div>
                <br>
            </div>
        </article>
        
        <footer>
            
        </footer>
        <script src="js/main.js"></script>
        <script src="../js/ajax.js"></script>
    </body>
</html>