<?php
/* 
Plugin Name: Custom Diesel Wholesale
Description: This is custom custom diesel plugin
Version: 0.0.1
Author: dev
*/

define( 'CUS_VERSION', '1.0.0' );
define( 'CUS_URI', plugin_dir_url( __FILE__ ) );

//custom_diese

function custom_diesel_wp_enqueue_scripts(){
    
    wp_enqueue_style( 'ppcuston-order-css', CUS_URI.'assets/css/custon-order.css', array(), '1.0', 'all' );
    wp_enqueue_script( 'custon-order-js', CUS_URI.'assets/js/custon-order.js', array( 'jquery' ), '1.0', false );
    wp_enqueue_script( 'custon-jquery-mask-js', CUS_URI.'assets/js/jquery.mask.js', array( 'jquery' ), '1.0', false );

    $data = array(
        'post_id' => get_the_ID(),
        'order_id' => get_the_ID(),
        'ajaxurl'=> admin_url( 'admin-ajax.php'),
        'posturl'=> admin_url( 'admin-post.php'),
        'display_name'=> get_post_type(get_the_ID()),
    );
    wp_localize_script( 'custon-order-js', 'objData', $data );
    
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_style( 'thickbox' );
    
}
add_action( 'admin_enqueue_scripts', 'custom_diesel_wp_enqueue_scripts' );

/*
* include files
*/
require_once 'inc/custom-useradd.php';
require_once 'inc/set-wholesale-price-by-order-save.php';
require_once 'inc/custom-order-column-info.php';
require_once 'inc/woo-custom-product-tab.php';
require_once 'paypal-invoice-api/paypal-invoice-api.php';
require_once 'net_30/custom-net-30.php';
require_once 'php-first-data-api-master/Test.php';


require_once 'inc/split_order_core_product2.php';
require_once 'fedex-api/Rate/RateWebServiceClient.php';
require_once 'inc/custom-core-product-order-list.php'; 

require_once 'custom-mail-chimp/custom_auto_get_coupon.php';

/*
* Start:wholesaler Payment Option
*/
add_action( 'wp_ajax_get_wholesale_payment_option_ac', 'get_wholesale_payment_option_ac_fun');
add_action( 'wp_ajax_nopriv_get_wholesale_payment_option_ac', 'get_wholesale_payment_option_ac_fun');
function get_wholesale_payment_option_ac_fun(){
    
    $user_id = $_POST['user_id'];
    $order_id = $_POST['order_id'];
    $user_meta = get_userdata($user_id);
    $user_roles = $user_meta->roles;

    /*if ( in_array( 'wholesale_customer', $user_roles, true ) ) {*/

        //$user_payment_option = get_user_meta( $user_id, 'custom_wholesaler_payment_option', true );
        
        $custom_wholesaler_payment_option = get_user_meta( $user_id, 'custom_wholesaler_payment_option', true );
        
        $user_paypal_id = get_user_meta( $user_id, 'opt_paypal_id', true );
        
        $user_payment_option = get_post_meta( $order_id, 'admin_payment_option', true );
        
        $opt_paypal_id = get_post_meta( $order_id, 'paypal_payment_email', true );
        
        if($opt_paypal_id==''){
		   $opt_paypal_id = get_user_meta( $user_id, 'opt_paypal_id', true );
		}
		
        if ($user_payment_option && !empty($user_payment_option)) {


            if ($user_payment_option == 'paypal') {

                
                $invoice_id = get_post_meta( $order_id, 'wholesaler_payment_invoice_id', true ); 
                $invoice_number = get_post_meta( $order_id, 'wholesaler_payment_number', true );
                $invoice_status = get_post_meta( $order_id, 'wholesaler_payment_invoice_status', true );


                $myArr = array(
                        'target_action' => $user_payment_option,
                        'paypal_id' => $opt_paypal_id,
                        'user_paypal_id' => $user_paypal_id,
                        'invoice_id' => $invoice_id,
                        'invoice_number' => $invoice_number,
                        'invoice_status' => $invoice_status,
                    );
                
            }

            if ($user_payment_option == 'credit_card') {

                /*$opt_cart_number = get_user_meta( $user_id, 'opt_cart_number', true );
                $opt_expiration_mm_yy = get_user_meta( $user_id, 'opt_expiration_mm_yy', true );
                $opt_cart_security_code = get_user_meta( $user_id, 'opt_cart_security_code', true );*/
                
                $wholesaler_firstdata_isError = get_post_meta($order_id, 'wholesaler_firstdata_isError', true);
                $wholesaler_firstdata_arraydata = get_post_meta($order_id, 'wholesaler_firstdata_arraydata', true);

                $myArr = array(
                        'target_action' => $user_payment_option,
                        'wholesaler_firstdata_isError' => $wholesaler_firstdata_isError,
                        'wholesaler_firstdata_arraydata' => $wholesaler_firstdata_arraydata,
                    );
                
            }

            if ($user_payment_option == 'net_30') {

                $order = wc_get_order( $order_id );
                $get_status = $order->get_status();
                
                
                $net30_invoice_number = get_post_meta( $order_id, 'net30_invoice_number', true ); 
                $net30_invoice_pdf_name = get_post_meta( $order_id, 'net30_invoice_pdf_name', true );
                $pdf_path = home_url().'/wp-content/uploads/net30-pdf/'.$net30_invoice_pdf_name;
                $view_pdf_path = home_url().'/wp-content/plugins/custom-diesel-wholesale/view-pdf.php';
                
                if($net30_invoice_number && !empty($net30_invoice_number)){
                    
                    $net30_invoice_number = sprintf("%04d", $net30_invoice_number);
                     
                    $myArr = array(
                        'target_action' => $user_payment_option,
                        'net30_invoice_number' => $net30_invoice_number,
                        'net30_invoice_pdf_name' => $net30_invoice_pdf_name,
                        'pdf_path' => $pdf_path,
                        'view_pdf_path' => $view_pdf_path,
                        'order_status' => $get_status,
                    );
                    
                }else{
                    $myArr = array(
                        'target_action' => $user_payment_option,
                        'net30_invoice_number' => 0,
                        'net30_invoice_pdf_name' => 0,
                        'pdf_path' => 0,
                        'view_pdf_path' => 0,
                        'order_status' => 0,
                    );
                }
                
                   
            }
            
            

        }else{
            
            $get_user_role = get_user_role('wholesale_customer', $user_id);
            
            $myArr = array(
                'target_action' => 'no_payment_option',
                'custom_wholesaler_payment_option' => $custom_wholesaler_payment_option,
                'user_role' => $get_user_role,
                'user_paypal_id' => $user_paypal_id
            );
        }

    /*}else{
       
        $myArr = array(
                        'target_action' => 'customer',
                    );
    }*/



        

        $myJSON = json_encode($myArr); 

        echo $myJSON;

    die;
}
/*
* End:wholesaler Payment Option
*/




/*
* Start:Net 30 Invoice pdf
*/
function custom_net30_invoice_pdf($order_id){

    require_once 'mpdf/mpdf-development/vendor/autoload.php';

    global $wpdb;

    $net30_invoice_number = get_post_meta($order_id, 'net30_invoice_number', true);

    if ($net30_invoice_number && !empty($net30_invoice_number)) {

        $next_no = $net30_invoice_number;

        //echo "next_no mt : ".$next_no;
       
    }else{

        $query =  'SELECT * FROM '.$wpdb->prefix.'postmeta WHERE meta_key = "net30_invoice_number" ';
        $results = $wpdb->get_results( $query );
        $count = sizeof($results); 

        if ($count == 0) {
          $next_no = 1;
        }else{
          $next_no = $count+1;
        }

        //echo "next_no : ".$next_no;
    }

    

    
    $pdf_name = 'Test-'.$next_no.'.pdf';

    update_post_meta($order_id, 'net30_invoice_number', $next_no);
    update_post_meta($order_id, 'net30_invoice_pdf_name', $pdf_name);
    


    $uploadDir = wp_upload_dir();
    $uploadDir['basedir'];

    $location = $uploadDir['basedir'].'/net30-pdf/'.$pdf_name;

    //$location = __DIR__ . '/upload/'.$pdf_name;

    $mpdf = new \Mpdf\Mpdf();

    $path = CUS_URI.'mpdf/';

    //html content
    $mailer = WC()->mailer();
    $order = new WC_Order( $order_id );
    $recipient = $order->get_billing_email();
    $subject = __("Net 30 Invoice", 'theme_name');
    $content = get_custom_email_pdf_html( $order, $subject, $mailer );
    //html content
    
    
    /**/
  /*  
    $img_path = CUS_URI.'assets/img/logo.png';
    
    $order = new WC_Order( $order_id );
    $billing_address = $order->get_formatted_billing_address(); // for printing or displaying on web page
    $shipping_address = $order->get_formatted_shipping_address();
    
    if($shipping_address == ""){
        $shipping_address = $billing_address;
    }
    $email = $order->billing_email;
    $name = $order->billing_first_name.' '.$order->billing_last_name;
    $billing_phone = $order->billing_phone;
    $date = date('M d, Y');

    $data   = '';
    
    
    
    //style
    $data   .= "
    <style type='text/css'>
    .pd-logo-con{
    	text-align: center;
    }
    .pd-logo{
    	width: 200px;
    }
    .pd-footer{
        text-align: center;
    }
    </style>
    ";
    
     $next_no = sprintf("%04d", $next_no);
    
    //header
    $data   .= "<div class='pd-logo-con'><img src='".$img_path."' class='pd-logo'></div>";
    
    $data   .= "<div style='background-color: #9b0919;padding: 10px;color: #fff;margin-top: 5px;'>Net 30 Invoice</div>";
     
     
    $data   .= "<table border='0' cellpadding='0' cellspacing='0' width='600'><tbody><tr>
    <td valign='top' style='background-color:#fdfdfd'>
    <table border='0' cellpadding='20' cellspacing='0' width='100%'>
    <tbody>
    <tr>
    <td valign='top' style='padding:48px'>
    <div style='color:#737373;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left'>
    <span>
    <p style='margin:0 0 16px'><strong>Invoice No. :</strong> ".$next_no."</p>
    </span>
    <h2 style='color:#557da1;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left'>
    Order # $order_id ( $date )
    </h2>
    <div>
    <div>";
    if( sizeof( $order->get_items() ) > 0 ) {           
        $data   .=    "<table cellspacing='0' cellpadding='6' style='width:100%;border:1px solid #eee' border='1'>
        <thead>
        <tr>
        <th scope='col' style='text-align:left;border:1px solid #eee;padding:12px'>
        Product
        </th>
        <th scope='col' style='text-align:left;border:1px solid #eee;padding:12px'>
        Quantity
        </th>
        <th scope='col' style='text-align:left;border:1px solid #eee;padding:12px'>
        Price
        </th>
        </tr>
        </thead>
        <tbody>";
        $data   .= $order->email_order_items_table( false, true );            
        $data   .=  "</tbody><tfoot>";
        if ( $totals = $order->get_order_item_totals() ) {
            $i = 0;
            foreach ( $totals as $total ) {
            $i++;
            $label =    $total['label'];
            $value = $total['value'];
            $data .= "<tr>
            <th scope='row' colspan='2' style='text-align:left; border: 1px solid #eee;'>$label</th>
            <td style='text-align:left; border: 1px solid #eee;'>$value</td>
            </tr>";
            }
        }
        $data .= "</tfoot></table>";
    }

    $data .=        
    "<span>
    <h2 style='color:#557da1;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left'>
    Customer details
    </h2>
    <p style='margin:0 0 16px'>
    <strong>Email:</strong>
    <a href='mailto:' target='_blank'>
    $email
    </a>
    </p>
    <p style='margin:0 0 16px'>
    <strong>Tel:</strong>
    $billing_phone
    </p>
    <table cellspacing='0' cellpadding='0' style='width:100%;vertical-align:top' border='0'>
    <tbody>
    <tr>
    <td valign='top' width='50%' style='padding:12px'>
    <h3 style='color:#557da1;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:16px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left'>Billing address</h3>
    <p style='margin:0 0 16px'> $billing_address </p>
    </td>
    <td valign='top' width='50%' style='padding:12px'>
    <h3 style='color:#557da1;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:16px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left'>Shipping address</h3>
    <p style='margin:0 0 16px'> $shipping_address </p>
    </td>
    </tr>
    </tbody>
    </table>
    </span>
    </div>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>";
    
    
    //footer
    $data   .= "<div class='pd-footer'>Diesel Truck Parts Direct</div>";*/
    /**/

    $mpdf->SetDisplayMode('fullpage');
    $stylesheet = file_get_contents($path.'css/style.css');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($content);
    //$mpdf->Output();

    $mpdf->Output($location, \Mpdf\Output\Destination::FILE);
    //die();

}


function get_custom_email_pdf_html( $order, $heading = false, $mailer ) {
 
    $template = 'emails/net30-invoice-dpf.php';
 
    return wc_get_template_html( $template, array(
        'order'         => $order,
        'email_heading' => $heading,
        'sent_to_admin' => false,
        'plain_text'    => false,
        'email'         => $mailer
    ) );
 
}


function custom_diesel_wholesale_activate() {

    $uploadDir = wp_upload_dir();
    if (!is_dir($uploadDir['basedir'].'/net30-pdf')){

        mkdir($uploadDir['basedir'].'/net30-pdf', 0777) or wp_send_json_error();

    }
}
register_activation_hook( __FILE__, 'custom_diesel_wholesale_activate' );
/*
* End:Net 30 Invoice pdf
*/










