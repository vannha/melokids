/*global wc_single_product_params, PhotoSwipe, PhotoSwipeUI_Default */
jQuery( function( $ ) {
	$(window).load(function() {
		$('.slick-v .gallery-thumb-wrap').flexslider({
			selector       : '.small-thumb > .thumbnail',
			animation 	   : 'slide',
			controlNav     : false,
			directionNav   : true,
			asNavFor 	   : '.woocommerce-product-gallery',
			direction	   : 'vertical',
			slideshow	   : false,
			animationSpeed : 500,
			animationLoop  : false, // Breaks photoswipe pagination if true.
			allowOneSlide  : false,
			maxItems: 1,
			itemWidth: 239,
			start: function(slider){
				slider.css('max-height', slider.vars.itemWidth*3);
				var asNavFor = slider.vars.asNavFor;
				var height = $(asNavFor).height();
				slider.find('> .flex-viewport > *').css({'height': height, 'width': ''});
			}
		});
		$('.slick-h .gallery-thumb-wrap').flexslider({
			selector       : '.small-thumb > .thumbnail',
			animation 	   : 'slide',
			controlNav     : false,
			directionNav   : false,
			asNavFor 	   : '.woocommerce-product-gallery',
			slideshow	   : false,
			animationSpeed : 500,
			animationLoop  : false, // Breaks photoswipe pagination if true.
			allowOneSlide  : false,
			itemWidth: 180,
    		itemMargin: 20,
			start: function(slider){

			}
		});
	});
} );
