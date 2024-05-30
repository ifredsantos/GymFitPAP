<?php
    function informacaoReferencia($chave_api, $referencia, $entidade)
    {
        // chamada do serviço SOAP - sandbox
        $client = @new SoapClient('http://replica.eupago.pt/replica.eupagov14.wsdl');

        // chamada do serviço SOAP - produção
        //$client = @new SoapClient('https://clientes.eupago.pt/eupagov15.wsdl');
        
        $arraydados = array (
            "chave" => $chave_api,
            "referencia" => $referencia,
            "entidade" => $entidade
        );
        $result = $client->informacaoReferencia($arraydados);
        // verifica erros na execução do serviço e exibe o resultado
        if (is_soap_fault($result))
        {
            trigger_error(
            "SOAP Fault:(
            faultcode: {$result->faultcode},
            faultstring: {$result->faultstring}
            )",E_ERROR);
        }
        else
        {
            //estados possíveis: 0 sucesso. -10 Chave inválida. -9 Valores incorretos
            if ($result->estado == 0)
            {
                //colocar a ação de sucesso
                var_dump($result);
            }
            else
            {
            //ação insucesso
            }
        }
    }

    $chave_api = "demo-663b-0b64-a863-ecc";
    $referencia = "405552889";
    $entidade = "81877";

    informacaoReferencia($chave_api, $referencia, $entidade);
?>