<?php

// Load config
require('.' . DIRECTORY_SEPARATOR . 'config.php');
// Load Itemplatform demo library
require('.' . DIRECTORY_SEPARATOR . 'lib.php');



echo '<html><head><title>Itemplatform API Demo</title></head><body>';

echo '<h1>Itemplatform API Demo</h1>';

echo '<h2>Demo 1: Itemplatform Trade In / Item Payments</h2>';
echo '<h3>Explanation</h3>';
echo '<p>This demo showcases how to use the Itemplatform API when your application works with user balances (=giving each user credits/coins/points/etc. to use on your site). Using Itemplatform, your application does not have to deal with items directly at any point. This allows you to focus on the core aspects of your app and leave all item handling to Itemplatform. Users <em>trade in</em> items to increase their credit balance in your application, and <em>trade out</em> items to decrease their balance. Itemplatform notifies you of trade ins, and each trade out has to confirmed by your app.</p>';
echo '<p><strong>Please note that this demo works with real items. Since trade in prices are lower that trade out prices, you will lose your item in the process and gain a slightly cheaper one for it instead, effectively losing a few cents in value!</strong></p>';
echo '<p style="font-size: 1.3em;"><a href="' . Itemplatform::htmlEncode('https://www.itemplatform.com/tradein/' . ITEMPLATFORM_ACCOUNT_ID . '/') . '" style="border: 1px solid; border-radius: 0.3em; padding: 0.3em;">Trade In Demo</a> | <a href="' . Itemplatform::htmlEncode('https://www.itemplatform.com/tradeout/' . ITEMPLATFORM_ACCOUNT_ID . '/') . '" style="border: 1px solid; border-radius: 0.3em; padding: 0.3em;">Trade Out Demo</a></p>';
echo '<p>Check out the <a href="https://github.com/webmini/itemplatform-demo-php" target="_blank">source code at GitHub</a> and the <a href="http://developer.webmini.com/en/itemplatform-api/" target="_blank">Itemplatform API documenation</a>.';

echo '<h2>Demo 2: Receiving &amp; Sending Items</h2>';
echo '<h3>Explanation</h3>';
echo '<p>This demo showcases how to use the Itemplatform API for directly receiving and sending items. Compared to Demo 1, you have more flexibility for your implementation, but need to maintain an item database within your application. The demo is kept very simple on purpose and does nothing more than just receiving items and immediately sending them back to their owner. Check out its <a href="https://github.com/webmini/itemplatform-demo-php" target="_blank">source code at GitHub</a> and the <a href="http://developer.webmini.com/en/itemplatform-api/" target="_blank">Itemplatform API documenation</a>.</p>';

echo '<p><strong>Send one or more items to the Demo application, and it will immediately send them back to you:</strong></p>';
echo '<p style="font-size: 1.3em;"><a href="' . Itemplatform::htmlEncode('https://www.itemplatform.com/send/' . ITEMPLATFORM_ACCOUNT_ID . '/') . '" style="border: 1px solid; border-radius: 0.3em; padding: 0.3em;">Click here to start!</a></p>';

echo '</body></html>';
