<?php
    /* 
    * Este ficheiro deve ser lido automáticamente todos os dias por cron jobs
    * Irá verificar as datas de nascimento dos utilizadores e verificar se hoje é o seu aniversário ou não
    * Se encontrar algum aniversariante devera enviar-lhe um email de parabéns
    */

    include("../config.php");
    
    $dataAtual = date("m-d");
    $enviados = 0;
    
    $dataCompletaAtual = date("Y-m-d H:i:s");

    $buscaTexto = $gst->exe_query("SELECT textoPT FROM textos WHERE titloPT = 'Parabéns'");
    if(count($buscaTexto) > 0)
        $mensagemPersonalizada = $buscaTexto[0]["textoPT"];
    else $mensagemPersonalizada = "";
    
    $buscaUsers = $gst->exe_query("
    SELECT cod_utilizador, nome, email, genero, data_nascimento FROM utilizadores");
    if(count($buscaUsers) > 0) {
        for($i=0; $i < count($buscaUsers); $i++) {
            $infUser = $buscaUsers[$i];
            $dataNascimento = $infUser['data_nascimento'];
            
            list($ano, $mes, $dia) = explode('-', $dataNascimento);
            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
            
            $mesDia = $mes."-".$dia;
            
            if($dataAtual == $mesDia) {
                $idade = floor((((($hoje-$nascimento)/60)/60)/24)/365.25) + 1;
                $nomeCompleto = $infUser['nome'];
                $email = $infUser['email'];
                
                $email_assunto = "Parabêns!";
                $email_msg1 = "Parabêns pelos seus $idade anos, $nomeCompleto";
                $email_msg2 = $mensagemPersonalizada;
                $email_msg3 = "";
                $email_msg4 = "";
                
                $txt_email = emailDefault($email_assunto, $email_msg1, $email_msg2, $email_msg3, $email_msg4);
                
                if(enviaEmail($email, $infUser['nome'], $email_assunto, $txt_email, "", "")) {
                    $enviados ++;
                    echo "<p>".$dataCompletaAtual." | ".$nomeCompleto." » Parabêns pelos seus ".$idade." anos!</p>";
                }
                
                if($enviados >= 25) {
                    sleep(60);
                    $enviados = 0;
                }
            }
        }
    } else {
        echo "Sem utilizadores";
    }
?>