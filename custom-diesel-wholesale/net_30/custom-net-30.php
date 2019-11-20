<?php
function custom_diese_save_test( $post_id ) {
    
    $get_post_type = get_post_type($post_id);
    
    if($get_post_type == 'shop_order'){
        
        $customer_user_id = $_POST['customer_user'];
    
        $get_user_role = get_user_role('wholesale_customer', $customer_user_id);
        
        if ($get_user_role) { 
            
            /**/
            //custom_net30_invoice_pdf($post_id);
            cusrom_send_mailer();
            /**/

        }else{
           // other user
        }
        
        die('@@');
    }
}
//add_action( 'save_post', 'custom_diese_save_test', 12, 1);


function sww_add_images_woocommerce_emails( $output, $order ) {
	
	// set a flag so we don't recursively call this filter
	static $run = 0;
  
	// if we've already run this filter, bail out
	if ( $run ) {
		return $output;
	}
  
	$args = array(
		'show_image'   	=> true,
		'image_size'    => array( 100, 100 ),
	);
  
	// increment our flag so we don't run again
	$run++;
  
	// if first run, give WooComm our updated table
	return $order->email_order_items_table( $args );
}
add_filter( 'woocommerce_email_order_items_table', 'sww_add_images_woocommerce_emails', 100000, 2 );

add_filter( 'woocommerce_order_item_name', 'display_product_title_as_link', 10, 2 );
function display_product_title_as_link( $item_name, $item ) {

    $_product = wc_get_product( $item['variation_id'] ? $item['variation_id'] : $item['product_id'] );

    $link = get_permalink( $_product->get_id() );

    return '<a href="'. $link .'"  rel="nofollow">'. $item_name .'</a>';
}

add_filter( 'woocommerce_order_item_thumbnail', 'custom_woocommerce_order_item_thumbnail', 10, 2 );
function custom_woocommerce_order_item_thumbnail( $image, $item ) {

    $_product = wc_get_product( $item['variation_id'] ? $item['variation_id'] : $item['product_id'] );

    $link = get_permalink( $_product->get_id() );
    
    
    /**/
    /*$to = "gaurav.clagtech@gmail.com";
    $subject = "Test";
    $txt = '<a href="'. $link .'"  rel="nofollow">'. $image .'</a>';
    $headers = "From: miller.clagtech@gmail.com";;
    $result = mail($to,$subject,$txt,$headers);*/
    /**/

    return '<a href="'. $link .'"  rel="nofollow">'. $image .'</a>';
    
}





add_action( 'wp_ajax_custom_net_30_aj_action', 'custom_net_30_aj_action_fun');
add_action( 'wp_ajax_nopriv_custom_net_30_aj_action', 'custom_net_30_aj_action_fun');


function custom_net_30_aj_action_fun(){

    $user_id = $_POST['user_id'];

    $order_id = $_POST['order_id'];

    $cus_hwspo = $_POST['cus_hwspo'];

    $net_30_ref_no = $_POST['net_30_ref_no'];


    $get_post_type = get_post_type($order_id);
    
    if($get_post_type == 'shop_order'){
    
        $get_user_role = get_user_role('wholesale_customer', $user_id);
        
        if ($get_user_role) { 

            $wholesaler_net_30_ref_no = get_post_meta( $order_id, 'wholesaler_net_30_ref_no', true);

            $wholesaler_net_30_ref_no = '';

            if ($wholesaler_net_30_ref_no && !empty($wholesaler_net_30_ref_no)) {
                
                $myArr = array(
                    'status' => 'done',
                    'net_30_ref_no' => $wholesaler_net_30_ref_no,
                );
                $myJSON = json_encode($myArr); 
                echo $myJSON;

            }else{
                custom_net30_invoice_pdf($order_id);
                custom_net_30_invoice_email($order_id, $net_30_ref_no);
            }
        }else{
           // other user
        }
    }
    die();
}


function custom_net_30_invoice_email( $order_id, $net_30_ref_no) {
    // load the mailer class
    $mailer = WC()->mailer();
    $order = new WC_Order( $order_id );
     
    //format the email
    $recipient = $order->get_billing_email();
    $subject = __("Net 30 Invoice", 'theme_name');
    $content = get_custom_email_html( $order, $subject, $mailer );
    $headers = "Content-Type: text/html\r\n";
     
    //send the email through wordpress
    $net30_invoice_pdf_name = get_post_meta($order_id, 'net30_invoice_pdf_name', true);
    $attachments = array(WP_CONTENT_DIR . '/uploads/net30-pdf/'.$net30_invoice_pdf_name);
    
    
    $mailer->send( $recipient, $subject, $content, $headers, $attachments);  


    $myArr = array($or_billing,$or_shipping,$itemArray,$net_30_ref_no);
    $myJSON = json_encode($myArr); 
    echo $myJSON;

    update_post_meta( $order_id, 'wholesaler_net_30_ref_no', $net_30_ref_no);
    
    update_post_meta( $order_id, 'admin_payment_option', $_POST['cus_hwspo'] );
    update_post_meta( $order_id, '_payment_method', 'Net 30' );
    update_post_meta( $order_id, '_payment_method_title', 'Net 30' );
    
    $order = wc_get_order( $order_id );
    $order->update_status( 'processing' );
}


function get_custom_email_html( $order, $heading = false, $mailer ) {
 
    $template = 'emails/net30-invoice.php';
 
    return wc_get_template_html( $template, array(
        'order'         => $order,
        'email_heading' => $heading,
        'sent_to_admin' => false,
        'plain_text'    => false,
        'email'         => $mailer
    ) );
 
}