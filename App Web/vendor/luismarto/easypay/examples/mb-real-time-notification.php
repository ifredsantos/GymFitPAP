<?php

/**
 * The following code demonstrates how to use real time notifications for MB payments
 * Use this when you want to be notified, in real time, that a MB payment was completed.
 * When Easypay calls this endpoint, it comes with a few parameters that we need to retrieve to move along.
 * The url is something like: http://easypay-examples.com/mb-real-time-notification.php?ep_cin=12345&ep_user=YOUR_USER&ep_doc=MBTEST0001234567890123456789
 *
 * BEWARE: this code should be executed on an endpoint that you need to ser on Easypay's backoffice.
 * For further details check this post: @todo LINKLINKLINKLINKLINKLINKLINKLINKLINKLINKLINKLINK
 */

// Set error reporting for demo purposes
error_reporting(E_ERROR);

// Load autoload classes
require_once 'vendor/autoload.php';
require_once 'config.php';

// There's a "ep_type" parameter that may or may not be sent. If sent, we need it
$epCin = $_GET['ep_cin'];
$epUser = $_GET['ep_user'];
$epDoc = $_GET['ep_doc'];
$additionalParameters = [];
if (array_key_exists('ep_type', $_GET)) {
    $additionalParameters['ep_type'] = $_GET['ep_type'];
}

// Let's start by creating the XML to retrieve later
// You can do this later on the process

// Start generating the XML
$xml = new SimpleXMLElement('<getautoMB_key></getautoMB_key>');
$xml->addChild('ep_cin', $epCin);
$xml->addChild('ep_user', $epUser);
$xml->addChild('ep_doc', $epDoc);

// Step 4 - Get the full information for this payment (including reference)
// Call API 03AG
$easypay = new Easypay\EasyPay($easypayConfig);
$paymentInfo = $easypay->getPaymentInfo(
    array_merge(
        [
            'ep_cin'  => $epCin,
            'ep_user' => $epUser,
            'ep_doc'  => $epDoc,
        ],
        $additionalParameters
    )
);

// Check if $paymentInfo has any error status
preg_match("/err[0-9]+/", $paymentInfo["ep_status"], $matches);

// Check if exists any error
if (count($matches) > 0) {
    var_dump($paymentInfo);
    throw new Exception('Something went wrong when retrieving the payment information');
}

// You can test the payment type here and, if it is an unexpected payment type, return the XML and move along
// or whatever you application should do
//if ($paymentInfo['ep_payment_type'] != 'MB') {
//    // You should return the XML anyway so Easypay gets notified
//    return $xml;
//}

// You now have access to all the payment's details, so you will want to update the easypay_references
// record. However, you also need to create a new row in order to create the `ep_key`. Actually,
// you can use the id of easypay_references as the ep_key. As long as its unique, it will work.
// I'll use the two tables since the same schema will serve for the direct debit payments
$conn = new PDO('mysql:host=' . $dbConfig['host']. ';dbname=easypay_examples', $dbConfig['user'], $dbConfig['pass']);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch the easypay_references row that was created on mb-create-reference.php
$stmt = $conn->prepare('SELECT * FROM easypay_references WHERE ep_reference = :ep_reference');
$stmt->execute([':ep_reference' => $paymentInfo['ep_reference']]);
$easypayReference = $stmt->fetch();

// Now that we have the easypay_reference id we can insert a new record on easypay_payments
$stmt = $conn->prepare("
    INSERT INTO easypay_payments (easypay_reference_id, ep_doc, ep_cin, ep_user, ep_status, ep_message, ep_entity, ep_reference, ep_value, ep_date, ep_payment_type, ep_value_fixed, ep_value_var, ep_value_tax, ep_value_transf, ep_date_transf, t_key)
    VALUES (:easypay_reference_id, :ep_doc, :ep_cin, :ep_user, :ep_status, :ep_message, :ep_entity, :ep_reference, :ep_value, :ep_date, :ep_payment_type, :ep_value_fixed, :ep_value_var, :ep_value_tax, :ep_value_transf, :ep_date_transf, :t_key)
");
$stmt->execute([
    ':easypay_reference_id' => $easypayReference['id'],
    ':ep_doc' => $epDoc,
    ':ep_cin' => $epCin,
    ':ep_user' => $epUser,
    ':ep_status' => $paymentInfo['ep_status'],
    ':ep_message' => $paymentInfo['ep_message'],
    ':ep_entity' => $paymentInfo['ep_entity'],
    ':ep_reference' => $paymentInfo['ep_reference'],
    ':ep_value' => $paymentInfo['ep_value'],
    ':ep_date' => $paymentInfo['ep_date'],
    ':ep_payment_type' => $paymentInfo['ep_payment_type'],
    ':ep_value_fixed' => $paymentInfo['ep_value_fixed'],
    ':ep_value_var' => $paymentInfo['ep_value_var'],
    ':ep_value_tax' => $paymentInfo['ep_value_tax'],
    ':ep_value_transf' => $paymentInfo['ep_value_transf'],
    ':ep_date_transf' => $paymentInfo['ep_date_transf'],
    ':t_key' => $paymentInfo['t_key'],
]);

// The insert will generate a new ep_key, which we'll use on the XML
$epKey = $conn->lastInsertId();

// Let's add the key to the XML
$xml->addChild('ep_key', $epKey);

// Add the status
$xml->addChild('ep_status', 'ok0');
$xml->addChild('ep_message', 'generated document');

// Echo the XML so Easypay can process this

header("content-type: text/xml; charset=utf-8");
echo $xml->saveXML();
