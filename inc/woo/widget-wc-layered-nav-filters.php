<?php
// Ensure some function from framework exists
if(class_exists('EF4Framework')){
	// add custom template 
	if(!function_exists('melokids_woocommerce_widgets_layered_nav_filters')){
		add_action( 'widgets_init', 'melokids_woocommerce_widgets_layered_nav_filters', 1 );
		function melokids_woocommerce_widgets_layered_nav_filters() {
		  // Ensure our parent class exists to avoid fatal error (thanks Wilgert!)
		  if ( class_exists( 'WC_Widget_Layered_Nav_Filters' ) ) {
		    unregister_ef4_widget( 'WC_Widget_Layered_Nav_Filters' );
		    register_ef4_widget( 'Melokids_WC_Widget_Layered_Nav_Filters' );
		  }
		}
	}

	/**
	 * Layered Navigation Filters Widget.
	 *
	 * @package WooCommerce/Widgets
	 * @version 2.3.0
	 */

	defined( 'ABSPATH' ) || exit;

	/**
	 * Widget layered nav filters.
	 */
	class Melokids_WC_Widget_Layered_Nav_Filters extends WC_Widget_Layered_Nav_Filters {
		/**
		 * Output widget.
		 *
		 * @see WP_Widget
		 * @param array $args     Arguments.
		 * @param array $instance Widget instance.
		 */
		public function widget( $args, $instance ) {
			if ( ! is_shop() && ! is_product_taxonomy() ) {
				return;
			}
			$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
			$min_price          = isset( $_GET['min_price'] ) ? wc_clean( wp_unslash( $_GET['min_price'] ) ) : 0; // WPCS: input var ok, CSRF ok.
			$max_price          = isset( $_GET['max_price'] ) ? wc_clean( wp_unslash( $_GET['max_price'] ) ) : 0; // WPCS: input var ok, CSRF ok.
			$rating_filter      = isset( $_GET['rating_filter'] ) ? array_filter( array_map( 'absint', explode( ',', wp_unslash( $_GET['rating_filter'] ) ) ) ) : array(); // WPCS: sanitization ok, input var ok, CSRF ok.
			$base_link          = $this->get_current_page_url();

			if ( 0 < count( $_chosen_attributes ) || 0 < $min_price || 0 < $max_price || ! empty( $rating_filter ) ) {

				$this->widget_start( $args, $instance );

				echo '<ul class="woocommerce-widget-layered-nav-list">';

				// Attributes.
				if ( ! empty( $_chosen_attributes ) ) {
					foreach ( $_chosen_attributes as $taxonomy => $data ) {
						foreach ( $data['terms'] as $term_slug ) {
							$term = get_term_by( 'slug', $term_slug, $taxonomy );
							if ( ! $term ) {
								continue;
							}

							$filter_name     = 'filter_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );

							$filter_by       =  sanitize_title( str_replace( 'pa_', '', $taxonomy ) );
							$filter_by_class = 'filter-by-' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );
							$filter_class    = 'wc-filter-' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );

							$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array(); // WPCS: input var ok, CSRF ok.
							$current_filter = array_map( 'sanitize_title', $current_filter );
							$new_filter     = array_diff( $current_filter, array( $term_slug ) );

							$link = remove_query_arg( array( 'add-to-cart', $filter_name ), $base_link );

							if ( count( $new_filter ) > 0 ) {
								$link = add_query_arg( $filter_name, implode( ',', $new_filter ), $link );
							}

							$filter_icon_text =  '';
				            if($taxonomy === 'pa_size'){
				                $filter_icon_text = $term->name;
				                if(strlen($term->name) > 3)
				                    $filter_icon_text = substr($term->name, 0, 1);
				            }

							// Get color option
							$custom_color = melokids_get_custom_meta_pa_color($term->term_id);
				            $custom_brand = melokids_get_custom_meta_pa_brand($term->term_id);
				            $type_use = 'name';
				            if (!empty($custom_color['color_value']))
				                $type_use = 'color';
				            if (!empty($custom_color['color_image']))
				                $type_use = 'color_image';
				            if($taxonomy === 'pa_brand'){
				                if (!empty($custom_brand['brand_logo']))
				                    $type_use = 'brand_logo';
				                else 
				                    $type_use = 'placeholder';
				            }
				            switch ($type_use) {
				                case 'brand_logo':
				                    $bg_css = "background-image:url({$custom_brand['brand_logo']})";
				                    break;
				                case 'color_image':
				                    $bg_css = "background-image:url({$custom_color['color_image']})";
				                    break;
				                case 'color':
				                    $bg_css = "background-color:" . ((!empty($custom_color['color_value'])) ? $custom_color['color_value'] : $term->slug);
				                    break;
				                case 'placeholder':
				                    $bg_css = 'background-image:url('.get_template_directory_uri().'/assets/images/no-image.jpg)';
				                    break;
				                default :
				                    $bg_css = "background-color:" . $term->slug;
				                    break;
				            }
							echo '<li class="chosen chosen-attr '.esc_attr($filter_by_class).'"><a rel="nofollow" id="'.esc_attr($filter_by.'_'.$term->slug).'" class="wc-widget-filter '.esc_attr($filter_class).' hint--top" aria-label="' . esc_attr__( 'Remove filter', 'melokids' ) . '" href="' . esc_url( $link ) . '"><span class="filter-icon filter-icon-'.$filter_by.'" style="'. esc_attr($bg_css).'">'.$filter_icon_text.'</span><span class="filter-title">' . esc_html( $term->name ) . '</span></a></li>';
						}
					}
				}

				if ( $min_price ) {
					$link = remove_query_arg( 'min_price', $base_link );
					/* translators: %s: minimum price */
					echo '<li class="chosen chosen-min-price"><a rel="nofollow" class="wc-widget-filter filter-by-price hint--top" aria-label="' . esc_attr__( 'Remove filter', 'melokids' ) . '" href="' . esc_url( $link ) . '">' . sprintf( __( 'Min %s', 'melokids' ), wc_price( $min_price ) ) . '</a></li>'; // WPCS: XSS ok.
				}

				if ( $max_price ) {
					$link = remove_query_arg( 'max_price', $base_link );
					/* translators: %s: maximum price */
					echo '<li class="chosen chosen-max-price"><a rel="nofollow" class="wc-widget-filter filter-by-price hint--top" aria-label="' . esc_attr__( 'Remove filter', 'melokids' ) . '" href="' . esc_url( $link ) . '">' . sprintf( __( 'Max %s', 'melokids' ), wc_price( $max_price ) ) . '</a></li>'; // WPCS: XSS ok.
				}

				if ( ! empty( $rating_filter ) ) {
					foreach ( $rating_filter as $rating ) {
						$link_ratings = implode( ',', array_diff( $rating_filter, array( $rating ) ) );
						$link         = $link_ratings ? add_query_arg( 'rating_filter', $link_ratings ) : remove_query_arg( 'rating_filter', $base_link );

						/* translators: %s: rating */
						echo '<li class="chosen chosen-rating"><a rel="nofollow" class="wc-widget-filter filter-by-rating hint--top" aria-label="' . esc_attr__( 'Remove filter', 'melokids' ) . '" href="' . esc_url( $link ) . '">' . sprintf( esc_html__( 'Rated %s out of 5', 'melokids' ), esc_html( $rating ) ) . '</a></li>';
					}
				}

				echo '</ul>';

				$this->widget_end( $args );
			}
		}
	}
}