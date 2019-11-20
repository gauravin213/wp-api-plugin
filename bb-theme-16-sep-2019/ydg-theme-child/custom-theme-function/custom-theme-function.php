<?php
/*
* StartIincludes custom files
*/
require_once 'inc/custom-woo-brand-select-box.php';
require_once 'shortcode/custom-testing-code.php';
require_once 'shortcode/custom-get-product-by-category-slug.php';
require_once 'shortcode/custom-get-category-by-slug.php';
require_once 'shortcode/custom-customer-review-template.php';
require_once 'shortcode/custom-countdown-timer.php';
require_once 'shortcode/custom-diesel-social-links.php';
//require_once 'shortcode/custom_auto_get_coupon.php';  
require_once 'shortcode/custom-brand-list.php';
require_once 'shortcode/custom-home-page-banner.php';
require_once 'inc/custom-diesel-settings-options.php';
/*
* End:Includes custom files
*/


remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10);
add_action('woocommerce_before_subcategory_title', 'category_thunbnail_woocommerce_subcategory_thumbnail', 10, 1);
function category_thunbnail_woocommerce_subcategory_thumbnail($category){
    
    
    $cat_term_id = $category->term_id;
    
    $product_img = '';
    
    //Get Top salling Product
    $args = array(
    'posts_per_page'   => 1,
    'meta_key' => 'total_sales',
    'orderby' => 'meta_value_num',
    'order'            => 'DESC',
    'post_type'        => 'product',
    'post_status'      => 'publish',
    /*'meta_query'    => array(
            array(
                'key'       => 'total_sales',
                'value'     => '0',
                'compare'   => '!=',
            )
        ),*/
    'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $cat_term_id,
                'operator' => 'IN'
            )
        )
    );
    $query = new WP_Query( $args );
    if($query->have_posts()){

        while( $query->have_posts() ) { 
            $query->the_post();
            
            $product_id = get_the_ID(); 
            
            //echo 'total_sales :: '. get_post_meta( $product_id, 'total_sales', true).' ---- '.$product_id;
            
            $get_post_thumbnail_id = get_post_thumbnail_id($product_id);
    
            if (!empty($get_post_thumbnail_id)) {
                $image_attributes_thumbnail = wp_get_attachment_image_src($get_post_thumbnail_id, 'medium');
            }
            
            $product_img = $image_attributes_thumbnail[0];
            
        }

        wp_reset_postdata();

    }else{
        //echo 'Not In post';
    }
    
    
    
    //exclude category from top selling product
    //all brands, ford, chevy, doge, heavy duty
    $get_term_data = get_term($cat_term_id);
    if($get_term_data->parent == 15732 || $get_term_data->parent == 44 || $get_term_data->parent == 45 || $get_term_data->parent == 46){ 
         $product_img = "";
    }
    
  
    if($product_img!=""){

        echo "<div class='product-image pp11'><img src='{$product_img}' alt='' width='762' height='365' /></div>";
        
    }else{
        
        //Get subcategory thumbnail 
        $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
        
        if($thumbnail_id){
            $image = wp_get_attachment_url( $thumbnail_id ); 
            echo "<div class='product-image pp22'><img src='{$image}' alt='' width='762' height='365' /></div>";
        }else{
            
            $image = wp_get_attachment_url( 37070 ); 
            echo "<div class='product-image pp33'><img src='{$image}' alt='' width='762' height='365' /></div>";
        }
        
    }

}





/*
* Start:Add meta box for inner pages
*/
/*add_action( 'add_meta_boxes', 'custom_custom_inner_page_advertisement_admin_metabox');
function custom_custom_inner_page_advertisement_admin_metabox(){

   add_meta_box( 'inner_page_advertisement_admin_metabox_fun', 'Advertisement Header', 'inner_page_advertisement_admin_metabox_fun', 'page', 'normal', 'high' );
    
}


function inner_page_advertisement_admin_metabox_fun(){
    global $post;
    $inner_page_ad_url = get_post_meta( $post->ID, 'inner_page_ad_url', true );
    $inner_page_ad_script = get_post_meta( $post->ID, 'inner_page_ad_script', true );
    ?>
    <div>
         <label>URL</label>
    <input type="text" name="inner_page_ad_url" id="inner_page_ad_url" value="<?php echo $inner_page_ad_url;?>" style="width:100%">
    </div>
   
    <div>
        <label>Script</label>
    <textarea rows="10" cols="91" name="inner_page_ad_script" id="inner_page_ad_script"><?php echo $inner_page_ad_script;?></textarea>
    </div>
    
    <?php 
}


function destination_save_metabox( $post_id, $post ) {
    
    //cus_woo_tab_technical_doc
    if (isset( $_POST['inner_page_ad_url'] ) ) {
        update_post_meta( $post->ID, 'inner_page_ad_url', $_POST['inner_page_ad_url'] );
    }

    if (isset( $_POST['inner_page_ad_script'] ) ) {
        update_post_meta( $post->ID, 'inner_page_ad_script', $_POST['inner_page_ad_script'] );
    }

}
add_action( 'save_post', 'destination_save_metabox', 1, 2 );*/
/*
* End:Add meta box for inner pages
*/




/*
* Start:New Layout scripts
*/
function bb_child_enqueue_styles() {
    wp_enqueue_style('new-layout-animate', get_stylesheet_directory_uri() . '/css/animate.css', array(), '1.0', 'all' );
    wp_enqueue_style('new-layout-carousel', get_stylesheet_directory_uri() . '/css/owl.carousel.min.css', array(), '1.0', 'all' );
    
    
    wp_enqueue_style('new-layout-style', get_stylesheet_directory_uri() . '/css/style.css', array(), '1.0', 'all' );
    
    //wp_enqueue_style('new-layout-skin-custom.css', get_stylesheet_directory_uri() . '/css/skin-custom.css', array(), '1.0', 'all' );
    
    
    
    
    
    
    wp_enqueue_script( 'new-layout-js-wow',get_stylesheet_directory_uri() . '/js/wow.min.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'new-layout-js-carousel',get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'new-masonry-js',get_stylesheet_directory_uri() . '/js/masonry.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'new-layout-js-custom',get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ), '1.0', true );
    
    
    //Normal woo search
    $product_search_args = '';
    if(  isset($_GET['s']) && isset($_GET['post_type'])  ){ //ymm_search
        if($_GET['post_type'] == 'product'){
            $product_search_args = $_GET['s'];
        }
    }
    //mdy advance search
    if(isset($_GET['ymm_search'])){
        if($_GET['ymm_search'] == 1){
            $product_search_args = 1;
        }
    }


    $child_data = array(
        'product_id' => get_the_ID(),
        'ajaxurl'=> admin_url( 'admin-ajax.php'),
        'posturl'=> admin_url( 'admin-post.php'),
        'product_search_args'=>$product_search_args
    );
    wp_localize_script( 'new-layout-js-custom', 'child_data', $child_data );
    
    //flipclock style
    wp_enqueue_style('flipclock-style', get_stylesheet_directory_uri() . '/css/flipclock.css', array(), '1.0', 'all' );
    wp_enqueue_script( 'flipclock-js',get_stylesheet_directory_uri() . '/js/flipclock.js', array( 'jquery' ), '1.0', true );
    
    wp_dequeue_script( 'wc-password-strength-meter' );
    
}
add_action( 'wp_enqueue_scripts', 'bb_child_enqueue_styles');
/*
* End:New Layout scripts
*/




/*
* Start:Reginster extra footer nav menu
*/
function wpmm_setup() {

    register_nav_menus( array(
        'custom_footer_menu2' => 'Custom Footer Menu2'
    ) );
}
add_action( 'after_setup_theme', 'wpmm_setup' );
/*
* End:Reginster extra footer nav menu
*/




/*
* Start:Reginster sidebar 
*/
add_action( 'widgets_init', 'theme_slug_widgets_init' );
function theme_slug_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Cart Widget', 'your_text_domain' ),
        'id' => 'cart-header',
        'description' => __( 'Your Description', 'your_text_domain' ),
    ) );
    
    register_sidebar( array(
        'name' => __( 'Footer top one', 'your_text_domain' ),
        'id' => 'footer-top1',
        'description' => __( 'Your Description', 'your_text_domain' ),
    ) );
    
    register_sidebar( array(
        'name' => __( 'Footer top two', 'your_text_domain' ),
        'id' => 'footer-top2',
        'description' => __( 'Your Description', 'your_text_domain' ),
    ) );
    
    register_sidebar( array(
        'name' => __( 'Shop page sidebar', 'your_text_domain' ),
        'id' => 'shop-page-sidebar',
        'description' => __( 'Your Description', 'your_text_domain' ),
    ) );
    
    register_sidebar( array(
        'name'          => 'Custom Deisel Brand Widget',
        'id'            => 'custom-deisel-brand-widget',
        'before_widget' => '<div class="chw-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="chw-title">',
        'after_title'   => '</h2>',
    ) );
    
    
    register_sidebar( array(
        'name'          => 'Custom Deisel Top Rated Product Widget',
        'id'            => 'custom-deisel-top-rated-produc-widget'
    ) );
    
    register_sidebar( array(
        'name'          => 'Custom Deisel Advance Search Widget',
        'id'            => 'custom-deisel-advance-search-widget'
    ) );
}
/*
* End:Reginster sidebar 
*/




/*
* Start:Woocommerce Checkout Page
*/
function custom_woocommerce_get_terms_and_conditions_checkbox_text($text){

	$newtext = "I've read and accept the";
	
	$link = '<a href="'.home_url().'/terms/" class="woocommerce-terms-and-conditions-link woocommerce-terms-and-conditions-link--closed" target="_blank">terms and conditions</a>';
	$link2 = '<a href="'.home_url().'/terms/" target="_blank">terms and conditions</a>';
	return $newtext." ".$link2;

}
add_filter( 'woocommerce_get_terms_and_conditions_checkbox_text', 'custom_woocommerce_get_terms_and_conditions_checkbox_text', 1, 1);
/*
* End:Woocommerce Checkout Page
*/




/*
* Start:Woocommerce shop page
*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'custom_woocommerce_template_loop_product_thumbnail', 10);
function custom_woocommerce_template_loop_product_thumbnail(){
    
    $get_post_thumbnail_id = get_post_thumbnail_id();
            
    if(!empty($get_post_thumbnail_id)){
         $image_attributes_thumbnail = wp_get_attachment_image_src( $get_post_thumbnail_id, 'medium' );
    }else{
         $image_attributes_thumbnail = wp_get_attachment_image_src( 37069 , 'medium' ); //37069 37070
    }
    
    echo '<span class="custom_deisel_thumbnail">';
    //echo woocommerce_get_product_thumbnail();
    echo '<img src="'.$image_attributes_thumbnail[0].'">';
    echo '</span>';
   
}
/*
* End:Woocommerce shop page
*/





/*
* Start:Woocommerce product page
*/

add_action( 'woocommerce_after_add_to_cart_form', 'custom_social_woocommerce_before_add_to_cart_button', 30 );
function custom_social_woocommerce_before_add_to_cart_button(){
    ?>
    
    <section class="cmp-product-social california_rule65">
        <div>
        <img src="<?php echo home_url().'/wp-content/themes/ydg-theme-child/images/alert-a2.png'?>">
        California Residents: Prop 65 Warning<br/>
        <strong>WARNING: Cancer and Reproductive Harm</strong><br/>
        Visit: <a href="www.p65warnings.ca.gov">www.p65warnings.ca.gov</a>
    </div>
    </section>

    <section class="cmp-product-social">
    
        
    <div class="cmp-product-social__cell">
        SHARE
    </div>
    <div class="cmp-product-social__cell">
        <a  href="<?php if (get_option('diesel_social_media_facebook')) echo get_option('diesel_social_media_facebook'); ?>" data-u="" title="Facebook" target="_blank">
            <i class="fa fa-facebook" aria-hidden="true"></i>
        </a>
    </div>
    <div class="cmp-product-social__cell">
        <a  href="<?php if (get_option('diesel_social_media_twitter')) echo get_option('diesel_social_media_twitter'); ?>" title="Twitter" target="_blank">
            <i class="fa fa-twitter" aria-hidden="true"></i>
        </a>
    </div>
    <div class="cmp-product-social__cell">
        <a  href="<?php if (get_option('diesel_social_media_printerest')) echo get_option('diesel_social_media_printerest'); ?>"  title="Pinterest" target="_blank">
            <i class="fa fa-pinterest-p" aria-hidden="true"></i>
        </a>
    </div>
    <div class="cmp-product-social__cell">
        <a href="<?php if (get_option('diesel_social_media_gmail')) echo get_option('diesel_social_media_gmail'); ?>" title="Email a Friend">
            <i class="fa fa-envelope-o" aria-hidden="true"></i>
        </a>
    </div>
</section>
    <?php
}

/*add_action( 'woocommerce_single_product_summary', 'california_rule_65_fun', 35 );
function california_rule_65_fun(){
    
    ?>


    <?php
    
}*/




remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 5);

add_action( 'woocommerce_single_product_summary', 'custom_add_sku_after_title', 5);
function custom_add_sku_after_title(){
    global $product;
    $product_sku = $product->get_sku();
    ?>
    <div class="sku-name"><span>SKU:</span> <?php echo $product_sku;?></div>
    <?php
}



//add_action('woocommerce_single_product_summary', 'ppp_woocommerce_template_single_title', 20);
function ppp_woocommerce_template_single_title(){
    
    global $product;
    
    $product_stock_status = $product->get_stock_status();
    
    if( $product_stock_status !='outofstock'){ //instock, outofstock
    
       ?>
        <div class="product-counter">
            <div class="header-offer">
                <div class="subs-offer" style='color:#fff;'>
                    <div class="subs-left">Order Placed in</div>
                </div>
                <span class="count-down-box"><?php echo do_shortcode('[custom_countdown_timer_shortcode]'); ?></span>
                <div class="subs-offer" style='color:#fff;'>
                    <div class="subs-left" id="order_shipping_time"></div>
                </div>
            </div>
        </div>
        <?php
    }
}



add_filter( 'woocommerce_product_tabs', 'custom_unset_product_tab' );
function custom_unset_product_tab( $tabs ) {
    
    foreach($tabs as $key=> $value){ 
        
        if($key == "ymm"){
            
            unset( $tabs['ymm'] ); 
        }
        
        if($key == "ebay_item_compatibility_list"){
            
            $tabs['ebay_item_compatibility_list']['title'] = "";
    
            $tabs['ebay_item_compatibility_list']['title'] = " Vehicle Fitment";
        }
        
    }
    
    return $tabs;
}

/*
* End:Woocommerce product page
*/






/*
* Start:Woocommerce cart page
*/
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
/*
* Start:Woocommerce cart page
*/





/*
*Start:user
*/
function check_custom_authentication ( $username ) {
    
   
    $redirect_to = $_REQUEST['redirect_to'];   //echo '<br>';
    
    if(isset($redirect_to)){  
        
    	wp_redirect($redirect_to);
        exit;
        
    }
    
    return $username;
    
    /*else{
        
        $userinfo = get_user_by( 'login', $username );

    	if($userinfo)
    	{
    	  
    	   	if ( in_array( 'wholesale_customer', $userinfo->roles, true ) ) { 
    	   	    
    	   	    //echo 'wholesale_customer__';
    	   	    
    	   	    $url = home_url().'/wholesale-ordering';
               	wp_redirect($url);
                exit;
            }else if(in_array( 'customer', $userinfo->roles, true )){
                $url = home_url().'/my-account';
               	wp_redirect($url);
                exit;
            }
    	   	
    	   	
    	}
        
    }
    
	return $username;*/
}
add_action( 'wp_login' , 'check_custom_authentication' );



function redirect_sample() {

    if (is_page(36763)) {
        
        $user_id = get_current_user_id(); 
        $user_meta = get_userdata($user_id);
        $user_roles = $user_meta->roles;
    
        if ( !in_array( 'wholesale_customer', $user_roles, true ) ) { //echo '11';
            wp_redirect( home_url(), 301 ); exit;
        }
        
      
    }

}
add_action( 'template_redirect', 'redirect_sample' );
/*
*End:user
*/


/*
* Start:Woocommerce account page
*/
function bbloomer_add_premium_support_link_my_account( $items ) {
   /* $items['diesel_wholesale_menu'] = 'My Courses';
    return $items;*/
    
     $my_items = array(
        'diesel_wholesale_menu' => __( 'Wholesale Ordering', 'my_plugin' ),
    );

    $my_items = array_slice( $items, 0, 6, true ) + $my_items + array_slice( $items, 6, count( $items ), true );

    return $my_items;
}
add_filter( 'woocommerce_account_menu_items', 'bbloomer_add_premium_support_link_my_account', 20);
/*
* End:Woocommerce account page
*/




add_action('woocommerce_before_subcategory_title', 'hide_grid_list_button_from_category_page');
function hide_grid_list_button_from_category_page($category){
    if ($_SESSION['shop_loop'] == 1) {
       //echo "string".$category->term_id;
       $_SESSION['shop_loop'] = 0;
       ?>
       <style>
       .berocket_lgv_widget {
            display: none !important;
        }
       </style>
       <?php
    }
}

//remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title');




/**
 * Hide category product count in product archives
 */
add_filter( 'woocommerce_subcategory_count_html', '__return_false' );




//Set default country
add_filter( 'default_checkout_billing_country', 'change_default_checkout_country' );
//add_filter( 'default_checkout_billing_state', 'change_default_checkout_state' );

function change_default_checkout_country() {
  return 'US'; // country code
}

/*function change_default_checkout_state() {
  return 'XX'; // state code
}*/




?>