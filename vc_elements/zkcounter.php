<?php
vc_map(
	array(
		'name'     => esc_html__('MeloKids Counter', 'melokids'),
		'base'     => 'zkcounter',
		'icon'     => 'zkel-icon-counter',
		'category' => esc_html__('MeloKids', 'melokids'),
		'params'   => array_merge(
			array(
		        array(
					'type'       => 'dropdown',
					'heading'    => esc_html__('Content Align','melokids'),
					'param_name' => 'content_align',
					'value'      => array(
						esc_html__('Default','melokids')  => '',
						esc_html__('Left'  ,'melokids')   => 'text-left',
						esc_html__('Right' ,'melokids')   => 'text-right',
						esc_html__('Center' ,'melokids')  => 'text-center'
		            ),
		            'std'		 => 'text-center',
		            'group' 	 => esc_html__('Settings', 'melokids')
		        ),
		        array(
					'type'       => 'dropdown',
					'heading'    => esc_html__('Counter Type','melokids'),
					'param_name' => 'counter_type',
					'value'      => array(
						esc_html__('Zero','melokids')   => 'zero',
		            ),
		            'std'		 => 'zero',
		            'group' 	 => esc_html__('Settings', 'melokids')
		        ),
		        array(
					'type'       => 'dropdown',
					'heading'    => esc_html__('Select Number Cols','melokids'),
					'param_name' => 'counter_column',
					'value'      => array('1','2','3','4','5','6'),
		            'std'		 => 1,
		            'admin_label' => true,
		            'group' 	 => esc_html__('Settings', 'melokids')
		        ),
		        array(
					'type'       => 'dropdown',
					'heading'    => esc_html__('Color Mode','melokids'),
					'param_name' => 'color_mode',
					'value'      => array(					
						esc_html__('Default','melokids')  => '',
						esc_html__('White','melokids')    => 'white',
						esc_html__('Gradient','melokids') => 'gradient',
					),
		            'std'		 => '',
		            'admin_label' => true,
		            'group' 	 => esc_html__('Settings', 'melokids')
		        ),
		        array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Extra Class','melokids'),
					'param_name'  => 'class',
					'value'       => '',
					'group' 	 => esc_html__('Settings', 'melokids')
		        ),
		    ),
		    /* Counter 1 */
		    array(
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Title','melokids'),
					'param_name' => 'title1',
					'dependency' => array(
		            	'element'=>'counter_column',
		            	'value'	 =>array('1','2','3','4','5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 1', 'melokids')
		        ),
		        array(
					'type'       => 'textarea',
					'heading'    => esc_html__('Description','melokids'),
					'param_name' => 'desc1',
					'dependency' => array(
		            	'element'=>'counter_column',
		            	'value'	 =>array('1','2','3','4','5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 1', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Digit','melokids'),
					'param_name' => 'digit1',
					'value'      => '',
					'edit_field_class' => 'vc_col-sm-4',
		            'dependency' => array(
						'element' => 'counter_column',
						'value'	  =>array('1','2','3','4','5','6')
		            ),
					'group'      => esc_html__('Counter 1', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Prefix','melokids'),
					'param_name' => 'prefix1',
					'edit_field_class' => 'vc_col-sm-4',
					'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('1','2','3','4','5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 1', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Suffix','melokids'),
					'param_name' => 'suffix1',
					'edit_field_class' => 'vc_col-sm-4',
					'value'      => '',
					'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('1','2','3','4','5','6')
		            ),
					'group'      => esc_html__('Counter 1', 'melokids')
		        ),
		        array(
	                'type'          => 'checkbox',
	                'param_name'    => 'add_icon1',
	                'heading'       => esc_html__( 'Add Icon?', 'melokids' ),
	                'std'           => 'false',
	                'group'         => esc_html__('Counter 1','melokids')
	            ),
		        array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__('Icon Color','melokids'),
					'param_name' => 'icon1_color',
					'value'      => '',
		            'dependency' => array(
						'element' => 'add_icon1',
						'value'	  => 'true'
		            ),
					'group'      => esc_html__('Counter 1', 'melokids')
		        ), 
		    ),
		    melokids_icon_libs(array('group'=> esc_html__('Counter 1','melokids'),'field_prefix'=>'i1_', 'dependency' => 'add_icon1')),
			melokids_icon_libs_icon(array('group' => esc_html__('Counter 1','melokids'), 'field_prefix' => 'i1_')),
			/* Counter 2 */
		    array(
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Title','melokids'),
					'param_name' => 'title2',
					'dependency' => array(
		            	'element'=>'counter_column',
		            	'value'	 =>array('2','3','4','5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 2', 'melokids')
		        ),
		        array(
					'type'       => 'textarea',
					'heading'    => esc_html__('Description','melokids'),
					'param_name' => 'desc2',
					'dependency' => array(
		            	'element'=>'counter_column',
		            	'value'	 =>array('2','3','4','5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 2', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Digit','melokids'),
					'param_name' => 'digit2',
					'value'      => '',
					'edit_field_class' => 'vc_col-sm-4',
		            'dependency' => array(
						'element' => 'counter_column',
						'value'	  =>array('2','3','4','5','6')
		            ),
					'group'      => esc_html__('Counter 2', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Prefix','melokids'),
					'param_name' => 'prefix2',
					'edit_field_class' => 'vc_col-sm-4',
					'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('2','3','4','5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 2', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Suffix','melokids'),
					'param_name' => 'suffix2',
					'edit_field_class' => 'vc_col-sm-4',
					'value'      => '',
					'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('2','3','4','5','6')
		            ),
					'group'      => esc_html__('Counter 2', 'melokids')
		        ),
		        array(
	                'type'          => 'checkbox',
	                'param_name'    => 'add_icon2',
	                'heading'       => esc_html__( 'Add Icon?', 'melokids' ),
	                'std'           => 'false',
	                'dependency' => array(
						'element' => 'counter_column',
						'value'	  =>array('2','3','4','5','6')
		            ),
	                'group'         => esc_html__('Counter 2','melokids')
	            ),
		        array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__('Icon Color','melokids'),
					'param_name' => 'icon2_color',
					'value'      => '',
		            'dependency' => array(
						'element' => 'add_icon2',
						'value'	  => 'true'
		            ),
					'group'      => esc_html__('Counter 2', 'melokids')
		        ), 
		    ),
		    melokids_icon_libs(array('group'=> esc_html__('Counter 2','melokids'),'field_prefix'=>'i2_', 'dependency' => 'add_icon2')),
			melokids_icon_libs_icon(array('group' => esc_html__('Counter 2','melokids'), 'field_prefix' => 'i2_')),
			/* Counter 3 */
		    array(
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Title','melokids'),
					'param_name' => 'title3',
					'dependency' => array(
		            	'element'=>'counter_column',
		            	'value'	 =>array('3','4','5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 3', 'melokids')
		        ),
		        array(
					'type'       => 'textarea',
					'heading'    => esc_html__('Description','melokids'),
					'param_name' => 'desc3',
					'dependency' => array(
		            	'element'=>'counter_column',
		            	'value'	 =>array('3','4','5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 3', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Digit','melokids'),
					'param_name' => 'digit3',
					'value'      => '',
					'edit_field_class' => 'vc_col-sm-4',
		            'dependency' => array(
						'element' => 'counter_column',
						'value'	  =>array('3','4','5','6')
		            ),
					'group'      => esc_html__('Counter 3', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Prefix','melokids'),
					'param_name' => 'prefix3',
					'edit_field_class' => 'vc_col-sm-4',
					'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('3','4','5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 3', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Suffix','melokids'),
					'param_name' => 'suffix3',
					'edit_field_class' => 'vc_col-sm-4',
					'value'      => '',
					'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('3','4','5','6')
		            ),
					'group'      => esc_html__('Counter 3', 'melokids')
		        ),
		        array(
	                'type'          => 'checkbox',
	                'param_name'    => 'add_icon3',
	                'heading'       => esc_html__( 'Add Icon?', 'melokids' ),
	                'std'           => 'false',
	                'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('3','4','5','6')
		            ),
	                'group'         => esc_html__('Counter 3','melokids')
	            ),
		        array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__('Icon Color','melokids'),
					'param_name' => 'icon3_color',
					'value'      => '',
		            'dependency' => array(
						'element' => 'add_icon3',
						'value'	  => 'true'
		            ),
					'group'      => esc_html__('Counter 3', 'melokids')
		        ), 
		    ),
		    melokids_icon_libs(array('group'=> esc_html__('Counter 3','melokids'),'field_prefix'=>'i3_', 'dependency' => 'add_icon3')),
			melokids_icon_libs_icon(array('group' => esc_html__('Counter 3','melokids'), 'field_prefix' => 'i3_')),
			/* Counter 4 */
		    array(
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Title','melokids'),
					'param_name' => 'title4',
					'dependency' => array(
		            	'element'=>'counter_column',
		            	'value'	 =>array('4','5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 4', 'melokids')
		        ),
		        array(
					'type'       => 'textarea',
					'heading'    => esc_html__('Description','melokids'),
					'param_name' => 'desc4',
					'dependency' => array(
		            	'element'=>'counter_column',
		            	'value'	 =>array('4','5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 4', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Digit','melokids'),
					'param_name' => 'digit4',
					'value'      => '',
					'edit_field_class' => 'vc_col-sm-4',
		            'dependency' => array(
						'element' => 'counter_column',
						'value'	  =>array('4','5','6')
		            ),
					'group'      => esc_html__('Counter 4', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Prefix','melokids'),
					'param_name' => 'prefix4',
					'edit_field_class' => 'vc_col-sm-4',
					'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('4','5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 4', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Suffix','melokids'),
					'param_name' => 'suffix4',
					'edit_field_class' => 'vc_col-sm-4',
					'value'      => '',
					'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('4','5','6')
		            ),
					'group'      => esc_html__('Counter 4', 'melokids')
		        ),
		        array(
	                'type'          => 'checkbox',
	                'param_name'    => 'add_icon4',
	                'heading'       => esc_html__( 'Add Icon?', 'melokids' ),
	                'std'           => 'false',
	                'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('4','5','6')
		            ),
	                'group'         => esc_html__('Counter 4','melokids')
	            ),
		        array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__('Icon Color','melokids'),
					'param_name' => 'icon4_color',
					'value'      => '',
		            'dependency' => array(
						'element' => 'add_icon4',
						'value'	  => 'true'
		            ),
					'group'      => esc_html__('Counter 4', 'melokids')
		        ), 
		    ),
		    melokids_icon_libs(array('group'=> esc_html__('Counter 4','melokids'),'field_prefix'=>'i4_', 'dependency' => 'add_icon4')),
			melokids_icon_libs_icon(array('group' => esc_html__('Counter 4','melokids'), 'field_prefix' => 'i4_')),
			/* Counter 5 */
		    array(
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Title','melokids'),
					'param_name' => 'title5',
					'dependency' => array(
		            	'element'=>'counter_column',
		            	'value'	 =>array('5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 5', 'melokids')
		        ),
		        array(
					'type'       => 'textarea',
					'heading'    => esc_html__('Description','melokids'),
					'param_name' => 'desc5',
					'dependency' => array(
		            	'element'=>'counter_column',
		            	'value'	 =>array('5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 5', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Digit','melokids'),
					'param_name' => 'digit5',
					'value'      => '',
					'edit_field_class' => 'vc_col-sm-4',
		            'dependency' => array(
						'element' => 'counter_column',
						'value'	  =>array('5','6')
		            ),
					'group'      => esc_html__('Counter 5', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Prefix','melokids'),
					'param_name' => 'prefix5',
					'edit_field_class' => 'vc_col-sm-4',
					'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('5','6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 5', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Suffix','melokids'),
					'param_name' => 'suffix5',
					'edit_field_class' => 'vc_col-sm-4',
					'value'      => '',
					'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('5','6')
		            ),
					'group'      => esc_html__('Counter 5', 'melokids')
		        ),
		        array(
	                'type'          => 'checkbox',
	                'param_name'    => 'add_icon5',
	                'heading'       => esc_html__( 'Add Icon?', 'melokids' ),
	                'std'           => 'false',
	                'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('5','6')
		            ),
	                'group'         => esc_html__('Counter 5','melokids')
	            ),
		        array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__('Icon Color','melokids'),
					'param_name' => 'icon5_color',
					'value'      => '',
		            'dependency' => array(
						'element' => 'add_icon5',
						'value'	  => 'true'
		            ),
					'group'      => esc_html__('Counter 5', 'melokids')
		        ), 
		    ),
		    melokids_icon_libs(array('group'=> esc_html__('Counter 5','melokids'),'field_prefix'=>'i5_', 'dependency' => 'add_icon5')),
			melokids_icon_libs_icon(array('group' => esc_html__('Counter 5','melokids'), 'field_prefix' => 'i5_')),
			/* Counter 6 */
		    array(
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Title','melokids'),
					'param_name' => 'title6',
					'dependency' => array(
		            	'element'=>'counter_column',
		            	'value'	 =>array('6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 6', 'melokids')
		        ),
		        array(
					'type'       => 'textarea',
					'heading'    => esc_html__('Description','melokids'),
					'param_name' => 'desc6',
					'dependency' => array(
		            	'element'=>'counter_column',
		            	'value'	 =>array('6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 6', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Digit','melokids'),
					'param_name' => 'digit6',
					'value'      => '',
					'edit_field_class' => 'vc_col-sm-4',
		            'dependency' => array(
						'element' => 'counter_column',
						'value'	  =>array('6')
		            ),
					'group'      => esc_html__('Counter 6', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Prefix','melokids'),
					'param_name' => 'prefix6',
					'edit_field_class' => 'vc_col-sm-4',
					'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('6')
		            ),
					'value'       => '',
					'group'       => esc_html__('Counter 6', 'melokids')
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Suffix','melokids'),
					'param_name' => 'suffix6',
					'edit_field_class' => 'vc_col-sm-4',
					'value'      => '',
					'dependency' => array(
						'element' =>'counter_column',
						'value'	  =>array('6')
		            ),
					'group'      => esc_html__('Counter 6', 'melokids')
		        ),
		        array(
	                'type'          => 'checkbox',
	                'param_name'    => 'add_icon6',
	                'heading'       => esc_html__( 'Add Icon?', 'melokids' ),
	                'std'           => 'false',
	                'dependency' => array(
						'element' => 'counter_column',
						'value'	  =>array('6')
		            ),
	                'group'         => esc_html__('Counter 6','melokids')
	            ),
		        array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__('Icon Color','melokids'),
					'param_name' => 'icon6_color',
					'value'      => '',
		            'dependency' => array(
						'element' => 'add_icon6',
						'value'	  => 'true'
		            ),
					'group'      => esc_html__('Counter 6', 'melokids')
		        ), 
		    ),
		    melokids_icon_libs(array('group'=> esc_html__('Counter 6','melokids'),'field_prefix'=>'i6_', 'dependency' => 'add_icon6')),
			melokids_icon_libs_icon(array('group' => esc_html__('Counter 6','melokids'), 'field_prefix' => 'i6_'))
	    )
	)
);
class WPBakeryShortCode_zkcounter extends CmsShortCode{
	protected function content($atts, $content = null){
		$atts_extra = shortcode_atts(array(
			'content_align'  => 'text-center',
			'color_mode'	 => '',
			'counter_column' => '1',
			'class'          => '',
		), $atts);
		$atts = array_merge($atts_extra,$atts);
        $html_id = cmsHtmlID('cms-counter');
        $class = ($atts['class'])?$atts['class']:'';
        $atts['template'] = $atts['color_mode'] . ' '. $atts['content_align'] . ' '. $atts['class'];
        if($atts['counter_column'] !== '1') $atts['template'] .=' multiple';
        $atts['html_id'] = $html_id;

        wp_enqueue_script( 'waypoints' );
        wp_enqueue_script('zkcounter', get_template_directory_uri() . '/vc_elements/zkcounter.js', array('waypoints'), '1.0.0', true);

		return parent::content($atts, $content);
	}
}