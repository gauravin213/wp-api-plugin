<?php
//return core charges
add_action( 'add_meta_boxes', 'core_charges_admin_metabox');
function core_charges_admin_metabox(){

   add_meta_box( 'core_return_charges', 'Refund Core Charges', 'core_return_charges', 'shop_order', 'side', 'low' );
    
}


function core_return_charges(){
  global $post;
  
  $order_id = $post->ID;
  
  $_suborder_product_type = get_post_meta( $post->ID, '_suborder_product_type', true);
  
?>
<div>
    
    <div>
    <?php //if($_suborder_product_type == 'simple_product' ){ ?> 
        
        <select id='suborder_items'>
            <option value=''>--select item--</option>
            <?php 
            $order = wc_get_order( $order_id ); foreach( $order->get_items() as $item_id => $item ){ 
                
            $_core_product_price = wc_get_order_item_meta( $item_id, '_core_product_price', true ); //wc_update_order_item_meta
            
                if($_core_product_price && !empty($_core_product_price)){
                ?>
                <option value='<?php echo $item_id;?>'><?php echo $product_name = $item->get_name(); ?></option>
                <?php
                }  
                
                
            }
            ?>
        </select>
        <div id="core_charges_loader" style="display:none;">Loading</div>
        <button class="button button-primary" id='core_charges_return_aj'>Submit</button>
    
    
    <?php //} ?>
    </div>
    
    
   
</div>
<?php
}




function return_core_charges_save_post( $order_id ) {
    
}
//add_action( 'save_post', 'return_core_charges_save_post', 12, 1);


add_action( 'wp_ajax_core_charges_return_aj', 'core_charges_return_aj_fun');
add_action( 'wp_ajax_nopriv_core_charges_return_aj', 'core_charges_return_aj_fun');

function core_charges_return_aj_fun(){
    
    $order_id = $_POST['order_id'];
    
    $suborder_item_id = $_POST['suborder_item_id'];
    
    $_core_product_price = wc_get_order_item_meta( $suborder_item_id, '_core_product_price', true );
     
    if($_core_product_price && !empty($_core_product_price)){
        
        
       //wc_update_order_item_meta($suborder_item_id, '_core_product_refund_status', '1');
        
       ibenic_wc_refund_order($order_id, $refund_reason = 'Core refund', $_core_product_price);
        
        $myArr = array(
            'refund_amount' => $_core_product_price,
            'order_id'=>  $order_id
        );
        
    }else{
        $myArr = array(
            'refund_amount' => 'Error',
        );
        
    }
    
    $myJSON = json_encode($myArr); 
    echo $myJSON;
    
    
    die();
}





    












function ibenic_wc_refund_order( $order_id, $refund_reason = '', $amount) {


  $args = array(
  'amount'         => $amount,
  'reason'         => $refund_reason,
  'order_id'       => $order_id,
  'line_items'     => array(),
  'refund_payment' => false
  );


//require_once(dirname(dirname(dirname(__FILE__))).'/plugins/woocommerce/includes/class-wc-order.php');
try {
        $args  = wp_parse_args( $args, $default_args );
        $order = new WC_ORDER( $args['order_id'] );


        if ( ! $order ) {
            throw new Exception( __( 'Invalid order ID.', 'woocommerce' ) );
        }

        $remaining_refund_amount = $order->get_remaining_refund_amount();
        $remaining_refund_items  = $order->get_remaining_refund_items();
        $refund_item_count       = 0;
        $refund                  = new WC_Order_Refund( $args['refund_id'] );

        if ( 0 > $args['amount'] || $args['amount'] > $remaining_refund_amount ) {
            throw new Exception( __( 'Invalid refund amount.', 'woocommerce' ) );
        }


        $refund->set_currency( $order->get_currency() );
        $refund->set_amount( $args['amount'] );
        $refund->set_parent_id( absint( $args['order_id'] ) );
        $refund->set_refunded_by( get_current_user_id() ? get_current_user_id() : 1 );
        $refund->set_prices_include_tax( $order->get_prices_include_tax() );

        if ( ! is_null( $args['reason'] ) ) {
            $refund->set_reason( $args['reason'] );
        }

        // Negative line items.
        

        $refund->update_taxes();
        $refund->calculate_totals( false );
        $refund->set_total( $args['amount'] * -1 );

        // this should remain after update_taxes(), as this will save the order, and write the current date to the db
        // so we must wait until the order is persisted to set the date.
        if ( isset( $args['date_created'] ) ) {
            $refund->set_date_created( $args['date_created'] );
        }

        /**
         * Action hook to adjust refund before save.
         *
         * @since 3.0.0
         */
        do_action( 'woocommerce_create_refund', $refund, $args );

        if ( $refund->save() ) {
            if ( $args['refund_payment'] ) {
                $result = wc_refund_payment( $order, $refund->get_amount(), $refund->get_reason() );

                if ( is_wp_error( $result ) ) {
                    $refund->delete();
                    return $result;
                }

                $refund->set_refunded_payment( true );
                $refund->save();
            }

            if ( $args['restock_items'] ) {
                wc_restock_refunded_items( $order, $args['line_items'] );
            }

            // Trigger notification emails.
            if ( ( $remaining_refund_amount - $args['amount'] ) > 0 || ( $order->has_free_item() && ( $remaining_refund_items - $refund_item_count ) > 0 ) ) {
                do_action( 'woocommerce_order_partially_refunded', $order->get_id(), $refund->get_id() );
            } else {
                do_action( 'woocommerce_order_fully_refunded', $order->get_id(), $refund->get_id() );

                $parent_status = apply_filters( 'woocommerce_order_fully_refunded_status', 'refunded', $order->get_id(), $refund->get_id() );

                if ( $parent_status ) {
                    $order->update_status( $parent_status );
                }
            }
        }

        do_action( 'woocommerce_refund_created', $refund->get_id(), $args );
        do_action( 'woocommerce_order_refunded', $order->get_id(), $refund->get_id() );
        
        
        //custom
        update_post_meta($order->get_id(), 'refund_core_charges_status','1');
        update_post_meta($order->get_id(), 'refund_id_core_charges', $refund->get_id());

    } catch ( Exception $e ) {
        if ( isset( $refund ) && is_a( $refund, 'WC_Order_Refund' ) ) {
            wp_delete_post( $refund->get_id(), true );
        }
        return new WP_Error( 'error', $e->getMessage() );
    }

return $refund;




}

























add_action('admin_menu', 'register_my_custom_submenu_page',99);
function register_my_custom_submenu_page() {
    add_submenu_page( 'woocommerce', 'Get Open Core Charges Report', 'Get Open Core Charges Report', 'manage_options', 'get-open-core-charges-report', 'my_custom_submenu_page_callback' ); 
}
function my_custom_submenu_page_callback() {

    global $wpdb;
    $_core_chagres =  'SELECT * FROM '.$wpdb->prefix.'postmeta WHERE meta_key = "_core_chagres_key"';
    $_core_chagres_results = $wpdb->get_results( $_core_chagres );

    $_core_chagres_results = sizeof($_core_chagres_results);
    
    global  $woocommerce;
    $currency_symbol = get_woocommerce_currency_symbol();


    $total_charges = 0;
    ?>  
    <style>
    table {
      border-collapse: collapse;
      width: 50%;
    }
    table, td, th {
      border: 1px solid black;
    }
    th {
      height: 50px;
    }
    </style>
    <h3>Get Open Core Charges Report</h3>

        <?php if ($_core_chagres_results == 0) { ?>

            <div>Data Not Found</div>
      
        <?php }else{ ?>

        <!---->
            <table>
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Status</th>
                <th>Charges</th>
            </tr>

            <?php //_core_chagres_key
                $args = array(
                    'posts_per_page'   => -1,
                    'orderby'          => 'date',
                    'order'            => 'DESC',
                    'post_type'        => 'shop_order',
                    'post_status'      => 'any',
                    'meta_query'       => array(
                        array(
                            'key'       => '_core_chagres_key',
                            'value'     => 1,
                            'compare'   => '=',
                        )
                    )
                );

            $query = new WP_Query( $args );

            if($query->have_posts()){

                while( $query->have_posts() ) { 
                    $query->the_post();

                    $order_id = get_the_ID();

                    /**/
                    $order = wc_get_order( $order_id );

                    foreach( $order->get_items() as $item_id => $item ){
                                
                        $product_id = $item->get_product_id(); 

                        $product_name = $item->get_name(); 

                        $meta_data = $item->get_formatted_meta_data( '' );

                        $_core_chagres_session_data = get_post_meta($order_id, '_core_chagres_session_data', true);


                        $c = 0;
                        
                        foreach ($_core_chagres_session_data[$product_id] as $key => $value) { $c++;
                            
                            $order_page_url = home_url().'/wp-admin/post.php?post='.$order_id.'&action=edit';
                        
                            $total_charges = $total_charges + $value['price'];
                        ?>
                            <tr>
                                <th><a href='<?php echo $order_page_url;?>'>#<?php echo $order_id;?></a></th>
                                <td><center><?php echo $product_name;?></center></td>
                                <td><center>
                                    <?php
                                     $refund_core_charges_status = get_post_meta($order_id, 'refund_core_charges_status', true);
                                     if($refund_core_charges_status && !empty($refund_core_charges_status)){
                                         echo 'Close';
                                     }else{
                                         echo 'Open';
                                     }
                                    ?>
                                </center></td>
                                 <td><center><?php echo $currency_symbol.$value['price'];?></center></td>
                            </tr>
                        <?php
                       }
                             
                    }
                    
                    

                    ?>
                    
                    
                    <!--<tr>
                        <th colspan="3"><b>Total:</b></th>
                        <th colspan="1"><b><?php //echo $currency_symbol.$total_charges;?></b></th>
                    </tr>-->
                  
                    
                   
                    <?php
                    
                    /**/
                }
                wp_reset_postdata();
            }
            ?>
        </table>
        <!---->
        <?php } ?>


    <?php
    
}



add_action( 'woocommerce_before_calculate_totals', 'adding_custom_price', 10, 1);
function adding_custom_price( $cart ) {


    if (is_checkout()) {

        if ( is_admin() && ! defined( 'DOING_AJAX' ) )
            return;

        if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
            return;

        $custom_addons = array();

        foreach ( $cart->get_cart() as $cart_item ) {
           
            if (!empty($cart_item['addons'])) {
               
                $product_id = $cart_item['product_id'];
                $custom_addons[$product_id] = $cart_item['addons'];
                $_SESSION['core_chagres_key'] = 1;

            }
        }

        $_SESSION['core_chagres_session_data'] = $custom_addons;

       // echo "<pre>"; print_r($_SESSION['core_chagres_session_data']); echo "</pre>"; die();
    }
}

add_action( 'woocommerce_thankyou', 'core_chagres_session_data_woocommerce_thankyou', 12, 1 );
function core_chagres_session_data_woocommerce_thankyou( $order_id ){

    if( ! $order_id ) return;

    $core_chagres_session_data = $_SESSION['core_chagres_session_data'];
    $core_chagres_key = $_SESSION['core_chagres_key'];

    if (!empty($core_chagres_session_data)) {

       /* echo "<pre>"; print_r($core_chagres_session_data); echo "</pre>";
        echo "<pre>"; print_r($core_chagres_key); echo "</pre>";*/

        update_post_meta($order_id, '_core_chagres_session_data', $core_chagres_session_data);
        update_post_meta($order_id, '_core_chagres_key', $core_chagres_key);
    }else{
        $custom_addons[] = "";
        $_SESSION['core_chagres_key'] = 0;
    }
}


add_action( 'woocommerce_refund_deleted', 'core_charges_action_woocommerce_order_refunded', 10, 2 ); 
function core_charges_action_woocommerce_order_refunded( $refund_id, $order_id ) { 
    
    $refund_id_core_charges = get_post_meta($order_id, 'refund_id_core_charges', true);
    
    if($refund_id == $refund_id_core_charges){
        update_post_meta($order_id, 'refund_core_charges_status', '0');
    }

}













