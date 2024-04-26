<?php
    include('config.php');
    ob_start();
    
    if(isset($_SESSION['cod_user'], $_SESSION['role']) && $_SESSION['role'] == 1) {
        header('location: '.APP_URL_OFFICE);
    }

    $msg = "";
    
    if(isset($_GET['target']) && !empty($_GET['target'])) {
        $tipo = $_GET['target'];
    } else {
        $tipo = "";
    }

    if(isset($_GET['acao']) && !empty($_GET['acao'])) {
        $acao = $_GET['acao'];
    } else {
        $acao = "";
    }
    
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = "";
    }

    if($tipo == "mensalidades" && $acao == "cancelar" && $id != "") {
        $param = [
            ":cod_mensalidade_pagamento" => $id,
            ":cod_utilizador" => $_SESSION['cod_user']
        ];

        $verificaMensalidadePertece = $gst->exe_query("
        SELECT cod_mensalidadePagamento FROM mensalidades_pagamentos 
        WHERE cod_mensalidadePagamento = :cod_mensalidade_pagamento AND cod_utilizador = :cod_utilizador", $param);

        if(count($verificaMensalidadePertece) > 0) {
            $param = [
                ":cod_utilizador" => $_SESSION['cod_user'],
                ":cod_mensalidade_pagamento" => $id
            ];

            $updateMensalidadeStatus = $gst->exe_non_query("
            UPDATE mensalidades_pagamentos SET cancelado = 's' 
            WHERE cod_utilizador = :cod_utilizador AND cod_mensalidadePagamento = :cod_mensalidade_pagamento", $param);

            if(!$updateMensalidadeStatus) {
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel anular a mensalidade pretendida", "");
            }
        } else {
            $msg .= MSGdanger("Ocorreu um erro", "Esta mensalidade não lhe pertence", "");
        }
    }
    
    if($tipo == "objetivos" && $acao == "cancelar" && $id != "") {
        $param = [
            ":id_obj" => $id,
            ":cod_utilizador" => $_SESSION['cod_user']
        ];

        $verificaObjetivoPertece = $gst->exe_query("
        SELECT id_objetivo FROM utilizadores_objetivos 
        WHERE id_objetivo = :id_obj AND utilizador = :cod_utilizador", $param);

        if(count($verificaObjetivoPertece) > 0) {
            $param = [
                ":cod_utilizador" => $_SESSION['cod_user'],
                ":cod_mensalidade_pagamento" => $id
            ];

            $param = [
                ":id_obj" => $id,
                ":cod_user" => $_SESSION['cod_user']
            ];
            $apagarObjetivo = $gst->exe_non_query("
            DELETE FROM utilizadores_objetivos WHERE id_objetivo = :id_obj AND utilizador = :cod_user", $param);

            if(!$apagarObjetivo) {
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel excluir o objetivo pretendido", "");
            }
        } else {
            $msg .= MSGdanger("Ocorreu um erro", "Este objetivo não lhe pertence", "");
        }
    }

    if(isset($_SESSION['cod_user']) && !empty($_SESSION['cod_user'])) {
        $erros = 0;

        $param = [
            ":cod_utilizador" => $_SESSION['cod_user']
        ];

        $infUser = $gst->exe_query("
        SELECT * FROM utilizadores U, utilizadores_tipo UT 
        WHERE U.tipo_utilizador = UT.cod_regra AND U.cod_utilizador = :cod_utilizador", $param);

        if(count($infUser) > 0)
        {
            $nome = $infUser[0]['nome'];
            $email = $infUser[0]['email'];
            $telefone = $infUser[0]['telefone'];
            $psw = $infUser[0]['psw'];

            if(isset($_POST['acao']) && $_POST['acao'] == "atualizar_perfil") {
                // Adquire e valida os dados do formulário
                $frmNome = $_POST['nome'];
                if(strlen($frmNome) > 100) {
                    $msg .= MSGdanger("Ocorreu um erro", "O comprimento do nome ultrapassa os 100 caracteres", "");
                    $erros = 1;
                }

                $frmEmail = $_POST['email'];
                if(strlen($frmEmail) > 100) {
                    $msg .= MSGdanger("Ocorreu um erro", "O comprimento do email ultrapassa os 100 caracteres", "");
                    $erros = 1;
                }
                $frmConfEmail = $_POST['conf_email'];

                $frmTele = $_POST['telefone'];
                if(strlen($frmTele) > 13) {
                    $msg .= MSGdanger("Ocorreu um erro", "O comprimento do telefone ultrapassa os 13 caracteres", "");
                    $erros = 1;
                }

                $frmPsw = $_POST['psw'];
                if(strlen($frmPsw) > 32) {
                    $msg .= MSGdanger("Ocorreu um erro", "O comprimento da password ultrapassa os 32 caracteres", "");
                    $erros = 1;
                }

                $frmConfPsw = $_POST['conf_psw'];
                // ==================================================




                // Se não existir erros realiza o update
                if($erros == 0) {
                    if($frmNome != "" && $frmNome != $nome) {
                        $param = [
                            ":nome" => $frmNome,
                            ":cod_utilizador" => $_SESSION['cod_user']
                        ];
                        $upNome = $gst->exe_non_query("
                        UPDATE utilizadores SET nome = :nome WHERE cod_utilizador = :cod_utilizador", $param);

                        if(!$upNome) {
                            $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel atualizar o nome", "");
                        }
                    } else if($frmNome != "" && $frmNome == $nome) {
                        $msg .= MSGdanger("Ocorreu um erro", "Inseriu o seu nome atual", "");
                    }

                    if($frmEmail != "" && $frmEmail != $email) {
                        if($frmEmail == $frmConfEmail) {
                            $param = [
                                ":email" => $frmNome,
                                ":cod_utilizador" => $_SESSION['cod_user']
                            ];
                            $upEmail = $gst->exe_non_query("
                            UPDATE utilizadores SET email = :email WHERE cod_utilizador = :cod_utilizador", $param);
    
                            if($upEmail) {
                                $msg .= MSGinfo("Informação", "Verifique a sua conta caixa de entrada em $frmEmail", "");
                            } else {
                                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel atualizar o email", "");
                            }
                        } else {
                            $msg .= MSGdanger("Ocorreu um erro", "Reescreva o seu email para confirmar", "");
                        }
                    } else if($frmEmail != "" && $frmEmail == $email) {
                        $msg .= MSGdanger("Ocorreu um erro", "Inseriu o endereço de email atual", "");
                    }

                    if($frmPsw != "" && md5($frmPsw) != $psw) {
                        if($frmPsw == $frmConfPsw) {
                            $param = [
                                ":psw" => md5($frmPsw),
                                ":cod_utilizador" => $_SESSION['cod_user']
                            ];
                            $upPsw = $gst->exe_non_query("
                            UPDATE utilizadores SET psw = :psw WHERE cod_utilizador = :cod_utilizador", $param);
    
                            if(!$upPsw) {
                                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel atualizar a password", "");
                            }
                        } else {
                            $msg .= MSGdanger("Ocorreu um erro", "Reescreva a sua password corretamente", "");
                        }
                    } else if($frmPsw != "" && md5($frmPsw) == $psw) {
                        $msg .= MSGdanger("Ocorreu um erro", "Inseriu a password atual", "");
                    }
                }

                if($frmTele != "" && $frmTele != $telefone) {
                    $param = [
                        ":telefone" => $frmTele,
                        ":cod_utilizador" => $_SESSION['cod_user']
                    ];
                    $upTele = $gst->exe_non_query("
                    UPDATE utilizadores SET telefone = :telefone WHERE cod_utilizador = :cod_utilizador", $param);

                    if(!$upTele) {
                        $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel atualizar o telefone", "");
                    }
                } else if($frmTele != "" && $frmTele == $telefone) {
                    $msg .= MSGdanger("Ocorreu um erro", "Inseriu o nº de telefone atual", "");
                }
            }
            $param = [
                ":cod_utilizador" => $_SESSION['cod_user']
            ];
            $buscaInfUser = $gst->exe_query("
            SELECT * FROM utilizadores U, utilizadores_tipo UT 
            WHERE U.tipo_utilizador = UT.cod_regra 
                AND U.cod_utilizador = :cod_utilizador", $param);
            if(count($buscaInfUser) > 0) {
                $infUser = $buscaInfUser[0];
                $nome = $infUser['nome'];
                $email = $infUser['email'];
                $telefone = $infUser['telefone'];
                $psw = $infUser['psw'];
            }
        } else {
            header('Location: ' . APP_URL . 'home/msg/acesso-restrito');
        }
    } else {
        header('Location: ' . APP_URL . 'home/msg/acesso-restrito');
    }

    if(isset($_POST['acao']) && $_POST['acao'] == "muda-mensalidade") {
        $alterarMensalidadeAtual = false;
        $mensalidade = $_POST['mensalidade'];

        if(isset($_POST['alterarMensalidadeAtual']) && $_POST['alterarMensalidadeAtual'] == "on")
            $alterarMensalidadeAtual = true;

        // Alterar mensalidade para o próximo mês
        if(!$alterarMensalidadeAtual) {
            // Cancela a mensalidade atual
            $param = [
                ":cod_utilizador" => $_SESSION['cod_user']
            ];
            $cancelaMensalidadeAtual = $gst->exe_non_query("
            UPDATE mensalidades_aquisicoes SET atual = 'n' WHERE utilizador = :cod_utilizador AND atual = 's'", $param);

            if(!$alterarMensalidadeAtual) {
                // Cancela o pagamento da mensalidade atual
                $param = [
                    ":cod_utilizador" => $_SESSION['cod_user'],
                ];
                // $cancelaPagamentoMensalidadeAtual = $gst->exe_non_query("
                // UPDATE mensalidades_pagamentos SET cancelado = 's' WHERE cod_utilizador = :cod_utilizador AND cancelado = 'n'", $param);
            }

            if($cancelaMensalidadeAtual) {
                // Adiciona a mensalidade atual
                $param = [
                    ":cod_utilizador" => $_SESSION['cod_user'],
                    ":mensalidade" => $mensalidade
                ];
                $registaNovaMensalidade = $gst->exe_non_query("
                INSERT INTO mensalidades_aquisicoes (utilizador, mensalidade, desconto, data_aquisicao, atual) VALUES 
                (
                    :cod_utilizador,
                    :mensalidade,
                    1,
                    NOW(),
                    's'
                )", $param);

                // Busca o codigo da aquisição anterior
                $param = [
                    ":utilizador" => $_SESSION['cod_user']
                ];
                $buscaUltimoCodAquisicao = $gst->exe_query("
                SELECT cod_aquisicao FROM mensalidades_aquisicoes WHERE utilizador = :utilizador AND atual LIKE 's' ORDER BY data_aquisicao DESC LIMIT 1", $param);

                // Insere uma mensalidade prepagamento para o próximo mês
                $proximoMes = date("m") + 1;
                $param = [
                    ":utilizador" => $_SESSION['cod_user'],
                    ":aquisicao" => $buscaUltimoCodAquisicao[0]["cod_aquisicao"],
                    ":mes" => $proximoMes,
                    ":ano" => date("Y")
                ];
                $registaNovaMensalidadePrePagamento = $gst->exe_non_query("
                INSERT INTO mensalidades_pagamentos (cod_utilizador, aquisicao, mes, ano) VALUES (:utilizador, :aquisicao, :mes, :ano)", $param);

                if(!$registaNovaMensalidade) {
                    $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel alterar a mensalidade", "");
                }
            }
        } else {
            // Alterar a mensalidade do próprio mês
            $param = [
                ":mensalidade" => $mensalidade,
                ":cod_user" => $_SESSION['cod_user']
            ];
            $updateMensalidadeAtual = $gst->exe_non_query("
            UPDATE mensalidades_aquisicoes SET mensalidade = :mensalidade 
            WHERE utilizador = :cod_user AND atual LIKE 's'", $param);

            if(!$updateMensalidadeAtual) {
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel atualizar a sua mensalidade atual", "");
            }
        }
    }

    if(isset($_POST['acao']) && $_POST['acao'] == "escolhe-primeira-mensalidade") {
        if(verificaPost() == "post") {
            $mensalidade = $_POST['mensalidade'];
            $utilizador = $_SESSION['cod_user'];

            $param = [
                ":utilizador" => $utilizador,
                ":mensalidade" => $mensalidade
            ];
            $registaMensalidadeAtual = $gst->exe_non_query("
            INSERT INTO mensalidades_aquisicoes (utilizador,mensalidade,desconto,data_aquisicao,atual) VALUES 
            (
                :utilizador,
                :mensalidade,
                1,
                NOW(),
                's'
            )", $param);
            if($registaMensalidadeAtual) {
                //$msg .= MSGsuccess("Sucesso", "Foi registada a mensalidade atual", ""); 
                
                $param = [
                    ":cod_user" => $_SESSION['cod_user'],
                    ":ano" => date("Y")
                ];
                $buscaSeguro = $gst->exe_query("
                SELECT data_pagamento FROM seguros WHERE utilizador = :cod_user AND ano = :ano", $param);
                if(count($buscaSeguro) == 0) {
                    $param = [
                        ":utilizador" => $utilizador,
                        ":ano" => date("Y")
                    ];
                    $registaPreSeguro = $gst->exe_non_query("
                    INSERT INTO seguros (utilizador, ano) VALUES (:utilizador, :ano)", $param);
                }
            } else {
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel registar uma mensalidade atual", "");
            }
        }
    }

    if(isset($_POST['acao']) && $_POST['acao'] == "objetivos") {
        $_SESSION['objetivos_a_definir'] = $_POST['objetivos'];
        //echo var_dump($_SESSION['objetivos_a_definir']);
        header('Location: '. APP_URL.'perfil/objetivos');
    }

    if(isset($_POST['definir_um_objetivo']) && !empty($_POST['definir_um_objetivo']) || isset($_GET['acao']) && $_GET['acao'] == "apagarlista") {
        array_shift($_SESSION['objetivos_a_definir']);

        $param = [
            ":utilizador" => $_SESSION['cod_user'],
            ":objetivo" => $_POST['definir_um_objetivo'],
            ":peso_alvo" => $_POST['peso_alvo'],
            ":data_alvo" => $_POST['data_alvo']
        ];
        $guardaObjetivo = $gst->exe_non_query("
        INSERT INTO utilizadores_objetivos (utilizador, objetivo, peso_alvo, data_alvo, atual, data_registo) 
        VALUES (:utilizador, :objetivo, :peso_alvo, :data_alvo, 's', NOW())", $param);

        if($guardaObjetivo) {
            header('Location: '. APP_URL.'perfil.php?target=objetivos&msg=O objetivo "'.$_POST['definir_um_objetivo'].'" foi adicionado com sucesso');
            exit();
        }

        if($_SESSION['objetivos_a_definir'] == "") {
            unset($_SESSION['objetivos_a_definir']);
        }

        header('Location: '. APP_URL.'perfil/objetivos');
    }

    if(isset($_POST['acao']) && $_POST['acao'] == "adicionar_objetivo") {
        $objetivo = $_POST['objetivo'];
        $peso_alvo = $_POST['peso_alvo'];
        $data_alvo = $_POST['data_alvo'];
        $atual = $_POST['atual'];
        $cumprido = $_POST['cumprido'];
        
        if($objetivo != "" && $peso_alvo != "" && $data_alvo != "" && $atual != "" && $cumprido != "") {
            $param = [
                ":user" => $_SESSION['cod_user'],
                ":obj" => $objetivo,
                ":palvo" => $peso_alvo,
                ":dalvo" => $data_alvo,
                ":atual" => $atual,
                ":cump" => $cumprido
            ];
            $guardaObjetivo = $gst->exe_non_query("
            INSERT INTO utilizadores_objetivos (utilizador, objetivo, peso_alvo, data_alvo, atual, cumprido, data_registo) VALUES 
            (
                :user,
                :obj,
                :palvo,
                :dalvo,
                :atual,
                :cump,
                NOW()
            )", $param);

            if(!$guardaObjetivo) {
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel adicionar o seu objetivo", "");
            }
        } else {
            $msg .= MSGdanger("Ocorreu um erro", "Por favor preencha todos os campos", "");
        }
    }

    if(isset($_POST['acao']) && $_POST['acao'] == "atualizar_objetivo") {
        $param = [
            ":atual" => $_POST['atual'],
            ":cumprido" => $_POST['cumprido']
        ];
        $atualiza_obj = $gst->exe_non_query("
        UPDATE utilizadores_objetivos SET atual = :atual, cumprido = :cumprido", $param);

        if(!$atualiza_obj) {
            $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel atualizar o seu objetivo", "");
        }
    }
?>

<!DOCTYPE html>

<html lang = "pt-pt">
    <head>
        <base href="<?= APP_URL ?>">
        <meta charset = "utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="content-language" content="pt">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="cache-control" content="private">
        <meta name="author" content="<?= PROGRAMER_NAME ?>, <?= PROGRAMER_EMAIL ?>">
        <meta name="reply-to" content="<?= PROGRAMER_EMAIL ?>">
        <meta name="rating" content="general">
	    <title>Perfil | <?= $infUser['username'] ?></title>
        <link rel="icon" href="layout/altere.png" type="image/x-icon">
        <link rel="shortcut icon" href="layout/altere.png" type="image/x-icon">
        <link rel = "stylesheet" type = "text/css" href = "layout/css/design.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </head>
    
    <body onselectstart="return false" data-spy="scroll" data-target="#myScrollspy" data-offset="50">
        <header id = "#myScrollspy">
            <?php include 'parts/header.php';?>
        </header>
        
        <article style="padding-top: 50px;">
            <br>
        <?php
            if(isset($_GET['msg']) && !empty($_GET['msg'])) {
                $URLmsg = $_GET['msg'];

                if($URLmsg == "objetivo1-erro")
                    $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel definir o seu 1º objetivo", "");
            }

            if($msg != "")  { ?>
            <div class="msg-space-modal" id="msg-space-modal">
                <div class="msg-content-modal">
                    <?= $msg; ?>
                </div>
            </div>
        <?php } ?>
            <div id="menu-vertical">
                <div id="header-client">
                    <div id="space-avatar">
                        <img id="avatar" src="posts/utilizadores/user.png" alt="Fredinson" title="Fredinson">
                        <div id="sobreAvatar">
                            <p id="avatarAcao">Adicionar</p>
                        </div>
                    </div>
                    
                    <div id="header-client-txt">
                        <h3><?= $infUser['username'] ?></h3>
                        <p><?= $infUser['nome_regra'] ?></p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <ul>
                    <?php
                        if(isset($_SESSION['cod_user'], $_SESSION['role']) && $_SESSION['role'] == 3) {
                            if($tipo == "informações" || $tipo == "")  {
                                echo '<a href="'. APP_URL . 'perfil/informações"><li class="menu-vertical-selected">Informações</li></a>';
                            } else  {
                                echo '<a href="'. APP_URL . 'perfil/informações"><li>Informações</li></a>';
                            }
                            
                            if($tipo == "mensalidades")  {
                                echo '<a href="'. APP_URL . 'perfil/mensalidades"><li class="menu-vertical-selected">Mensalidades</li></a>';
                            } else  {
                                echo '<a href="'. APP_URL . 'perfil/mensalidades"><li>Mensalidades</li></a>';
                            }
                            
                            if($tipo == "objetivos")  {
                                echo '<a href="'. APP_URL . 'perfil/objetivos"><li class="menu-vertical-selected">Objetivos e análises</li></a>';
                            } else  {
                                echo '<a href="'. APP_URL . 'perfil/objetivos"><li>Objetivos e análises</li></a>';
                            }
                            
                            if($tipo == "evolução")  {
                                echo '<a href="'. APP_URL . 'perfil/evolução"><li class="menu-vertical-selected">Evolução</li></a>';
                            } else  {
                                echo '<a href="'. APP_URL . 'perfil/evolução"><li>Evolução</li></a>';
                            }
                            
                            if($tipo == "planos" || $tipo == "plano_exercicios" || $tipo == "exercicio" && isset($_GET['plano']))  {
                                echo '<a href="'. APP_URL . 'perfil/planos"><li class="menu-vertical-selected">Planos</li></a>';
                            } else  {
                                echo '<a href="'. APP_URL . 'perfil/planos"><li>Planos</li></a>';
                            }
                            
                            if($tipo == "biblioteca_exercicios" || $tipo == "exercicios" || $tipo == "exercicio" && !isset($_GET['plano']))  {
                                echo '<a href="'. APP_URL . 'perfil/biblioteca_exercicios"><li class="menu-vertical-selected">Biblioteca de exercícios</li></a>';
                            } else  {
                                echo '<a href="'. APP_URL . 'perfil/biblioteca_exercicios"><li>Biblioteca de exercícios</li></a>';
                            }
                        } else if(isset($_SESSION['cod_user'], $_SESSION['role']) && $_SESSION['role'] == 2) {
                            if($tipo == "informações" || $tipo == "")  {
                                echo '<a href="'. APP_URL . 'perfil/informações"><li class="menu-vertical-selected">Informações</li></a>';
                            } else  {
                                echo '<a href="'. APP_URL . 'perfil/informações"><li>Informações</li></a>';
                            }
                            
                            if($tipo == "administrar_planos")  {
                                echo '<a href="'. APP_URL . 'perfil/administrar_planos"><li class="menu-vertical-selected">Administrar planos</li></a>';
                            } else  {
                                echo '<a href="'. APP_URL . 'perfil/administrar_planos"><li>Administrar planos</li></a>';
                            }
                        }
                    ?>
                </ul>
            </div>
            
            <div id="area-consulta">
                <?php
                    switch ($tipo) {
                        case "informações":
                            if(verificaExisteFicheiro("parts/perfil_informacoes.php")) {
                                include_once("parts/perfil_informacoes.php");
                            } else {
                                echo "<p style=\"color: #fff\">Esta funcionalidade ainda não está disponivel.</p>";
                            }
                            break;

                        case "mensalidades":
                            if(verificaExisteFicheiro("parts/perfil_mensalidades.php")) {
                                include_once("parts/perfil_mensalidades.php");
                            } else {
                                echo "<p style=\"color: #fff\">Esta funcionalidade ainda não está disponivel.</p>";
                            }
                            break;

                        case "objetivos":
                            if(verificaExisteFicheiro("parts/perfil_objetivos.php")) {
                                include_once("parts/perfil_objetivos.php");
                            } else {
                                echo "<p style=\"color: #fff\">Esta funcionalidade ainda não está disponivel.</p>";
                            }
                            break;

                        case "evolução":
                            if(verificaExisteFicheiro("parts/perfil_evolucao.php")) {
                                include_once("parts/perfil_evolucao.php");
                            } else {
                                echo "<p style=\"color: #fff\">Esta funcionalidade ainda não está disponivel.</p>";
                            }
                            break;

                        case "planos":
                            if(verificaExisteFicheiro("parts/perfil_planos.php")) {
                                include_once("parts/perfil_planos.php");
                            } else {
                                echo "<p style=\"color: #fff\">Esta funcionalidade ainda não está disponivel.</p>";
                            }
                            break;

                        case "encomendas":
                            if(verificaExisteFicheiro("parts/perfil_encomendas.php")) {
                                include_once("parts/perfil_encomendas.php");
                            } else {
                                echo "<p style=\"color: #fff\">Esta funcionalidade ainda não está disponivel.</p>";
                            }
                            break;

                        case "primeira_avaliacao":
                            if(verificaExisteFicheiro("parts/perfil_primeira_avaliacao.php")) {
                                include_once("parts/perfil_primeira_avaliacao.php");
                            } else {
                                echo "<p style=\"color: #fff\">Esta funcionalidade ainda não está disponivel.</p>";
                            }
                            break;

                        case "biblioteca_exercicios":
                            if(verificaExisteFicheiro("parts/perfil_biblioteca_exercicios.php")) {
                                include_once("parts/perfil_biblioteca_exercicios.php");
                            } else {
                                echo "<p style=\"color: #fff\">Esta funcionalidade ainda não está disponivel.</p>";
                            }
                            break;

                        case "exercicios":
                            if(verificaExisteFicheiro("parts/perfil_exercicios.php")) {
                                include_once("parts/perfil_exercicios.php");
                            } else {
                                echo "<p style=\"color: #fff\">Esta funcionalidade ainda não está disponivel.</p>";
                            }
                            break;

                        case "exercicio":
                            if(verificaExisteFicheiro("parts/perfil_exercicio.php")) {
                                include_once("parts/perfil_exercicio.php");
                            } else {
                                echo "<p style=\"color: #fff\">Esta funcionalidade ainda não está disponivel.</p>";
                            }
                            break;

                        case "plano_exercicios":
                            if(verificaExisteFicheiro("parts/perfil_plano_exercicios.php")) {
                                include_once("parts/perfil_plano_exercicios.php");
                            } else {
                                echo "<p style=\"color: #fff\">Esta funcionalidade ainda não está disponivel.</p>";
                            }
                            break;

                        default:
                            if(verificaExisteFicheiro("parts/perfil_informacoes.php")) {
                                include_once("parts/perfil_informacoes.php");
                            } else {
                                echo "<p style=\"color: #fff\">Esta funcionalidade ainda não está disponivel.</p>";
                            }
                    }
                ?>
            </div>
        </article>

        <br><br><br><br>
        <div style="position: fixed; bottom: 0; width: 100%;">
            <div class = "gradCinBlack"></div>
            <footer>
                <?php include("parts/footer.php"); ?>
            </footer>
        </div>
        <script src = "js/perfil.js"></script>
    </body>
</html>            