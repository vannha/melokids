<?php
    $el_price = $el_price_currency = $el_title = $layout_mode = $add_image = $image = $img_pos = $button_link = $values = $a_href = $a_title = $link_open = $link_close = $feature_text = '';
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    /* parse button_link */
    if(!empty($button_link)){
        $button_link = vc_build_link( $button_link);
        $button_link = ( $button_link == '||' ) ? '' : $button_link; 
        $btn = '';
        $btn_class = ($layout_type === 'featured') ? 'btn-primary' : 'btn';
        
        if ( strlen( $button_link['url'] ) > 0 ) {
            $a_href = $button_link['url'];
            $a_title = $button_link['title'] ? $button_link['title'] :  esc_html__('Get Started','melokids');
            $a_target = strlen( $button_link['target'] ) > 0 ? $button_link['target'] : '_self';

            $btn = '<a class="'.$btn_class.'" href="'.esc_url($a_href).'" title="'.esc_attr($a_title).'" target="'.esc_html($a_target).'">'.esc_html($a_title).'</a>';
        }
    }
    /* get social */
    $values = (array) vc_param_group_parse_atts( $values );
    /* Image Size */
    if($image){
        if ($thumbnail_size === 'custom') $thumbnail_size = $thumbnail_size_custom;
        $img = wpb_getImageBySize( array(
            'attach_id'  => $image,
            'thumb_size' => $thumbnail_size,
            'class'      => 'zk-pricing-img',
        ));
        $thumbnail = $img['thumbnail'];
        $image_url = wp_get_attachment_url($image);
    }
    /* featured list class */
    $featured_cls = $feature_space ? 'large' : '';
    /* get value for Design Tab */
    $css_classes = array(
        vc_shortcode_custom_css_class( $css ),
    );
    $css_class = [
        'img-'.$img_pos,
        'layout'.$layout_mode,
        $content_align,
        $layout_type,
        preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) )
    ];
?>
<div class="zk-pricing <?php echo trim(implode(' ',$css_class)); ?>">
    <?php if(!empty($image)) : ?>
        <div class="pricing-img <?php echo esc_attr('img-'.$img_pos); ?>">
            <?php 
                echo  wp_kses_post($thumbnail);
            ?>
        </div>
    <?php endif; 
        if(!empty($el_title) || !empty($el_price)) {
    ?>
    <div class="el-header pricing-header">
    <?php 
        /* EL Title */
        if(!empty($el_title)) echo '<h3 class="el-title pricing-title">'.esc_html($el_title).'</h3>';
        /* EL Price */
        if(!empty($el_price)) echo '<div class="pricing-price h1"><span class="currency">'.esc_html($el_price_currency).'</span><span class="price">'.esc_html($el_price).'</span><span class="plan">'.esc_html($el_price_plan).'</span></div>';
    ?>
    </div>
    <?php
       }
    if(!empty($values)) {
    ?>
    <div class="pricing-content">
        <div class="feature-list <?php echo esc_attr($featured_cls); ?>">
        <?php 
            foreach($values as $value){
                if(isset($value['add_icon']) && 'true' === $value['add_icon']){
                    vc_icon_element_fonts_enqueue( $value['i_type'] );  /* Call icon font libs */
                    $iconClass = $value['add_icon'] && isset($value['i_icon_'. $value['i_type']]) ? '<i class="'.$value['i_icon_'. $value['i_type']].'">&nbsp;&nbsp;</i>' : '';     
                    /* get icon class */
                    $has_icon = !empty($iconClass) ? 'has-icon' : 'no-icon';
                } else {
                    $iconClass = $has_icon = '';
                }
                if (isset($value['feature_text'])){  
                  echo '<div class="'.esc_attr($has_icon).'">'.wp_kses_post($iconClass) . esc_html($value['feature_text']).'</div>';
                }
            }
        ?>
        </div>
    </div>
    <?php }
        if(!empty($btn))  echo '<footer class="pricing-footer">'.wp_kses_post($btn).'</footer>'; 
    ?>
</div>