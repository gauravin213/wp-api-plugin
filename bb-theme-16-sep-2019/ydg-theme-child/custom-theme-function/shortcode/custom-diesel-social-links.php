<?php
/*
* Custom Testing code
*/
function custom_diesel_social_links_shortcode_function($atts){

    extract( shortcode_atts(
        array(
            'id' => '',
            'cate_id' => '',
            'title'  => '',
            ), $atts )
    );
    ob_start();
    
?>
<div class="newsletter-container">
    <div class="footer-social">
        <ul>
            <li><a href="<?php if (get_option('diesel_social_media_facebook')) echo get_option('diesel_social_media_facebook'); ?>"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
            <li><a href="<?php if (get_option('diesel_social_media_twitter')) echo get_option('diesel_social_media_twitter'); ?>"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
            <li><a href="<?php if (get_option('diesel_social_media_youtube')) echo get_option('diesel_social_media_youtube'); ?>"><i class="fa fa-youtube-square" aria-hidden="true"></i></a></li>
            <li><a href="<?php if (get_option('diesel_social_media_instagram')) echo get_option('diesel_social_media_instagram'); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
        </ul>
    </div>
    <div class="newsletter">
        <div class="newsletter-text">Newsletter <span>SIGN UP</span></div>
        <div class="newsletter-input">
             <?php echo do_shortcode('[mc4wp_form id="79750"]');?>
        </div>
    </div>
</div>
<?php

return ob_get_clean();
}
add_shortcode('custom_diesel_social_links_shortcode', 'custom_diesel_social_links_shortcode_function');

?>