<?php
/**
 * Add to wishlist template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly

global $product;

if(isset($icon) && empty($icon)) {
	$iconClass = apply_filters('yith_wcwl_icon_class','fa fa-heart-o');
	$icon = '<i class="'.$iconClass.'"></i>'; 
}
$show_hide_cls = ( $exists && ! $available_multi_wishlist ) ? 'hide': 'show';
$display_style = ( $exists && ! $available_multi_wishlist ) ? 'none': 'block';

?>

<div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo esc_attr($product_id) ?>">
	<?php if( ! ( $disable_wishlist && ! is_user_logged_in() ) ): ?>
	    <div class="yith-wcwl-add-button <?php echo esc_attr($show_hide_cls); ?>" style="display:<?php echo esc_attr($display_style); ?>">
	        <?php yith_wcwl_get_template( 'add-to-wishlist-' . $template_part . '.php', $atts ); ?>
	    </div>

	    <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
	        <a href="<?php echo esc_url( $wishlist_url )?>" class="<?php echo str_replace( 'add_to_wishlist', 'added_to_wishlist', $link_classes ) ?>" data-hint="<?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', $browse_wishlist_text )?>">
	        	<?php echo sprintf('%s', $icon).' '.apply_filters( 'yith-wcwl-browse-wishlist-label', $browse_wishlist_text ) ?>
	        </a>
	    </div>

	    <div class="yith-wcwl-wishlistexistsbrowse <?php echo esc_attr($show_hide_cls); ?>" style="display:<?php echo esc_attr($display_style); ?>">
	        <a href="<?php echo esc_url( $wishlist_url ) ?>" class="<?php echo str_replace( 'add_to_wishlist', 'added_to_wishlist', $link_classes ) ?>" data-hint="<?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', $browse_wishlist_text );?>">
	            <?php echo sprintf('%s', $icon).' '.apply_filters( 'yith-wcwl-browse-wishlist-label', $browse_wishlist_text ) ?>
	        </a>
	    </div>
	    <div class="yith-wcwl-wishlistaddresponse"></div>
	<?php else: ?>
		<a href="<?php echo esc_url( add_query_arg( array( 'wishlist_notice' => 'true', 'add_to_wishlist' => $product_id ), get_permalink( wc_get_page_id( 'myaccount' ) ) ) )?>" class="<?php echo str_replace( 'add_to_wishlist', 'added_to_wishlist', $link_classes ) ?>" data-hint="<?php echo esc_html($label) ?>">
			<?php echo sprintf('%s',$icon).' '.esc_html($label); ?>
		</a>
	<?php endif; ?>

</div>