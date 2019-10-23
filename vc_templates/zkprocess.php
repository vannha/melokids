<?php
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    $values = (array) vc_param_group_parse_atts( $values );

    $wrap_css_class = array('zk-process-wrap', $el_id);

    $css_class_attr = $item_class = array();
    $css_class_attr[] = 'layout-'.$layout_template;

    if($layout_type === 'carousel'){
        $wrap_css_class[] = 'zk-owl-wrap';
        $css_class_attr[] = 'zk-carousel owl-carousel';
        $item_class[] = 'zk-carousel-item';
    } else {
        $css_class_attr[] = 'zk-grid row';
        $item_class[] = 'zk-grid-item col-sm-'.round(12/$col_sm).' col-md-'.round(12/$col_md).' col-lg-'.round(12/$col_lg).' col-xl-'.round(12/$col_xl);
    }
    $css_class_attr[] = $content_align;
    $css_class_attr[] = $el_class;


    $count = count($values);
    $i=1;
    $j = $data_number = 0;

    $dot_image = '';

    $item_inner_cls = ['zk-process-item overlay-wrap row d-flex'];
    $item_media_cls = ['zk-process-img entry-media col-12'];
    $item_content_cls = ['zk-process-content col-12'];
?>
<div class="<?php echo trim(implode(' ',$wrap_css_class));?>">
    <?php melokids_owl_dots_top($layout_type, $dot_pos, $dot_style); ?>
    <div id="<?php echo esc_attr($el_id);?>" class="<?php echo join(' ',$css_class_attr);?>">
        <?php 
            foreach($values as $value){
                $j++; 
                if($i > $number_row) $i=1;

                $data_number ++;
                $data_number   = zeroise( $data_number, 2 );

                $title   = isset($value['p_title']) ? $value['p_title'] : '';
                $desc    = isset($value['p_desc']) ? $value['p_desc'] : '';
                $img_id  = isset($value['p_image']) ? $value['p_image'] : '';
                $img_pos = isset($value['p_image_pos']) ? $value['p_image_pos'] : 'top';

                if($img_pos === 'bottom') 
                    $order = 'order-md-1';
                else 
                    $order = 'order-md-0';
                
                if(!empty($img_id)){
                    //$thumbnail = melokids_image_by_size($img_id, '470x373');
                    $dot_image = '';//melokids_image_by_size($img_id, 'thumbnail', 'dot-img circle');
                } else {
                    $dot_image = '';//melokids_image_by_size($img_id, 'thumbnail', 'dot-img circle');
                }
                if(isset($value['add_icon']) && 'true' === $value['add_icon']){
                    vc_icon_element_fonts_enqueue( $value['i_type'] );  /* Call icon font libs */
                    $iconClass = isset($value['i_icon_'. $value['i_type']]) ? $value['i_icon_'. $value['i_type']] : '';     /* get icon class */
                } else {
                    $iconClass = '';
                }
                /* Get Icon Link */
                $show_link = false;          
                if (isset($value['icon_link'])){  
                    $link = vc_build_link($value['icon_link']);
                    $link = ( $link == '||' ) ? '' : $link;
                    if ( strlen( $link['url'] ) > 0 ) {
                        $show_link = true;
                        $a_href = $link['url'];
                        $a_title = !empty($link['title']) ? $link['title'] : esc_html__('Read More','melokids');
                        $a_target = strlen( $link['target'] ) > 0 ? str_replace(' ', '', $link['target']) : '_self';

                        $link_open = '<a class="overlay" href="'.esc_url($a_href).'" title="'.esc_attr($a_title).'" target="'.esc_attr($a_target).'"><span class="overlay-inner center-align">';
                        $link_close = '</span></a>';
                    }
                }
                if($i==1) : ?>
                <div class="<?php echo join(' ',$item_class);?>"<?php if($dot_style === 'dots-thumbnail'): ?> data-dot='<?php echo wp_kses_post($dot_image); ?>'<?php endif; ?>>
                <?php
                    endif;
                    echo '<div class="'.trim(implode(' ', $item_inner_cls)).'">';
                        if(!empty($img_id)) {
                            echo '<div class="'.trim(implode(' ', $item_media_cls)).' '.$order.'">';
                                melokids_image_by_size(['id' => $img_id, 'size' => '470x373']);
                                if($show_link) echo wp_kses_post($link_open).'<i class="'.esc_attr($iconClass).'"></i>'.wp_kses_post($link_close);
                            echo '</div>';
                        } 
                        echo '<div class="'.trim(implode(' ', $item_content_cls)).'">';
                            if($title) echo '<h3 data-count="'.esc_attr($data_number).'">'.esc_html($data_number.' '.$title).'</h3>';
                            if($desc) echo '<div class="desc">'.esc_html($desc).'</div>';
                            if($show_link) echo '<div class="p-footer"><a class="btn" href="'.esc_url($a_href).'" title="'.esc_attr($a_title).'" target="'.esc_attr($a_target).'">'.$a_title.'</a></div>';
                        echo '</div>'; 
                    echo '</div>';
                if($i == $number_row || $j==$count) echo '</div>';
                $i ++;
            }
        ?>
    </div>
    <?php 
        melokids_owl_preload($layout_type);
        melokids_owl_dots($layout_type, $dot_style, $dot_pos);
        melokids_owl_nav($layout_type, $nav_style, $nav_pos);
        melokids_owl_dots_in_nav($layout_type, $nav_style);
    ?>
</div>