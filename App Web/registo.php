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
                ":email" => $email
            ];
            $verificaExisteEmail = $gst->exe_query("
            SELECT cod_utilizador FROM utilizadores U 
                INNER JOIN utilizadores_pre_registos UPR ON U.cod_utilizador <> UPR.utilizador 
            WHERE U.email LIKE :email", $param);
            if(count($verificaExisteEmail) > 0) {
                $msg .= MSGdanger("Ocorreu um erro", "Já existe uma conta com este email em uso que não pertence a este pré-registo. Para tentar novamente clique ", "http://localhost/app_web/registo");
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
            
            <div class="msg-space-modal" id="msg-space-modal-opcoes" style="display: block; background-color: rgba(0,0,0,1);">
                <div class="msg-content-modal">
                    <h2 class="text_center">Já tem uma ficha cliente no GymFit?</h2>
                    <p class="text_center">Se já é um cliente que se tenha inscrito no nosso establecimento terá sido enviado um email com um cógido (clique em "Completar registo").</p>
                    <p class="text_center">Caso não lhe tenha sido dado algum código poderá solicitar no nosso establecimento.</p>
                    <p class="text_center"><b>Este código irá associar ao registo que irá fazer a sua ficha cliente já existente.</b></p>
                    <p class="text_center">Se for um cliente novo faça já a sua ficha cliente (clique em "Criar registo")!</p>
                    <div class="space-buttons">
                        <button type="button" style="float: left; background-color: #efefef;">
                            <a style="text-decoration: none; color: black" href="<?= APP_URL ?>completar-registo">Completar registo</a>
                        </button>
                        <button type="button" style="float: right; background-color: #efefef;">
                            <a style="text-decoration: none; color: black" href="<?= APP_URL ?>criar-registo">Criar registo</a>
                        </button>
                    </div>
                </div>
            </div>

            <br>
            <div class = "gradCinBlack"></div>
        </article>
        
        <footer>
            <?php include("parts/footer.php"); ?>
        </footer>
        
        <script src = "js/validar_registo.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>            