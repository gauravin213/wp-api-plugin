<?php
/*
* Custom Get Category By Slug
*/
function custom_get_product_category_by_slug_shortcode_function($atts){

     extract( shortcode_atts(
        array(
            'cat_id' => '',
            'cate_slug' => '',
            'title'  => '',
            'title2'  => '',
            'view_more' => ''
            ), $atts )
    );
    
    
    $category = get_queried_object();
    
    $term_id = $category->term_id;
    
    $name = $category->name;
    
    if($term_id == ""){
        $term_id = $cat_id;
        $name = $title;
        
    }
    
    
    $args = array(
       'hierarchical' => 1,
       'show_option_none' => '',
       'hide_empty' => 0,
       'parent' => $term_id,
       'taxonomy' => 'product_cat',
       //'orderby' => 'name',
        //'order'   => 'DESC'
    );
    $subcats = get_categories($args);
    
    
  /* $thisCat = get_category(get_query_var('cat'));
    
    echo '<pre>';
    print_r($thisCat);
    echo '</pre>';*/
    
    ob_start();
?>
<div class="category-list">
    <div class="category-heading"><h5><?php echo $name;?></h5></div>
        <ul>
            <?php if(sizeof($subcats)==0){ ?>
            
                <?php
                $term_data = get_term($term_id);
                $get_parent_cat = get_term($term_data->parent);
                ?>
                
               <!-- <li><a href="<?php //echo get_term_link( $get_parent_cat->term_id , 'product_cat' );?>"><?php //echo $get_parent_cat->name?><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>-->
                
                
            <?php }else{ ?>
            
                <?php foreach ($subcats as $sc) { $link = get_term_link( $sc->slug, $sc->taxonomy ); ?>
            
                    <?php 
                   
                    $hide_category_from_sidebar = get_term_meta($sc->term_id, 'hide_category_from_sidebar', true);
                    
                    if ( !in_array( 'Hide', $hide_category_from_sidebar, true ) ) {
                        
                        ?>
                        <li><a href="<?php echo $link;?>"><?php echo $sc->name?><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
                        <?php
                          
                    }
                    ?>
                            
                <?php } ?>
                
            <?php } ?>
            
            
            
            
            
            
           
            
            <?php if(!empty($view_more) && $view_more == 'true'){ ?>
                <li><a href="<?php echo wc_get_page_permalink( 'shop' );?>">More <i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
            <?php }?>
                
        </ul>
    </div><!--category-list-->
</div>                      
                    
<?php
return ob_get_clean();
}
add_shortcode('custom_get_product_category_by_slug_shortcode', 'custom_get_product_category_by_slug_shortcode_function');

?>