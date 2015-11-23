<?php

// Load config
require('.' . DIRECTORY_SEPARATOR . 'config.php');
// Load Itemplatform demo library
require('.' . DIRECTORY_SEPARATOR . 'lib.php');


echo '<h2>Itemplatform API Demo</h2>';
echo '<p>This demo showcases how to use the Itemplatform API. It is kept very simple on purpose and does nothing more than just receiving items and immediately sending them back to their owner. Check out its <a href="https://github.com/webmini/itemplatform-demo-php" target="_blank">source code at GitHub</a> and the <a href="http://developer.webmini.com/en/itemplatform-api/" target="_blank">Itemplatform API documenation</a>.</p>';

echo '<p><strong>Send one or more items to the Demo application, and it will send them back to you:</strong></p>';
echo '<p><a href="' . Itemplatform::htmlEncode('http://www.itemplatform.com/send/' . ITEMPLATFORM_ACCOUNT_ID . '/') . '">Click here to start!</a></p>';
