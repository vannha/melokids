<?php
vc_map(array(
    'name'        => 'MeloKids Clients',
    'base'        => 'zkclients',
    'category'    => esc_html__('MeloKids', 'melokids'),
    'description' => esc_html__('Add clients image with custom link', 'melokids'),
    'icon'        => 'zkel-icon-client',
    'params'      => array_merge(
        array(
            array(
                'type'       => 'img',
                'heading'    => esc_html__('Layout Template','melokids'),
                'param_name' => 'layout_template',
                'value'      =>  array(
                    '1'          => get_template_directory_uri().'/assets/images/header/default.jpg',
                ),
                'std'        => '1',
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Content Align','melokids'),
                'param_name'    => 'content_align',
                'value'         => array(
                    'Default'       => '',
                    'Text Left'     => 'text-left',
                    'Text Right'    => 'text-right',
                    'Text Center'   => 'text-center',
                ),
                'std'           => '',
            ),
            array(
                'type'        => 'el_id',
                'settings' => array(
                    'auto_generate' => true,
                ),
                'heading'     => esc_html__( 'Element ID', 'melokids' ),
                'param_name'  => 'el_id',
                'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'melokids' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
            ),
            array(
                'type'       => 'textfield',
                'heading'    => esc_html__('Extra Class','melokids'),
                'param_name' => 'el_class',
                'value'      => '',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'melokids'),
            ),
            /* Clients Settings */
            array(
                "type"          => "dropdown",
                "heading"       => esc_html__("Client image size",'melokids'),
                "param_name"    => "thumbnail_size",
                "value"         => melokids_thumbnail_sizes(),
                "std"           => "medium",
                "group"         => esc_html__('Clients','melokids'),
            ),
            array(
                "type"          => "textfield",
                "heading"       => esc_html__("Custom member image size",'melokids'),
                'description'   => esc_html__('Alternatively enter size in pixels (Example: 200x100 (Width x Height)).','melokids'),
                "param_name"    => "thumbnail_size_custom",
                "value"         => '',
                "group"         => esc_html__('Clients','melokids'),
                'dependency'    => array(
                    'element'   => 'thumbnail_size',
                    'value'     => 'custom',
                ),
            ),
            array(
                'type'       => 'param_group',
                'heading'    => esc_html__( 'Add Clients', 'melokids' ),
                'param_name' => 'values',
                'value'      =>  '',
                'params'     => array(
                    array(
                        'type'        => 'attach_image',
                        'heading'     => esc_html__( 'Client Image', 'melokids' ),
                        'param_name'  => 'image',
                        'admin_label' => true,
                    ),
                    array(
                        'type'        => 'vc_link',
                        'heading'     => esc_html__( 'Link', 'melokids' ),
                        'param_name'  => 'image_link',
                        'description' => esc_html__( 'Enter link for image.', 'melokids' ),
                    ),
                ),
                'group'     => 'Clients'
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Layout type','melokids'),
                'param_name' => 'layout_type',
                'value'      =>  array(
                    esc_html__('Grid','melokids')     => 'grid',
                    esc_html__('Carousel','melokids') => 'carousel'
                ),
                'std'        => 'grid',
                'group'      => esc_html__('Layout Settings','melokids'),
            ),
        ),
        /* Grid settings */
        melokids_grid_settings(array(
            'group'      => esc_html__('Layout Settings','melokids'), 
            'param_name' => 'layout_type', 
            'value'      => 'grid'
            )
        ),
        /* Carousel Settings */
        melokids_owl_settings(array(
            'group'      => esc_html__('Layout Settings','melokids'), 
            'param_name' => 'layout_type', 
            'value'      => 'carousel'
            )
        )
    )
));

class WPBakeryShortCode_zkclients extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
        extract( $atts );
        wp_enqueue_style( 'animate-css');
        melokids_owl_call_settings($atts);
        return parent::content($atts, $content);
    }
}