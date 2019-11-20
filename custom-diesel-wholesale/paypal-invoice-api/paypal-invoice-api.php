<?php
/*
* Custom Paypal Invoice API 
*/

require_once 'paypal-invoice-api-args.php';
require_once 'paypal-invoice-api-settings.php';


add_action( 'wp_ajax_get_state_list_of_country', 'get_state_list_of_country_fun');
add_action( 'wp_ajax_nopriv_get_state_list_of_country', 'get_state_list_of_country_fun');
function get_state_list_of_country_fun(){

    global $woocommerce;
    $countries_obj   = new WC_Countries();
    $country_code = $_POST['country_code'];
    $default_county_states = $countries_obj->get_states( $country_code );
    
    ?>
     <?php foreach ($default_county_states as $key => $value) { ?>
        <option value="<?php echo $key;?>" <?php echo selected(get_option('diesel_pi_state'), $key);?> ><?php echo $value;?></option>
    <?php } ?>
    <?php 

    die();

}



add_action( 'add_meta_boxes', 'custom_add_meta_boxes_paypal_invoice');
function custom_add_meta_boxes_paypal_invoice(){
    add_meta_box( 'cus_paypal_invoice', 'Payment Options', 'cus_paypal_invoice', 'shop_order', 'side', 'low' );
}

function cus_paypal_invoice(){
    global $post;
    
    //$add_months_caption_txt = get_post_meta( $post->ID, 'add_months_caption_txt', true );

    ?>
    <div id="cus_wholesale_payment_option" class="form-field form-field-wide custom-wpc-loader">
    </div>
    
    
    <!--First Data API-->
    <div id="modal-window-id-firstdata" style="display:none;">
        
        <style>
        .cus-f-data {
            max-width: 50%;
            margin: auto;
        }
        </style>
        
        <div class='cus-f-data'>
        <?php
        
        $order_id = $post->ID;
        
        $wholesaler_firstdata_isError = get_post_meta($order_id, 'wholesaler_firstdata_isError', true);
    
        $wholesaler_firstdata_arraydata = get_post_meta($order_id, 'wholesaler_firstdata_arraydata', true);
        
        if($wholesaler_firstdata_arraydata && !empty($wholesaler_firstdata_arraydata)){
            
            
            echo '<pre>';
            print_r($wholesaler_firstdata_arraydata->ctr);
            //echo '<br><br><br>';
            //print_r($wholesaler_firstdata_arraydata);
            echo '</pre>';
            
            
            
        }else{
            echo 'No data';
        }
        ?>
        </div>
        
        
        
   
    </div>
    <!--First Data API-->
    
    
    
    <?php
}




add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { ?>

        <?php
            $user_id = $_GET['user_id']; 
            $user_meta = get_userdata($user_id);
            $user_roles = $user_meta->roles;
        ?>
    
        <?php if (in_array( 'wholesale_customer', $user_roles, true ) ) { ?>
          
           <h3><?php _e("Wholesaler Payment Option", "blank"); ?></h3>
    
            <?php
            $payment_opt = get_the_author_meta( 'custom_wholesaler_payment_option', $user->ID );


           

            $opt_cart_number = get_the_author_meta( 'opt_cart_number', $user->ID );

            $opt_expiration_mm_yy = get_the_author_meta( 'opt_expiration_mm_yy', $user->ID );

            $opt_cart_security_code = get_the_author_meta( 'opt_cart_security_code', $user->ID );

           
            ?>
        
            <table class="form-table">
            <tr>
                <th>
                    <label for="custom_wholesaler_payment_option"><?php _e("Select Payment"); ?></label>
                </th>
                <td>
                    <select class="regular-text" name="custom_wholesaler_payment_option" id="custom_wholesaler_payment_option">
                        <option value="" <?php echo selected($payment_opt, '')?>>--select--</option>
                        <option value="net_30" <?php echo selected($payment_opt, 'net_30')?>>Net 30</option>
                       <!-- <option value="paypal" <?php //echo selected($payment_opt, 'paypal')?>>Paypal</option>
                        <option value="credit_card" <?php// echo selected($payment_opt, 'credit_card')?>>Credit Card</option>-->
                    </select></br>
                    <span class="description"><?php _e("Please enter your custom_wholesaler_payment_option."); ?></span>
                </td>
            </tr>


            <tr class="credit_card_details" style="display: none;">
                <th>
                    <label for="custom_wholesaler_payment_option"><?php _e("Cart number"); ?></label>
                </th>
                <td>
                   <input type="text" class="simple-field-data-mask-selectonfocus" data-mask="00-0000-0000" data-mask-selectonfocus="true" name="opt_cart_number" id="opt_cart_number" value="<?php  if ($opt_cart_number) { echo $opt_cart_number;} ?>">
                </td>
            </tr>

            <tr class="credit_card_details" style="display: none;">
                <th>
                    <label for="custom_wholesaler_payment_option"><?php _e("Expiration (MM/YY)"); ?></label>
                </th>
                <td>
                   <input type="text" name="opt_expiration_mm_yy" id="opt_expiration_mm_yy" value="<?php  if ($opt_expiration_mm_yy) { echo $opt_expiration_mm_yy;} ?>">
                </td>
            </tr class="credit_card_details">

             <tr class="credit_card_details" style="display: none;">
                <th>
                    <label for="custom_wholesaler_payment_option"><?php _e("Card Security Code"); ?></label>
                </th>
                <td>
                   <input type="text" name="opt_cart_security_code" id="opt_cart_security_code" value="<?php  if ($opt_cart_security_code) { echo $opt_cart_security_code;} ?>">
                </td>
            </tr>
        
        
            </table>


            <script type="text/javascript">
                jQuery(document).ready(function(){

                jQuery('#opt_cart_number').mask('0000-0000-0000-0000');

                jQuery('#opt_expiration_mm_yy').mask('00/00');

                jQuery('#opt_cart_security_code').mask('000');



                    jQuery.fn.check_payment_option = function(selected_val){ //alert(selected_val);

                        if (selected_val == 'paypal') {

                            jQuery('.opt_paypal_id').show();
                            //jQuery('.credit_card_details').hide();

                        }else if(selected_val == 'credit_card'){

                            jQuery('.opt_paypal_id').hide();
                            //jQuery('.credit_card_details').show();

                        }else if(selected_val == 'net_30'){

                            jQuery('.opt_paypal_id').hide();
                            //jQuery('.credit_card_details').hide();

                        }else{
                            jQuery('.opt_paypal_id').hide();
                            //jQuery('.credit_card_details').hide();
                        }

                    }

                    var selected_val = jQuery('#custom_wholesaler_payment_option').find('option:selected').val();

                    jQuery(this).check_payment_option(selected_val);

                    jQuery(document).on('change', '#custom_wholesaler_payment_option', function(){

                        var target = jQuery(this);

                        var selected_val = target.find('option:selected').val();

                        jQuery(this).check_payment_option(selected_val);


                    });

                });
            </script>
    
    
        <?php } ?> 
        
        
        
            <?php
             $opt_paypal_id = get_the_author_meta( 'opt_paypal_id', $user->ID );
            ?>
            <table class="form-table">
            <tr>
                <th>
                    <label for="custom_wholesaler_payment_option"><?php _e("Paypal Email ID"); ?></label>
                </th>
                <td>
                   <input type="text" name="opt_paypal_id" value="<?php  if ($opt_paypal_id) { echo $opt_paypal_id;} ?>">
                </td>
            </tr>
            </tr>
            </table>
        

<?php }


add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
       return false; 
    }
    update_user_meta( $user_id, 'custom_wholesaler_payment_option', $_POST['custom_wholesaler_payment_option'] );



    if (isset($_POST['opt_paypal_id'])) {

         update_user_meta( $user_id, 'opt_paypal_id', $_POST['opt_paypal_id'] );
       
    }

    if (isset($_POST['opt_cart_number'])) {

         update_user_meta( $user_id, 'opt_cart_number', $_POST['opt_cart_number'] );
       
    }

    if (isset($_POST['opt_expiration_mm_yy'])) {

         update_user_meta( $user_id, 'opt_expiration_mm_yy', $_POST['opt_expiration_mm_yy'] );
       
    }

    if (isset($_POST['opt_cart_security_code'])) {

         update_user_meta( $user_id, 'opt_cart_security_code', $_POST['opt_cart_security_code'] );
       
    }

}
/*
* End:custom user meta fields
*/




//add_action( 'woocommerce_admin_order_data_after_billing_address', 'misha_editable_order_meta_general', 200);
function misha_editable_order_meta_general( $order ){ 
$order_id = $order->id;
?>

<div id="custom_paypal_email_id" class="custom-wpc-loader">
</div>

<?php
}



//Add Custom Status
add_action( 'init', 'custom_paypal_api_register_my_new_order_statuses' );

function custom_paypal_api_register_my_new_order_statuses() {

	
    register_post_status( 'wc-paypal-sent', array(
        'label'                     => _x( 'Paypal Invoice Sent', 'Order status', 'woocommerce' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Paypal Invoice Sent <span class="count">(%s)</span>', 'Paypal Invoice Sent<span class="count">(%s)</span>', 'woocommerce' )
    ) );
}

add_filter( 'wc_order_statuses', 'custom_paypal_api_my_new_wc_order_statuses' );

// Register in wc_order_statuses.
function custom_paypal_api_my_new_wc_order_statuses( $order_statuses ) {

	
    $order_statuses['wc-paypal-sent'] = _x( 'Paypal Invoice Sent', 'Order status', 'woocommerce' );
    return $order_statuses;
}