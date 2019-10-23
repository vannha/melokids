<?php
vc_map(array(
    'name'        => 'MeloKids Processes',
    'base'        => 'zkprocess',
    'icon'        => 'zkel-icon-processes',
    'category'    => esc_html__('MeloKids', 'melokids'),
    'description' => esc_html__('Add your processes', 'melokids'),
    'params'      => array_merge(
        array(
            array(
                'type'       => 'img',
                'heading'    => esc_html__('Layout Template','melokids'),
                'param_name' => 'layout_template',
                'value'      =>  array(
                    '1' => get_template_directory_uri().'/assets/images/header/default.jpg',
                ),
                'std'   => '1',
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Content Align','melokids'),
                'param_name'    => 'content_align',
                'value'         => array(
                    'Default'       => 'text-default',
                    'Text Left'     => 'text-left',
                    'Text Right'    => 'text-right',
                    'Text Center'   => 'text-center',
                ),
                'std'           => 'text-center',
            ),
            array(
                'type'       => 'textfield',
                'heading'    => esc_html__('Element Class','melokids'),
                'param_name' => 'el_class',
                'description'=> esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.','melokids' ),
            ),
            array(
                'type'       => 'el_id',
                'heading'    => esc_html__('Element ID','melokids'),
                'param_name' => 'el_id',
                'settings'   => array(
                    'auto_generate' => true,
                ),
                'description'   => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'melokids' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
            ),
            array(
                'type'       => 'dropdown',
                'param_name' => 'layout_type',
                'heading'    => esc_html__( 'Layout Type', 'melokids' ),
                'value'      => array(
                    esc_html__( 'Grid', 'melokids' )     => 'grid',
                    esc_html__( 'Carousel', 'melokids' ) => 'carousel',
                ),
                'std'         => '',
                'admin_label' => true,
                'group'       => esc_html__('Layout Settings', 'melokids')
            )
        ),
        /* Grid Settings */
        melokids_grid_settings(array('group'=>esc_html__('Layout Settings','melokids'), 'param_name' => 'layout_type', 'value' => 'grid')),
        /* Carousel Settings */
        melokids_owl_settings(array('group'=>esc_html__('Layout Settings','melokids'), 'param_name' => 'layout_type', 'value' => 'carousel')),
        array(
            array(
                'type'       => 'param_group',
                'heading'    => esc_html__( 'Add your process', 'melokids' ),
                'param_name' => 'values',
                'value'      =>  urlencode( json_encode( array(
                    array(
                        'p_title' => esc_html__( 'Development', 'melokids' ),
                        'p_desc'  => esc_html__( 'Development', 'melokids' ),
                    ),
                    array(
                        'p_title' => esc_html__( 'Design', 'melokids' ),
                        'p_desc'  => esc_html__( 'Design', 'melokids' ),
                    ),
                    array(
                        'p_title' => esc_html__( 'Marketing', 'melokids' ),
                        'p_desc'  => esc_html__( 'Marketing', 'melokids' ),
                    ),
                    array(
                        'p_title' => esc_html__( 'Photography', 'melokids' ),
                        'p_desc'  => esc_html__( 'Photography', 'melokids' ),
                    )
                ) ) ),
                'group'      => esc_html__('Your Process','melokids'),
                'params'     => array_merge(
                    array(
                        array(
                            'type'        => 'textfield',
                            'heading'     => esc_html__( 'Title', 'melokids' ),
                            'param_name'  => 'p_title',
                            'admin_label' => true,
                        ),
                        array(
                            'type'        => 'textarea',
                            'heading'     => esc_html__( 'Description', 'melokids' ),
                            'param_name'  => 'p_desc',
                        ),
                        array(
                            'type'       => 'attach_image',
                            'heading'    => esc_html__('Image','melokids'),
                            'param_name' => 'p_image',
                        ),
                        array(
                            'type'       => 'dropdown',
                            'heading'    => esc_html__('Image Position','melokids'),
                            'param_name' => 'p_image_pos',
                            'value'      => array(
                                esc_html__( 'Top / Left', 'melokids' )    => 'top',
                                esc_html__( 'Bottom / Right', 'melokids' ) => 'bottom',
                                ),
                            'std'        => 'top',
                            'dependency'    => array(
                              'element'         => 'p_image',
                              'not_empty'       => true,
                            ),
                        ),
                        array(
                            'type'          => 'checkbox',
                            'param_name'    => 'add_icon',
                            'value'         => array(
                                esc_html__( 'Add Icon?', 'melokids' ) => 'true',
                            ),
                            'std'           => false,
                        ),
                    ),
                    melokids_icon_libs(),
                    melokids_icon_libs_icon(),
                    array(
                        array(
                            'type'       => 'vc_link',
                            'heading'    => esc_html__( 'Process Link', 'melokids' ),
                            'param_name' => 'icon_link'
                        )
                    )
                )
            )
        )
    )
));
class WPBakeryShortCode_zkprocess extends CmsShortCode
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