<?php
function custom_diese_save_post( $post_id ) {
    
    $get_post_type = get_post_type($post_id);
    
    if($get_post_type == 'shop_order'){
    
        $customer_user_id = $_POST['customer_user'];
    
        $get_user_role = get_user_role('wholesale_customer', $customer_user_id);
        
        if ($get_user_role) { 
            
            set_wholesale_price_diesel($post_id);
            
        }else{
           // other user
        }
     
    }else{
        // other post type
    }
}
add_action( 'save_post', 'custom_diese_save_post', 11, 1);

function set_wholesale_price_diesel($order_id){
    
   /**/
        $order = wc_get_order( $order_id ); // The WC_Order object instance
        foreach( $order->get_items() as $item_id => $item ){
            
            $wholesale_customer_wholesale_price = get_post_meta( $item->get_product_id() , 'wholesale_customer_wholesale_price', true ); 
            if($wholesale_customer_wholesale_price!=''){
            // A static replacement product price
            $product_quantity = (int) $item->get_quantity(); // product Quantity
    
            // The new line item price
            $new_line_item_price = $wholesale_customer_wholesale_price * $product_quantity;
            
            /**Disscount rule***/
               $wwpp_post_meta_quantity_discount_rule_mapping = get_post_meta( $item->get_product_id() , 'wwpp_post_meta_quantity_discount_rule_mapping', true ); 
    
                if(!empty($wwpp_post_meta_quantity_discount_rule_mapping)){ 
                    
                    $qty = $product_quantity;
                    
                    foreach ($wwpp_post_meta_quantity_discount_rule_mapping as $w_data) {
                       $start_qty = $w_data['start_qty']-1;
                       $end_qty = $w_data['end_qty']+1;
                       $price_type = $w_data['price_type'];
                       $wholesale_price = $w_data['wholesale_price'];
                       
                       if($price_type == 'percent-price'){  
                           
                           if($qty > $start_qty && $qty < $end_qty){
                              $disscount_price = $wholesale_price;
                              $new_line_item_price = $new_line_item_price * $wholesale_price / 100;
                           }
                           
                       }
                       
                       if($price_type == 'fixed-price'){  
                           
                            if($qty > $start_qty && $qty < $end_qty){
                                $disscount_price = $wholesale_price;
                                $new_line_item_price = $disscount_price * $product_quantity;
                            }
                       }
                       
                       
                    }
                }
            /**Disscount rule***/
    
            // Set the new price
            $item->set_subtotal( $new_line_item_price ); 
            $item->set_total( $new_line_item_price );
    
            // Make new taxes calculations
            $item->calculate_taxes();
    
            $item->save(); // Save line item data
         }
        }
        
        // Make the calculations  for the order
        $order->calculate_totals();

        $order->save(); // Save and sync the data
        /**/
        
        
        
        
        /**/
        /*// Store Order ID in session so it can be re-used after payment failure
        WC()->session->order_awaiting_payment = $order_id;
    
        // Process Payment
        $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
        
        echo '<pre>';
        print_r($available_gateways);
        foreach($available_gateways as $key => $value){
            echo "==>".$key; echo '<br>';
        }
        echo '</pre>';
        die('@');
        
        $result = $available_gateways[ 'paypal' ]->process_payment( $order_id );
    
        // Redirect to success/confirmation/payment page
        if ( $result['result'] == 'success' ) {
    
            $result = apply_filters( 'woocommerce_payment_successful_result', $result, $order_id );
    
            wp_redirect( $result['redirect'] );
            exit;
        }*/
        /**/
}

function get_user_role($user_role, $user_id){

    $user_meta = get_userdata($user_id);
    $user_roles = $user_meta->roles;

    if ( in_array($user_role, $user_roles, true ) ) {
        return true;
    }else{
        return false;
    }

}
?>