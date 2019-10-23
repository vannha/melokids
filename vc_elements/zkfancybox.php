<?php
vc_map(
	array(
		'name' 			=> esc_html__('MeloKids Fancy Box', 'melokids'),
	    'base' 			=> 'zkfancybox',
	    'icon'			=> 'vc_icon-vc-hoverbox',
	    'category' 		=> esc_html__('MeloKids', 'melokids'),
	    'params' 		=> array_merge(
	    	array(
		    	array(
		            'type' 			=> 'textfield',
		            'heading' 		=> esc_html__('Title','melokids'),
		            'param_name' 	=> 'title',
		            'value' 		=> '',
		            'description' 	=> esc_html__('Title Of Fancy Icon Box','melokids'),
		            'group' 		=> esc_html__('General', 'melokids'),
		            'holder'		=> 'div'
		        ),
		        array(
		            'type' 			=> 'colorpicker',
		            'heading' 		=> esc_html__('Title Color','melokids'),
		            'param_name' 	=> 'title_color',
		            'value' 		=> '',
		            'description' 	=> esc_html__('Custom Title Color','melokids'),
		            'group' 		=> esc_html__('General', 'melokids'),
		            'dependency'  => array(
					  'element'   	=> 'title',
					  'not_empty'   => true,
					),
		        ),
		        array(
		            'type' 			=> 'textarea',
		            'heading' 		=> esc_html__('Description','melokids'),
		            'param_name' 	=> 'description',
		            'value' 		=> '',
		            'description' 	=> esc_html__('Description Of Fancy Icon Box','melokids'),
		            'group' 		=> esc_html__('General', 'melokids')
		        ),
		        array(
		            'type' 			=> 'dropdown',
		            'heading' 		=> esc_html__('Content Align','melokids'),
		            'param_name' 	=> 'content_align',
		            'value' 		=> array(
		            	'Default' 	=> '',
		            	'Left' 		=> 'text-left',
		            	'Right' 	=> 'text-right',
		            	'Center' 	=> 'text-center'
		            ),
		            'std'			=> '',
		            'group' 		=> esc_html__('General', 'melokids')
		        ),
		        array(
		            'type' => 'vc_link',
		            'heading' => esc_html__('Choose your link','melokids'),
		            'param_name' => 'button_link',
		            'value' => '',
		            'group' => esc_html__('General','melokids'),
			    ),
			),
	        /* Start Items */
	        /* Start Icon */
	        array(
	        	array(
	                'type'          => 'checkbox',
	                'param_name'    => 'add_icon',
	                'heading'       => esc_html__( 'Add Icon?', 'melokids' ),
	                'std'           => 'false',
	                'group'         => esc_html__('Icon Settings','melokids')
	            )
	        ),
	        melokids_icon_libs(array('group' => esc_html__('Icon Settings','melokids'))),
        	melokids_icon_libs_icon(array('group' => esc_html__('Icon Settings','melokids'))),
	        array(
	        	array(
		            'type'          => 'textfield',
		            'param_name'    => 'i_size',
		            'heading'       => esc_html__( 'Icon Size', 'melokids' ),
		            'value'         => '',
		            'description'   => esc_html__( 'Enter your icon size. Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'melokids' ),
		            'group' 		=> esc_html__('Icon Settings','melokids'),
		            'dependency'	=> array(
				        'element' => 'add_icon',
				        'value' => 'true',
				    )
		        ),
		        array(
		            'type'          => 'dropdown',
		            'param_name'    => 'i_shape',
		            'heading'       => esc_html__( 'Icon Shape', 'melokids' ),
		            'value'         => array(
		            		esc_html__('Default','melokids')	=> '',
		            		esc_html__('Square','melokids')	=> 'square',
		            		esc_html__('Rounded','melokids')	=> 'rounded',
		            		esc_html__('Circle','melokids')	=> 'circle',
		            	),
		            'std'           => '',
		            'description'   => esc_html__( 'Choose a shape for icon', 'melokids' ),
		            'group' 		=> esc_html__('Icon Settings','melokids'),
		            'dependency'	=> array(
				        'element' => 'add_icon',
				        'value' => 'true',
				    )
		        ),
		        array(
		            'type'          => 'textfield',
		            'param_name'    => 'i_font_size',
		            'heading'       => esc_html__( 'Icon Font Size', 'melokids' ),
		            'value'         => '',
		            'description'   => esc_html__( 'Enter your icon font size, in PX. Ex: 40px', 'melokids' ),
		            'group' 		=> esc_html__('Icon Settings','melokids'),
		            'dependency'	=> array(
				        'element' => 'add_icon',
				        'value' => 'true',
				    )	
		        ),
		        array(
		            'type'          => 'colorpicker',
		            'param_name'    => 'i_color',
		            'heading'       => esc_html__( 'Icon Text Color', 'melokids' ),
		            'value'         => '',
		            'description'   => esc_html__( 'Choose icon text color.', 'melokids' ),
		            'group' 		=> esc_html__('Icon Settings','melokids'),
		            'dependency'	=> array(
				        'element' => 'add_icon',
				        'value' => 'true',
				    )
		        ),
		        array(
		            'type'          => 'colorpicker',
		            'param_name'    => 'i_bg',
		            'heading'       => esc_html__( 'Icon Background Color', 'melokids' ),
		            'std'           => '',
		            'description'   => esc_html__( 'Choose background color. Default is Accent Color added in theme', 'melokids' ),
		            'group' 		=> esc_html__('Icon Settings','melokids'),
		            'dependency'	=> array(
				        'element' => 'add_icon',
				        'value' => 'true',
				    )
		        ),
		        array(
		            'type'          => 'animation_style',
		            'class'         => '',
		            'heading'       => esc_html__('Animation In','melokids'),
		            'param_name'    => 'animation_in',
		            'settings' => array(
						'type' => array(
							/*'in',
							  'out',
							*/
							'other',
						),
					),
		            'std'           => 'wobble',
		            'edit_field_class' => 'vc_col-sm-6 vc_carousel_item',
		            'group' 		=> esc_html__('Icon Settings','melokids'),
		            'dependency'	=> array(
				        'element' => 'add_icon',
				        'value' => 'true',
				    )
		        ),
				/* End Icon */
				array(
					'type'       => 'attach_image',
					'heading'    => esc_html__('Image Item','melokids'),
					'param_name' => 'image',
					'group'      => esc_html__('Image Settings', 'melokids')
		        ),
		        array(
					'type'        => 'checkbox',
					'heading'     => esc_html__('Make image as icon','melokids'),
					'description' => esc_html__('If YES, the icon will removed and use image as icon!','melokids'),
					'param_name'  => 'image_icon',
					'default'     => false,
					'group'       => esc_html__('Image Settings', 'melokids'),
					'dependency'  => array(
					  'element'   	=> 'image',
					  'not_empty'   => true,
					),
		        ),
		        array(
					'type'          => 'dropdown',
					'class'         => '',
					'heading'       => esc_html__('Thumbnail Size','melokids'),
					'param_name'    => 'thumbnail_size',
					'value'         => melokids_thumbnail_sizes(),
					'std'           => 'medium',
					'group'         => esc_html__('Image Settings', 'melokids'),
					'dependency'    => array(
					  'element'   => 'image',
					  'not_empty'     => true,
					),
			    ),
				array(
					'type'          => 'textfield',
					'class'         => '',
					'heading'       => esc_html__('Custom Thumbnail Size','melokids'),
					'description'   => esc_html__('Alternatively enter size in pixels (Example: 200x100 (Width x Height)).','melokids'),
					'param_name'    => 'thumbnail_size_custom',
					'value'         => '',
					'group'         => esc_html__('Image Settings', 'melokids'),
					'dependency'    => array(
					  'element'   => 'thumbnail_size',
					  'value'     => 'custom',
					),
				),
		       
		        /* End Items */
		        array(
		            'type' 			=> 'dropdown',
		            'heading' 		=> esc_html__('Color Mode','melokids'),
		            'param_name' 	=> 'color_mode',
		            'value' 		=> array(
		            	esc_html__('Default','melokids') 	=> '',
		            ),
		            'std'			=> '',
		            'group' 		=> esc_html__('Template', 'melokids')
		        ),
			    array(
					'type'       => 'img',
					'heading'    => esc_html__('Layout Mode','melokids'),
					'param_name' => 'layout_mode',
					'value'      =>  array(
						'1'          => get_template_directory_uri().'/assets/images/header/default.jpg',
					),
					'std'        => '1',
					'group'      => esc_html__('Template','melokids'),
			    ),
		        array(
					'type'       => 'el_id',
					'heading'    => esc_html__('Element ID','melokids'),
					'param_name' => 'el_id',
					'settings' => array(
						'auto_generate' => false,
					),
					'description'	=> sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'melokids' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
					'group'      => esc_html__('Template', 'melokids')
				),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Element Class','melokids'),
					'param_name' => 'class',
					'value'      => '',
					'group'      => esc_html__('Template', 'melokids')
				),
				array(
					"type"       => "css_editor",
					"heading"    => '',
					"param_name" => "css",
					"value"      => "",
					"group"      => esc_html__("Design Options",'melokids'),
				) 
			)
		)
	)
);
class WPBakeryShortCode_zkfancybox extends CmsShortCode{
	protected function content($atts, $content = null){
		$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    	extract( $atts );
    	if($add_icon){
			switch ($i_type) {
				default:
					vc_icon_element_fonts_enqueue( $i_type );
					break;
			}
		}
		return parent::content($atts, $content);
	}
}