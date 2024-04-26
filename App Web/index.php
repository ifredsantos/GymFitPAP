<?php
    include "config.php";  

    $msg = "";

    $param = [":titulo" => "Apresentação"];
    $textoApresentacao = $gst->exe_query("SELECT textoPT FROM textos WHERE titloPT = :titulo", $param);

    if(count($textoApresentacao) > 0) {
        $textoApresentacao = $textoApresentacao[0]["textoPT"];
    } else $textoApresentacao = "";

    if(isset($_GET['msg']) && $_GET['msg'] != "")
    {
        $URLmsg = $_GET['msg'];
        
        if($URLmsg == "conta-nao-existe")
            $msg .= MSGdanger("Ocorreu um erro", "Não existe uma conta com os dados introduzidos! Para criar uma conta clique ", "registar");
        else if($URLmsg == "conta-nao-ativada")
            $msg .= MSGdanger("Ocorreu um erro", "A sua conta não está ativa. Por favor confirme-a a partir do seu endereço de email", "");
        else if($URLmsg == "conta-ja-ativada")
            $msg .= MSGinfo("Informação", "A sua conta já se encontrava ativa e pronta para utilizar", "");
        else if($URLmsg == "conta-ativada")
            $msg .= MSGsuccess("Sucesso", "A sua conta foi ativada com sucesso", "");
        else if($URLmsg == "mensagem-enviada-com-sucesso")
            $msg .= MSGsuccess("Sucesso", "A sua mensagem foi enviada com sucesso", "");
        else if($URLmsg == "dados-login-incorretos")
            $msg .= MSGdanger("Ocorreu um erro", "Dados de login incorretos", "");
        else if($URLmsg == "acesso-restrito")
            $msg .= MSGdanger("Acesso restrito", "Não tem acesso a esta área. Faça login", "");
        else if($URLmsg == "mensagem-nao-enviada")
            $msg .= MSGdanger("Email não enviado", "Ocorreu um erro ao enviar a sua mensagem", "");
        else if($URLmsg == "excedida-tentativa-de-acesso")
            $msg .= MSGdanger("Conta bloqueada", "A sua conta foi bloqueada por excesso de tentativas de login incorretas. Altere a sua password ou espere ".MAX_LOGIN_TEMPO." Hora", "");
        else if($URLmsg == "password-alterada")
            $msg .= MSGsuccess("Sucesso", "A sua password foi alterada com sucesso", "");
        else if($URLmsg == "password-nao-alterada")
            $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel alterar a sua password", "");
        else if($URLmsg == "token-recuperacao-senha-sucesso")
            $msg .= MSGsuccess("Sucesso", "O seu pedido foi registado e enviado um email para alteração de senha", "");
        else if($URLmsg == "token-recuperacao-senha-erro")
            $msg .= MSGdanger("Ocorreu um erro", "Não foi possivel registar um token de confirmação", "");
        else if($URLmsg == "email-recuperacao-senha-erro")
            $msg .= MSGdanger("Ocorreu um erro", "Ocorreu um erro", "Não foi possivel enviar email para alteração de senha", "");
    }
?>

<!DOCTYPE html>

<html lang = "pt-pt">
    <head>
        <base href="<?= APP_URL ?>">
        <meta charset = "utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="gymfit, ginásio, ginásio em condeixa, condeixa, ginásio gymfit">
        <meta name="description" content="<?= encortarTexto(removerTextoFromat($textoApresentacao), 90, '...'); ?>">
        <meta property="og:url" content="<?= APP_URL ?>">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?= APP_NAME ?> - Ginásio & Fitness">
        <meta property="og:description" content="<?= encortarTexto(removerTextoFromat($textoApresentacao), 90, '...'); ?>">
        <meta name="robots" content="index,nofollow">
        <meta http-equiv="content-language" content="pt">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
        <meta name="author" content="<?= PROGRAMER_NAME ?>, <?= PROGRAMER_EMAIL ?>">
        <meta name="reply-to" content="<?= PROGRAMER_EMAIL ?>">
        <meta http-equiv="cache-control" content="private">
        <meta name="rating" content="general">
        <title><?= APP_NAME ?> - Ginásio & Fitness</title>
        <link rel="icon" href="<?= APP_URL ?>layout/altere.png" type="image/x-icon">
        <link rel="shortcut icon" href="<?= APP_URL ?>layout/altere.png" type="image/x-icon">
        <link rel = "stylesheet" type = "text/css" href = "<?= APP_URL ?>layout/css/design.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src = "<?= APP_URL ?>js/modal_img.js"></script>
    </head>
    
    <body onselectstart="return false" data-spy="scroll" data-target="#myScrollspy" data-offset="50">
        <header id = "#myScrollspy">
            <?php include ("parts/header.php"); ?>
        </header>
        
        <article>
            <?php
                if($msg != "")  { ?>
            <div class="msg-space-modal" id="msg-space-modal">
                <div class="msg-content-modal">
                    <?= $msg; ?>
                </div>
            </div>
            <?php } ?>
            
            <div id="sobrenos" class="apresentacao" style="padding-top: 50px;"><img src="<?php echo APP_URL ?>layout/apresentacao.png" />
                <div class="space_text">
                    <hr>
                    <h2>Bem vindo ao</h2>
                    <h1><span>Gym</span>Fit</h1>
                    <h2>O teu ginásio</h2>
                    <hr>
                    <br>
                    <?= textoFormat($textoApresentacao); ?>
                    <button class="button"><a href="#"><a onclick="document.getElementById('msg-space-modal').style.display='block';">Saber mais</a></button>
                </div>
            </div>

            <div class="msg-space-modal" id="msg-space-modal" style="display: none">
                <div class="msg-content-modal">
                    <h2 class="text_center">GymFit</h2>
                    <p class="text_center"><?= textoFormat($textoApresentacao); ?></p>
                    <div class="space-buttons">
                        <button type="button" style="display: block; margin: auto; background-color: #efefef;">
                            <a onclick="document.getElementById('msg-space-modal').style.display='none';" style="color: black;">Fechar</a>
                        </button>
                    </div>
                </div>
            </div>
            
            <?php
                $modalidades = $gst->exe_query("SELECT * FROM modalidades");
                if (count($modalidades) > 0)
                {
            ?>
            <br id = "modalidades">
            <h2 class="txt-align-center">Modalidades</h2>
            <hr>
            <br>
            <div class = "meio">
                <div class = "catg">
                    <?php
                        for($i = 0; $i < count($modalidades); $i++)
                        {
                    ?>
                    <div class = "space_img">
                        <img src = "<?= APP_URL ?>posts/modalidades/FID/<?= $modalidades[$i]['imgIndex']; ?>">
                        <?php
                                if($modalidades[$i]["descricao"] != "" || $modalidades[$i]["imgs"] != "") {
                        ?>
                        <button class="button"><a href = "<?= APP_URL ?>modalidade/<?= $modalidades[$i]['nome_modalidade']; ?>"><?php echo $modalidades[$i]['nome_modalidade']; ?></a></button>
                        <?php
                                } else
                                echo '<button class="button"><a href="javascript:alert(\'Sem informação adicional\')">'.$buscaModalidades[$i]['nome_modalidade'].'</a></button>';
                        ?>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class  = "clearfix"></div>
            <?php
                }
            ?>
            
            <?php
                $buscaHorarios = $gst->exe_query("SELECT * FROM horarios");

                if(count($buscaHorarios) > 0) {
                    $horario = $buscaHorarios[0];

                    $semanal = str_replace(array(":", ";"),array("H", " - "), $horario['semanal_manha']) . " | " . str_replace(array(":", ";"),array("H", " - "), $horario['semanal_tarde']);
                    $sabado = str_replace(array(":", ";"),array("H", " - "), $horario['sabado_manha']) . " | " . str_replace(array(":", ";"),array("H", " - "), $horario['sabado_tarde']);
                    
                    if($horario['domingo_manha'] == "Encerrado" || $horario['domingo_manha'] == null)
                        $domingo_manha = "ENCERRADO";
                    else
                        $domingo_manha = str_replace(array(":", ";"),array("H", " - "), $horario['domingo_manha']);
                    
                    if($horario['domingo_tarde'] == "Encerrado" || $horario['domingo_tarde'] == null)
                        $domingo_tarde = "ENCERRADO";
                    else
                        $domingo_tarde = str_replace(array(":", ";"),array("H", " - "), $horario['domingo_tarde']);
                    
                    if($domingo_manha == "ENCERRADO" && $domingo_tarde == "ENCERRADO")
                        $domingo = "ENCERRADO";
                    else
                        $domingo = $domingo_manha . " | " . $domingo_tarde;
            ?>
            <br id = "horario">
            <h2 class="txt-align-center">Horário de funcionamento</h2>
            <hr>
            <br>
            <div class = "meio" style = "margin-top: 200px; margin-bottom: 200px;">
                <br>
                <h2 class="txt-align-center"><span>SEGUNDA A SEXTA</span></h2>
                <p class = "text_center"><?= $semanal ?></p>
                <br>
                <h2 class="txt-align-center"><span>SABADO</span></h2>
                <p class = "text_center"><?= $sabado ?></p>
                <br>
                <h2 class="txt-align-center"><span>DOMINGO</span></h2>
                <p class = "text_center"><?= $domingo ?></p>
            </div>
            <div class  = "clearfix"></div>
            <?php
                }
            ?>
            
            <br id = "galeria">
            <h2 class="txt-align-center">Galeria</h2>
            <hr>
            <br>
            <div class = "galeria">
                <div class = "space_galeria_destaque">
                    <img class = "galeria_destaque" src = "<?php echo APP_URL ?>posts/galeria/18813152_1488489704506115_5105988806235853395_n.jpg" onclick="clique('0', '<?php echo APP_URL ?>posts/galeria/18813152_1488489704506115_5105988806235853395_n.jpg', 'Família GymFit', '')" alt = "Família GymFit">
                </div>
                
                <div class = "space_galeria_outras">
                    <?php
                        $fotos = $gst->exe_query("SELECT * FROM galeria ORDER BY data_pub DESC");
                        if (count($fotos) > 0)
                        {
                            for($i = 0; $i < count($fotos); $i++)
                            {
                    ?>
                    <img src = "<?php echo APP_URL ?>posts/galeria/_200_/<?= $fotos[$i]['nome_img']; ?>" alt = "<?= $fotos[$i]['descricao']; ?>" onclick="clique('<?= $fotos[$i]['cod_img']; ?>', '<?php echo APP_URL ?>posts/galeria/<?= $fotos[$i]['nome_img']; ?>', '<?= $fotos[$i]['titulo']; ?>', '<?= $fotos[$i]['descricao']; ?>')">
                    <?php
                            }
                        }
                    ?>
                </div>
            </div>
            
            <div id = "modal">
                <div id="modal-content">
                    <span id = "btnFechar">&times;</span>
                    <img id = "imgModal">
                    <h1 id = "imgTitulo"></h1>
                    <p id = "imgDesc"></p>
                </div>
            </div>
            
            <div class  = "clearfix"></div>
            
            <br id = "localizacao">
            <h2 class="txt-align-center">Onde estamos?</h2>
            <hr>
            <br>
            <div class = "meio">
                <iframe src="<?= APP_MAP ?>" width="100%" height="550" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <div class  = "clearfix"></div>
                        
            <br id = "contactos">
            <h2 class="txt-align-center">Contactos</h2>
            <hr>
            <br>
            <form class = "form_contactos" method = "post" action = "parts/mensagem-contactos.php">
                <p style = "text-align: center;">Pode esclarecer as suas duvidas na <a href = "#localizacao">morada acima</a> indicada ou então atravês do nosso formulário ou ainda por telefone <?= mascaraTelefone(OWNER_TELEFONE,3," ") ?>.</p>
                <br>
                <label>Nome</label><br>
                <input name = "nome" 
                       type = "text" 
                       placeholder = "Escreva o seu primeiro e ultimo nome" 
                       maxlength="100" 
                       autocomplete="on"
                       required>
                <br>
                <label>Email *</label><br>
                <input name="email"
                       type = "email" 
                       placeholder = "Escreva o seu email" 
                       maxlength="100" 
                       autocomplete="on"
                       required>
                <br>
                <label>Mensagem *</label><br>
                <textarea name = "mensagem" 
                          placeholder="Escreva a sua mensagem" 
                          maxlength="500" 
                          autocomplete="off"
                          required></textarea>
                <p style = "margin-top: 5px; font-size: 12px;">* Campos obrigatórios</p>
                <br>
                <div class = "space_termos">
                    <?php include 'parts/termos.html';?>
                </div>

                <div class = "space_termosECheck">
                    <input name="check_termos" type="checkbox" checked required>
                    <div class = "spacePTermos"><p>Concordo com a <a class = "myBtn">politica de proteção de dados</a> pessoais</p></div>
                    <div class  = "clearfix"></div>
                </div>

                <input type = "hidden" name = "acao" value = "enviar-msg-contactos">
                <button type = "submit" class = "button"><a>Enviar</a></button>
            </form>
            <br>
            <div class = "gradCinBlack"></div>
        </article>
        
        <footer>
            <?php include("parts/footer.php"); ?>
        </footer>
        <script src = "<?php echo APP_URL ?>js/modal.js"></script>
    </body>
</html>            