<?php 
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    /* parse button link */
    $use_link = false;
    if(!empty($atts['button_link'])){
        $button_link = vc_build_link( $atts['button_link'] );
        $button_link = ( $button_link == '||' ) ? '' : $button_link;
        if ( strlen( $button_link['url'] ) > 0 ) {
            $use_link = true; 
            $a_href = $button_link['url'];
            $a_title = strlen($button_link['title']) > 0 ? $button_link['title'] : esc_html__('Explore More','melokids') ;
            $a_target = strlen( $button_link['target'] ) > 0 ? $button_link['target'] : '_self';
        }
    }

    $html_atts = [];
    if(!empty($el_id)) $html_atts[] = 'id="'.$el_id.'"';

    $classes = ['zk-fancyhover', 'layout-'.$layout_mode, 'hoverbox-wrap', 'text-center', 'clearfix'];
    if(!empty($el_class)) $classes[] = $el_class;

    $html_atts[] = 'class="'.trim(implode(' ',$classes)).'"';

    if(empty($img_id)) {
        echo '<div class="required">';
        esc_html_e('Please add a image first','melokids');
        echo '</div>';
        return;
    }
?>
<div <?php echo trim(implode(' ', $html_atts)); ?>>
    <?php switch ($layout_mode) {
        default:
            melokids_image_by_size(['id' => $img_id, 'size' => $img_size]);
        ?>
        <div class="hover-box static animated <?php echo esc_attr($static_in);?>" data-static-in="<?php echo esc_attr($static_out);?>" data-static-out="<?php echo esc_attr($static_in);?>">
            <div class="on-static"><?php
                if(!empty($title)) echo '<h4 class="static-title">'.esc_html($title).'</h4>';
                if(!empty($description)) echo '<div>'.esc_html($description).'</div>';
            ?></div>
        </div>
        <div class="hover-box hover animated <?php echo esc_attr($hover_out);?>" data-hover-in="<?php echo esc_attr($hover_in);?>" data-hover-out="<?php echo esc_attr($hover_out);?>">
            <?php 
                if($use_link) {
                    echo '<a href="'.esc_url($a_href).'" target="'.esc_attr($a_target).'" class="overlay d-lg-none"></a>';
                } 
            ?>
            <div class="on-hover"><?php
                if(!empty($hover_title)) echo '<h4 class="hover-title">'.esc_html($hover_title).'</h4>';
                if(!empty($hover_description)) echo '<div>'.esc_html($hover_description).'</div>';
                if($use_link) {
                    echo '<div class="hover-link"><a href="'.esc_url($a_href).'" title="'.esc_attr($a_title).'" target="'.esc_attr($a_target).'">'.esc_html($a_title).' <span class="fa fa-caret-'.melokids_align2().'"></span></a></div>';
                }
            ?></div>
        </div>
        <?php
        break;
    } 
    ?>
</div>