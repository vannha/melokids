<?php
vc_map(array(
    'name'          => 'MeloKids Button',
    'base'          => 'zkbutton',
    'category'      => esc_html__('MeloKids', 'melokids'),
    'description'   => esc_html__('Theme button style', 'melokids'),
    'icon'         => 'icon-wpb-ui-button',
    'params'        => array_merge(
        array(
            array(
                'type'          => 'textfield',
                'param_name'    => 'btn_text',
                'heading'       => esc_html__( 'Button Text', 'melokids' ),
                'value'         => esc_html__('Text on the button','melokids'),
                'admin_label'   => true
            ),
            array(
                'type'          => 'dropdown',
                'param_name'    => 'btn_type',
                'heading'       => esc_html__( 'Button Type', 'melokids' ),
                'value'         => melokids_btn_types(),
                'std'           => 'btn',
                'admin_label'   => true
            ),
            array(
                "type"          => "vc_link",
                "heading"       => esc_html__("Button link",'melokids'),
                "param_name"    => "button_link",
                "value"         => "",
            ),
            array(
                'type'          => 'dropdown',
                'param_name'    => 'btn_size',
                'heading'       => esc_html__( 'Button Size', 'melokids' ),
                'value'         => melokids_btn_size(),
                'std'           => '',
                'admin_label'   => true
            ),
            array(
                'type'          => 'dropdown',
                'param_name'    => 'btn_block',
                'heading'       => esc_html__( 'Button Display', 'melokids' ),
                'value'         => array(
                    esc_html__( 'Inline', 'melokids' )   => 'd-inline-block', 
                    esc_html__( 'Block', 'melokids' )    => 'd-block', 
                ),
                'std'           => 'd-block',
            ),
            array(
                'type'          => 'dropdown',
                'param_name'    => 'btn_width',
                'heading'       => esc_html__( 'Button Width', 'melokids' ),
                'value'         => array(
                    esc_html__( 'Default', 'melokids' )   => 'd-inline-block', 
                    esc_html__( 'Full', 'melokids' )      => 'd-block', 
                ),
                'std'           => 'd-inline-block',
                'dependency'    => array(
                    'element'   => 'btn_block',
                    'value'     => 'd-block',
                ),
            ),
            array(
                'type'          => 'dropdown',
                'param_name'    => 'btn_align',
                'heading'       => esc_html__( 'Button Align', 'melokids' ),
                'value'         => array(
                    esc_html__( 'Default', 'melokids' )  => '',
                    esc_html__( 'Left', 'melokids' )     => 'text-left', 
                    esc_html__( 'Right', 'melokids' )    => 'text-right',
                    esc_html__( 'Center', 'melokids' )   => 'text-center',
                ),
                'std'           => '',
                'dependency'    => array(
                    'element'   => 'btn_width',
                    'value'     => 'd-inline-block',
                ),
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'add_icon',
                'heading'       => esc_html__( 'Add Icon?', 'melokids' ),
                'std'           => false,
                'group'         => esc_html__('Icon','melokids')
            ),
            
        ),
        melokids_icon_libs(),
        melokids_icon_libs_icon(),
        array(
            array(
                'type'          => 'dropdown',
                'param_name'    => 'icon_position',
                'heading'       => esc_html__( 'Icon Position', 'melokids' ),
                'value'         => array(
                    esc_html__( 'Left', 'melokids' )     => 'left',
                    esc_html__( 'Right', 'melokids' )    => 'right',
                ),
                'std'           => 'right',
                'dependency'    => array(
                    'element'   => 'add_icon',
                    'value'     => 'true',
                ),
                'group'         => esc_html__('Icon','melokids')
            ),
            array(
                'type'          => 'dropdown',
                'param_name'    => 'btn_icon_style',
                'heading'       => esc_html__( 'Icon Style', 'melokids' ),
                'value'         => array(
                    esc_html__( 'Default', 'melokids' ) => 'default',
                ),
                'std'           => 'default',
                'dependency'    => array(
                    'element'   => 'add_icon',
                    'value'     => 'true',
                ),
                'group'         => esc_html__('Icon','melokids')
            ),
            array(
                'type'       => 'css_editor',
                'param_name' => 'css',
                'group'       => esc_html__('Designs', 'melokids')
            )
        )
    )
));

class WPBakeryShortCode_zkbutton extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}