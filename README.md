# Itemplatform API Demo
Simple demo application showcasing the Itemplatform API and webhooks.

Test all demo applications of this repository live at https://www.itemplatform.com/demo/index.php

## Introduction
Itemplatform is an open platform that aims to solve many of the problems that occur when creating applications that deal with virtual items, such as e.g. Steam items. With it, users can easily and quickly send and receive items, and also sell and buy items on the Itemplatform market. The platform is designed from the gound up to be integrated by other services that can use its API for everything regarding items.

This repository serves as an entry point for developers wanting to integrate the Itemplatform API into their application. It contains two demo applications:
1.) Itemplatform trade in demo: perfect when your application works with user balances (=giving each user credits/coins/points/etc. to use on your site)
2.) Receving & sending specific items: the demo application accepts incoming items and sends them back immediately to their owners. 

The demo applications are kept very simple on purpose. However, in the process all important API functions are used, and you can use the source code of this demo freely used as the foundation stone of your application / integration.

## Important Links
- [Itemplatform](https://www.itemplatform.com/)
- [Itemplatform API Documentation](http://developer.webmini.com/en/itemplatform-api/)
- [Itemplatform Webhooks Documentation](http://developer.webmini.com/en/webhooks/)
- [Test both demo applications live](https://www.itemplatform.com/demo/index.php)

## Setup
1. Download the source code of this demo.
2. Edit the file `config.php`
  1. Enter the name of your application / website URL at `ITEMPLATFORM_APPLICATION_NAME`, such as e.g. `MyWebsite.com`.
  2. Enter your Itemplatform account ID at `ITEMPLATFORM_ACCOUNT_ID`. Your can get your ID from the [Itemplatform settings page](https://www.itemplatform.com/en/settings/).
  3. [Create a new webhook](https://my.webmini.com/en/user/apihooks/) for the `Item(s) Received` event. Use the absolute URL to `webhook.php` as the webhook URL, e.g. `https://yourwebsite.com/webhook.php`. Once you added the webhook, enter its secret at `ITEMPLATFORM_WEBHOOK_SECRET`.
  4. Optional (not required for trade ins): [Create a new Personal API Token](https://my.webmini.com/en/user/apikeys/), enter its username at `ITEMPLATFORM_PERSONAL_TOKEN_USERNAME` and its secret at `ITEMPLATFORM_PERSONAL_TOKEN_SECRET`.
3. When testing the Itemplatform trade in functionality, you need to modify the files `webhook_payment.php` and `interface_tradeout.php`. Details can be found in the two files.
4. Open the `index.php` page in your webbrowser to test the demo. *Please note that you need two different Itemplatform accounts for this demo to work: one account that you automate using the API, and one "personal" account that you can use for testing.*

## Disclaimer
This website and project are not affiliated with Steam or Valve. Steam and Valve are registered trademarks of Valve Corporation.
