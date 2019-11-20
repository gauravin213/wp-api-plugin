<?php
// Include required library files.
require_once('../../../autoload.php');



/**/
$sandbox = TRUE;
$rest_client_id = 'AZe3PuexT_sguHpQ-lDk2ny8jvXCYDsdi5Oa5wUK1oqgqzycB-ezTKDHgBtuLjhRmiQs-Xal5lxj5XXY';
$rest_client_secret = 'EMq9dsAwO3KvZVcgUNaa8e1BJwVH8sQuVJ8mXXte5U7YErb8sk7MBIKwfUWmgaahKNv0y27inSuqG9Xm';
$log_results = false;
$log_path = $_SERVER['DOCUMENT_ROOT'].'/logs/';
$log_level = 'DEBUG';
/**/

$configArray = array(
    'Sandbox' => $sandbox,
    'ClientID' => $rest_client_id,
    'ClientSecret' => $rest_client_secret,
    'LogResults' => $log_results, 
    'LogPath' => $log_path,
    'LogLevel' => $log_level  
);
$PayPal = new \angelleye\PayPal\rest\invoice\InvoiceAPI($configArray);

$parameters = array(
    'page'                  => '',                // A zero-relative index of the list of merchant invoices.
    'page_size'             => '',                // The number of invoices to list beginning with the specified page.
    'total_count_required ' => '',                // Indicates whether the total count appears in the response. Default is false.
);

$returnArray = $PayPal->ListInvoice($parameters);
echo "<pre>";
print_r($returnArray);
