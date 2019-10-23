<?php
/**
 * Meta box config file
 */
if (! class_exists('MetaFramework')) {
    return;
}

$args =  array(
    'opt_name'           => apply_filters('opt_meta', 'meta_options'),
    'dev_mode'           => false,
    'open_expanded'      => false,
    'disable_save_warn'  => true,
    'save_defaults'      => false,
    'ajax_save'          => false,
    'update_notice'      => false,
    'admin_bar'          => false,
    'allow_sub_menu'     => false,
    'customizer'         => false,
    'show_import_export' => false,
    'use_cdn'            => false,
    'meta_mode'          => 'multiple',
    'async_typography'   => false
);

// -> Set Option To Panel.
MetaFramework::setArgs($args);

add_action('admin_init','melokids_post_metas');

MetaFramework::init();

/**
 * List of thumbnails size
 * @since 1.0.0
 * @author Chinh Duong Manh
 */
if(!function_exists('melokids_post_thumbnail_sizes')){

    function melokids_post_thumbnail_sizes()
    {
        return array(
            'thumbnail'      => esc_html__('Thumbnail', 'melokids'),
            'medium'         => esc_html__('Medium', 'melokids'),
            'large'          => esc_html__('Large', 'melokids'),
            'post-thumbnail' => esc_html__('Post Thumbnail', 'melokids'),
            'full'           => esc_html__('Full', 'melokids'),
            'custom'         => esc_html__('Custom', 'melokids')
        );
    }
}
if(!function_exists('melokids_post_metas')){
    function melokids_post_metas(){
        /** post options */
        MetaFramework::setMetabox(array(
            'id'            => 'post_format_options',
            'label'         => esc_html__('Post Format', 'melokids'),
            'post_type'     => 'post',
            'context'       => 'advanced',
            'priority'      => 'default',
            'open_expanded' => true,
            'sections'      => array(
                array(
                    'title'  => '',
                    'id'     => 'post_format', 
                    'icon'   => 'el el-laptop',
                    'fields' => array(
                        array(
                            'id'       => 'video_type',
                            'type'     => 'select',
                            'title'    => esc_html__('Select Video Type', 'melokids'),
                            'subtitle' => esc_html__('Local video or video-sharing website like: Youtube, Video, Daily Motion, ...', 'melokids'),
                            'options'  => array(
                                'local'    => esc_html__('Upload', 'melokids'),
                                'embed'    => esc_html__('Embed Video', 'melokids'),
                            ),
                            'default'      => 'embed',
                            //'post_format'   => array('video'),
                        ),
                        array(
                            'id'             => 'video_local',
                            'type'           => 'media',
                            'library_filter' =>array('mp4','m4v','mov','wmv','avi','mpg','ogv','3gp','3g2'),
                            'title'          => esc_html__('Local Video', 'melokids'),
                            'subtitle'       => esc_html__('Upload video media using the WordPress native uploader', 'melokids'),
                            'required'       => array('video_type', '=', 'local')
                        ),
                        array(
                            'id'             => 'video_local_thumb',
                            'type'           => 'media',
                            'library_filter' =>array('jpeg', 'jpg', 'png','gif','ico'),
                            'title'          => esc_html__('Video Thumb', 'melokids'),
                            'subtitle'       => esc_html__('Upload thumb media using the WordPress native uploader', 'melokids'),
                            'required'       => array('video_type', '=', 'local')
                        ),
                        array(
                            'id'          => 'video_embed',
                            'type'        => 'text',
                            'title'       => esc_html__('Embed Video', 'melokids'),
                            'subtitle'    => esc_html__('Load video from video-sharing website like: Youtube, Vimeo, Daily Motion,... Ex: https://www.youtube.com/watch?v=lMJXxhRFO1k', 'melokids'),
                            'description' => sprintf('%s <a href="%s" target="_blank">%s</a>', esc_html__('What Sites Can You Embed From? please look at:', 'melokids'), esc_url('https://codex.wordpress.org/Embeds'), esc_html__('WordPress Embeds','melokids')),
                            'placeholder' => esc_html__('ex: https://www.youtube.com/watch?v=lMJXxhRFO1k', 'melokids'),
                            'required'    => array('video_type', '=', 'embed')
                        ),
                        array(
                            'id'       => 'audio_type',
                            'type'     => 'select',
                            'title'    => esc_html__('Select Audio Type', 'melokids'),
                            'subtitle' => esc_html__('Local audio or audio-sharing website like: SoundCloud,...', 'melokids'),
                            'options'  => array(
                                'local'    => esc_html__('Upload', 'melokids'),
                                'embed'    => esc_html__('Embed Audio', 'melokids'),
                            ),
                            'default'      => 'embed'
                        ),
                        array(
                            'id'             => 'audio_local',
                            'type'           => 'media',
                            'library_filter' =>array('mp3','m4a','ogg','wav'),
                            'title'          => esc_html__('Audio Media', 'melokids'),
                            'subtitle'       => esc_html__('Upload audio media using the WordPress native uploader', 'melokids'),
                            'required'       => array('audio_type', '=', 'local')
                        ),
                        array(
                            'id'          => 'audio_embed',
                            'type'        => 'text',
                            'title'       => esc_html__('Embed Audio', 'melokids'),
                            'subtitle'    => esc_html__('Load audio from audio-sharing website like: SoundCloud,... Ex: https://soundcloud.com/wavey-hefner/lil-pump-gucci-gang-prod-bighead-gnealz', 'melokids'),
                            'description' => sprintf('%s <a href="%s" target="_blank">%s</a>', esc_html__('What Sites Can You Embed From? please look at:', 'melokids'), esc_url('https://codex.wordpress.org/Embeds'), esc_html__('WordPress Embeds','melokids')),
                            'placeholder' => esc_html__('ex: https://soundcloud.com/wavey-hefner/lil-pump-gucci-gang-prod-bighead-gnealz', 'melokids'),
                            'required'    => array('audio_type', '=', 'embed')
                        ),
                        array(
                            'title'     => esc_html__('Gallery Layout', 'melokids'),
                            'subtitle'  => esc_html__('Choose default layout your gallery to show', 'melokids'),
                            'id'        => 'gallery_layout',
                            'type'      => 'button_set',
                            'options'   => array(
                                'slide'   => esc_html__('Slideshow','melokids'),
                                'grid'    => esc_html__('Grid','melokids'),
                                'masonry' => esc_html__('Masonry','melokids'),
                            ),
                            'default'   => 'slide',
                        ),
                        array(
                            'id'        => 'gallery_grid_col',
                            'title'     => esc_html__('Grid Columns', 'melokids'),
                            'description'  => esc_html__('Choose columns you want to show', 'melokids'),
                            'type'      => 'button_set',
                            'options' => array(
                                '1'     => esc_html__('One','melokids'), 
                                '2'     => esc_html__('Two','melokids'),
                                '3'     => esc_html__('Three','melokids'), 
                                '4'     => esc_html__('Four','melokids'), 
                                '6'     => esc_html__('Six','melokids'), 
                            ), 
                            'default'   => '3',
                            'required'  => array( 0 => 'gallery_layout', 1 => '=', 2 => 'grid' )
                        ),
                        array(
                            'title'     => esc_html__('Gallery Size', 'melokids'),
                            'subtitle'  => esc_html__('Choose image size for gallery to show', 'melokids'),
                            'id'        => 'gallery_size',
                            'type'      => 'select',
                            'options'   => melokids_post_thumbnail_sizes(),
                            'default'   => 'large',
                        ),
                        array(
                            'title'     => esc_html__('Gallery Size Custom', 'melokids'),
                            'subtitle'  => esc_html__('Enter custom size for gallery to show', 'melokids'),
                            'desc'      => esc_html__('Alternatively enter size in pixels (Example: 200x100 (Width x Height)). You can enter multiple image size separate by comma (Example: 200x100, 300x200, large, medium_large, medium, thumbnail, full)','melokids'),
                            'id'        => 'gallery_size_custom',
                            'type'      => 'text',
                            'default'   => 'medium',
                            'required'  => array(
                                array('gallery_size', '=', 'custom')
                            )
                        ),
                        array(
                            'id'             => 'gallery_ids',
                            'type'           => 'gallery',
                            'library_filter' => array('jpeg', 'jpg', 'png','gif','ico'),
                            'title'          => esc_html__('Add/Edit Gallery', 'melokids'),
                            'subtitle'       => esc_html__('Create a new Gallery by selecting existing or uploading new images using the WordPress native uploader', 'melokids'),
                        ),
                        array(
                            'id'       => 'quote_title',
                            'type'     => 'text',
                            'title'    => esc_html__('Quote Title', 'melokids'),
                        ),
                        array(
                            'id'    => 'quote_content',
                            'type'  => 'textarea',
                            'title' => esc_html__('Quote Content', 'melokids'),
                        ),
                        array(
                            'id'       => 'link_text',
                            'type'     => 'text',
                            'placeholder' => 'Google',
                            'title'    => esc_html__('Your Text', 'melokids'),
                        ),
                        array(
                            'id'          => 'link_url',
                            'type'        => 'text',
                            'placeholder' => 'http://google.com',
                            'title'       => esc_html__('Your Link', 'melokids'),
                        ),
                    )
                ),
            )
        ));
    }
}
