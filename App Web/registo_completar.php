<?php
    require 'config.php';  

    $msg = "";
    $dataAtual = date('Y-m-d');

    // ==================================================
    // Completar o registo de cliente
    // ==================================================
    if(isset($_POST['acao'], $_POST['acao_sec']) && $_POST['acao'] == "registar" && $_POST['acao_sec'] == "completar-registo") {
        $erros = 0;
        $tipoUser = 4;

        $cod_utilizador = $_POST['utilizador'];
        
        //ADQUIRE OS DADOS INTRODUZIDOS NO FORMULÁRIO E FAZ AS RESPÉTIVAS VALIDAÇÕES
        $genero = $_POST['gen'];
        if($genero != "m" && $genero != "f") {
            $msg .= MSGdanger("Ocorreu um erro", "Género inválido", "");
            $erros = 1;
        }
        
        $nome = $_POST['nome'];
        if(strlen($nome) > 100) {
            $msg .= MSGdanger("Ocorreu um erro", "O comprimento do nome ultrapassa os 100 caracteres", "");
            $erros = 1;
        }

        $nif = $_POST['nif'];
        if($nif != "")
            if(strlen($nif) > 9) {
                $msg .= MSGdanger("Ocorreu um erro", "O comprimento do NIF ultapassa os 9 digitos", "");
                $erros = true;
            }
        
        $username = $_POST['username'];
        if(strlen($username) > 30) {
            $msg .= MSGdanger("Ocorreu um erro", "O comprimento do username ultrapassa os 30 caracteres", "");
            $erros = 1;
        }
        
        $email = $_POST['email'];
        if(strlen($email) > 100) {
            $msg .= MSGdanger("Ocorreu um erro", "O comprimento do email ultrapassa os 100 caracteres", "");
            $erros = 1;
        }
        
        $psw = $_POST['psw'];
        if(strlen($psw) > 32) {
            $msg .= MSGdanger("Ocorreu um erro", "O comprimento da password ultrapassa os 32 caracteres", "");
            $erros = 1;
        }
        $conf_psw = $_POST['conf_psw'];
        if($psw != $conf_psw) {
            $msg .= MSGdanger("Ocorreu um erro", "As passwords não correspondem", "");
            $erros = 1;
        }
        
        $data_nasc = $_POST['data_nasc'];
        if($data_nasc >= $dataAtual) {
            $msg .= MSGdanger("Ocorreu um erro", "Data de nascimento inválida", "");
            $erros = 1;
        }
        
        if($genero == "" || $nome == "" || $username == "" || $email == "" || $psw == "" || $conf_psw == "" || $data_nasc == "") {
            $msg .= MSGdanger("Ocorreu um erro", "Preencha todos os campo obrigatórios (*)", "");
            $erros = 1;
        }
        
        //SE NÃO OCORRER NENHUM ERRO
        if($erros == 0) {
            // Verifica se já existe um cliente com o mesmo username
            $param = [
                ":username" => $username
            ];
            $verExisteUsername = $gst->exe_query("
            SELECT cod_utilizador FROM utilizadores WHERE username = :username", $param);

            if(count($verExisteUsername) > 0) {
                $msg .= MSGdanger("Ocorreu um erro", "Já existe uma conta com este username em uso.", "");
                $erros = 1;
            }

            // Verifica se já existe um email igual que não corresponda ao pré-registo
            $param = [
                ":email" => $email,
                ":utilizador" => $cod_utilizador
            ];
            $verificaExisteEmail = $gst->exe_query("
            SELECT cod_utilizador FROM utilizadores U 
                INNER JOIN utilizadores_pre_registos UPR ON U.cod_utilizador <> UPR.utilizador 
            WHERE U.email LIKE :email AND cod_utilizador <> :utilizador", $param);
            if(count($verificaExisteEmail) > 0) {
                $_SESSION["mensagem"] = MSGdanger("Ocorreu um erro", "Já existe uma conta com este email em uso que não pertence a este pré-registo.", "");
                $erros = 1;
            }

            //SE CONTINUAR SEM EXISTIR ERROS
            if($erros == 0) {
                //ENCRIPTA A PASSWORD
                $psw = md5($psw);
                
                //REGISTA NA BD AS INFORMAÇÕES DO UTILIZADOR
                $param = [
                    ":cod_user" => $cod_utilizador,
                    ":username" => $username,
                    ":nome" => $nome,
                    ":nif" => $nif,
                    ":email" => $email,
                    ":psw" => $psw,
                    ":genero" => $genero,
                    ":data_nascimento" => $data_nasc,
                    ":tipo_utilizador" => $tipoUser
                ];
                $updateUser = $gst->exe_non_query("
                UPDATE utilizadores SET 
                    username = :username,
                    nome = :nome,
                    nif = :nif,
                    email = :email,
                    psw = :psw,
                    genero = :genero,
                    data_nascimento = :data_nascimento,
                    tipo_utilizador = :tipo_utilizador
                WHERE cod_utilizador = :cod_user", $param);

                // CANCELA A MENSALIDADE ANTERIOR
                $param = [":utilizador" => $cod_utilizador];
                $cancelaMensalidadeAnterior = $gst->exe_non_query("
                UPDATE mensalidades_aquisicoes SET atual = 'n' WHERE utilizador = :utilizador", $param);

                // REGISTA NA BD A MENSALIDADE ATUAL
                $cod_mensalidade = $_POST['mensalidade'];
                $cod_desconto = $_POST['desconto'];

                if($cod_mensalidade == 4)
                    $cod_desconto = 1;

                $param = [
                    ":utilizador" => $cod_utilizador,
                    ":mensalidade" => $cod_mensalidade,
                    ":desconto" => $cod_desconto
                ];
                $selecionaMensalidadeAtual = $gst->exe_non_query("
                INSERT INTO mensalidades_aquisicoes (utilizador, mensalidade, desconto, data_aquisicao, atual)
                VALUES (
                    :utilizador,
                    :mensalidade,
                    :desconto,
                    NOW(),
                    's'
                )", $param);

                $param = [
                    ":utilizador" => $cod_utilizador,
                    ":ano" => date('Y')
                ];
                $inserePreSeguro = $gst->exe_non_query("
                INSERT INTO seguros (utilizador, ano) VALUES (:utilizador, :ano)", $param);

                //CRIAR UM SERIAL E REGISTA-O PARA POSTERIORMENTE O UTILIZADOR CONFIRMAR O EMAIL
                $dataHora = date("Y-m-d H:i:s");
                $token = md5(uniqid(rand(), true));

                $param = [
                    ":cod_utilizador" => $cod_utilizador,
                    ":token" => $token,
                    ":dataHora" => $dataHora
                ];
                $registaToken = $gst->exe_non_query("
                INSERT INTO utilizadores_confirmacao (cod_user, chave_confirmacao, date_pedido) VALUES 
                (
                    :cod_utilizador, 
                    :token, 
                    :dataHora
                )", $param);
                
                // ==================================================
                $email_assunto = "Confirme a sua conta do GymFit";
                $email_msg1 = "Olá, $nome <br>Recentemente completou um pré-registo de uma conta no GymFit.";
                $email_msg2 = "Está a um passo para poder usar a sua conta!";
                $email_msg3 = "Confirme já a sua conta <a href='".APP_URL."validar-conta/ativar/$email/$token'>aqui</a>.";
                $email_msg4 = "";
                
                $txt_email = emailDefault($email_assunto, $email_msg1, $email_msg2, $email_msg3, $email_msg4);

                if(enviaEmail($email, $nome, $email_assunto, $txt_email, "", "")) {
                    if($updateUser && $selecionaMensalidadeAtual) {
                        $msg .= MSGsuccess("Sucesso", "A sua conta foi completada", "");
                        $msg .= MSGinfo("Informação", "Foi enviado um email de confirmação para o seu endereço de email", "");

                        $param = [":utilizador" => $cod_utilizador];
                        $apagarCodigoPreRegisto = $gst->exe_non_query("
                        DELETE FROM utilizadores_pre_registos WHERE utilizador = :utilizador", $param);
                    } else {
                        $msg .= MSGdanger("Ocorreu um erro", "Ups...Parece que ocorreu um erro ao criar a sua conta. Tente novamente mais tarde, se o erro persistir contacte um oficial", "");
                    }
                }
            }
            else
            {
                //header('Location: ' . APP_URL . "completar-registo");
            }
        }
    }
?>

<!DOCTYPE html>

<html lang = "pt-pt">
    <head>
        <base href="<?= APP_URL ?>">
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="content-language" content="pt">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="cache-control" content="private">
        <meta name="author" content="<?= PROGRAMER_NAME ?>, <?= PROGRAMER_EMAIL ?>">
        <meta name="reply-to" content="<?= PROGRAMER_EMAIL ?>">
        <meta name="rating" content="general">
        <title><?= APP_NAME ?> - Ginásio & Fitness</title>
        <link rel="icon" href="layout/altere.png" type="image/x-icon">
        <link rel="shortcut icon" href="layout/altere.png" type="image/x-icon">
        <link rel = "stylesheet" type = "text/css" href = "layout/css/design.css">
    </head>
    
    <body onselectstart="return false" data-spy="scroll" data-target="#myScrollspy" data-offset="50">
        <header id = "#myScrollspy">
            <?php include 'parts/header.php';?>
        </header>
        
        <article style="padding-top: 50px;">
            <br>
            <?php
                if($msg != "")  { ?>
            <div class="msg-space-modal" id="msg-space-modal">
                <div class="msg-content-modal">
                    <?= $msg; ?>
                </div>
            </div>
            <?php } ?>

            <?php
                if(isset($_SESSION["mensagem"]) && !empty($_SESSION["mensagem"]))  { ?>
            <div class="msg-space-modal" id="msg-space-modal">
                <div class="msg-content-modal">
                    <?= $_SESSION["mensagem"]; ?>
                </div>
            </div>
            <?php $_SESSION["mensagem"] = null; } ?>

            <?php
                if(!isset($_POST['acao']) || isset($_POST['acao_sec']) && $_POST['acao_sec'] != "completar-registo") {
            ?>

            <form id="frm-antigo-cliente-codigo" class="form-registo" name="completar-registo" method="post" action="completar-registo">
                <div class="form-registo-ld-left" style="width: 100%; border: none;">
                    <div>
                        <label for="nome">Código <span>*</span></label>
                        <br>
                        <input 
                               name="code"
                               id="code"
                               type="text"
                               placeholder="Insira o seu código de pré-registo" 
                               onkeypress="return mask(event, this, '####-####-####-####')" maxlength="19" 
                               required>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>
                <input type="hidden" name="acao" value="completar-codigo">
                <input class="from-registo-btn-submit" type="submit" value="Completar">
            </form>

            <?php
                }
                if(isset($_POST['acao']) && $_POST['acao'] == "completar-codigo") {
                    $serial = $_POST['code'];

                    $param = [
                        ":serial" => $serial
                    ];
                    $buscaDados = $gst->exe_query("
                    SELECT cod_utilizador, username, nome, nif, email, telefone, genero, data_nascimento, cod_mensalidade, nome_mensalidade, preco, cod_desconto, nome_desconto, valor_desconto 
                    FROM utilizadores 
                        INNER JOIN utilizadores_pre_registos ON utilizadores.cod_utilizador = utilizadores_pre_registos.utilizador 
                        INNER JOIN mensalidades_aquisicoes ON utilizadores.cod_utilizador = mensalidades_aquisicoes.utilizador 
                        INNER JOIN mensalidades ON mensalidades_aquisicoes.mensalidade = mensalidades.cod_mensalidade 
                        INNER JOIN mensalidades_descontos ON mensalidades_aquisicoes.desconto = mensalidades_descontos.cod_desconto 
                    WHERE cod_preReg = :serial", $param);

                    if(count($buscaDados) == 0) {
                        $codigo = $nome = $email = $telefone = $genero = $data_nasc = "";
                        echo MSGdanger("Ocorreu um erro", "Não existe um pré-registo com o código inserido para tentar novamente clique", "http://localhost/app_web/registo");
                    } else {
                        $codigo = $buscaDados[0]['cod_utilizador'];
                        $nome = $buscaDados[0]['nome'];
                        $nif = $buscaDados[0]['nif'];
                        $email = $buscaDados[0]['email'];
                        $telefone = $buscaDados[0]['telefone'];
                        $genero = $buscaDados[0]['genero'];
                        $data_nasc = $buscaDados[0]['data_nascimento'];
                        $cod_mensalidade = $buscaDados[0]['cod_mensalidade'];
                        $nome_mensalidade = $buscaDados[0]['nome_mensalidade'];
                        $preco_mensalidade = $buscaDados[0]['preco'];
                        $cod_desconto = $buscaDados[0]['cod_desconto'];
                        $nome_desconto = $buscaDados[0]['nome_desconto'];
                        $valor_desconto = $buscaDados[0]['valor_desconto'];
            ?>

            <form id="frm-antigo-cliente" class="form-registo" method="post" action="completar-registo">
                <div class="form-registo-ld-left" style="width: 100%; border: none;">
                    <h3>Completar registo</h3>
                    <br>
                    <div>
                        <select 
                                name="gen"
                                required>
                            <?php
                                if($genero == "m") {
                                    echo '<option value="m">Sr.</option>';
                                    echo '<option value="f">Sra.</option>';
                                    echo '<option value="o">Outro</option>';
                                } else if($genero == 'f') {
                                    echo '<option value="f">Sra.</option>';
                                    echo '<option value="m">Sr.</option>';
                                    echo '<option value="o">Outro</option>';
                                } else {
                                    echo '<option value="m">Sr.</option>';
                                    echo '<option value="f">Sra.</option>';
                                    echo '<option value="o">Outro</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <br>

                    <style>
                        .input_esquerda { width: calc(50% - 15px); float: left; }
                        .input_direita { width: 50%; float: right; }

                        @media(max-width:500px)    {
                            .input_esquerda { width: 100%; float: none; padding-bottom: 20px; }
                            .input_direita { width: 100%; float: none; }
                        }
                    </style>

                    <div>
                        <label for="nome">Nome <span>*</span></label>
                        <br>
                        <input name="nome" id="nome" type="text" placeholder="Nome completo" pattern=".{4,100}" title="O nome deve conter entre 4 e 100 caracteres" value="<?= $nome ?>" required>
                    </div>
                    <br>

                    <div class="input_esquerda">
                        <label for="nif">NIF</label>
                        <br>
                        <input name="nif" id="nif" pattern=".{9}" title="O NIF deve conter 9 caracteres" type="text" placeholder="NIF" value="<?= $nif ?>">
                    </div>

                    <div class="input_direita">
                        <label for="username">Username <span>*</span></label>
                        <br>
                        <input name="username" id="username" pattern=".{4,30}" title="O username deve ter entre 3 a 30 caracteres" type="text" placeholder="Nome de utilizador" required>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <div>
                        <label for="email">Email <span>*</span></label>
                        <br>
                        <input name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="O email introduzido não é válido" type="email" placeholder="Email" required value="<?= $email ?>">
                    </div>
                    <br>

                    <div>
                        <label for="psw">Password <span>*</span></label>
                        <br>
                        <input name="psw" type="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="A password deve conter no mínimo 6 caracteres, incluindo maiúsculas, minúsculas e números" placeholder="Password"
                               required>
                    </div>
                    <p id="msg_password" style="text-align: center;"></p>
                    <br>
                    <div>
                        <label for="conf_psw">Confirmação de Password <span>*</span></label>
                        <br>
                        <input name="conf_psw" type="password" id="confirm_password" placeholder="Confirmação de Password" required>
                    </div>
                    <p id="msg_confirm_password" style="text-align: center;"></p>
                    <br>

                    <div>
                        <label for="data_nasc">Data de nascimento <span>*</span></label>
                        <br>
                        <input
                               name="data_nasc"
                               id="data_nasc"
                               type="date" 
                               required
                               value="<?= $data_nasc ?>">
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr style="border: 1px solid #333232; width: 100%; margin-bottom: 1.2rem; margin-top: 1rem">
                <div class="form-registo-ld-left" style="width: 100%; border: none;">
                    <h3>Informações de mensalidade</h3>
                    <br>

                    <div>
                        <label for="mensalidade">Mensalidade</label>
                        <br>
                        <select name="mensalidade" required>
                            <option value="<?= $cod_mensalidade ?>"><?= $nome_mensalidade ?> - <?= preco($preco_mensalidade) ?> (atual)</option>
                            <?php
                                // Busca as outras mensalidades
                                
                                $param = [
                                    ":cod_mensalidade" => $cod_mensalidade
                                ];
                                $buscaOutrasMensalidades = $gst->exe_query("
                                SELECT * FROM mensalidades WHERE cod_mensalidade <> :cod_mensalidade AND cod_mensalidade <> 1 AND cod_mensalidade <> 5", $param);
                                if(count($buscaOutrasMensalidades) > 0) {
                                    for($i = 0; $i < count($buscaOutrasMensalidades); $i++) {
                                        echo '<option value="'.$buscaOutrasMensalidades[$i]['cod_mensalidade'].'">'.$buscaOutrasMensalidades[$i]['nome_mensalidade'].' - '.preco($buscaOutrasMensalidades[$i]['preco']).'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <br>
                    <div>
                        <label for="desconto">Desconto</label>
                        <br>
                        <input type="text" name="desconto" readonly required value="<?= $nome_desconto ?>">
                    </div>
                </div>

                <div class="clearfix"></div>
                <br>
                <p id = "txt_geral"></p>
                <input type="hidden" name="acao" value="registar">
                <input type="hidden" name="acao_sec" value="completar-registo">
                <input type="hidden" name="utilizador" value=<?= $codigo ?>>
                <input type="hidden" name="desconto" value=<?= $cod_desconto ?>>
                <input class="from-registo-btn-submit" id="btn_submit" type="submit" value="Registar">
            </form>

            <?php
                    }
                }
            ?>
        </article>
        
        <br><br><br><br>
        <div style="position: fixed; bottom: 0; width: 100%;">
            <div class = "gradCinBlack"></div>
            <footer>
                <?php include("parts/footer.php"); ?>
            </footer>
        </div>
        
        <script src = "js/validar_registo.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>            