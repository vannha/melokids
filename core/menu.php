<?php
/** 
 * wp_list_categories()
 *
 * This code filters the Categories list to add class: parent 
 * to parent category to make open/close child category 
 *
 * @since 1.0.0
*/
if(!function_exists('melokids_category_css_class')){
	add_filter('category_css_class','melokids_category_css_class',10,4);
	function melokids_category_css_class($css_classes, $category, $depth, $args ){
	    if ( $args['has_children'] && $args['hierarchical'] && ( empty( $args['max_depth'] ) || $args['max_depth'] > $depth + 1 ) ) {
	        $css_classes[] = 'parent';
	    }
	    return $css_classes;  
	}
}

/** 
 * wp_list_pages()
 *
 * This code filters the wp_list_pages to add class:  parent 
 * to parent page to make open/close child page 
 *
 * @since 1.0.0
*/
if(!function_exists('melokids_page_css_class')){
	add_filter('page_css_class','melokids_page_css_class',10,5);
	function melokids_page_css_class($css_class, $page, $depth, $args, $current_page ){
	    if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
	        $css_class[] = 'parent';
	    }
	    return $css_class;  
	}
}

/** 
 * wp_nav_menu()
 *
 * Filtering a Class in Navigation Menu Item
 * This code filters the wp_nav_menu to add class:  parent 
 * to parent page to make open/close child page 
 *
 * @since 1.0.0
*/
if(!function_exists('melokids_parent_nav_class')){
	add_filter('nav_menu_css_class' , 'melokids_parent_nav_class' , 10 , 4);
	function melokids_parent_nav_class($classes, $item, $args){
	    if(in_array('menu-item-has-children', $item->classes))
	        $classes[] = 'parent';
	    return $classes;
	}
}
/**
 * Removes all wp_menu_nav classes EXCEPT some allowed classes
 * filter hook: add_filter('nav_menu_css_class', 'melokids_nav_class_filter', 100, 2);
 *
 */
if(!function_exists('melokids_nav_class_filter')){
	
    function melokids_nav_class_filter( $var , $item ) {
        $default_class = $item->classes;
        $allowed_class = array(
            $default_class[0],
            'menu-item',
            'current-menu-item',
            'current-menu-ancestor',
            'menu-item-has-children',
            'parent',
            'megamenu'
        );
        return is_array($var) ? array_intersect($var, $allowed_class) : '';
    }
}

/**
 * Add new argument to wp_nav_menu
 * add args to add custom class to li tag
 *
*/
function melokids_add_additional_class_on_nav_menu_li($classes, $item, $args) {
    if(!empty($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'melokids_add_additional_class_on_nav_menu_li', 1, 3);


/**
 * Using custom attributes in menus and taxonomy archives
 * https://docs.woocommerce.com/document/using-custom-attributes-in-menus/
*/
if(!function_exists('melokids_woocommerce_attribute_show_in_nav_menus')){
    add_filter('woocommerce_attribute_show_in_nav_menus', 'melokids_woocommerce_attribute_show_in_nav_menus', 1, 3);
    function melokids_woocommerce_attribute_show_in_nav_menus( $register, $name, $attributes = ['pa_size','pa_colors','pa_badge','pa_year-old', 'pa_brand'] ) {
         if ( in_array($name, $attributes) ) $register = true;
         return $register;
    }
}

/**
 * Show Menu Description option
 * filter hook : walker_nav_menu_start_el
 *
 * add_filter('walker_nav_menu_start_el', 'melokids_add_description_to_menu', 10, 4);
 *
*/
if(!function_exists('melokids_add_description_to_menu')){
    function melokids_add_description_to_menu($item_output, $item, $depth, $args) {
        if (strlen($item->description) > 0 ) {
            //insert description as last item *in* link ($input_output ends with "</a>{$args->after}")
            $item_output = substr($item_output, 0, -strlen("</a>{$args->after}")) . sprintf('<span class="menu-desc">%s</span >', esc_html($item->description)) . "</a>{$args->after}";
        }

        return $item_output;
    }
}
