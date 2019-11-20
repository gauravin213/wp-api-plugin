<?php

/*
* Add custom product tab
*/
add_filter( 'woocommerce_product_tabs', 'woo_custom_product_tabs' );
function woo_custom_product_tabs( $tabs ) {

    //unset( $tabs['description'] );  // Remove the description tab
  
    $prod_id = get_the_ID();
    //$cus_woo_tab_technical_doc = get_post_meta($prod_id,'cus_woo_tab_technical_doc',true);
    
    $fields = get_field('upload_files', $prod_id, true);
    
    if (count($fields)!=0 && $fields!="") {
       // Adds the other products tab
        $tabs['technical_products_tab'] = array(
            'title'     => __( 'Technical Documents', 'woocommerce' ),
            'priority'  => 120,
            'callback'  => 'woo_technical_products_tab_content'
        );
    }
    

    return $tabs;

}

// New Tab contents
function woo_technical_products_tab_content() {
   
    $prod_id = get_the_ID();
   
    $fields = get_field('upload_files', $prod_id, true);
    
    foreach($fields as $field){
       
        
        //echo $field['files']['title']; echo "<br>";
        
        //echo $field['files']['id']; echo "<br>";
        
        //echo $field['files']['filename']; echo "<br>";
        
        //echo $field['files']['url']; echo "<br>";
        
        //echo $field['files']['link']; echo "<br>";
        
        //echo $field['files']['name']; echo "<br>";
        
        //echo $field['files']['icon']; echo "<br>";
        
        //echo $field['files']['sizes']['thumbnail']; echo "<br>";
        
        //echo "==>".count($fields);
        ?>
        
        <a href="<?php echo $field['files']['url'];?>" target="_blank" class="techical_doc_action">
            <div>
                <img src="<?php echo $field['files']['icon'];?>">
            </div>
             
             <div>
                  <span><?php echo $field['files']['name'];?></span>
             </div>
        </a>
        <?php
        
    }
    
    ?>
    <div class="container">
      <!-- Trigger the modal with a button -->
     <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>-->
    
      <!-- Modal -->
      <div class="modal fade modal-design" id="technical_doc_modal" role="dialog">
        <div class="modal-dialog">
            <button type="button" class="close abs-close" data-dismiss="modal">×</button>
            <!-- Modal content-->
            <div class="dialog">
                <h2>&nbsp;</h2>
                <div>
                    <iframe id="technical_doc_modal_src" src="" width="100" height="600px"></iframe>
                    <!--<p class="em-btns"><button type="button" class="close" data-dismiss="modal">Cancel</button></p>-->
                </div>
            </div>
        </div>
    </div>
      
    </div>
    
    <script>
        jQuery(document).ready(function(){
            
            jQuery(document).on('click', '.techical_doc_action', function(e){
                
                e.preventDefault();
                
                var target = jQuery(this);
                
                //target.addClass('custom_overlay');
                
                var data_href = target.attr('href'); //alert(data_href);
                
                jQuery('#technical_doc_modal_src').attr('src', data_href);
                
                //setTimeout(function(){ 
                    
                    //target.removeClass('custom_overlay');
                    
                    jQuery('#technical_doc_modal').modal({backdrop: 'static', keyboard: false}) 
                    
                    
                //}, 3000);
                
                
                
                
            });
            
        });
    </script>
    
    <?php
    
    
  /* echo '<pre>';
    print_r($fields);
    echo '</pre>';*/

    
}


/*add_action( 'add_meta_boxes', 'custom_admin_metabox');
function custom_admin_metabox(){

   add_meta_box( 'cus_woo_tab_technical_doc', 'Product Tab - Technical Description', 'cus_woo_tab_technical_doc', 'product', 'normal', 'high' );
    
}


function cus_woo_tab_technical_doc(){
    global $post;
    $cus_woo_tab_technical_doc = get_post_meta( $post->ID, 'cus_woo_tab_technical_doc', true );
    $content = $cus_woo_tab_technical_doc;
    $editor_id = 'mycustomeditor_technical_doc';
    $settings = array(
        'tinymce' => array(
            'height' => 200
        )
    );
    wp_editor( $content, $editor_id, $settings);
}


function destination_save_metabox( $post_id, $post ) {
    
    //cus_woo_tab_technical_doc
    if (isset( $_POST['mycustomeditor_technical_doc'] ) ) {
        $sanitized = wp_filter_post_kses( $_POST['mycustomeditor_technical_doc'] );
        update_post_meta( $post->ID, 'cus_woo_tab_technical_doc', $sanitized );
    }

}
add_action( 'save_post', 'destination_save_metabox', 1, 2 );*/
/*
* Add custom product tab
*/



/*
* Add custom element after terms & condition
*/
/*add_action('woocommerce_checkout_after_terms_and_conditions', 'checkout_additional_checkboxes');
function checkout_additional_checkboxes( ){
    ?>
    <p class="form-row custom-checkboxes" id="myModal" style="display: none;">
        <?php 
        if (isset($_POST['billing_state'])) {
           echo "string";
        }
        ?>
       <img src="<?php echo home_url().'/wp-content/themes/ydg-theme-child/images/alert-a2.png'?>">
       California Proposition 65 requires businesses to provide warnings to Californians about significant exposure to chemicals that cause cancer, birth defects, or other reproductive harm. Add details about the warning you want to show California buyers. We'll add a warning symbol and the word 'WARNING:' before the description you enter here, and we’ll add 'For more information go to www.p65warnings.ca.gov' following your description.
    </p>
    
    <style>
        #myModal{
            border: 1px solid #efe9e9;
        }
    </style>
    <?php
}*/
/*
* Add custom element after terms & condition
*/

?>