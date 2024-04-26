<?php
    require "config.php";  

    $msg = "";

    if(isset($_SESSION['cod_user']) && !empty($_SESSION['cod_user']))
        header('Location: '.APP_URL.'perfil');

    if(isset($_POST['identificador'], $_POST['psw'], $_POST['acao']) && $_POST['acao'] == "Entrar") {
        $dataAtual = date('Y-m-d H:i:s');
        
        $erros = 0;
        $identificador = $_POST['identificador'];
        $psw = md5($_POST['psw']);

        if($identificador == "" || $psw == "") {
            $erros = 1;
        }

        if($erros == 0) {
            $param = [
                ":username" => $identificador,
                ":email" => $identificador
            ];
    
            $verfExisteutilizador = $gst->exe_query("SELECT username, email, psw FROM utilizadores WHERE username = :username OR email = :email", $param);
            if(count($verfExisteutilizador) > 0) {
                $param = [
                    ":username" => $identificador,
                    ":psw" => $psw,
                    ":email" => $identificador
                ];
        
                $verificaUtilizador = $gst->exe_query("SELECT cod_utilizador, username, email, psw, tipo_utilizador 
                FROM utilizadores WHERE username = :username AND psw = :psw OR email = :email AND psw = :psw", $param);
                if(count($verificaUtilizador) > 0) {
                    //VERIFICA SE A CONTA ESTÁ DESATIVADA
                    if($verificaUtilizador[0]['tipo_utilizador'] == 4) {
                        $msg .= "A sua conta não está ativa. Confirme o seu email.";
                    }
                    else {
                        //COLOCA EM SESSÃO
                        $_SESSION['cod_user'] = $verificaUtilizador[0]['cod_utilizador'];
                        $_SESSION['role'] = $verificaUtilizador[0]['tipo_utilizador'];

                        //Atualiza ultima data de acesso e ip
                        $ip = get_client_ip();

                        $param = [
                            ":data_ultimo_acesso" => $dataAtual,
                            ":ip_ultimo_acesso" => $ip,
                            ":cod_user" => $verificaUtilizador[0]['cod_utilizador']
                        ];
                        $updateLastAcss = $gst->exe_non_query("
                        UPDATE utilizadores 
                        SET data_ultimoAcesso = :data_ultimo_acesso, ip_ultimoAcesso = :ip_ultimo_acesso 
                        WHERE cod_utilizador = :cod_user", $param);

                        include 'parts/inc_verifica_utilizadores_online.php';

                        if($verificaUtilizador[0]['tipo_utilizador'] == 1 || $verificaUtilizador[0]['tipo_utilizador'] == 2) {
                            $_SESSION['auth'] = 1;
                        } else {
                            $_SESSION['auth'] = 0;
                        }
                        
                        header('location: '.APP_URL.'perfil');
                    }
                }
                else {
                    $msg .= "Dados de login incorretos. Tente novamente.";
                }
            }
            else {
                $msg .= "Não existe uma conta com os dados introduzidos.";
            }
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
        <meta name="author" content="<?= PROGRAMER_NAME ?>, <?= PROGRAMER_EMAIL ?>">
        <meta name="reply-to" content="<?= PROGRAMER_EMAIL ?>">
        <meta http-equiv="cache-control" content="private">
        <meta name="rating" content="general">
        <title>Login - <?= APP_NAME ?></title>
        <link rel="icon" href="<?= APP_URL ?>layout/altere.png" type="image/x-icon">
        <link rel="shortcut icon" href="<?= APP_URL ?>layout/altere.png" type="image/x-icon">
        <link rel = "stylesheet" type = "text/css" href = "<?= APP_URL ?>layout/css/design.css">

        <style>
            @font-face {
                font-family: 'Jura';
                src: url("fonts/Jura-Regular.ttf");
            }

            * {
                font-family: 'Jura';
            }

            .frm_login_mobile {
                width: calc(100% - 30px);
                position: absolute;
                bottom: 0;
                height: 100vh;
                left: 15px;
                margin: auto;
            }

            .frm_login_mobile label {
                color: #bababa;
                width: 100%;
                float: left;
            }

            .frm_login_mobile input {
                margin-top: 5px;
                margin-bottom: 10px;
                padding: 8px 5px 10px 5px;
                font-size: 16px;
                width: calc(100% - 14px);
                background-color: black;
                border: 2px solid #262626;
                color: #efefef;
                border-radius: 5px;
            }

            .frm_login_mobile input[type=submit] {
                margin-bottom: 0;
                padding: 12px 5px 12px 5px;
                font-size: 16px;
                width: 100%;
                background-color: #262626;
                color: #bababa;
                position: absolute;
                bottom: 15px;
                border-radius: 5px;
            }
        </style>
    </head>
    
    <body style="background-color: black;" onselectstart="return false" data-spy="scroll" data-target="#myScrollspy" data-offset="50">
        <div style="background-color: #0f0f0f; border-bottom: 1px solid #161616; width: 100%; height: 60px;">
            <a href="<?= APP_URL ?>login_registo_mobile.php"><img style="position: absolute; z-index: 99; top: 15px; left: 15px; cursor: pointer;" src="<?= APP_URL ?>layout/left-arrow-white.png" alt="Voltar atrás" title="Voltar atrás"></a>
            <img src="<?= APP_URL ?>layout/logoFinal.png" style="width: 200px; position: absolute; right: 15px; top: 7px">
        </div>
        <form class="frm_login_mobile" action="<?= APP_URL ?>login_mobile.php" method="post">
            <h3 style="text-align: center; margin-top: 90px;">Bem-vindo</h3>
            <hr style="border: 1px solid #262626; width: 50%; margin-top: 15px;">

            <?php
                if($msg != "")
                    echo '<p style="color: red; text-align: center; margin-top: 20px;">'.$msg.'</p>';
            ?>
            <br>

            <label for="email">E-mail / Username:</label>
            <input type="text" name="identificador" id="identificador">
            <br>

            <label for="psw">Senha:</label>
            <input type="password" name="psw" id="psw">

            <p><a href="<?= APP_URL ?>recuperar_password">Esqueceu sua senha?</a></p>

            <input type="submit" name="acao" value="Entrar">
        </form>
    </body>
</html>