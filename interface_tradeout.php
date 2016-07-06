<?php

/**
 * This is a demonstration of how the tradeout confirmation call from
 * Itemplatform could be processed.
 * Edit this file so that the outgoing payment is added to your database
 * and the payment request confirmed.
 * Documentation:
 * http://developer.webmini.com/en/itemplatform-api/
 * http://developer.webmini.com/en/webhooks/ (the tradeout confirmation
 * call is NOT a webhook but the validation is identical)
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



// !!! EDIT CODE HERE !!!
$userBalance = 0; // replace this with your code retrieving the user balance from your database





// There are two possible cases of why this interface can be called by Itemplatform:
// 1. To receive the user balance WITHOUT requesting a payment confirmation
// 2. Requesting confirmation for a specific payment

if (!isset($webhookValidationResult['payload']['amount'])) {
	// Payload does not contain "amount" parameter => this is case 1, requesting user balance
	
	// (we use the default HTTP code 200 here, so no changes needed)
	
	// Print out user balance
	echo round($userBalance['balance'], 2);
	
} else {
	// Payload contains "amount" parameter => this is case 2, requesting payment confirmation
	// process transaction
	
	// Check that user balance is sufficient for requested payout
	if ($userBalance['balance'] >= $webhookValidationResult['payload']['amount']) {
		// User balance is equal or higher of the requested payout amount
		
		// !!! EDIT CODE HERE !!!
		
		// Add your code here for adding the transaction to your database.
		// Remember that this is an OUTGOING payment, so depending on your implementation
		// you might want store the amount multiplied by -1 to mark it as a payment going out.
		
		if (
			
			// !!! EDIT CODE HERE !!!
			
			// check that adding the transaction to database was successful
			
		) {
			// The transaction was successfully added to database => confirm payout by sending
			// HTTP code and the output "OK"
			http_response_code(201);
			echo 'OK';
		} else {
			// Something went wrong
			
			// You can specifiy your own HTTP code here, this is just a suggestion
			http_response_code(502);
			
			// You can output your error message here if you want (optional)
			echo 'Database error';
		}
	} else {
		// User balance does not have sufficient balance for this payment => deny payout
		
		// By sending code 409, we trigger an "insufficient funds" message on Itemplatform
		http_response_code(409);
		
		// Print out user balance
		echo round($userBalance['balance'], 2);
	}
}
