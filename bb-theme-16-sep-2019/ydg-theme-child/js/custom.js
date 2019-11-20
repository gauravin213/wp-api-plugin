jQuery(document).ready(function(){
    new WOW().init();
    jQuery('.banner-image-slide').owlCarousel({
        loop:true,
    	autoplay:true,
        margin:0,
        nav:true,
        dots:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
    
    
    jQuery('.review-carousel').owlCarousel({
        loop:false,
    	autoplay:false,
        margin:0,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:3
            }
        }
    });
    
    
    /*To Rated Product Carousel script*/ 
    var custom_class_target = jQuery('#custom_carousel_container_top_rated_product');
    custom_class_target.find('.product_list_widget').attr('id', 'carousel_top_rated_product');
    custom_class_target.find('.product_list_widget').addClass('owl-carousel owl-theme');
    custom_class_target.find('.product_list_widget > li').addClass('item');
    
    jQuery('#carousel_top_rated_product').owlCarousel({
      loop: true,
      margin: 10,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1,
          nav: true
        },
        600: {
          items: 2,
          nav: true
        },
        1000: {
          items: 3,
          nav: true,
          loop: false,
          margin: 20
        }
      }
    
    });
    /*To Rated Product Carousel script*/
    
    
    /*Customer review Carousel script*/ 
    /*var custom_class_target = jQuery('.ivole-reviews-grid');
    var customer_r_c_id = custom_class_target.attr('id');
    jQuery('#'+customer_r_c_id).addClass('owl-carousel owl-theme pppp1');
    jQuery('#'+customer_r_c_id).find('.ivole-review-card').addClass('item pppp2');
    
    jQuery('#'+customer_r_c_id).owlCarousel({
      loop: true,
      margin: 10,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1,
          nav: true
        },
        600: {
          items: 2,
          nav: true
        },
        1000: {
          items: 3,
          nav: true,
          loop: false,
          margin: 20
        }
      }
    
    });*/
    /*Customer review Carousel script*/ 
    
    
    jQuery('#tab-description *').each(function() {
        var $this = jQuery(this);
        if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
            $this.addClass('empty-tags');
    });
    
    
    jQuery( "#tab-ebay_item_compatibility_list" ).find('h2').text('Item Vehicle Fitment List');
    
    
   
    
    //shop loop
    jQuery( ".woocommerce-products-header__title" ).wrap( '<div class="custom-befor-shop-loop-box"></div>' );
    jQuery('.berocket_lgv_widget').insertAfter('.woocommerce-products-header__title');
    jQuery('.woocommerce-ordering').insertAfter('.woocommerce-products-header__title');
    if(child_data.product_search_args!=""){
        jQuery('.berocket_lgv_widget').remove();
    }
	
	
	
	setTimeout(function(){ 
        if(child_data.product_id == '3025'){
            jQuery('.show-category-search').next('li').show();
	         //console.log('page_id: '+child_data.product_id);
        }
	},1000);
	
	
	
	
	jQuery('.show-category-search').on('click',function(){
		jQuery(this).next('li').slideToggle();
	});
setInterval(function(){
    var thumbs = jQuery('.woocommerce div.product div.images .flex-control-thumbs').outerHeight();
//console.log(thumbs);
    var thumbs = jQuery('body.single-product.woocommerce div.product div.images, .woocommerce-page div.product div.images').
            css({'margin-bottom':thumbs});
}, 500);

jQuery('.bot-bor').parent().addClass('ham-bar');

});

jQuery(function($){  
   
    
    function imgfunc(){
        if($('.single-product .product-counter').length !==0){
    var space=$('.single-product .product-counter').outerHeight() - $('.single-product .sku-name').outerHeight();
//    $('.single-product .custom-price-and-stocl').css({'top':-space, 'margin-bottom':-space});
    }
}
    imgfunc();
    $(window).resize(function(){
        imgfunc();
    });
//    if($('.single-product .woocommerce-product-rating').length){
//        $('.single-product .woocommerce-product-rating').insertBefore($('.custom-price-and-stocl').children().first());
//    }
    
});






















