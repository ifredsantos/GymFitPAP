<?php
    require("../config.php");
    require("verifica-acesso.php");

    ob_start();

    $msg = "";

    if(isset($_GET['target']) && !empty($_GET['target'])) {
        $target = $_GET['target'];
    } else {
        $target = null;
    }

    if(isset($_POST['acao']) && $_POST['acao'] == "foto_upload") {
        $erros = false;
        $msg = $msg_erros = "";
        
        $caminhoTEMP = CAM_GALERIA . basename($_FILES["image"]["name"]);
        $formato = strtolower(pathinfo($caminhoTEMP,PATHINFO_EXTENSION));
        $nomeImg = rand(100000, 1000000)."_".rand(100000, 1000000)."_".rand(100000, 1000000)."_".rand(100000, 1000000)."_A14.".$formato;
        $caminho = CAM_GALERIA . $nomeImg;

        $maxDim = 250;
        $file_name = $_FILES["image"]['tmp_name'];
        $caminho200 = CAM_GALERIA . "_200_/" . $nomeImg;
        list($width, $height, $type, $attr) = getimagesize($file_name);

        if($width > $maxDim || $height > $maxDim) {
            $ratio = $width/$height;

            if($ratio > 1) {
                $new_width = $maxDim;
                $new_height = $maxDim/$ratio;
            } else {
                $new_width = $maxDim*$ratio;
                $new_height = $maxDim;
            }

            $src = imagecreatefromstring(file_get_contents($file_name));
            $dst = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagedestroy($src);
            imagejpeg($dst, $caminho200);
            imagedestroy($dst);
        }

        // Verifica se é uma imagem
        $verificaImagem = getimagesize($_FILES["image"]["tmp_name"]);
        if($verificaImagem === false) {
            $msg .= "<li>O ficheiro não é uma imagem.</li>";
            $erros = true;
        }

        // Verifica se já existe
        if(file_exists($caminho)) {
            $msg_erros .= "<li>O ficheiro já existe.</li>";
            $erros = true;
        }

        // Verifica se o tamanho da foto não ultrapassa o limite
        if($_FILES["image"]["size"] > 20000000) {
            $msg_erros .= "<li>O ficheiro é demasiado extenso.</li>";
            $erros = true;
        }

        // Verifica se o formato da foto é válida
        if($formato != "jpg" && $formato != "png" && $formato != "jpeg") {
            $msg_erros .= "<li>O ficheiro não tem um formato válido.</li>";
            $erros = true;
        }
        
        // Verifica se ocorreu um algum erro
        if($erros) {
            $msg .= "<p style=\"color: red\">Ocorreu um erro ao realizar o upload do ficheiro pretendido:</p>";
            $msg .= "<ul style=\"margin-left: 15px\">";
            $msg .= $msg_erros;
            $msg .= "</ul>";
        } else {
            // Realiza o upload
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $caminho)) {
                $param = [
                    ":titulo" => $_POST['titulo'],
                    ":desc" => $_POST['descricao'],
                    ":nome_img" => $nomeImg
                ];
                $registaFoto = $gst->exe_non_query("
                INSERT INTO galeria (titulo, descricao, nome_img, data_pub) VALUES (:titulo, :desc, :nome_img, NOW())", $param);
            
                if($registaFoto) {
                    $msg .= MSGsuccess("Sucesso", "A foto foi adicionada à galeria com sucesso", "");
                } else {
                    $msg .= MSGdanger("Ocorreu um erro", "Ocorreu um erro ao adicionar a foto à galeria", "");
                }
            } else {
                $msg .= MSGdanger("Ocorreu um erro", "Ocorreu um erro ao adicionar a foto à galeria", "");
            }
        }
    }

    if($target == "galeria" && isset($_GET['acao'], $_GET['id']) && $_GET['acao'] == "remover" && $_GET['id'] != "") {
        $param = [":cF" => $_GET['id']];
        $buscaNomeFoto = $gst->exe_query("
        SELECT nome_img FROM galeria WHERE cod_img = :cF", $param);
        $foto = $buscaNomeFoto[0]["nome_img"];

        if(verificaExisteFicheiro(CAM_GALERIA.$foto)) {
            unlink(CAM_GALERIA.$foto);
            unlink(CAM_GALERIA."_200_/".$foto);
        }

        $apagarFotoBD = $gst->exe_non_query("
        DELETE FROM galeria WHERE cod_img = :cF", $param);

        if($apagarFotoBD) {
            $msg .= MSGsuccess("Sucesso", "A foto foi excluida com sucesso", "");
        } else {
            $msg .= MSGdanger("Ocorreu um erro", "Ocorreu um erro ao excluir a foto da galeria", "");
        }
    }

    if(isset($_POST['acao']) && $_POST['acao'] == "editText") {
        $erros = false;
        $titulo = $_POST['titulo'];
        $texto = $_POST['texto'];

        if($texto == "") {
            $erros = true;
            $msg .= MSGdanger("Ocorreu um erro", "O campo do texto não pode estar vazio", "");
        }

        if(!$erros) {
            $param = [
                ":texto" => $texto,
                ":titulo" => $titulo
            ];
            $updateTexto = $gst->exe_non_query("
            UPDATE textos 
            SET textoPT = :texto 
            WHERE titloPT = :titulo", $param);
            if($updateTexto) {
                $msg .= MSGsuccess("Sucesso", "Texto atualizado com sucesso", "");
            } else {
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel atualizar o texto pretendido", "");
            }
        }
    }

    if(isset($_POST['acao']) && $_POST['acao'] == "alterarHorario") {
        $semana_manha = $_POST['semanal_manha_inicio'].";".$_POST['semanal_manha_fim'];
        $semana_tarde = $_POST['semanal_tarde_inicio'].";".$_POST['semanal_tarde_fim'];

        $sabado_manha = $_POST['sabado_manha_inicio'].";".$_POST['sabado_manha_fim'];
        $sabado_tarde = $_POST['sabado_tarde_inicio'].";".$_POST['sabado_tarde_fim'];

        if($_POST['domingo_manha_inicio'] == "" || $_POST['domingo_manha_fim'] == "") {
            $domingo_manha = null;
        } else {
            $domingo_manha = $_POST['domingo_manha_inicio'].";".$_POST['domingo_manha_fim'];
        }

        if($_POST['domingo_tarde_inicio'] == "" || $_POST['domingo_tarde_fim'] == "") {
            $domingo_tarde = null;
        } else {
            $domingo_tarde = $_POST['domingo_tarde_inicio'].";".$_POST['domingo_tarde_fim'];
        }
        
        $param = [
            ":sem_manha" => $semana_manha, ":sem_tarde" => $semana_tarde,
            ":sab_manha" => $sabado_manha, ":sab_tarde" => $sabado_tarde,
            ":dom_manha" => $domingo_manha, ":dom_tarde" => $domingo_tarde
        ];
        
        $verificaExisteHorario = $gst->exe_query("SELECT data_modificacao FROM horarios");
        if(count($verificaExisteHorario) == 0) {
            $horarioRegisto = $gst->exe_non_query("
            INSERT INTO horarios (cod_horario, semanal_manha, semanal_tarde, sabado_manha, sabado_tarde, domingo_manha, domingo_tarde, data_modificacao) 
            VALUES (1, :sem_manha, :sem_tarde, :sab_manha, :sab_tarde, :dom_manha, :dom_tarde, NOW())", $param);
        
            if($horarioRegisto) {
                $msg .= MSGsuccess("Sucesso", "O horário foi adicionado com sucesso", "");
            } else {
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel adicionar o horário", "");
            }
        } else {
            $horarioUpdate = $gst->exe_non_query("
            UPDATE horarios SET semanal_manha = :sem_manha, semanal_tarde = :sem_tarde, 
            sabado_manha = :sab_manha, sabado_tarde = :sab_tarde, 
            domingo_manha = :dom_manha, domingo_tarde = :dom_tarde, 
            data_modificacao = NOW() 
            WHERE cod_horario = 1", $param);

            if($horarioUpdate) {
                $msg .= MSGsuccess("Sucesso", "O horário foi atualizado com sucesso", "");
            } else {
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel alterar o horário", "");
            }
        }
    }

    if(isset($_POST['acao']) && $_POST['acao'] == "add_modalidade") {
        // Se alguma imagem não estiver a ser enviada verificar o limite de memória de upload no php.ini
        $erros = false;
        $fotoApresentacaoModalidade = true;

        $msg = $msg_erros = "";
        
        $caminhoTEMPFotoIndex = "../posts/modalidades/FID/" . basename($_FILES["foto_index"]["name"]);
        $caminhoTEMPFotoApresentacao = "../posts/modalidades/FAP/" . basename($_FILES["foto_mensalidade"]["name"]);

        $formatoFIndex = strtolower(pathinfo($caminhoTEMPFotoIndex,PATHINFO_EXTENSION));
        $formatoFAp = strtolower(pathinfo($caminhoTEMPFotoApresentacao,PATHINFO_EXTENSION));

        $nomeImgFIndex = "FID_".rand(100000, 1000000)."_".rand(100000, 1000000).".".$formatoFIndex;
        $nomeImgFAp = "FAP_".rand(100000, 1000000)."_".rand(100000, 1000000).".".$formatoFAp;
        
        $caminhoFIndex = "../posts/modalidades/FID/" . $nomeImgFIndex;
        $caminhoFAp = "../posts/modalidades/FAP/" . $nomeImgFAp;

        $verificaImagemIndex = getimagesize($_FILES["foto_index"]["tmp_name"]);
        if($verificaImagemIndex === false) {
            $msg .= "<li>O ficheiro de index não é uma imagem.</li>";
            $erros = true;
        }

        if(file_exists($caminhoFIndex)) {
            $msg_erros .= "<li>O ficheiro de index já existe.</li>";
            $erros = true;
        }

        if($_FILES["foto_index"]["size"] > 20000000) {
            $msg_erros .= "<li>O ficheiro de index é demasiado extenso.</li>";
            $erros = true;
        }

        if($formatoFIndex != "jpg" && $formatoFIndex != "png" && $formatoFIndex != "jpeg") {
            $msg_erros .= "<li>O ficheiro de index não tem um formato válido.</li>";
            $erros = true;
        }
        
        if(isset($_FILES['foto_mensalidade']['name']) && $_FILES['foto_mensalidade']['error'] == 0) {
            $verificaImagemApresentacao = getimagesize($_FILES["foto_mensalidade"]["tmp_name"]);
            if($verificaImagemApresentacao === false) {
                $msg .= "<li>O ficheiro de apresentação não é uma imagem.</li>";
                $erros = true;
            }
            if(file_exists($caminhoFAp)) {
                $msg_erros .= "<li>O ficheiro de apresentação já existe.</li>";
                $erros = true;
            }
            if($_FILES["foto_mensalidade"]["size"] > 20000000) {
                $msg_erros .= "<li>O ficheiro de apresentação é demasiado extenso.</li>";
                $erros = true;
            }
            if($formatoFAp != "jpg" && $formatoFAp != "png" && $formatoFAp != "jpeg") {
                $msg_erros .= "<li>O ficheiro de apresentação não tem um formato válido.</li>";
                $erros = true;
            }
        } else {
            $fotoApresentacaoModalidade = false;
            $nomeImgFAp = "";
        }

        if($erros) {
            $msg .= "<p style=\"color: red\">Ocorreu um erro ao realizar o upload dos ficheiros pretendidos:</p>";
            $msg .= "<ul style=\"margin-left: 15px\">";
            $msg .= $msg_erros;
            $msg .= "</ul>";
        } else {
            // Realiza o upload
            if(move_uploaded_file($_FILES["foto_index"]["tmp_name"], $caminhoFIndex) && move_uploaded_file($_FILES["foto_mensalidade"]["tmp_name"], $caminhoFAp) || !$fotoApresentacaoModalidade) {
                $param = [
                    ":nome" => $_POST['nome'],
                    ":desc" => $_POST['descricao'],
                    ":img_index" => $nomeImgFIndex,
                    ":img_ap" => $nomeImgFAp,
                ];
                $registaFoto = $gst->exe_non_query("
                INSERT INTO modalidades (nome_modalidade, descricao, imgIndex, imgs) VALUES (:nome, :desc, :img_index, :img_ap)", $param);
            
                if($registaFoto) {
                    $msg .= MSGsuccess("Sucesso", "A modalidade foi adicionada com sucesso", "");
                } else {
                    $msg .= MSGdanger("Ocorreu um erro", "Ocorreu um erro ao adicionar modalidade", "");
                }
            } else {
                $msg .= MSGdanger("Ocorreu um erro", "Ocorreu um erro ao adicionar a(s) foto(s) da mensalidade", "");
            }
        }
    }

    if(isset($_GET['target'], $_GET['acao'], $_GET['id']) && $_GET['target'] == "modalidades" && $_GET['acao'] == "remover_modalidade" && $_GET['id'] != "") {
        $idMod = $_GET['id'];

        $param = [
            ":cod_mod" => $idMod
        ];
        $buscaFotosApagar = $gst->exe_query("
        SELECT imgIndex, imgs FROM modalidades WHERE cod_modalidade = :cod_mod", $param);

        if(count($buscaFotosApagar) > 0) {
            $fotos = $buscaFotosApagar[0];
    
            if(verificaExisteFicheiro("../posts/modalidades/FID/" . $fotos['imgIndex']))
                unlink("../posts/modalidades/FID/" . $fotos['imgIndex']);
            if(verificaExisteFicheiro("../posts/modalidades/FAP/" . $fotos['imgs']))
                unlink("../posts/modalidades/FAP/" . $fotos['imgs']);

            $apagarFotos = $gst->exe_non_query("
            DELETE FROM modalidades WHERE cod_modalidade = :cod_mod", $param);

            if($apagarFotos) {
                $msg .= MSGsuccess("Sucesso", "A modalidade foi apagada com sucesso", "");
            } else {
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel apagar a modalidade", "");
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
                    <?php
                        if($target == null) {
                            echo '<p><a id = "trace-link-main" href = "'.APP_URL_OFFICE.'editor">Editor</a></p>';
                        } else {
                            echo '<p><a id = "trace-link-main" href = "'.APP_URL_OFFICE.'editor">Editor</a> / '.$_GET['target'].'</p>';
                        }
                    ?>
                </div>
            </div>

            <div class = "col-md-10 offset-md-2">
                <div class="panel panel-default panel-table" style="margin-bottom: 0 !important;">
                    <ul class="submenu-editor">
                        <li><a href="<?= APP_URL_OFFICE ?>editor/horarios">Horários</a></li>
                        <li><a href="<?= APP_URL_OFFICE ?>editor/textos">Textos</a></li>
                        <!-- <li><a href="<?= APP_URL_OFFICE ?>editor/treinadores">Treinadores</a></li> -->
                        <li><a href="<?= APP_URL_OFFICE ?>editor/modalidades">Modalidades</a></li>
                        <li><a href="<?= APP_URL_OFFICE ?>editor/galeria">Galeria</a></li>
                    </ul>
                </div>
            </div>

            <div class = "col-md-10 offset-md-2">
                <div class="panel panel-default panel-table">
                    <?php
                        if($target != null) {
                            switch ($target) {
                                case "horarios":
                                case "textos":
                                case "treinadores":
                                case "modalidades":
                                case "galeria":
                                    if(verificaExisteFicheiro("parts/inc_$target.php")) {
                                        include_once("parts/inc_$target.php");
                                    } else {
                                        echo "<p>Esta funcionalidade ainda não está disponivel.</p>";
                                    }
                                    break;
                                default:
                                    echo "<p>Esta funcionalidade ainda não está disponivel.</p>";
                                    break;
                            }
                        }
                    ?>
                </div>
            </div>
        </article>
        
        <footer>
            
        </footer>
        <script src="js/main.js"></script>
        <script src="../js/ajax.js"></script>
    </body>
</html>