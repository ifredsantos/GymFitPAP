<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    // ==================================================
    // Função para bloquear SQLInjections [depreciated]
    // ==================================================
    function sqlinjectionfilter($var) {  
        $banlist = array("insert", "select", "update", "delete", "distinct", "having", "truncate", "replace", 
        "handler", "like", " as ", "or ", "procedure", "limit", "order by", "group by", "asc", "desc","'", 
        "union all", "INSERT", "SELECT", "UPDATE", "DELETE", "DISTINCT", "HAVING", "TRUNCATE", "REPLACE", 
        "HANDLE", "LIKE", " AS ", "OR", "PROCEDURE", "LIMIT", "ORDER BY", "GROUP BY", "ASC", "DESC", "UNION ALL");
        $texto = trim(str_replace($banlist,'', $var));
        return $texto;  
    }

    // ==================================================
    // Função para iníciar sessão de forma segura
    // ==================================================
    function sec_session_start() {
        $session_name = 'sec_session_id';
        $secure = false;
        $httponly = true;
        // ==================================================
        ini_set('session.use_only_cookies', 1); 
        $cookieParams = session_get_cookie_params();
        session_cache_expire(30);
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name);
        session_start();
        session_regenerate_id(true);
    }

    // ==================================================
    // Função para formatar o preço
    // ==================================================
    function preco($preco) {
        return "&euro;".str_replace(".",",",number_format(round($preco,2),2));
    }

    // ==================================================
    // Função para converter a data para o formato usado em Portugal
    // ==================================================
    function ptdate($date) {
        return date("d/m/Y",strtotime($date));
    }

    // ==================================================
    // Função para converter a data e hora para o formato usado em Portugal
    // ==================================================
    function ptdatetime($date) {
        return date("d/m/Y H:i",strtotime($date));
    }

    // ==================================================
    // Função para converter a hora para o formato usado em Portugal
    // ==================================================
    function pttime($hora) {
        return date("H:i",strtotime($hora));
    }

    // ==================================================
    // Tempo de carregamento da página
    // ==================================================
    $theTime = array_sum(str_split(microtime()));
    echo "<!-- Tempo: ".$theTime." ms -->";

    // ==================================================
    // Função que adquire o IP do cliente
    // ==================================================
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else $ipaddress = 'UNKNOWN';
        
        return $ipaddress;
    }

    // ==================================================
    // Função que verifica se o dispositivo é mobile
    // ==================================================
    function verificaMobile() {
        $mobile = FALSE;
        $user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric");
  
        foreach($user_agents as $user_agent) {
            if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
                $mobile = TRUE;
            } else {
                $mobile = FALSE;
            }
        }
    }

    // ==================================================
    // Funções de mensagens
    // ==================================================
    function MSGsuccess($title, $mensagem, $link)
    {
        if($link != "")
        {
            $texto = "<div class=\"alert alert-success\" role=\"alert\">
                          <strong>$title!</strong> $mensagem <a href=\"$link\" target=\"_blank\" class=\"alert-link\">aqui</a>.
                          <strong class=\"btn-X-close\" onclick=\"document.getElementById('msg-space-modal').style.display = 'none';\">X</strong>
                    </div>";
        }
        else
        {
            $texto = "<div class=\"alert alert-success\" role=\"alert\">
                          <strong>$title!</strong> $mensagem.
                          <strong class=\"btn-X-close\" onclick=\"document.getElementById('msg-space-modal').style.display = 'none';\">X</strong>
                    </div>";
        }
        return $texto;
    }

    // ==================================================
    function MSGinfo($title, $mensagem, $link)
    {
        if($link != "")
        {
            $texto = "<div class=\"alert alert-info\" role=\"alert\">
                          <strong>$title!</strong> $mensagem <a href=\"$link\" target=\"_blank\" class=\"alert-link\">aqui</a>.
                    </div>";
        }
        else
        {
            $texto = "<div class=\"alert alert-info\" role=\"alert\">
                          <strong>$title!</strong> $mensagem.
                    </div>";
        }
        return $texto;
    }

    // ==================================================
    function MSGdanger($title, $mensagem, $link)
    {
        if($link != "")
        {
            $texto = "<div class=\"alert alert-danger\" role=\"alert\">
                          <strong>$title!</strong> $mensagem <a href=\"$link\" target=\"_blank\" class=\"alert-link\">aqui</a>.
                          <strong class=\"btn-X-close\" onclick=\"document.getElementById('msg-space-modal').style.display = 'none';\">X</strong>
                    </div>";
        }
        else
        {
            $texto = "<div class=\"alert alert-danger\" role=\"alert\">
                          <strong>$title!</strong> $mensagem.
                          <strong class=\"btn-X-close\" onclick=\"document.getElementById('msg-space-modal').style.display = 'none';\">X</strong>
                    </div>";
        }
        return $texto;
    }

    // ==================================================
    // Função que retira todos os acentos das letras
    // ==================================================
    function sanitizeString($string)
    {
        $what = array('ç','ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
    
        $by = array('c','a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','-','-','-','-','-','-','-','-','','-','','-','-','-','-','','','','','','','','' );
    
        return str_replace($what, $by, $string);
    }

    function textoFormat($texto)
    {
        $what = array(
        '[b]', '[/b]', 
        '[i]', '[/i]',
        '[del]', '[/del]',
        '[ins]', '[/ins]',
        '[sup]', '[/sup]',
        '[mark]', '[/mark]',
        '[small]', '[/small]',
        '[p]', '[/p]',
        '[url=', '[/url]', ']');
    
        $by = array(
        '<strong>', '</strong>',
        '<em>', '</em>',
        '<del>', '</del>',
        '<ins>', '</ins>',
        '<sup>', '</sup>',
        '<mark>', '</mark>',
        '<small>', '</small>',
        '<p>', '</p>',
        '<a href="', '</a>', '" target="blank">');
    
        return str_replace($what, $by, $texto);
    }

    function removerTextoFromat($texto)
    {
        $what = array(
            '<b>', '</b>', 
            '<i>', '</i>',
            '<del>', '</del>',
            '<ins>', '</ins>',
            '<sup>', '</sup>',
            '<mark>', '</mark>',
            '<small>', '</small>',
            '<p>', '</p>',
            '<br>'
        );
        
        $by = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
        
        return str_replace($what, $by, $texto);
    }

    function meses($mes) {
        $mes = abs($mes);

        if($mes == 1) {
            $mes = "Janeiro";
        } else if ($mes == 2) {
            $mes = "Fevereiro";
        } else if ($mes == 3) {
            $mes = "Março";
        } else if($mes == 4) {
            $mes = "Abril";
        } else if($mes == 5) {
            $mes = "Maio";
        } else if($mes == 6) {
            $mes = "Junho";
        } else if($mes == 7) {
            $mes = "Julho";
        } else if($mes == 8) {
            $mes = "Agosto";
        } else if($mes == 9) {
            $mes = "Setembro";
        } else if($mes == 10) {
            $mes = "Outubro";
        } else if($mes == 11) {
            $mes = "Novembro";
        } else if($mes == 12) {
            $mes = "Dezembro";
        }
        return $mes;
    }

    // ==================================================
    // Função para encortar um texto
    // ==================================================
    function encortarTexto($texto, $limite, $terminar)
    {
        return substr($texto, 0, $limite).$terminar;
    }

    // ==================================================
    // Função para um escrever um email base
    // ==================================================
    function emailDefault($assunto, $mensagem1, $mensagem2, $mensagem3, $mensagem4) {
        $email = '
        <!DOCTYPE html>
        <html lang = "pt-pt">
            <head>
                <style>
                    * {margin: 0;padding: 0;}
                    .space_EmailMsg {max-width: 650px;min-width: 290px;border: 2px solid #ECA739;border-radius: 15px;background-color: #0F0F0F;color: #efefef;font-family: Arial, sans-serif;}
                    .space_EmailText {padding: 15px;}
                    #logo {width: 240px;}
                    h1 {color: #ECA739;font-size: 20px;}
                    a {font-style: italic;color: #ECA739 !important;}
                    p {margin-bottom: 10px; color: #fffff;}
                    #footer {margin-top: 15px;}
                </style>
                <title>'.$assunto.'</title>
            </head>
            <body>
                <article>
                    <div class = "space_EmailMsg">
                        <div class = "space_EmailText">
                            <a href=""><img id="logo" src="' .APP_URL. 'layout/logoFinal.png" alt="GymFit" title="GymFit"></a>
                            <h1>'.$assunto.'</h1>
                            <br>
                            <p>'.$mensagem1.'</p>
                            <p>'.$mensagem2.'</p>
                            <p>'.$mensagem3.'</p>
                            <p>'.$mensagem4.'</p>
                            <p id="footer">Cumprimentos,
                                <br>A equipa, <a href="'.APP_URL.'"><b>'.APP_NAME.'</b></a></p>
                        </div>
                    </div>
                </article>
            </body>
        </html>
        ';
        return $email;
    }

    // ==================================================
    // Função para criar comprovativo de pagamento de mensalidade
    // ==================================================
    function criaFatura($mesPagamento, $anoPagamento, $nomeCliente, $telefone, $numFatura, $dataPagamento, 
    $valorPagar, $valorPago, $valorPorPagar, $nomeMensalidade, $precoMensalidade, $nomeDesconto, $valorDesconto, $existeSeguro) {
        require_once("vendor/autoload.php");

        $html = '
        <!DOCTYPE html>
        <html lang="pt-pt">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title></title>
            <link rel="stylesheet" type="text/css" href="layout/css/fatura.css">
            <link rel="stylesheet" type="text/css" href="layout/css/fatura_print.css" media="print">
        </head>

        <body>
        <div id="page-wrap">
            <div id="header">Comprovativo de pagamento de '.meses($mesPagamento).'/'.$anoPagamento.'</div>

            <table>
                <tr style="border: none">
                    <td style="border: none">
                        <div id="logo">
                            <img id="image" src="'. APP_URL."layout/altere.png" . '" alt="GymFit">
                        </div>
                    </td>
                    <td style="width: 220px; border: none;"></td>
                    <td style="border: none">
                        <div id="infUtilizador">
                            <p>'.$nomeCliente.'</p>
                            <br>
                            <p>Telefone: '.mascaraTelefone($telefone, 3).'</p>
                        </div>
                    </td>
                </tr>
            </table>

            <div style="clear:both"></div>
            <br>
            <div id="customer">
                <h2>Ginásio GymFit</h2>

                <table id="meta">
                    <tr>
                        <td style="width: 420px; border: none;"></td>
                        <td style="width: 140px;" class="meta-head">Comp. Nº</td>
                        <td style="width: 140px;">'.$numFatura.'</td>
                    </tr>
                    <tr>
                        <td style="width: 420px; border: none;"></td>
                        <td style="width: 140px;" class="meta-head">Data</td>
                        <td style="width: 140px;">'.ptdate($dataPagamento).'</td>
                    </tr>
                    <tr>
                        <td style="width: 420px; border: none;"></td>
                        <td style="width: 140px;" class="meta-head">Valor total</td>
                        <td style="width: 140px;"><div class="due">'.preco($valorPagar).'</div></td>
                    </tr>
                </table>
            </div>
            
            <table id="items">
                <tr>
                    <th>Item</th>
                    <th>Descrição</th>
                    <th>Preço Unitário</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                </tr>';
            
                $html .= '
                <tr class="item-row">
                    <td class="item-name">Mensalidade - '.$nomeMensalidade.'</td>
                    <td class="description"></td>
                    <td class="cost">'.preco($precoMensalidade).'</td>
                    <td class="qty">1</td>
                    <td class="price">'.preco($precoMensalidade).'</td>
                </tr>';

                if($existeSeguro == "n") {
                    $html .= '
                    <tr class="item-row">
                        <td class="item-name">Seguro</td>
                        <td class="description"></td>
                        <td class="cost">'.preco(SEGURO).'</td>
                        <td class="qty">1</td>
                        <td class="price">'.preco(SEGURO).'</td>
                    </tr>';
                    $precoSeguro = SEGURO; 
                } else {
                    $precoSeguro = 0.00;
                }

                if($valorDesconto != 0) {
                $html .= '
                <tr class="item-row">
                    <td class="item-name">Desconto - '.$nomeDesconto.'</td>
                    <td class="description"></td>
                    <td class="cost">'.preco($valorDesconto).'</td>
                    <td class="qty">1</td>
                    <td class="price">-'.preco($valorDesconto).'</td>
                </tr>';
                }

                $html .= '
                <tr>
                    <td colspan="2" class="blank"> </td>
                    <td colspan="2" class="total-line">Subtotal</td>
                    <td class="total-value"><div id="subtotal">'.preco($valorPagar).'</div></td>
                </tr>';

                $html .= '
                <tr>
                    <td colspan="2" class="blank"> </td>
                    <td colspan="2" class="total-line">Total</td>
                    <td class="total-value"><div id="total">'.preco($valorPagar).'</div></td>
                </tr>';

                $html .= '
                <tr>
                    <td colspan="2" class="blank"> </td>
                    <td colspan="2" class="total-line">Quantia paga</td>
                    <td class="total-value">'.preco($valorPago).'</td>
                </tr>';

                $html .= '
                <tr>
                    <td colspan="2" class="blank"> </td>
                    <td colspan="2" class="total-line balance">Pagamento em falta</td>
                    <td class="total-value balance"><div class="due">'.preco($valorPorPagar).'</div></td>
                </tr>
            </table>
            <footer style="position: absolute; bottom: 0;">
                <p style="padding: 10px; font-size: 12px;">Email enviado automáticamente após o pagamento de uma mensalidade.</p>
            </footer>
        </div>
        </body>
        </html>';

        $mpdf = new \Mpdf\Mpdf(); 
        $mpdf->SetDisplayMode('fullpage');
        $css = file_get_contents("layout/css/fatura.css");
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML($html, 2);
        if($mpdf->Output(CAM_FATURAS.$numFatura.".pdf", 'F')) {
            return true;
        } else {
            return false;
        }
    }
    
    // ==================================================
    // Função para enviar um email para o cliente
    // ==================================================
    function enviaEmail($destino, $destino_nome, $assunto, $txt_email, $anexo, $nomeAnexo)
    {
        require 'vendor/autoload.php';
        
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->CharSet = 'utf-8';
        $mail->Host = '[Servidor Email]';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Username = '[Email Origem]';
        $mail->Password = '[Password Email Origem]';
        $mail->Port = 465;
        
        $mail->From = utf8_decode('[Email Origem]');
        $mail->FromName = utf8_decode(APP_NAME);
        $mail->addReplyTo = utf8_decode(OWNER_EMAIL);
        $mail->addAddress(utf8_decode($destino), utf8_decode($destino_nome));
        
        $mail->isHTML(true);
        $mail->Subject = utf8_decode($assunto);
        $mail->Body = utf8_decode($txt_email);
        if($anexo != "") {
            $mail->AddAttachment($anexo);
        }
        $mail->AltBody = 'O meio de leitura não é compativel, utilize por exemplo o gmail.com';
        
        if(!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }
    
    // ==================================================
    // Função para enviar um email para o Owner
    // ==================================================
    function enviaEmailToOwner($de, $de_nome, $assunto, $txt_email)
    {
        require 'vendor/autoload.php';
        
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        //$mail->SMTPDebug = 3;
        $mail->Host = '[Servidor Email]';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Username = '[Email Origem]';
        $mail->Password = '[Password Email Origem]';
        $mail->Port = 465;
        
        $mail->From = utf8_decode('[Email Origem]');
        $mail->FromName = utf8_decode(APP_NAME);
        $mail->addReplyTo(utf8_decode($de), utf8_decode($de_nome));
        $mail->addAddress(utf8_decode(OWNER_EMAIL), utf8_decode(APP_NAME));
        
        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body = $txt_email;
        $mail->AltBody = 'O meio de leitura não é compativel, utilize por exemplo o gmail.com';
        
        if(!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }

    // ==================================================
    // Função para criar uma mascara de telefone do tipo XXX XXX XXX
    // ==================================================
    function mascaraTelefone($telefone, $digitos)
    {
        $telefone = chunk_split($telefone,$digitos," ");
        return $telefone;
    }

    // ==================================================
    // Função para abreviar o ano de XXXX para XX
    // ==================================================
    function encortaAno($ano) {
        return substr($ano, 2, 4);
    }

    function getFotoPrincipal($string) {
        $foto = explode(";", $string);
        return $foto[0];
    }

    function verificaExisteFicheiro($caminho) {
        if(file_exists($caminho)) {
            return true;
        } else {
            return false;
        }
    }
    
    function criaSerial() {
        $cr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $max = strlen($cr)-1;
        $parteSerial = null;
        for($i=0; $i < 16; $i++) {
            $parteSerial .= $cr{mt_rand(0, $max)};
        }
        $parteSerial = str_split($parteSerial, 4);
        $parteSerial = "$parteSerial[0]-$parteSerial[1]-$parteSerial[2]-$parteSerial[3]";
        
        return $parteSerial;
    }

    function verificaPost() {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $request = md5(implode($_POST));
            
            if(isset($_SESSION['last_request']) && $_SESSION['last_request'] == $request) {
                return 'refresh';
            } else {
                $_SESSION['last_request'] = $request;
                return 'post';
            }
        }
    }

    function acessoPrivadoAoEstablecimento() {
        if(in_array(get_client_ip(), IP_ESTABLECIMENTO))
            return true;
        else
            return false;
    }
?>