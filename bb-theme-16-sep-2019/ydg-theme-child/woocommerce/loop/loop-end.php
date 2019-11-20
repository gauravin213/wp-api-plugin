<?php
/**
 * Product Loop End
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-end.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</div><!--end row-->
</div><!--end products-->
</div><!--end col-9-->
 <?php if( is_shop() || is_product_category() ) { ?>
<div class="col-sm-3 shop-page-sidebar">
    <?php if ( is_active_sidebar( 'shop-page-sidebar' ) ) { ?>
            <?php dynamic_sidebar( 'shop-page-sidebar' ); ?>
    <?php } ?>
</div>
<?php } ?>
</div><!--end row-->
</div><!--end container-->
</div><!--end category-->


