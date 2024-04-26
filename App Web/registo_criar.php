<?php
    require 'config.php';  

    $msg = "";
    $dataAtual = date('Y-m-d');
    
    // ==================================================
    // Registar um cliente
    // ==================================================
    if(isset($_POST['acao']) && $_POST['acao'] == "registar" && !isset($_POST['acao_sec'])) {
        $erros = 0;
        $tipoUser = 4;
        
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
        
        $data_nasc = $_POST['data_nasc'];
        if($data_nasc >= $dataAtual) {
            $msg .= MSGdanger("Ocorreu um erro", "Data de nascimento inválida", "");
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
        
        if($genero == "" || $nome == "" || $username == "" || $email == "" || $psw == "" || $conf_psw == "" || $data_nasc == "") {
            $msg .= MSGdanger("Ocorreu um erro", "Preencha todos os campo obrigatórios (*)", "");
            $erros = 1;
        }
        
        //SE NÃO OCORRER NENHUM ERRO
        if($erros == 0) {
            //VERIFICA SE JÁ EXISTE
            $param = [
                ":username" => $username
            ];
            $verExisteUsername = $gst->exe_query("
            SELECT cod_utilizador FROM utilizadores WHERE username = :username", $param);

            if(count($verExisteUsername) > 0) {
                $msg .= MSGdanger("Ocorreu um erro", "Já existe uma conta com este username em uso." , "");
                $erros = 1;
            }
            
            $param = [
                ":email" => $email
            ];
            $verExisteEmail = $gst->exe_query("
            SELECT cod_utilizador FROM utilizadores WHERE email = :email", $param);
            if(count($verExisteEmail) > 0) {
                $msg .= MSGdanger("Ocorreu um erro", "Já existe uma conta com este email em uso", "");
                $erros = 1;
            }
            
            //SE CONTINUAR SEM EXISTIR ERROS
            if($erros == 0) {
                //ADQUIRE O CODIGO DE UTILIZADOR CORRETO
                $buscaUltimoCodUser = $gst->exe_query("
                SELECT MAX(cod_utilizador) AS num_utilizadores FROM utilizadores");
                $newCodUser = $buscaUltimoCodUser[0]['num_utilizadores'] + 1;
                
                //ENCRIPTA A PASSWORD
                $psw = md5($psw);
                
                //REGISTA NA BD AS INFORMAÇÕES DO UTILIZADOR
                $param = [
                    ":cod_user" => $newCodUser,
                    ":username" => $username,
                    ":nome" => $nome,
                    ":nif" => $nif,
                    ":email" => $email,
                    ":psw" => $psw,
                    ":genero" => $genero,
                    ":data_nascimento" => $data_nasc,
                    ":data_atual" => $dataAtual,
                    ":tipo_utilizador" => $tipoUser
                ];
                $registaUser = $gst->exe_non_query("
                INSERT INTO utilizadores (cod_utilizador,username,nome,nif,email,psw,genero,data_nascimento,data_adesao,tipo_utilizador) VALUES 
                (
                    :cod_user,
                    :username,
                    :nome,
                    :nif,
                    :email,
                    :psw,
                    :genero,
                    :data_nascimento,
                    :data_atual,
                    :tipo_utilizador
                )", $param);

                // REGISTA NA BD A MENSALIDADE ATUAL (sem mensalidade)
                $param = [
                    ":cod_utilizador" => $newCodUser
                ];
                
                //CRIAR UM SERIAL E REGISTA-O PARA POSTERIORMENTE O UTILIZADOR CONFIRMAR O EMAIL
                $dataHora = date("Y-m-d H:i:s");
                $token = md5(uniqid(rand(), true));

                $param = [
                    ":cod_utilizador" => $newCodUser,
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
                $email_msg1 = "Olá, $nome <br>Recentemente criou uma conta no GymFit. Para se tornar nosso cliente necessita de confirmar o seu email.";
                $email_msg2 = "Se não foi você que se inscreveu por favor clique <a href='".APP_URL."validar-conta/desativar/$email/$token'>aqui</a> para cancelar.";
                $email_msg3 = "Confirme a sua conta <a href='".APP_URL."validar-conta/ativar/$email/$token'>aqui</a>.";
                $email_msg4 = "<small>Esta confirmação tem um tempo limitado</small>";
                
                $txt_email = emailDefault($email_assunto, $email_msg1, $email_msg2, $email_msg3, $email_msg4);

                $enviaEmail = enviaEmail($email, $nome, $email_assunto, $txt_email, "", "");
                if($enviaEmail == true)
                {
                    if($registaUser && $registaToken)
                    {
                        $msg .= MSGsuccess("Sucesso", "A sua conta foi criada com sucesso", "");
                        $_SESSION["mensagem"] = $msg;
                        header("Location: " . APP_URL);
                        exit;
                    }
                    else
                    {
                        $msg .= MSGdanger("Ocorreu um erro", "Ups...Parece que ocorreu um erro ao criar a sua conta. Tente novamente mais tarde, se o erro persistir contacte um oficial", "");
                        $_SESSION["mensagem"] = $msg;
                        
                        $param = [":codU", $newCodUser];
                        $gst->exe_non_query("DELETE FROM utilizadores_confirmacao WHERE cod_user = :codU", $param);
                        $gst->exe_non_query("DELETE FROM utilizadores WHERE cod_utilizador = :codU", $param);
                    
                        header("Location: " . APP_URL . "criar-registo");
                        exit;
                    }
                }
                else
                {
                    $msg .= MSGdanger("Ocorreu um erro", "Ups...Parece que ocorreu um erro ao enviar um email de confirmação, não foi registado", "");
                    $_SESSION["mensagem"] = $msg;

                    $param = [":codU", $newCodUser];
                    $gst->exe_non_query("DELETE FROM utilizadores_confirmacao WHERE cod_user = :codU", $param);
                    $gst->exe_non_query("DELETE FROM utilizadores WHERE cod_utilizador = :codU", $param);

                    header("Location: " . APP_URL . "criar-registo");
                    exit;
                }
            } 
        }
    } else $genero = $nome = $nif = $username = $email = $data_nasc = "";
?>

<!DOCTYPE html>
<!--
Todos os direitos reservados de DKSoft
-->
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
        <title>Registo - <?= APP_NAME ?></title>
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
            
            <form id="frm-novo-cliente" class="form-registo" name="registo" method="post" action="criar-registo" enctype="multipart/form-data">
                <div class="form-registo-ld-left" style="width: 100%; border: none;">
                    <!-- Falta a validação dos campos em HTML -->
                    <h3>Registo</h3>
                    <br>
                    <div>
                        <select name="gen" required>
                            <?php 
                                if($genero != "")
                                {
                                    if($genero == "m")
                                    {
                                        echo '<option value="m" selected>Sr.</option>';
                                        echo '<option value="f">Sra.</option>';
                                    }
                                    if($genero == "f")
                                    {
                                        echo '<option value="m">Sr.</option>';
                                        echo '<option value="f" selected>Sra.</option>';
                                    }
                                }
                                else
                                {
                                    echo '<option value="m">Sr.</option>';
                                    echo '<option value="f">Sra.</option>';
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
                        <input name="username" id="username" type="text" pattern=".{4,30}" title="O username deve ter entre 3 a 30 caracteres" placeholder="Nome de utilizador" value="<?= $username ?>" required>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <div>
                        <label for="email">Email <span>*</span></label>
                        <br>
                        <input name="email" id="email" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="O email introduzido não é válido" placeholder="Email" value="<?= $email ?>" required>
                    </div>
                    <br>

                    <div>
                        <label for="psw">Password <span>*</span></label>
                        <br>
                        <input name="psw" type="password" id="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="A password deve conter no mínimo 6 caracteres, incluindo maiúsculas, minúsculas e números" required>
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
                        <input name="data_nasc" id="data_nasc" type="date" value="<?= $data_nasc ?>"  required>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>
                <p id = "txt_geral"></p>
                <input type="hidden" name="acao" value="registar">
                <input class="from-registo-btn-submit" id="btn_submit" type="submit" value="Registar">
            </form>

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