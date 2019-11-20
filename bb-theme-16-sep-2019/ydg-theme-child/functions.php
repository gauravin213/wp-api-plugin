<?php

/*
* Custom child theme inc code
*/
require_once 'custom-theme-function/custom-theme-function.php';
/*
* Custom child theme inc code
*/




// Defines
define( 'YDG_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'YDG_CHILD_THEME_URL', get_stylesheet_directory_uri() );

// ClassesA
require_once 'classes/class-ydg-child-theme.php';
require_once 'classes/class-ydg-customizer.php';

// Compile SCSS
//add_action( 'customize_save_after',               'YDGChildTheme::compile_css' );
add_action( 'after_setup_theme',                  'YDGChildTheme::check_for_updates' );

// Output CSS
add_action( 'fl_head',                            'YDGChildTheme::stylesheet' );

// Output JS
// add_action( 'wp_enqueue_scripts',                 'YDGChildTheme::scripts' );

// Customizer
add_action( 'customize_register',                 'YDGCustomizer::register_customize_settings' );
add_action( 'customize_controls_enqueue_scripts', 'YDGCustomizer::customizer_settings' );
add_action( 'customize_preview_init',             'YDGCustomizer::customizer_preview' );

// Blog
add_action( 'excerpt_length',                     'YDGChildTheme::change_excerpt_length', 9999 );

// Gravity forms
// add_action( 'wp_print_styles',                    'YDGChildTheme::remove_gform_styles' );
// add_action( 'after_switch_theme',                 'YDGChildTheme::change_gform_options' );

function ydg_hide_shipping_method_based_on_shipping_class ($available_shipping_methods, $package) {
    

    foreach(WC()->cart->cart_contents as $key => $values) {
        //print_r($values['data']->get_shipping_class());
        
        if ($values['data']->get_shipping_class() == 'fedex-products') {
            foreach ($available_shipping_methods as $skey => $svalue) {
                
                 if ($svalue->method_id == 'wf_shipping_usps') {
                     unset($available_shipping_methods[$skey]);
                 }
            }
        }
        if ($values['data']->get_shipping_class() == 'usps-products') {
            foreach ($available_shipping_methods as $skey => $svalue) {
                
                 if ($svalue->method_id == 'wf_fedex_woocommerce_shipping') {
                     unset($available_shipping_methods[$skey]);
                 }
            }
        }
    }
    return $available_shipping_methods;
}
// add_filter('woocommerce_package_rates', 'ydg_hide_shipping_method_based_on_shipping_class', 10, 2);
add_action('init', 'send_tracking_number_mail');
function send_tracking_number_mail() {
    if(isset($_POST['order']) && isset($_POST['tracking']) && isset($_POST['action']) && isset($_POST['shippingdate']) && isset($_POST['carrier']) && $_POST['action'] == 'updateshipment'){
        $order = htmlspecialchars( $_POST['order'] );
        $date = htmlspecialchars( $_POST['shippingdate'] );
        $carrier = htmlspecialchars( $_POST['carrier'] );
        $tracking = htmlspecialchars( $_POST['tracking'] );
        $dateModify = $_POST['shippingdate'];
        $order = new WC_Order( $_POST['order'] );
        $to = $order->billing_email;
        $subject = 'Your Order Has Shipped';
        $body = "<p>Hello ".$order->get_billing_first_name().",</p><p>Your order was shipped on " . $dateModify . " via " . $carrier . ".</p><br><br><p>Tracking number is " . $tracking . ".</p>";
        $headers = array('Content-Type: text/html; charset=UTF-8');
         
        wp_mail( $to, $subject, $body, $headers );
    }
}

//
// add_action('init', 'filter_user_and_location');
// function filter_user_and_location() {
//     $user_ip = getenv('REMOTE_ADDR');
//     $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
//     $country = $geo["geoplugin_countryName"];
//     $city = $geo["geoplugin_city"];
//     echo var_dump($country);
//     // if(){
        
//     // }
// }
add_filter( 'wc_dynamic_pricing_table_header_text', function ( $text ) {

   if ( current_user_can( 'administrator' ) ) {
      $text = 'Admin Pricing';
   } elseif ( current_user_can( 'wholesaler' ) ) {
      $text = 'Wholesale Pricing';
   } elseif ( current_user_can( 'repair shops' ) ) {
      $text = 'Repair Shop Pricing';
   }
   
   return $text;
} );

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

add_filter('geot/cancel_query', function() {
    if( ! current_user_can( 'Administrator' ) )
      return false;
    elseif( ! current_user_can( 'Wholesaler' ) )
        return false;
    elseif( ! current_user_can( 'Repair Shops' ) )
        return false;
  
    $data = [];
        $data['city']['names']                 = [ 'en' => 'Miami'];
        $data['city']['zip']                   = '33166';
        $data['continent']['names']            = 'North America';
        $data['continent']['iso_code']         = 'NA';
        $data['country']['iso_code']           = 'US';
        $data['country']['names']              = [ 'en' => 'United States'];
        $data['state']['iso_code']             = 'FL';
        $data['state']['names']                = [ 'en' => 'Florida'];
        $data['geolocation']['latitude']       = '11.11';
        $data['geolocation']['longitude']      = '11.11';
        $data['geolocation']['accuracy_radius']= '100';
        $data['geolocation']['time_zone']      = 'UTC';
  
    return json_decode(json_encode($data)); 
});

function set_zapier_auth_key( $auth_key = false ) {
    $api_key = Zapier_Settings::get_api_key();
    // API key is the url
    if ( isset( $_SERVER[ 'REQUEST_URI' ] ) ) {
        // check if the url matches the api key
        if ( strpos( $_SERVER[ 'REQUEST_URI' ], $api_key ) ) {
            $auth_key = $api_key;
        }
    }
    return $auth_key;
}
add_filter( 'si_zapier_php_auth_user_not_set', 'set_zapier_auth_key' );

//added by glen
function update_qb_status($post_id,$post) {
         //added by glen
        global $wpdb;
        if($post->post_type=='shop_order'){
            if(trim($post->post_status)=="wc-completed" || trim($post->post_status)=="wc-pending" || trim($post->post_status)=="wc-cancelled" || trim($post->post_status)=="wc-processing"){
                $wpdb->query("UPDATE ".$wpdb->prefix."posts SET qb_sync=0 WHERE ID=".$post_id);
            }
        }
}
add_action('save_post', 'update_qb_status',10,2);

add_filter('woocommerce_package_rates','overwrite_priority_overnight_saturday',100,2);
function overwrite_priority_overnight_saturday($rates,$package) {
    global $woocommerce;
    date_default_timezone_set("America/Los_Angeles");
  
    if(date("N")==4){
       if(date("H")>=15){
          
            $priority_rate = 0;
            foreach ($rates as $k =>$rate) {
                if( $k == 'fedex:11:PRIORITY_OVERNIGHT' ) {
                    $priority_rate = $rate->get_cost();
                    $rate->set_label('FedEx Priority Overnight with Monday Delivery');
                }
                if($k=='fedex:11:STANDARD_OVERNIGHT'){
                    $rate->set_label('FedEx Standard Overnight with Monday Delivery');
                }
                if( $k == 'alg_wc_shipping:20') {
                    $newrate = $priority_rate*4;
                    $rate->set_cost($newrate);
                }
                
            }
            if($priority_rate==0){
                unset($rates['alg_wc_shipping:20']);
            }
            if( $woocommerce->cart->subtotal<100){
                unset($rates['free_shipping:10']);
            }
          
          
       }else{
        unset($rates['alg_wc_shipping:20']);
       }
    }else if(date("N")==5){
       if(date("H")<15){
          
          $priority_rate = 0;
            foreach ($rates as $k =>$rate) {
                if( $k == 'fedex:11:PRIORITY_OVERNIGHT' ) {
                    $priority_rate = $rate->get_cost();
                    $rate->set_label('FedEx Priority Overnight with Monday Delivery');
                }
                if($k=='fedex:11:STANDARD_OVERNIGHT'){
                    $rate->set_label('FedEx Standard Overnight with Monday Delivery');
                }
                if( $k == 'alg_wc_shipping:20') {
                    $newrate = $priority_rate*4;
                    $rate->set_cost($newrate);
                }
            }
            if($priority_rate==0){
                unset($rates['alg_wc_shipping:20']);
            }
            if( $woocommerce->cart->subtotal<100){
                unset($rates['free_shipping:10']);
            }
          
          
       }else{
        unset($rates['alg_wc_shipping:20']);
       }
    }else{
        unset($rates['alg_wc_shipping:20']);
    }
    
    $temp = array();
     
    foreach( $rates as $rate ) {
        $temp[] = $rate->cost;
    }
  
    array_multisort( $temp, $rates );
    
    return $rates;
}

// Remove Order Notes Field
add_filter( 'woocommerce_checkout_fields' , 'remove_order_notes' );

function remove_order_notes( $fields ) {
     unset($fields['order']['order_comments']);
     return $fields;
}

remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action('show_payment_methods','woocommerce_checkout_payment',99);

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


function exclude_category( $query ) {
    if ( ! is_admin() && $query->is_main_query() && isset($_GET['s']) && isset($_GET['post_type']) && $_GET['post_type']=='product' && !isset($_GET['ymm_search'])) {
         $get_s = $_GET['s'];
         global $wpdb;
         $get_p_ids = $wpdb->get_results("SELECT post_id FROM ".$wpdb->prefix."postmeta WHERE meta_key='search_keywords' AND meta_value LIKE '%".strtolower($get_s)."%'",ARRAY_A);
         $post_ids = array_column($get_p_ids, 'post_id');
         $query->set('post__in', $post_ids);
    }
}
add_action( 'pre_get_posts', 'exclude_category' );