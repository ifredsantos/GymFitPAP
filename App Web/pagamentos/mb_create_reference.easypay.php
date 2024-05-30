<?php
/* Links uteis
 * -> https://geekalicious.pt/pt/php/integracao-servico-pagamentos-easypay-multibanco-mb-atm/
 * -> https://docs.easypay.pt/how-to-implement/multibanco
 * -> https://github.com/luismarto/easypay
 * -> https://backoffice.test.easypay.pt
*/

require '../config.php';

/**
 * The following code demonstrates how to create a MB reference calling an API of Easypay
 * If everything goes well, you'll end up with a table with entity, reference and value
 * that you should provide to the end client to pay.
 */
// Load autoload classes
require_once '../vendor/autoload.php';
// $easypayConfig deve ser onde se coloca o token para a API
$easypayConfig = [
    'ep_user'   => 'SOEIEDNDFNVR270',
    'ep_entity' => '10111',
    'ep_cin'    => '101192',
    's_code'    => '4c19908f-8116-4227-8787-20eb805fa011'
];
$easypay = new Easypay\EasyPay($easypayConfig);
// Note: Live mode is disabled by default.
// If you want to use production you'll need to uncomment the following line
// $easypay->setLive(true);
// In an usual use case, you would have an order that should be related
// to your payment. We're creating a dummy order here, using the sample database on schema/
$codEncomenda = 30;
$param = [
    ":cod_enc" => $codEncomenda,
    ":utilizador" => 1001,
    ":metodo_pagamento" => 1,
    ":localidade" => "Condeixa",
    ":cod_postal" => "3150-230",
    ":morada" => "Urb",
    ":status" => 1,
    ":met_envio" => 1
];
$encomenda = $gst->exe_non_query("
INSERT INTO encomendas(cod_encomenda, utilizador, metodo_pagamento, localidade, codigo_postal, morada, status, metodo_envio) VALUES 
(
    :cod_enc,
    :utilizador,
    :metodo_pagamento,
    :localidade,
    :cod_postal,
    :morada,
    :status,
    :met_envio
)", $param);
$tKey = $codEncomenda;
// Set the key so you can correlate the payment with your system
// This key is usually an autoincrement value from DB and will always
// be treated as "t_key" by easypay
$easypay->setValue('t_key', $tKey);
// Set the value to be payed
$value = '1.00';
$easypay->setValue('t_value', $value);
// Fill in optional values
$obs = 'Bought XPTO product on Nov 2017';
$mobile = '+351 123 456 789';
$email = 'email@example.com';
$easypay->setValue('o_name', 'John Doe');
$easypay->setValue('o_description', 'Purchase of amazing product');
$easypay->setValue('o_obs', $obs);
$easypay->setValue('o_mobile', $mobile);
$easypay->setValue('o_email', $email);
$result = $easypay->createReference('normal');
// Verify if the request throwed an error:
// Easypay result "normally" throws a ep_status with "err1" when there's an error
// but I'm not sure if it's always a "1" at the end, so we better prepare for anything
preg_match("/err[0-9]+/", $result["ep_status"], $matches);
// If matches is not empty, an error was thrown
if (count($matches) !== 0 || $result === false) {
    var_dump($result);
    throw new Exception('Something went wrong with Easypay integration');
}
// We'll display the reference below.
// We're going to store this info on the `easypay_references` table to use later on.
// However, for advanced sites / applications, you will probably want to send this
// information to the client by email or something.
$param = [
    ':ep_cin' => $easypayConfig['ep_cin'],
    ':ep_status' => $result['ep_status'],
    ':ep_message' => $result['ep_message'],
    ':ep_entity' => $easypayConfig['ep_entity'],
    ':ep_reference' => $result['ep_reference'],
    ':t_key' => $tKey,
    ':o_obs' => $obs,
    ':o_mobile' => $mobile,
    ':o_email' => $email,
    ':ep_value' => $value
];
$referenciasEasypay = $gst->exe_non_query("
INSERT INTO easypay_references (ep_cin, ep_status, ep_message, ep_entity, ep_reference, t_key, o_obs, o_mobile, o_email, ep_value) VALUES 
(
    :ep_cin, 
    :ep_status, 
    :ep_message, 
    :ep_entity, 
    :ep_reference, 
    :t_key, 
    :o_obs, 
    :o_mobile, 
    :o_email, 
    :ep_value
)", $param);
?>

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>Create a MB reference</title>
</head>

<body>
<h1>Easypay Example - Create MB reference</h1>
<p style="font-weight: bold">Data for the payment:</p>
<ul>
    <li><span style="font-weight: bold">Entity:</span> <?= $result['ep_entity'] ?></li>
    <li><span style="font-weight: bold">Reference:</span> <?= $result['ep_reference'] ?></li>
    <li><span style="font-weight: bold">Value:</span> <?= $result['ep_value'] ?></li>
</ul>
</body>
</html>