<?php
vc_map(array(
    'name'        => 'MeloKids Video',
    'base'        => 'zkvideo',
    'icon'        => 'icon-wpb-film-youtube',
    'category'    => esc_html__('MeloKids','melokids'),
    'description' => esc_html__('Add a custom Videos', 'melokids'),
    'params'      => array(
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Video Source','melokids'),
            'param_name' => 'video_source',
            'value'      =>   array(
                esc_html__('Online Video','melokids')   => '1',
                esc_html__('Uploaded Video','melokids') => '2',
                esc_html__('Hosted Video','melokids')   => '3', 
                esc_html__('Embed code','melokids')     => '4', 
            ),
            'std'         => '1',
            'admin_label' => true,
        ),
        array(
            'type'        => 'textfield',
            'class'       => '',
            'heading'     => esc_html__('Online Video','melokids'),
            'description' => sprintf( __( 'Enter link to video, EX: https://www.youtube.com/watch?v=lMJXxhRFO1k (Note: read more about available formats at WordPress <a href="%s" target="_blank">codex page</a>).', 'melokids' ), 'http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' ),
            'param_name'  => 'online_video',
            'value'       => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
            'dependency'  => array(
                'element'     => 'video_source',
                'value'       => '1',
            ),
            'holder'      => 'div',
        ),
        array(
            'type'        => 'ef4_video',
            'class'       => '',
            'heading'     => esc_html__('Uploaded Video','melokids'),
            'description' => esc_html__('choose your uploaded video','melokids' ),
            'param_name'  => 'uploaded_video',
            'settings'    => array('single'=>true),
            'dependency'  => array(
                'element' => 'video_source',
                'value'   => '2',
            ),
            'holder' => 'div',            
        ),
        array(
            'type'        => 'textfield',
            'class'       => '',
            'heading'     => esc_html__('MP4','melokids'),
            'description' => esc_html__('Enter your MP4 video file url, ex: http://clips.vorwaerts-gmbh.de/big_buck_bunny.mp4','melokids'),
            'param_name'  => 'video_mp4',
            'value'       => '',
            'dependency'  => array(
                'element'     => 'video_source',
                'value'       => '3',
            ),
            'holder'      => 'div',            
        ),
        
        array(
            'type'        => 'textfield',
            'class'       => '',
            'heading'     => esc_html__('OGV','melokids'),
            'description' => esc_html__('Enter your OGV video file url, ex: http://clips.vorwaerts-gmbh.de/big_buck_bunny.ogv','melokids'),
            'param_name'  => 'video_ogv',
            'value'       => '',
            'dependency'  => array(
                'element'     => 'video_source',
                'value'       => '3',
            ),
            'holder'      => 'div',
        ),
        array(
            'type'        => 'textfield',
            'class'       => '',
            'heading'     => esc_html__('OGG','melokids'),
            'description' => esc_html__('Enter your OGV video file url, ex: https://www.w3schools.com/html/mov_bbb.ogg','melokids'),
            'param_name'  => 'video_ogg',
            'value'       => '',
            'dependency'  => array(
                'element'     => 'video_source',
                'value'       => '3',
            ),
            'holder'      => 'div',
        ),
        array(
            'type'        => 'textfield',
            'class'       => '',
            'heading'     => esc_html__('WEBM','melokids'),
            'description' => esc_html__('Enter your WEBM video file url, ex: http://clips.vorwaerts-gmbh.de/big_buck_bunny.webm','melokids'),
            'param_name'  => 'video_webm',
            'value'       => '',
            'dependency' => array(
                'element' => 'video_source',
                'value'   => '3',
            ),
            'holder' => 'div',
        ),
        array(
            'type'        => 'textarea_raw_html',
            'class'       => '',
            'heading'     => esc_html__('Embed video','melokids'),
            'description' => esc_html__('Enter your embed code.','melokids'),
            'param_name'  => 'embed_video',
            'value'       => '',
            'dependency' => array(
                'element' => 'video_source',
                'value'   => '4',
            ),
            'holder' => 'div',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Extra class name', 'melokids' ),
            'param_name'  => 'el_class',
            'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'melokids' ),
        ),
        array(
            'type'       => 'el_id',
            'heading'    => esc_html__('Element ID','melokids'),
            'param_name' => 'el_id',
            'settings' => array(
                'auto_generate' => true,
            ),
            'description'   => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'melokids' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
        ),
        array(
            'type'       => 'attach_image',
            'class'      => '',
            'param_name' => 'poster',
            'value'      => '',
            'group'      =>esc_html__( 'Poster','melokids'),
        ),
    )
));

class WPBakeryShortCode_zkvideo extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        wp_enqueue_script('magnific-popup');
        wp_enqueue_style ('magnific-popup');
        return parent::content($atts, $content);
    }
}

?>