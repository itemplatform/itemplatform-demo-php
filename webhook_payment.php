<?php

/**
 * This is a demonstration of how the payment webhook from Itemplatform could be processed.
 * Edit this file so that the incoming payment is added to your database.
 * Webhook documentation:
 * http://developer.webmini.com/en/webhooks/
 * Set up your webhook here:
 * https://my.webmini.com/en/user/apihooks/
 */


// Load config
require('.' . DIRECTORY_SEPARATOR . 'config.php');
// Load Itemplatform demo library
require('.' . DIRECTORY_SEPARATOR . 'lib.php');


// Validate webhook call
$webhookValidationResult = Itemplatform::webhookValidate(ITEMPLATFORM_WEBHOOK_SECRET);

if (!$webhookValidationResult['success']) {
	// Validation failed => send HTTP error code and exit
	http_response_code($webhookValidationResult['httpcode']);
	exit;
}


// Check webhook event: we only care about the "payment" event.
if ($webhookValidationResult['event'] !== 'payment') {
	// Do not send an HTTP error code here, as the webhook itself
	// was actually valid.
	exit;
}


// Store payment in database
foreach ($webhookValidationResult['payload'] as $payment) {
	
	// !!! EDIT CODE HERE !!!
	
	// Insert your code here to add the transaction to your database.
	// Available parameters:
	// - $payment['payer_id']		Itemplatform account ID of payer
	// - $payment['payer_steam']	Steam 64 ID of payer
	// - $payment['amount']			Payment amount (your account receives this amount minus the fees)
	// - $payment['fees']			Fees for this transaction
	// - $payment['date']			Date this payment was created
}
