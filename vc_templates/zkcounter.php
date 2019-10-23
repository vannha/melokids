<?php 
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
?>
<div class="zk-counter-wraper <?php echo trim(implode(' ', [$content_align, $color_mode, $class])); ?>">
    <div class="row justify-content-center">
        <?php
            $columns = (int)$atts['counter_column'];
            $item_class = ['counter-item'];
            switch($columns){
                case "2":
                    $item_class[] = 'col-md-6';
                    break;
                case "3":
                    $item_class[] = 'col-md-6 col-lg-4';
                    break;
                case "4":
                    $item_class[] = 'col-md-6 col-lg-3';
                    break;
                case "5":
                    $item_class[] = 'col-md-6 col-lg-auto col-lg-max-20';
                    break;
                case "6":
                    $item_class[] = 'col-md-6 col-lg-2';
                    break;
                default:
                    $item_class[] = 'col-12';
                    break;
            }
            for($i=1;$i<=$columns;$i++) { ?>
                    <?php
                        $title      = isset($atts['title'.$i]) ? $atts['title'.$i] : '';
                        $desc       = isset($atts['desc'.$i]) ? $atts['desc'.$i] : '';
                        $i_type     = isset($atts['i'.$i.'_type']) ? $atts['i'.$i.'_type'] : '';
                        $add_icon   = isset($atts['add_icon'.$i]) ? $atts['add_icon'.$i] : '';
                        $icon       = isset($atts['i'.$i.'_icon_'.$i_type]) ? $atts['i'.$i.'_icon_'.$i_type] : '';
                        $icon_color = isset($atts['icon'.$i.'_color']) ? $atts['icon'.$i.'_color'] : '';
                        $suffix     = isset($atts['suffix'.$i]) ? $atts['suffix'.$i] : '';
                        $prefix     = isset($atts['prefix'.$i]) ? $atts['prefix'.$i] : '';
                        $digit      = isset($atts['digit'.$i]) ? $atts['digit'.$i] : '';
                    if(!empty($title) || !empty($desc) || 'true' === $add_icon || !empty($suffix) || !empty($prefix) || !empty($digit)) {
                    ?>
                    <div class="<?php echo trim(implode(' ', $item_class));?>">
                        <?php if( 'true' === $add_icon && '' !== $icon ): 
                            /* call icon font css */
                            vc_icon_element_fonts_enqueue($i_type);
                        ?>
        					<span class="counter-icon text-<?php echo esc_attr($color_mode);?>"><span class="<?php echo esc_attr($icon); ?>" <?php if(!empty($icon_color)) :?> style="color:<?php echo esc_attr($icon_color);?>"<?php endif; ?>></span></span>
        				<?php endif; ?>
        				<div class="zk-counter-wrap text-<?php echo esc_attr($color_mode);?>" data-prefix="<?php echo esc_attr($prefix);?>" data-suffix="<?php echo esc_attr($suffix);?>" data-type="<?php echo esc_attr($counter_type);?>" data-digit="<?php echo esc_attr($digit);?>">
                            <?php if(!empty($prefix)) echo '<span class="prefix">'.esc_html($prefix).'</span>'; ?>
                            <span class="zk-counter h1"><?php echo esc_attr($digit); ?></span>
                            <?php if(!empty($suffix)) echo '<span class="suffix">'.esc_html($suffix).'</span>'; ?>
        				</div>
                        <?php if($title):?>
                            <div class="counter-title h3 text-<?php echo esc_attr($color_mode);?>"><?php echo esc_html($title);?></div>
                        <?php endif;?>
                        <?php if($desc):?>
                            <div class="counter-desc text-<?php echo esc_attr($color_mode);?>"><?php echo esc_html($desc);?></div>
                        <?php endif;?>
        			</div>
            <?php }
            }
        ?>
    </div>
</div>