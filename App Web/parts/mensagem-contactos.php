<?php
    require '../config.php';

    if(isset($_POST['acao']) && $_POST['acao'] == "enviar-msg-contactos")
    {
        $erros = 0;
        
        $nome = $_POST['nome'];
        if(strlen($nome) > 100)
        {
            $msg .= MSGdanger("Ocorreu um erro", "O campo nome não pode conter mais que 100 caracteres", "");
            $erros = 1;
        }
        
        $email = $_POST['email'];
        if(strlen($email) > 100)
        {
            $msg .= MSGdanger("Ocorreu um erro", "O campo email não pode conter mais que 100 caracteres", "");
            $erros = 1;
        }
        
        $mensagem = $_POST['mensagem'];
        if(strlen($mensagem) > 500)
        {
            $msg .= MSGdanger("Ocorreu um erro", "A mensagem não pode conter mais que 500 caracteres", "");
            $erros = 1;
        }
        $mensagem_apresentacao = str_replace("\n", "<br>", $mensagem);
        
        if($erros == 0)
        {
            $param = [
                ":nome_cliente" => $nome,
                ":email_cliente" => $email,
                ":mensagem" => $mensagem_apresentacao
            ];

            $registaMensagem = $gst->exe_non_query("INSERT INTO mensagens (nome_cliente, email_cliente, mensagem, data_envio, vista, respondida) 
            VALUES (:nome_cliente, :email_cliente, :mensagem, NOW(), 'n', 'n')", $param);

            $dataAtual = date('Y-m-d H:i:s');
            
            $email_assunto_to_owner = "Mensagem de $nome";
            $email_msg1_to_owner = "Os seus clientes estão a enviar mensagens!";
            $email_msg2_to_owner = "Nome: $nome";
            $email_msg3_to_owner = "Email: $email";
            $email_msg4_to_owner = "Mensagem:<br><i>\"$mensagem_apresentacao\"</i>";
                
            $txt_email = emailDefault($email_assunto_to_owner, $email_msg1_to_owner, $email_msg2_to_owner, $email_msg3_to_owner, $email_msg4_to_owner);

            if(enviaEmailToOwner($email, $nome, $email_assunto_to_owner, $txt_email))
                header('location: '.APP_URL.'home/msg/mensagem-enviada-com-sucesso');
            else header('location: '.APP_URL.'home/msg/mensagem-nao-enviada');
        }
    }
?>