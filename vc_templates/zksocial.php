<?php
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    $values = (array) vc_param_group_parse_atts( $values );
    $wrap_classes = array(
        'zk-social', 
        'layout-'.$layout_template, 
        $color_mode
    );

    $link_classes = array();
?>
<div class="<?php echo trim(implode(' ', $wrap_classes)); ?>">
    <?php
        switch ($source) {
            case 'custom':
                foreach($values as $value){
                    if(isset($value['add_icon']) && 'true' === $value['add_icon']) {
                        vc_icon_element_fonts_enqueue( $value['i_type'] );  /* Call icon font libs */
                        $iconClass = isset($value['i_icon_'. $value['i_type']]) ? $value['i_icon_'. $value['i_type']] : ''; /* get icon class */
                    } else {
                        $iconClass = '';
                        $link_classes[] = 'no-icon';
                    }

                    $a_title = isset($value['social_name']) ? $value['social_name'] : esc_html__('Follow Us','melokids');
                    $a_href = '#';
                    $a_target = '_blank';

                    if (isset($value['social_url'])){  
                        $link = vc_build_link($value['social_url']);
                        $link = ( $link == '||' ) ? '' : $link;
                        if ( strlen( $link['url'] ) > 0 ) {
                            $a_href = $link['url'];
                            $a_title = isset($link['title']) ? $link['title'] : $a_title;
                            $a_target = strlen( $link['target'] ) > 0 ? str_replace(' ', '', $link['target']) : '_blank';
                        }
                    }
                    $link_open = '<a title="'.esc_attr($a_title).'" data-toggle="tooltip" class="'.trim(implode(' ', $link_classes)).'" href="'.esc_attr($a_href).'" target="'.esc_attr($a_target).'">';
                    $link_close = '</a>';

                    echo ''.$link_open; 
                    if(!empty($iconClass)) {
                        echo '<i class="'.esc_attr($iconClass).'"></i>';
                    } else {
                        echo esc_html($a_title);
                    }
                    echo wp_kses_post($link_close); 
                }
                break;
             
            default:
                melokids_social_list(['layout' => $layout_template]);
                break;
         } 
        
    ?>
</div>


