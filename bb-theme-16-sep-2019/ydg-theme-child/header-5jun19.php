<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php //do_action( 'fl_head_open' ); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php// echo apply_filters( 'fl_theme_viewport', "<meta name='viewport' content='width=device-width, initial-scale=1.0' />\n" ); ?>
<?php //echo apply_filters( 'fl_theme_xua_compatible', "<meta http-equiv='X-UA-Compatible' content='IE=edge' />\n" ); ?>
<link rel="profile" href="https://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php //FLTheme::title(); ?>
<?php //FLTheme::favicon(); ?>
<?php //FLTheme::fonts(); ?>
<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
<![endif]-->
<?php

wp_head();

/*FLTheme::head();
date_default_timezone_set("America/Los_Angeles");*/

?>


<!--New Layout-->
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:200,300,400,500,600,700,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Racing+Sans+One" rel="stylesheet">
<!--New Layout-->

</head>

<body <?php body_class(); ?> itemscope="itemscope" itemtype="https://schema.org/WebPage">

        <div class="header-container" id="main-header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="logo">
                            <a href="<?php echo home_url();?>"><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/logo.png" alt="Logo"></a>
                            <span class="logo-text">Proven, Tested Diesel Parts For Long-Term Durability</span>
                            
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="header-right">
                            <div class="header-right-top">
                                <div class="header-offer">
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
                                <div class="header-right-top-search">
                                   <!-- <input type="text">
                                    <button><img src="<?php //echo home_url();?>/wp-content/themes/ydg-theme-child/img/search-icon.png"></button>-->
                                    <?php echo get_search_form();?>
                                </div>
                                <!--header-right-top-search-->
                                <div class="header-register">
                                    <img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/user-reg.png" alt="User Register">
                                    <span>
                                        <a href="<?php echo get_permalink(wc_get_page_id( 'myaccount' ))?>">Sign in</a>
                                        <a href="<?php echo get_permalink(wc_get_page_id( 'myaccount' ))?>">Register</a>
                                    </span>
                                </div><!--header-register-->
                                <div class="header-cart-user">
                                    <div class="header-cart">
                                        <a href="<?php echo get_permalink(wc_get_page_id( 'cart' ))?>">
                                             <img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/cart.png" alt="Cart">
                                                <div class="header-cart-value">0</div>
                                                 <?php if ( is_active_sidebar( 'cart-header' ) ) { ?>
                                                 <?php //dynamic_sidebar( 'cart-header' ); ?>
                                                <?php } ?>
                                        </a>
                                    </div>
                                    <div class="header-register">
                                        <img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/user-sign.png" alt="User Sign In">
                                        <span>
                                            <a href="<?php echo get_permalink( get_page_by_path( '/wholesale-log-in-page' ) )?>">Dealer</a>
                                            <a href="<?php echo get_permalink( get_page_by_path( '/wholesale-registration-page' ) )?>">Sign In</a>
                                        </span>
                                    </div><!--header-register-->
                                    <div class="phone-number"> <img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/phone-call.png" alt="call"><a href="tel:18004896820">1-800-489-6820</a></div>
                                </div><!--header-cart-user-->
                            </div><!--header-right-top-->


    
                            <div class="header-search">
                                <?php //echo do_shortcode('[ymm_selector template="horizontal_selector.php"]'); ?>
                               <select>
                                    <option>Year</option>
                                </select>
                                <select>
                                    <option>Make</option>
                                </select>
                                <select>
                                    <option>Model</option>
                                </select>
                                <select>
                                    <option>Trim</option>
                                </select>
                                <select>
                                    <option>Engine</option>
                                </select>
                                <input type="submit" value="&nbsp;">
                            </div><!--header-search-->
                            
                            
                            
                        </div><!--header-right-->
                    </div>
                </div>
            </div><!--container-->
        </div><!--header-container-->
        <div class="col-sm-12"><?php echo do_shortcode('[custom_brand_shortcode]')?></div>