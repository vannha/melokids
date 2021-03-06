jQuery(document).ready(function($) {
    "use strict";
    $(window).on('load', function() {
        zk_wcwl_loading();
        zk_quantity_plus_minus();

        TableMoveColumn('.woocommerce-cart-form__contents','.cart_item, thead tr',0,5, 'thead tr .product-thumbnail','thead tr .product-name', 2);

        $('.actions > .coupon').remove();
        $('.actions > [name="update_cart"]').remove();
        $('.woocommerce-cart-form > [name="update_cart"]').remove();
    });
});
jQuery( document ).on( 'updated_wc_div', function() {
    "use strict";
    zk_quantity_plus_minus();
    zk_product_widget_item_height();
    TableMoveColumn('.woocommerce-cart-form__contents','.cart_item, thead tr',0,5, 'thead tr .product-thumbnail','thead tr .product-name', 2);
    jQuery('.actions > .coupon').remove();
    jQuery('.actions > [name="update_cart"]').remove();
} );

jQuery( document ).on( 'added_to_cart removed_from_cart', function() {
    "use strict";
});

/* Ajax Complete */
jQuery(document).ajaxComplete(function(event, xhr, settings){
});

/**
 * Widget Product list 
*/
function zk_product_widget_item_height(){
    'use strict';
    jQuery('.product_list_widget li').each(function(){
        var img_h = jQuery(this).find('img').innerHeight(),
            padding_top = parseInt(jQuery(this).css('padding-top')),
            padding_bottom = parseInt(jQuery(this).css('padding-bottom'));
        jQuery(this).css('min-height',img_h + padding_top + padding_bottom);
    });
}

/*
 * Single Product
 * Add plus, minus button to quantity
 *
*/
function zk_quantity_plus_minus(){
    'use strict';
    jQuery('.quantity input').wrap('<div class="quantity-inner"></div>');
    jQuery('<span class="qty-arrow quantity-down"></span>').insertBefore('.quantity input');
    jQuery('<span class="qty-arrow quantity-up"></span>').insertAfter('.quantity input');

    jQuery(document).on('click','.quantity .qty-arrow',function () {
         var $this = jQuery(this),spinner = $this.closest('.quantity')
             ,input = spinner.find('input[type="number"]'),
            step = input.attr('step'),
            min = input.attr('min'),
            max = input.attr('max'),value = parseInt(input.val());
         if(!value) value = 0;
        if(!step) step=1;
        step = parseInt(step);
        if (!min) min = 0;
        var type = $this.hasClass('quantity-up') ? 'up' : 'down' ;
        switch (type)
        {
            case 'up':
                if(!(max && value >= max))
                    input.val(value+step).change();
                break;
            case 'down':
                if (value > min)
                    input.val(value-step).change();
                break;
        }
        if(max && (parseInt(input.val()) > max))
            input.val(max).change();
        if(parseInt(input.val()) < min)
            input.val(min).change();
    });
}

/* Cart page 
 * Move column
*/
function TableMoveColumn(table, selected ,from, to, remove, colspan, colspan_value) {
    'use strict';
    var rows = jQuery(selected, table);
    var cols;
    rows.each(function() {
        cols = jQuery(this).children('th, td');
        cols.eq(from).detach().insertAfter(cols.eq(to));
    });
    var rows_remove = jQuery(remove, table);
    rows_remove.each(function(){
        jQuery(this).remove(remove);
    });
    var colspan = jQuery(colspan, table);
    colspan.each(function(){
        jQuery(this).attr('colspan',colspan_value);
    });

}

/**
 * YITH Wishlist
 * add class loading
*/
function zk_wcwl_loading(){
    'use strict';
    jQuery('a.add_to_wishlist').on('click', function(){
        jQuery(this).toggleClass('loading');
    });
}