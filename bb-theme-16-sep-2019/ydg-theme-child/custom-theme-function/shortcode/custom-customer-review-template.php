<?php
/*
* Custom Get Category By Slug
*/
function custom_get_customer_review_shortcode_function($attributes){
    
		$shortcode_enabled = get_option( 'ivole_reviews_shortcode', 'no' );
		if( $shortcode_enabled === 'no' ) {
			return;
		} else {
			// Convert shortcode attributes to block attributes
			$attributes = shortcode_atts( array(
				'count' => 3,
				'show_products' => true,
				'product_links' => true,
				'sort_by' => 'date',
				'sort' => 'DESC',
				'categories' => array(),
				'products' => array(),
				'color_ex_brdr' => '#ebebeb',
				'color_brdr' => '#ebebeb',
				'color_ex_bcrd' => '',
				'color_bcrd' => '#fbfbfb',
				'color_pr_bcrd' => '#f2f2f2',
				'shop_reviews' => 'false',
				'count_shop_reviews' => 1,
				'inactive_products' => 'false'
			), $attributes, 'cusrev_reviews_grid' );

			$attributes['count'] = absint( $attributes['count'] );
			$attributes['show_products'] = ( $attributes['show_products'] !== 'false' && boolval( $attributes['count'] ) );
			$attributes['product_links'] = ( $attributes['product_links'] !== 'false' );
			$attributes['shop_reviews'] = ( $attributes['shop_reviews'] !== 'false' && boolval( $attributes['count_shop_reviews'] ) );
			$attributes['count_shop_reviews'] = absint( $attributes['count_shop_reviews'] );
			$attributes['inactive_products'] = ( $attributes['inactive_products'] === 'true' );

			if ( ! is_array( $attributes['categories'] ) ) {
				$attributes['categories'] = array_filter( array_map( 'trim', explode( ',', $attributes['categories'] ) ) );
			}

			if ( ! is_array( $attributes['products'] ) ) {
				$attributes['products'] = array_filter( array_map( 'trim', explode( ',', $attributes['products'] ) ) );
			}

			return custom_render_reviews_grid( $attributes );
		}
}    
 
 
function custom_render_reviews_grid( $attributes ) {
		if ( get_option( 'ivole_reviews_shortcode', 'no' ) === 'no' ) {
             return '';
        }
		$max_reviews = $attributes['count'];
		$order_by = $attributes['sort_by'] === 'date' ? 'comment_date_gmt' : 'rating';
		$order = $attributes['sort'];
		$inactive_products = $attributes['inactive_products'];

		$post_ids = $attributes['products'];
		if ( count( $attributes['categories'] ) > 0 ) {
			$post_ids = get_posts(
				array(
					'post_type' => 'product',
					'posts_per_page' => -1,
					'fields' => 'ids',
					'post__in' => $attributes['products'],
					'tax_query' => array(
						array(
							'taxonomy' => 'product_cat',
							'field'    => 'term_id',
							'terms'    => $attributes['categories']
						),
					)
				)
			);
		}

		if( $inactive_products ) {
			$reviews = get_comments(
				array(
					'number'      => $max_reviews,
	        'status'      => 'approve',
	        'post_type'   => 'product',
	        'meta_key'    => 'rating',
	        'orderby'     => $order_by,
					'order'       => $order,
	        'post__in'    => $post_ids
				)
			);
		} else {
			$reviews = get_comments(
				array(
					'number'      => $max_reviews,
	        'status'      => 'approve',
	        'post_status' => 'publish',
	        'post_type'   => 'product',
	        'meta_key'    => 'rating',
	        'orderby'     => $order_by,
					'order'       => $order,
	        'post__in'    => $post_ids
				)
			);
		}

		$shop_page_id = wc_get_page_id( 'shop' );
		if( true === $attributes['shop_reviews'] ) {
			$max_shop_reviews = $attributes['count_shop_reviews'];
			if( $shop_page_id > 0 && $max_shop_reviews > 0 ) {
				$shop_reviews = get_comments(
					array(
						'number'      => $max_shop_reviews,
		        'status'      => 'approve',
		        'post_status' => 'publish',
		        'post_id'			=> $shop_page_id,
		        'meta_key'    => 'rating',
		        'orderby'     => $order_by,
						'order'       => $order
					)
				);
				if( is_array( $reviews ) && is_array( $shop_reviews ) ) {
					$reviews = array_merge( $reviews, $shop_reviews );
					Ivole_Reviews_Grid::$sort_order_by = $order_by;
					Ivole_Reviews_Grid::$sort_order = $order;
					usort( $reviews, array( "Ivole_Reviews_Grid", "compare_dates_sort" ) );
				}
			}
		}

		$num_reviews = count( $reviews );

		if ( $num_reviews < 1 ) {
			return __( 'No reviews to show', IVOLE_TEXT_DOMAIN );
		}

		$show_products = $attributes['show_products'];
		$product_links = $attributes['product_links'];
		$verified_text = __( '(verified owner)', IVOLE_TEXT_DOMAIN );

		$verified_reviews_enabled = false;
		if ( 'yes' === get_option( 'ivole_reviews_verified', 'no' ) ) {
			$verified_reviews_enabled = true;
		}
		$country_enabled = ('yes' === get_option( 'ivole_form_geolocation', 'no' ) ? true : false);

		$badge_link = 'https://www.cusrev.com/reviews/' . get_option( 'ivole_reviews_verified_page', Ivole_Email::get_blogdomain() ) . '/p/p-%s/r-%s';
		$badge = '<p class="ivole-verified-badge"><img src="' . plugins_url( '/img/shield-20.png', __FILE__ ) . '" alt="' . __( 'Verified review', IVOLE_TEXT_DOMAIN ) . '" class="ivole-verified-badge-icon">';
		$badge .= '<span class="ivole-verified-badge-text">';
		$badge .= __( 'Verified review', IVOLE_TEXT_DOMAIN );
		$badge .= ' - <a href="' . $badge_link . '" title="" target="_blank" rel="nofollow noopener">' . __( 'view original', IVOLE_TEXT_DOMAIN ) . '</a>';
		$badge .= '</span></p>';

		$badge_link_sr = 'https://www.cusrev.com/reviews/' . get_option( 'ivole_reviews_verified_page', Ivole_Email::get_blogdomain() ) . '/s/r-%s';
		$badge_sr = '<p class="ivole-verified-badge"><img src="' . plugins_url( '/img/shield-20.png', __FILE__ ) . '" alt="' . __( 'Verified review', IVOLE_TEXT_DOMAIN ) . '" class="ivole-verified-badge-icon">';
		$badge_sr .= '<span class="ivole-verified-badge-text">';
		$badge_sr .= __( 'Verified review', IVOLE_TEXT_DOMAIN );
		$badge_sr .= ' - <a href="' . $badge_link_sr . '" title="" target="_blank" rel="nofollow noopener">' . __( 'view original', IVOLE_TEXT_DOMAIN ) . '</a>';
		$badge_sr .= '</span></p>';

		$section_style = "border-color:" . $attributes['color_ex_brdr'] . ";";
		if ( ! empty( $attributes['color_ex_bcrd'] ) ) {
			$section_style .= "background-color:" . $attributes['color_ex_bcrd'] . ";";
		}
		$card_style = "border-color:" . $attributes['color_brdr'] . ";";
		$card_style .= "background-color:" . $attributes['color_bcrd'] . ";";
		$product_style = "background-color:" . $attributes['color_pr_bcrd'] . ";";

		$id = uniqid( 'ivole-reviews-grid-' );

	

		ob_start();
		?>
		<div class="review-box-container">
    <div class="review-head">
        <h3>Real Reviews From Real Customers  </h3>
        <div class="review-top-right d-flex align-items-center ml-auto">
            <div class="rev-stars d-flex align-items-center"><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/img/review-star.png" alt=""/> 1998 Reviews</div>
            <div class="review-arrows">

            </div>
        </div>
    </div>
    <div class="review-carousel ivole-reviews-grid owl-carousel">
        <?php foreach ( $reviews as $i => $review ){
                $rating = intval( get_comment_meta( $review->comment_ID, 'rating', true ) );
        		$order_id = intval( get_comment_meta( $review->comment_ID, 'ivole_order', true ) );
        		$country = get_comment_meta( $review->comment_ID, 'ivole_country', true );
        		$country_code = null;
        		if( $country_enabled && is_array( $country ) && isset( $country['code'] ) ) {
        			$country_code = $country['code'];
        		}
        		$product = wc_get_product( $review->comment_post_ID );
        ?>
        <div class="ivole-review-card item">
            <div class="review-item">
                <div class="image-star d-flex align-items-center">
                    <div class="star-rating"><span style="width:<?php echo ($rating / 5) * 100; ?>%;"></span></div>
                    
                    <span class="time-span"><?php echo date('m/d/y',strtotime($review->comment_date));?></span>
                </div>
                <div class="rev-prod-name">
                    <?php echo $product->get_title();?>
                </div>
                <div class="prod-rev-box d-flex">
                    <div class="rev-image-box">
                        <?php
                            $get_post_thumbnail_id = get_post_thumbnail_id($product->get_id());
                
                            if(!empty($get_post_thumbnail_id)){
                                 $image_attributes_thumbnail = wp_get_attachment_image_src( $get_post_thumbnail_id, 'medium' );
                            }else{
                                 $image_attributes_thumbnail = wp_get_attachment_image_src( 37069 , 'medium' ); //37069 37070
                            }
                        ?>
                        <span class="rev-span-img"><img src="<?php echo home_url();?>/wp-content/themes/ydg-theme-child/timthumb.php?src=<?php echo $image_attributes_thumbnail[0];?>&w=81&h=81" alt="" /></span>
                       
                    </div>
                    <div class="rev-text-box">
                        <p class="rev-text-p"><?php echo substr($review->comment_content,0,50);?></p>
                        <div class="rev-read-more">
                            <a class="read-more-rev" href="<?php echo esc_url( get_permalink( $product->get_id() ) );?>">Read More</a>
                        </div>
                        <div class="reviwer-name"><p><?php echo get_comment_author( $review );?></p></div>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
</div><!--review-box-container-->       
		<?php
		return ob_get_clean();
}

add_shortcode('custom_get_customer_review_shortcode', 'custom_get_customer_review_shortcode_function');

?>