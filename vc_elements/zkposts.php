<?php
add_filter( 'vc_autocomplete_zkposts_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
add_filter( 'vc_autocomplete_zkposts_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

vc_map(array(
    'name'        => 'MeloKids Posts',
    'base'        => 'zkposts',
    'category'    => esc_html__('MeloKids', 'melokids'),
    'description' => esc_html__('Add your posts', 'melokids'),
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
                'type'          => 'textfield',
                'heading'       => esc_html__('Post per page','melokids'),
                'param_name'    => 'posts_per_page',
                'value'         => '10',
                'description'   => esc_html__('Number of item to show', 'melokids'),
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
                'type'          => 'dropdown',
                'heading'       => esc_html__('Content Alignment','melokids'),
                'param_name'    => 'content_align',
                'value'         => array(
                    esc_html__('Default', 'melokids') => '',
                    esc_html__('Left', 'melokids')    => 'text-left',
                    esc_html__('Right', 'melokids')   => 'text-right',
                    esc_html__('Center', 'melokids')  => 'text-center',
                ),
                'std'           => '',
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
            ),
            /* Layout Settings */
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Layout Type','melokids'),
                'param_name'    => 'layout_type',
                'value'         => array(
                    esc_html__('Grid', 'melokids')     => 'grid',
                    esc_html__('Carousel', 'melokids') => 'carousel',
                    esc_html__('Masonry', 'melokids')  => 'masonry',
                ),
                'std'           => 'grid',
                'admin_label'   => true,
                'group'         => esc_html__('Layout Settings','melokids')
            ),
            /* Item Settings */
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_image',
                'value'         => array(
                    esc_html__('Show image','melokids') => 1
                ),
                'std'   => '1',
                'group'         => esc_html__('Item Settings','melokids')
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Thumbnail Size','melokids'),
                'param_name'    => 'thumbnail_size',
                'value'         => melokids_thumbnail_sizes(),
                'std'           => 'medium',
                'dependency'    => array(
                    'element'   => 'show_image',
                    'value'     => '1',
                ),
                'group'         => esc_html__('Item Settings','melokids')
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Custom Thumbnail size','melokids'),
                'description'   => esc_html__('Alternatively enter size in pixels (Example: 200x100 (Width x Height)). You can enter multi image size separate by comma (,).','melokids'),
                'param_name'    => 'thumbnail_size_custom',
                'value'         => '',
                'dependency'    => array(
                    'element'   => 'thumbnail_size',
                    'value'     => 'custom',
                ),
                'group'         => esc_html__('Item Settings','melokids')
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_author',
                'value'         => array(
                    esc_html__('Show Author','melokids') => 1,
                ),
                'group'         => esc_html__('Item Settings','melokids')
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_date',
                'value'         => array(
                    esc_html__('Show Date','melokids') => 1,
                ),
                'std'           => 1,
                'group'         => esc_html__('Item Settings','melokids')
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_cat',
                'value'         => array(
                    esc_html__('Show Category','melokids') => 1,
                ),
                'group'         => esc_html__('Item Settings','melokids')
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_comment',
                'value'         => array(
                    esc_html__('Show Comment','melokids') => 1,
                ),
                'group'         => esc_html__('Item Settings','melokids')
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_view',
                'value'         => array(
                    esc_html__('Show View','melokids') => 1,
                ),
                'group'         => esc_html__('Item Settings','melokids')
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_like',
                'value'         => array(
                    esc_html__('Show Like','melokids') => 1,
                ),
                'group'         => esc_html__('Item Settings','melokids')
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_share',
                'value'         => array(
                    esc_html__('Show Share','melokids') => 1,
                ),
                'group'         => esc_html__('Item Settings','melokids')
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_desc',
                'value'         => array(
                    esc_html__('Show Description','melokids') => 1,
                ),
                'std'           => 1,
                'group'         => esc_html__('Item Settings','melokids')
            ),
            array(
                'type'          => 'textfield',
                'param_name'    => 'excerpt_length',
                'value'         => '55',
                'dependency'    => array(
                    'element'   => 'show_desc',
                    'value'     => '1',
                ),
                'description'   => esc_html__('Enter the number of word you want to show','melokids'),
                'group'         => esc_html__('Item Settings','melokids')
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_tag',
                'value'         => array(
                    esc_html__('Show Tags','melokids') => 1,
                ),
                'group'         => esc_html__('Item Settings','melokids')
            ),
            array(
                'type'          => 'checkbox',
                'param_name'    => 'show_readmore',
                'value'         => array(
                    esc_html__('Show Readmore','melokids') => 1,
                ),
                'std'           => 1,
                'group'         => esc_html__('Item Settings','melokids')
            ),
        ),
        /* Grid Settings */
        melokids_grid_settings(array(
            'group'      => esc_html__('Layout Settings','melokids'), 
            'param_name' => 'layout_type', 
            'value'      => 'grid',
            )
        ),
        /* Carousel Settings */
        melokids_owl_settings(array(
            'group'      => esc_html__('Layout Settings','melokids'), 
            'param_name' => 'layout_type', 
            'value'      => 'carousel',
            )
        ),
        /* Masonry Settings */
        array(
            array(
                'type'       => 'img',
                'heading'    => esc_html__('Masonry Template','melokids'),
                'param_name' => 'masonry_template',
                'value'      =>  array(
                    '1' => get_template_directory_uri().'/assets/images/header/default.jpg',
                ),
                'std'        => '1',
                'dependency'    => array(
                    'element'   => 'layout_type',
                    'value'     => 'masonry',
                ),
                'group'         => esc_html__('Layout Settings','melokids')
            ),
            array(
                'type'          => 'textfield',
                'param_name'    => 'masonry_size',
                'value'         => '',
                'dependency'    => array(
                    'element'   => 'layout_type',
                    'value'     => 'masonry',
                ),
                'heading'       => esc_html__('Masonry Image Size','melokids'),
                'description'   => esc_html__('Alternatively enter size in pixels (Example: 200x100 (Width x Height)). You can enter multi item size separate by comma (,).','melokids'),
                'group'         => esc_html__('Layout Settings','melokids')
            ),
            array(
                'type'          => 'textfield',
                'param_name'    => 'masonry_gutter',
                'value'         => '30',
                'dependency'    => array(
                    'element'   => 'layout_type',
                    'value'     => 'masonry',
                ),
                'heading'       => esc_html__('Space between each item','melokids'),
                'description'   => esc_html__('Please enter numeric only!','melokids'),
                'group'         => esc_html__('Layout Settings','melokids')
            ),
        )
    )
));
class WPBakeryShortCode_zkposts extends CmsShortCode{
    protected function content($atts, $content = null)
    {
        global $cms_carousel;
        $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
        extract( $atts );
        wp_enqueue_style( 'animate-css');
        melokids_owl_call_settings($atts);
        melokids_masonry_call_settings($atts);
        return parent::content($atts, $content);
    }
}