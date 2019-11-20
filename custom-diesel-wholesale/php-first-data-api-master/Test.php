<?php

function custom_first_data_api_save_post_fun($order_id) {
    
    $get_post_type = get_post_type($order_id);
    
    if($get_post_type == 'shop_order'){
        
        $customer_user_id = $_POST['customer_user'];
    
        $get_user_role = get_user_role('wholesale_customer', $customer_user_id);
        
        if ($get_user_role) { 
            
            /**/
            //custom_first_data_api_fun($order_id, $customer_user_id);
            /**/

        }else{
           // other user
        }
        
        //die('@');
    }
}
//add_action( 'save_post', 'custom_first_data_api_save_post_fun', 12, 1);




add_action( 'wp_ajax_custom_first_data_api_save_aj_fun', 'custom_first_data_api_save_aj_fun');
add_action( 'wp_ajax_nopriv_custom_first_data_api_save_aj_fun', 'custom_first_data_api_save_aj_fun');
function custom_first_data_api_save_aj_fun(){
    
    $user_id = $_POST['user_id'];
    
    $order_id = $_POST['order_id'];
    
    $cus_hwspo = $_POST['cus_hwspo'];
    
    $fd_card_no = $_POST['fd_card_no'];
    $fd_card_no = str_replace("-","",$fd_card_no);
    
    $fd_card_exp = $_POST['fd_card_exp'];
    $fd_card_exp = str_replace("/","",$fd_card_exp);
    
    $fd_card_cvv = $_POST['fd_card_cvv'];
    
    
    
    
    $get_post_type = get_post_type($order_id);
    
    if($get_post_type == 'shop_order'){
    
        $get_user_role = get_user_role('wholesale_customer', $user_id);
        
        if ($get_user_role) { 
            
            /**/
            custom_first_data_api_fun($order_id, $user_id, $fd_card_no, $fd_card_exp, $fd_card_cvv);
            //custom_firstdata_email($order_id);
            /**/

        }else{
           // other user
            custom_first_data_api_fun($order_id, $user_id, $fd_card_no, $fd_card_exp, $fd_card_cvv);
        }
        
        
    }
    
    die();
}


function custom_firstdata_email( $order_id) {
    // load the mailer class
    $mailer = WC()->mailer();
    $order = new WC_Order( $order_id );
     
    //format the email
    $recipient = $order->get_billing_email();
    $subject = __("First Data", 'theme_name');
    $content = get_custom_firstdata_email_html( $order, $subject, $mailer );
    $headers = "Content-Type: text/html\r\n";
     
    $mailer->send( $recipient, $subject, $content, $headers); 
    
   /* $myJSON = json_encode(array($mailer)); 
    echo $myJSON;*/
}

function get_custom_firstdata_email_html( $order, $heading = false, $mailer ) {
 
    $template = 'emails/firstdata-tmp.php';
 
    return wc_get_template_html( $template, array(
        'order'         => $order,
        'email_heading' => $heading,
        'sent_to_admin' => false,
        'plain_text'    => false,
        'email'         => $mailer
    ) );
 
}

function custom_first_data_api_fun($order_id, $customer_user_id, $number, $exp, $cvv){
    
    require 'src/VinceG/FirstDataApi/FirstData.php';
    
    
    $custom_first_data_gateway_id =   get_option('custom_first_data_gateway_id');
    
    $custom_first_data_password =   get_option('custom_first_data_password');
    
    
    $firstData = new FirstData($custom_first_data_gateway_id, $custom_first_data_password, false);
    
    //$firstData = new FirstData('KC3677-71', 'RgGEO6bhG17P1btim1asgjODAZ4nA2o3', true);
    //gateway_id and password

    $order = wc_get_order( $order_id );
    
    $type = 'Visa';
    /*$number = 4000060001234562;
    $cvv = 743;
    $exp = '1020';*/
    $name = $order->get_data()['billing']['first_name'].' '.$order->get_data()['billing']['last_name'];
    $zip = $order->get_data()['billing']['postcode']; 
    $address  = $order->get_data()['billing']['address_1']; 
    $amount = $order->get_total(); 
    if($order->get_total_refunded()>0){
       $amount = $amount-$order->get_total_refunded();
    }
    
    $amount =  round($amount, 2);
    
    $data = array(
    'type' => $type,
    'number' => $number,
    'cvv' => $cvv,
    'exp' => $exp,
    'amount' => $amount,
    'name' => $name,
    'zip' => $zip,
    'address' => $address,
    );
    

    /*$myJSON = json_encode($data); 
    echo $myJSON;*/
    
    
    
    // Charge
    $firstData->setTransactionType(FirstData::TRAN_PURCHASE);
    $firstData->setCreditCardType($data['type'])
    		->setCreditCardNumber($data['number'])
    		->setCreditCardName($data['name'])
    		->setCreditCardExpiration($data['exp'])
    		->setAmount($data['amount'])
    		->setReferenceNumber($order_id)
    		->setCustomerReferenceNumber($customer_user_id);
    
    if($data['zip']) {
    	$firstData->setCreditCardZipCode($data['zip']);
    }
    
    if($data['cvv']) {
    	$firstData->setCreditCardVerification($data['cvv']);
    }
    
    if($data['address']) {
    	$firstData->setCreditCardAddress($data['address']);
    }
    
    $firstData->process();
    
    // Check
    if($firstData->isError()) {
    	// there was an error

    	$myArr = array('card_data'=>$data, 'api_respoce_data'=>'error');
        $myJSON = json_encode($myArr); 
        echo $myJSON;
        
        update_post_meta($order_id, 'wholesaler_firstdata_isError', 'error');
    
    } else {
    	// transaction passed
    	
    	$myArr = array('card_data'=>$data, 'api_respoce_data'=>'done');
        $myJSON = json_encode($myArr); 
        echo $myJSON;
        
        update_post_meta($order_id, 'wholesaler_firstdata_isError', 'transaction_passed');
    }
    

    update_post_meta($order_id, 'wholesaler_firstdata_arraydata', $firstData->getArrayResponse());
    
    update_post_meta( $order_id, 'admin_payment_option', $_POST['cus_hwspo'] );
    update_post_meta( $order_id, '_payment_method', 'Credit Card' );
    update_post_meta( $order_id, '_payment_method_title', 'Credit Card' );
    
    $order = wc_get_order( $order_id );
    $order->update_status( 'processing' );
    
}





/*
* Paypal Invoice API Settings Option Page
*/
add_action( 'admin_menu', 'custom_first_data_merchantInfo_fun' );
function custom_first_data_merchantInfo_fun() {
    $page_title = $menu_title = "First Data Merchant Info";
    $capability = "manage_options";
    $menu_slug = "first-data-merchant-info-settings-options";
    $function = "custom_first_data_merchantInfo_settings_options";
    add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
}


function custom_first_data_merchantInfo_settings_options(){

    global $woocommerce;
    $countries_obj   = new WC_Countries();

?>
<!---->
<div class="wrap">

    <form method="post" action="options.php" novalidate="novalidate">

      <?php wp_nonce_field('update-options') ?>

        <table class="form-table">

            <tbody>

            <tr>
                <td colspan="3">
                    <h1><?php echo _e('First Data API Configuration ', 'cus-spin-tool');?></h1>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="custom_first_data_gateway_id"><?php echo _e('Gateway id', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <input name="custom_first_data_gateway_id" id="custom_first_data_gateway_id" type="text" class="regular-text" value="<?php if (get_option('custom_first_data_gateway_id')) echo get_option('custom_first_data_gateway_id'); ?>">
                </td>
            
            </tr>

            <tr>
                <th scope="row">
                    <label for="custom_first_data_password"><?php echo _e('Password', 'cus-spin-tool');?></label>
                </th>
            
                <td>
                <input name="custom_first_data_password" id="custom_first_data_password" type="text" class="regular-text" value="<?php if (get_option('custom_first_data_password')) echo get_option('custom_first_data_password'); ?>">
                </td>
            
            </tr>


            </tbody>

        </table>


        <!---->
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="custom_first_data_password, custom_first_data_gateway_id" />
        <!---->

        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>

    </form>

</div>
<!---->
<?php
}
?>