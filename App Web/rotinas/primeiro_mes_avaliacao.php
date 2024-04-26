<?php
    /* 
    * Este ficheiro deve ser lido automáticamente todos os dias por cron jobs
    * Irá verificar os utilizadores que façam 1 mês de inscrição no ginâsio
    * Se encontrar algum cliente com esta condição deverá enviar um email para uma ligação a avaliação do establecimento.
    */

    include("../config.php");
    
    $anoAtual = date("Y");
    $mesAtual = date("m");
    $diaAtual = date("d");
    $enviados = 0;
    
    $dataCompletaAtual = date("Y-m-d H:i:s");
    
    $buscaTexto = $gst->exe_query("SELECT textoPT FROM textos WHERE titloPT = 'Avaliação 1 mês'");
    if(count($buscaTexto) > 0)
        $mensagemPersonalizada = $buscaTexto[0]["textoPT"];
    else $mensagemPersonalizada = "";

    $buscaUsers = $gst->exe_query("SELECT cod_utilizador, nome, email, genero, data_adesao FROM utilizadores");
    if(count($buscaUsers) > 0) {
        for($i=0; $i < count($buscaUsers); $i++) {
            $infUser = $buscaUsers[$i];
            $dataAdesao = $infUser['data_adesao'];
            
            list($ano, $mes, $dia) = explode('-', $dataAdesao);
            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $adesao = mktime( 0, 0, 0, $mes, $dia, $ano);
            
            if($ano == $anoAtual) {
                if($mesAtual > $mes) {
                    $mesesPassados = $mesAtual - $mes;
                    if($mesesPassados == 1) {
                        $nomeCompleto = $infUser['nome'];
                        $email = $infUser['email']; 
                        echo "<p>".$dataCompletaAtual." | ".$nomeCompleto." » aderio à $mesesPassados mês » Avalie-nos!</p>";

                        $email_assunto = "Gostaríamos de obter a sua opinião";
                        $email_msg1 = "Como o tempo passa rápido! Já faz um mês que se juntou a nós.";
                        $email_msg2 = $mensagemPersonalizada;
                        $email_msg3 = "Avalie-nos <a href='https://www.google.pt/search?authuser=1&source=hp&ei=2HjxW6eGJPLOrgSN3YSwCw&q=gymfit&btnK=Pesquisa+Google&oq=gymfit&gs_l=psy-ab.3..0l2j0i10j0l2j0i10j0l2.2803.4561..4811...0.0..0.103.576.7j1......0....1..gws-wiz.....0..0i131.A66DRqLTpOM#btnK=Pesquisa%20Google&lrd=0xd22589c1063c277:0x21ddad272e4fac02,3,,,'>aqui</a>";
                        $email_msg4 = "Obrigado por nos avaliar! Acredite é realmente muito importante para nós :) ";

                        $txt_email = emailDefault($email_assunto, $email_msg1, $email_msg2, $email_msg3, $email_msg4);

                        if(enviaEmail($email, $infUser['nome'], $email_assunto, $txt_email, "", "")) {
                            $enviados ++;
                        }

                        if($enviados >= 25) {
                            sleep(60);
                            $enviados = 0;
                        }
                    }
                }
            }
        }
    } else {
        echo "Sem utilizadores";
    }
?>