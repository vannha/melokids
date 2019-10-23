<?php
vc_map(
	array(
		'name' 			=> esc_html__('MeloKids Hover Box', 'melokids'),
	    'base' 			=> 'zkhoverbox',
	    'icon'			=> 'vc_icon-vc-hoverbox',
	    'category' 		=> esc_html__('MeloKids', 'melokids'),
	    'params' 		=> array_merge(
	    	array(
	    		array(
					'type'       => 'attach_image',
					'heading'    => esc_html__('Image Item','melokids'),
					'param_name' => 'img_id',
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Image Size','melokids'),
					'param_name' => 'img_size',
					'value'		 => '640x418'
		        ),
			    array(
					'type'       => 'el_id',
					'heading'    => esc_html__('Element ID','melokids'),
					'param_name' => 'el_id',
					'settings'   => array(
						'auto_generate' => false,
					),
					'description'	=> sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'melokids' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
				),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Element Class','melokids'),
					'param_name' => 'el_class',
					'value'      => '',
				),
				array(
					'type'       => 'img',
					'heading'    => esc_html__('Layout Mode','melokids'),
					'param_name' => 'layout_mode',
					'value'      =>  array(
						'1'      => get_template_directory_uri().'/vc_customs/layouts/fancy-img1.png',
					),
					'std'        => '1',
					'group'      => esc_html__('Template','melokids'),
			    ),
			    array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Title','melokids'),
					'param_name' => 'title',
					'value'      => 'Your Title',
					'holder'     => 'div',
					'group'		 => esc_html__('Default','melokids')
		        ),
		        array(
					'type'       => 'textarea',
					'heading'    => esc_html__('Description','melokids'),
					'param_name' => 'description',
					'value'      => 'Your Description',
					'group'		 => esc_html__('Default','melokids')
		        ),
		        array(
		            'type'          => 'animation_style',
		            'class'         => '',
		            'heading'       => esc_html__('Animation In','melokids'),
		            'param_name'    => 'static_in',
		            'settings' => array(
						'type' => array(
							'in',
							/*  
							'out',
							'other'
							*/
						),
					),
		            'std'           => 'zoomIn',
		            'edit_field_class' => 'vc_col-sm-6 vc_carousel_item',
		            'group' 		=> esc_html__('Default','melokids'),
		        ),
		        array(
		            'type'          => 'animation_style',
		            'class'         => '',
		            'heading'       => esc_html__('Animation Out','melokids'),
		            'param_name'    => 'static_out',
		            'settings' => array(
						'type' => array(
							'out',
						),
					),
		            'std'           => 'zoomOut',
		            'edit_field_class' => 'vc_col-sm-6 vc_carousel_item',
		            'group' 		=> esc_html__('Default','melokids'),
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Title','melokids'),
					'param_name' => 'hover_title',
					'value'      => 'Hover Title',
					'holder'     => 'div',
					'group'		 => esc_html__('Hover','melokids')
		        ),
		        array(
					'type'       => 'textarea',
					'heading'    => esc_html__('Description','melokids'),
					'param_name' => 'hover_description',
					'value'      => 'Hover Description',
					'group'		 => esc_html__('Hover','melokids')
		        ),
		        
		        array(
					'type'       => 'vc_link',
					'heading'    => esc_html__('Choose your link','melokids'),
					'param_name' => 'button_link',
					'group'		 => esc_html__('Hover','melokids')
			    ),
			    array(
		            'type'          => 'animation_style',
		            'class'         => '',
		            'heading'       => esc_html__('Animation In','melokids'),
		            'param_name'    => 'hover_in',
		            'settings' => array(
						'type' => array(
							'in',
							/*  
							'out',
							'other'
							*/
						),
					),
		            'std'           => 'zoomIn',
		            'edit_field_class' => 'vc_col-sm-6 vc_carousel_item',
		            'group' 		=> esc_html__('Hover','melokids'),
		        ),
		        array(
		            'type'          => 'animation_style',
		            'class'         => '',
		            'heading'       => esc_html__('Animation Out','melokids'),
		            'param_name'    => 'hover_out',
		            'settings' => array(
						'type' => array(
							'out',
						),
					),
		            'std'           => 'zoomOut',
		            'edit_field_class' => 'vc_col-sm-6 vc_carousel_item',
		            'group' 		=> esc_html__('Hover','melokids'),
		        ),
			)
		)
	)
);
class WPBakeryShortCode_zkhoverbox extends CmsShortCode{
	protected function content($atts, $content = null){
		$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
		wp_enqueue_style('animate-css');
		return parent::content($atts, $content);
	}
}