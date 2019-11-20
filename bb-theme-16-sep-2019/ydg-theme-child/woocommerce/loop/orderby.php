<form class="woocommerce-ordering" method="get">
    <label>Sort by Price</label>
	<select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
	    
	    <?php
	    unset($catalog_orderby_options['relevance']);
	    unset($catalog_orderby_options['popularity']);
	    unset($catalog_orderby_options['rating']);
	    unset($catalog_orderby_options['date']);
	    
	    $catalog_orderby_options['price'] = "";
	    $catalog_orderby_options['price'] = "Low to High";
	    
	    $catalog_orderby_options['price-desc'] = "";
	    $catalog_orderby_options['price-desc'] = "High to Low";
	    
	    ?>
	    
	    
		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" name="paged" value="1" />
	<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
</form>