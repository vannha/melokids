<?php
if(!class_exists('Newsletter')) return;
vc_map(array(
	'name'        => 'MeloKids Newsletter',
	'base'        => 'zknewsletter',
	'icon'        => 'zkel-icon-newsletter',
	'category'    => esc_html__('MeloKids', 'melokids'),
	'description' => esc_html__('Add Newsletter Form.', 'melokids'),
	'params'      => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Layout Mode', 'melokids' ),
			'description' => esc_html__( 'Choose Layout mode you want to show', 'melokids' ),
			'param_name'  => 'layout_mode',
			'value'       => array(
				esc_html__('Newsletter','melokids')         => 'default',
				esc_html__('Newsletter Minimal','melokids') => 'minimal',
			),
			'std'		  => 'minimal',
			'admin_label' => true,
    	),
    	array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Show lists as', 'melokids' ),
			'param_name'  => 'lists_layout',
			'value'       => array(
				esc_html__('Checkbox','melokids') => '',
				esc_html__('Dropdown','melokids') => 'dropdown'
			),
			'std'		  	=> '',
			'dependency'    => array(
				'element'   => 'layout_mode',
				'value'     => 'default',
			),
    	),
    	array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'First dropdown entry label', 'melokids' ),
			'param_name'  => 'lists_empty_label',
			'value'		  => '',
			'dependency'    => array(
				'element'   => 'lists_layout',
				'value'     => 'dropdown',
			),
    	),
    	array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Lists field label', 'melokids' ),
			'description' => esc_html__( 'Seperate by comma (,)', 'melokids' ),
			'value'		  => '',		
			'param_name'  => 'lists_field_label',
			'dependency'    => array(
				'element'   => 'layout_mode',
				'value'     => 'default',
			),
    	),
    	array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Button Text', 'melokids' ),
			'description' => esc_html__( 'Enter button text', 'melokids' ),
			'param_name'  => 'btn_text',
			'value'       => '',
			'std'		  => 'Subscribe',
			'dependency'    => array(
				'element'   => 'layout_mode',
				'value'     => 'minimal',
			),
    	),
    	array(
			'type'        => 'textfield',
			'heading'     => esc_html__('Extra Class','melokids'),
			'param_name'  => 'el_class',
			'value'       => '',
			'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'melokids'),
        ),
        array(
			'type'       => 'img',
			'heading'    => esc_html__('Layout Template','melokids'),
			'param_name' => 'layout_template',
			'value'      =>  array(
                'layout-1' => get_template_directory_uri().'/vc_customs/layouts/newsletter1.png',
                'layout-2' => get_template_directory_uri().'/vc_customs/layouts/newsletter2.png',
            ),
			'std'   => 'layout-1',
			'group' => esc_html__('Template','melokids')
        ),
    )
));

class WPBakeryShortCode_zknewsletter extends CmsShortCode{
}