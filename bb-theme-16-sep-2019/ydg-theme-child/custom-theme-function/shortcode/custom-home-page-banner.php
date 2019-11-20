<?php

/*

* Start:add shortcode for brand

*/

function custom_home_page_banner_shortcode_function($atts){



  extract( shortcode_atts(

        array(

           'id' => '',

            'content'  => '',

            "cat_id" => '',

            "cat_icon_class" => '',

            "image" => '',

            ), $atts )

    ); 



ob_start();

?>

    <?php  echo do_shortcode('[custom_sidebar_coupon_code_widget_shortcode]'); ?>
<section class="banner"  id='home_page_slider'>
    <!---->


    <!---->

    
    <div class="banner-image for-desktop">

        <div class="banner-image-slide owl-carousel">

            <div class="item"><a href="<?php if (get_option('diesel_baaner_link1')) echo home_url().get_option('diesel_baaner_link1'); ?>"><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/h-banner-1new.jpg" alt="Banner Prosource"></a></div>

            <div class="item"><a href="<?php if (get_option('diesel_baaner_link2')) echo home_url().get_option('diesel_baaner_link2'); ?>"><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/h-banner-zibbix-2.jpg" alt="Banner Zibbix"></a></div>

            <div class="item"><a href="<?php //if (get_option('diesel_baaner_link2')) echo home_url().get_option('diesel_baaner_link2'); ?>"><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/third-banner.jpg" alt="Banner Spoologic"></a></div>

			

        </div>

        <div class="banner-content">

            <h3>Providing Quality <br> Diesel Parts </h3>

            <h4>For Over 10 Years</h4>

            <ul>

                <li><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/list-check.png" alt="Diesel"> Avoid the hassle of dealership sales.</li>

                <li><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/list-check.png" alt="Diesel"> Take advantage of wholesale pricing options.</li>

                <li><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/list-check.png" alt="Diesel"> Get the parts you need with no extra costs!</li>

            </ul>

        </div><!--banner-content-->

    </div>

	

	<div class="banner-image for-mobile">

        <div class="banner-image-slide owl-carousel">

            <div class="item"><a href="<?php if (get_option('diesel_baaner_link1')) echo home_url().get_option('diesel_baaner_link1'); ?>"><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/mobile-first-banner.jpg" alt="Banner Prosource"></a></div>

            <div class="item"><a href="<?php if (get_option('diesel_baaner_link2')) echo home_url().get_option('diesel_baaner_link2'); ?>"><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/mobile-second-banner-zibbix.jpg" alt="Banner Zibbix"></a></div>

            <div class="item"><a href="<?php if (get_option('diesel_baaner_link2')) echo home_url().get_option('diesel_baaner_link2'); ?>"><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/mobile-third-banner.jpg" alt="Banner Spoologic"></a></div>

        </div>

    </div>

</section>

<?php

return ob_get_clean();

}

add_shortcode('custom_home_page_banner_shortcode', 'custom_home_page_banner_shortcode_function');



/*

* End:add shortcode for brand

*/

?>