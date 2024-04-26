<?php 
    include '../config.php';

    $param = [
        ":utilizador" => $_SESSION['cod_user']
    ];
    $tornaUtilizadorOffline = $gst->exe_non_query("
    UPDATE utilizadores 
    SET online = 'n', data_ultimoAcesso = NOW() 
    WHERE cod_utilizador = :utilizador", $param);
    
    session_unset();
    session_destroy();
    header('location: '.APP_URL); 
?>