<?php
if(!class_exists('WooCommerce')) return;

// Call data for autocomplete param
//js_composer/include/params/autocomplete/autocomplete.php line 45
// vc_filter: vc_autocomplete_{shortcode_tag}_{param_name}_render - hook to define output for autocomplete item

add_filter( 'vc_autocomplete_zkproduct_product_id_callback', 'vc_autocomplete_product_id_field_search', 10, 1 );
add_filter( 'vc_autocomplete_zkproduct_product_id_render', 'vc_autocomplete_product_id_field_render', 10, 1 );

vc_map(array(
    'name'        => 'MeloKids Single Product',
    'base'        => 'zkproduct',
    'icon'        => 'icon-wpb-woocommerce',
    'category'    => esc_html__('MeloKids','melokids'),
    'description' => esc_html__('Show a product', 'melokids'),
    'params'      => array(        
        array(
            'type'        => 'autocomplete',
            'heading'     => esc_html__('Select identificator','melokids'),
            'description' => esc_html__('Enter product Title  or product SKU or product ID to see suggestions','melokids'),
            'param_name'  => 'product_id',
        ),
		array(
			'type' => 'hidden',
			// This will not show on render, but will be used when defining value for autocomplete
			'param_name' => 'sku',
		),
        array(
            'type' => 'textfield',
            'param_name' => 'ctp_name',
            'heading' => esc_html__('Custom product Name','melokids'),
            'description' => esc_html__('This option will overwrite product name in this element','melokids')
        ),
        array(
            'type'        => 'attach_image',
            'param_name'        => 'ctp_image',
            'heading'     => esc_html__('Custom product image','melokids'),
            'description' => esc_html__('This option will overwrite product image in this element','melokids')
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Extra class name', 'melokids' ),
            'param_name'  => 'el_class',
            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'melokids' ),
        ),
        array(
            'type'       => 'img',
            'heading'    => esc_html__('Layout Template','melokids'),
            'param_name' => 'layout_template',
            'value'      =>  array(
                '1' => get_template_directory_uri().'/vc_customs/layouts/product1.png',
                '2' => get_template_directory_uri().'/vc_customs/layouts/product2.png',
                '3' => get_template_directory_uri().'/vc_customs/layouts/product2.png',
            ),
            'std'        => '1',
            'group'         => esc_html__('Layout Settings','melokids')
        ),
        /* Layout 2 */
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Button Type','melokids'),
            'param_name' => 'btn_type',
            'value'      =>  array(
                esc_html__('Add To Cart Button','melokids') => '1',
                esc_html__('Link to Details','melokids')    => '2',
            ),
            'std'        => '2',
            'group'      => esc_html__('Layout Settings','melokids'),
            'dependency' => array(
                'element' => 'layout_template',
                'value'   => array('2','3')
            )
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('Button Text','melokids'),
            'param_name' => 'btn_text',
            'value'      => 'Buy Now',
            'group'      => esc_html__('Layout Settings','melokids'),
            'dependency' => array(
                'element' => 'btn_type',
                'value'   => array('2')
            )
        ),
    )
));

class WPBakeryShortCode_zkproduct extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}