<?php 
    
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    if(empty($el_id)) $el_id = uniqid();
    $html_id = 'zk-fancybox-'.$el_id;
    /* Default */
    $title_css = $content_css = array();
    
    /* parse button link */
    $use_link = false;
    if(!empty($atts['button_link'])){
        $button_link = vc_build_link( $atts['button_link'] );
        $button_link = ( $button_link == '||' ) ? '' : $button_link;
        if ( strlen( $button_link['url'] ) > 0 ) {
            $use_link = true; 
            $a_href = $button_link['url'];
            $a_title = strlen($button_link['title']) > 0 ? $button_link['title'] : esc_html__('Read more','melokids') ;
            $a_target = strlen( $button_link['target'] ) > 0 ? $button_link['target'] : '_self';
        }
    }
    /* Image Size */
    $custom_size = false;
    if ($thumbnail_size === 'custom'){
        $custom_size = true;
        $thumbnail_size = $thumbnail_size_custom;
    } elseif($image_icon) {
        $thumbnail_size = $i_size;
    }
    if($image){
        $img_id = $atts['image'];
        $img = wpb_getImageBySize( array(
            'attach_id'  => $img_id,
            'thumb_size' => $thumbnail_size,
            'class'      => 'zk-fancybox-img',
        ));
        $thumbnail = $img['thumbnail'];
        $_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
        $image_url = $_image[0];
    }
    /* get value for Design Tab */
    $css_classes = array(
        vc_shortcode_custom_css_class( $css ),
    );

    $css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
    switch ($layout_mode) {
        default:
            break;
    }
    $css_class .= ' animated-wrap layout-'.$layout_mode.' '.$content_align.' '.$color_mode;
    /* Layout */
    switch ($layout_mode) {
        case '2':
            $_size = !empty($i_size) ? $i_size : '70';
            break;
        default:
            $_size = !empty($i_size) ? $i_size : '120';
            break;
    }
    /* Title Style */
    if(!empty($title_color)){
        $title_css[] ='color:'.$title_color;
    }
    /* Icon */
    $_i_size = explode('x',$_size);
    $_i_size_w = $_i_size[0];
    $_i_size_h = isset($_i_size[1]) ? $_i_size[1] : $_i_size[0];
    $icon_name = "i_icon_" . $i_type;
    $iconClass = isset($atts[$icon_name]) ? $atts[$icon_name]: '';
    $icon_attrs = $icon_style = $icon_class = array();
    
    /* Icon Class */
    $icon_class[] = 'zk-fancy-icon';
    $icon_class[] = $i_shape;
    $icon_class[] = 'animated';

    /* Icon Style*/
    if(!empty($i_font_size)) $icon_style[] = 'font-size:'.$i_font_size;
    if(!empty($i_color)) $icon_style[]     = 'color:'.$i_color;
    if(!empty($i_size)) $icon_style[]      = 'width:'.$_i_size_w.'px';
    if(!empty($i_size)) $icon_style[]      = 'height:'.$_i_size_h.'px';
    if(!empty($i_size)) $icon_style[]      = 'line-height:'.$_i_size_h.'px; text-align:center';
    if(!empty($i_bg)) $icon_style[]        = 'background-color:'.$i_bg;
    /* Icon Attributes */
    $icon_attrs[] = 'class="'.implode(' ', $icon_class).'"';
    if(!empty($animation_in) && $animation_in !== 'none')
        $icon_attrs[] = 'data-animation-in='.$animation_in;
    if(!empty($animation_out) && $animation_in !== 'none')
        $icon_attrs[] = 'data-animation-out='.$animation_out;
    $icon_attrs[] = 'style="'.join(';',$icon_style).'"';

    wp_enqueue_style('animate-css');
?>
<div id="<?php echo esc_attr($html_id);?>" class="zk-fancybox <?php echo trim($css_class);?> clearfix">
    <?php switch ($layout_mode) {
        default:
    ?>
        <?php if( ($add_icon && (!empty($iconClass)) || $image_icon)) :?>
            <div <?php echo implode(' ', $icon_attrs);?>>
                <?php if(!empty($iconClass) && !$image_icon) { ?>
                    <i class="<?php echo esc_attr($iconClass); ?>"></i>
                <?php } else {?>
                    <?php echo wp_kses_post($thumbnail);  ?>
                <?php } ?>
            </div>
        <?php endif;?>
        <?php if($image && !$image_icon) : ?>
            <div class="zk-fancy-img">
                <?php if ($image) echo wp_kses_post($thumbnail);  ?>
            </div>
        <?php endif; ?>
        <div class="zk-fancy-content" style="<?php echo join(';',$content_css);?>">
            <?php if(!empty($title)):?>
                <h3 class="zk-fancy-title" style="<?php echo join(';',$title_css);?>">
                    <?php if($use_link) { ?>
                    <a href="<?php echo esc_url( $a_href ); ?>" title="<?php echo esc_attr( $a_title ); ?>" target="<?php echo trim( esc_attr( $a_target ) ); ?>" style="<?php echo join(';', $title_css);?>">
                    <?php } ?>
                    <?php echo esc_html($title);?>
                    <?php if($use_link) { ?>
                    </a>
                    <?php } ?>
                </h3>
            <?php endif;?>
            
            <?php if(!empty($description)) :?>
            <div class="zk-fancy-desc">
                <?php echo wp_kses_post($description);?>
            </div>
            <?php endif;?>
            <?php if($use_link) { ?>
            <footer class="zk-fancy-footer">
                <a href="<?php echo esc_url( $a_href ); ?>" title="<?php echo esc_attr( $a_title ); ?>" target="<?php echo trim( esc_attr( $a_target ) ); ?>" class="btn">
                <?php echo esc_html($a_title);?>
                </a>
            </footer>
            <?php } ?>
        </div>
    <?php
        break;
    } ?>
    
</div>