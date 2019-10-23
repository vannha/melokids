<?php
// Ensure some function from framework exists
if(class_exists('EF4Framework')){
    // add custom template 
    if(!function_exists('melokids_woocommerce_widgets_layered_nav')){
        add_action( 'widgets_init', 'melokids_woocommerce_widgets_layered_nav', 1 );
        function melokids_woocommerce_widgets_layered_nav() {
          // Ensure our parent class exists to avoid fatal error (thanks Wilgert!)
          if ( class_exists( 'WC_Widget_Layered_Nav' ) ) {
            unregister_ef4_widget( 'WC_Widget_Layered_Nav' );
            register_ef4_widget( 'Melokids_WC_Widget_Layered_Nav');
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

    class Melokids_WC_Widget_Layered_Nav extends WC_Widget_Layered_Nav {
        /**
         * Output widget.
         *
         * @see WP_Widget
         *
         * @param array $args Arguments.
         * @param array $instance Instance.
         */
        public function widget( $args, $instance ) {
            if ( ! is_shop() && ! is_product_taxonomy() ) {
                // Need remove it to use filter on non-product archive page
                return;
            }

            $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
            $taxonomy           = isset( $instance['attribute'] ) ? wc_attribute_taxonomy_name( $instance['attribute'] ) : $this->settings['attribute']['std'];
            $query_type         = isset( $instance['query_type'] ) ? $instance['query_type'] : $this->settings['query_type']['std'];
            $display_type       = isset( $instance['display_type'] ) ? $instance['display_type'] : $this->settings['display_type']['std'];

            if ( ! taxonomy_exists( $taxonomy ) ) {
                return;
            }

            $get_terms_args = array( 'hide_empty' => '1' );

            $orderby = wc_attribute_orderby( $taxonomy );

            switch ( $orderby ) {
                case 'name':
                    $get_terms_args['orderby']    = 'name';
                    $get_terms_args['menu_order'] = false;
                    break;
                case 'id':
                    $get_terms_args['orderby']    = 'id';
                    $get_terms_args['order']      = 'ASC';
                    $get_terms_args['menu_order'] = false;
                    break;
                case 'menu_order':
                    $get_terms_args['menu_order'] = 'ASC';
                    break;
            }

            $terms = get_terms( $taxonomy, $get_terms_args );

            if ( 0 === count( $terms ) ) {
                return;
            }

            switch ( $orderby ) {
                case 'name_num':
                    usort( $terms, '_wc_get_product_terms_name_num_usort_callback' );
                    break;
                case 'parent':
                    usort( $terms, '_wc_get_product_terms_parent_usort_callback' );
                    break;
            }

            ob_start();

            $this->widget_start( $args, $instance );

            if ( 'dropdown' === $display_type ) {
                wp_enqueue_script( 'selectWoo' );
                wp_enqueue_style( 'select2' );
                $found = $this->layered_nav_dropdown( $terms, $taxonomy, $query_type );
            } else {
                $found = $this->layered_nav_list( $terms, $taxonomy, $query_type );
            }

            $this->widget_end( $args );

            // Force found when option is selected - do not force found on taxonomy attributes.
            if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
                $found = true;
            }

            if ( ! $found ) {
                ob_end_clean();
            } else {
                echo ob_get_clean(); // @codingStandardsIgnoreLine
            }
        }
        /**
         * Show list based layered nav.
         *
         * @param  array  $terms Terms.
         * @param  string $taxonomy Taxonomy.
         * @param  string $query_type Query Type.
         * @return bool   Will nav display?
         */
        protected function layered_nav_list( $terms, $taxonomy, $query_type ) {
            // List display.
            echo '<ul class="woocommerce-widget-layered-nav-list">';

            $term_counts        = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
            $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
            $found              = false;

            foreach ( $terms as $term ) {
                $current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
                $option_is_set  = in_array( $term->slug, $current_values, true );
                $count          = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

                // Skip the term for the current archive.
                if ( $this->get_current_term_id() === $term->term_id ) {
                    continue;
                }

                // Only show options with count > 0.
                if ( 0 < $count ) {
                    $found = true;
                } elseif ( 0 === $count && ! $option_is_set ) {
                    continue;
                }

                $filter_name     = 'filter_' . str_replace( 'pa_', '', $taxonomy );
                
                $filter_by       =  sanitize_title( str_replace( 'pa_', '', $taxonomy ) );
                $filter_by_class = 'filter-by-' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );
                $filter_class    = 'wc-filter-' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );

                $current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array(); // WPCS: input var ok, CSRF ok.
                $current_filter = array_map( 'sanitize_title', $current_filter );

                if ( ! in_array( $term->slug, $current_filter, true ) ) {
                    $current_filter[] = $term->slug;
                }

                $link = remove_query_arg( $filter_name, $this->get_current_page_url() );

                // Add current filters to URL.
                foreach ( $current_filter as $key => $value ) {
                    // Exclude query arg for current term archive term.
                    if ( $value === $this->get_current_term_slug() ) {
                        unset( $current_filter[ $key ] );
                    }

                    // Exclude self so filter can be unset on click.
                    if ( $option_is_set && $value === $term->slug ) {
                        unset( $current_filter[ $key ] );
                    }
                }

                if ( ! empty( $current_filter ) ) {
                    asort( $current_filter );
                    $link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

                    // Add Query type Arg to URL.
                    if ( 'or' === $query_type && ! ( 1 === count( $current_filter ) && $option_is_set ) ) {
                        $link = add_query_arg( 'query_type_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) ), 'or', $link );
                    }
                    $link = str_replace( '%2C', ',', $link );
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

                $filter_icon_text =  '';
                if($taxonomy === 'pa_size'){
                    $filter_icon_text = $term->name;
                    if(strlen($term->name) > 3)
                        $filter_icon_text = substr($term->name, 0, 1);
                }
                $filter_icon = '<span class="filter-icon filter-icon-'.$filter_by.'" style="'.$bg_css.'">'.$filter_icon_text.'</span>';

                $count_html = ' ' . apply_filters( 'woocommerce_layered_nav_count', '<span class="filter-count">(' . absint( $count ) . ')</span>', $count, $term );
                if ( $count > 0 || !$option_is_set ) {
                    $link      = esc_url( apply_filters( 'woocommerce_layered_nav_link', $link, $term, $taxonomy ) );
                    $term_html = '<a rel="nofollow" id="'.esc_attr($filter_by.'_'.$term->slug).'" class="wc-widget-filter wc-widget-filter-layout '.esc_attr($filter_class).' hint--top" aria-label="'.esc_attr($term->name).' ('.absint( $count ).')" data-count="'.absint( $count ).'" href="' . $link . '">'.$filter_icon.'<span class="filter-title">' . esc_html( $term->name ).'</span>'.$count_html.'</a>';
                } else {
                    $link      = false;
                    $term_html = '<span class="wc-widget-filter '.esc_attr($filter_class).' hint--top" aria-label="'.esc_attr($term->name).' ('.absint( $count ).')" data-count="'.absint( $count ).'">'.$filter_icon.'<span class="filter-title">' . esc_html( $term->name ) . '</span>'.$count_html.'</span>';
                }

                //$term_html .= ' ' . apply_filters( 'woocommerce_layered_nav_count', '<span class="count">(' . absint( $count ) . ')</span>', $count, $term );

                echo '<li class="woocommerce-widget-layered-nav-list__item wc-layered-nav-term ' . ( $option_is_set ? 'woocommerce-widget-layered-nav-list__item--chosen chosen' : '' ) . ' '.esc_attr($filter_by_class).'">';
                echo wp_kses_post( apply_filters( 'woocommerce_layered_nav_term_html', $term_html, $term, $link, $count ) );
                echo '</li>';
            }

            echo '</ul>';

            return $found;
        }
    }
}


/** 
 * Custom Widget Product Layered Nav List  
 * This code filters the Product Layered Nav List widget to include the post count inside the link 
 * @since 1.0.0
*/
if(!function_exists('melokids_wc_attr_count_span')){
	//add_filter('woocommerce_layered_nav_term_html', 'melokids_wc_attr_count_span');
	function melokids_wc_attr_count_span($term_html) {
	    $dir = is_rtl() ? 'left' : 'right';
	    $term_html = str_replace('</a> <span class="count">(', ' <span class="count '.$dir.'">(', $term_html);
	    $term_html = str_replace(')</span>', ')</span></a>', $term_html);
	    return $term_html;
	}
}

/**
 * Custom layout layered nav
 *
 * Custom layout for attribute pa_color
 * 
*/
//add_filter('woocommerce_layered_nav_term_html','melokids_woocommerce_layered_nav_term_html_pa_color',11,4);
function melokids_woocommerce_layered_nav_term_html_pa_color($term_html, $term ='', $link='', $count='' )
{
    if($term->taxonomy !== 'pa_color')
        return $term_html;
    $custom = melokids_get_custom_meta_pa_color($term->term_id);
    $type_use = 'name';
    if (!empty($custom['color_value']))
        $type_use = 'color';
    if (!empty($custom['color_image']))
        $type_use = 'image';
    switch ($type_use) {
        case 'image':
            $bg_css = "background-image:url({$custom['color_image']})";
            break;
        default:
            $bg_css = "background-color:" . ((!empty($custom['color_value'])) ? $custom['color_value'] : $term->slug);
            break;
    }
    ?>
    <a href="<?php echo esc_url($link);?>" id="color_<?php echo esc_attr($term->slug) ?>" class="wc-widget-filter wc-filter-color hint--top" data-hint="<?php echo esc_attr($term->name.' ('.$count.')'); ?>" data-count="<?php echo esc_attr($count);?>"><span class="wc-filter-icon" style="<?php echo esc_attr($bg_css) ?>"></span><span class="wc-filter-title"><?php echo esc_html($term->name.' ('.$count.')'); ?></span></a>
    <?php
    return '';
}
 
/**
 * Custom layout layered nav
 *
 * Custom layout for attribute pa_size
 * 
*/
//add_filter('woocommerce_layered_nav_term_html','melokids_woocommerce_layered_nav_term_html_pa_size',11,4);
function melokids_woocommerce_layered_nav_term_html_pa_size($term_html, $term ='', $link='', $count='' )
{
    if($term->taxonomy !== 'pa_size')
        return $term_html;
    ?>
    <a href="<?php echo esc_url($link);?>" id="size_<?php echo esc_attr($term->slug) ?>" class="wc-widget-filter wc-filter-size hint--top" data-hint="<?php echo esc_attr($count); ?>" data-count="<?php echo esc_attr($count);?>"><?php echo esc_html($term->name); ?></a>
    <?php
    return '';
}

/**
 * Custom layout layered nav
 *
 * Custom layout for attribute pa_brand
 * 
*/
//add_filter('woocommerce_layered_nav_term_html','melokids_woocommerce_layered_nav_term_html_pa_brand',11,4);
function melokids_woocommerce_layered_nav_term_html_pa_brand($term_html, $term ='', $link='', $count='' )
{
    if($term->taxonomy !== 'pa_brand')
        return $term_html;
    ?>
    <a href="<?php echo esc_url($link);?>" id="brand_<?php echo esc_attr($term->slug) ?>" class="wc-widget-filter wc-filter-brand hint--top" data-hint="<?php echo esc_attr($count); ?>" data-count="<?php echo esc_attr($count);?>"><?php echo esc_html($term->name); ?></a>
    <?php
    return '';
}