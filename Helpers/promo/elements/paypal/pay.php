<?php

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

require 'app/start.php';

if(!isset($_GET['success'], $_GET['paymentId'], $_GET['PayerID'])){
    die();
}

if((bool)$_GET['success'] === false){
    die();
}

$paymentId = $_GET['paymentId'];
$payerID = $_GET['PayerID'];

$payment = Payment::get($paymentId, $paypal);

$execute = new PaymentExecution();
$execute->setPayerId($payerID);

try{
    $result = $payment->execute($execute, $paypal);
} catch(Exception $e){
    die($e);
}

header("Location: $returnUrl", true, 301);
exit();