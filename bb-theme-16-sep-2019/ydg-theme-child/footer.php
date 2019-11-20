<!---->
<?php
//echo '==>'. $_SESSION['auto_apply_coupon_code_check'];


//echo '_used_by : '.$user_id =  get_post_meta(77938, '_used_by', true); echo '<br>';

/*global $wpdb;

$email_id = 'paul.quickfix@gmail.com';

$email_exists_check = email_exists( $email_id );
if($email_exists_check){
    $userbyemail = get_user_by('email', $email_id);
    $query =  'SELECT * FROM wp_postmeta WHERE meta_key = "_used_by" AND meta_value = "'.$userbyemail->ID.'"';
    $results = $wpdb->get_results( $query );
    
}else{
    $query =  'SELECT * FROM wp_postmeta WHERE meta_key = "_used_by" AND meta_value = "'.$email_id.'"';
    $results = $wpdb->get_results( $query );
}

echo '<pre>';
print_r($results);
echo '</pre>';*/


/*$message = 'Test cart';

wc_add_notice( apply_filters( 'wc_add_to_cart_message', $message) );*/


/**/
           /* $order = wc_get_order( 78172 );
            $invoice = wcpdf_get_document( 'invoice', $order, true );*/
            /**/

?>
<style>
a.added_to_cart.wc-forward {
    display: none !important;
}
</style>
<script type="text/javascript">

    jQuery(function($){

        $('.cl-insta-disc > a').click(function(){

            $(this).parent().toggleClass('anc-insta');

        $('.get-instant-box').animate({width: 'toggle'}, 'fast');

    });

});

</script>

<style>

.for-mobile{display:none;}

.for-desktop{display:block;}

@media (max-width:767px){

.for-mobile{display:block;}

.for-desktop{display:none;}

}



</style>
<section class="footer-container">
    <?php if ( is_active_sidebar( 'footer-top1' ) ) { ?>
        <?php dynamic_sidebar( 'footer-top1' ); ?>
    <?php } ?>

    <?php if ( is_active_sidebar( 'footer-top2' ) ) { ?>
        <?php dynamic_sidebar( 'footer-top2' ); ?>
    <?php } ?>
    
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
            <?php if ( is_active_sidebar( 'footer-col' ) ) { ?>
                <?php dynamic_sidebar( 'footer-col' ); ?>
            <?php } ?>
            </div>
            <div class="col-sm-2">
            <?php if ( is_active_sidebar( 'footer-col-2' ) ) { ?>
                <?php dynamic_sidebar( 'footer-col-2' ); ?>
            <?php } ?>
            </div>
            <div class="col-sm-3">
            <?php if ( is_active_sidebar( 'footer-col-3' ) ) { ?>
                <?php dynamic_sidebar( 'footer-col-3' ); ?>
            <?php } ?>
            </div>
            <div class="col-sm-3">
            <?php if ( is_active_sidebar( 'footer-col-4' ) ) { ?>
                <?php dynamic_sidebar( 'footer-col-4' ); ?>
            <?php } ?>
            </div>
        </div><!--row-->
    </div><!--container-->
    <div class="footer-copyright">
        &copy;2019 <a href="<?php echo home_url();?>">Prosource Diesel</a>
    </div><!--footer-copyright-->
</section>
<!---->
<?php
wp_footer();
//do_action( 'fl_body_close' );
//FLTheme::footer_code();
?>


<!--checkout page-->
<?php if (is_checkout()) { ?>
<script type="text/javascript">
jQuery(document).ready(function(){ 
    
        //uncheck shipping method
        
        jQuery('#ship-to-different-address-checkbox').click();
        
        
        
        
        
        //Satrt:Apply_discount
        jQuery(document).on('click', '#btn_apply_discount', function(){
            
            jQuery('#custom_discount_form').addClass('coupon_custom_overlay');
     
            var target = jQuery(this); 
            
            var custom_discount_input_val = jQuery('#custom_discount_input').val();
            
            //alert(custom_discount_input_val);
            
            jQuery('#coupon_code').val(custom_discount_input_val);
            
            jQuery('[name=apply_coupon]').click();
            
        });
        
        jQuery(document).on("keyup","#custom_discount_input",function(e){
            if(e.keyCode == 13){
                jQuery("#btn_apply_discount").click();
            }
        });
    
    
        //Open model on state selection
        jQuery.fn.get_state_code = function(target){
            
            var billing_state = target.find(":selected").val();

            if (billing_state == "CA") { //fire popup box

                jQuery('#myModal').show();

            }
        };
        
        jQuery(document).on('change', '#billing_state', function(){
            var target = jQuery(this);
            jQuery(this).get_state_code(target);
        });

        jQuery(document).on('change', '#shipping_state', function(){
            var target = jQuery(this);
            jQuery(this).get_state_code(target);
        });
        
        jQuery('.woocommerce-shipping-totals').hide();
        jQuery( document ).on( 'updated_checkout', function() { 
            
            //coupon_custom
            jQuery('#custom_discount_form').removeClass('coupon_custom_overlay');
         
            
            //checkout shippinmg total hode
            if(jQuery('.woocommerce-shipping-totals').length){
                jQuery('.woocommerce-shipping-totals').hide();
                var shipping_htm = jQuery('.woocommerce-shipping-totals').html();
                var ship_html = '<table class="padd-table">'+
                '<tfoot>'+
                '<tr class="woocommerce-shipping-totalsxx shippingxx">'+shipping_htm+'</tr>'+
                '</tfoot>'+
                '</table>';
                jQuery('.shpping-section').html(ship_html); 
            }else{
                var ship_html = "Please fill address to get Shipping Methods.";
                jQuery('.shpping-section').html(ship_html); 
            }
            
            //Open model on state selection
                var billing_state = jQuery('#billing_state').find(":selected").val();
                if (billing_state == "CA") {
                    jQuery('#myModal').show();
                }
                
                var shipping_state = jQuery('#shipping_state').find(":selected").val();
                if (shipping_state == "CA") { //fire popup box
                    jQuery('#myModal').show();
                }
        } );

    });
</script>
<?php } ?>
<!--checkout page-->



<?php if(!isset($_GET['ign_opc_pop']) && strpos($_SERVER['REQUEST_URI'], 'phone-manual-orders-do-not-delete') === false): ?>
<!-- Start of LiveChat (www.livechatinc.com) code -->
<script type="text/javascript" async>
window.__lc = window.__lc || {};
window.__lc.license = 9706795;
(function() {
var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
})();
</script>
<noscript>
<a href="https://www.livechatinc.com/chat-with/9706795/">Chat with us</a>,
powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener" target="_blank">LiveChat</a>
</noscript>
<!-- End of LiveChat code -->
<?php endif; ?>


<script>
    jQuery(document).ready(function(){
        jQuery('.search_submit').click(function(){
            var search_val = jQuery('.fl-search-input.form-control').val();
            if (search_val == 'Search') {
                jQuery('.fl-search-input.form-control').val(' ');
            }
            jQuery('.top-search-form').submit();
        });
    });
</script>
</body>
</html>
