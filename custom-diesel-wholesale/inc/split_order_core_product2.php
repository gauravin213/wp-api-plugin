<?php
/*
* Check Order splited or note
*/
function filter_woocommerce_payment_complete_order_status( $status, $order_id ) { 
    
    $arr1 = array();
	$arr2 = array();
	$arr3 = array();
	$arr4 = array();
	$arr5 = array();
	$maim_arr = array();

	$_core_product_price = '';

	$total_flat = 0;

	$count1 = 0;
	$count2 = 0;
	$count3 = 0;
	$count4 = 0;
	$count5 = 0;

	$flag1 = 0;
	$flag2 = 0;
	$flag3 = 0;
	$flag4 = 0;
	$flag5 = 0;


	$simple_line_item_product_status = $status;

    $order = wc_get_order( $order_id );
    // Gets fees and taxes
	$fees  = $order->get_fees();
	$taxes = $order->get_taxes();
	$item_count = $order->get_item_count();

    $billing_address = $order->get_data()['billing'];
    $shipping_address = $order->get_data()['shipping'];
    $order_items = $order->get_items();

	foreach( $order_items as $item_id => $item ){

		$product_id = $item->get_product_id();

		$product_name = $item->get_name();

		$product = get_product($product_id);

		$stock_qty = $product->get_stock_quantity();

		if (wc_get_order_item_meta( $item_id, '_is_backorder', true )){ 

		    $_core_product_price = wc_get_order_item_meta( $item_id, '_core_product_price', true );

		    if ($_core_product_price !=0 || $_core_product_price!='') {

			    if ($_core_product_price == '0') {

			    	$simple_line_item_product_status = 'core-backorder0';

		    		$arr4['core_product_backorder_without_charge'][$item_id] = array(
		    			'product_name' => $product_name,
		    			'item_id'=>$item_id,
		    			'item'=>$item
		    		);
		    	}else {

		    		$simple_line_item_product_status = 'core-backorder1';

		    		$arr3['core_product_backorder_with_charge'][$item_id] = array(
		    			'product_name' => $product_name,
		    			'item_id'=>$item_id,
		    			'item'=>$item
		    		);
		    	}
		    	
		    } else {

		    	$simple_line_item_product_status = 'cus-backorder';

		    	$arr5['simple_product_backorder'][$item_id] = array(
		    		'product_name' => $product_name,
		    		'item_id'=>$item_id,
		    		'item'=>$item
		    	);
		    	
		    }
		    

		}
		else{
	
		    $_core_product_price = wc_get_order_item_meta( $item_id, '_core_product_price', true );

	    	if ($_core_product_price == '0') {
	    		
	    		$simple_line_item_product_status = 'core-charges';

	    		$arr2['core_product'][$item_id] = array(
	    			'product_name' => $product_name,
	    			'item_id'=>$item_id,
	    			'item'=>$item
	    		);

	    	}else {

	    		$simple_line_item_product_status = 'processing';

	    		$arr1['simple_product'][$item_id] = array(
	    			'product_name' => $product_name,
	    			'item_id'=>$item_id,
	    			'item'=>$item
	    		);
	    	}
		}


		
	}



	$count1 = sizeof($arr1);
	if ($count1!=0) {
		$flag1 = 1;
	}

	$count2 = sizeof($arr2); 
	if ($count2!=0) {
		$flag2 = 1;
	}

	$count3 = sizeof($arr3); 
	if ($count3!=0) {
		$flag3 = 1;
	}

	$count4 = sizeof($arr4); 
	if ($count4!=0) {
		$flag4 = 1;
	}

	$count5 = sizeof($arr5); 
	if ($count5!=0) {
		$flag5 = 1;
	}

	$total_flat = $flag1 + $flag2 + $flag3 + $flag4 + $flag5;

	if ($total_flat > 1) {
        
        return 'on-hold';
	
	}else{

		return $simple_line_item_product_status;
	}
	
}
add_filter( 'woocommerce_payment_complete_order_status', 'filter_woocommerce_payment_complete_order_status', 11, 2 );
/*
* Check Order splited or note
*/



/*
* If order is suborder then re-calculate total
*/
function order_id_custom_diese_calculate_taxes_save_post( $order_id ) {
    
    $_suborder_product_type = get_post_meta( $order_id, '_suborder_product_type', true);
    if($_suborder_product_type && !empty($_suborder_product_type)){
        $order = wc_get_order( $order_id ); 
        $order->calculate_totals(); 
        $order->save();
    }

}
add_action( 'save_post', 'order_id_custom_diese_calculate_taxes_save_post', 11, 999999999999999999999);
/*
* If order is suborder then re-calculate total
*/





/*
* Order Item meta key and value filter
*/
function custom_core_woocommerce_hidden_order_itemmeta_fun($arr) {
    $arr[] = '_core_product_price';
    return $arr;
}
add_filter('woocommerce_hidden_order_itemmeta', 'custom_core_woocommerce_hidden_order_itemmeta_fun', 10, 1);


//add_filter( 'woocommerce_order_item_display_meta_key', 'custom_core_change_order_item_meta_title', 20, 3 );
function custom_core_change_order_item_meta_title( $key, $meta, $item ) {
    if ( '_line_item_backorder_stock_status' === $meta->key ) { $key = 'Item Stock Status'; }
    return $key;
}

//add_filter( 'woocommerce_order_item_display_meta_value', 'custom_core_change_order_item_meta_value', 20, 3 );
function custom_core_change_order_item_meta_value( $value, $meta, $item ) {

    if ( '_is_backorder' === $meta->key ){

	    $value = 'Backorder';
	   		
    }

    return $value;
}


/*add_action( 'woocommerce_add_order_item_meta',  'custom_core_woocommerce_add_order_item_meta', 10, 2 );
function custom_core_woocommerce_add_order_item_meta( $item_id, $values ) {
	if ($values['data']->stock_quantity < 1 && $values['data']->stock_status == 'onbackorder') {
		woocommerce_add_order_item_meta( $item_id, 'Product', 'Backorder');
	}
}*/
/*
* Order Item meta key and value filter
*/






/*
* Create suborder function
*/
add_action('woocommerce_order_status_processing', 'custom_processing', 10, 1);
add_action('woocommerce_order_status_on-hold', 'custom_processing', 10, 1);
function custom_processing($order_id) {

	if (is_admin()) {
		return;
	}

	$arr1 = array();
	$arr2 = array();
	$arr3 = array();
	$arr4 = array();
	$arr5 = array();
	$maim_arr = array();

    $order = wc_get_order( $order_id );
    // Gets fees and taxes
	$fees  = $order->get_fees();
	$taxes = $order->get_taxes();
	$item_count = $order->get_item_count();

    $billing_address = $order->get_data()['billing'];
    $shipping_address = $order->get_data()['shipping'];
    $order_items = $order->get_items();

	foreach( $order_items as $item_id => $item ){

		$product_id = $item->get_product_id();

		$product_name = $item->get_name();

		$product = get_product($product_id);

		$stock_qty = $product->get_stock_quantity();

		if (wc_get_order_item_meta( $item_id, '_is_backorder', true )){ 

		    $_core_product_price = wc_get_order_item_meta( $item_id, '_core_product_price', true );

		    if ($_core_product_price !=0 || $_core_product_price!='') {

			    if ($_core_product_price == '0') {
		    		$arr4['core_product_backorder_without_charge'][$item_id] = array(
		    			'product_name' => $product_name,
		    			'item_id'=>$item_id,
		    			'item'=>$item
		    		);
		    	}else {
		    		$arr3['core_product_backorder_with_charge'][$item_id] = array(
		    			'product_name' => $product_name,
		    			'item_id'=>$item_id,
		    			'item'=>$item
		    		);
		    	}
		    	
		    } else {

		    	$arr5['simple_product_backorder'][$item_id] = array(
		    		'product_name' => $product_name,
		    		'item_id'=>$item_id,
		    		'item'=>$item
		    	);
		    	
		    }
		    

		}
		else{
	
		    $_core_product_price = wc_get_order_item_meta( $item_id, '_core_product_price', true );

	    	if ($_core_product_price == '0') {
	    		
	    		$arr2['core_product'][$item_id] = array(
	    			'product_name' => $product_name,
	    			'item_id'=>$item_id,
	    			'item'=>$item
	    		);

	    	}else {

	    		$arr1['simple_product'][$item_id] = array(
	    			'product_name' => $product_name,
	    			'item_id'=>$item_id,
	    			'item'=>$item
	    		);
	    	}
		}


		
	}



	$count1 = sizeof($arr1);
	if ($count1!=0) {
		$flag1 = 1;
	}

	$count2 = sizeof($arr2); 
	if ($count2!=0) {
		$flag2 = 1;
	}

	$count3 = sizeof($arr3); 
	if ($count3!=0) {
		$flag3 = 1;
	}

	$count4 = sizeof($arr4); 
	if ($count4!=0) {
		$flag4 = 1;
	}

	$count5 = sizeof($arr5); 
	if ($count5!=0) {
		$flag5 = 1;
	}

	$total_flat = $flag1 + $flag2 + $flag3 + $flag4 + $flag5;

	if ($total_flat > 1) {

		$maim_arr = array($arr1, $arr2, $arr5, $arr3, $arr4,);
		$count_or = 1;

		foreach ($maim_arr as $maim_arr_data) {

			foreach ($maim_arr_data as $key => $value) {
				
				$type = $key;

				create_custom_suborder($order_id, $maim_arr_data, $type, $count_or);

				$count_or++;
			}
		}
	}



}


function create_custom_suborder( $main_order_id, $maim_arr_data, $type, $order_counter) {
	

	$sub_or_total = 0;
	$line_item_qty_total = 0;

	$main_order                 = wc_get_order( $main_order_id );
	$main_order_post            = get_post( $main_order_id );
	$currentUser                = wp_get_current_user();
	$original_main_order_status = get_post_status( $main_order_id );


	if ($type == 'core_product') {
		$count_or_type = 'Core Product';
		$suborder_status = 'wc-core-charges';
	}

	if ($type == 'simple_product') {
		$count_or_type = 'Simple Product';
		$suborder_status = 'wc-processing';  //wc-processing
	}

	//wc-cus-backorder
	if ($type == 'simple_product_backorder') { 
		$count_or_type = 'Simple Product(backorder)';
		$suborder_status = 'wc-cus-backorder';
	}

	//wc-core-backorder0
	if ($type == 'core_product_backorder_without_charge') {
		$count_or_type = 'Core Product(Backorder No)';
		$suborder_status = 'wc-core-backorder0';
	}

	//wc-core-backorder1
	if ($type == 'core_product_backorder_with_charge') {
		$count_or_type = 'Core Product(Backorder Yes)';
		$suborder_status = 'wc-core-backorder1';
	}


	$order_data = array(
		'post_type'     => 'shop_order',
		'post_title'    => $main_order_post->post_title,
		'post_status'   => $suborder_status,
		'ping_status'   => 'closed',
		'post_author'   => $currentUser->ID,
		'post_password' => $main_order_post->post_password,
		'meta_input'    => array(
			'_suborder_IS_SUB_ORDER'     => true,
			'_suborder_PARENT_ORDER'      => $main_order_id,
			'_suborder_SUB_ORDER_SUB_ID'  => $order_counter,
			'_suborder_SUB_ORDER_FAKE_ID' => $main_order->get_order_number() . '-' . $order_counter
		),
	);

	// Create sub order
	$suborder_id = wp_insert_post( $order_data, true );

	foreach ( $maim_arr_data[$type] as $item_id => $main_order_item ) {

		$main_order_item = $main_order_item['item'];
	
		$product = $main_order_item->get_product();

		$line_item_qty = $main_order_item->get_quantity();
		
		

		$line_item_qty_total = $line_item_qty_total + $line_item_qty;

		$product_id = $main_order_item->get_product_id();

			// Creates a fake id for main order
			//update_post_meta( $main_order_id, '_suborder_SUB_ORDER_FAKE_ID', $main_order->get_order_number().'('.$count_or_type.')' );
			update_post_meta( $main_order_id, '_suborder_SUB_ORDER_FAKE_ID', $main_order->get_order_number().'-'.$order_counter );
		
			$sub_or_total = $sub_or_total + $main_order_item->get_total();


			// Adds line item in suborder
			$suborder_item_id = add_line_item_in_suborder( $main_order_item, $item_id, $suborder_id );

			// Associate main order item with suborder id
			wc_add_order_item_meta( $item_id, '_suborder_SUB_ORDER', $suborder_id, ! $consider_quantity );


		if ($type == 'simple_product_backorder' || $type == 'core_product_backorder_with_charge' || $type == 'core_product_backorder_without_charge') { 
			//wc_update_order_item_meta( $suborder_item_id, '_line_item_backorder_stock_status', 'line_item_onback_order' );
			wc_update_order_item_meta( $suborder_item_id, '_reduced_stock', $line_item_qty );
		}

	
	}


	// Updates suborder price
	update_post_meta( $suborder_id, '_order_total', $sub_or_total);

	update_post_meta( $suborder_id, '_order_line_qty_total', $line_item_qty_total);

	// Clone order post metas into suborder
	$main_order_metadata = get_metadata( 'post', $main_order_id );
	$exclude_post_metas = apply_filters( 'alg_mowc_exclude_cloned_order_postmetas', array(
		'_suborder_SUB_ORDERS',
		'_wcj_order_number',
	) );
	clone_order_postmetas( $main_order_metadata, $suborder_id, $exclude_post_metas );

	
	// Updates main order meta regarding suborder
	add_post_meta( $main_order_id, '_suborder_SUB_ORDERS', $suborder_id, false );

	update_post_meta( $suborder_id, '_suborder_product_type', $type);




}


function clone_order_postmetas( $main_order_metadata, $suborder_id, $exclude = array() ) {
	foreach ( $main_order_metadata as $index => $meta_value ) {
		foreach ( $meta_value as $value ) {
			if ( ! in_array( $index, $exclude ) ) {
				add_post_meta( $suborder_id, $index, $value );
			}
		}
	}
}


function add_line_item_in_suborder( $main_order_item, $item_id, $suborder_id ) {
	$item_name        = $main_order_item['name'];
	$item_type        = $main_order_item->get_type();
	$suborder_item_id = wc_add_order_item( $suborder_id, array(
		'order_item_name' => $item_name,
		'order_item_type' => $item_type,
	) );

	// Clone order item metas
	clone_order_itemmetas( $item_id, $suborder_item_id, array( '_suborder_SUB_ORDER' ) );
	return $suborder_item_id;
}

function add_fees_in_suborder( $fees, $suborder_id, $main_order ) {
	$fee_value_count = 0;
	/* @var WC_Order_Item_Fee $fee */
	foreach ( $fees as $fee ) {
		$item_name           = $fee->get_name();
		$item_type           = $fee->get_type();
		$suborder_new_fee_id = wc_add_order_item( $suborder_id, array(
			'order_item_name' => $item_name,
			'order_item_type' => $item_type,
		) );
		clone_order_itemmetas( $fee->get_id(), $suborder_new_fee_id );
		$fee_value       = $fee->get_total() / $main_order->get_item_count();
		$fee_value_count += $fee_value;
		wc_update_order_item_meta( $suborder_new_fee_id, '_line_total', $fee_value );
		wc_update_order_item_meta( $suborder_new_fee_id, '_line_tax', 0 );
		wc_update_order_item_meta( $suborder_new_fee_id, '_line_tax_data', 0 );
	}
	return $fee_value_count;
}


function add_taxes_in_suborder( $taxes, $suborder_id, $main_order_item ) {
	/* @var WC_Order_Item_Tax $tax */
	foreach ( $taxes as $tax ) {
		$item_name           = $tax->get_name();
		$item_type           = $tax->get_type();
		$suborder_new_tax_id = wc_add_order_item( $suborder_id, array(
			'order_item_name' => $item_name,
			'order_item_type' => $item_type,
		) );
		clone_order_itemmetas( $tax->get_id(), $suborder_new_tax_id );
		//wc_update_order_item_meta( $suborder_new_tax_id, 'tax_amount', $main_order_item->get_total_tax() );
	}
}


function clone_order_itemmetas( $order_item_id, $target_order_id, $exclude = array(), $method = 'add' ) {
	$order_item_metas = wc_get_order_item_meta( $order_item_id, '' );
	foreach ( $order_item_metas as $index => $meta_value ) {
		foreach ( $meta_value as $value ) {
			if ( ! in_array( $index, $exclude ) ) {
				if ( $method == 'add' ) {
					wc_add_order_item_meta( $target_order_id, $index, maybe_unserialize( $value ) );
				} else if ( $method == 'update' ) {
					wc_update_order_item_meta( $target_order_id, $index, maybe_unserialize( $value ) );
				}
			}
		}
	}
}


function delete_suborders_from_main_order( $main_order_id ) {
	$prev_suborders = get_post_meta( $main_order_id, '_suborder_SUB_ORDERS' );
	if ( is_array( $prev_suborders ) && count( $prev_suborders ) > 0 ) {
		foreach ( $prev_suborders as $prev_suborder_id ) {
			wp_delete_post( $prev_suborder_id, true );
		}
		delete_post_meta( $main_order_id, '_suborder_SUB_ORDERS' );
	}
}



add_action( 'manage_edit-shop_order_columns', 'my_custom_edit_movie_columns'); 
function my_custom_edit_movie_columns($columns) { 
 
   	$columns['custom_suborder'] =  'Suborder';

    return $columns;
}
/*
* Create suborder function
*/










// add custom column valuse
add_action( 'manage_shop_order_posts_custom_column', 'my_custom_activity_columns', 10, 2); 
function my_custom_activity_columns( $column, $post_id ) { 

   switch( $column ) 
   {

        case 'custom_suborder' :

            $suborders = get_post_meta( $post_id, '_suborder_SUB_ORDERS' );

            $counter   = 1;
            if ( is_array( $suborders ) && count( $suborders ) > 0 ) {
                echo '<ul style="margin:0;padding:0;list-style:none">';
                foreach ( $suborders as $suborder_id ) {
	                $suborder = wc_get_order($suborder_id);

	                if($suborder){

	                	$fake_order_id = get_post_meta( $suborder_id, '_suborder_SUB_ORDER_FAKE_ID', true);


	                	$_suborder_product_type = get_post_meta( $suborder_id, '_suborder_product_type', true);

	                	    
	                	if ($_suborder_product_type == 'simple_product') {
	                		$order_type = 'With Core/Simple (processing)';
	                	}

	                	if ($_suborder_product_type == 'core_product') {
	                		$order_type = 'Awaiting Core';
	                	}

	                	if ($_suborder_product_type == 'simple_product_backorder') {
	                		$order_type = 'Backorder';
	                	}

	                	if ($_suborder_product_type == 'core_product_backorder_without_charge') {
	                		$order_type = 'Backorder without core charges';
	                	}

	                	if ($_suborder_product_type == 'core_product_backorder_with_charge') {
	                		$order_type = 'Backorder with core charges';
	                	}


		                echo '<li style="margin-bottom:1px;color:#DDD;"><a style="font-size:12px !important;" href="' . admin_url( 'post.php?post=' . absint( $suborder_id ) . '&action=edit' ) . '" class="row-title"><strong>#' . $fake_order_id .' - '.$order_type. '</strong></a></li>';

		                $counter ++;
	                }

                }
                echo '</ul>';
            }

            break;

        default :
                break;
    }

}









add_action( 'pre_get_posts', 'custom_core_show_or_hide_admin_suborders_list_view');
function custom_core_show_or_hide_admin_suborders_list_view( $query ) {
	if (
		! is_admin() ||
		! isset( $query->query['post_type'] ) ||
		'shop_order' != $query->query['post_type']
	) {
		return;
	}

	// Check if it is searching for a suborder
	$searching_a_suborder=false;
	if (
		isset( $query->query['s'] ) &&
		1 === preg_match( '/^\d.*\-\d.*$/', $query->query['s'] ) &&
		0 != $query->query['s']
	) {
		$searching_a_suborder=true;
	}


	$setting_option_boolean = false;

	$show_suborders = filter_var( $setting_option_boolean, FILTER_VALIDATE_BOOLEAN );
	if ( $show_suborders || $searching_a_suborder ) {
		return;
	}

	$meta_query   = $query->get( 'meta_query' );
	$meta_query   = empty( $meta_query ) ? array() : $meta_query;
	$meta_query[] = array(
		array(
			'key'     => '_suborder_IS_SUB_ORDER',
			'compare' => 'NOT EXISTS',
		),
	);
	$query->set( 'meta_query', $meta_query );
}


// New order status AFTER woo 2.2
add_action( 'init', 'custom_core_register_my_new_order_statuses' );

function custom_core_register_my_new_order_statuses() {

	register_post_status( 'wc-core-charges', array(
        'label'                     => _x( 'Awaiting for core charges', 'Order status', 'woocommerce' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Awaiting for core charges <span class="count">(%s)</span>', 'Awaiting for core charges<span class="count">(%s)</span>', 'woocommerce' )
    ) );

    register_post_status( 'wc-core-backorder1', array(
        'label'                     => _x( 'Backorder without core charges', 'Order status', 'woocommerce' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Backorder with core charges <span class="count">(%s)</span>', 'Backorder without core charges<span class="count">(%s)</span>', 'woocommerce' )
    ) );

    register_post_status( 'wc-core-fcfs', array(
        'label'                     => _x( 'FCFS process', 'Order status', 'woocommerce' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'FCFS process <span class="count">(%s)</span>', 'FCFS process<span class="count">(%s)</span>', 'woocommerce' )
    ) );


    register_post_status( 'wc-core-backorder0', array(
        'label'                     => _x( 'Backorder and Awaiting for core charges', 'Order status', 'woocommerce' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Backorder and Awaiting for core charges <span class="count">(%s)</span>', 'Backorder and Awaiting for core charges<span class="count">(%s)</span>', 'woocommerce' )
    ) );



    register_post_status( 'wc-cus-backorder', array(
        'label'                     => _x( 'Backorder', 'Order status', 'woocommerce' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Backorder<span class="count">(%s)</span>', 'Backorder<span class="count">(%s)</span>', 'woocommerce' )
    ) );


}

add_filter( 'wc_order_statuses', 'custom_core_my_new_wc_order_statuses' );

// Register in wc_order_statuses.
function custom_core_my_new_wc_order_statuses( $order_statuses ) {

	$order_statuses['wc-core-charges'] = _x( 'Awaiting for core charges', 'Order status', 'woocommerce' );

    $order_statuses['wc-core-backorder1'] = _x( 'Backorder with core charges', 'Order status', 'woocommerce' );

    $order_statuses['wc-core-backorder0'] = _x( 'Backorder and Awaiting for core charges', 'Order status', 'woocommerce' );

    $order_statuses['wc-cus-backorder'] = _x( 'Backorder', 'Order status', 'woocommerce' );

    $order_statuses['wc-core-fcfs'] = _x( 'FCFS process', 'Order status', 'woocommerce' );

    return $order_statuses;
}



add_action( 'admin_head', 'custom_core_my_custom_fun' );
function custom_core_my_custom_fun(){
	?>
	<style type="text/css">
		#custom_suborder{
			    width: 248px !important;
		}
	</style>
	<?php
}



add_action('woocommerce_product_options_stock_fields', 'custom_core_next_date_woocommerce_product_options_stock');
function custom_core_next_date_woocommerce_product_options_stock(){
    //echo "string";

    $post_id = $_GET['post'];

    $next_date = get_post_meta($post_id, '_backorder_next_available_date_meta_val', true);

    if (empty($next_date)) {
      $next_date = '';
    }

   ?>
    <p class="form-field _backorder_next_available_date_field ">
        <label for="_backorder_next_available_date">Backorder next available date</label>
        <span class="woocommerce-help-tip"></span>
        <input type="text" class="short" style="" name="_backorder_next_available_date" id="_backorder_next_available_date" value="<?php echo $next_date;?>" placeholder="YY/MM/DD" step="any"> 
    </p>
   <?php


}
function custom_core_next_date_save_post( $post_id ) {

    $_backorder_next_available_date = $_POST['_backorder_next_available_date'];
    if (isset($_backorder_next_available_date)) {
        update_post_meta($post_id, '_backorder_next_available_date_meta_val', $_backorder_next_available_date);
    }
    
}
add_action( 'save_post', 'custom_core_next_date_save_post', 11, 1);

add_action( 'woocommerce_after_add_to_cart_form', 'custom_core_next_date_woocommerce_after_add_to_cart_form', 30 );
function custom_core_next_date_woocommerce_after_add_to_cart_form(){
    
    $post_id = get_the_ID();
    $next_date = get_post_meta($post_id, '_backorder_next_available_date_meta_val', true);
    
    
    global $product;       
    $product_name = $product->get_name();
    $stock_qty = $product->get_stock_quantity();
    $_product_addons = get_post_meta( $product->get_id() , '_product_addons', true);
                                             
    ?>
    <div>
        <?php
    
            if ($stock_qty > 0 || empty($stock_qty)) {
        
            } else {
        
               if ($product->backorders_allowed()) {
               	
                   	 if($next_date && !empty($next_date)){ 
                   	     
                   	     
                   	    echo 'Next available date: '.$next_date;
                   	     
                   	    $today = date("Y/m/d H:i:s");  
                        $startdate = $next_date;   
                        $offset = strtotime("+1 day");
                        $enddate = date($startdate, $offset);    
                        $today_date = new DateTime($today);
                        $expiry_date = new DateTime($enddate);
                        
                        if ($expiry_date < $today_date) { 
                        
                           echo "(<span style='color:red;'><i>expired</i><span>)";
                        
                        }
                   	     
                   	     
                   	 }
                
               	}
            }
        ?>
        
    </div>
    <?php
   
}















/*
* IF backorder in stock
*/
add_filter( 'woocommerce_payment_complete_order_status', 'before_above_function', 10, 2 );
function before_above_function($status, $order_id){
	global $wpdb;
	if( is_a( $order_id, 'WC_Order' ) ) { 
	  $order = $order_id; 
	  $order_id = $order->get_id(); 
	} else { 
	  $order = wc_get_order( $order_id ); 
	} 

	if( 'yes' === get_option( 'woocommerce_manage_stock' ) && $order && sizeof( $order->get_items() ) > 0 ) { 
	  foreach ( $order->get_items() as $k=>$item ) { 
	      if ($item->is_type( 'line_item' ) && ( $product = $item->get_product() ) && $product->managing_stock() ) { 
	          $product_id = $product->get_id();
	          $qty = $item->get_quantity();
	          $new_stock = $qty; 
	          $pro_qty = $product->get_stock_quantity();
	          $item_id = $k;
	        //  wp_mail('paul.quickfix@gmail.com','asd','OrderId: '.$order_id.' ProductID:'.$product_id.' ItemQty:'.$qty.' ProQty:'.$pro_qty.' ItemId:'.$item_id);
	          if($new_stock>$pro_qty){
	            wc_update_order_item_meta($item_id,'_is_backorder',1);
	            
	            $remaining_stock = 0;
	            if($pro_qty>0){
	               $remaining_stock = $new_stock-$pro_qty;
	            }else{
	               $remaining_stock = $new_stock; 
	            }
	            
	            if($remaining_stock>0){
	               wc_update_order_item_meta($item_id,'_remaining_stock',$remaining_stock);
	            }
	            
	          }
	          
	      }
	  }
	}
}


function custom_core_backorder_check_save_post_fun( $product_id ) {

	$get_post_type = get_post_type($product_id);
    
    if($get_post_type == 'product'){ 
        
        
        /**/
        /*echo '==>'.$_core_product_price = wc_get_order_item_meta( 17262, '_core_product_price', true ); echo '<br>'; //17253, 17254
	    if ($_core_product_price == 0 && $_core_product_price !="") {
		    echo '==>'.$_core_product_price;
	    }
	    die();*/
        /**/

		$orders_ids_array = retrieve_orders_ids_from_a_product_id( $product_id ); 

		foreach ($orders_ids_array as $order_id) { 
            
            $order = wc_get_order( $order_id );

			foreach( $order->get_items() as $item_id => $item ){   
	            
	            $product_stock_qty = get_post_meta($product_id, '_stock', true);
	            
	            $line_item_product_id = $item->get_product_id();
	                                
	            $line_item_qty = wc_get_order_item_meta( $item_id, '_remaining_stock', true);

	            $manage_product_qty = $product_stock_qty - $line_item_qty; 
	            
	            if ($product_id == $line_item_product_id) { 

	            	$_remaining_stock = wc_get_order_item_meta( $item_id, '_remaining_stock', true);

	            	if (!empty($_remaining_stock) && $_remaining_stock!=0) {

	            		if ($product_stock_qty >= $line_item_qty ) { //echo $manage_product_qty; echo '<br>';
                            

                            update_post_meta($product_id, '_stock', $manage_product_qty);
                            wc_update_order_item_meta( $item_id, '_remaining_stock', 0 );

                            $item_backorder_status = backorder_status_ckeck_fun($order_id);
                			if ($item_backorder_status == 'line_item_instock') {

                				$_core_product_price = wc_get_order_item_meta( $item_id, '_core_product_price', true );

							    if ($_core_product_price == 0 && $_core_product_price !="") {

								   $order->update_status( 'core-charges' );

							    }else {

									$order->update_status( 'processing' );
							    }


                			}

							
                            
                            
			
                            
			            }
		            
		            }
	            
	            }
	        
	        }
		    
            
		    
		}
    
    //die('__');
	}
}
add_action( 'save_post', 'custom_core_backorder_check_save_post_fun', 99999999999999999, 1);


function retrieve_orders_ids_from_a_product_id( $product_id ) {

    global $wpdb;

    $orders_statuses = "'wc-cus-backorder', 'wc-core-backorder1', 'wc-core-backorder0'";

    $orders_ids = $wpdb->get_col( "
        SELECT DISTINCT woi.order_id
        FROM {$wpdb->prefix}woocommerce_order_itemmeta as woim, 
             {$wpdb->prefix}woocommerce_order_items as woi, 
             {$wpdb->prefix}posts as p
        WHERE  woi.order_item_id = woim.order_item_id
        AND woi.order_id = p.ID
     	AND p.post_status IN ( $orders_statuses )
        AND woim.meta_key LIKE '_product_id'
        AND woim.meta_value LIKE '$product_id'
        ORDER BY woi.order_item_id DESC"
    );

    return $orders_ids;
}


function backorder_status_ckeck_fun( $order_id ) {

	$item_id_arr = array();

	$c = 0;

	$order = wc_get_order( $order_id );

	foreach( $order->get_items() as $item_id => $item ){

		$item_id_arr[] = $item_id;

		$_line_item_backorder_stock_status = wc_get_order_item_meta( $item_id, '_remaining_stock', true);

    	if ($_line_item_backorder_stock_status==0) {

    		$c++;
        	
        }

	}

	$item_id_count = sizeof($item_id_arr);

	if ($item_id_count == $c) {
		
		return 'line_item_instock';

	}else{

		return 'line_item_onback_order';
	}
}
/*
* IF backorder in stock
*/