<?php

if(!function_exists('melokids_user_wishlist')){
	function melokids_user_wishlist(){
		if(!class_exists('WPcleverWoosw')) return array();
		return array_merge(
			array(
	    		array(
	                'type'          => 'checkbox',
	                'param_name'    => 'show_wishlist',
	                'heading'       => esc_html__( 'Show Wishlist?', 'melokids' ),
	                'std'           => 'true',
	                'group'         => esc_html__('Wishlist','melokids')
	            ),
		    	array(
		            'type' 			=> 'textfield',
		            'heading' 		=> esc_html__('Title','melokids'),
		            'param_name' 	=> 'title_wishlist',
		            'value' 		=> esc_html__('Wishlist', 'melokids'),
		            'dependency'	=> array(
		            	'element' => 'show_wishlist',
		            	'value'	  => 'true'
		            ),
		            'group' 		=> esc_html__('Wishlist', 'melokids'),
		        ),
		        array(
		            'type' 			=> 'dropdown',
		            'heading' 		=> esc_html__('Wishlist Page','melokids'),
		            'param_name' 	=> 'wishlist_page',
		            'value' 		=> melokids_list_page_vc(),
		            'std'			=> '',
		            'dependency'	=> array(
		            	'element' => 'show_wishlist',
		            	'value'	  => 'true'
		            ),
		            'group' 		=> esc_html__('Wishlist', 'melokids'),
		        ),
	        	array(
	                'type'          => 'checkbox',
	                'param_name'    => 'add_icon2',
	                'heading'       => esc_html__( 'Add Icon?', 'melokids' ),
	                'std'           => 'false',
	                'dependency'	=> array(
		            	'element' => 'show_wishlist',
		            	'value'	  => 'true'
		            ),
	                'group'         => esc_html__('Wishlist','melokids')
	            )
	        ),
	        melokids_icon_libs(array('group' => esc_html__('Wishlist','melokids'),'field_prefix' => 'i2_', 'dependency' => 'add_icon2')),
        	melokids_icon_libs_icon(array('group' => esc_html__('Wishlist','melokids'), 'field_prefix' => 'i2_'))
		);	
	}
}

if(!function_exists('melokids_user_wc_cart')){
	function melokids_user_wc_cart(){
		if(!class_exists('WooCommerce')) return array();
		return array_merge(
			array(
	    		array(
	                'type'          => 'checkbox',
	                'param_name'    => 'show_cart',
	                'heading'       => esc_html__( 'Show Cart?', 'melokids' ),
	                'std'           => 'true',
	                'group'         => esc_html__('Cart','melokids')
	            ),
		    	array(
		            'type' 			=> 'textfield',
		            'heading' 		=> esc_html__('Title','melokids'),
		            'param_name' 	=> 'title_cart',
		            'value' 		=> esc_html__('Cart', 'melokids'),
		            'dependency'	=> array(
		            	'element' => 'show_cart',
		            	'value'	  => 'true'
		            ),
		            'group' 		=> esc_html__('Cart', 'melokids'),
		        ),
	        	array(
	                'type'          => 'checkbox',
	                'param_name'    => 'add_icon4',
	                'heading'       => esc_html__( 'Add Icon?', 'melokids' ),
	                'std'           => 'false',
	                'dependency'	=> array(
		            	'element' => 'show_cart',
		            	'value'	  => 'true'
		            ),
	                'group'         => esc_html__('Cart','melokids')
	            )
	        ),
	        melokids_icon_libs(array('group' => esc_html__('Cart','melokids'),'field_prefix' => 'i4_', 'dependency' => 'add_icon4')),
        	melokids_icon_libs_icon(array('group' => esc_html__('Cart','melokids'), 'field_prefix' => 'i4_'))
        );	
	}
}

vc_map(
	array(
		'name' 			=> esc_html__('MeloKids User Tools', 'melokids'),
	    'base' 			=> 'zkusertools',
	    'icon'			=> '',
	    'category' 		=> esc_html__('MeloKids', 'melokids'),
	    'description' 	=> esc_html__('Show My account, My wishlist, Search, Shopping Cart', 'melokids'),
	    'params' 		=> array_merge(
	    	/* General */
	    	array(
	    		array(
					'type'       => 'img',
					'heading'    => esc_html__('Layout Template','melokids'),
					'param_name' => 'layout_template',
					'value'      =>  array(
						'1'      => get_template_directory_uri().'/vc_customs/layouts/usertools1.png',
						'2'      => get_template_directory_uri().'/vc_customs/layouts/usertools2.png',
					),
					'std' 		 => '1'
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__('Content Align','melokids'),
					'param_name' => 'content_align',
					'value'      =>  array(
						esc_html__('Default','melokids') => '',
						esc_html__('Left','melokids')    => 'left',
						esc_html__('Right','melokids')   => 'end',
						esc_html__('Center','melokids')  => 'center',
						esc_html__('Justify','melokids') => 'between',
					),
					'std' 		 => '',
					'dependency'	=> array(
		            	'element' => 'layout_template',
		            	'value'	  => '1'
		            ),
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__('Color Mode','melokids'),
					'param_name' => 'color_mode',
					'value'      =>  array(
						esc_html__('Default','melokids') => '',
						esc_html__('White','melokids')   => 'color-white',
						esc_html__('Grey','melokids')    => 'color-grey',
					),
					'std' 		 => ''
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__('Row Gutters','melokids'),
					'param_name' => 'gutters',
					'value'      =>  melokids_vc_gutters_list(),
					'std' 		 => ''
				),
	    		array(
					'type'       => 'el_id',
					'heading'    => esc_html__('Element ID','melokids'),
					'param_name' => 'el_id',
					'settings'   => array(
						'auto_generate' => false,
					),
					'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'melokids' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
				),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Element Class','melokids'),
					'param_name' => 'el_class',
					'value'      => '',
				)
	    	),
	    	/* My Account */
	    	array(
	    		array(
	                'type'          => 'checkbox',
	                'param_name'    => 'show_account',
	                'heading'       => esc_html__( 'Show My Account?', 'melokids' ),
	                'std'           => 'true',
	                'group'         => esc_html__('My Account','melokids')
	            ),
		    	array(
		            'type' 			=> 'textfield',
		            'heading' 		=> esc_html__('Title','melokids'),
		            'param_name' 	=> 'title_myaccount',
		            'value' 		=> esc_html__('My Account', 'melokids'),
		            'dependency'	=> array(
		            	'element' => 'show_account',
		            	'value'	  => 'true'
		            ),
		            'group' 		=> esc_html__('My Account', 'melokids'),
		        ),
		        array(
		            'type' 			=> 'dropdown',
		            'heading' 		=> esc_html__('Account Page','melokids'),
		            'param_name' 	=> 'account_page',
		            'value' 		=> melokids_list_page_vc(),
		            'std'			=> '',
		            'dependency'	=> array(
		            	'element' => 'show_account',
		            	'value'	  => 'true'
		            ),
		            'group' 		=> esc_html__('My Account', 'melokids'),
		        ),
	        	array(
	                'type'          => 'checkbox',
	                'param_name'    => 'add_icon1',
	                'heading'       => esc_html__( 'Add Icon?', 'melokids' ),
	                'std'           => 'false',
	                'dependency'	=> array(
		            	'element' => 'show_account',
		            	'value'	  => 'true'
		            ),
	                'group'         => esc_html__('My Account','melokids')
	            )
	        ),
	        melokids_icon_libs(array('group' => esc_html__('My Account','melokids'),'field_prefix' => 'i1_', 'dependency' => 'add_icon1')),
        	melokids_icon_libs_icon(array('group' => esc_html__('My Account','melokids'), 'field_prefix' => 'i1_')),

        	/* Wishlist */
	    	melokids_user_wishlist(),
        	/* Search */
	    	array(
	    		array(
	                'type'          => 'checkbox',
	                'param_name'    => 'show_search',
	                'heading'       => esc_html__( 'Show Search?', 'melokids' ),
	                'std'           => 'true',
	                'group'         => esc_html__('Search','melokids')
	            ),
		    	array(
		            'type' 			=> 'textfield',
		            'heading' 		=> esc_html__('Title','melokids'),
		            'param_name' 	=> 'title_search',
		            'value' 		=> esc_html__('Search', 'melokids'),
		            'dependency'	=> array(
		            	'element' => 'show_search',
		            	'value'	  => 'true'
		            ),
		            'group' 		=> esc_html__('Search', 'melokids'),
		        ),
	        	array(
	                'type'          => 'checkbox',
	                'param_name'    => 'add_icon3',
	                'heading'       => esc_html__( 'Add Icon?', 'melokids' ),
	                'std'           => 'false',
	                'dependency'	=> array(
		            	'element' => 'show_search',
		            	'value'	  => 'true'
		            ),
	                'group'         => esc_html__('Search','melokids')
	            )
	        ),
	        melokids_icon_libs(array('group' => esc_html__('Search','melokids'),'field_prefix' => 'i3_', 'dependency' => 'add_icon3')),
        	melokids_icon_libs_icon(array('group' => esc_html__('Search','melokids'), 'field_prefix' => 'i3_')),

        	/* Cart */
	    	melokids_user_wc_cart(),

	        array(
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
class WPBakeryShortCode_zkusertools extends CmsShortCode{
	protected function content($atts, $content = null){
		$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    	extract( $atts );

    	if(isset($add_icon1) && 'true' === $add_icon1) vc_icon_element_fonts_enqueue( $i1_type );
    	if(isset($add_icon2) && 'true' === $add_icon2) vc_icon_element_fonts_enqueue( $i2_type );
    	if(isset($add_icon3) && 'true' === $add_icon3) vc_icon_element_fonts_enqueue( $i3_type );
    	if(isset($add_icon4) && 'true' === $add_icon4) vc_icon_element_fonts_enqueue( $i4_type );
			
		return parent::content($atts, $content);
	}
}