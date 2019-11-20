<?php
/*
* Start:add shortcode for brand
*/
function custom_brand_shortcode_function($atts){

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
<div class="brand-list-desktop-view"></div>
<div class="our-professional" id="custom_brand_lits_top">
    <div class="container">
        <div class="row">
            
            <?php
            if(!empty($cat_id)){
                
                $cate_ids = explode(',', $cat_id);
    
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
                    
                    ?>
                
                    <div class="col-sm-3  loop">
                        <div class="partners">
                            <a class="brand-item-link" href="<?php echo $cate_link_url;?>">
                                <img src="<?php echo $cate_img_url;?>" alt="Brand">
                            </a>
                           
                            <?php
                            $term_id = $cate_id;
                            $args = array(
                               'hierarchical' => 1,
                               'show_option_none' => '',
                               'hide_empty' => 0,
                               'parent' => $term_id,
                               'taxonomy' => 'product_cat',
                               'orderby' => 'term_order',
                                'order'   => 'ASC'
                            );
                            $subcats = get_categories($args);//print_r($subcats);
                            ?>
                            <ul class="custom-category-menu-list"  id="diesel_cat_dropdown_<?php echo$term_id;?>">
                                <?php foreach ($subcats as $sc) { $link = get_term_link( $sc->slug, $sc->taxonomy ); ?>
                                
                                
                                    <?php 
                                    $hide_category_from_dropdown_ = get_term_meta($sc->term_id, 'hide_category_from_dropdown_', true);
                                    $category_title = str_replace("Powerstroke"," ",$sc->name);
                                    //if ( !in_array( 'Hide', $hide_category_from_dropdown_, true ) ) {  ?>
                                        <li><a href="<?php echo $link;?>"><?php echo str_replace("Powerstroke"," ",$sc->name);?></a></li>
                                    <?php //} ?>
                                
                                   
                                
                                <?php } ?>
                            </ul>
                           
            
                        </div><!--partners-->
                    </div>
                    <?php
                    
                    
                }
                
            }
            ?>
           
            
            <!--<div class="col-sm-3">
                <div class="partners">
                    <a href="<?php echo home_url();?>/shop">
                        <img src="<?php echo home_url();?>/wp-content/uploads/2019/06/Untitled-1-1.jpg" alt="Brand">
                    </a>
                </div>
            </div>
            
            <div class="col-sm-3">
                <div class="partners">
                    <a href="<?php echo home_url();?>/shop">
                        <img src="<?php echo home_url();?>/wp-content/uploads/2019/06/shopbybrand.jpg" alt="Brand">
                    </a>
                </div>
            </div>-->
            
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
?>