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
        <div class="get-instant-box cus_container">
            
            <a href="javascript://" class="coupon_close_popup">X</a>
            
            <div class="get-insta-padd">
                
            <h2 class="chw-title  chw-title-lab" >Enter Your Email Address</h2>
            
            <div class="get-instant-email">
                <input type="email" id="coupon_email_id"  placeholder="Email Address" value="<?php echo $user_email_id;?>">
            </div>
            
            <div class="get-instant-submit">
                <input type="button" value="Submit" id="coupon_btn"/>
            </div>
            
            <div id="coupon_btn_msg"></div>
            <div id="coupon_btn_loader" style="display:none;">Loading..</div>
                
        </div>
        </div>
        
        </div>
    </div>

    
    
    <style>
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
    }
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
    }
    </style>
    
    <script>
        jQuery(document).ready(function(){
            
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
                    beforeSend: function(){
                    },
                    complete: function(){
                    },
                    success: function (response) {  //alert(response[0]); 
                    
                       
                        
                        console.log(response);
                        
                        if(response == ""){
                            
                            var html = '<div class="coupon_btn_msg_email_used">Sorry, Coupon code not available!</div>';
                                jQuery('#coupon_btn_msg').show();
                                jQuery('#coupon_btn_msg').html(html);
                                jQuery('.get-instant-email').hide();
                                jQuery('.get-instant-submit').hide();
                                jQuery('.chw-title-lab').hide();
                            
                        }else{
                            
                            if(response == "this_email_used"){
                                
                                var html = '<div class="coupon_btn_msg_email_used">Looks like '+email_id+' is already subscribed.<br>Check out all the new items on our website.</div>';
                                jQuery('#coupon_btn_msg').show();
                                jQuery('#coupon_btn_msg').html(html);
                                jQuery('.get-instant-email').hide();
                                jQuery('.get-instant-submit').hide();
                                jQuery('.chw-title-lab').hide();
                                
                            }else{
                                
                               
                                var html = '<div class="coupon_btn_msg">COUPON CODE "'+response[0]+'".</div>';
                                jQuery('#coupon_btn_msg').show();
                                jQuery('#coupon_btn_msg').html(html);
                               
                                
                                jQuery('.chw-title-lab').show();
                                jQuery('.chw-title-lab').text(' thank you for contacting us');
                                jQuery('.get-instant-email').hide();
                                jQuery('.get-instant-submit').hide();
                                
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
    </script>
    <!--auto generate coupon code-->
    <?php

    return ob_get_clean();
}

add_shortcode('custom_sidebar_coupon_code_widget_shortcode', 'custom_sidebar_coupon_code_widget_shortcode_fun');