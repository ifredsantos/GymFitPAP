<?php
    $dataCompletaAtual = date('Y-m-d');
    $horaAtual = date('H');
    $minutoAtual = date('i');
    $segundoAtual = date('s');
    $dataCompletaAtualHora = date('Y-m-d H:i:s');

    $timeout = $dataCompletaAtual." ".$horaAtual.":".($minutoAtual - TEMPO_INATIVIDADE).":".$segundoAtual;
    
    $param = [
        ":timeout" => $timeout
    ];
    $atualizaEstadoDosUtilizadoresParaOffline = $gst->exe_non_query("
    UPDATE utilizadores 
    SET online = 'n' 
    WHERE data_ultimoAcesso < :timeout OR data_ultimoAcesso LIKE '0000-00-00 00:00:00'", $param);

    $param = [
        ":utilizador" => $_SESSION['cod_user'],
        ":dataHora" => $dataCompletaAtualHora
    ];
    $atualizaEstadoDOUtilizadorAtual = $gst->exe_non_query("
    UPDATE utilizadores 
    SET online = 's', data_ultimoAcesso = :dataHora 
    WHERE cod_utilizador = :utilizador", $param);
?>