(function($) {

	// shorthand
	var api 			= wp.customize,
		priColor 		= '',
		secColor 		= '',
		headingColor 	= '#333333',
		bodyColor		= '#808080';

	// brand colors
	api('ydg-brand-primary', function(val) {
		val.bind( function(newval) {
			var elements = $('.alt-row, .alt-col .fl-col-content, .row-col-bg, .onsale');
			elements.css('background-color', newval);
			if( isDark(newval) ) {
				elements.find('p, h1, h2, h3, h4, h5, h6').css('color', 'white');
			} else {
				elements.find('h1, h2, h3, h4, h5, h6').css('color', headingColor);
				elements.find('p').css('color', bodyColor);
			}

			priColor = newval;
		});
	});

	api('ydg-brand-secondary', function(val) {
		val.bind( function(newval) {
			var elements = $('.alt-row2, .alt-col2 .fl-col-content, .page-heading, .row-col-bg2 .fl-col-content');
			elements.css('background-color', newval);
			if( isDark(newval) ) {
				elements.find('p, h1, h2, h3, h4, h5, h6').css('color', 'white');
			} else {
				elements.find('h1, h2, h3, h4, h5, h6').css('color', headingColor);
				elements.find('p').css('color', bodyColor);
			}

			secColor = newval;
		});
	});

	api('fl-heading-text-color', function(val) {
		val.bind( function(newval) {
			headingColor = newval;
		});
	});
	api('fl-body-text-color', function(val) {
		val.bind( function(newval) {
			bodyColor = newval;
		});
	});

	// row spacing
	api('ydg-row-spacing', function(val) {
		val.bind(function(newval) {
			var rows = $('.fl-row-content-wrap');
			rows.css({
				paddingTop: 	newval + 'px',
				paddingBottom: 	newval + 'px'
			});
		});
	});

	// module spacing
	api('ydg-module-spacing', function(val) {
		val.bind(function(newval) {
			var modules = $('.fl-module-content');
			modules.css({
				marginTop: 		newval + 'px',
				marginBottom: 	newval + 'px'
			});
		});
	});

	// button style
	api('ydg-button-style', function(val) {
		val.bind(function(newval) {
			var btnWrappers = $('.fl-module-button, .gform_wrapper');

			btnWrappers.removeClass('flat-btn');
			btnWrappers.removeClass('border-btn');
			btnWrappers.removeClass('gradient-btn');

			btnWrappers.addClass(newval + '-btn');
		});
	});

	// icon size
	api('ydg-icons-size', function(val) {
		val.bind(function(newval) {
			var icons = $('.fl-module-icon .fl-module-content .fl-icon i, .fl-module-icon .fl-module-content .fl-icon i::before');
			icons.css('font-size', newval + 'px');
			icons.css('line-height', ((newval * 2) - 2) + 'px');
		});
	});

	// image style
	api('ydg-images-style', function(val) {
		val.bind(function(newval) {
			var images = $('.fl-photo, .woocommerce');

			images.removeClass('none-img');
			images.removeClass('padded-border-img');
			images.removeClass('shadow-img');
			images.removeClass('bottom-border-img');

			images.addClass(newval + '-img');
		});
	});

	// woocommerce headers size
	api('ydg-woo-product-spacing', function(val) {
		val.bind(function(newval) {
			var products = $('.woocommerce ul.products li.product, .woocommerce-page ul.products li.product');
			products.css('margin-bottom', newval + 'px');
		});
	});

	// woocommerce headers size
	api('ydg-woo-headers-size', function(val) {
		val.bind(function(newval) {
			var headers = $('.woocommerce ul.products li.product h3, .woocommerce-page ul.products li.product h3');
			headers.css('font-size', newval + 'px');
		});
	});

	// woocommerce stars size
	api('ydg-woo-stars-size', function(val) {
		val.bind(function(newval) {
			var stars = $('.woocommerce ul.products li.product .star-rating, .woocommerce-page ul.products li.product .star-rating');
			stars.css('font-size', newval + 'px');
		});
	});

	// woocommerce price size
	api('ydg-woo-price-size', function(val) {
		val.bind(function(newval) {
			var price = $('.woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price');
			price.css('font-size', newval + 'px');
		});
	});

	// figure out if a color is too dark or not
	function isDark(hex) {
		var color = hex.substring(1);
			r = parseInt(color.substr(0,2),16),
	    	g = parseInt(color.substr(2,2),16),
	    	b = parseInt(color.substr(4,2),16),
    		o = Math.round(((parseInt(r) * 299) + (parseInt(g) * 587) + (parseInt(b) * 114)) /1000);

		if(o > 125) {
			return false;
		} else {
			return true;
		}
	}

})(jQuery);
