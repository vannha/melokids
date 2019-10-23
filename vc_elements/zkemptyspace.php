<?php
vc_map(array(
    'name'        => 'MeloKids Empty Space',
    'base'        => 'zkemptyspace',
    'icon'        => 'icon-wpb-ui-empty_space',
    'category'    => esc_html__('MeloKids', 'melokids'),
    'description' => esc_html__('Blank space with custom height for each screen size', 'melokids'),
    'params'      => array(
        array(
            'type'       => 'param_group',
            'heading'    => esc_html__( 'Add Custom Screen Size', 'melokids' ),
            'param_name' => 'values',
            'value'      => urlencode( json_encode( array(
                array(
                    'screen_size' => '',
                ),
            ) ) ),
            'params' => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Add your screen size', 'melokids' ),
                    'param_name'  => 'screen_size',
                    'description' => esc_html__('Enter max-width of your screen size, ex: 1920px (Note: CSS measurement units allowed).','melokids'),
                    'admin_label' => true,
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Empty space height', 'melokids' ),
                    'param_name'  => 'height',
                    'description' => esc_html__('Enter empty space height (Note: CSS measurement units allowed).','melokids'),
                ),
            ),
        ),
    ),
));
class WPBakeryShortCode_zkemptyspace extends WPBakeryShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}