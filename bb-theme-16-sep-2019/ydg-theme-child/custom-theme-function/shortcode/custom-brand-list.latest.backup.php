<?php
/*
* Start:add shortcode for brand
*/
function custom_brand_shortcode_function($atts){

  extract( shortcode_atts(
        array(
           'id' => '',
            'content'  => '',
            "cate_id" => '',
            "cat_icon_class" => '',
            "make" => '',
            ), $atts )
    );

ob_start();
?>
<div class="our-professional">
    <div class="container">
        <div class="row">
            
            
            <?php
            if(!empty($cate_id)){
                
                $cate_ids = explode(',', $cate_id);
    
                foreach($cate_ids as $cate_id){  
                  
                    $get_datas = get_term($cate_id); 
                   
                    $thumbnail_id = get_term_meta( $get_datas->term_id, 'thumbnail_id', true );
                    
                    $imgsize = "full";
                    if(!empty($thumbnail_id)){
                        $image_attributes_thumbnail = wp_get_attachment_image_src( $thumbnail_id, $imgsize ); 
                    }else{
                        $image_attributes_thumbnail = wp_get_attachment_image_src(37069, $imgsize );//37069 37070
                    } 
                     
                    $cate_img_url = $image_attributes_thumbnail[0]; echo '<br>';
                    
                    $cate_link_url = get_term_link($get_datas->slug, 'product_cat');
                    
                    if($cate_id == 13144){
                        $make_name = 'Ford';
                    }else if($cate_id == 13145){
                         $make_name = 'Dodge';
                    }else if($cate_id == 13146){
                         $make_name = 'Chevrolet';
                    }else if($cate_id == 13274){
                         $make_name = 'commercialtrucks';
                    }
                    ?>
                
                    <div class="col-sm-3  loop">
                        <div class="partners">
                            <a href="<?php echo $cate_link_url;?>">
                                <img src="<?php echo $cate_img_url;?>" alt="Brand">
                            </a>
                          
                            <?php
                            global $wpdb;

                            $brand_array = array();
                            $brand_sub_array = array();
                            
                            $query_makes =  'SELECT DISTINCT engine FROM `wp_ebay_compats` WHERE make = "'.$make_name.'" AND product_id IN (SELECT ID FROM '.$wpdb->prefix.'posts WHERE post_type="product" AND post_status="publish")';
                            $results_makes = $wpdb->get_results( $query_makes );
                            
                            foreach($results_makes as $results_make){
                                $query_engine =  "SELECT DISTINCT product_id  FROM `wp_ebay_compats` WHERE engine = '".$results_make->engine."'";
                                $results_engines = $wpdb->get_results( $query_engine );
                                
                                foreach($results_engines as $results_engine){
                                   
                                    $brand_sub_array[$results_make->engine][] = $results_engine->product_id;
                                     
                                    $brand_array = $brand_sub_array;
                                }
                                
                            }
                            
                        
                            ?>
                            <ul class="custom-category-menu-list" style="max-height: 400px;overflow-y: auto;">
                                <?php foreach ($brand_array as $key => $value) {  
                                $ppp = implode(",",$brand_array[$key]); 
                                $base64_encoded = base64_encode($ppp);
                                ?>
        
                                    <li>
                                        <a href="https://www.dieseltruckpartsdirect.com/sandbox2/shop?pids=<?php echo $base64_encoded;?>"><?php echo $key;?></a>
                                    </li>
                                
                                <?php } ?>
                            </ul>
                           
            
                        </div><!--partners-->
                    </div>
                    <?php
                    
                    
                }
                
            }
            ?>
            <div class="col-sm-3">
                <div class="partners">
                    <a href="<?php echo home_url();?>/shop">
                        <img src="<?php echo home_url();?>/wp-content/uploads/2019/06/shopbybrand.jpg" alt="Brand">
                    </a>
                </div><!--partners-->
            </div>
        </div>
    </div>
</div><!--our-professional-->

<?php
return ob_get_clean();
}
add_shortcode('custom_brand_shortcode', 'custom_brand_shortcode_function');
/*
* End:add shortcode for brand
*/



/*
* Shop Page Product Filter Query
*/
function add_query_vars_filter_pids( $vars ){
    $vars[] = 'pids';
    return $vars;
}
add_action( 'query_vars', 'add_query_vars_filter_pids' );


function filter_pre_get_posts_pids( $wp_query ) {
    if (!is_archive() || !$wp_query->is_main_query() ) {
        return;
    }

    $pids = get_query_var('pids');
    if (isSet($pids ) && !empty($pids )) {
        
        $base64_decoded = base64_decode($pids);
       
        $pids_exploded = explode(",", $base64_decoded);
        $wp_query->set('post__in', $pids_exploded);
    }
}
add_action('pre_get_posts', 'filter_pre_get_posts_pids' );
/*
* Shop Page Product Filter Query
*/
?>