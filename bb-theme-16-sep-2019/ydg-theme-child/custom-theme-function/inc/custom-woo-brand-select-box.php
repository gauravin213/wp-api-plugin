<?php
/*
*  Custom Woocommerce Brand Select Box On Shop page
*/
function add_query_vars_filter( $vars ){
    $vars[] = 'myBrandAttr';
    return $vars;
}
add_action( 'query_vars', 'add_query_vars_filter' );


function filter_pre_get_posts( $wp_query ) {
    if (!is_archive() || !$wp_query->is_main_query() ) {
        return;
    }

    $myBrandAttr = get_query_var('myBrandAttr');
    if (isSet($myBrandAttr ) && !empty($myBrandAttr )) {
        /*$wp_query->set('tax_query', array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $myBrandAttr ,
                'include_children' => true,
                'operator' => 'IN'
            )
        ));*/
        
        $myBrandAttr_exploded = explode(" ", $myBrandAttr);
        
       /* echo '<pre>';
        print_r($myBrandAttr_exploded);
        echo '</pre>';*/
        
         $wp_query->set('post__in', $myBrandAttr_exploded);
    }
}
add_action('pre_get_posts', 'filter_pre_get_posts' );


//add_action( 'woocommerce_before_shop_loop', 'ps_selectbox', 25 );
function ps_selectbox() {
    $per_page = filter_input(INPUT_GET, 'myBrandAttr', FILTER_SANITIZE_NUMBER_INT);     
    echo '<div class="woocommerce-myBrandAttr">';
    echo '<select onchange="if (this.value) window.location.href=this.value">'; 
    echo "<option ".selected( $per_page, $value )." value='?myBrandAttr=all'>Select Brand</option>";
    $category_names = get_terms('product_cat'); //taxonomy
    foreach($category_names as $category_name){
        if(!empty($category_name->term_id)){
            $brand_names = get_term_meta( $category_name->term_id, '_woocommerce_gpf_data', false );
            foreach($brand_names as $brand_name){
                if(!empty($brand_name['brand'])){
                    $cat_id = $category_name->term_id;
                    $brand_title = $brand_name['brand'];
                    echo "<option ".selected( $per_page, $cat_id )." value='?myBrandAttr=$cat_id'>$brand_title</option>";
                }
            }
    
        }
    }
    echo '</select>';
    echo '</div>';
}
?>