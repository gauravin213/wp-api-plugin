<?php
/*
* Custom Testing code
*/
function custom_testing_code_shortcode_function($atts){

    extract( shortcode_atts(
        array(
            'cat_id' => '',
            'cate_slug' => '',
            'title'  => '',
            'make' => '',
            ), $atts )
    );
    
    ob_start();
?>
<!---------------------------------------------------->

<?php
$args = array(
    	'posts_per_page'   =>  -1,
        //'orderby'    => 'rand',
        'order'      => 'DESC',
    	'post_type'        => 'shop_coupon',
    	'post_status'      => 'publish',
    	'meta_query'    => array(
    	    'relation'      => 'AND',
    	    array(
    	        'key'       => 'usage_limit',
    	        'value'     => '1',
    	        'compare'   => '=',
    	    ),
    	    array(
    	        'key'       => 'usage_limit_per_user',
    	        'value'     => '1',
    	        'compare'   => '=',
    	    ),
    	    array(
    	        'key'       => 'usage_count',
    	        'value'     => '0',
    	        'compare'   => '=',
    	    ),
    	    array(
    	        'key'       => 'custom_auto_coupon_title',
    	        'value'     => 'INSTANT',
    	        'compare'   => '=',
    	    )
    	)
    );
    
    $query = new WP_Query( $args );
    
    $c_arr = array();
    if($query->have_posts()){
        while( $query->have_posts() ) {  $query->the_post();
        
            $coupon_code_title = get_the_title();
            
            $post_id = get_the_ID(); 
            
            
            echo 'coupon_code_title'.$coupon_code_title; echo '<br>';
            echo '$post_id'.$post_id; echo '<br><br>';
            
            //update_post_meta( $post_id, 'minimum_amount', '50' );
            //update_post_meta( $post_id, 'coupon_amount', 10 );
            //update_post_meta( $post_id, 'individual_use', 'yes' );
             
            
            
         
        }
        wp_reset_postdata();
    }
    
?>

<!---------------------------------------------------->
<?php
return ob_get_clean();
}
add_shortcode('custom_testing_code_shortcode', 'custom_testing_code_shortcode_function');

?>