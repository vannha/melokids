<?php
/**
 * WooCommerce
 *
 * 3rd Extensions 
*/

/**
 * Custom YITH Plugin
 * 
*/
if(!function_exists('melokids_custom_yith')){
    //add_action('init', 'melokids_custom_yith');
    function melokids_custom_yith()
    {
        if (class_exists('YITH_WCQV_Frontend')) {
            // Quick view button
            remove_action('woocommerce_after_shop_loop_item', array(YITH_WCQV_Frontend(), 'yith_add_quick_view_button'), 15);
            add_action('melokids_woocommerce_loop_overlay', array(YITH_WCQV_Frontend(), 'yith_add_quick_view_button'), 14);
        }
        if(class_exists('YITH_WCWL')){
            // Wislish Button
        }
        if (class_exists('YITH_Woocompare_Frontend')) {
        	// compare button
            melokids_relocation_yith_compare_link();
        }

        if(class_exists('WPcleverWooscp')){
            // Woo Smart Compare
            //melokids_wcscp_position();
        }
    }
}

/**
 * Custom YITH WishList
 * Change wishlist button position in loop
 * Change wishlist button position in single
*/

/**
 * Add wishlist button to products archive page
 * loop attributes right
 * hook : melokids_loop_product_thumnail_attrs_right
 *
 * for config shortcode, see: https://docs.yithemes.com/yith-woocommerce-wishlist/free-settings/shortcodes/
 */
if (class_exists('YITH_WCWL')) {
    //add_action('melokids_loop_product_thumnail_attrs_right', 'melokids_yith_wishlist', 1);
    function melokids_yith_wishlist()
	{
	    echo do_shortcode('[yith_wcwl_add_to_wishlist link_classes="add_to_wishlist hint--left hint--bounce wc-attr-btn" icon="fa-heart-o"]');
	}
}

/**
 * Change add to wish list button position on single product page 
*/
if(!function_exists('melokids_yith_wcwl_positions')){
    //add_filter('yith_wcwl_positions', 'melokids_yith_wcwl_positions', 10, 1);
	function melokids_yith_wcwl_positions($args){
		$args = array(
			'add-to-cart' => array( 'hook' => 'woocommerce_after_add_to_cart_button', 'priority' => 2 ),
			'thumbnails'  => array( 'hook' => 'woocommerce_product_thumbnails', 'priority' => 21 ),
			'summary'     => array( 'hook' => 'woocommerce_after_single_product_summary', 'priority' => 11 )	
		);
		return $args;
	}
}

/**
 * Change class wish list button
*/
if(!function_exists('melokids_yith_wcwl_add_to_wishlist_button_classes')){
    //add_filter('yith_wcwl_add_to_wishlist_button_classes', 'melokids_yith_wcwl_add_to_wishlist_button_classes', 10, 1);
	function melokids_yith_wcwl_add_to_wishlist_button_classes($class){
        $new_class = array(
            'hint--top',
            'hint--bounce'
        );
		$new_class[] = get_option( 'yith_wcwl_use_button' ) == 'yes' ? '' : '';
        $class = array_merge((array)$class, $new_class);
		return trim(implode(' ', $class));
	}
}

/**
 * Custom YITH Compare
 * Change Compare button position
 * 
 */
function melokids_relocation_yith_compare_link()
{
    global $yith_woocompare;
    if(!($yith_woocompare && get_class($yith_woocompare->obj) === 'YITH_Woocompare_Frontend'))
        return;
    // Loop 
    remove_action('woocommerce_after_shop_loop_item', array($yith_woocompare->obj, 'add_compare_link'), 20);
    add_action('melokids_woocommerce_loop_overlay', array($yith_woocompare->obj, 'add_compare_link'), 20);
    // Single 
    remove_action('woocommerce_single_product_summary', array($yith_woocompare->obj, 'add_compare_link'), 35);
    add_action('woocommerce_after_add_to_cart_button', array($yith_woocompare->obj, 'add_compare_link'), 3);
}
if(!function_exists('melokids_yith_compare_actions_to_check_frontend')){
    //add_filter('yith_woocompare_actions_to_check_frontend', 'melokids_yith_compare_actions_to_check_frontend');
    function melokids_yith_compare_actions_to_check_frontend($arr)
    {
        return array_merge($arr, array(
            'products_rating',
            'nopriv_products_rating',
            'products_sale',
            'nopriv_products_sale'
        ));
    }
}
if(!function_exists('melokids_yith_compare')){
    function melokids_yith_compare(){
        echo do_shortcode('[yith_compare_button container="no"]');
    }
}

/**
 * Custom Woo Smart Compare
 * 
 * Change Compare button position
 *
*/
if(class_exists('WPcleverWooscp')){
    add_filter( 'filter_wooscp_button_archive', function() {
        return '0';
    } );
    add_filter( 'filter_wooscp_button_single', function() {
        return '0';
    } ); 
    // Loop
    add_action('melokids_loop_product_thumnail_attrs_right', 'melokids_wooscp_icon', 10);
    function melokids_wooscp_icon(){
        global $product;
        $wooscp_text = apply_filters('wooscp_button_text', get_option( '_wooscp_button_text', esc_html__( 'Compare', 'melokids' ) ));
        echo '<div class="wc-attr-icon woosmart-icon compare-icon hint--bounce hint--bottom-'.melokids_align(false).'" data-hint="'.esc_html($wooscp_text).'">'.do_shortcode('[wooscp id="'.$product->get_id().'"]').'</div>';
    }

    // Single 
    add_action('woocommerce_after_add_to_cart_button', 'melokids_wooscp_button', 10);

    function melokids_wooscp_button(){
        global $product;
        $wooscp_text = apply_filters('wooscp_button_text', get_option( '_wooscp_button_text', esc_html__( 'Compare', 'melokids' ) ));
        echo '<div class="woosmart-btn compare-btn hint--bounce hint--bottom" data-hint="'.esc_html($wooscp_text).'">'.do_shortcode('[wooscp id="'.$product->get_id().'"]').'</div>';
    }
}
/**
 * Custom Woo Smart Quick View
 *
 * Change Quick View button position
 *
*/
if(class_exists('WPcleverWoosq')){
    add_filter( 'woosq_button_position', function() {
        return '0';
    } );
    // Loop
    add_action('melokids_loop_product_thumnail_attrs_right', function(){
        global $product;
        $woosq_text = apply_filters('woosq_button_text', get_option( 'woosq_button_text', esc_html__( 'Quick view', 'melokids' ) ));
        echo '<div class="wc-attr-icon woosmart-icon quickview-icon hint--bounce hint--bottom-'.melokids_align(false).'" data-hint="'.esc_html($woosq_text).'">'.do_shortcode('[woosq id="'.$product->get_id().'"]').'</div>';
    },11);
}
/**
 * Custom Woo Smart Add to Wishlist
 *
 * Change Add to Wishlist button position
 *
*/
if(class_exists('WPcleverWoosw')){
    add_filter( 'woosw_button_position_archive', function() {
        return '0';
    } );
    add_filter( 'woosw_button_position_single', function() {
        return '0';
    } );
    // Loop 
    add_action('melokids_loop_product_thumnail_attrs_right', function(){
        global $product;
        $woosw_text  = apply_filters( 'woosw_button_text', get_option( 'woosw_button_text', esc_html__( 'Add to Wishlist', 'melokids' ) ) );
        echo '<div class="wc-attr-icon woosmart-icon wishlist-icon hint--bounce hint--bottom-'.melokids_align(false).'" data-hint="'.esc_html($woosw_text).'">'.do_shortcode('[woosw id="'.$product->get_id().'"]').'</div>';
    },12);
    // Single
    add_action('woocommerce_after_add_to_cart_button', function(){
        global $product;
        $woosw_text  = apply_filters( 'woosw_button_text', get_option( 'woosw_button_text', esc_html__( 'Add to Wishlist', 'melokids' ) ) );
        echo '<div class="woosmart-btn wishlist-btn hint--bounce hint--bottom" data-hint="'.esc_html($woosw_text).'">'.do_shortcode('[woosw id="'.$product->get_id().'"]').'</div>';
    },12);
}

