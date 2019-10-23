<?php
vc_map(array(
    'name'          => 'MeloKids Team',
    'base'          => 'zkteam',
    'icon'          => 'zkel-icon-team',
    'category'      => esc_html__('MeloKids', 'melokids'),
    'description'   => esc_html__('Add your team member', 'melokids'),
    'params'        => array_merge(
        array(
            /* Template Settings */
            array(
                'type'       => 'img',
                'heading'    => esc_html__('Layout Template','melokids'),
                'param_name' => 'layout_template',
                'value'      =>  array(
                    '1' => get_template_directory_uri().'/assets/images/header/default.jpg',
                ),
                'std'   => '1',
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Content Align','melokids'),
                'param_name'    => 'content_align',
                'value'         => array(
                    'Default'       => '',
                    'Text Left'     => 'text-left',
                    'Text Right'    => 'text-right',
                    'Text Center'   => 'text-center',
                ),
                'std'           => '',
            ),
            array(
                'type'          => 'animation_style',
                'class'         => '',
                'heading'       => esc_html__('Overlay Animation In Style','melokids'),
                'param_name'    => 'animation_in',
                'std'           => 'zoomIn',
            ),
            array(
                'type'          => 'animation_style',
                'class'         => '',
                'heading'       => esc_html__('Overlay Animation Out Style','melokids'),
                'param_name'    => 'animation_out',
                'std'           => 'zoomOut',
            ),
            array(
                'type'        => 'el_id',
                'settings' => array(
                    'auto_generate' => true,
                ),
                'heading'     => esc_html__( 'Element ID', 'melokids' ),
                'param_name'  => 'el_id',
                'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'melokids' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
            ),
            array(
                'type'       => 'textfield',
                'heading'    => esc_html__('Extra Class','melokids'),
                'param_name' => 'el_class',
                'value'      => '',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'melokids'),
            ),
            /* Members Settings */
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Member image size','melokids'),
                'param_name'    => 'thumbnail_size',
                'value'         => melokids_thumbnail_sizes(),
                'std'           => 'custom',
                'group'         => esc_html__('Members','melokids'),
            ),
            array(
                'type'          => 'textfield',
                'heading'       => esc_html__('Custom member image size','melokids'),
                'description'   => esc_html__('Alternatively enter size in pixels (Example: 200x100 (Width x Height)).','melokids'),
                'param_name'    => 'thumbnail_size_custom',
                'value'         => '370',
                'group'         => esc_html__('Members','melokids'),
                'dependency'    => array(
                    'element'   => 'thumbnail_size',
                    'value'     => 'custom',
                ),
            ),
            array(
                'type'          => 'checkbox',
                'heading'       => esc_html__('Make Member image as Black & White','melokids'),
                'param_name'    => 'thumbnail_bw',
                'std'           => 'false',
                'group'         => esc_html__('Members', 'melokids')
            ),
            array(
                'type'          => 'param_group',
                'heading'       => esc_html__( 'Add Member', 'melokids' ),
                'param_name'    => 'values',
                'value'         => urlencode( json_encode( array(
                    array(
                        'image'   => '',
                        'name'    => 'John Doe',
                        'position'=> 'Director',
                        'slogan'  => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                        'social_values' => urlencode( json_encode( array(
                            array(
                                'social_icon' => 'fa fa-facebook',
                                'social_link' => 'title:Facebook||url:https%3A//www.facebook.com/ZookaStudio-303678886710953||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-twitter',
                                'social_link' => 'title:Twitter||url:https%3A//twitter.com/zookadotio||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-linkedin',
                                'social_link' => 'title:Linkedin||url:https%3A//www.linkedin.com/company/zooka-studio||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-youtube-play',
                                'social_link' => 'title:Youtube||url:https%3A//www.youtube.com/playlist?list=PLStisDW1uGOBC_17qkU0N2AFZj96PVEf7||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-skype',
                                'social_link' => 'title:Skype Chat||url:https%3A//skype.chinhjm||target:_blank',
                            )
                        ) ) )
                    ),
                    array(
                        'image'   => '',
                        'name'    => 'Christopher Sterling',
                        'position'=> 'Leader',
                        'slogan'  => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                        'social_values' => urlencode( json_encode( array(
                            array(
                                'social_icon' => 'fa fa-facebook',
                                'social_link' => 'title:Facebook||url:https%3A//www.facebook.com/ZookaStudio-303678886710953||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-twitter',
                                'social_link' => 'title:Twitter||url:https%3A//twitter.com/zookadotio||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-linkedin',
                                'social_link' => 'title:Linkedin||url:https%3A//www.linkedin.com/company/zooka-studio||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-youtube-play',
                                'social_link' => 'title:Youtube||url:https%3A//www.youtube.com/playlist?list=PLStisDW1uGOBC_17qkU0N2AFZj96PVEf7||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-skype',
                                'social_link' => 'title:Skype Chat||url:https%3A//skype.chinhjm||target:_blank',
                            )
                        ) ) )
                    ),
                    array(
                        'image'   => '',
                        'name'    => 'Olivia Franches',
                        'position'=> 'Designer',
                        'slogan'  => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                        'social_values' => urlencode( json_encode( array(
                            array(
                                'social_icon' => 'fa fa-facebook',
                                'social_link' => 'title:Facebook||url:https%3A//www.facebook.com/ZookaStudio-303678886710953||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-twitter',
                                'social_link' => 'title:Twitter||url:https%3A//twitter.com/zookadotio||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-linkedin',
                                'social_link' => 'title:Linkedin||url:https%3A//www.linkedin.com/company/zooka-studio||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-youtube-play',
                                'social_link' => 'title:Youtube||url:https%3A//www.youtube.com/playlist?list=PLStisDW1uGOBC_17qkU0N2AFZj96PVEf7||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-skype',
                                'social_link' => 'title:Skype Chat||url:https%3A//skype.chinhjm||target:_blank',
                            )
                        ) ) )
                    ),
                    array(
                        'image'   => '',
                        'name'    => 'Devin Phillo',
                        'position'=> 'Photographer',
                        'slogan'  => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
                        'social_values' => urlencode( json_encode( array(
                            array(
                                'social_icon' => 'fa fa-facebook',
                                'social_link' => 'title:Facebook||url:https%3A//www.facebook.com/ZookaStudio-303678886710953||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-twitter',
                                'social_link' => 'title:Twitter||url:https%3A//twitter.com/zookadotio||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-linkedin',
                                'social_link' => 'title:Linkedin||url:https%3A//www.linkedin.com/company/zooka-studio||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-youtube-play',
                                'social_link' => 'title:Youtube||url:https%3A//www.youtube.com/playlist?list=PLStisDW1uGOBC_17qkU0N2AFZj96PVEf7||target:_blank',
                            ),
                            array(
                                'social_icon' => 'fa fa-skype',
                                'social_link' => 'title:Skype Chat||url:https%3A//skype.chinhjm||target:_blank',
                            )
                        ) ) )
                    )
                ) ) ),
                'params'        => array(
                    array(
                        'type'          => 'attach_image',
                        'heading'       => esc_html__( 'Image', 'melokids' ),
                        'param_name'    => 'image',
                    ),
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Name', 'melokids' ),
                        'param_name'    => 'name',
                        'admin_label'   => true,
                    ),
                    array(
                        'type'          => 'textfield',
                        'heading'       => esc_html__( 'Position', 'melokids' ),
                        'param_name'    => 'position',
                    ),
                    array(
                        'type'          => 'textarea',
                        'heading'       => esc_html__( 'Description', 'melokids' ),
                        'param_name'    => 'slogan',
                    ),
                    array(
                        'type'          => 'vc_link',
                        'heading'       => esc_html__( 'Member Page', 'melokids' ),
                        'param_name'    => 'image_link',
                        'description'   => esc_html__( 'Enter link to member details page.', 'melokids' ),
                    ),
                    array(
                        'type'          => 'param_group',
                        'heading'       => esc_html__( 'Member Social', 'melokids' ),
                        'param_name'    => 'social_values',
                        'params'        => array(
                            array(
                                'type'          => 'iconpicker',
                                'heading'       => esc_html__( 'Social icon', 'melokids' ),
                                'param_name'    => 'social_icon',
                                'settings'      => array(
                                    'emptyIcon' => false,
                                    'type'      => 'fontawesome',
                                ),
                                'value'         => 'fa fa-adjust',
                                'admin_label'   => true,
                            ),
                            array(
                                'type'          => 'vc_link',
                                'heading'       => esc_html__( 'Enter social link', 'melokids' ),
                                'param_name'    => 'social_link',
                            ),
                        ),
                    ),
                    
                ),
                'group'     => esc_html__('Members','melokids')
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Layout Style','melokids'),
                'param_name' => 'layout_type',
                'value'      =>  array(
                    esc_html__('Grid','melokids')     => 'grid',
                    esc_html__('Carousel','melokids') => 'carousel'
                ),
                'std'        => 'grid',
                'group'      => esc_html__('Layout Settings','melokids'),
                'admin_label'=> true
            )
        ),
        /* Grid settings */
        melokids_grid_settings(array(
            'group'      => esc_html__('Layout Settings','melokids'), 
            'param_name' => 'layout_type', 
            'value'      => 'grid'
            )
        ),
        /* Carousel Settings */
        melokids_owl_settings(array(
            'group'      => esc_html__('Layout Settings','melokids'), 
            'param_name' => 'layout_type', 
            'value'      => 'carousel'
            )
        )
    )
));

class WPBakeryShortCode_zkteam extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
        extract( $atts );
        wp_enqueue_style( 'animate-css');
        melokids_owl_call_settings($atts);
        return parent::content($atts, $content);
    }
}