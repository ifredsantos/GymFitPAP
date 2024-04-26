<?php
    //validar-conta.php?acao=$1&email=$2&token=$3
    require "../config.php";

    if(isset($_GET['acao']) && $_GET['acao'] == "ativar" && isset($_GET['email'], $_GET['token']) && $_GET['email'] != "" && $_GET['token'] != "") {
        $email = $_GET['email'];
        $token = $_GET['token'];

        $param = [
            ":email" => $email
        ];
        $verificaContaAtivada = $gst->exe_query("
        SELECT U.cod_utilizador, U.email, U.tipo_utilizador 
        FROM utilizadores U 
        WHERE U.email = :email AND U.tipo_utilizador <> 4", $param);
        if(count($verificaContaAtivada) > 0) {
            header('location: '.APP_URL."home/msg/conta-ja-ativada");
        }
        else {
            $param = [
                ":email" => $email,
                ":token" => $token
            ];
            $verificaToken = $gst->exe_query("
            SELECT UC.cod_user, U.nome, UC.chave_confirmacao, UC.date_pedido, U.email 
                FROM utilizadores_confirmacao UC  
                    INNER JOIN utilizadores U ON UC.cod_user = U.cod_utilizador 
                WHERE U.email = :email AND UC.chave_confirmacao = :token", $param);
            //SE HOUVER UMA CORRESPONDÊNCIA
            if(count($verificaToken) > 0) {
                $nome = $verificaToken[0]['nome'];
                $codUser = $verificaToken[0]['cod_user'];

                $param = [
                    ":email" => $verificaToken[0]['email']
                ];
                $atualizaTipoUser = $gst->exe_non_query("
                UPDATE utilizadores 
                SET tipo_utilizador = 3 
                WHERE email = :email", $param);

                if($atualizaTipoUser) {
                    $param = [
                        ":token" => $token
                    ];
                    $removeConfirmacao = $gst->exe_non_query("
                    DELETE FROM utilizadores_confirmacao WHERE chave_confirmacao = :token", $param);

                    $param = [
                        ":cod_utilizador" => $codUser
                    ];
                    $adicionaConquista = $gst->exe_non_query("
                    INSERT INTO utilizadores_conquistas (
                        cod_utilizador,
                        cod_conquista,
                        data_conquista
                    ) VALUES (
                        :cod_utilizador,
                        1,
                        NOW()
                    )", $param);

                    $email_assunto = "$nome, a sua conta está pronta a usar!";
                    $email_msg1 = "Desde já seja muito bem vindo ao ".APP_NAME."!";
                    $email_msg2 = "A sua conta foi confirmada com sucesso e está pronta a ser usada. "
                           . "Na área de cliente pode completar o seu perfil como por exemplo escolher uma foto de perfil,"
                           . "escolher a sua mensalidade, bem como completar outras informações pessoais como seus objetivos, peso, altura, etc...";
                    $email_msg3 = "Pode ainda pedir um treinador para que este crie planos de treino, aulas e até de alimentação consoantes os seus objetivos.";
                    $email_msg4 = "Obrigado por se juntar a nós!";

                    $txt_email = emailDefault("$email_assunto", "$email_msg1", "$email_msg2", "$email_msg3", "$email_msg4");

                    enviaEmail($email, $p_nome, $email_assunto, $txt_email, "", "");
                    header('location: '.APP_URL."home/msg/conta-ativada");
                }
                else
                {
                    header('location: '.APP_URL."home/msg/conta-erro-ativacao"); 
                }
            }
        }
    }
    
    if(isset($_GET['acao']) && $_GET['acao'] == "desativar" && isset($_GET['email']) && $_GET['email'] != "" && isset($_GET['token']) && $_GET['token'] != "") {
        $email = $_GET['email'];
        $token = $_GET['token'];

        $param = [
            ":email" => $email,
            ":token" => $token
        ];
        $verificaToken = $gst->exe_query("
        SELECT UC.cod_user, UC.chave_confirmacao, UC.date_pedido, U.email 
            FROM utilizadores_confirmacao UC, utilizadores U 
            WHERE UC.cod_user = U.cod_utilizador AND U.email = :email AND UC.chave_confirmacao = :token", $param);

        //SE HOUVER UMA CORRESPONDÊNCIA
        if(count($verificaToken) > 0) {
            $infUser = mysqli_fetch_assoc($verificaToken);

            $param = [
                ":cod_utilizador" => $verificaToken[0]['cod_user'],
                ":token" => $token
            ];
            $removeConfirmacao = $gst->exe_query("
            DELETE FROM utilizadores_confirmacao WHERE cod_user = :cod_utilizador AND chave_confirmacao = :token", $param);
        }
        
        header('location: '.APP_URL);
    }
?>