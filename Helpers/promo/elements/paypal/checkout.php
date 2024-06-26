<?php

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

require 'app/start.php';

if( !isset( $_POST['product'], $_POST['price'] )){
    die();
}

$product = $_POST['product'];
$price = $_POST['price'];
$currency = 'USD';

$total = $price + $shipping;

$payer = new Payer();
$payer->setPaymentMethod('paypal');

$item = new Item();
$item->setName($product)
    ->setCurrency($currency)
    ->setQuantity(1)
    ->setPrice($price);

$itemList = new ItemList();
$itemList->setItems([$item]);

$details =new Details();
$details->setShipping($shipping)
    ->setSubtotal($price);

$amount = new Amount();
$amount->setCurrency($currency)
    ->setTotal($total)
    ->setDetails($details);

$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription($paymentDesc)
    ->setInvoiceNumber(uniqid());

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl(SITE_URL . '/paypal/pay.php?success=true')
    ->setCancelUrl(SITE_URL . '/paypal/pay.php?success=false');

$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->SetTransactions([$transaction]);

try{
    $payment->create($paypal);
} catch( Exception $e ){
    die($e);
}

$approvalUrl = $payment->getApprovalLink();

header("Location: {$approvalUrl}");