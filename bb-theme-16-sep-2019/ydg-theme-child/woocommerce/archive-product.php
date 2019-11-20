<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );


?>


<?php // if ( is_active_sidebar( 'shop-page-header' ) ) { ?>
    <?php //dynamic_sidebar( 'shop-page-header' ); ?>
<?php // } ?>



<!--<div class="product-cate-desc">
    <h3>Turbo Rebuild Kit</h3>
    <div class="product-cate-box">
    <p>The Components Found In DTPD Rebuild Kits Are Sourced From The World’s Leading Manufacturers. Built To Exceed OEM Quality Standards. We Provide Exactly The Parts You Need For Your 6.0L Powerstroke GT3782VA Turbo Rebuild. No More, No Less. This Is Not A Universal Kit Fitting Several GT37 Models. This Kit Was Designed To Completely Rebuild And Reinstall Your 6.0L Turbo. From Start To Finish.</p>
    <a class="cate-read-more" href="#">Read More</a>
    </div>
</div>-->


<header class="woocommerce-products-header">
    
    
<div class="product-cate-desc">

    
    
   
	<?php
	$category = get_queried_object();
    $term_id = $category->term_id;
    
    
     
     if($term_id == 15732){
         remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title');
     }
    
    $term_description = term_description( $term_id, 'product_cat' );
    
    if(!empty($term_description)){
        ?>
        
        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h3 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h3>
	    <?php endif; ?>
	
        <div class="product-cate-box">
            <?php
            /**
        	 * Hook: woocommerce_archive_description.
        	 *
        	 * @hooked woocommerce_taxonomy_archive_description - 10
        	 * @hooked woocommerce_product_archive_description - 10
        	 */
        	do_action( 'woocommerce_archive_description' );
            ?>
        </div>
        <?php
    }else{
        ?>
            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
    		    <h3 class="woocommerce-products-header__title page-title" style=""><?php woocommerce_page_title(); ?></h3>
    	    <?php endif; ?>
        <?php
    }
	?>
    
    
</div>

    
	
</header>
<?php

if ( have_posts() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked wc_print_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	 
	//echo '<div class="custom-befor-shop-loop-box">';
	do_action( 'woocommerce_before_shop_loop' );
	//echo '</div>';

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 *
			 * @hooked WC_Structured_Data::generate_product_data() - 10
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );?>
