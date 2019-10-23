<?php
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    $class = array('zk-video', $el_class);
    if(empty($poster))
        $poster_url = site_url().melokids_default_image_thumbnail_url();
    else 
        $poster_url =  wp_get_attachment_url($poster);

    $open = '<div id="'.esc_attr($el_id).'" class="mfp-hide">';
    $close = '</div>';
?>
<div id="zk-video-<?php echo esc_attr($el_id);?>" class="<?php echo trim(implode(' ', $class));?>">
    <div class="poster">
        <img src="<?php echo esc_url($poster_url);?>" alt="<?php echo get_option('blogname');?>" />
        <a href="#<?php echo esc_attr($el_id);?>" class="mfp-inline">
            <img src="<?php echo get_template_directory_uri().'/assets/images/video-play-btn.png';?>" alt="<?php echo get_option('blogname');?>" />
        </a>
    </div>
    <?php 
        switch ($video_source) {
            case '1':
                $video_w = 1024;
                $video_h = $video_w / 1.61; //1.61 golden ratio
                echo wp_kses_post($open).apply_filters('the_content','[embed width="'.$video_w.'" height="'.$video_h.'"]' . $online_video . '[/embed]').wp_kses_post($close);
                break;

            case '2':
                if(!empty($uploaded_video)) {
                    $video_type = wp_check_filetype(wp_get_attachment_url($uploaded_video), wp_get_mime_types());
                    if(is_numeric($uploaded_video))
                        $uploaded_video = wp_get_attachment_url($uploaded_video);
                    switch ($video_type['type']) {
                        case 'audio/mpeg':
                            echo wp_kses_post($open).apply_filters('the_content', '[audio mp3="'.esc_url($uploaded_video).'"][/audio]').wp_kses_post($close);
                            break;
                        
                        default:
                            echo wp_kses_post($open).apply_filters('the_content', '[video poster="'.esc_url($poster_url).'" '.$video_type['ext'].'="'.esc_url($uploaded_video).'" src="'.esc_url($uploaded_video).'"][/video]').wp_kses_post($close);
                            break;
                    }
                }
                break;

            case '3':
                echo wp_kses_post($open);
                    echo apply_filters('the_content','[video mp4="'.esc_url($video_mp4).'" ogv="'.esc_url($video_ogv).'" ogg="'.esc_url($video_ogg).'" webm="'.esc_url($video_webm).'" poster="'.esc_url($poster_url).'"][/video]');
                echo wp_kses_post($close);
                break;

            case '4': /* Embed Code */                
                echo wp_kses_post($open).rawurldecode( base64_ef4_decode( strip_tags( $embed_video ) ) ).wp_kses_post($close);
                break;    
        } 
    ?>
</div>