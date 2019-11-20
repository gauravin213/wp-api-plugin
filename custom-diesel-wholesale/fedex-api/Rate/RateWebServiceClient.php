<?php

add_action( 'add_meta_boxes', 'custom_admin_shipping_rate_add_meta_boxes');
function custom_admin_shipping_rate_add_meta_boxes(){
    add_meta_box( 'custom_admin_shipping_rate', 'Shipping Rate', 'custom_admin_shipping_rate', 'shop_order', 'side', 'low' );
}

function custom_admin_shipping_rate(){
    global $post;
    
    //$add_months_caption_txt = get_post_meta( $post->ID, 'add_months_caption_txt', true );

    ?>
    <style>
        #custom_shipping_rate td {
        border-bottom: 1px solid;
        padding-bottom: 5px;
        }
    </style>
    <span class='shipping-rate-error1'></span>
    <div id="custom_shipping_rate" class="custom_shipping_rate custom-wpc-loader">
    </div>
    <?php
}



add_action( 'wp_ajax_custom_admin_add_shipping_rate', 'custom_admin_add_shipping_rate_fun');
add_action( 'wp_ajax_nopriv_custom_admin_add_shipping_rate', 'custom_admin_add_shipping_rate_fun');
function custom_admin_add_shipping_rate_fun(){
    
    $order_id = $_POST['order_id'];
    $user_id = $_POST['user_id'];
    $shipping_method_id = $_POST['shipping_method_id'];
    $shipping_method_title = $_POST['shipping_method_title'];
    $shipping_rate_vl = $_POST['shipping_rate_vl'];


    $calculate_tax_for = array(
        'country' => 'US',
        'state' => 'CA', 
        'postcode' => '10001',
        'city' => 'NY', 
    );
    $item = new WC_Order_Item_Shipping();
    $item->set_method_title( $shipping_method_title );
    $item->set_method_id( $shipping_method_id ); 
    $item->set_total( $shipping_rate_vl ); 
    //$item->calculate_taxes($calculate_tax_for);
    
    $order = wc_get_order( $order_id ); 
    $order->add_item( $item );
    $order->calculate_totals();
    //$order->update_status('on-hold');
    $order->save();
    
    $myArr = array(
        'reponce_data' => 'done',
        'shipping_rate' => $shipping_rate_vl,
    );
    
    $myJSON = json_encode($myArr); 
    echo $myJSON;

    die();
    
}



add_action( 'wp_ajax_custom_get_shipping_rate_aj', 'custom_get_shipping_rate_aj_fun');
add_action( 'wp_ajax_nopriv_custom_get_shipping_rate_aj', 'custom_get_shipping_rate_aj_fun');

function custom_get_shipping_rate_aj_fun(){
    
    $order_id = $_POST['order_id'];
    
    $shipping_data_arr = array();
        
    $order = wc_get_order($order_id);

    //Iterating through order shipping items
    foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ){
        
        $shipping_data_arr[] = array(
        'order_item_name'             => $shipping_item_obj->get_name(),
        'order_item_type'             => $shipping_item_obj->get_type(),
        'shipping_method_title'       => $shipping_item_obj->get_method_title(),
        'shipping_method_id'          => $shipping_item_obj->get_method_id(),
        'shipping_method_instance_id' => $shipping_item_obj->get_instance_id(),
        'shipping_method_total'       => $shipping_item_obj->get_total(),
        'shipping_method_total_tax'   => $shipping_item_obj->get_total_tax(),
        'shipping_method_taxes'       => $shipping_item_obj->get_taxes()
        );
    }
    
    $count = sizeof($shipping_data_arr);
    if($count!=0){
        //echo 'filled';
        $myArr = array(
                'reponce_data' => 'Shipping rate applied',
                'htm_data'=>'filled'
            );
        $myJSON = json_encode($myArr); 
        echo $myJSON;
            
    }else{
        //echo 'zero';
        custom_fedex_api_rate_service_fun($order_id);
       
    }
    die();
    
}


function custom_fedex_api_rate_service_save_post_fun( $order_id ) {
    
    $get_post_type = get_post_type($order_id);
    
    if($get_post_type == 'shop_order'){
        
     
    }
}
//add_action( 'save_post', 'custom_fedex_api_rate_service_save_post_fun', 12, 1);


function custom_fedex_api_rate_service_fun($order_id){
    
    
    $path = CUS_URI.'fedex-api/Rate';
    
    $packageLineItem = array();
    
    $order = wc_get_order( $order_id );
    $billing_address = $order->get_data()['billing'];
    $shipping_address = $order->get_data()['shipping'];
    
    $total = $order->get_total();
    
    $or_items = $order->get_items();
    $woocommerce_currency = get_woocommerce_currency();


    foreach( $or_items as $item_id => $item ){
        
        $product_id =  $item->get_product_id();
       
        $product =  $item->get_product(); 
       
        // Get Product Dimensions
        $weight = $product->get_weight();
        $length = $product->get_length();
        $width = $product->get_width();
        $height =  $product->get_height();
        $dimensions = $product->get_dimensions();
        
        $packageLineItem[] = array(
    		'SequenceNumber'=>1,
    		'GroupPackageCount'=>1,
    		'Weight' => array(
    			'Value' => $weight,
    			'Units' => 'LB'
    		),
    		'Dimensions' => array(
    			'Length' => $length,
    			'Width' => $width,
    			'Height' => $height,
    			'Units' => 'IN'
    		)
    	);
	
    }
    
    
    
    
	require_once('fedex-common.php5');

	$path_to_wsdl = $path.'/RateService_v16.wsdl';

	ini_set("soap.wsdl_cache_enabled", "0");
	 
	$opts = array(
		  'ssl' => array('verify_peer' => false, 'verify_peer_name' => false)
		);
	$client = new SoapClient($path_to_wsdl, array('trace' => 1,'stream_context' => stream_context_create($opts)));  

	$request['WebAuthenticationDetail'] = array(
		'UserCredential' => array(
			'Key' => 'VQX7nDHZbPwi1nLg', 
			'Password' => 'y9FOBtmfJrSjU0OXoEh8dIbmt', 
		)
	); 
	$request['ClientDetail'] = array(
		'AccountNumber' => '578539581',
		'MeterNumber' => '112537509',
	);
	$request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request using PHP ***');
	$request['Version'] = array(
		'ServiceId' => 'crs', 
		'Major' => '16', 
		'Intermediate' => '0', 
		'Minor' => '0'
	);
	$request['RequestedShipment']['DropoffType'] = 'REGULAR_PICKUP'; 
	$request['RequestedShipment']['ShipTimestamp'] = date('c');
	$request['RequestedShipment']['PackagingType'] = 'YOUR_PACKAGING'; 

	$request['RequestedShipment']['Shipper'] = array
                (
                    'Address' => array
                        (
                            'StreetLines' => array('4747 Central Way'),
                			'City' => 'Fairfield',
                			'StateOrProvinceCode' => 'CA',
                		    'PostalCode' => '94534',
                            'CountryCode' => 'US'
                        ),

                );
	$request['RequestedShipment']['Recipient'] = array
                (
                    'Address' => array
                        (
                            'StreetLines' => array
                                (
                                    '0'             => (!empty($shipping_address['address_1']))? $shipping_address['address_1']: $billing_address['address_1'],
                                    '1'             => (!empty($shipping_address['address_2']))? $shipping_address['address_2']: $billing_address['address_2'],
                                ),

                            'Residential'           => '',
                            'PostalCode'            => (!empty($shipping_address['postcode']))? $shipping_address['postcode']: $billing_address['postcode'],
                            'City'                  => (!empty($shipping_address['city']))? $shipping_address['city']: $billing_address['city'],
                            'StateOrProvinceCode'   =>  (!empty($shipping_address['state']))? $shipping_address['state']: $billing_address['state'],
                            'CountryCode' =>  (!empty($shipping_address['country']))? $shipping_address['country']: $billing_address['country'],
                        )

                );
	$request['RequestedShipment']['ShippingChargesPayment'] = array
                (
                    'PaymentType' => 'SENDER',
                    'Payor' => array
                        (
                            'ResponsibleParty' => array
                                (
                                    'AccountNumber' => '578539581',
                                    'CountryCode' => 'US'
                                ),

                        ),

                );
	$request['RequestedShipment']['RateRequestTypes'] = 'NONE';
	$request['RequestedShipment']['PackageCount'] = '1';
	$request['RequestedShipment']['RequestedPackageLineItems'] = $packageLineItem;
              
              
              
    try {
    	    
		if(setEndpoint('changeEndpoint')){
			$newLocation = $client->__setLocation(setEndpoint('endpoint'));
		}
		
		$response = $client -> getRates($request);
	        
	    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){  	
	    	$rateReplys = $response -> RateReplyDetails;


	       $rateReplys_sort = array();


	        $htm = '';
	        $htm .='<table style="margin-bottom: 10px;">';
	        $htm .= '<tr><td><b>Service Type</b></td><td><b>Amount</b></td></tr>';
	        
	        
	        //free shipping
			if($total > 100){
		       $htm .= '<tr><td><input data-shipping_method_id="free_shipping" data-shipping_method_title="Free Shipping (3-5 Business Days)" type="radio" name="admin_shipping_rates" id="admin_shipping_rates" value="0">Free Shipping (3-5 Business Days)</td><td>$0</td></tr>';
		    }
	

		    foreach ($rateReplys as $rateReply) {

		    	$htm1 = '';
		    	
		    	$htm1 .= '<tr>';

				$serviceType = $rateReply -> ServiceType;
				
				$serviceType = str_replace("_"," ", $serviceType);
				
				
				$serviceType_method_id = $rateReply -> ServiceType;
				$serviceType_method_title = $serviceType;
				
					
		    	if($rateReply->RatedShipmentDetails && is_array($rateReply->RatedShipmentDetails)){
		    	    
		    	    $amount2 = number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",");

		    	   $amount = '<td>$' . number_format($rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",") . '</td>';
				}elseif($rateReply->RatedShipmentDetails && ! is_array($rateReply->RatedShipmentDetails)){
					$amount = '<td>$' . number_format($rateReply->RatedShipmentDetails->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",") . '</td>';
					
					$amount2 = number_format($rateReply->RatedShipmentDetails->ShipmentRateDetail->TotalNetCharge->Amount,2,".",",");
		
					
				}
		        if(array_key_exists('DeliveryTimestamp',$rateReply)){
		        	$deliveryDate= '<td>' . $rateReply->DeliveryTimestamp . '</td>';
		        }else if(array_key_exists('TransitTime',$rateReply)){
		        	$deliveryDate= '<td>' . $rateReply->TransitTime . '</td>';
		        }else {
		        	//$deliveryDate='<td>&nbsp;</td>';
		        }
		        
		        
		        $htm1 .= '<td><input data-shipping_method_id="'.$serviceType_method_id.'" data-shipping_method_title="'.$serviceType_method_title.'"  type="radio" name="admin_shipping_rates" id="admin_shipping_rates" value="'.$amount2.'">'.$serviceType .'</td>'. $amount. $deliveryDate;
		        
		        $htm1 .= '</tr>';


		        $rateReplys_sort[$amount2] = $htm1;
			}
			
		
		     
		     
		     
		        

			ksort($rateReplys_sort);
			$htm.= implode('',$rateReplys_sort);
	    	
	        $htm .= '</table>';
	        
	        $htm .= '<button class="button button-primary" id="btn_get_shipping_rate_js">Submit</button>';
	        
	        

	        $myArr = array(
                'reponce_data' => $response,
                'htm_data'=>$htm,
                'ordet_total'=>$total
            );
    
	    }else{
	   
	        $myArr = array(
                'reponce_data' => $response,
                'htm_data'=>''
            );
	    } 
	    
	    
	//writeToLog($client);
	
	} catch (SoapFault $exception) {
  
	   $myArr = array(
            'reponce_data' => $exception,
            'htm_data'=>$htm
        );
	}

    $myJSON = json_encode($myArr); 
    echo $myJSON;


}




?>