<?php
    extract($atts);

    if(empty($content)) return;
?>
<div class="<?php echo trim(implode(' ',array($el_id, $el_class)));?>">
    <?php melokids_owl_dots_top($layout_type, $dot_pos, $dot_style); ?>
    <div id="<?php echo esc_attr($el_id);?>" class="zk-carousel owl-carousel <?php echo esc_attr($el_class);?>">
        <?php
        if (is_array($content)):
            $count = count($content);
            $i=1;
            $j=0;
            foreach ($content as $key => $shortcode) {
                $j++;
                if($i > $number_row) $i=1;
                if($i==1): 
                ?>
                <div class="zk-carousel-item">
                <?php endif; ?>
                    <div class="item">
                        <?php echo wpb_js_remove_wpautop($shortcode) ?>
                    </div>
                <?php if( ($i == $number_row || $j == $count) ) : ?>
                </div>
                <?php endif; 
                $i ++;
            }
        endif;
        ?>
    </div>
    <?php 
        melokids_owl_preload($layout_type);
        melokids_owl_dots($layout_type, $dot_style, $dot_pos);
        melokids_owl_nav($layout_type, $nav_style, $nav_pos);
        melokids_owl_dots_in_nav($layout_type, $nav_style);
    ?>
</div>
