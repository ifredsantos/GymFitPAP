<?php
    /*include("../config.php");

    if(isset($_SESSION['role']) && $_SESSION['role'] == 1 || isset($_SESSION['role']) && $_SESSION['role'] == 2 && $_SESSION['auth'] == 1)
        header('location: dashboard');

    $msg = "";
    $auth = 0;
    if(isset($_POST['acao']) && $_POST['acao'] == "login")
    {
        $username = $_POST['username'];
        $psw = md5($_POST['psw']);

        $param = [
            ":identificador" => $username,
            ":psw" => $psw
        ];
        $verificaDados = $gst->exe_query("
        SELECT cod_utilizador, username, email, psw, tipo_utilizador FROM utilizadores 
        WHERE username = :identificador AND psw = :psw OR email = :identificador AND psw = :psw", $param);
        
        if(count($verificaDados) > 0)
        {
            $uDados = $verificaDados[0];
            
            if($uDados['tipo_utilizador'] == 1 || $uDados['tipo_utilizador'] == 2)
            {
                $auth = 1;
                $_SESSION['cod_user'] = $uDados['cod_utilizador'];
                $_SESSION['role'] = $uDados['tipo_utilizador'];
                $_SESSION['auth'] = $auth;

                //Atualiza ultima data de acesso e ip
                $ip = get_client_ip();

                $param = [
                    ":data_ultimo_acesso" => date("Y-m-d H:i:s"),
                    ":ip_ultimo_acesso" => $ip,
                    ":cod_user" => $uDados['cod_utilizador']
                ];
                $updateLastAcss = $gst->exe_non_query("UPDATE utilizadores 
                SET data_ultimoAcesso = :data_ultimo_acesso, ip_ultimoAcesso = :ip_ultimo_acesso 
                WHERE cod_utilizador = :cod_user", $param);
                header("location: dashboard");
            }
            else
            {
                $msg .= "Não tem acesso a esta área!<br>";
            }
        }
        else
        {
            $msg .= "Dados incorretos!<br>";
        }
    } */
?>

<!-- <!DOCTYPE html>
<html lang = "pt-pt">
	<head>
        <base href="<?= APP_URL_OFFICE ?>" />
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="content-language" content="pt">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
        <meta name="author" content="Fredinson, fredinsondev@gmail.com">
        <meta name="reply-to" content="fredinsondev@gmail.com">
        <meta http-equiv="cache-control" content="private">
		<title>Office - Acesso Restrito</title>
		<link rel = "stylesheet" type = "text/css" href = "layout/css/design.css">
        <link rel="icon" href="layout/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="layout/favicon.ico" type="image/x-icon">
	</head>
    
    <body>
        <article>
            <div class = "space-form-login">
                <form action = "index.php" method="post">
                    <div class = "form-header">
                        <h1>Acesso Restrito!</h1>
                    </div>
                    <p style = "margin-top: 20px; text-align: center; color: red;"><?php echo $msg; ?></p>
                    <input type = "text" name = "username" placeholder="Username">
                    <input type = "password" name = "psw" placeholder="Password">
                    <input type = "hidden" name = "acao" value = "login">
                    <input id = "btn-login" type = "submit" value = "Login">
                </form>
            </div>
        </article>
        
        <footer>
            
        </footer>
    </body>
</html> -->