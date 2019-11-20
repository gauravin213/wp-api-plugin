<?php

add_filter( 'manage_edit-shop_order_columns', 'MY_COLUMNS_FUNCTION' );
function MY_COLUMNS_FUNCTION( $columns ) {
    
  	$columns = array(
            'cb' => '<input type="checkbox" />',
            'order_number' => __( 'Order' ),
            'CUSTOM_ORDER_DETAILS' => __( 'Purchase Details' ),
            //'CUSTOM_PAYPAL_INVOICE_STATUS' => __( 'Paypal Invoice Status' ),
           // 'CUSTOM_ORDER_QTY' => __( 'Qty' ),
            //'wpl_order_src' => __( '' ),
            'billing_address' => __( 'Billing' ),
            'shipping_address' => __( 'Shipping' ),
            'order_total' => __( 'Total' ),
            'order_status' => __( 'Status' ),
            'wwpp_order_type' => __( 'Order Type' ),
            'woe_export_status' => __( 'Export Status' ),
            'wc_actions' => __( 'Actions' ),
            'ivole-review-reminder' => __( 'Review Reminder' ),
            'order_date' => __( 'Date' )
        );

    return $columns;
  	
  	
}

add_action( 'manage_shop_order_posts_custom_column', 'MY_COLUMNS_VALUES_FUNCTION', 11 );
function MY_COLUMNS_VALUES_FUNCTION( $column ) {
	global $post;
	switch( $column ) {

        case 'order_number' :

            $order_id = $post->ID;
	        $order = wc_get_order( $order_id ); // The WC_Order object instance
	        
	        $count = 1;
	        
	        
	        echo '<div>';
	        
	        
	        echo '<div>';
	        echo '<a href="'.home_url().'/wp-admin/post.php?post='.$order_id.'&action=edit"><strong>#'.$order_id.'</strong></a>';
	        echo '<style>.order-view{display: none;}</style>';
	        echo '</div>';
	        
	        
	        echo '<div>';
            foreach( $order->get_items() as $item_id => $item ){
                
                //if($count == 1){
                  
                    $get_post_thumbnail_id = get_post_thumbnail_id($item->get_product_id());
        
                    if(!empty($get_post_thumbnail_id)){
                         $image = wp_get_attachment_image_src( $get_post_thumbnail_id, 'thumbnail' );
                    }else{
                         $image = wp_get_attachment_image_src( 37069 , 'thumbnail' ); //37069 37070
                    }
                    
                    
                    echo '<img src="'.$image[0].'" data-id="'.$item->get_product_id().'" style="width: 30%;">';
                    
                    
                    //break;
                //}
               //$count ++;
            }
            echo '</div>';
            
            echo '<div>';
            

            break;

        case 'CUSTOM_ORDER_DETAILS' :

            $order_id = $post->ID;
	        $order = wc_get_order( $order_id ); // The WC_Order object instance
	        
	        $count = 1;
	        
	        
            $user_id = get_post_meta($order_id, '_customer_user', true);
            $user_meta = get_userdata($user_id);
            $display_name = $user_meta->display_name;
            
            
            echo '<div class="custom_tb_data_container">';
            
            
            echo '<div style="margin-bottom: 18px;"><a href="'.home_url().'/wp-admin/user-edit.php?user_id='.$user_id.'">'.$display_name.'</div>';
	        
            foreach( $order->get_items() as $item_id => $item ){
                
                
                //if($count == 1){
                    
                    $product_id = $item->get_product_id();
                    
                    $product_quantity = $item->get_quantity();
        
                    $product_variation_id = $item->get_variation_id();
                    
                    // Check if product has variation.
                    if ($product_variation_id) { 
                        $product = new WC_Product($product_variation_id);
                    } else {
                        $product = new WC_Product($product_id);
                    }
                    
                    // Get Product Name
                    echo '<div><a href="'.get_permalink($product_id).'">'.$product->get_name().'</a>   <b> X '.$product_quantity.'</b></div>';
                
                    // Get SKU
                    echo "<div>Sku: ".$sku = $product->get_sku().'</div>';
                    
                    
                    
                  
                    
                    //break;
                
                //}
                //$count ++;
               
            }
            
            //Get paypal Invoice
            $invoice_id = get_post_meta( $order_id, 'wholesaler_payment_invoice_id', true ); 
            $invoice_number = get_post_meta( $order_id, 'wholesaler_payment_number', true );
            $invoice_status = get_post_meta( $order_id, 'wholesaler_payment_invoice_status', true );
            
            if($invoice_id && !empty($invoice_id)){
                echo '<div class="paypal_invoice_info">';
                echo '<div><strong>Paypal Invoive Info</strong></div>';
                echo '<div>Invoice id. : '.$invoice_id.'</div>';
                echo '<div>Invoice no. : '.$invoice_number.'</div>';
                
                if($invoice_status == 'PAID'){
                     echo '<div>Invoice status. : <span class="invoice_status_paid">'.$invoice_status.'</span></div>';
                }else{
                     echo '<div>Invoice status. : <span class="invoice_status_other">'.$invoice_status.'</span></div>';
                }
               
                echo '</div>';
            }

            //Get Net 30 invoice
            $net30_invoice_number = get_post_meta( $order_id, 'net30_invoice_number', true);
            if ($net30_invoice_number && !empty($net30_invoice_number)) {

                echo '<div class="paypal_invoice_info">';
                echo '<div><strong>Net 30 Invoive Info</strong></div>';
                
                $net30_invoice_number = sprintf("%04d", $net30_invoice_number);
                
                echo '<div>Invoice no. : '.$net30_invoice_number.'</div>';
                $get_status = $order->get_status();
                if ( $get_status == 'completed') {
                    echo '<div>Invoice status. : <span class="invoice_status_paid">PAID</span></div>';
                }else{
                    echo '<div>Invoice status. : <span class="invoice_status_other">SENT</span></div>';
                }
                echo '</div>';
            }


            


      

            echo '</div>';

            break;
            
            
            
            
        case 'CUSTOM_ORDER_QTY' :
            
            $order_id = $post->ID;
	        $order = wc_get_order( $order_id ); 
	        
	        $count = 1;
	        
            foreach( $order->get_items() as $item_id => $item ){
                
                
                if($count == 1){
                    
                     echo $product_quantity = $item->get_quantity();
                    
                    break;
                }
                $count ++;
               
            }
            break;
            
        case 'CUSTOM_PAYPAL_INVOICE_STATUS' :
            
            $order_id = $post->ID;
	       
	        echo 'pppppppppppppp';
            break;

        default :
                break;
    }
}


?>