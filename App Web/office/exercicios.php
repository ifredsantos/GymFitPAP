<?php
    include("../config.php");
    include("verifica-acesso.php");

    $dataAtual = date("Y-m-d");

    $msg = "";

    // ==================================================
    // Adicionar um exercício
    // ==================================================
    if(isset($_POST['acao']) && $_POST['acao'] == "adicionarExercicio") {
        $erros = $fotoEnviada = $videoEnviado = false;
        $video_nome_final = "";

        $codExercicio = $_POST['cod'];
        $nomeExercicio = $_POST['nome'];
        $tipoExercicio = $_POST['tipo_exercicio'];

        if(isset($_FILES['img']['name'])) {
            $foto_nome = $_FILES['img']['name'];
            $foto_tempnome = $_FILES['img']['tmp_name'];
            $foto_extensao = strtolower(pathinfo($foto_nome,PATHINFO_EXTENSION));
            $caminhoFoto = "../posts/biblioteca_exercicios/img/";

            $foto_nome_final = "IMG_".$codExercicio."_".$nomeExercicio.".".$foto_extensao;

            if($foto_extensao != "jpg" && $foto_extensao != "png" && $foto_extensao != "gif" && $foto_extensao != "jpeg") {
                $msg .= MSGdanger("Ocorreu um erro", "O ficheiro tem que ser de formato jpg, jpeg, png ou gif", "");
                $erros = true;
            }

            if(!$erros) {
                if(move_uploaded_file($foto_tempnome, $caminhoFoto.$foto_nome_final)) {
                    $fotoEnviada = true;
                }
            }
        }

        if(isset($_FILES['video']['name']) && !empty($_FILES['video']['name'])) {
            $video_nome = $_FILES['video']['name'];
            $video_tempnome = $_FILES['video']['tmp_name'];
            $video_extensao = strtolower(pathinfo($video_nome,PATHINFO_EXTENSION));
            $caminhoVideo = "../posts/biblioteca_exercicios/video/";

            $video_nome_final = "VID_".$codExercicio."_".$nomeExercicio.".".$video_extensao;

            if($video_extensao != "mp4") {
                $msg .= MSGdanger("Ocorreu um erro", "O ficheiro tem que ser de formato mp4", "");
                $erros = true;
            }

            if(!$erros) {
                if(move_uploaded_file($video_tempnome, $caminhoVideo.$video_nome_final)) {
                    $videoEnviado = true;
                }
            }
        } else $videoEnviado = true;

        if(!$erros && $fotoEnviada && $videoEnviado) {
            $param = [
                ":cod" => $codExercicio,
                ":nome" => $nomeExercicio,
                ":img" => $foto_nome_final,
                ":vid" => $video_nome_final,
                ":tipo" => $tipoExercicio
            ];
            $inserirExercicio = $gst->exe_non_query("
            INSERT INTO exercicios () VALUES
            (
                :cod,
                :nome,
                :img,
                :vid,
                :tipo
            )", $param);

            if($inserirExercicio) {
                $msg .= MSGsuccess("Sucesso", "O exercício foi adicionado com sucesso", "");
            } else {
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel adicionar o exercício", "");
            }
        }
    }

    // ==================================================
    // Apagar um exercício
    // ==================================================
    if(isset($_GET['acao'], $_GET['id']) && $_GET['acao'] == "apagar" && $_GET['id'] != "") {
        $param = [
            ":cod_exercicio" => $_GET['id']
        ];

        $apagarPlanosExercicios = $gst->exe_non_query("
        DELETE FROM plano_exercicios WHERE exercicio = :cod_exercicio", $param);

        $buscaInf = $gst->exe_query("
        SELECT img, video FROM exercicios WHERE cod_exercicio = :cod_exercicio", $param);

        if($buscaInf[0]['img'] && verificaExisteFicheiro('../posts/biblioteca_exercicios/img/'.$buscaInf[0]['img']))
            unlink('../posts/biblioteca_exercicios/img/'.$buscaInf[0]['img']);
        if($buscaInf[0]['video'] != "" && verificaExisteFicheiro('../posts/biblioteca_exercicios/video/'.$buscaInf[0]['video']))
            unlink('../posts/biblioteca_exercicios/video/'.$buscaInf[0]['video']);

        if($apagarPlanosExercicios) {
            $apagarExercicio = $gst->exe_non_query("
            DELETE FROM exercicios WHERE cod_exercicio = :cod_exercicio", $param);

            $msg .= MSGsuccess("Sucesso", "O exercício Nº".$_GET['id']." foi excluido com sucesso", "");
        } else {
            $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel remover o exercício Nº ".$_GET['id'], "");
        }
    }

    // ==================================================
    // Adicionar uma categoria
    // ==================================================
    if(isset($_POST['acao']) && $_POST['acao'] == "adicionarCatgExercicio") {
        $erros = $fotoEnviada = false;
        $nomeCatg = $_POST['nome'];

        if(isset($_FILES['img']['name'])) {
            $foto_nome = $_FILES['img']['name'];
            $foto_tempnome = $_FILES['img']['tmp_name'];
            $foto_extensao = strtolower(pathinfo($foto_nome,PATHINFO_EXTENSION));
            $caminhoFoto = "../posts/biblioteca_exercicios/img/";

            $foto_nome_final = "IMG_CAPA_".$nomeCatg.".".$foto_extensao;

            if($foto_extensao != "jpg" && $foto_extensao != "png" && $foto_extensao != "gif" && $foto_extensao != "jpeg") {
                $msg .= MSGdanger("Ocorreu um erro", "O ficheiro tem que ser de formato jpg, jpeg, png ou gif", "");
                $erros = true;
            }

            if(!$erros) {
                if(move_uploaded_file($foto_tempnome, $caminhoFoto.$foto_nome_final)) {
                    $fotoEnviada = true;
                }
            }
        }

        if($fotoEnviada && !$erros) {
            $param = [
                ":nome" => $nomeCatg,
                ":img" => $foto_nome_final
            ];
            $insereCatg = $gst->exe_non_query("
            INSERT INTO tipos_exercicios (nome_tipo, img) VALUES
            (
                :nome,
                :img
            )", $param);

            if($insereCatg)
                $msg .= MSGsuccess("Sucesso", "A categoria foi adicionada com sucesso", "");
            else
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel adicionar a categoria", "");
        }
    }

    // ==================================================
    // Apagar uma categoria
    // ==================================================
    if(isset($_GET['acao'], $_GET['id']) && $_GET['acao'] == "apagar_categoria" && $_GET['id'] != "") {
        $param = [":tipo" => $_GET['id']];
        $buscaExerciciosCategoria = $gst->exe_query("
        SELECT cod_exercicio, img, video FROM exercicios WHERE tipo = :tipo", $param);

        if(count($buscaExerciciosCategoria) > 0) {
            for($i=0; $i < count($buscaExerciciosCategoria); $i++) {
                if(verificaExisteFicheiro('../posts/biblioteca_exercicios/img/'.$buscaExerciciosCategoria[$i]['img']))
                    unlink('../posts/biblioteca_exercicios/img/'.$buscaExerciciosCategoria[$i]['img']);
                if(verificaExisteFicheiro('../posts/biblioteca_exercicios/video/'.$buscaExerciciosCategoria[$i]['video']))
                    unlink('../posts/biblioteca_exercicios/video/'.$buscaExerciciosCategoria[$i]['video']);

                $paramExercicioPlanos = [":cod_exercicio" => $buscaExerciciosCategoria[$i]["cod_exercicio"]];
                $apagarPlanosExercicios = $gst->exe_non_query("
                DELETE FROM plano_exercicios WHERE exercicio = :cod_exercicio", $paramExercicioPlanos);
            }
        }

        $apagarExerciciosCategoria = $gst->exe_non_query("
        DELETE FROM exercicios WHERE tipo = :tipo", $param);

        $buscaCategoria = $gst->exe_query("
        SELECT img FROM tipos_exercicios WHERE cod_tipo_exercicio = :tipo", $param);
        if(count($buscaCategoria) > 0) {
            if(verificaExisteFicheiro('../posts/biblioteca_exercicios/img/'.$buscaCategoria[0]["img"]))
                unlink('../posts/biblioteca_exercicios/img/'.$buscaCategoria[0]["img"]);
        }

        $apagarCategoria = $gst->exe_non_query("
        DELETE FROM tipos_exercicios WHERE cod_tipo_exercicio = :tipo", $param);

        if($apagarCategoria)
            $msg .= MSGsuccess("Sucesso", "A categoria foi apagada bem como os seus exercícios", "");
        else
            $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel excluir a categoria desejada", "");
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
                    <p><a id = "trace-link-main" href = "exercicios">Exercícios</a></p>
                </div>
            </div>

            <!-- Cabeçalho de pesquisas -->
            <div class = "col-md-10 offset-md-2">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-6">
                                <form action="exercicios" method="post">
                                    <select style="float: left; width: 250px;" name="pesquisa" class="form-control">
                                        <option value="">Selecionar o tipo de exercicios</option>
                                        <?php
                                            $buscaTiposExercicios = $gst->exe_query("
                                            SELECT cod_tipo_exercicio, nome_tipo FROM tipos_exercicios");
                                            if(count($buscaTiposExercicios) > 0) {
                                                for($i=0; $i < count($buscaTiposExercicios); $i++) {
                                                    echo '<option value="'.$buscaTiposExercicios[$i]["cod_tipo_exercicio"].'">'.$buscaTiposExercicios[$i]["nome_tipo"].'</option>';
                                                }
                                            } else
                                                echo '<option value="">Sem tipo de exercícios</option>';
                                        ?>
                                    </select>
                                    <input type="hidden" name="action" value="pesquisar">
                                    <input style="float: left; margin-left: 10px; padding: 5px;" type="submit" value="Filtrar">
                                </form>
                            </div>
                            <div class="col col-xs-6 text-right">
                                <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#adicionarExercicio" style="height: 42px;">Adicionar Exercício</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal com formulário para adicionar um exercicio -->
                    <div class="modal fade" id="adicionarExercicio" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">Adicionar um exercício</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="exercicios" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="cod">Nº</label>
                                                <input name="cod" 
                                                    type="number" 
                                                    class="form-control" 
                                                    placeholder="Insira o número do exercício">
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="nome">Nome</label>
                                                <input name="nome" 
                                                    type="text" 
                                                    class="form-control" 
                                                    placeholder="Insira o nome do exercício" 
                                                    required>
                                            </div>
                                        <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="img">Foto</label>
                                                <input name="img" 
                                                    type="file" 
                                                    class="form-control"
                                                    accept="image/*" 
                                                    required>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="vid">Vídeo</label>
                                                <input name="video" 
                                                    type="file" 
                                                    class="form-control"
                                                    accept="video/*">
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="tipo_exercicio">Tipo</label>
                                                <select name="tipo_exercicio" class="form-control" required>
                                                    <?php
                                                        $buscaTipoExercicios = $gst->exe_query("
                                                        SELECT cod_tipo_exercicio, nome_tipo FROM tipos_exercicios");
                                                        if(count($buscaTipoExercicios) > 0) {
                                                            for($i = 0; $i < count($buscaTipoExercicios); $i++) {
                                                                $infTiposExercicios = $buscaTipoExercicios[$i];
                                                    ?>
                                                    <option value="<?= $infTiposExercicios['cod_tipo_exercicio'] ?>"><?= $infTiposExercicios['nome_tipo'] ?></option>
                                                    <?php
                                                            }
                                                        } else {
                                                            echo "<option value=''>Sem tipos de exercícios</option>";
                                                        }
                                                    ?>
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
                                                    <input type="hidden" name="acao" value="adicionarExercicio">
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
                                    <th>Nº</th>
                                    <th>Nome exercício</th>
                                    <th>Foto</th>
                                    <th>Vídeo</th>
                                    <th>Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $quantidade = 10;
                                $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
                                $inicio = ($quantidade * $pagina) - $quantidade;

                                // Busca os exercícios
                                $sqlBuscaExercicios = "
                                SELECT E.cod_exercicio, E.nome_exercicio, E.img, E.video, TE.nome_tipo 
                                FROM exercicios E 
                                    INNER JOIN tipos_exercicios TE ON E.tipo = TE.cod_tipo_exercicio ";
                                if(isset($_POST['action']) && $_POST['action'] == "pesquisar" && $_POST['pesquisa'] != "")
                                {
                                    if(isset($_POST['action']))
                                        $pesquisa = $_POST['pesquisa'];

                                    $sqlPesquisa = "WHERE E.tipo = :cod_tipo ";

                                    $param = [
                                        ":cod_tipo" => $pesquisa
                                    ];
                                } else {
                                    $param = [];
                                    $sqlPesquisa = "";
                                }
                                
                                $sqlBuscaExercicios .= $sqlPesquisa;
                                $sqlBuscaExercicios .= "LIMIT $inicio, $quantidade";
                                $buscaExercicios = $gst->exe_query($sqlBuscaExercicios, $param);

                                
                                $sqlContaTotal = "
                                SELECT COUNT(E.nome_exercicio) AS NUMEXERCICIOS 
                                FROM exercicios E ";
                                $sqlContaTotal .= $sqlPesquisa;

                                $qrTotal = $gst->exe_query($sqlContaTotal, $param);
                                $numTotal = $qrTotal[0]["NUMEXERCICIOS"];
                                
                                $totalPagina= ceil($numTotal/$quantidade);
                                
                                $exibir = 10;
                                $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
                                $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
                                
                                if(count($buscaExercicios) > 0) {
                                    for($i = 0; $i < count($buscaExercicios); $i++) {
                                        $infExercicio = $buscaExercicios[$i];
                            ?>
                                <tr>
                                    <td align="center">
                                        <a class="btn btn-danger" href="<?= APP_URL_OFFICE ?>exercicios.php?acao=apagar&id=<?= $infExercicio['cod_exercicio'] ?>"><em class="fa fa-trash"></em></a>
                                    </td>
                                    <!--<td class="hidden-xs">1</td>-->
                                    <td><?= $infExercicio['cod_exercicio'] ?></td>
                                    <td><?= $infExercicio['nome_exercicio'] ?></td>
                                    <td><img style="width: 200px; display: block; margin: auto;" src="<?= APP_URL ?>posts/biblioteca_exercicios/img/<?= $infExercicio['img'] ?>"></td>
                                    <td>
                                        <?php
                                            if($infExercicio['video'] != "") {
                                        ?>
                                        <video style="width: 200px; display: block; margin: auto;" controls>
                                            <source src="<?= APP_URL ?>posts/biblioteca_exercicios/video/<?= $infExercicio['video'] ?>" type="video/mp4">
                                        </video>
                                        <?php
                                            } else {
                                                echo 'Sem vídeo';
                                            }
                                        ?>
                                    </td>
                                    <td><?= $infExercicio['nome_tipo'] ?></td>
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
                                    
                                        echo "<li><a href=\"exercicios/1/$pesquisa\">&laquo;</a></li>";
                                        echo "<li><a href=\"exercicios/$anterior/$pesquisa\">&lsaquo;</a></li>";
                                    
                                        for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                                            if($i > 0)
                                                echo "<li><a href=\"exercicios/$i/$pesquisa\">$i</a></li>";
                                        }

                                        echo "<li><a href=\"exercicios/$pagina/$pesquisa\"><strong>$pagina</strong></a></li>";

                                        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                                            if($i <= $totalPagina)
                                                echo "<li><a href=\"exercicios/$i/$pesquisa\">$i</a></li>";
                                        }
                                        echo "<li><a href=\"exercicios/$posterior/$pesquisa\">&rsaquo;</a></li>";
                                        echo "<li><a href=\"exercicios/$totalPagina/$pesquisa\">&raquo;</a></li>";
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="clearfix"></div>

            <!-- Cabeçalho de hiperligações -->
            <div class = "col-md-10 offset-md-2">
                <div class = "trace-link col-xs-12 col-sm-12 col-md-12">
                    <p><a id = "trace-link-main" href = "exercicios">Categoria de Exercícios</a></p>
                </div>
            </div>

            <!-- Cabeçalho de pesquisas -->
            <div class = "col-md-10 offset-md-2">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-6">
                            </div>
                            <div class="col col-xs-6 text-right">
                                <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#adicionarCategoria" style="height: 42px;">Adicionar Categoria</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal com formulário para adicionar categorias de exercicios -->
                    <div class="modal fade" id="adicionarCategoria" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">Adicionar Categoria de Exercícios</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="exercicios" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="nome">Nome</label>
                                                <input name="nome" 
                                                    type="text" 
                                                    class="form-control" 
                                                    placeholder="Insira o nome da categoria"
                                                    required>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="img">Foto</label>
                                                <input name="img" 
                                                    type="file" 
                                                    class="form-control"
                                                    accept="image/*" 
                                                    required>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                        <div class="modal-footer clearfix">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Fechar</button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <input type="hidden" name="acao" value="adicionarCatgExercicio">
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
                                    <th>Nome categoria</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $quantidade = 10;
                                $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
                                $inicio = ($quantidade * $pagina) - $quantidade;

                                // Busca as categorias de exercícios
                                $buscaCatgExercicios = $gst->exe_query("
                                SELECT cod_tipo_exercicio, nome_tipo, img FROM tipos_exercicios");

                                $qrTotal = $gst->exe_query("
                                SELECT COUNT(nome_tipo) AS NUMCATGS 
                                FROM tipos_exercicios");
                                $numTotal = $qrTotal[0]["NUMCATGS"];
                                
                                $totalPagina= ceil($numTotal/$quantidade);
                                
                                $exibir = 10;
                                $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
                                $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
                                
                                if(count($buscaCatgExercicios) > 0) {
                                    for($i = 0; $i < count($buscaCatgExercicios); $i++) {
                                        $infCatgExercicio = $buscaCatgExercicios[$i];
                            ?>
                                <tr>
                                    <td align="center">
                                        <a class="btn btn-danger" href="<?= APP_URL_OFFICE ?>exercicios.php?acao=apagar_categoria&id=<?= $infCatgExercicio['cod_tipo_exercicio'] ?>"><em class="fa fa-trash"></em></a>
                                    </td>
                                    <!--<td class="hidden-xs">1</td>-->
                                    <td><?= $infCatgExercicio['nome_tipo'] ?></td>
                                    <td><img style="width: 150px; display: block; margin: auto;" src="<?= APP_URL ?>posts/biblioteca_exercicios/img/<?= $infCatgExercicio['img'] ?>"></td>
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
                                    
                                        echo "<li><a href=\"exercicios/1/$pesquisa\">&laquo;</a></li>";
                                        echo "<li><a href=\"exercicios/$anterior/$pesquisa\">&lsaquo;</a></li>";
                                    
                                        for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                                            if($i > 0)
                                                echo "<li><a href=\"exercicios/$i/$pesquisa\">$i</a></li>";
                                        }

                                        echo "<li><a href=\"exercicios/$pagina/$pesquisa\"><strong>$pagina</strong></a></li>";

                                        for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                                            if($i <= $totalPagina)
                                                echo "<li><a href=\"exercicios/$i/$pesquisa\">$i</a></li>";
                                        }
                                        echo "<li><a href=\"exercicios/$posterior/$pesquisa\">&rsaquo;</a></li>";
                                        echo "<li><a href=\"exercicios/$totalPagina/$pesquisa\">&raquo;</a></li>";
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