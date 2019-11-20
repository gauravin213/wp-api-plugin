<?php
/*
 * Custom Register as Wholesale checkbox [May 14, 2019]
*/
function wooc_extra_register_fields() {?>
    <p class="form-row form-row-wide" id="woocommerce_my_account_page_checkbox_field" data-priority="">
        <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="woocommerce_my_account_page_checkbox" id="woocommerce_my_account_page_checkbox" value="1">
        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline"><span><?php esc_html_e('Register as wholesaler', 'woocommerce'); ?></span></label>
    </p>
    <?php
}
//add_action( 'woocommerce_register_form', 'wooc_extra_register_fields', 5 );

function wooc_save_extra_register_fields($customer_id) {
   if ( isset( $_POST['woocommerce_my_account_page_checkbox'] ) ) {
       update_user_meta( $customer_id, 'woocommerce_my_account_page_checkbox', sanitize_text_field( $_POST['woocommerce_my_account_page_checkbox'] ) );
       wp_update_user( array ('ID' => $customer_id, 'role' => 'wholesale_customer') );
   }
}
//add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' ); 

function pxln_remove_menu_items() {
    
    $user_id = get_current_user_id(); 
    $user_meta = get_userdata($user_id);
    $user_roles = $user_meta->roles;
    /*echo "<pre>";
    print_r($user_roles);
    echo "</pre>";*/
        
    if ( count($user_roles) == 1) {
           
        if ( in_array( 'wholesale_customer', $user_roles, true ) ) {
            
            global $menu;
            //an array with menus to remove (use their title)
            $restricted = array(__('Posts'),__('Links'), __('Comments'), __('Media'), __('Separator'));
            // keys of the unfolders
            unset($menu[4]);
            unset($menu[59]);
            unset($menu[99]);
            unset($menu[75]); // remove_menu_page( 'tools.php' ); 
            
            end ($menu);
            while (prev($menu)){
                $value = explode(' ',$menu[key($menu)][0]);
                if(in_array($value[0] != NULL?$value[0]:"" , $restricted)) {
                    unset($menu[key($menu)]);
                }
            }
        
        }
        
    }
}
add_action('admin_menu', 'pxln_remove_menu_items');

function add_role_filter_to_posts_query( $query ) {

    if (isset($_GET['post_type'])) {
        
        $user_id = get_current_user_id(); 
        $user_meta = get_userdata($user_id);
        $user_roles = $user_meta->roles;
        /*echo "<pre>";
        print_r($user_roles);
        echo "</pre>";*/
        if ( count($user_roles) == 1) {

            if ( in_array( 'wholesale_customer', $user_roles, true ) ) {
            $query->set( 'author__in', $user_id );
            }

        }
    
    }
}
add_action( 'pre_get_posts', 'add_role_filter_to_posts_query' );





//add new tab in my-acount page
function bbloomer_add_create_orders_endpoint() {
    add_rewrite_endpoint( 'create-orders', EP_ROOT | EP_PAGES );
}
  
add_action( 'init', 'bbloomer_add_create_orders_endpoint' );
  
  
// ------------------
// 2. Add new query var
  
function bbloomer_create_orders_query_vars( $vars ) {
    $vars[] = 'create-orders';
    return $vars;
}
  
add_filter( 'query_vars', 'bbloomer_create_orders_query_vars', 0 );
  
  
// ------------------
// 3. Insert the new endpoint into the My Account menu
  
function bbloomer_add_create_orders_link_my_account( $items ) {
    
        $user_id = get_current_user_id(); 
        $user_meta = get_userdata($user_id);
        $user_roles = $user_meta->roles;
        /*echo "<pre>";
        print_r($user_roles);
        echo "</pre>";*/
        
        if ( in_array( 'wholesale_customer', $user_roles, true ) ) {
           $items['create-orders'] = 'Create Orders';
        
        }
        
    return $items;
        
    
}
  
add_filter( 'woocommerce_account_menu_items', 'bbloomer_add_create_orders_link_my_account' );
  
  
// ------------------
// 4. Add content to the new endpoint
  
function bbloomer_create_orders_content() {
?>
<!-- <script type="text/javascript">
    window.location = "<?php //echo home_url();?>/wp-admin/post-new.php?post_type=shop_order";
</script> -->
 <a href="<?php echo home_url();?>/wp-admin/post-new.php?post_type=shop_order">Create Order</a>
<?php
}
  
add_action( 'woocommerce_account_create-orders_endpoint', 'bbloomer_create_orders_content' );
/**/
/* End [May 19, 2019] */
add_action('woocommerce_after_cart','woocommerce_output_related_products');
function woocommerce_output_related_products(){
    $args = array( 
        'posts_per_page' => 4,  
        'columns' => 4,  
        'orderby' => 'rand' 
 ); 
    woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) ); 
}
//add new tab in my-acount page


/*
 * Custom Register as Wholesale checkbox [May 14, 2019]
*/


/*
* Set Order View
*/
add_filter( "views_edit-shop_order" , 'custom_view_count', 10, 1);
function custom_view_count($views){

    global $current_screen;

    $user_id = get_current_user_id(); 
    $user_meta = get_userdata($user_id);
    $user_roles = $user_meta->roles;
    /*echo "<pre>";
    print_r($views);
    echo "</pre>";
    die();*/
        
    if ( count($user_roles) == 1) {
           
        if ( in_array( 'wholesale_customer', $user_roles, true ) ) {

            switch( $current_screen->id ) 
            {
                case 'edit-shop_order':
                    $views = wpse_30331_manipulate_views( 'shop_order', $views );
                    break;
            }

        }
    }
    
    return $views;
}

function wpse_30331_manipulate_views( $what, $views )
{

    global $user_ID, $wpdb;
    
    /*
     * This needs refining, and maybe a better method
     * e.g. Attachments have completely different counts 
     */
    $total = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'wc-pending' OR post_status = 'wc-processing' OR post_status = 'wc-on-hold' OR post_status = 'wc-completed' OR post_status = 'wc-cancelled' OR post_status = 'wc-refunded' OR post_status = 'wc-failed' ) AND (post_author = '$user_ID'  AND post_type = '$what' ) ");

    $trash = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'trash') AND (post_author = '$user_ID'  AND post_type = '$what' ) ");

    $pending = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'wc-pending') AND (post_author = '$user_ID'  AND post_type = '$what' ) ");


    $processing = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'wc-processing') AND (post_author = '$user_ID'  AND post_type = '$what' ) ");

    $on_hold = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'wc-on-hold') AND (post_author = '$user_ID'  AND post_type = '$what' ) ");

    $completed = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'wc-completed') AND (post_author = '$user_ID'  AND post_type = '$what' ) ");

    $cancelled = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'wc-cancelled') AND (post_author = '$user_ID'  AND post_type = '$what' ) ");

    $refunded = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'wc-refunded') AND (post_author = '$user_ID'  AND post_type = '$what' ) ");

    $failed = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE (post_status = 'wc-failed') AND (post_author = '$user_ID'  AND post_type = '$what' ) ");

    $views['all'] = preg_replace( '/\(.+\)/U', '('.$total.')', $views['all'] ); 

    $views['trash'] = preg_replace( '/\(.+\)/U', '('.$trash.')', $views['trash'] ); 

    $views['wc-pending'] = preg_replace( '/\(.+\)/U', '('.$pending.')', $views['wc-pending'] ); 

    $views['wc-processing'] = preg_replace( '/\(.+\)/U', '('.$processing.')', $views['wc-processing'] ); 

    $views['wc-on-hold'] = preg_replace( '/\(.+\)/U', '('.$on_hold.')', $views['wc-on-hold'] ); 

    $views['wc-completed'] = preg_replace( '/\(.+\)/U', '('.$completed.')', $views['wc-completed'] ); 

    $views['wc-cancelled'] = preg_replace( '/\(.+\)/U', '('.$cancelled.')', $views['wc-cancelled'] ); 

    $views['wc-refunded'] = preg_replace( '/\(.+\)/U', '('.$refunded.')', $views['wc-refunded'] ); 

    $views['wc-failed'] = preg_replace( '/\(.+\)/U', '('.$failed.')', $views['wc-failed'] ); 

    return $views;
}
/*
* Set Order View
*/














/*
* update whole sale price
*/
/*function salient_child_enqueue_styles() {
   wp_enqueue_script( 'cus-js1',get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ), '1.0', true );
   
    $data = array(
        'order_id' => get_the_ID(),
        'ajaxurl'=> admin_url( 'admin-ajax.php'),
        'posturl'=> admin_url( 'admin-post.php')
    );
    wp_localize_script( 'cus-js1', 'datab', $data );
}
add_action( 'admin_enqueue_scripts', 'salient_child_enqueue_styles');*/





//add_action( 'woocommerce_admin_order_data_after_order_details', 'misha_editable_order_meta_general' );
 
function misha_editable_order_meta_general( $order ){ 
$order_id = $order->id;



if(isset($_GET['post'])){
    
    //echo "==>".$_GET['post'];
    
?>
<br class="clear" />
<div style="margin-top: 31px;">
    <button id="set_whole_sale" class="button button-primary" style="display:none">Set Wholesale Customer price</button> 
    <div id="set_whole_sale_data_load" style="display:none">Loading</div>
</div>

<?php
    }

}




add_action( 'wp_ajax_set_whole_sale_data', 'ajax_function_set_whole_sale_data');
add_action( 'wp_ajax_nopriv_set_whole_sale_data', 'ajax_function_set_whole_sale_data');
function ajax_function_set_whole_sale_data(){
    
    $customer_user_id = $_POST['customer_user_id'];
    $order_id = $_POST['order_id'];
    
    $user_id = $customer_user_id;
    $user_meta = get_userdata($user_id);
    $user_roles = $user_meta->roles;
    
    $user_role = 'wholesale_customer';

    if ( in_array($user_role, $user_roles, true ) ) {
        echo 'Wholesale Customer price updated successfully';
        
        /**/
        $order = wc_get_order( $order_id ); // The WC_Order object instance
        foreach( $order->get_items() as $item_id => $item ){
            
            //echo $item->get_order_id(); echo '<br>';
            
            //echo $item->get_product_id(); 
            
            $wholesale_customer_wholesale_price = get_post_meta( $item->get_product_id() , 'wholesale_customer_wholesale_price', true ); 
            
            // A static replacement product price
            $product_quantity = (int) $item->get_quantity(); // product Quantity
    
            // The new line item price
            $new_line_item_price = $wholesale_customer_wholesale_price * $product_quantity;
            
            /**Disscount rule***/
               $wwpp_post_meta_quantity_discount_rule_mapping = get_post_meta( $item->get_product_id() , 'wwpp_post_meta_quantity_discount_rule_mapping', true ); 
    
                if(!empty($wwpp_post_meta_quantity_discount_rule_mapping)){ 
                    
                    $qty = $product_quantity;
                    
                    foreach ($wwpp_post_meta_quantity_discount_rule_mapping as $w_data) {
                       $start_qty = $w_data['start_qty']-1;
                       $end_qty = $w_data['end_qty']+1;
                       $price_type = $w_data['price_type'];
                       $wholesale_price = $w_data['wholesale_price'];
                       
                       if($price_type == 'percent-price'){  
                           
                           if($qty > $start_qty && $qty < $end_qty){
                              $disscount_price = $wholesale_price;
                              $new_line_item_price = $new_line_item_price * $wholesale_price / 100;
                           }
                           
                       }
                       
                       if($price_type == 'fixed-price'){  
                           
                            if($qty > $start_qty && $qty < $end_qty){
                                $disscount_price = $wholesale_price;
                                $new_line_item_price = $disscount_price * $product_quantity;
                            }
                       }
                       
                       
                    }
                }
            /**Disscount rule***/
    
            // Set the new price
            $item->set_subtotal( $new_line_item_price ); 
            $item->set_total( $new_line_item_price );
    
            // Make new taxes calculations
            $item->calculate_taxes();
    
            $item->save(); // Save line item data
                
            
        }
        
        // Make the calculations  for the order
        $order->calculate_totals();

        $order->save(); // Save and sync the data
        /**/
        
        
        
        
        
    }else{
        echo 'not';
    }
    die();
}


add_action( 'wp_ajax_check_whole_sale_usredata', 'ajax_function_check_whole_sale_usredata');
add_action( 'wp_ajax_nopriv_check_whole_sale_usredata', 'ajax_function_check_whole_sale_usredata');
function ajax_function_check_whole_sale_usredata(){

    $customer_user_id = $_POST['customer_user_id'];

    $user_id = $customer_user_id;
    $user_meta = get_userdata($user_id);
    $user_roles = $user_meta->roles;
    
    $user_role = 'wholesale_customer';

    if ( in_array($user_role, $user_roles, true ) ) {
         echo 1;
    }else{
        echo '0';
    }
    die();
}
/*
* update whole sale price
*/



add_action( 'add_meta_boxes', 'custom_admin_metaboxppppp');
function custom_admin_metaboxppppp(){

   add_meta_box( 'add_months_caption_txtpp', 'Set Wholesale Price', 'add_months_caption_txtpp', 'shop_order', 'side', 'high' );
    
}

function add_months_caption_txtpp(){
    
if(isset($_GET['post'])){
    
    //echo "==>".$_GET['post'];
    
?>
<div>
    <button id="set_whole_sale" class="button button-primary" style="display:none">Set Wholesale Customer price</button> 
    <div id="set_whole_sale_data_load" style="display:none">Loading</div>
</div>

<?php
    }
}


?>