<?php
vc_map(array(
    'name' => 'MeloKids Testimonial',
    'base' => 'zktestimonial',
    'icon'  => 'zkel-icon-testimonial',
    'category' => esc_html__('MeloKids', 'melokids'),
    'description' => esc_html__('Add clients testimonial', 'melokids'),
    'params' => array_merge(
        array(
            
            array(
                'type' => 'img',
                'heading' => esc_html__('Layout Template','melokids'),
                'param_name' => 'layout_template',
                'value' =>  array(
                    '1' => get_template_directory_uri().'/vc_customs/layouts/testimonial1.png',
                ),
                'std' => '1',
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
                'edit_field_class' => 'vc_col-sm-6 vc_column',
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__( 'Color Mode', 'melokids' ),
                'param_name'    => 'color_mode',
                'value'         => array(
                    esc_html__('Default','melokids') => '',
                ),
                'std'           => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
            ),
            /*array(
                'type'          => 'colorpicker',
                'heading'       => esc_html__( 'Icon Quote Background Color', 'melokids' ),
                'description'   => esc_html__( 'Custom background color for icon quote', 'melokids' ),
                'param_name'    => 'quote_bg_color',
                'std'           => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
            ),
            array(
                'type'          => 'colorpicker',
                'heading'       => esc_html__( 'Icon Quote Color', 'melokids' ),
                'description'   => esc_html__( 'Custom color for icon quote', 'melokids' ),
                'param_name'    => 'quote_color',
                'std'           => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
            ),*/
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
            /* Testimonial Settings */
            array(
                'type'          => 'param_group',
                'heading'       => esc_html__( 'Add your testimonial', 'melokids' ),
                'param_name'    => 'values',
                'value'         => urlencode( json_encode( array(
                    array(
                        'author_name' => esc_html__( 'John Smith', 'melokids' ),
                    ),
                ) ) ),
                'params' => array(
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Author name', 'melokids' ),
                        'param_name'    => 'author_name',
                        'admin_label'   => true,
                        'value'         => 'John Smith',
                    ),
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Author Position', 'melokids' ),
                        'param_name'    => 'author_position',
                        'placeholder'   => esc_html__('Project Manager','melokids'),
                        'value'         => ''
                    ),
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Author URL', 'melokids' ),
                        'param_name'    => 'author_url',
                        'value'         => '#'
                    ),
                    array(
                        'type'          => 'attach_image',
                        'heading'       => esc_html__( 'Author Image', 'melokids' ),
                        'param_name'    => 'author_avatar',
                        'value'         => ''
                    ),
                    array(
                        'type'          => 'attach_image',
                        'heading'       => esc_html__( 'Author signature image', 'melokids' ),
                        'param_name'    => 'author_signature_img',
                        'value'         => '',
                        'dependency'  => array(
                            'element' => 'layout_mode', 
                            'value'   => '3',
                        ),
                    ),
                    array(
                        'type'          => 'textarea',
                        'heading'       => esc_html__( 'Testimonial text', 'melokids' ),
                        'description'   => esc_html__('Press double ENTER to get line-break','melokids'),
                        'param_name'    => 'text',
                        'value'         => esc_html__('Donec euismod sem ac urna finibus, sit amet efficitur erat tem pus. Ut dapibus dictum turpis, vel faucibus erat posuere vitae icitur erat tem puna','melokids')
                    ),
                ),
                'group' => esc_html__('Testimonial Item','melokids')
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Layout Type','melokids'),
                'param_name' => 'layout_type',
                'value'      =>  array(
                    esc_html__('Grid','melokids')     => 'grid',
                    esc_html__('Carousel','melokids') => 'carousel'
                ),
                'std'        => 'grid',
                'group'      => esc_html__('Layout Settings','melokids'),
                'admin_label'=> true
            )
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

class WPBakeryShortCode_zktestimonial extends CmsShortCode
{
    protected function content($atts, $content = null){
        $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
        extract( $atts );
        wp_enqueue_style( 'animate-css');
        melokids_owl_call_settings($atts);
        return parent::content($atts, $content);
    }
}