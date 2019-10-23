<?php
if(!class_exists('EF4Framework') || !class_exists('VC_Manager')) return;

add_filter( 'vc_autocomplete_zkfancyimg_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
add_filter( 'vc_autocomplete_zkfancyimg_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

vc_map(
	array(
		'name' 			=> esc_html__('MeloKids Fancy Image', 'melokids'),
	    'base' 			=> 'zkfancyimg',
	    'icon'			=> 'vc_icon-vc-hoverbox',
	    'category' 		=> esc_html__('MeloKids', 'melokids'),
	    'params' 		=> array_merge(
	    	array(
	    		array(
					'type'       => 'img',
					'heading'    => esc_html__('Layout Mode','melokids'),
					'param_name' => 'layout_mode',
					'value'      =>  array(
						'1'      => get_template_directory_uri().'/vc_customs/layouts/fancy-img1.png',
						'2'      => get_template_directory_uri().'/vc_customs/layouts/fancy-img2.png',
						//'3'      => get_template_directory_uri().'/vc_customs/layouts/fancy-img3.png',
						'4'      => get_template_directory_uri().'/vc_customs/layouts/fancy-img4.jpg',
						'5'      => get_template_directory_uri().'/vc_customs/layouts/fancy-img5.jpg',
						'6'      => get_template_directory_uri().'/vc_customs/layouts/fancy-img6.jpg',
						'7'      => get_template_directory_uri().'/vc_customs/layouts/fancy-img7.jpg',
						'8'      => get_template_directory_uri().'/vc_customs/layouts/fancy-img8.jpg',
					),
					'std'        => '1',
					'group'      => esc_html__('Template','melokids'),
			    ),
			    array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Element Class','melokids'),
					'param_name' => 'el_class',
					'value'      => '',
					'group'      => esc_html__('Template','melokids'),
				),
			    array(
					'type'       => 'el_id',
					'heading'    => esc_html__('Element ID','melokids'),
					'param_name' => 'el_id',
					'settings'   => array(
						'auto_generate' => false,
					),
					'description'	=> sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'melokids' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
					'group'      => esc_html__('Template','melokids'),
				),
			    array(
					'type'       => 'attach_image',
					'heading'    => esc_html__('Image Item','melokids'),
					'param_name' => 'img_id',
					'group'      => esc_html__('Content','melokids'),
		        ),
		        array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Image Size','melokids'),
					'description' => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by you). Alternatively enter size in pixels (Example: 200x100 (Width x Height)). Leave empty to use default size','melokids'),
					'param_name'  => 'img_size',
					'value'       => '',
					'group'       => esc_html__('Content','melokids')
		        ),
		    	array(
					'type'       => 'textarea',
					'heading'    => esc_html__('Title','melokids'),
					'param_name' => 'title',
					'value'      => '',
					'holder'     => 'div',
					'group'      => esc_html__('Content','melokids'),
		        ),
		        array(
					'type'       => 'attach_image',
					'heading'    => esc_html__('Title Image','melokids'),
					'description'=> esc_html__('If has title image, title text will hide','melokids'),
					'param_name' => 'title_img',
					'group'      => esc_html__('Content','melokids'),
					'dependency'  => array(
						'element' => 'layout_mode',
						'value'   => array('7'),
					),
		        ),
		        array(
					'type'       => 'textarea',
					'heading'    => esc_html__('Description','melokids'),
					'param_name' => 'description',
					'value'      => '',
					'group'      => esc_html__('Content','melokids'),
					'dependency'  => array(
						'element' => 'layout_mode',
						'value'   => array('1','2','7'),
					),
		        ),
		        array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Regular Price','melokids'),
					'param_name' => 'regular_price',
					'group'      => esc_html__('Content','melokids'),
					'edit_field_class' => 'vc_col-sm-6',
					'dependency' => array(
						'element' => 'layout_mode',
						'value'   => array('4','5'),
					),
		        ),
		       	array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Sales Price','melokids'),
					'param_name' => 'sale_price',
					'group'      => esc_html__('Content','melokids'),
					'edit_field_class' => 'vc_col-sm-6',
					'dependency' => array(
						'element' => 'layout_mode',
						'value'   => array('4','5'),
					),
		        ),
		        array(
					'type'       => 'vc_link',
					'heading'    => esc_html__('Choose your link','melokids'),
					'param_name' => 'button_link',
					'group'      => esc_html__('Content','melokids'),
					'dependency' => array(
						'element' => 'layout_mode',
						'value'   => array('1','2','3','4','5'),
					),
			    ),
			    array(
					'type'       => 'autocomplete',
					'heading'    => esc_html__('Choose your Brand','melokids'),
					'param_name' => 'taxonomies',
					'settings'   => array(
	                    'multiple'       => false,
	                    'min_length'     => 2,
	                    'groups'         => true,
	                    'unique_values'  => true,
	                    'display_inline' => true,
	                    'delay'          => 500,
	                    'auto_focus'     => true,
	                ),
	                'param_holder_class' => 'vc_not-for-custom',
					'group'      => esc_html__('Content','melokids'),
					'dependency' => array(
						'element' => 'layout_mode',
						'value'   => array('6','7','8'),
					),
			    ),
			)
		)
	)
);
class WPBakeryShortCode_zkfancyimg extends CmsShortCode{
	protected function content($atts, $content = null){
		$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
		wp_enqueue_style('animate-css');
		return parent::content($atts, $content);
	}
}