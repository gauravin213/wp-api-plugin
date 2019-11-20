<?php
/*
* Paypal Invoice API arguments
*/
add_action( 'wp_ajax_custom_paypal_invoice_aj', 'custom_paypal_invoice_aj_fun');
add_action( 'wp_ajax_nopriv_custom_paypal_invoice_aj', 'custom_paypal_invoice_aj_fun');
function custom_paypal_invoice_aj_fun(){

    $post_id = $_POST['order_id'];

    $get_post_type = get_post_type($post_id);
    
    if($get_post_type == 'shop_order'){
        
        $customer_user_id = $_POST['user_id'];
    
        $get_user_role = get_user_role('wholesale_customer', $customer_user_id);
        
        if ($get_user_role) { 
            
            prepare_invoce_data_backend($post_id);

            //echo "call :: prepare_invoce_data_backend";
            
        }else{
           // other user
            prepare_invoce_data_backend($post_id);
        }
    }


    die();
}

function prepare_invoce_data_backend($order_id){

    global  $woocommerce;
   
    $order = wc_get_order( $order_id );
    $or_billing = $order->get_data()['billing'];
    $or_shipping = $order->get_data()['shipping'];
    $types = array('line_item','fee','shipping');
    $or_items = $order->get_items($types);
    
    $woocommerce_currency = get_woocommerce_currency();


    $invoice_id = get_post_meta( $order_id, 'wholesaler_payment_invoice_id', true ); 
    $invoice_number = get_post_meta( $order_id, 'wholesaler_payment_number', true );


   /* $invoice_id = '';
    $invoice_number = '';*/


    if(isset($_POST['cus_hwspo'])){
        
        if($_POST['cus_hwspo'] == 'paypal'){

            if ($invoice_number && !empty($invoice_number)) {
                //echo "invoice_number true : ".$invoice_number;
                //die();

                $myArr = array(
                        'status' => 'done',
                        'invoice_id' => $invoice_id,
                        'invoice_number' => $invoice_number,
                    );
                $myJSON = json_encode($myArr); 
                echo $myJSON;

            }else{
                //echo "invoice_number false : ".$invoice_number;
                $payment_name = 'paypal';
                update_post_meta( $order_id, '_payment_method', 'Paypal' );
                update_post_meta( $order_id, '_payment_method_title', 'Paypal' );
                get_invoice_custom_backend($order_id, $or_billing, $or_shipping, $or_items, $woocommerce_currency);

               
            }
        
        }
        
        
    }else{
        
       //die('Payment Mode Note Set');
        
    }

}



function get_invoice_custom_backend($order_id, $or_billing, $or_shipping, $or_items, $woocommerce_currency){

    // Include required library files.
    require_once('autoload.php');
    require_once('config.php');

    $configArray = array(
        'Sandbox' => $sandbox,
        'ClientID' => $rest_client_id,
        'ClientSecret' => $rest_client_secret,
        'LogResults' => $log_results, 
        'LogPath' => $log_path,
        'LogLevel' => $log_level  
    );

    $PayPal = new \angelleye\PayPal\rest\invoice\InvoiceAPI($configArray);

    // Merchant informations is Required for creating new Invoice. 
    $merchantInfo = array(
        'Email' => get_option('diesel_pi_email'),            // The merchant email address. Maximum length is 260 characters.
        'FirstName' => get_option('diesel_pi_firstname'),                         // The merchant first name. Maximum length is 30 characters.
        'LastName'  => get_option('diesel_pi_lastname'),                           // The merchant last name. Maximum length is 30 characters.        
        'BusinessName' => get_option('diesel_pi_company'),           // The merchant company business name. Maximum length is 100 characters.
    );

    $merchantPhone = array(
        'CountryCode' =>  get_option('diesel_pi_country'),                          // Country code (from in E.164 format).
        'NationalNumber' =>  get_option('diesel_pi_phone'),               // In-country phone number (from in E.164 format).
        //'Extension' => '',                           // Phone extension.
    );

    $merchantAddress = array(
        'Line1' => get_option('diesel_pi_address1'),                     // Line 1 of the Address (eg. number, street, etc).
        'Line2' => get_option('diesel_pi_address2'),                              // Optional line 2 of the Address (eg. suite, apt #, etc.).
        'City'  => get_option('diesel_pi_city'),                          // City name.
        'CountryCode' => get_option('diesel_pi_country'),                     // 2 letter country code.    
        'PostalCode'  => get_option('diesel_pi_zip'),                  // Zip code or equivalent is usually required for countries that have them. For list of countries that do not have postal codes please refer to http://en.wikipedia.org/wiki/Postal_code. 
        'State'       => get_option('diesel_pi_state'),                      // 2 letter code for US states, and the equivalent for other countries.     
    );


    //if (isset($_POST['cus_paypal_id'])) {
    //    $or_billing['email'] = '';
        $or_billing['email'] =  $_POST['cus_paypal_id'];
    //}



    $billingInfo = array(
        'Email' => $or_billing['email'],                 // The invoice recipient email address. Maximum length is 260 characters.
        'FirstName' => $or_billing['first_name'],        // The invoice recipient first name. Maximum length is 30 characters.
        'LastName'  => $or_billing['last_name'],         // The invoice recipient last name. Maximum length is 30 characters. 
        'BusinessName' => $or_billing['company'],        // The invoice recipient company business name. Maximum length is 100 characters.
        'Language' => 'en_US',                           // The language in which the email was sent to the payer. Used only when the payer does not have a PayPal account. Valid Values: ["da_DK", "de_DE", "en_AU", "en_GB", "en_US", "es_ES", "es_XC", "fr_CA", "fr_FR", "fr_XC", "he_IL", "id_ID", "it_IT", "ja_JP", "nl_NL", "no_NO", "pl_PL", "pt_BR", "pt_PT", "ru_RU", "sv_SE", "th_TH", "tr_TR", "zh_CN", "zh_HK", "zh_TW", "zh_XC"]
        'AdditionalInfo' => '',                          // Additional information, such as business hours. Maximum length is 40 characters.    
        'NotificationChannel' => '',                     // Valid Values: ["SMS", "EMAIL"]. Preferred notification channel of the payer. Email by default.
        
    );

    $billingInfoPhone = array(
        'CountryCode' => $or_billing['country'],          // Country code (from in E.164 format).
        'NationalNumber' => $or_billing['phone'],         // In-country phone number (from in E.164 format).
        'Extension' => '',                                // Phone extension.
    );

    $billingInfoAddress = array(
        'Line1' => $or_billing['address_1'],              // Line 1 of the Address (eg. number, street, etc).
        'Line2' => $or_billing['address_2'],              // Optional line 2 of the Address (eg. suite, apt #, etc.).
        'City'  => $or_billing['city'],                   // City name.
        'CountryCode' => $or_billing['country'],          // 2 letter country code.    
        'PostalCode'  => $or_billing['postcode'],         // Zip code or equivalent is usually required for countries that have them. For list of countries that do not have postal codes please refer to http://en.wikipedia.org/wiki/Postal_code. 
        'State'       => $or_billing['state'],            // 2 letter code for US states, and the equivalent for other countries.         
    );


    $shippingInfo = array(
        'FirstName' => $or_shipping['first_name'],       // The invoice recipient first name. Maximum length is 30 characters. 
        'LastName'  => $or_shipping['last_name'],        // The invoice recipient last name. Maximum length is 30 characters.
        'BusinessName' => $or_shipping['company'],       // The invoice recipient company business name. Maximum length is 100 characters.     
    );

    $shippingInfoPhone = array(
        'CountryCode' => $or_shipping['country'],         // Country code (from in E.164 format).
        'NationalNumber' => $or_billing['phone'],                           // In-country phone number (from in E.164 format).
        'Extension' => '',                                // Phone extension.
    );

    $shippingInfoAddress = array(
        'Line1' => $or_shipping['address_1'],             // Line 1 of the Address (eg. number, street, etc).
        'Line2' => $or_shipping['address_2'],             // Optional line 2 of the Address (eg. suite, apt #, etc.).
        'City'  => $or_shipping['city'],                  // City name.
        'CountryCode' => $or_shipping['country'],         // 2 letter country code.    
        'PostalCode'  => $or_shipping['postcode'],        // Zip code or equivalent is usually required for countries that have them. For list of countries that do not have postal codes please refer to http://en.wikipedia.org/wiki/Postal_code. 
        'State'       => $or_shipping['state'],           // 2 letter code for US states, and the equivalent for other countries.     
    );


    $itemArray = array();

    foreach( $or_items as $item_id => $item ){

        $item1 = array(
            'Name' => $item->get_name(),                                // Name of the item. 200 characters max.
            'Description' => '',                                        // Description of the item. 1000 characters max.
            'Quantity' => $item->get_quantity(),                        // Quantity of the item. Range of -10000 to 10000.
            'UnitPrice'  => array(
                                'Currency' => $woocommerce_currency,   // 3 letter currency code as defined by ISO 4217.     
                                'Value'    => $item->get_total()    // amount up to N digit after the decimals separator as defined in ISO 4217 for the appropriate currency code. 
                               ),                 // Unit price of the item. Range of -1,000,000 to 1,000,000.
           'Tax' => array(
                                'Name'    => '',                        // The tax name. Maximum length is 20 characters. 
                                'Percent' => '',                        // The rate of the specified tax. Valid range is from 0.001 to 99.999.                        
                             ),                                         // Tax associated with the item.
            'Date' => '',          // The date when the item or service was provided. The date format is *yyyy*-*MM*-*dd* *z* as defined in [Internet Date/Time Format](http://tools.ietf.org/html/rfc3339#section-5.6).
           'Discount' => array(
                                'Percent' => '',                        
                            ),                                         // The item discount, as a percent or an amount value.
            'UnitOfMeasure' => '',   // Valid Values: ["QUANTITY", "HOURS", "AMOUNT"] The unit of measure of the item being invoiced.                                                   // Unit price of the item. Range of -1,000,000 to 1,000,000.
        );

        array_push($itemArray,$item1);

    }
  
    $ordd = wc_get_order($order_id);
    
    if($ordd->get_total_refunded()>0){
      $refund_arr = array(
            'Name' => 'Refunded Total',                                // Name of the item. 200 characters max.
            'Description' => '',                                        // Description of the item. 1000 characters max.
            'Quantity' => 1,                        // Quantity of the item. Range of -10000 to 10000.
            'UnitPrice'  => array(
                                'Currency' => $woocommerce_currency,   // 3 letter currency code as defined by ISO 4217.     
                                'Value'    => '-'.$ordd->get_total_refunded()    // amount up to N digit after the decimals separator as defined in ISO 4217 for the appropriate currency code. 
                               ),                 // Unit price of the item. Range of -1,000,000 to 1,000,000.
                                          
           'Tax' => array(
                                'Name'    => '',                        // The tax name. Maximum length is 20 characters. 
                                'Percent' => '',                        // The rate of the specified tax. Valid range is from 0.001 to 99.999.                        
                             ),                                         // Tax associated with the item.
            'Date' => '',          // The date when the item or service was provided. The date format is *yyyy*-*MM*-*dd* *z* as defined in [Internet Date/Time Format](http://tools.ietf.org/html/rfc3339#section-5.6).
           'Discount' => array(
                                'Percent' => '',                        
                            ),                                         // The item discount, as a percent or an amount value.
            'UnitOfMeasure' => '',   // Valid Values: ["QUANTITY", "HOURS", "AMOUNT"] The unit of measure of the item being invoiced.                                                   // Unit price of the item. Range of -1,000,000 to 1,000,000.
        );
        
      array_push($itemArray,$refund_arr);
    }
    
    

    $finalDiscountForInvoice = array(
        'Percent' => ''                                 // The rate of the specified Discount. Valid range is from 0.001 to 99.999.                         
    );


    $paymentTerm = array(
        'TermType' => 'NET_30',                        // Valid Values: ["DUE_ON_RECEIPT", "DUE_ON_DATE_SPECIFIED", "NET_10", "NET_15", "NET_30", "NET_45", "NET_60", "NET_90", "NO_DUE_DATE"]. The terms by which the invoice payment is due.
        'DueDate'  => ''                                          // The date when the invoice payment is due. This date must be a future date. Date format is *yyyy*-*MM*-*dd* *z*, as defined in [Internet Date/Time Format](http://tools.ietf.org/html/rfc3339#section-5.6).   
    );

    $invoiceData = array(
        'Note' => '',                                             // Note to the payer. 4000 characters max.
        'Number' => '',                                           // Unique number that appears on the invoice. If left blank will be auto-incremented from the last number. 25 characters max.
        'TemplateId' => '',                                       // The template ID used for the invoice. Useful for copy functionality.   
        'Uri' => '',                                              // URI of the invoice resource.
        'MerchantMemo' => '',                                     // A private bookkeeping memo for the merchant. Maximum length is 150 characters.
        'LogoUrl'      => '',                                     // Full URL of an external image to use as the logo. Maximum length is 4000 characters.    
    );


    $requestData =array(
        'merchantInfo'            => $merchantInfo,
        'merchantPhone'           => $merchantPhone,
        'merchantAddress'         => $merchantAddress,

        'billingInfo'             => $billingInfo,
        'billingInfoPhone'        => $billingInfoPhone,
        'billingInfoAddress'      => $billingInfoAddress,

        'itemArray'               => $itemArray,
       //'finalDiscountForInvoice' => $finalDiscountForInvoice,
        'shippingInfo'            => $shippingInfo,
        'shippingInfoPhone'       => $shippingInfoPhone,
        'shippingInfoAddress'     => $shippingInfoAddress,

        'paymentTerm'             => $paymentTerm,
        //'invoiceData'             => $invoiceData
    );
    
    //echo '<pre>';
    //print_r($requestData);
    //echo '</pre>';
    
    //die('@@');
    
    

    //Create invoice
    $returnArray = $PayPal->CreateInvoice($requestData);
    
    
    
    if($returnArray['RESULT'] == 'Error'){
        
        $myArr = array(
                'reponce_data' => $returnArray,
                'status' => $returnArray['RESULT']
            );
        $myJSON = json_encode($myArr); 
        echo $myJSON;
        
    }
    
    if($returnArray['RESULT'] == 'Success'){
        
        $Invoice_id = $returnArray['INVOICE']['id']; 
        $Invoice_number = $returnArray['INVOICE']['number'];
        update_post_meta( $order_id, 'wholesaler_payment_invoice_id', $Invoice_id );
        update_post_meta( $order_id, 'wholesaler_payment_number', $Invoice_number );
        update_post_meta($order_id,'paypal_inv_status',1);
        update_post_meta($order_id,'paypal_payment_email',$or_billing['email']);
    
        $myArr = array(
                'reponce_data' => $returnArray,
                'status' => $returnArray['RESULT'],
                'invoice_id' => $Invoice_id,
                'invoice_number' => $Invoice_number,
            );
        $myJSON = json_encode($myArr); 
        echo $myJSON;
    
        //send invoice
        $PayPal = new \angelleye\PayPal\rest\invoice\InvoiceAPI($configArray);
        $returnArray = $PayPal->SendInvoice($Invoice_id);
        
        $Invoice_status = $returnArray['INVOICE']['status'];
        update_post_meta( $order_id, 'wholesaler_payment_invoice_status', $Invoice_status );
        
        update_post_meta( $order_id, 'admin_payment_option', $_POST['cus_hwspo'] );
        
        $order = wc_get_order( $order_id );
        $order->update_status( 'paypal-sent' );
       
    }
    
    
    

    
    



  
       


}

?>