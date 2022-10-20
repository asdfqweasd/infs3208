<?php  defined('BASEPATH') OR exit('No direct script access allowed'); 
 
/* 
| ------------------------------------------------------------------- 
|  PayPal API Configuration 
| ------------------------------------------------------------------- 
| 
| You will get the API keys from Developers panel of the PayPal account 
| Login to PayPal account (https://developer.paypal.com/) 
| and navigate to the SANDBOX » Accounts page 
| Remember to switch to your live business email in production! 
| 
|  sandbox                    boolean  PayPal environment, TRUE for Sandbox and FALSE for live 
|  business                    string   PayPal business email 
|  paypal_lib_currency_code string   Currency code. 
*/ 
 
$config['sandbox'] = TRUE; // FALSE for live environment 
 
$config['business'] = '229463581@qq.com'; 
 
$config['paypal_lib_currency_code'] = 'AUD'; 
 
// Where is the button located at? (optional) 
$config['paypal_lib_button_path'] = 'assets/img/paypal.png'; 
 
// If (and where) to log ipn response in a file 
$config['paypal_lib_ipn_log'] = FALSE; 
$config['paypal_lib_ipn_log_file'] = BASEPATH . 'logs/paypal_ipn.log';