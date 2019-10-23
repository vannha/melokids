<?php
/** 
 * Custom Widget Product Categories 
 * This code filters and modify the Product Categories widget walker to include the post count inside the link 
 * @since 1.0.0
*/
if(!function_exists('melokids_woocommerce_product_categories_widget_args')){
	include_once WC()->plugin_path() . '/includes/walkers/class-wc-product-cat-list-walker.php';
	add_filter('woocommerce_product_categories_widget_args', 'melokids_woocommerce_product_categories_widget_args');
	function melokids_woocommerce_product_categories_widget_args($list_args){
		$list_args['walker'] = new Melokids_WC_Product_Cat_List_Walker;
		return $list_args;
	}
}

class Melokids_WC_Product_Cat_List_Walker extends WC_Product_Cat_List_Walker{
	public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$cat_id = intval( $cat->term_id );

		$output .= '<li class="wg-menu-item cat-item cat-item-' . $cat_id;

		if ( $args['current_category'] === $cat_id ) {
			$output .= ' current-cat';
		}

		if ( $args['has_children'] && $args['hierarchical'] && ( empty( $args['max_depth'] ) || $args['max_depth'] > $depth + 1 ) ) {
			$output .= ' cat-parent';
		}

		if ( $args['current_category_ancestors'] && $args['current_category'] && in_array( $cat_id, $args['current_category_ancestors'], true ) ) {
			$output .= ' current-cat-parent';
		}

		$output .= '"><a class="wc-widget-filter" href="' . get_term_link( $cat_id, $this->tree_type ) . '"><span class="title">' . apply_filters( 'list_product_cats', $cat->name, $cat ).'</span>';

		if ( $args['show_count'] ) {
			$output .= ' <span class="count">(' . $cat->count . ')</span>';
		}

		$output .= '</a>';
	}
}