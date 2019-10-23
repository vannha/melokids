<?php
vc_map(array(
    'name'        => 'MeloKids Instagram',
    'base'        => 'zkinstagram',
    'category'    => esc_html__('MeloKids', 'melokids'),
    'description' => esc_html__('Add your Instagram image', 'melokids'),
    'icon'        => 'zk-icon-instagram',
    'params'      => array_merge(
        array(
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Layout','melokids'),
                'param_name'    => 'layout_mode',
                'value'         => array(
                    esc_html__('Default', 'melokids')       => '0',
                ),
                'std'           => '0'
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Number Image','melokids'),
                'param_name'    => 'number',
                'std'           => '8',
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Number Columns','melokids'),
                'param_name'    => 'columns',
                'value'         => array('1','2','3','4','6','12','7','auto'),
                'std'           => '4'
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Columns Space','melokids'),
                'param_name'    => 'columns_space',
                'value'         => array('0','2','5','10','20','30'),
                'std'           => '2'
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Image Size','melokids'),
                'param_name'    => 'size',
                'value'         => array(
                    esc_html__('Thumbnail (150x150)', 'melokids')       => 'thumbnail',
                    esc_html__('Small (320x320)', 'melokids')           => 'small',
                    esc_html__('Large (640x640)', 'melokids')           => 'large',
                    esc_html__('Original (640x640)', 'melokids')        => 'original',
                ),
                'std'           => 'thumbnail',
                'description'   => esc_html__('Auto-detect means that the plugin automatically sets the image resolution based on the size of your feed.','melokids')
            ),
            array(
                'type'          => 'checkbox',
                'heading'       => esc_html__('Show Author','melokids'),
                'param_name'    => 'show_author',
                'std'           => 'true' 
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Author Text','melokids'),
                'param_name'    => 'author_text',
                'value'         => esc_html__('Follow Us Now', 'melokids'),
                'description'   => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'melokids'),
                'dependency'    => array(
                    'element'   => 'show_author',
                    'value'     => 'true',
                ),
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_like',
                'value'         => array(
                    esc_html__('Show like count?','melokids') => true
                ),
                'std'           => false,
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_comments',
                'value'         => array(
                    esc_html__('Show comment count?','melokids') => true
                ),
                'std'           => false,
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Open Link in?','melokids'),
                'param_name'    => 'target',
                'value'         => array(
                    esc_html__('Current window', 'melokids')       => '_self',
                    esc_html__('New Window ', 'melokids')      => '_blank',
                ),
                'std'           => '_self',
                'dependency'    => array(
                    'element'   => 'show_author',
                    'value'     => 'true',
                ),
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Extra Class','melokids'),
                'param_name'    => 'class',
                'value'         => '',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'melokids'),
            )
        )
    )
));
class WPBakeryShortCode_zkinstagram extends CmsShortCode{
    protected function content($atts, $content = null)
    {
        $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
        extract( $atts );
        return parent::content($atts, $content);
    }
}