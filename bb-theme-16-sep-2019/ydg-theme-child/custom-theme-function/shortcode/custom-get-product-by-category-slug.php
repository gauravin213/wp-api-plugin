<?php
/*
 * Start:add shortcode for Get Product By category
 */

function custom_get_product_by_cat_shortcode_function($atts) {

    extract(shortcode_atts(
                    array(
        'cat_id' => '',
        'cate_slug' => '',
        'title' => '',
        'title2' => '',
                    ), $atts)
    );

    $args_product = array(
        'post_type' => 'product',
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
        'order'            => 'DESC',
        'posts_per_page' => 5,
        'product_cat' => $cate_slug,
    );


    $loop = new WP_Query($args_product);




    $category_slug = $cate_slug;
    $taxonomy = 'product_cat';
    $get_term = get_term_by('slug', $category_slug, $taxonomy);
    $term_id = $get_term->term_id;
    $args_cat = array(
        'hierarchical' => 1,
        'show_option_none' => '',
        //'hide_empty' => 0,
        'parent' => $cat_id,
        'taxonomy' => $taxonomy,
            //'orderby' => 'term_id',
            //'order'   => 'DESC'
    );
    $subcats = get_categories($args_cat);

    //print_r($subcats);



    $page_url = get_permalink(get_the_ID());


    ob_start();
    ?>
    <div class="category-box-container woocommerce">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="category-name"><h5><?php echo $title; ?></h5></div>
                    <div class="products">
                        <div class="row">
                            <?php
                            /* $loop = new WP_Query( $args_product );
                              if ( $loop->have_posts() ) {
                              while ( $loop->have_posts() ) : $loop->the_post();
                              wc_get_template_part( 'content', 'product' );
                              endwhile;
                              } else {
                              echo __( 'No products found' );
                              }
                              wp_reset_postdata(); */
                            ?>

                            <?php
                            while ($loop->have_posts()) : $loop->the_post();

                                $title = get_the_title();
                                $content_des = substr(strip_tags(get_the_excerpt()), 0, 50);
                                $product = wc_get_product(get_the_ID());
                                $get_regular_price = $product->get_regular_price();
                                $get_sale_price = $product->get_sale_price();
                                $get_price = $product->get_price();
                                $sku = $product->get_sku();

                                $get_post_thumbnail_id = get_post_thumbnail_id();

                                if (!empty($get_post_thumbnail_id)) {
                                    $image_attributes_thumbnail = wp_get_attachment_image_src($get_post_thumbnail_id, 'medium');
                                } else {
                                    $image_attributes_thumbnail = wp_get_attachment_image_src(37069, 'medium'); //37069 37070
                                }

                                $stock_status = get_post_meta(get_the_ID(), '_stock_status', true);
                                ?>
                                <!--loop-->
                                <div class="col-sm-3">
                                    <div class="category-product">
                                        <div class="product-image">
                                            <a href="<?php echo get_the_permalink(); ?>">
                                                <img src="<?php echo $image_attributes_thumbnail[0]; ?>" alt="Diesel Product">
                                            </a>
                                        </div>

                                        <div class="product-title"> <a href="<?php echo get_the_permalink(); ?>" class=""><?php echo $title; ?></a></div>

                                        <div class="product-price"><?php echo $product->get_price_html(); ?></div>

                                        <div class="product-add">


                                            <?php if ($stock_status == 'instock') { ?>


                                                <!--check addons-->
                                                <?php
                                                $_product_addons = get_post_meta(get_the_ID(), '_product_addons', true);

                                                if ($_product_addons && !empty($_product_addons)) {
                                                    foreach ($_product_addons as $addon) {

                                                        if (isset($addon['required']) && '1' == $addon['required']) {   //echo 'Required!!';
                                                            ?>
                                                            <a href="<?php echo get_the_permalink(); ?>" class="button">Select Options</a>
                                                            <?php
                                                        } else { //echo 'Not Required!!';
                                                            ?>
                                                            <a href="<?php echo $page_url; ?>?add-to-cart=<?php echo get_the_ID(); ?>" 
                                                               data-quantity="1" 
                                                               class="button product_type_simple add_to_cart_button ajax_add_to_cart" 
                                                               data-product_id="<?php echo get_the_ID(); ?>" 
                                                               data-product_sku="<?php echo $sku; ?>" 
                                                               aria-label="Add â€œMopar 6.7L 4032806 Turbo Speed Sensor For 13-18 Dodge Ram ISB Cummins Dieselâ€? to your cart" 
                                                               rel="nofollow">Add to cart</a>
                        <?php
                    }
                }
            } else { //echo 'not addons';
                ?>
                                                    <a href="<?php echo $page_url; ?>?add-to-cart=<?php echo get_the_ID(); ?>" 
                                                       data-quantity="1" 
                                                       class="button product_type_simple add_to_cart_button ajax_add_to_cart" 
                                                       data-product_id="<?php echo get_the_ID(); ?>" 
                                                       data-product_sku="<?php echo $sku; ?>" 
                                                       aria-label="Add â€œMopar 6.7L 4032806 Turbo Speed Sensor For 13-18 Dodge Ram ISB Cummins Dieselâ€? to your cart" 
                                                       rel="nofollow">Add to cart</a>
                <?php
            }
            ?>
                                                <!--check addons-->


                                               <?php } else if ($stock_status == 'outofstock') { ?>

                                                <a href="<?php echo get_the_permalink(); ?>" class="button">READ MORE</a>

                                            <?php } else { //echo 'PPP'; ?>

        <?php } ?>

                                        </div>
                                    </div><!--category-product-->
                                </div>

                                <!--loop-->
    <?php endwhile;
    wp_reset_query(); ?>


                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="category-list">
                        <div class="category-heading"><h5><?php echo $title2; ?></h5></div>
                        <ul class="diesel_cat_sidebar_<?php echo$term_id; ?>">
    <?php foreach ($subcats as $sc) {
        $link = get_term_link($sc->slug, $sc->taxonomy); ?>


        <?php
        $hide_category_from_sidebar = get_term_meta($sc->term_id, 'hide_category_from_sidebar', true);

        if (!in_array('Hide', $hide_category_from_sidebar, true)) {
            ?>
                                    <li><a href="<?php echo $link; ?>"><?php echo $sc->name ?><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
                                    <?php
                                }
                                ?>


                            <?php } ?>
                            <!--<li><a href="<?php //echo get_term_link($term_id, 'product_cat'); ?>">More <i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>-->
                        </ul>
                    </div><!--category-list-->
                </div>
            </div>
        </div><!--container-->
    </div><!--category-box-container-->
    <?php
    return ob_get_clean();
}

add_shortcode('custom_get_product_by_cat_shortcode', 'custom_get_product_by_cat_shortcode_function');
/*
 * End:add shortcode for Get Product By category
 */




























/*
 * Start:add shortcode for Get Product By category Home 3
 */

function custom_get_product_by_cat_shortcode_function_home3($atts) {

    extract(shortcode_atts(
                    array(
        'cat_id' => '',
        'cate_slug' => '',
        'title' => '',
        'title2' => '',
                    ), $atts)
    );

    $args_product = array(
        'post_type' => 'product',
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
        'order'            => 'DESC',
        'posts_per_page' => 10,
        'product_cat' => $cate_slug,
    );


    $loop = new WP_Query($args_product);




    $category_slug = $cate_slug;
    $taxonomy = 'product_cat';
    $get_term = get_term_by('slug', $category_slug, $taxonomy);
    $term_id = $get_term->term_id;
    $args_cat = array(
        'hierarchical' => 1,
        'show_option_none' => '',
        //'hide_empty' => 0,
        'parent' => $cat_id,
        'taxonomy' => $taxonomy,
            //'orderby' => 'term_id',
            //'order'   => 'DESC'
    );
    $subcats = get_categories($args_cat);

    //print_r($subcats);



    $page_url = get_permalink(get_the_ID());


    ob_start();
    ?>
    <div class="category-box-container woocommerce">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="category-name"><h5><?php echo $title; ?></h5></div>
                    <div class="products">
                        <div class="row">
                            <?php
                            /* $loop = new WP_Query( $args_product );
                              if ( $loop->have_posts() ) {
                              while ( $loop->have_posts() ) : $loop->the_post();
                              wc_get_template_part( 'content', 'product' );
                              endwhile;
                              } else {
                              echo __( 'No products found' );
                              }
                              wp_reset_postdata(); */
                            ?>

                            <?php
                            while ($loop->have_posts()) : $loop->the_post();

                                $title = get_the_title();
                                $content_des = substr(strip_tags(get_the_excerpt()), 0, 50);
                                $product = wc_get_product(get_the_ID());
                                $get_regular_price = $product->get_regular_price();
                                $get_sale_price = $product->get_sale_price();
                                $get_price = $product->get_price();
                                $sku = $product->get_sku();

                                $get_post_thumbnail_id = get_post_thumbnail_id();

                                if (!empty($get_post_thumbnail_id)) {
                                    $image_attributes_thumbnail = wp_get_attachment_image_src($get_post_thumbnail_id, 'medium');
                                } else {
                                    $image_attributes_thumbnail = wp_get_attachment_image_src(37069, 'medium'); //37069 37070
                                }

                                $stock_status = get_post_meta(get_the_ID(), '_stock_status', true);
                                ?>
                                <!--loop-->
                                <div class="col-sm-3">
                                    <div class="category-product">
                                        <div class="product-image">
                                            <a href="<?php echo get_the_permalink(); ?>">
                                                <img src="<?php echo $image_attributes_thumbnail[0]; ?>" alt="Diesel Product">
                                            </a>
                                        </div>

                                        <div class="product-title"> <a href="<?php echo get_the_permalink(); ?>" class=""><?php echo $title; ?></a></div>

                                        <div class="product-price"><?php echo $product->get_price_html(); ?></div>

                                        <div class="product-add">


                                            <?php if ($stock_status == 'instock') { ?>


                                                <!--check addons-->
                                                <?php
                                                $_product_addons = get_post_meta(get_the_ID(), '_product_addons', true);

                                                if ($_product_addons && !empty($_product_addons)) {
                                                    foreach ($_product_addons as $addon) {

                                                        if (isset($addon['required']) && '1' == $addon['required']) {   //echo 'Required!!';
                                                            ?>
                                                            <a href="<?php echo get_the_permalink(); ?>" class="button">Select Options</a>
                                                            <?php
                                                        } else { //echo 'Not Required!!';
                                                            ?>
                                                            <a href="<?php echo $page_url; ?>?add-to-cart=<?php echo get_the_ID(); ?>" 
                                                               data-quantity="1" 
                                                               class="button product_type_simple add_to_cart_button ajax_add_to_cart" 
                                                               data-product_id="<?php echo get_the_ID(); ?>" 
                                                               data-product_sku="<?php echo $sku; ?>" 
                                                               aria-label="Add â€œMopar 6.7L 4032806 Turbo Speed Sensor For 13-18 Dodge Ram ISB Cummins Dieselâ€? to your cart" 
                                                               rel="nofollow">Add to cart</a>
                        <?php
                    }
                }
            } else { //echo 'not addons';
                ?>
                                                    <a href="<?php echo $page_url; ?>?add-to-cart=<?php echo get_the_ID(); ?>" 
                                                       data-quantity="1" 
                                                       class="button product_type_simple add_to_cart_button ajax_add_to_cart" 
                                                       data-product_id="<?php echo get_the_ID(); ?>" 
                                                       data-product_sku="<?php echo $sku; ?>" 
                                                       aria-label="Add â€œMopar 6.7L 4032806 Turbo Speed Sensor For 13-18 Dodge Ram ISB Cummins Dieselâ€? to your cart" 
                                                       rel="nofollow">Add to cart</a>
                <?php
            }
            ?>
                                                <!--check addons-->


                                               <?php } else if ($stock_status == 'outofstock') { ?>

                                                <a href="<?php echo get_the_permalink(); ?>" class="button">READ MORE</a>

                                            <?php } else { //echo 'PPP'; ?>

        <?php } ?>

                                        </div>
                                    </div><!--category-product-->
                                </div>

                                <!--loop-->
    <?php endwhile;
    wp_reset_query(); ?>


                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="category-list">
                        <div class="category-heading"><h5><?php echo $title2; ?></h5></div>
                        <ul class="diesel_cat_sidebar_<?php echo$term_id; ?>">
    <?php foreach ($subcats as $sc) {
        $link = get_term_link($sc->slug, $sc->taxonomy); ?>


        <?php
        $hide_category_from_sidebar = get_term_meta($sc->term_id, 'hide_category_from_sidebar', true);

        if (!in_array('Hide', $hide_category_from_sidebar, true)) {
            ?>
                                    <li><a href="<?php echo $link; ?>"><?php echo $sc->name ?><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
                                    <?php
                                }
                                ?>


                            <?php } ?>
                            <!--<li><a href="<?php //echo get_term_link($term_id, 'product_cat'); ?>">More <i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>-->
                        </ul>
                    </div><!--category-list-->
                </div>
            </div>
        </div><!--container-->
    </div><!--category-box-container-->
    <?php
    return ob_get_clean();
}

add_shortcode('custom_get_product_by_cat_shortcode_home3', 'custom_get_product_by_cat_shortcode_function_home3');
/*
 * End:add shortcode for Get Product By category
 */
































/*
 * Start:add shortcode for Get Product By category Home 2
 */ 

function custom_get_product_by_cat_shortcode_function_home2($atts) {

    extract(shortcode_atts(
                    array(
        'cat_id' => '',
        'cate_slug' => '',
        'title' => '',
        'title2' => '',
                    ), $atts)
    );



    $category_slug = $cate_slug;
    $taxonomy = 'product_cat';
    $get_term = get_term_by('slug', $category_slug, $taxonomy);
    $term_id = $get_term->term_id;
    $args_cat = array(
        'hierarchical' => 1,
        'show_option_none' => '',
        //'hide_empty' => 0,
        'parent' => $cat_id,
        'taxonomy' => $taxonomy,
            //'orderby' => 'term_id',
            //'order'   => 'DESC'
    );
    $subcats = get_categories($args_cat);

    //print_r($subcats);

    $page_url = get_permalink(get_the_ID());


    ob_start();
    $c=1;
    ?>
    <div class="category-box-container woocommerce">
        <div class="container cagegory-home-cont"><div class="row"><div class="category-name"><h5><?php echo $title; ?></h5></div></div></div>
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="products">
                        <div class="row">

    <?php  foreach ($subcats as $sc) { ?>

        <?php
        $link = get_term_link($sc->slug, $sc->taxonomy);
        $cat_name = $sc->name;
        $cat_slug = $sc->slug;
        $cat_term_id = $sc->term_id;
        ?>


        <?php
        //Get Top salling Product
        $args = array(
        'posts_per_page'   => 1,
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
        'order'            => 'DESC',
        'post_type'        => 'product',
        'post_status'      => 'publish',
        /*'meta_query'    => array(
                array(
                    'key'       => 'total_sales',
                    'value'     => '0',
                    'compare'   => '!=',
                )
            ),*/
        'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $cat_term_id,
                    'operator' => 'IN'
                )
            )
        );
        $query = new WP_Query( $args );
        if($query->have_posts()){
    
            while( $query->have_posts() ) { 
                $query->the_post();
                
                $product_id = get_the_ID(); 
                
                $product = wc_get_product( $product_id );
                
                $get_post_thumbnail_id = get_post_thumbnail_id($product_id);
    
                if (!empty($get_post_thumbnail_id)) {
                    $image_attributes_thumbnail = wp_get_attachment_image_src($get_post_thumbnail_id, 'medium');
                } else {
                    $image_attributes_thumbnail = wp_get_attachment_image_src(37069, 'medium'); //37069 37070
                }
    
                $title = $product->get_title();
                $sku = $product->get_sku();
                $url = $page_url . '?add-to-cart=' . $product_id;
                
                ?>
                <div class="col-sm-3 <?php echo ($c > 5)? 'bot-bor' : '' ?>">
                <div class="product-cat homes-prod-cats">
                    <a href="<?php echo $link ?>"><?php echo $cat_name; ?><i class="fa fa-chevron-right"></i></a>
                </div>
                <div class="category-product">
                    <div class="product-image">
                        <a href="<?php echo get_permalink($product_id); ?>">
    
                            <img src="<?php echo $image_attributes_thumbnail[0]; ?>" alt="Diesel Product">
                        </a>
                    </div>

                    <div class="product-title"> <a href="<?php echo get_permalink($product_id); ?>" class=""><?php echo $title; ?></a></div>

                    <div class="product-price"><?php echo $product->get_price_html(); ?></div>

                    <div class="product-add">

                        <a href="<?php echo get_home_add_to_cart_button_url($url, $product); ?>" 
                           data-quantity="1" 
                           class="button product_type_simple add_to_cart_button <?php echo get_home_ajax_add_to_cart_supports($product); ?>" 
                           data-product_id="<?php echo $product_id; ?>" 
                           data-product_sku="<?php echo $sku; ?>" 
                           aria-label="Add â€œMopar 6.7L 4032806 Turbo Speed Sensor For 13-18 Dodge Ram ISB Cummins Dieselâ€? to your cart" 
                           rel="nofollow">
                            <?php echo get_home_add_to_cart_button_text($product); ?>
                        </a>

                    </div>
                </div>
            </div>
            <?php }
    
            wp_reset_postdata();
    
        }else{
            //echo 'Not In post';
        }
        ?>

        


    <?php $c++;  } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div><!--container-->
    </div><!--category-box-container-->
    <?php
    return ob_get_clean();
}

add_shortcode('custom_get_product_by_cat_shortcode_home2', 'custom_get_product_by_cat_shortcode_function_home2');
/*
 * End:add shortcode for Get Product By category
 */

function get_home_add_to_cart_button_text($product) {

    $stock_qty = $product->get_stock_quantity();

    $_product_addons = get_post_meta($product->get_id(), '_core_product_price_meta', true);

    $_stock_status = get_post_meta($product->get_id(), '_stock_status', true);

    if ($stock_qty > 0 || $_stock_status == 'instock') {

        if ($_product_addons && !empty($_product_addons)) {
            return 'Select options';
        } else {
            return 'Add to cart';
        }
    } else {

        if ($product->backorders_allowed()) {

            if ($_product_addons && !empty($_product_addons)) {
                return 'select Backorder';
            } else {
                return 'Backorder';
            }
        } else {
            return 'Read more';
        }
    }
}

function get_home_add_to_cart_button_url($url, $product = null) {


    $stock_qty = $product->get_stock_quantity();

    $_product_addons = get_post_meta($product->get_id(), '_core_product_price_meta', true);

    $_stock_status = get_post_meta($product->get_id(), '_stock_status', true);

    if ($stock_qty > 1 || $_stock_status == 'instock') {

        if ($_product_addons && !empty($_product_addons)) {
            $url = get_permalink($product->get_id());
        } else {
            return 'Add to cart';
        }
    } else {

        if ($product->backorders_allowed()) {

            if ($_product_addons && !empty($_product_addons)) {
                $url = get_permalink($product->get_id());
            } else {
                return 'Backorder';
            }
        } else {
            $url = get_permalink($product->get_id());
        }
    }

    return $url;
}

function get_home_ajax_add_to_cart_supports($product = null) {

    $stock_qty = $product->get_stock_quantity();

    $_product_addons = get_post_meta($product->get_id(), '_core_product_price_meta', true);

    $_stock_status = get_post_meta($product->get_id(), '_stock_status', true);

    if ($stock_qty > 1 || $_stock_status == 'instock') {

        if ($_product_addons && !empty($_product_addons)) {
            return 'Select options';
        } else {
            return 'ajax_add_to_cart';
        }
    } else {

        if ($product->backorders_allowed()) {

            if ($_product_addons && !empty($_product_addons)) {
                return 'select Backorder';
            } else {
                return 'ajax_add_to_cart';
            }
        } else {
            return 'Read more';
        }
    }
}
