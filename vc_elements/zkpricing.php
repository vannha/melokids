<?php
vc_map(array(
    'name'        => 'MeloKids Pricing',
    'base'        => 'zkpricing',
    'icon'        => 'zkel-icon-pricing',
    'category'    => esc_html__('MeloKids', 'melokids'),
    'description' => esc_html__('Add your pricing', 'melokids'),
    'params'      => array(
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Element Title', 'melokids' ),
            'param_name'  => 'el_title',
            'value'       => 'Standard',
            'admin_label' => true,
            'group'       => esc_html__('Settings','melokids'),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Currency code', 'melokids' ),
            'heading'     => esc_html__( 'Enter your currency code', 'melokids' ),
            'param_name'  => 'el_price_currency',
            'value'       => '$',
            'group'       => esc_html__('Settings','melokids'),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Price', 'melokids' ),
            'heading'     => esc_html__( 'Enter your price', 'melokids' ),
            'param_name'  => 'el_price',
            'value'       => '9.99',
            'group'       => esc_html__('Settings','melokids'),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Price Plan', 'melokids' ),
            'heading'     => esc_html__( 'Enter your plan. Per week / month / year', 'melokids' ),
            'param_name'  => 'el_price_plan',
            'value'       => '/per month',
            'group'       => esc_html__('Settings','melokids'),
        ),
        
        array(
            'type'        => 'checkbox',
            'heading'     => esc_html__( 'Add Image ?', 'melokids' ),
            'param_name'  => 'add_image',
            'std'         => false,
            'description' => esc_html__( 'Add an image', 'melokids' ),
            'group'       => esc_html__( 'Settings', 'melokids' ),
        ),
        array(
            'type'          => 'attach_image',
            'param_name'    => 'image',
            'heading'       => esc_html__( 'Choose your image', 'melokids' ),
            'value'         => '',
            'description'   => esc_html__( 'Choose an image.', 'melokids' ),
            'group'         => esc_html__('Image','melokids'),
            'dependency'    => array(
                'element' => 'add_image', 
                'value'   => 'true',
            ),
        ),
        array(
            'type'          => 'dropdown',
            'class'         => '',
            'heading'       => esc_html__('Thumbnail Size','melokids'),
            'param_name'    => 'thumbnail_size',
            'value'         => melokids_thumbnail_sizes(),
            'std'           => 'medium',
            'group'         => esc_html__('Image', 'melokids'),
            'dependency'    => array(
              'element'   => 'image',
              'not_empty' => true,
            ),
        ),
        array(
            'type'          => 'textfield',
            'class'         => '',
            'heading'       => esc_html__('Custom Thumbnail Size','melokids'),
            'description'   => esc_html__('Alternatively enter size in pixels (Example: 200x100 (Width x Height)).','melokids'),
            'param_name'    => 'thumbnail_size_custom',
            'value'         => '',
            'group'         => esc_html__('Image', 'melokids'),
            'dependency'    => array(
              'element'   => 'thumbnail_size',
              'value'     => 'custom',
            ),
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__( 'Image position', 'melokids' ),
            'param_name' => 'img_pos',
            'value'      => array(
                esc_html__( 'Top', 'melokids' )      => 'top',
            ),
            'std'         => '',
            'description' => esc_html__( 'Select image position.', 'melokids' ),
            'dependency'  => array(
                'element'   => 'image', 
                'not_empty' => true,
            ),
            'group'         => esc_html__('Image','melokids'),
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__( 'Layout Type', 'melokids' ),
            'param_name' => 'layout_type',
            'value'      => array(
                esc_html__( 'Default', 'melokids' )      => '',
                esc_html__( 'Featured', 'melokids' )     => 'featured',
            ),
            'std'         => '',
            'description' => esc_html__( 'Choose layout type.', 'melokids' ),
            'group'         => esc_html__('Settings','melokids'),
        ),
        array(
            'type'       => 'img',
            'heading'    => esc_html__('Layout Mode','melokids'),
            'param_name' => 'layout_mode',
            'value'      =>  array(
                '1' => get_template_directory_uri().'/assets/images/header/default.jpg',
            ),
            'std'   => '1',
            'group' => esc_html__('Settings','melokids'),
        ),
        array(
            'type'          => 'dropdown',
            'heading'       => esc_html__('Content Align','melokids'),
            'param_name'    => 'content_align',
            'value'         => array(
                'Default'   => '',
                'Left'      => 'text-left',
                'Right'     => 'text-right',
                'Center'    => 'text-center'
            ),
            'std'           => 'text-center',
            'group'         => esc_html__('Settings', 'melokids')
        ),
        array(
            'type'        => 'checkbox',
            'heading'     => esc_html__( 'Featured Space', 'melokids' ),
            'param_name'  => 'feature_space',
            'value'       => array(
                esc_html__('Add Large space to bottom?','melokids') => true
            ),
            'std'         => false,
            'group'       => esc_html__( 'Feature List', 'melokids' ),
        ),
        array(
            'type'       => 'param_group',
            'heading'    => esc_html__( 'Add your feature', 'melokids' ),
            'param_name' => 'values',
            'value'      =>  urlencode( json_encode( array(
                array(
                    'feature_text' => esc_html__( 'Development', 'melokids' ),
                ),
                array(
                    'feature_text' => esc_html__( 'Design', 'melokids' ),
                ),
                array(
                    'feature_text' => esc_html__( 'Marketing', 'melokids' ),
                ),
            ) ) ),
            'group'      => esc_html__('Feature List','melokids'),
            'params'     => array_merge(
                array(
                    array(
                        'type'       => 'textfield',
                        'heading'    => esc_html__( 'Feature Text', 'melokids' ),
                        'param_name' => 'feature_text',
                        'admin_label' => true,
                    ),
                    array(
                        'type'          => 'checkbox',
                        'param_name'    => 'add_icon',
                        'heading'       => esc_html__( 'Add Icon?', 'melokids' ),
                        'std'           => 'false',
                        'group'         => esc_html__('Icon','melokids')
                    )
                ),
                melokids_icon_libs(),
                melokids_icon_libs_icon()
            ),
        ),
        array(
            'type'          => 'vc_link',
            'heading'       => esc_html__('Choose Link','melokids'),
            'param_name'    => 'button_link',
            'value'         => '',
            'group'         => esc_html__('Button','melokids'),
        ),
        array(
            "type"       => "css_editor",
            "heading"    => '',
            "param_name" => "css",
            "value"      => "",
            "group"      => esc_html__("Design Options",'melokids'),
        ) 
    )
));

class WPBakeryShortCode_zkpricing extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}