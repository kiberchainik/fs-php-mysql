<?php

$paypal_client_id = $_POST['paypal_client_id'];
$paypal_secret_key = $_POST['paypal_secret_key'];
$paypal_shipping_cost = $_POST['paypal_shipping_cost'];
$paypal_website_link = $_POST['paypal_website_link'];
$paypal_redirect_link = $_POST['paypal_redirect_link'];
$paypal_payment_desc = $_POST['paypal_payment_desc'];

$paypal_data = "
	require 'vendor/autoload.php';

	define('SITE_URL', '$paypal_website_link');
	\$returnUrl = '$paypal_redirect_link';
	\$shipping = $paypal_shipping_cost;
	\$paymentDesc = '$paypal_payment_desc';

	\$paypal = new \PayPal\Rest\ApiContext(
	    new \PayPal\Auth\OAuthTokenCredential(
	        '$paypal_client_id', 
	        '$paypal_secret_key'
	    )
	);
";