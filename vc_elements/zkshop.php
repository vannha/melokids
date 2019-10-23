<?php
if(!class_exists('WooCommerce')) return;

// Call data for autocomplete param
//js_composer/include/params/autocomplete/autocomplete.php line 45
// vc_filter: vc_autocomplete_{shortcode_tag}_{param_name}_render - hook to define output for autocomplete item

add_filter( 'vc_autocomplete_zkshop_category_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
add_filter( 'vc_autocomplete_zkshop_category_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

vc_map(array(
    'name'        => 'MeloKids Shop List',
    'base'        => 'zkshop',
    'icon'        => 'icon-wpb-woocommerce',
    'category'    => esc_html__('MeloKids','melokids'),
    'description' => esc_html__('Show Archive products', 'melokids'),
    'params'      => array(
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('Products per page','melokids'),
            'description'=> esc_html__('The "per_page" shortcode determines how many products to show on the page','melokids'),
            'param_name' => 'limit',
            'value'      => 16,   
            'std'        => 16,   
            'admin_label' => true,
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Products columns','melokids'),
            'description'=> esc_html__('The columns attribute controls how many columns wide the products should be before wrapping.','melokids'),
            'param_name' => 'columns',
            'value'      => array(1,2,3,4),
            'std'        => 4,
            'admin_label' => true,
        ),
       
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Order By','melokids'),
            'description' => esc_html__('Select how to sort retrieved products','melokids'),
            'param_name'  => 'orderby',
            'value'       => array(
                esc_html__('Default','melokids')                => '',
                esc_html__('Title','melokids')                  => 'title',
                esc_html__('Date','melokids')                   => 'date ',
                esc_html__('ID','melokids')                     => 'id',
                esc_html__('Menu Order','melokids')             => 'menu_order',
                esc_html__('Popular','melokids')                => 'popularity',
                esc_html__('Randomly','melokids')               => 'rand',
                esc_html__('Average product rating','melokids') => 'rating',
            ),
            'std'        => '',
            'admin_label' => true,
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Sort order','melokids'),
            'description' => esc_html__('Designates the ascending or descending order','melokids'),
            'param_name'  => 'order',
            'value'       => array(
                esc_html__('Ascending ','melokids')  => 'ASC',
                esc_html__('Descending ','melokids') => 'DESC',
            ),
            'std'        => 'ASC',
            'admin_label' => true,
        ),
        array(
            'type'        => 'autocomplete',
            'heading'     => esc_html__('Product Categories','melokids'),
            'description' => esc_html__('Enter categories you want to show','melokids'),
            'param_name'  => 'category',
            'settings'    => array(
                'multiple'       => true,
                'min_length'     => 2,
                'groups'         => true,
                'unique_values'  => true,
                'display_inline' => true,
                'delay'          => 500,
                'auto_focus'     => true,
            ),
            'param_holder_class' => 'vc_not-for-custom',
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Products to show','melokids'),
            'description' => esc_html__('What product to show','melokids'),
            'param_name'  => 'product_show',
            'value'       => array(
                esc_html__('All products','melokids')          => '',
                esc_html__('Featured products','melokids')     => 'featured',
                esc_html__('On-sale products','melokids')      => 'on_sale',
                esc_html__('Best Selling products','melokids') => 'best_selling',
                esc_html__('Top rated products','melokids')    => 'top_rated',
            ),
            'std'        => '',
            'admin_label' => true,
        ),
        array(
            'type'        => 'checkbox',
            'param_name'  => 'paginate',
            'value'       => array(
                esc_html__('Show Paginate','melokids') => 'true'
            ),
            'std'         => 'false',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Extra class name', 'melokids' ),
            'param_name'  => 'el_class',
            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'melokids' ),
        )
    )
));

class WPBakeryShortCode_zkshop extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}