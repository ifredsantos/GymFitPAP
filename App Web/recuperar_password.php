<?php
    require 'config.php';

    $msg = "";

    $acao="";

    if(isset($_POST['acao']) && $_POST['acao'] == "alterar_password") {
        if(isset($_SESSION['utilizador_altera_psw']) && !empty($_SESSION['utilizador_altera_psw'])) {
            $utilizador = $_SESSION['utilizador_altera_psw'];
            $cod_confirmacao = $_POST['c_k'];
            $psw = md5($_POST['newpsw']);

            $param = [
                ":psw" => $psw,
                ":cod_utilizador" => $utilizador
            ];
            $atualizaPassw = $gst->exe_non_query("
            UPDATE utilizadores SET psw = :psw WHERE cod_utilizador = :cod_utilizador", $param);

            if($atualizaPassw) {
                $email_assunto = "Password alterada";
                $email_msg1 = "Olá $nome, <br>Recentemente foi feito um pedido de alteração de senha.";
                $email_msg2 = 'Se o pedido foi da sua autoria clique no link seguinte:
                <p><a href="'.APP_URL.'recuperar_password.php?acao=alterar&email='.$email.'&token='.$token.'">'.APP_URL.'recuperar_password.php?acao=mudar&email='.$email.'&token='.$token.'</a></p>';
                $email_msg3 = "Caso não seja da sua autoria também é recomendado alterar a sua password.";
                $email_msg4 = "";
                        
                $txt_email = emailDefault($email_assunto, $email_msg1, $email_msg2, $email_msg3, $email_msg4);

                if($enviaEmail = enviaEmail($email, $nome, $email_assunto, $txt_email, "", "")) {

                }

                $param = [":codCf" => $cod_confirmacao];
                $apagarConfirmacao = $gst->exe_non_query("
                DELETE FROM utilizadores_confirmacao WHERE cod_confirmacao = :codCf", $param);

                $param = [":cod_utilizador" => $utilizador];
                $apagarRegTentativasLogin = $gst->exe_non_query("
                DELETE FROM utilizadores_login_tentativas WHERE utilizador = :cod_utilizador", $param);

                header('Location: '.APP_URL.'home/msg/password-alterada');
            }
            else
                header('Location: '.APP_URL.'home/msg/password-nao-alterada');
        }
    }

    if(isset($_POST['acao']) && $_POST['acao'] == "email_recuperacao" && !empty($_POST['email'])) {
        $email = $_POST['email'];

        $param = [
            ":email" => $email
        ];
        $buscaDadosUtilizador = $gst->exe_query("
        SELECT cod_utilizador, username FROM utilizadores WHERE email = :email", $param);
        if(count($buscaDadosUtilizador) > 0) {
            $cod_utilizador = $buscaDadosUtilizador[0]["cod_utilizador"];
            $nome = $buscaDadosUtilizador[0]["username"];
            $token = strtoupper(md5(time()));

            $email_assunto = "Pedidio de alteração de senha";
            $email_msg1 = "Olá $nome, <br>Recentemente foi feito um pedido de alteração de senha.";
            $email_msg2 = 'Se o pedido foi da sua autoria clique no link seguinte:
            <p><a href="'.APP_URL.'recuperar_password.php?acao=alterar&email='.$email.'&token='.$token.'">'.APP_URL.'recuperar_password.php?acao=mudar&email='.$email.'&token='.$token.'</a></p>';
            $email_msg3 = "Caso não seja da sua autoria também é recomendado alterar a sua password.";
            $email_msg4 = "";
                    
            $txt_email = emailDefault($email_assunto, $email_msg1, $email_msg2, $email_msg3, $email_msg4);

            if($enviaEmail = enviaEmail($email, $nome, $email_assunto, $txt_email, "", "")) {
                $param = [
                    ":utilizador" => $cod_utilizador,
                    ":token" => $token
                ];
                $registaToken = $gst->exe_non_query("
                INSERT INTO utilizadores_confirmacao (cod_user, chave_confirmacao, date_pedido) VALUES
                (
                    :utilizador,
                    :token,
                    NOW()
                )", $param);

                if($registaToken)
                    header('Location: '.APP_URL.'home/msg/token-recuperacao-senha-sucesso');
                else
                    header('Location: '.APP_URL.'home/msg/token-recuperacao-senha-erro');
            } else
                header('Location: '.APP_URL.'home/msg/email-recuperacao-senha-erro');
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
        <link rel="shortcut icon" href="<?= APP_URL ?>layout/altere.png" type="image/x-icon">
        <link rel = "stylesheet" type = "text/css" href = "<?= APP_URL ?>layout/css/design.css">
    </head>
    
    <body onselectstart="return false" data-spy="scroll" data-target="#myScrollspy" data-offset="50">
        <header id = "#myScrollspy">
            <?php include 'parts/header.php';?>
        </header>
        
        <article style="padding-top: 50px;">
            <br>
            <?php
                if(isset($_GET['acao'], $_GET['email'], $_GET['token']) && !empty($_GET['token']) && 
                !empty($_GET['email']) && $_GET['acao'] == "alterar" && !isset($_POST['acao'])) {
                    // Verifica token
                    $param = [
                        ":email" => $_GET['email'],
                        ":token" => $_GET['token']
                    ];
                    $verificaToken = $gst->exe_query("
                    SELECT cod_confirmacao, cod_utilizador, date_pedido FROM utilizadores_confirmacao 
                        INNER JOIN utilizadores ON utilizadores_confirmacao.cod_user = utilizadores.cod_utilizador 
                    WHERE email = :email AND chave_confirmacao = :token", $param);

                    if(count($verificaToken) > 0) {
                        $_SESSION['utilizador_altera_psw'] = $verificaToken[0]["cod_utilizador"];
            ?>
            <h3 class="text_center">Alterar password</h3>
            <br>

            <form class="form-registo" action="<?= APP_URL ?>recuperar_password" method="post">
                <div class="form-registo-ld-left" style="width: 100%; border: none;">
                    <div>
                        <label for="newpsw">Nova password <span>*</span></label>
                        <br>
                        <input 
                               name="newpsw"
                               id="newpsw"
                               type="password"
                               placeholder="Insira a sua nova password" 
                               required>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>
                <input type="hidden" name="acao" value="alterar_password">
                <input type="hidden" name="c_k" value="<?= $verificaToken[0]["cod_confirmacao"] ?>">
                <input class="from-registo-btn-submit" style="width: 250px !important;" type="submit" value="Alterar password">
            </form>
            <?php
                    } else echo '<p class="text_center">Algo está errado. Clique <a href="'.APP_URL.'recuperar_password">aqui</a> para repor novamente a sua password.</p>';
                }

                if(!isset($_GET['acao']) && !isset($_POST['acao'])) {
            ?>

            <h3 class="text_center">Recuperar password</h3>
            <br>

            <form class="form-registo" method="post" action="<?= APP_URL ?>recuperar_password">
                <div class="form-registo-ld-left" style="width: 100%; border: none;">
                    <div>
                        <label for="email">Email <span>*</span></label>
                        <br>
                        <input 
                               name="email"
                               id="email"
                               type="email"
                               placeholder="Insira o email associado à sua conta" 
                               required>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>
                <input type="hidden" name="acao" value="email_recuperacao">
                <input class="from-registo-btn-submit" style="width: 250px !important;" type="submit" value="Enviar email de recuperação">
            </form>
            <?php
                }
                
                if($msg != "") {
            ?>
            <div class="msg-space-modal" id="msg-space-modal">
                <div class="msg-content-modal">
                    <?= $msg; ?>
                </div>
            </div>
            <?php
            }
            ?>
        </article>
        
        <div style="position: fixed; bottom: 0; left: 0; width: 100%;">
        <div class = "gradCinBlack"></div>
        <footer>
            <?php include("parts/footer.php"); ?>
        </footer>
        </div>
        
        <script src="js/main.js"></script>
    </body>
</html>            