<?php
    require "../config.php";

    if(isset($_POST['email']) && isset($_POST['psw']) && isset($_POST['back'])) {
        $dataAtual = date('Y-m-d H:i:s');

        $erros = 0;
        $email = $_POST['email'];
        $psw = md5($_POST['psw']);
        $back = $_POST['back'];

        if($email == "" || $psw == "") {
            $erros = 1;
        }

        if($erros == 0) {
            $param = [
                ":username" => $email,
                ":email" => $email
            ];
    
            $verfExisteutilizador = $gst->exe_query("
            SELECT cod_utilizador, username, email, psw FROM utilizadores WHERE username = :username OR email = :email", $param);
            if(count($verfExisteutilizador) > 0) {
                $existeUtilizadorCod = $verfExisteutilizador[0]["cod_utilizador"];
                $email = $verfExisteutilizador[0]["email"];
                $username= $verfExisteutilizador[0]["username"];

                $dataHoraAtual = date("Y-m-d h:i:s");
                $dataMinima = new DateTime($dataHoraAtual);
                $dataMinima->sub(new DateInterval('PT'.MAX_LOGIN_TEMPO.'H'));
                $dataMinima = $dataMinima->format("Y-m-d h:i:s");


                $param = [
                    ":cod_utilizador" => $existeUtilizadorCod,
                    ":tempo_anterior" => '0 '.MAX_LOGIN_TEMPO.':0:0'
                ];
                $verificaTentativasLogin = $gst->exe_query("
                SELECT data_log FROM utilizadores_login_tentativas 
                WHERE utilizador = :cod_utilizador AND data_log > DATE_SUB(NOW(), INTERVAL :tempo_anterior DAY_SECOND)", $param);
                $numTentativasLogin = count($verificaTentativasLogin);

                if($numTentativasLogin >= MAX_LOGIN_TENTATIVAS) {
                    if(!isset($_SESSION['email_block'])) {
                        $token = strtoupper(md5(time()));
                        
                        $email_assunto = "Conta GymFit bloqueada!";
                        $email_msg1 = 'Olá,'.$username.' <br>
                        Recentemente alguém excedeu o limite de tentativas de login.';
                        $email_msg2 = 'Altere a sua password aqui:
                        <p><a href="'.APP_URL.'recuperar_password.php?acao=alterar&email='.$email.'&token='.$token.'">'.APP_URL.'recuperar_password.php?acao=mudar&email='.$email.'&token='.$token.'</a></p>';
                        $email_msg3 = 'Se não foi você aconcelhamos vivamente que também <a href="'.APP_URL.'recuperar_password">altere a sua password</a>';
                        $email_msg4 = "<small>Recomendação: Utilize sempre uma password segura.</small>";
                    
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
                            
                            $_SESSION['email_block'] = true;
                        }
                    }

                    header('location: '.APP_URL.'home/msg/excedida-tentativa-de-acesso');
                } else {
                    $param = [
                        ":username" => $email,
                        ":psw" => $psw,
                        ":email" => $email
                    ];
                    $verificaUtilizador = $gst->exe_query("
                    SELECT cod_utilizador, username, email, tipo_utilizador 
                    FROM utilizadores WHERE username = :username AND psw = :psw OR email = :email AND psw = :psw", $param);
                    if(count($verificaUtilizador) > 0) {
                        //VERIFICA SE A CONTA ESTÁ DESATIVADA
                        $param = [":cod_utilizador" => $verificaUtilizador[0]["cod_utilizador"]];
                        $apagarRegTentativasLogin = $gst->exe_non_query("
                        DELETE FROM utilizadores_login_tentativas WHERE utilizador = :cod_utilizador", $param);
                        if($verificaUtilizador[0]['tipo_utilizador'] == 4) {
                            header('location: '.APP_URL.'home/msg/conta-nao-ativada');
                        } else {
                            //COLOCA EM SESSÃO
                            $_SESSION['cod_user'] = $verificaUtilizador[0]['cod_utilizador'];
                            $_SESSION['role'] = $verificaUtilizador[0]['tipo_utilizador'];

                            $param = [
                                ":cod_utilizador" => $_SESSION['cod_user']
                            ];
                            $limpaTentativasLogin = $gst->exe_non_query("
                            DELETE FROM utilizadores_login_tentativas WHERE utilizador = :cod_utilizador", $param);

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

                            include 'inc_verifica_utilizadores_online.php';

                            if($verificaUtilizador[0]['tipo_utilizador'] == 1 || $verificaUtilizador[0]['tipo_utilizador'] == 2) {
                                $_SESSION['auth'] = 1;
                            }
                            else {
                                $_SESSION['auth'] = 0;
                            }

                            if($_SESSION['role'] == 1) {
                                header('location: '.APP_URL.'office/dashboard');
                            } else {
                                header('location: '.APP_URL.'perfil');
                            }
                        }
                    }
                    else {
                        $param = [
                            ":utilizador" => $existeUtilizadorCod
                        ];
                        $registaErroLog = $gst->exe_non_query("
                        INSERT INTO utilizadores_login_tentativas (utilizador, data_log) VALUES
                        (
                            :utilizador,
                            NOW()
                        )", $param);

                        header('location: '.APP_URL.'home/msg/dados-login-incorretos');
                    }
                }
            }
            else
            {
                header('location: '.APP_URL.'home/msg/conta-nao-existe');
            }
        }
    }
?>