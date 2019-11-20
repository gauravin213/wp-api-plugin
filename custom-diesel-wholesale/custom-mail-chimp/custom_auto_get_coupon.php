<?php

function custom_sidebar_coupon_code_widget_shortcode_fun() {
    
    if (is_user_logged_in()) {
        $user_id = get_current_user_id(); 
        $user_meta = get_userdata($user_id);
        $user_email_id = $user_meta->data->user_email;
    }else{
        $user_email_id = '';
    }


	ob_start();
	?>
	<!--auto generate coupon code-->
	
	<div class="instant-discount">
        <div class="cl-insta-disc">
            <a href="javascript:void(0)">
                <img class="coupan-desktop" src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/get-instant.jpg" alt="get instant">
                <img class="coupan-mobile" src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/get-instant-mobile.jpg" alt="get instant">
                <!--<div class="instant-a">GET $20 INSTANTLY!<span>Click Here</span></div>-->
            </a>
        <div class="get-instant-box cus_container rem-maxs">
            
            <a href="javascript://" class="coupon_close_popup">X</a>
            <div class="get-insta-padd">
                
                <?php //echo get_option('admin_email');?>
                
                <h2 class="chw-title  chw-title-lab" >Get Your<br> $10 Coupon <br> <i>Instantly !</i><br>Subscribe Now.</h2>
            
            <div class="custom_coupon_controls">
                <div class="get-instant-email">
                    <input type="email" id="coupon_email_id"  placeholder="Email Address" value="<?php echo $user_email_id;?>">
                </div>
                
                <div class="get-instant-submit">
                    <input type="button" value="Get $10 >" id="coupon_btn"/>
                </div>
            </div>
                
            
            <div id="coupon_btn_msg"></div>
            <div class="coupon-small-box"><span>Providing your email address confirms consent to receive emails from ProSource Diesel and that you have read and agree to our privacy policies.</span> </div>
            <div id="coupon_btn_loader" style="display:none;">Loading..</div>
                
        </div>
        </div> 
        
        </div>
    </div>

    
    
    <style>
    .rem-maxs{max-width:335px;}
    .cl-insta-disc > a{position:relative; z-index: 999;}
    @media(min-width:1199px){
    .instant-discount a img.coupan-desktop{max-width:30px;}
    }
        @media(max-width:767px){
        .home .front-page > .row > .col-md-12{position:static;}
        .home .front-page .home-page-discounts > .vc_col-sm-12{position:static;}
        
        }
    .coupon_btn_msg_email_used{
        padding: 20px;
        margin-top: 38px;
        font-size: 20px;
        color: #9b0a19;
        font-weight: 600;
        text-align: center;
        border: 1px dashed #9b0a19;
    }
    .coupon_btn_msg{
        padding: 20px;
        margin-top: 38px;
        font-size: 20px;
        color: #9b0a19;
        font-weight: 600;
        text-align: center;
        border: 1px dashed #9b0a19;
    }
    .coupon_btn_msg_error{
        background-color: #9b0a19;
    color: #fff;
    padding: 5px;
    margin-top: 10px;
    position: absolute;
    top: 0px;
    left: 50%; white-space: nowrap;
    transform: translate(-50% , -50%); -webkit-transform: translate(-50% , -50%);
    top: 50%;
    }
/*    #coupon_btn_msg {display:none;
    left: 0px;
    right: 0px;
    position: absolute;
    top: 0px;
    bottom: 0px;
    background: rgba(255, 255, 255, .6);
}*/
    .custom-wpc-loader{
        position: relative;
    }
    .custom-wpc-loader:before{
        content:'';
        background: rgba(255,522,522, .89);
        position: absolute;
        left: 0;
        right:0;
        top:0;
        bottom:0;
    }
    .custom-wpc-loader:after{
        content:'';
        background: url('../img/spinner-2x.gif') no-repeat center center;
        position: absolute;
        left: 0;
        right:0;
        top:0;
        bottom:0;
    }
    
    .coupon_close_popup{
        float:right !important;
        padding:10px;
            z-index: 999999;
    }
    
    
    
    /**************************/
    .coupon_btn_msg_email_used{}
    .used-small-box{position:absolute; left:40px; bottom:10px; right:10px;}
    .cl-insta-disc {background: transparent;}
    .get-instant-box .chw-title{
    text-align: center;
    font-size: 28px;
    background: rgba(255,255,255, .7);
    line-height: 28px; padding: 5px 30px;font-weight: 700;border:1px solid #212121;color: #000; margin-bottom:0px;}
    .get-insta-padd{padding:10px 8px 5px 10px;}
    .cl-insta-disc.anc-insta {outline: 0px;}
    .custom_coupon_controls{display: flex; display: -webkit-box; margin-top: 10px;}
    .get-instant-submit {margin-left:10px; margin-top: 0px;}
    #coupon_email_id{height:32px; border:1px solid #fff ;}
    .get-instant-submit #coupon_btn{text-transform: uppercase; height:32px;     padding: 0px 13px; border:1px solid #fff !important; line-height: 29px;background:#046b02;}
    .get-instant-box .chw-title span{display:block; font-size:12px; text-transform: none;line-height: 14px;}
    body .coupon_btn_msg {padding:8px 10px;margin-top: 2px;outline: 2px dashed #9b0a19; outline-offset: -8px; border: 1px solid #000;background: rgba(255,255, 255, .7);}
    body .instant-discount{top:50%; transform: translate(0, -50%); -webkit-transform: translate(0, -50%);}
    body .coupon_btn_msg_email_used{ text-align: center;
    font-size: 20px;min-width:240px;
    background: rgba(255,255,255, .7);
    line-height: 30px; padding: 15px;font-weight: 700;border:1px solid #212121;color: #000; margin-bottom:0px; margin-top:0px;    white-space: normal;
    font-size: 15px;
    line-height: 20px;
    padding-left: 5px !important;
    padding-right: 5px !important;;max-width:350px;}
    .coupon-small-box{font-size: 6px;
    background: rgba(255,255,255, .7);
    line-height: 7px;
    padding: 4px 6px;
    font-weight: 600;
    border: 0px solid #212121;
    color: #000;
    margin-bottom: 0px;
    text-align: left;
    margin-top: 12px;margin-left:auto;}
    .coupon-small-box span{ width: 301px; display:block;}
    .coupon-small-box.coupon-small2{text-align: center; margin-top:5px;}
    .get-instant-email{    width: calc(100% - 117px);}
    .instant-discount{background-image:url(https://prosourcediesel.com/wp-content/uploads/2019/09/dollor10j-1.jpg); background-repeat:no-repeat; background-size:cover;}
    .coupon_close_popup {
    position: absolute;
    top: -10px;
    right: -10px;
    background: #9b0a19;
    color: #fff !important;
    width: 20px;
    height: 20px;
    padding: 0px !important;
    text-align: center;
    font-weight: 700;
    line-height: 20px;
    border-radius: 20px;
}
.chw-title.chw-title-lab.add-coupon-h2{padding:2px 15px;font-size:27px;}
.instant-discount {
    bottom: auto;
    height: auto;
    display: flex;
    align-items: flex-start;
    display: -webkit-flex;
    align-items: -webkit-flex-start;
}
@media(min-width:992px) and (max-width:1199px){
    .get-instant-box .chw-title, body .coupon_btn_msg_email_used{font-size:20px;line-height: 22px;}
    .chw-title.chw-title-lab.add-coupon-h2{font-size:20px;line-height: 20px;}
    .coupon-small-box{margin-top:5px;}
    .get-instant-box{background-image:url(https://prosourcediesel.com/wp-content/uploads/2019/09/dollor10j-1.jpg); background-repeat:no-repeat; background-size:cover;}
}
@media(max-width:991px){
    .coupon_btn_msg_email_used{margin-top:0px !important;}
    .get-insta-padd {padding: 6px 5px 0px 6px;}
    .get-instant-box .chw-title span{font-size:10px; line-height: 12px;}
    .coupon-small-box.coupon-small2 {min-width: 200px;}
    body .coupon_btn_msg {font-size: 15px; padding: 4px 8px;outline: 1px dashed #9b0a19;}
    .get-instant-box .chw-title, body .coupon_btn_msg_email_used{font-size: 14px;line-height: 14px;padding: 3px 10px;}
    .chw-title.chw-title-lab.add-coupon-h2{font-size: 14px;line-height: 14px; padding: 3px 10px;}
    #coupon_email_id {height: 30px; line-height: 30px;}
    .get-instant-submit #coupon_btn{height:30px; line-height: 30px;}
    .coupon-small-box{margin-top:4px;}
    .coupon-small-box span {width: 245px;}
    .get-instant-email {width: calc(100% - 112px);}
    .get-instant-box{background-image:url(https://prosourcediesel.com/wp-content/uploads/2019/09/dollor10j-1.jpg); background-repeat:no-repeat; background-size:cover;}
    body .coupon_btn_msg {margin-top:1px;}
}
@media(max-width:767px){
    .get-instant-box .chw-title, body .coupon_btn_msg_email_used, html .status-publish .vc_column_container .wpb_wrapper .get-instant-box .chw-title{font-size: 12px !important;line-height: 12px; padding: 3px 10px;}
    .instant-discount a img{min-height: 150px;}
    .get-instant-box{min-height: 150px;width: 250px;}
    .get-instant-email {width: calc(100% - 103px);}
    .chw-title.chw-title-lab.add-coupon-h2, .status-publish .vc_column_container .wpb_wrapper .get-instant-box .chw-title.add-coupon-h2 {font-size: 13px !important;line-height: 13px !important;}
}
@media(max-width:575px) and (min-width:200px){
    .get-instant-box .get-insta-padd {padding: 6px 5px 0px 6px;}
    .chw-title.chw-title-lab.add-coupon-h2, .status-publish .vc_column_container .wpb_wrapper .get-instant-box .chw-title.add-coupon-h2 {font-size: 12px !important;line-height: 12px!important;}
    .coupon_btn_msg {padding: 6px !important; margin-top: 1px !important;font-size: 12px !important;}
    
}
@media(max-width:350px){
    .cl-insta-disc.anc-insta{display:flex; display:-webkit-flex;}
    .instant-discount{max-width:calc(100% - 20px);}
}
/*#chat-widget-container{bottom:0px !important; right:0px !important; display:none !important;}*/
.coupon-small-box.coupon-small2 span{white-space: nowrap;}
.coupon-small-box{font-size:6px;line-height:7px;max-width:236px; min-width:236px;position:absolute; right:0px;bottom:0px;}
.coupon-small-box span {width: 100%;}
.get-instant-box, .forpos{position:static; border:0px;}


@media(max-width:1699px) and (min-width:1500px){
    .coupon-small-box{max-width: 255px; min-width: 255px;}
}
@media(min-width:1700px){
    /*.coupon-small-box span {width: 342px;}*/
    .coupon-small-box{max-width: 280px; min-width: 280px;font-weight: 400;letter-spacing: -.6px;}
}
    </style>
    
    <script>
        jQuery(document).ready(function(){
            
            var coupon_small_msg2 = '';
            
            //Apply coupon ajax 
            jQuery.fn.coupon_btn_hide_msg = function(seconds, fadeOut){ 
             
                setTimeout(function(){ 
                    
                    jQuery('#coupon_btn_msg').fadeOut(fadeOut); 
                        
                }, seconds);
             
            }
            
            jQuery.fn.auto_apply_coupon_aj = function(email_id){ 
            
                jQuery.ajax({
                    url: '<?php echo admin_url( 'admin-ajax.php'); ?>',
                    type: "POST",
                    data: {'action': 'auto_apply_coupon_aj', 'email_id': email_id},
                    cache: false,
                    dataType: 'json',
                    /*beforeSend: function(){
                    
                    },
                    complete: function(){
                      
                    },*/
                    success: function (response) {  //alert(response[0]); 
                    
                       
                        console.log(response);
                        
                        
                        
                        
                        //response['coupon_code'] = 'Testcouponcode';
                        //response['reponce']['status'] = 'subscribed';
                        //response['reponce']['status'] = 400;
                        
                        if(response['coupon_code'] == ""){
                            
                            var html = '<div class="coupon_btn_msg_email_used">Sorry, Coupon code not available!</div>';
                                jQuery('#coupon_btn_msg').show();
                                jQuery('#coupon_btn_msg').html(html);
                                
                                jQuery('.chw-title-lab').hide();
                                jQuery('.custom_coupon_controls').hide();
                            
                        }else{
                        
                            if(response['reponce']['status'] == 400){
                            jQuery('.get-instant-box').removeClass('rem-maxs');
                                var html = '<div class="coupon_btn_msg_email_used">Looks like <br>'+email_id+'<br> is already subscribed.<br>Check out all the new items on our website.</div>';
                                jQuery('#coupon_btn_msg').show();
                                jQuery('#coupon_btn_msg').html(html);
                                jQuery('.coupon-small-box').addClass('used-small-box');
                                jQuery('.get-instant-box').addClass('forpos');
                                jQuery('.chw-title-lab').hide();
                                jQuery('.custom_coupon_controls').hide();
                                
                            }else{
                                
                                var html = '<div class="coupon_btn_msg">'+response['coupon_code']+'</div>';
                                jQuery('#coupon_btn_msg').show();
                                jQuery('#coupon_btn_msg').html(html);
                                jQuery('.chw-title-lab').show();
                                jQuery('.chw-title-lab').addClass('add-coupon-h2').html('Congratulations!<br> Here'+"'"+'s Your<br> Instant $10 <br> Coupon Code: <span>valid on orders of $50 or more.</span>');
                        
    
                                coupon_small_msg2 = '<span>One time use only. Can not be combined with other offers.</span><span>Subject to change without notice.Restrictions apply.</span>';
                                jQuery('.coupon-small-box').addClass('coupon-small2').html(coupon_small_msg2);
                                
                                
                                jQuery('.custom_coupon_controls').hide();
                                
                                
                            }
                        }
                        
                        jQuery('.cus_container').removeClass('custom_overlay');
                    
                     
                    }
                });
                
            }
            
           jQuery(document).on('click', '#coupon_btn', function(){
               
              
               var email_id = jQuery('#coupon_email_id').val(); 
               
               if(email_id == ""){
                    var html = '<div class="coupon_btn_msg_error">Empty email address.</div>';
                    jQuery('#coupon_btn_msg').show();
                    jQuery('#coupon_btn_msg').html(html);
                    jQuery(this).coupon_btn_hide_msg(3000, 600);
                }else{
                    var custom_validateEmail = validateEmail(email_id); 
            
                    if(custom_validateEmail == true){
                        jQuery('.cus_container').addClass('custom_overlay');
                        jQuery(this).auto_apply_coupon_aj(email_id);
                    }else{
                        var html = '<div class="coupon_btn_msg_error">Invailid email address.</div>';
                        jQuery('#coupon_btn_msg').show();
                        jQuery('#coupon_btn_msg').html(html);
                        jQuery(this).coupon_btn_hide_msg(3000, 600);
                    }
                }
              
           }); 
           
           
           //coupon_close_popup
           jQuery(document).on('click', '.coupon_close_popup', function(){
              jQuery('.get-instant-box').hide(100);
           });
           
           
           
           
           
            
        });
        
        
    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    }
    
    jQuery(function($){
            setInterval(function(){
                if($('body').hasClass('home'))
                {
                  if ($(window).width() < 767){
                    var gap = $('#home_page_slider').offset().top + ($('#home_page_slider').outerHeight() - $('.instant-discount').outerHeight())/2;
                    $('.instant-discount').css({'top':gap, 'transform':'none', '-webkit-transform':'none'}); 
                    
                  }else{
                    $('.instant-discount').css({'top':'50%','position':'absolute','transform': 'translate(0, -50%)', '-webkit-transform': 'translate(0, -50%)'}); 
                    
                  }
                }
    }, 1000);
    });
    </script>
	<!--auto generate coupon code-->
	<?php

    return ob_get_clean();
}

add_shortcode('custom_sidebar_coupon_code_widget_shortcode', 'custom_sidebar_coupon_code_widget_shortcode_fun');






/*
* Start: Auto apply coupon ajax function
*/
add_action( 'wp_ajax_auto_apply_coupon_aj', 'auto_apply_coupon_aj_fun');
add_action( 'wp_ajax_nopriv_auto_apply_coupon_aj', 'auto_apply_coupon_aj_fun');
function auto_apply_coupon_aj_fun(){
    
    
    $wc_emails_status = "";
    $_SESSION['auto_apply_coupon_code_check'] = '';
    $_SESSION['auto_apply_coupon_code'] = '';

    $email_id = $_POST['email_id'];
    
    $args = array(
    	'posts_per_page'   =>  1,
        'orderby'    => 'rand',
        'order'      => 'DESC',
        //'post__not_in'=> array(),
        //'post_name__note_in'=> array(),
    	'post_type'        => 'shop_coupon',
    	'post_status'      => 'publish',
    	'meta_query'    => array(
    	    'relation'      => 'AND',
    	    array(
    	        'key'       => 'usage_limit',
    	        'value'     => '1',
    	        'compare'   => '=',
    	    ),
    	    array(
    	        'key'       => 'usage_limit_per_user',
    	        'value'     => '1',
    	        'compare'   => '=',
    	    ),
    	    array(
    	        'key'       => 'usage_count',
    	        'value'     => '0',
    	        'compare'   => '=',
    	    ),
    	    array(
    	        'key'       => 'custom_auto_coupon_title',
    	        'value'     => 'INSTANT',
    	        'compare'   => '=',
    	    )
    	)
    );
    
    $query = new WP_Query( $args );
    
    $c_arr = array();
    if($query->have_posts()){
        while( $query->have_posts() ) {  $query->the_post();
            $coupon_code_title = get_the_title();
            $c_arr['coupno_title'] = $coupon_code_title;
            $c_arr['post_id'] = get_the_ID();
        }
        wp_reset_postdata();
    }
    
    
   
    
    //Mail chimp 
    include('MailChimp.php'); 

    $MailChimp = new MailChimp('91d523207b2280a32698e9f10f131050-us18');
    
    //Then, list all the mailing lists (with a get on the lists method)
    $result_list = $MailChimp->get('lists');
    foreach ($result_list['lists'] as $data) {
    
    	$list_id = $data['id']; 
    
    }
    
    //Subscribe someone to a list (with a post to the lists/{listID}/members method):
    $result_subscribed = $MailChimp->post("lists/$list_id/members", [
    				'email_address' => $email_id,
    				'status'        => 'subscribed',
    			]);
    			
    if($result_subscribed['status'] == 400){
        
        
        //Send mail using woocommerce header and footer
        /*$wc_emails = WC_Emails::instance();
        
        $subject = 'GET $10 COUPON';
        
        $message = 'Get your coupon code: '.$c_arr['coupno_title'];
        
        $from_name = 'Alvin';
        
        $from_email = get_option('admin_email'); //'alvin.quickfix@gmail.com';
        
        $to = $email_id;  //'lores.quickfix@gmail.com ';
        
        $headers = _construct_email_header( $from_name , $from_email );
        
        $message = $wc_emails->wrap_message( $subject, $message );
        
        $wc_emails->send( $to , $subject , $message , $headers );
        if($wc_emails){
            $wc_emails_status = 'SENT';
        }else{
            $wc_emails_status = 'NOT SENT';
        }*/
        //Send mail using woocommerce header and footer
        
        
        $myJSON = json_encode(array('coupon_sent_mail_status'=>$wc_emails_status, 'coupon_code'=>$c_arr['coupno_title'], 'post_id'=>$c_arr['post_id'], 'reponce'=>$result_subscribed));   
        echo $myJSON;
        $_SESSION['auto_apply_coupon_code_check'] = '';
        $_SESSION['auto_apply_coupon_code'] = '';
        
       
        
    }else if($result_subscribed['status'] == 'subscribed'){
        
        $myJSON = json_encode(array('coupon_code'=>$c_arr['coupno_title'], 'post_id'=>$c_arr['post_id'], 'reponce'=>$result_subscribed)); 
        echo $myJSON;
        $_SESSION['auto_apply_coupon_code_check'] = 1;
        $_SESSION['auto_apply_coupon_code'] = $c_arr['coupno_title'];
        
    }else{
        $myJSON = json_encode(array('coupon_code'=>'No data', 'reponce'=>'No data'));  
        echo $myJSON;
    }
    //Mail chimp 

    die();
}

function _construct_email_header ( $from_name , $from_email , $cc = array() , $bcc = array() ) {

    $headers[] = 'From: ' . $from_name  . ' <' . $from_email . '>';

    if ( is_array( $cc ) )
        foreach ( $cc as $c )
            $headers[] = 'Cc: ' . $c;

    if ( is_array( $bcc ) )
        foreach ( $bcc as $bc )
            $headers[] = 'Bcc: ' . $bc;

    $headers[] = 'Content-Type: text/html; charset=UTF-8';

    return $headers;

}



add_action( 'woocommerce_before_cart', 'bbloomer_apply_matched_coupons' );
add_action( 'woocommerce_before_checkout_form', 'bbloomer_apply_matched_coupons', 25 );

function bbloomer_apply_matched_coupons() {

global  $woocommerce;

$currency_symbol = get_woocommerce_currency_symbol();

    if ( $_SESSION['auto_apply_coupon_code_check'] ) {

        $coupon_code = $_SESSION['auto_apply_coupon_code']; 

        if ( WC()->cart->has_discount( $coupon_code ) ) return;
        WC()->cart->add_discount( $coupon_code );
        wc_print_notices();
        
        $_SESSION['auto_apply_coupon_code_check'] = '';
        $_SESSION['auto_apply_coupon_code'] = '';
       
    }

}


add_filter('wc_add_to_cart_message', 'handler_function_name', 10, 1);
function handler_function_name($message) {
    return $message;
}


function tatwerat_startSession() {
    if(!session_id()) {
        session_start();
        $_SESSION['shop_loop'] = 1;
    }
}

add_action('init', 'tatwerat_startSession', 1);


add_action( 'manage_edit-shop_coupon_columns', 'custom_shop_coupon_column_fun'); 
function custom_shop_coupon_column_fun($columns) {
    $columns['custom_coupon_used_by'] =  'Used by';
    return $columns;
}
add_action( 'manage_shop_coupon_posts_custom_column', 'custom_shop_coupon_column_val_fun', 10, 2); 
function custom_shop_coupon_column_val_fun( $column, $post_id ) { 
global $wpdb;
   switch( $column ) 
   {

        case 'custom_coupon_used_by' :
           $get_users = $wpdb->get_results("SELECT meta_value FROM ".$wpdb->prefix."postmeta WHERE meta_key='_used_by' AND post_id=".$post_id);
           
            $str=array();
            if(!empty($get_users)){
                foreach($get_users as $each_user){
                    if(is_numeric($each_user->meta_value)){
                        $user_meta = get_userdata($each_user->meta_value);
                        $str[] = $user_meta->data->user_email;
            
                    }else{
                        $str[] = $each_user->meta_value;
                    }
                }
            }
            if(!empty($str)){
               echo implode(", ",$str);
            }
            break;
            
        default :
                break;
    }

}
/*
* End: Auto apply coupon ajax function
*/