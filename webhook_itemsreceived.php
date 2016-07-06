<?php

/**
 * This is a demonstration of how the webhook from Itemplatform could be processed
 * when receiving items.
 * We keep things very simple here and just immediately send back all the items we
 * receive. In your application, you probably will do something more elaborate
 * with the received items, but this demo shows all relevant parts.
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


// Check webhook event: in this demo, we only care about the items_received event.
if ($webhookValidationResult['event'] !== 'items_received') {
	// Do not send an HTTP error code here, as the webhook itself
	// was actually valid.
	exit;
}


// Webhook call is valid => initiate Itemplatform class to call API
$itemplatform = new Itemplatform(
	// This value will be used as the User-Agent for API calls. Itemplatform REQUIRES you
	// to have a User-Agent that let's us identify you, e.g. the name or website of your
	// application.
	ITEMPLATFORM_APPLICATION_NAME,
	ITEMPLATFORM_ACCOUNT_ID
);


// Personal API Token documentation:
// http://developer.webmini.com/en/authentication/
// Get your Personal API Token here:
// https://my.webmini.com/en/user/apikeys/
$itemplatform->setPersonalApiToken(
	ITEMPLATFORM_PERSONAL_TOKEN_USERNAME,
	ITEMPLATFORM_PERSONAL_TOKEN_SECRET
);


// Generate array for "send items" API call
$itemsToSend = array();
foreach ($webhookValidationResult['payload'] as $item) {
	$itemsToSend[] = array(
		'item' => $item['id'],
		'to' => $item['from'] // Send item back to original owner
	);
}


// If wanted, turn debugging on:
// $itemplatform->setDebug(true);

// Make "send items" API call
$apiCallResult = $itemplatform->apiSendItems($itemsToSend);

// $apiCallResult['httpcode'] will contain the resulting HTTP code. A code of 2xx means
// everything went fine.
// When debugging is turned on, $apiCallResult['debug'] will contain the complete HTTP
// call log data.
