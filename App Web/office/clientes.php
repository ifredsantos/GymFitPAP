<?php
    include("../config.php");
    include("verifica-acesso.php");

    $dataAtual = date("Y-m-d");

    $msg = "";

    if(isset($_POST['acao']) && $_POST['acao'] == "alterarMensalidadeEdesconto") {
        $param = [
            ":cod_utilizador" => $_POST['cod_utilizador']
        ];
        $buscaMensalidadeAtual = $gst->exe_query("
        SELECT mensalidade, desconto FROM mensalidades_aquisicoes WHERE atual LIKE 's' AND utilizador = :cod_utilizador", $param);
        if(count($buscaMensalidadeAtual) > 0) {
            $mensalidadeAtual = $buscaMensalidadeAtual[0]["mensalidade"];
            $descontoAtual = $buscaMensalidadeAtual[0]["desconto"];
        } else {
            $mensalidadeAtual = $descontoAtual = 0;
        }
        $mensalidadeNova = $_POST['mensalidade'];
        $descontoNovo = $_POST['desconto'];

        if($mensalidadeAtual != $mensalidadeNova || $descontoAtual != $descontoNovo) {
            $anulaMensalidadeAtual = $gst->exe_non_query("
            UPDATE mensalidades_aquisicoes SET atual = 'n' WHERE utilizador = :cod_utilizador AND atual = 's'", $param);
            
            if($anulaMensalidadeAtual) {
                $param = [
                    ":cod_utilizador" => $_POST['cod_utilizador'],
                    ":mens" => $mensalidadeNova,
                    ":desc" => $descontoNovo
                ];
                $registaNovaMensalidade = $gst->exe_non_query("
                INSERT INTO mensalidades_aquisicoes (utilizador, mensalidade, desconto, data_aquisicao, atual) VALUES 
                (
                    :cod_utilizador,
                    :mens,
                    :desc,
                    NOW(),
                    's'
                )", $param);

                if($registaNovaMensalidade)
                    $msg .= MSGsuccess("Sucesso", "A mensalidade do utilizador foi alterada com sucesso", "");
                else
                    $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel alterar a mensalidade do utilizador pretendido", "");
            }
        }
    }

    // ==================================================
    // Regista um cliente
    // ==================================================
    if(isset($_POST['acao']) && $_POST['acao'] == "addCliente") {
        $erros = false;

        // Validação de dados
        $nome = $_POST['nome'];
        if(strlen($nome) > 100) {
            $msg .= MSGdanger("Ocorreu um erro", "O comprimento do nome ultrapassa os 100 caracteres", "");
            $erros = true;
        }

        $nif = $_POST['nif'];
        if($nif != "")
            if(strlen($nif) > 9) {
                $msg .= MSGdanger("Ocorreu um erro", "O comprimento do NIF ultapassa os 9 digitos", "");
                $erros = true;
            }

        $email = $_POST['email'];
        if(strlen($email) > 100) {
            $msg .= MSGdanger("Ocorreu um erro", "O comprimento do email ultrapassa os 100 caracteres", "");
            $erros = true;
        }

        $telefone = $_POST['telefone'];
        if(strlen($telefone) > 13) {
            $msg .= MSGdanger("Ocorreu um erro", "O comprimento do telefone ultrapassa os 13 caracteres", "");
            $erros = true;
        }

        $genero = $_POST['genero'];
        if($genero != "m" && $genero != "f" && $genero != "o") {
            $msg .= MSGdanger("Ocorreu um erro", "Género inválido", "");
            $erros = true;
        }

        $tipoMensalidade = $_POST['tipo_mensalidade'];
        $tipoDesconto = $_POST['tipo_desconto'];

        $dataAdesao = $_POST['data_adesao'];
        if($dataAdesao > $dataAtual) {
            $msg .= MSGdanger("Ocorreu um erro", "Data de adesão inválida", "");
            $erros = true;
        }

        $dataNascimento = $_POST['data_nascimento'];
        if($dataNascimento >= $dataAtual) {
            $msg .= MSGdanger("Ocorreu um erro", "Data de nascimento inválida", "");
            $erros = true;
        }

        $novoCliente = $_POST['novoCliente'];

        if($nome == "" || $dataNascimento == "" || $genero == "") {
            $msg .= MSGdanger("Ocorreu um erro", "Preencha todos os campo obrigatórios (*)", "");
            $erros = true;
        }
        // ==================================================

        

        // Verificar se já existe um cliente com o mesmo email
        $param = [":email" => $email];
        $verExisteEmail = $gst->exe_query("SELECT cod_utilizador FROM utilizadores WHERE email = :email", $param);
        if(count($verExisteEmail) > 0) {
            $msg .= MSGdanger("Ocorreu um erro", "Já existe uma conta com este email em uso", "");
            $erros = true;
        }
        // ==================================================



        // Se não existir erros
        if($erros == false) {
            // Cria um código de utilizador
            $buscaUltimoCodUser = $gst->exe_query("SELECT MAX(cod_utilizador) AS MAX_USER FROM utilizadores");
            $newCodUser = $buscaUltimoCodUser[0]["MAX_USER"] + 1;

            
            // Cria o registo do cliente
            $param = [
                ":new_cod_user" => $newCodUser,
                ":nome" => $nome,
                ":nif" => $nif,
                ":email" => $email,
                ":telefone" => $telefone,
                ":gen" => $genero,
                ":dataNasc" => $dataNascimento,
                ":dataAdesao" => $dataAdesao
            ];
            $utilizadorRegisto = $gst->exe_non_query("
            INSERT INTO utilizadores(cod_utilizador, nome, nif, email, telefone, genero, data_nascimento, data_adesao, tipo_utilizador) VALUES (
                :new_cod_user,
                :nome,
                :nif,
                :email,
                :telefone,
                :gen,
                :dataNasc,
                :dataAdesao,
                5
            )", $param);
            // ==================================================



            // Faz um pré-registo
            $codPreRegisto = criaSerial();

            $param = [
                ":cod_pre_reg" => $codPreRegisto,
                ":new_cod_user" => $newCodUser
            ];
            $preRegisto = $gst->exe_non_query("INSERT INTO utilizadores_pre_registos(cod_preReg, utilizador) VALUES (
                :cod_pre_reg,
                :new_cod_user
            )", $param);
            // ==================================================



            // Se o pré-registo for criado com sucesso
            if($utilizadorRegisto && $preRegisto) {
                $msg .= MSGsuccess("Sucesso", "O pré-registo foi criado", "");

                // Se tiver sido escolhida uma mensalidade
                if($tipoMensalidade != 1) {
                    $registaMensalidadePadrao = $gst->exe_non_query("
                    INSERT INTO mensalidades_aquisicoes (
                        utilizador,
                        mensalidade, 
                        desconto, 
                        data_aquisicao, 
                        atual
                    ) VALUES (
                        $newCodUser,
                        $tipoMensalidade,
                        $tipoDesconto,
                        NOW(),
                        's'
                    )", $param);
                    if($registaMensalidadePadrao) {
                        $msg .= MSGsuccess("Sucesso", "A mensalidade atual foi atribuida", "");
                    }
                }
                // ==================================================



                // Se o campo email for inserido envia um email para o mesmo
                if($email != "") {
                    // Se for um novo cliente prepara o texto de boas vindas e a informar o sistema online
                    if($novoCliente == "s") {
                        $email_assunto = "Seja bem vindo ao GymFit";
                        $email_msg1 = "Olá, $nome <br>
                        Seja bem bindo ao GymFit<br>
                        Recentemente inscreveu-se no GymFit.";
                        $email_msg2 = "Já criou o seu <a href=\"#\">perfil online</a>??";
                        $email_msg3 = "Complete o seu registo do GymFit online e tenha acesso as novas funcionalidades como: <br>
                        <ul style=\"margin-left: 30px; margin-bottom: 10px;\">
                            <li>Pagamento e consulta de mensalidades</li>
                            <li>Objetivos</li>
                            <li>Evolução</li>
                            <li>Planos de treino/alimentação</li>
                        </ul>
                        <p>Quando criar a sua conta insira o código abaixo para a sua ficha cliente já criada ser associada:</p>
                        <div style=\"text-align: center; width: 270px; padding: 8px; border: 1px solid grey; border-radius: 20px;\">$codPreRegisto</div> ";
                        $email_msg4 = "Estamos à sua espera!<br>
                        <small>Experimente a nossa aplicação para smartphones é facil de usar!</small>";
                    } 
                    // Se for um cliente antigo prepara o texto a informar o novo sistema online
                    else {
                        $email_assunto = "Já aderiu ao GymFit Online?";
                        $email_msg1 = "Olá, $nome ";
                        $email_msg2 = "";
                        $email_msg3 = "Complete o seu registo do GymFit online e tenha acesso as novas funcionalidades como: <br>
                        <ul style=\"margin-left: 30px; margin-bottom: 10px;\">
                            <li>Pagamento e consulta de mensalidades</li>
                            <li>Objetivos</li>
                            <li>Evolução</li>
                            <li>Planos de treino/alimentação</li>
                        </ul>
                        <p>Quando criar a sua conta insira o código abaixo para a sua ficha cliente anterior ser associada:</p>
                        <div style=\"text-align: center; width: 270px; padding: 8px; border: 1px solid grey; border-radius: 20px;\">$codPreRegisto</div> ";
                        $email_msg4 = "Estamos à sua espera!<br>
                        <small>Experimente a nossa aplicação para smartphones é facil de usar!</small>";
                    }

                    $txt_email = emailDefault("$email_assunto", "$email_msg1", "$email_msg2", "$email_msg3", "$email_msg4");

                    if(enviaEmail($email, $nome, $email_assunto, $txt_email, "", "")) {
                        $msg .= MSGsuccess("Sucesso", "Email enviado ao cliente", "");
                    } else {
                        $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel enviar um email ao cliente", "");
                    }
                }
                // ==================================================



            } else {
                $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel fazer o pré-registo do cliente", "");
            }
            // ==================================================
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
                    <p><a id = "trace-link-main" href = "clientes">Clientes</a></p>
                </div>
            </div>

            <!-- Cabeçalho de pesquisas -->
            <div class = "col-md-10 offset-md-2">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-6">
                                <div id="custom-search-input">
                                    <form class="input-group col-md-12" action="<?= APP_URL_OFFICE ?>clientes" method="post">
                                        <input name="pesquisa" type="text" class="form-control" placeholder="Pesquisar">
                                        <input type="hidden" name="acao" value="pesquisar">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="submit">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </span>
                                    </form>
                                </div>
                            </div>
                            <div class="col col-xs-6 text-right">
                                <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#adicionarCliente" style="height: 42px;">Adicionar cliente</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal com formulário para registar um cliente -->
                    <div class="modal fade" id="adicionarCliente" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">Adicionar Cliente</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="clientes" method="post">
                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="nome">Nome</label>
                                                <input name="nome" 
                                                    type="text" 
                                                    class="form-control" 
                                                    placeholder="Insira o nome do cliente">
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="telefone">NIF</label>
                                                <input name="nif" 
                                                       type="text" 
                                                       class="form-control" 
                                                       placeholder="Insira o NIF">
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="email">Email</label>
                                                <input name="email" 
                                                    type="email" 
                                                    class="form-control" 
                                                    placeholder="Insira o email do cliente">
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="telefone">Telefone</label>
                                                <input name="telefone" 
                                                       type="text" 
                                                       class="form-control" 
                                                       placeholder="Insira o telefone do cliente">
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="data_nascimento">Data de nascimento</label>
                                                <input name="data_nascimento" 
                                                       type="date" 
                                                       class="form-control" 
                                                       required>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="genero">Género</label>
                                                <select name="genero" class="form-control" required>
                                                    <option value="m">Masculino</option>
                                                    <option value="f">Feminino</option>
                                                    <option value="o">Outro</option>
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="tipo_mensalidade">Tipo de Mensalidade</label>
                                                <select name="tipo_mensalidade" class="form-control" required>
                                                    <?php
                                                        $buscaMensalidades = $gst->exe_query("SELECT * FROM mensalidades");
                                                        if(count($buscaMensalidades) > 0) {
                                                            for($i = 0; $i < count($buscaMensalidades); $i++) {
                                                                $infMsl = $buscaMensalidades[$i];
                                                    ?>
                                                    <option value="<?= $infMsl['cod_mensalidade'] ?>"><?= $infMsl['nome_mensalidade']." | ". preco($infMsl['preco']) ?></option>
                                                    <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo "<option value=''>Sem mensalidades</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="tipo_desconto">Tipo de Desconto</label>
                                                <select name="tipo_desconto" class="form-control" required>
                                                    <?php
                                                        $buscaMensalidadesDescontos = $gst->exe_query("SELECT * FROM mensalidades_descontos");
                                                        if(count($buscaMensalidadesDescontos) > 0) {
                                                            for($i = 0; $i < count($buscaMensalidadesDescontos); $i++) {
                                                                $infMslDesconto = $buscaMensalidadesDescontos[$i];
                                                    ?>
                                                    <option value="<?= $infMslDesconto['cod_desconto'] ?>"><?= $infMslDesconto['nome_desconto']." | ". preco($infMslDesconto['valor_desconto']) ?></option>
                                                    <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo "<option value=''>Sem mensalidades</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                <label for="data_adesao">Data de adesão</label>
                                                <input name="data_adesao" 
                                                        type="date" 
                                                        class="form-control" 
                                                        value="<?= $dataAtual ?>"
                                                        required>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6" style="padding-left: 15px; padding-right: 0px;">
                                                <label for="novoCliente">É um novo cliente?</label>
                                                <select name="novoCliente" class="form-control" required>
                                                    <option value="s">Sim</option>
                                                    <option value="n">Não</option>
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
                                                    <input type="hidden" name="acao" value="addCliente">
                                                    <button type="submit" class="btn btn-default btn-hover-green" role="button">Adicionar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="utilizadorExtraInfo" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fechar</span></button>
                                    <h3 class="modal-title" id="lineModalLabel">Consultar informação do cliente</h3>
                                </div>
                                <div class="modal-body" id="result">
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="resultado_pesquisa"></div>
                    
                    <!-- Tabela -->
                    <div class="panel-body" id="resultado_anterior">
                        <table class="table table-striped table-bordered table-list">
                            <thead>
                                <tr>
                                    <th><em class="fa fa-cog"></em></th>
                                    <th>Nome</th>
                                    <th>NIF</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Mensalidade</th>
                                    <th>Desconto</th>
                                    <th>Idade</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $quantidade = 10;
                                $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
                                $inicio = ($quantidade * $pagina) - $quantidade;

                                $param = [];
                                $sqlPesquisa = "";
                                // Busca os clientes
                                $sqlBuscaClientes = "
                                SELECT U.cod_utilizador, U.nome, U.nif, U.email, U.telefone, U.data_adesao, U.data_nascimento, U.genero, 
                                uT.nome_regra 
                                FROM utilizadores U 
                                    INNER JOIN utilizadores_tipo uT ON U.tipo_utilizador = uT.cod_regra 
                                WHERE ";
                                if(isset($_POST['acao']) && $_POST['acao'] == "pesquisar" || isset($_GET['pesquisa']) && $_GET['pesquisa'] != "") {
                                    if(isset($_POST['acao']))
                                        $pesquisa = $_POST['pesquisa'];
                                    else if(isset($_GET['pesquisa']))
                                        $pesquisa = $_GET['pesquisa'];

                                    $sqlPesquisa = " U.nome LIKE '%".$pesquisa."%' AND U.tipo_utilizador = 3 
                                    OR U.nome LIKE '%".$pesquisa."%' AND U.tipo_utilizador = 5 ";
                                } else {
                                    $param = [];
                                    $sqlPesquisa .= "U.tipo_utilizador = 3 OR U.tipo_utilizador = 5 ";
                                }
                                $sqlBuscaClientes .= $sqlPesquisa."LIMIT $inicio, $quantidade";
                                $buscaClientes = $gst->exe_query($sqlBuscaClientes, $param);

                                
                                $sqlContaTotal = "
                                SELECT COUNT(U.cod_utilizador) AS NUMCLIENTES 
                                FROM utilizadores U 
                                    INNER JOIN utilizadores_tipo uT ON U.tipo_utilizador = uT.cod_regra 
                                WHERE ";
                                $sqlContaTotal .= $sqlPesquisa;

                                $qrTotal = $gst->exe_query($sqlContaTotal);
                                $numTotal = $qrTotal[0]["NUMCLIENTES"];
                                
                                $totalPagina= ceil($numTotal/$quantidade);
                                
                                $exibir = 10;
                                $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
                                $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
                                
                                if(count($buscaClientes) > 0) {
                                    for($i = 0; $i < count($buscaClientes); $i++) {
                                        $infCliente = $buscaClientes[$i];

                                        $codUtilizador = $infCliente['cod_utilizador'];
                                        $dataNasc = $infCliente['data_nascimento'];
                                        
                                        list($ano, $mes, $dia) = explode('-', $dataNasc);
                                        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                                        $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

                                        $idade = floor((((($hoje-$nascimento)/60)/60)/24)/365.25);
                                        
                                        $telefone = mascaraTelefone($infCliente['telefone'], 3, " ");

                                        $param = [
                                            ":cod_utilizador" => $codUtilizador
                                        ];
                                        $buscaMensalidadeEdescontoAtual = $gst->exe_query("
                                        SELECT nome_mensalidade, nome_desconto FROM mensalidades_aquisicoes 
                                            INNER JOIN mensalidades ON mensalidades_aquisicoes.mensalidade = mensalidades.cod_mensalidade 
                                            INNER JOIN mensalidades_descontos ON mensalidades_aquisicoes.desconto = mensalidades_descontos.cod_desconto 
                                        WHERE utilizador = :cod_utilizador AND atual LIKE 's'", $param);
                                        if(count($buscaMensalidadeEdescontoAtual) > 0)
                                            $infMensDesc = $buscaMensalidadeEdescontoAtual[0];
                                        else $infMensDesc["nome_mensalidade"] = $infMensDesc["nome_desconto"] = "";
                            ?>
                                <tr>
                                    <td align="center">
                                        <a class="btn btn-default" data-toggle="modal" data-target="#utilizadorExtraInfo" onclick="getInfUtilizadorExtra('<?= $codUtilizador ?>')"><em class="fa fa-pencil"></em></a>
                                    </td>
                                    <!--<td class="hidden-xs">1</td>-->
                                    <td><?= $infCliente['nome'] ?></td>
                                    <td><?= $infCliente['nif'] ?></td>
                                    <td><?= $infCliente['email'] ?></td>
                                    <td><?= $telefone ?></td>
                                    <td><?= $infMensDesc['nome_mensalidade'] ?></td>
                                    <td><?= $infMensDesc['nome_desconto'] ?></td>
                                    <td><?= $idade ?></td>
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

                                        //if($posterior == 0) $posterior = 1;
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