<?php

//split order list
add_action('admin_menu', 'custom_core_split_order_list_admin_menu',99);
function custom_core_split_order_list_admin_menu() {

    add_submenu_page( 'woocommerce', 'Split Order List', 'Split Order List', 'manage_options', 'split-order-list', 'split_order_list_fun' ); 
}

function split_order_list_fun() {

	?>
	<style>
	td, th {padding: 5px !important;}
	</style>
	
	<div>
		<select id="core_charges_order_list" name="core_charges_order_list" style="margin-top: 20px;">
			<option value="">Select</option>
			<option value="wc-processing">Processing with Core Charges</option>			
			<option value="wc-core-charges">Awaiting for core charges</option>
			<option value="wc-core-backorder1">Backorder with core charges</option>
			<option value="wc-core-backorder0">Backorder and Awaiting for core charges</option>			
		</select>
	</div>
	<div id='core_order_loader'  style='display:none;font-size: 20px;margin-left: 2px;margin-top: 11px;'>Loading...</div>
	<div id='core_order_tb'></div>
	
	<?php
}


add_action( 'wp_ajax_core_charges_order_list', 'core_charges_order_list_fun');
add_action( 'wp_ajax_nopriv_core_charges_order_list', 'core_charges_order_list_fun');
function core_charges_order_list_fun(){
    
    $core_o_status = $_POST['core_o_status'];
    
    $o_status_text = array(
        'wc-processing'=> 'Core',
        'wc-core-charges'=> 'Awaiting for core charges',
        'wc-core-backorder1'=> 'Backorder with core charges',
        'wc-core-backorder0'=> 'Backorder and Awaiting for core charges',
    );
    
    
    
    
    global $wpdb;
    
    if($core_o_status=='wc-processing'){//ACCEPT CORE DEPOSIT
       $getcoreorderids = $wpdb->get_results("SELECT distinct(order_id) as OrderId FROM ".$wpdb->prefix."woocommerce_order_items WHERE order_item_id IN (SELECT order_item_id FROM ".$wpdb->prefix."woocommerce_order_itemmeta WHERE meta_key LIKE 'ACCEPT CORE DEPOSIT%' AND meta_value='Yes')",ARRAY_A);
       $get_core_ids = array_column($getcoreorderids,"OrderId");
    }
    if(!empty($get_core_ids)){
      $query =  "SELECT * FROM ".$wpdb->prefix."posts WHERE post_status='".$core_o_status."' AND ID IN (".implode(",",$get_core_ids).") ORDER BY ID DESC";
    }else{
      $query =  "SELECT * FROM ".$wpdb->prefix."posts WHERE post_status='".$core_o_status."' ORDER BY ID DESC";
    }
    $results_posts = $wpdb->get_results( $query );
    
    $htm = '';
    $htm.= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">';
    $htm .= '<table class="table-bordered" style="width: 90%;text-align: center;margin-top: 10px;">';
    $htm .= '<tr>';
        $htm .= '<th style="padding:5px; text-align:center;">Order ID</th>';
        $htm .= '<th style="padding:5px; text-align:center;">Line Items (With/Without Core Charges)</th>';
        //$htm .= '<th>Charges</th>';
    $htm .= '</tr>';
            
    foreach ($results_posts as $results_post) { 
      $core_charges_total = 0;           

       $htm .= '<tr>';
      
            $htm .= '<td><a target="_blank" href="'.home_url().'/wp-admin/post.php?post='.$results_post->ID.'&action=edit"><strong>#'.$results_post->ID.'</strong></a></td>';
            
            $htm .= '<td><table align="center" style="width:80%;text-align: center;">';
            
            $order = wc_get_order( $results_post->ID );
            $order_items = $order->get_items();
        	foreach( $order_items as $item_id => $item ){
        	    
        	    $product_id = $item->get_product_id();
        	    $product_name = $item->get_name();
        	    $product_quantity = $item->get_quantity();
        	    
        	    
        	  /*  $get_core_chrg = $wpdb->get_results("SELECT meta_value FROM ".$wpdb->prefix."woocommerce_order_itemmeta WHERE meta_key='_core_product_price' AND order_item_id IN (SELECT order_item_id FROM ".$wpdb->prefix."woocommerce_order_items WHERE order_id=".$results_post->ID." AND order_item_type='line_item')");
            	if(!empty($get_core_chrg)){
            	    foreach($get_core_chrg as $each_chrg){
            	            $core_charges_total = $each_chrg->meta_value;
            	    }
            	}
            	$core_ch = '$'.$core_charges_total;*/
            	if(get_post_meta($product_id,'_core_product_price_meta',true)>0){
            	   $core_ch = '$'.get_post_meta($product_id,'_core_product_price_meta',true); 
            	}else{
            	   $core_ch = ' - '; 
            	}
            	
		        $htm .= '<tr><th style="width: 55%;">'.$product_name.' X '.$product_quantity.'</th><td>'.$core_ch.'</td></tr>';
	
        	    
        	}
        	
        	$htm .= '</table></td>';
        	
        	
        	/*$htm .= '<td>';
        	
            	$get_core_chrg = $wpdb->get_results("SELECT meta_value FROM ".$wpdb->prefix."woocommerce_order_itemmeta WHERE meta_key='_core_product_price' AND order_item_id IN (SELECT order_item_id FROM ".$wpdb->prefix."woocommerce_order_items WHERE order_id=".$results_post->ID." AND order_item_type='line_item')");
            	if(!empty($get_core_chrg)){
            	    foreach($get_core_chrg as $each_chrg){
            	            $core_charges_total = $core_charges_total+$each_chrg->meta_value;
            	    }
            	}
            	$htm .= '$'.$core_charges_total;
        	
        	$htm .='</td>';*/
          

       $htm .= '</tr>';
       
    }
    
    $htm .= '</table>';
    
    
    $myArr = array('reponce_data'=>'done', 'o_data'=>$htm);
    $myJSON = json_encode($myArr); 
    echo $myJSON;
    die();
}