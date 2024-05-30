<?php
    function geraReferenciaMB($chave_api, $nota_de_encomenda, $valor_da_encomenda)
    {
        // chamada do serviço SOAP - produção
        //$client = @new SoapClient('https://seguro.eupago.pt/eupagov2.wsdl');

        // chamada do serviço SOAP - sandbox
        $client = @new SoapClient('http://replica.eupago.pt/replica.eupagov2.wsdl');

        $arraydados = array(
            "chave" => $chave_api, 
            "valor" => $valor_da_encomenda, 
            "id" => $nota_de_encomenda
        );//cada canal tem a sua chave

        $result = $client->gerarReferenciaMB($arraydados);

        // verifica erros na execução do serviço e exibe o resultado
        if (is_soap_fault($result))
        {
            trigger_error("SOAP Fault: (faultcode: {$result->faultcode}, faultstring: {$result->faulstring})", E_ERROR);
        }
        else
        {
            echo "1\n";
            if ($result->estado == 0)
            { 
                echo "2\n";
                //estados possíveis: 0 sucesso. -10 Chave invalida. -9 Valores incorretos
                //colocar a ação de sucesso
                var_dump($result); // retorna 3 valores: entidade, referência e valor
            }
            else
            {
                //acao insucesso
                echo "3\n";
            }
        }
    }
    /*********** Fim Exemplo de chamada de método gerarReferenciaMB ***************/

    $chave_api = "demo-663b-0b64-a863-ecc";
    $nota_de_encomenda = "Teste 1";
    $valor_da_encomenda = 30.00;

    geraReferenciaMB($chave_api, $nota_de_encomenda, $valor_da_encomenda);
?>