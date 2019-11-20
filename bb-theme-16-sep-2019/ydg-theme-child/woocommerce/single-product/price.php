<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$stock_status = get_post_meta($product->get_ID(), '_stock_status', true);

?>

<div class="custom-price-and-stocl">
    
    <p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) );?>">
        <?php echo $product->get_price_html(); ?>
    </p>
    

    <?php if($stock_status == 'instock'){ ?>
        
        <p class="stock in-stock">
            <?php echo $product->get_stock_quantity().' in stock'; ?> 
            
            
            <div class="product-msg">
                
                <?php
                if($product->get_shipping_class()=='fedex-one-rate-2day'){
                   echo '<div class="custom-product-message">';
                     echo '<div><img src="'.home_url().'/wp-content/uploads/2019/08/fedex-2day.png"></div>';
                   echo '</div>';
                }
               /* $fields_image = get_field('upload_image', $product->get_ID(), true);
                $fields_text = get_field('test_message', $product->get_ID(), true);
                echo '<div class="custom-product-message">';
                if (count($fields_image)!=0 && $fields_image!="") {$image_url = $fields_image['sizes']['thumbnail'];  
                    ?>
                    <div><img src='<?php echo $image_url;?>'></div>
                    <?php
                }
                if (count($fields_text)!=0 && $fields_text!="") { 
                    ?>
                    <div><span><?php echo $fields_text?></span></div>
                    <?php
                }
                echo '</div>';*/
                ?>
            </div>
            
            
        </p>
        
    <?php }else if($stock_status == 'outofstock'){ ?>
    
        <p class="out-of-stock">
             <?php echo 'out of stock'?>
        </p>
        
    <?php } else{ ?>
         
    <?php } ?>

</div>
