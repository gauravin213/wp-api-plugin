<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php //do_action( 'fl_head_open' ); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php// echo apply_filters( 'fl_theme_viewport', "<meta name='viewport' content='width=device-width, initial-scale=1.0' />\n" ); 
?>
<?php //echo apply_filters( 'fl_theme_xua_compatible', "<meta http-equiv='X-UA-Compatible' content='IE=edge' />\n" ); 
?>
<link rel="profile" href="https://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php //FLTheme::title(); ?>
<?php //FLTheme::favicon(); ?>
<?php //FLTheme::fonts(); ?>
<!--[if lt IE 9]>
	<script src="<?php //echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
	<script src="<?php //echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
<![endif]-->
<?php

wp_head();

/*FLTheme::head();
date_default_timezone_set("America/Los_Angeles");*/

?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--New Layout--> 

<link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:200,300,400,500,600,700,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Racing+Sans+One" rel="stylesheet">
<!--New Layout-->


<script type="text/javascript">
jQuery.fn.manage_view = function(){
    if (jQuery(window).width() <= 767) {  
        console.log('mobile');
        jQuery( "#header_register" ).insertBefore( ".user-reg-mobile" );
        jQuery( "#home_page_slider" ).insertAfter( ".mobile-slider" );
        
        jQuery( "#custom_brand_lits_top" ).insertAfter( ".brand-list-mobile-view" );
        jQuery(document).on('click', '.brand_event_0, .brand_event_1, .brand_event_2', function(e){
            e.preventDefault();
            //alert('Stop redirection');
        });
        
       
        
        
    }else{
        console.log('Desktop');
        jQuery( "#header_register" ).insertAfter( ".user-reg-destop" );
        jQuery( "#home_page_slider" ).insertAfter( ".desktop-slider" );
        
        jQuery( "#custom_brand_lits_top" ).insertAfter( ".brand-list-desktop-view" );
    }
}
setTimeout(function(){ jQuery(this).manage_view(); }, 1000);

jQuery(window).resize(function(e) {
    jQuery(this).manage_view();
});

jQuery(document).ready(function(){
    
    jQuery('.brand-item-link').each(function(index){
        var target = jQuery(this);
        target.addClass('brand_event_'+index);
        //console.log(index);
    });
   
   jQuery('.single-product').find('.ivole-upload-local-images').remove(); 
    
});
</script>



</head>

<body <?php body_class(); ?> itemscope="itemscope" itemtype="https://schema.org/WebPage">
<?php // echo do_shortcode('[custom_sidebar_coupon_code_widget_shortcode]'); ?>
        <div class="header-container" id="main-header">
            <div class="main-header-top header-top-v2" style="display:none">
                <div class="header-offer">
                    
                    <a href="#" style="pointer-events:none;">
                        <div class="subs-offer">
                            <div class="subs-left"><!--<strong>Subscribe</strong> to Us & Get <strong>$10 off</strong> Instantly-->Orders Ship In:</div>
                            <!--div class="subs-right">
                                Get $10 <img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/subs-icon.png" alt="subs icon">
                            </div-->
                        </div>
                    </a>
                    
                    <!--timer start-->
                    <!--<span class="count-down-box"><?php //echo do_shortcode('[custom_countdown_timer_shortcode]'); ?></span>-->
                    <!--timer end-->
                    
                </div><!--header-offer-->
            </div>
            
            
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 checkout-logo">
                        <div class="logo">
                            <a href="<?php echo home_url();?>"><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/logo.png" alt="Logo"></a>
                            <span class="logo-text">Proven, Tested Diesel Parts For Long-Term Durability</span>
                            
                        </div>
                    </div>

                    <div class="col-sm-9 rem-checkout">
                        
                        <div class="header-right">
                            <div class="header-right-top">
                                <div class="header-offer offerv-1">
                                    <a href="#">
                                        <div class="subs-offer">
                                            <div class="subs-left">
                                                Subscribe to Us <span>& Get <strong>$10 off</strong> Instantly</span>
                                            </div>
                                            <div class="subs-right">
                                                Get $10 <img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/subs-icon.png" alt="subs icon">
                                            </div>
                                        </div>
                                    </a>
                                </div><!--header-offer-->
                                 <div class="header-offer offerv-2" style='display:none;'>
                                    <a href="#">GET $20 INSTANTLY! <span> Click Here</span></a>
                                </div><!--header-offer-->
                                <div class="header-right-top-search user-reg-destop">
                                    <?php //echo get_search_form();?>
                                    
                                    
<form class="top-search-form" method="get" role="search" action="<?php echo home_url();?>" title="Type and press Enter to search.">
    <a class="search_submit" href="javascript://"><i class="fa fa-search" aria-hidden="true"></i></a>

    <input type="hidden" name="post_type" value="product">
    <input type="hidden" name="orderby" value="price-desc">
    
	<input type="search" class="fl-search-input form-control" name="s" value="Search" onfocus="if (this.value == 'Search') { this.value = ''; }" onblur="if (this.value == ''){ this.value='Search';}">
</form>



                                </div>
                                <!--header-right-top-search-->
                               
                                
                                <div class="header-register 11" id="header_register">
                                    <div class="userreg-icon icon-tops"><i class="fa fa-user"></i></div>
                                    <!--<img src="<?php // echo home_url();?>/wp-content/themes/ydg-theme-child/img/user-reg.png" alt="User Register">-->
                                   
                                    
                                    <!--user-->
                                    <?php if (is_user_logged_in()) { 
                                    
                                    $user_id = get_current_user_id(); 
                                    $user_meta = get_userdata($user_id);
                                    $user_roles = $user_meta->roles;
                                    
                                        
                                    ?>
                            
                                    <span>
                                        
                                    <?php  if ( in_array( 'wholesale_customer', $user_roles, true ) ) {  $first_name = get_user_meta(  $user_id, 'first_name', true );  ?>
                                    
                                        <a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">Hello <?php echo $first_name;?></a>
                                
                                    <?php }else{  $nickname = get_user_meta(  $user_id, 'nickname', true ); ?>
                                    
                                    
                                    
                                    <?php
                                        $first_name = get_user_meta(  $user_id, 'first_name', true ); 
                                        if(!empty($first_name)){ $first_name = get_user_meta(  $user_id, 'first_name', true ); 
                                        
                                        ?>
                                        <a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">Hello <?php echo $first_name;?></a>
                                        <?php 
                                        }else{ $nickname = get_user_meta(  $user_id, 'nickname', true ); ?>
                                        <a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">Hello <?php echo $nickname;?></a>
                                        <?php
                                        }
                                    ?>
                                        
                                        
                                      
                                    <?php } ?>
                                    
                                        <a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">My Account</a>
                                    </span>

                                    <?php }else{ ?>
                                        <span>
                                            <a href="<?php echo wc_get_page_permalink( 'myaccount' );?>">Customer <br>Sign In</a>
                                        </span>
                                    <?php }?>
                                    <!--user-->
                                    
                                    
                                    
                                </div><!--header-register-->
                                
                                
                                <div class="header-cart-user">
                                    
                                    <?php echo do_shortcode('[custom_get_mini_cart_shortcode]');?>
                                    
                                    
                                        
                                        
                                        <!--user-->
                                        <?php if (is_user_logged_in()) { 
                                        
                                        $user_id = get_current_user_id(); 
                                        $user_meta = get_userdata($user_id);
                                        $user_login = $user_meta->user_login;
                                        ?>
                                        
                                        <?php }else{ ?>
                                        <div class="header-register 22">
                                            <div class="usersign-icon icon-tops"><i class="fa fa-user"></i></div>
                                            <!--<img src="<?php // echo home_url();?>/wp-content/themes/ydg-theme-child/img/user-sign.png" alt="User Sign In">-->
                                            <span>
                                                <a href="<?php echo get_permalink( get_page_by_path( 'wholesale-log-in-and-registration-page' ) )?>">Dealer <br> Sign In</a>
                                            </span>
                                         </div>
                                        <?php }?>
                                        <!--user-->
                                
                                    <div class="phone-number user-reg-mobile">
                                        <div class="phones-icon icon-tops"><i class="fa fa-phone"></i></div>
                                            <!--<img src="<?php // echo home_url();?>/wp-content/themes/ydg-theme-child/img/phone-call.png" alt="call">-->
                                            <a href="tel:18004896820">1-800-489-6820</a></div>
                                </div><!--header-cart-user-->
                            </div><!--header-right-top-->
                            
                            <div class="mobile-slider">
                            <?php 
                            /* if (is_front_page()) {
                                
                                //echo do_shortcode ("[custom_home_page_banner_shortcode]"); 
                            }*/
                            ?>
                            </div>
                            <div class="header-search">
								<div class="show-category-search">
									<span>Customize your search</span> 
									<i class="fa fa-bars" aria-hidden="true"></i>
								</div>
								
                                <?php 
                                if ( is_active_sidebar( 'custom-deisel-advance-search-widget' ) ) {
                                    dynamic_sidebar( 'custom-deisel-advance-search-widget' );
                                }
                                ?>
                            </div><!--header-search-->
                            
                        </div><!--header-right-->
                    </div>
                </div>
            </div><!--container-->
        </div><!--header-container-->
        <div class="col-sm-12 ppppppppppppppppppppppppp">
            <?php 
            if (!is_front_page()) {
                
                if ( is_active_sidebar( 'custom-deisel-brand-widget' ) ) {
                    dynamic_sidebar( 'custom-deisel-brand-widget' );
                }
            }
            
            
            
            
            
          /* $user_id = get_current_user_id(); 
            $user_meta = get_userdata($user_id); 
            $user_roles = $user_meta->roles;

            if ( in_array( 'wholesale_customer', $user_roles, true ) ) {
                
                echo "first_name : ".$first_name = get_user_meta(  $user_id, 'first_name', true ); 
              
            }else{
                
                $first_name = get_user_meta(  $user_id, 'first_name', true ); 
                if(!empty($first_name)){
                     echo "first_name : ".$first_name = get_user_meta(  $user_id, 'first_name', true ); 
                }else{
                    echo "nickname : ".$nickname = get_user_meta(  $user_id, 'nickname', true );
                }
            }*/
            
            
           
            
           
        
            ?>
        </div>