jQuery(document).ready(function($) {
    "use strict";
    /*$('.woocommerce-product-gallery__wrapper').slick({
    	dots: false,
    	arrows: true,
        infinite: true,
        adaptiveHeight: true,
        slidesToShow: 1,
        slidesToScroll: 1
    });*/
    var rtl = $('html[dir="rtl"]').length == 1 ? true : false;
    // Gallery Horizontal
    $('.slick-h .woocommerce-product-gallery__wrapper').slick({
        slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		adaptiveHeight: true,
		asNavFor: '.slick-h .small-thumb',
		rtl: rtl
    });
    $('.slick-h .small-thumb').slick({
        slidesToShow: 3,
		slidesToScroll: 1,
		asNavFor: '.slick-h .woocommerce-product-gallery__wrapper',
		dots: false,
		focusOnSelect: true,
		rtl: rtl
    });
    // Gallery Vertical 
    $('.slick-v .large-thumb').slick({
    	vertical: false,
        slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		adaptiveHeight: true,
		asNavFor: '.slick-v .small-thumb',
		rtl: rtl
    });
    $('.slick-v .small-thumb').slick({
    	vertical: true,
    	verticalSwiping: true,
        slidesToShow: 3,
		slidesToScroll: 1,
		asNavFor: '.slick-v .large-thumb',
		dots: false,
		focusOnSelect: true,
		responsive: [
			{
			  breakpoint: 576,
			  settings: {
			    vertical: false,
    			verticalSwiping: false,
    			rtl: rtl,
			  }
			}
		]
    });
});