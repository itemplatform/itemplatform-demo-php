<?php

/**
 * CONFIGURATION FOR ITEMPLATFORM DEMO
 *
 * Never share your Webhook Secret or Personal API Token Secret with anyone,
 * and do not commit them to e.g. GitHub! Whoever has access to your tokens
 * gains access to your account, with all access rights that you granted to
 * those tokens!
 *
 */



// APPLICATION NAME
// ================

// All API calls are required to have an User-Agent thet identifies your application.
// This can be your website URL, your email address, or something similar.

define(
	'ITEMPLATFORM_APPLICATION_NAME',
	$_SERVER['SERVER_NAME'] // Put the URL of your application here, e.g. mywebsite.com
);




// ITEMPLATFORM ACCOUNT
// ====================

// In order to make API calls regarding items in your account, your application needs
// to know your account ID. You can find your account ID here:
// https://www.itemplatform.com/en/settings/

define(
	'ITEMPLATFORM_ACCOUNT_ID',
	12345678 // Put your account ID here.
);




// WEBHOOK (FOR RECEIVING NOTIFICATIONS ABOUT E.G. NEW ITEMS RECEIVED)
// ===================================================================

// Webhook documentation:
// http://developer.webmini.com/en/webhooks/
// Set up your webhook and receive the secret here:
// https://my.webmini.com/en/user/apihooks/

// Webhook secret
define(
	'ITEMPLATFORM_WEBHOOK_SECRET',
	'abcdef123456' // Put your webhook secret here.
);




// PERSONAL API TOKEN (FOR MAKING API CALLS)
// =========================================

// Personal API Token documentation:
// http://developer.webmini.com/en/authentication/
// Get your Personal API Token here:
// https://my.webmini.com/en/user/apikeys/

// Token username
define(
	'ITEMPLATFORM_PERSONAL_TOKEN_USERNAME',
	'abcdef123456' // Put your Personal API Token username here.
);

// Token secret
define(
	'ITEMPLATFORM_PERSONAL_TOKEN_SECRET',
	'abcdef123456' // Put your Personal API Token secret here.
);
