<?php
    include("../config.php");
    include("verifica-acesso.php");

    $dataAtual = date("Y-m-d");

    $msg = "";

    // ==================================================
    // Regista um plano de treino
    // ==================================================
    if(isset($_POST['acao']) && $_POST['acao'] == "adicionarPlano") {
        $erros = $imgEnviada = false;
        $nome_plano = $_POST['nome'];
        $duracao_plano = $_POST['duracao'];
        $tipo_plano = $_POST['tipo'];

        if(isset($_FILES['img']['name']) && !empty($_FILES['img']['name'])) {
            $img_nome = $_FILES['img']['name'];
            $img_tempnome = $_FILES['img']['tmp_name'];
            $img_extensao = strtolower(pathinfo($img_nome,PATHINFO_EXTENSION));
            $caminhoImg = "../posts/planos/";

            $foto_nome_final = "PLANO_IMG_".$nome_plano.".".$img_extensao;

            if($img_extensao != "jpg" && $img_extensao != "png" && $img_extensao != "gif" && $img_extensao != "jpeg") {
                $msg .= MSGdanger("Ocorreu um erro", "O ficheiro tem que ser de formato jpg, jpeg, png ou gif", "");
                $erros = true;
            }

            if(!$erros) {
                if(move_uploaded_file($img_tempnome, $caminhoImg.$foto_nome_final)) {
                    $imgEnviada = true;
                }
            }

            if(!$erros && $imgEnviada) {
                $param = [
                    ":nome" => $nome_plano,
                    ":img" => $foto_nome_final,
                    ":duracao" => $duracao_plano,
                    ":tipo" => $tipo_plano
                ];
                $inserirPlanoTreino = $gst->exe_non_query("
                INSERT INTO planos (nome_plano, img_plano, duracao, tipo) VALUES
                (
                    :nome,
                    :img,
                    :duracao,
                    :tipo
                )", $param);

                if($inserirPlanoTreino)
                    $msg .= MSGsuccess("Sucesso", "O plano de treino foi adicionado com sucesso", "");
                else 
                    $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel adicionar o plano de treino", "");
            }
        } else $msg .= MSGdanger("Ocorreu um erro", "Insira uma imagem no plano de treino", "");
    }

    // ==================================================
    // Remover um plano de treino
    // ==================================================
    if(isset($_GET['acao'], $_GET['id']) && $_GET['acao'] == "removerPlano" && $_GET['id'] != "") {
        $param = [":cod_plano" => $_GET['id']];
        
        $removerExercicioAssociadosAoPlano = $gst->exe_non_query("
        DELETE FROM plano_exercicios WHERE plano = :cod_plano", $param);

        $removerClientesAssociadosAoPlano = $gst->exe_non_query("
        DELETE FROM planos_clientes WHERE plano = :cod_plano", $param);

        if($removerExercicioAssociadosAoPlano && $removerClientesAssociadosAoPlano) {
            $buscaInfPlano = $gst->exe_query("
            SELECT img_plano FROM planos WHERE cod_plano = :cod_plano", $param);

            if(verificaExisteFicheiro('../posts/planos/'.$buscaInfPlano[0]["img_plano"]))
                unlink('../posts/planos/'.$buscaInfPlano[0]["img_plano"]);

            $removerPlano = $gst->exe_non_query("
            DELETE FROM planos WHERE cod_plano = :cod_plano", $param);

            if($removerPlano)
                $msg .= MSGsuccess("Sucesso", "O plano foi removido", "");
            else
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel remover o plano", "");
        }
    }

    // ==================================================
    // Adicionar um exercício a um plano de treino
    // ==================================================
    if(isset($_POST['acao']) && $_POST['acao'] == "adicionarExercicioAoPlano") {
        $cod_plano = $_POST['cod_plano'];
        $exercicio = $_POST['exercicio'];
        $num_reps = $_POST['num_reps'];
        $num_series = $_POST['num_series'];
        $duracao = $_POST['duracao'];

        $param = [
            ":cod_plano" => $cod_plano,
            ":cod_exercicio" => $exercicio,
            ":num_reps" => $num_reps,
            ":num_series" => $num_series,
            ":duracao" => $duracao
        ];
        $associarExerAoPlano = $gst->exe_non_query("
        INSERT INTO plano_exercicios (plano, exercicio, num_reps, num_series, duracao) VALUES 
        (
            :cod_plano,
            :cod_exercicio,
            :num_reps,
            :num_series,
            :duracao
        )", $param);
    }

    // ==================================================
    // Remover um exercício a um plano de treino
    // ==================================================
    if(isset($_POST['acao']) && $_POST['acao'] == "removerExercicioAoPlano") {
        $param = [
            ":cod_plano" => $_POST['cod_plano'],
            ":cod_exercicio" => $_POST['exercicio']
        ];
        $removerExercicioAoPlano = $gst->exe_non_query("
        DELETE FROM plano_exercicios WHERE plano = :cod_plano AND exercicio = :cod_exercicio", $param);

        if($removerExercicioAoPlano)
            $msg .= MSGsuccess("Sucesso", "O exercício foi retirado ao plano", "");
        else
            $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel retirar o exercício ao plano", "");
    }

    // ==================================================
    // Adicionar um cliente a um plano de treino personalizado
    // ==================================================
    if(isset($_POST['acao']) && $_POST['acao'] == "adicionarClienteAoPlano") {
        $param = [":cod_plano" => $_POST['cod_plano']];

        $verificarPlano = $gst->exe_query("
        SELECT nome_plano FROM planos WHERE cod_plano = :cod_plano AND tipo = 2", $param);
        if(count($verificarPlano) > 0) {
            $param = [
                ":cod_plano" => $_POST['cod_plano'],
                ":cod_cliente" => $_POST['cliente']
            ];
            $registaClientePlano = $gst->exe_non_query("
            INSERT INTO planos_clientes (plano, cliente) VALUES 
            (
                :cod_plano,
                :cod_cliente
            )", $param);

            if($registaClientePlano)
                $msg .= MSGsuccess("Sucesso", "O cliente pretendido foi associado ao plano de treino desejado", "");
            else
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel associar o cliente ao plano de treino desejado", "");
        } else {
            $msg .= MSGdanger("Ocorreu um erro", "Apenas planos de treino personalizados podem ser atribuidos a um cliente", "");
        }
    }

    // ==================================================
    // Remover um cliente de um plano de treino personalizado
    // ==================================================
    if(isset($_POST['acao']) && $_POST['acao'] == "removerClienteAoPlano") {
        $param = [":cod_cliente" => $_POST['cliente']];
        $eliminarClienteDoPlano = $gst->exe_non_query("
        DELETE FROM planos_clientes WHERE cliente = :cod_cliente", $param);

        if($eliminarClienteDoPlano)
            $msg .= MSGsuccess("Sucesso", "O cliente foi removido do plano de treino", "");
        else
            $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel remover o cliente do plano de treino", "");
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
                    <p><a id = "trace-link-main" href = "planos_treino">Planos de treino</a></p>
                </div>
            </div>

            <!-- Cabeçalho de pesquisas -->
            <div class = "col-md-10 offset-md-2">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-6">
                                <div id="custom-search-input">
                                    <div class="input-group col-md-12">
                                        <input name="pesquisa" type="text" class="form-control" placeholder="Pesquisar" onkeyup="pesquisaClientes(this.value)">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="button">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-xs-6 text-right">
                                <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#adicionarPlano" style="height: 42px;">Adicionar plano</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal com formulário para registar um cliente -->
                    <div class="modal fade" id="adicionarPlano" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">Adicionar plano</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="planos_treino" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="nome">Nome</label>
                                                <input name="nome" 
                                                    type="text" 
                                                    class="form-control" 
                                                    placeholder="Insira o nome do plano">
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="img">Foto</label>
                                                <input name="img" 
                                                       type="file" 
                                                       class="form-control" 
                                                       required>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="duracao">Duração</label>
                                                <input name="duracao" 
                                                       type="time" 
                                                       class="form-control">
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="tipo">Tipo</label>
                                                <select name="tipo" class="form-control" required>
                                                    <option value="1">Padrão</option>
                                                    <option value="2">Personalizado</option>
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="modal-footer clearfix">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Fechar</button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <input type="hidden" name="acao" value="adicionarPlano">
                                                    <button type="submit" class="btn btn-default btn-hover-green" role="button">Adicionar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="adicionarExercicioAoPlano" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">Adicionar exercícios aos planos</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="planos_treino" method="post">
                                        <div id="resultado_ajax_add_exercicios_plano"></div>
                                
                                        <div class="modal-footer clearfix">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Fechar</button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <input type="hidden" name="acao" value="adicionarExercicioAoPlano">
                                                    <button type="submit" class="btn btn-default btn-hover-green" role="button">Adicionar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="removerExercicioAoPlano" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">Remover exercícios ao plano</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="planos_treino" method="post">
                                        <div id="resultado_ajax_rem_exercicios_plano"></div>
                                
                                        <div class="modal-footer clearfix">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Fechar</button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <input type="hidden" name="acao" value="removerExercicioAoPlano">
                                                    <button type="submit" class="btn btn-default btn-hover-green" role="button">Remover</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="removerClienteAoPlano" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">Remover cliente do plano</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="planos_treino" method="post">
                                        <div id="resultado_ajax_rem_cliente_plano"></div>
                                
                                        <div class="modal-footer clearfix">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Fechar</button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <input type="hidden" name="acao" value="removerClienteAoPlano">
                                                    <button type="submit" class="btn btn-default btn-hover-green" role="button">Remover</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="adicionarClienteAoPlano" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">Adicionar cliente ao plano</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="planos_treino" method="post">
                                        <div id="resultado_ajax_add_cliente_plano"></div>
                                
                                        <div class="modal-footer clearfix">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Fechar</button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <input type="hidden" name="acao" value="adicionarClienteAoPlano">
                                                    <button type="submit" class="btn btn-default btn-hover-green" role="button">Adicionar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela -->
                    <div class="panel-body" id="resultado_anterior">
                        <table class="table table-striped table-bordered table-list">
                            <thead>
                                <tr>
                                    <th><em class="fa fa-cog"></em></th>
                                    <th>Nome</th>
                                    <th>Duração média</th>
                                    <th>Nº de exercícios</th>
                                    <th>Imagem</th>
                                    <th>Tipo</th>
                                    <th>Clientes</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $quantidade = 10;
                                $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
                                $inicio = ($quantidade * $pagina) - $quantidade;

                                // Busca os clientes
                                $sqlBuscaPlanos = " SELECT * FROM planos ";
                                
                                $sqlBuscaPlanos .= "LIMIT $inicio, $quantidade";
                                $buscaPlanos = $gst->exe_query($sqlBuscaPlanos, $param);

                                
                                $sqlContaTotal = "
                                SELECT COUNT(nome_plano) AS NUMPLANOSPADRAO 
                                FROM planos";

                                $qrTotal = $gst->exe_query($sqlContaTotal);
                                $numTotal = $qrTotal[0]["NUMPLANOSPADRAO"];
                                
                                $totalPagina= ceil($numTotal/$quantidade);
                                
                                $exibir = 10;
                                $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
                                $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
                                
                                if(count($buscaPlanos) > 0) {
                                    for($i = 0; $i < count($buscaPlanos); $i++) {
                                        $cod_plano = $buscaPlanos[$i]["cod_plano"];

                                        if($buscaPlanos[$i]["tipo"] == 1)
                                            $tipoPlano = "Padrão";
                                        else
                                            $tipoPlano = "Personalizado";

                                        $param = [":cod_plano" => $buscaPlanos[$i]["cod_plano"]];
                                        $buscaNrExercicios = $gst->exe_query("
                                        SELECT COUNT(cod_plano_exercicio) AS NUMEX FROM plano_exercicios WHERE plano = :cod_plano", $param);
                                        $nExercicios = $buscaNrExercicios[0]["NUMEX"];

                                        $buscaNrClientesPlano = $gst->exe_query("
                                        SELECT COUNT(cod_plano_cliente) AS NRCLIENTEPLANO FROM planos_clientes WHERE plano = :cod_plano", $param);
                                        if(count($buscaNrClientesPlano) > 0)
                                            $numClientesPlano = $buscaNrClientesPlano[0]["NRCLIENTEPLANO"];
                                        else
                                            $numClientesPlano = 0;
                            ?>
                                <tr>
                                    <td align="center">
                                        <a class="btn btn-danger" href="planos_treino.php?acao=removerPlano&id=<?= $buscaPlanos[$i]['cod_plano'] ?>"><em class="fa fa-trash"></em></a>
                                    </td>
                                    <!--<td class="hidden-xs">1</td>-->
                                    <td style="text-align: center;"><?= $buscaPlanos[$i]['nome_plano'] ?></td>
                                    <td style="text-align: center;"><?= $buscaPlanos[$i]['duracao'] ?></td>
                                    <td style="text-align: center;">
                                        <button type="button" data-toggle="modal" data-target="#removerExercicioAoPlano" onclick="remExerciciosAoPlano('<?= $cod_plano ?>')" style="border: none; background: transparent; float: left;"><img style="width: 25px;" src="layout/less.png"></button>
                                        <?= $nExercicios ?>
                                        <button type="button" data-toggle="modal" data-target="#adicionarExercicioAoPlano" onclick="addExerciciosAoPlano('<?= $cod_plano ?>')" style="border: none; background: transparent; float: right;"><img style="width: 25px;" src="layout/add.png"></button>
                                    </td>
                                    <td style="text-align: center;"><img style="width: 150px; display: block; margin: auto;" src="../posts/planos/<?= $buscaPlanos[$i]['img_plano'] ?>"></td>
                                    <td style="text-align: center;"><?= $tipoPlano ?></td>
                                    <td style="text-align: center;">
                                        <?php
                                            if($tipoPlano != "Padrão") {
                                        ?>
                                        <button type="button" data-toggle="modal" data-target="#removerClienteAoPlano" onclick="removerClientesAoPlano('<?= $cod_plano ?>')" style="border: none; background: transparent; float: left;"><img style="width: 25px;" src="layout/less.png"></button>
                                        <?= $numClientesPlano ?>
                                        <button type="button" data-toggle="modal" data-target="#adicionarClienteAoPlano" onclick="addClientesAoExercicio('<?= $cod_plano ?>')" style="border: none; background: transparent; float: right;"><img style="width: 25px;" src="layout/add.png"></button>
                                        <?php
                                            } else echo "Todos";
                                        ?>
                                    </td>
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
                            <div class="col col-xs-3">Página <?= $pagina ?> de <?= $totalPagina ?>
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
                                <p>Número de resultados: <?= $numTotal ?></p>
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
                                    
                                        echo "<li><a href=\"clientes/1/$pesquisa\">&laquo;</a></li>";
                                        echo "<li><a href=\"clientes/$anterior/$pesquisa\">&lsaquo;</a></li>";
                                    
                                        for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                                            if($i > 0)
                                                echo "<li><a href=\"clientes/$i/$pesquisa\">$i</a></li>";
                                        }

                                        echo "<li><a href=\"clientes/$pagina/$pesquisa\"><strong>$pagina</strong></a></li>";

                                        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                                            if($i <= $totalPagina)
                                                echo "<li><a href=\"clientes/$i/$pesquisa\">$i</a></li>";
                                        }
                                        echo "<li><a href=\"clientes/$posterior/$pesquisa\">&rsaquo;</a></li>";
                                        echo "<li><a href=\"clientes/$totalPagina/$pesquisa\">&raquo;</a></li>";
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
        <script src="../js/ajax.js"></script>
    </body>
</html>