<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

if ( ! defined( 'YITH_WCWL' ) ) {
    exit;
} // Exit if accessed directly

global $product;
if(isset($icon) && empty($icon)) {
	$iconClass = apply_filters('yith_wcwl_icon_class','fa fa-heart-o');
	$icon = '<i class="'.$iconClass.'"></i>'; 
}
?>
<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) )?>" rel="nofollow" data-product-id="<?php echo esc_attr($product_id); ?>" data-product-type="<?php echo esc_attr($product_type);?>" class="<?php echo esc_attr($link_classes); ?>" data-hint="<?php echo esc_html($label) ?>">
    <?php echo sprintf('%s', $icon).' '.esc_html($label)?>
</a>