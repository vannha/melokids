<?php
if(!class_exists('EF4Framework') || !class_exists('VC_Manager')) return;

add_filter( 'vc_autocomplete_zkposts_special_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
add_filter( 'vc_autocomplete_zkposts_special_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

vc_map(array(
    'name'        => 'MeloKids Posts Special',
    'base'        => 'zkposts_special',
    'category'    => esc_html__('MeloKids', 'melokids'),
    'description' => esc_html__('Posts, pages or custom posts in grid', 'melokids'),
    'icon'        => 'icon-wpb-application-icon-large',
    'params'      => array_merge(
        array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__('Post Type','melokids'),
                'param_name'  => 'post_type',
                'value'       => melokids_get_post_types_for_vc(),
                'std'         => 'post',
                'description' => esc_html__('Choose post type you want to show', 'melokids')
            ),
            array(
                'type'       => 'autocomplete',
                'heading'    => esc_html__( 'Narrow data source', 'melokids' ),
                'param_name' => 'taxonomies',
                'settings'   => array(
                    'multiple'       => true,
                    'min_length'     => 2,
                    'groups'         => true,
                    'unique_values'  => true,
                    'display_inline' => true,
                    'delay'          => 500,
                    'auto_focus'     => true,
                ),
                'param_holder_class' => 'vc_not-for-custom',
                'description'        => esc_html__( 'Enter categories, tags or custom taxonomies.', 'melokids' ),
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_sticky',
                'value'         => array(
                    esc_html__('Show Sticky Post?','melokids') => 1,
                ),
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Sort By','melokids'),
                'param_name'    => 'sort_by',
                'value'         => array(
                    esc_html__('Recent', 'melokids')         => '',
                    esc_html__('Most Viewed', 'melokids')    => 'most_viewed',
                    esc_html__('Sticky Post', 'melokids')    => 'sticky_posts',
                    esc_html__('Most Commented', 'melokids') => 'most_comment',
                ),
                'std'           => '',
                'admin_label'   => true,
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Extra Class','melokids'),
                'param_name'    => 'el_class',
                'std'           => '',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'melokids'),
            ),
            array(
                'type'     => 'el_id',
                'settings' => array(
                    'auto_generate' => true,
                ),
                'heading'     => esc_html__( 'Element ID', 'melokids' ),
                'param_name'  => 'el_id',
                'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'melokids' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
            )
        ),
        /* Grid Settings */
        array(
        	array(
                'type'          => 'checkbox',
                'param_name'    => 'show_pagination',
                'value'         => array(
                    esc_html__('Show Pagination','melokids') => 1,
                ),
                'std'			=> 1,
                'group'         => esc_html__('Layout Settings','melokids')
            ),
        ),
        /* Hover Effect */
		array(
			array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Hover Effect','melokids'),
                'param_name'    => 'hover_effect',
                'value'         => array(
					esc_html__('Swing animation', 'melokids')            => 'swing',
					esc_html__('Slide animation', 'melokids')            => 'slide',
					esc_html__('Slide - Push animation', 'melokids') 	 => 'slide-push',
					esc_html__('Rotate animation', 'melokids')           => 'rotate',
					esc_html__('Flip animation', 'melokids')             => 'flip',
                ),
                'std'           => 'swing',
                'group'         => esc_html__('Hover Effect','melokids')
            ),
		)
    )
));
class WPBakeryShortCode_zkposts_special extends CmsShortCode{
    protected function content($atts, $content = null)
    {
        global $cms_carousel;
        $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
        extract( $atts );
        wp_enqueue_script( 'waypoints' );
        wp_enqueue_style( 'animate-css' );
        return parent::content($atts, $content);
    }
}