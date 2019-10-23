<?php
vc_map(array(
    'name'        => 'MeloKids Socials',
    'base'        => 'zksocial',
    'icon'        => 'zkel-icon-social',
    'category'    => esc_html__('MeloKids', 'melokids'),
    'description' => esc_html__('Add your social networks', 'melokids'),
    'params'      => array(
        array(
            'type'       => 'img',
            'heading'    => esc_html__('Layout Template','melokids'),
            'param_name' => 'layout_template',
            'value'      =>  array(
                '1' => get_template_directory_uri().'/vc_customs/layouts/socials1.png',
                '2' => get_template_directory_uri().'/vc_customs/layouts/socials2.png',
            ),
            'std'   => '1',
        ),
        
        array(
            'type'       => 'dropdown',
            'param_name' => 'color_mode',
            'heading'    => esc_html__( 'Color Mode', 'melokids' ),
            'value'      => array(
                esc_html__( 'Default', 'melokids' )            => '',
                esc_html__( 'White', 'melokids' )              => 'white',
                esc_html__( 'Text Colored', 'melokids' )       => 'text-colored'
            ),
            'std' => '',
            'admin_label' => true,
        ),
        
        array(
            'type'       => 'dropdown',
            'param_name' => 'source',
            'heading'    => esc_html__( 'Source', 'melokids' ),
            'value'      => array(
                esc_html__( 'From Theme Options', 'melokids' ) => 'ThemeOption',
                esc_html__( 'Custom', 'melokids' )             => 'custom',
            ),
            'std' => 'ThemeOption',
            'description' => esc_html__( 'Choose what social source display. Default from Theme Option, or custom in this element!', 'melokids' ),
            'group'       => esc_html__('Socials','melokids'),
            'admin_label' => true,
        ),
        array(
            'type'       => 'param_group',
            'heading'    => esc_html__( 'Add your socials link', 'melokids' ),
            'param_name' => 'values',
            'value'      => urlencode( json_encode( array(
                array(
                    'social_name'        => esc_html__('Faceboook','melokids'),
                    'social_url'         => 'title:Facebook||url:https%3A//www.facebook.com/ZookaStudio-303678886710953||target:_blank',
                    'add_icon'           => 'true',
                    'i_type'             => 'fontawesome',
                    'i_icon_fontawesome' => 'fa fa-facebook'
                ),
                array(
                    'social_name'        => esc_html__('Twitter','melokids'),
                    'social_url'         => 'title:Twitter||url:https%3A//twitter.com/zookadotio||target:_blank',
                    'add_icon'           => 'true',
                    'i_type'             => 'fontawesome',
                    'i_icon_fontawesome' => 'fa fa-twitter'
                ),
                array(
                    'social_name'        => esc_html__('Linkedin','melokids'),
                    'social_url'         => 'title:Linkedin||url:https%3A//www.linkedin.com/company/zooka-studio||target:_blank',
                    'add_icon'           => 'true',
                    'i_type'             => 'fontawesome',
                    'i_icon_fontawesome' => 'fa fa-linkedin'
                ),
                array(
                    'social_name'        => esc_html__('Youtube','melokids'),
                    'social_url'         => 'title:Youtube||url:https%3A//www.youtube.com/playlist?list=PLStisDW1uGOBC_17qkU0N2AFZj96PVEf7||target:_blank',
                    'add_icon'           => 'true',
                    'i_type'             => 'fontawesome',
                    'i_icon_fontawesome' => 'fa fa-youtube-play'
                ),
                array(
                    'social_name'        => esc_html__('Skype Chat','melokids'),
                    'social_url'         => 'title:Skype Chat||url:skype%3Achinhjm?chat||target:_blank',
                    'add_icon'           => 'true',
                    'i_type'             => 'fontawesome',
                    'i_icon_fontawesome' => 'fa fa-skype'
                )
            ) ) ),
            'params'     => array_merge(
                array(
                    array(
                        'type'        => 'textfield',
                        'heading'     =>  esc_html__('Social Name','melokids'),
                        'param_name'  => 'social_name',
                        'admin_label' => true,
                    ),
                    array(
                        'type'       => 'vc_link',
                        'heading'    => esc_html__( 'Social url', 'melokids' ),
                        'param_name' => 'social_url',
                    ),
                    array(
                        'type'       => 'checkbox',
                        'param_name' => 'add_icon',
                        'value'      => array(
                            esc_html__( 'Add icon?', 'melokids' ) => 'true',
                        ),
                        'std'        => 'false',
                    )
                ),
                melokids_icon_libs(),
                melokids_icon_libs_icon()
            ),
            'group'      => esc_html__('Socials','melokids'),
            'dependency' => array(
                'element' => 'source',
                'value'   => 'custom',
            ),
        ),
    )
));

class WPBakeryShortCode_zksocial extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}