<?php 
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    /* parse button link */
    $use_link = false;
    $a_href = $a_title = $a_target = '';
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

    $classes = ['zk-fancyimg', 'layout-'.$layout_mode, 'overlay-wrap', 'clearfix'];
    if(!empty($el_class)) $classes[] = $el_class;

    $html_atts[] = 'class="'.trim(implode(' ',$classes)).'"';
?>
<div <?php echo trim(implode(' ', $html_atts)); ?>>
    <?php switch ($layout_mode) {
        case '8' : 
            if(empty($img_size)) $img_size = '470x510';
            $term = get_term($taxonomies);
            echo '<div class="content justify-content-center align-items-end text-center" style="min-height:'.melokids_thumbnail_dimensions($img_id, $img_size).';">';
                echo '<a href="'.get_category_link($taxonomies).'">';
                    melokids_image_by_size(['id' => $img_id, 'size' => $img_size, 'class' => 'overlay image-fit']);
                echo '</a>';
                echo '<div class="content-inner">';
                    if(!empty($title)) echo wp_kses_post('<h5 class="el-title"><a href="'.get_category_link($taxonomies).'">'.$title.'</a></h5>');
                    if(!empty($taxonomies) && term_exists($taxonomies)) echo esc_html__('by','melokids').' <a class="brand-name" href="'.get_category_link($taxonomies).'">'.$term->name.'</a>';
                echo '</div>';
            echo '</div>';
        break;
        case '7' :  
            if(empty($img_size)) $img_size = '560x470';
            $term = get_term($taxonomies);
            echo '<div class="content justify-content-center align-items-center text-center" style="min-height:'.melokids_thumbnail_dimensions($img_id, $img_size).';">';
                melokids_image_by_size(['id' => $img_id, 'size' => $img_size, 'class' => 'overlay image-fit']);
                echo '<div class="content-inner">';
                    if(!empty($title) && empty($title_img)) echo wp_kses_post('<h5 class="el-title"><a href="'.get_category_link($taxonomies).'">'.$title.'</a></h5>');
                    if(!empty($title_img)) melokids_image_by_size(['id' => $title_img, 'size' => 'full', 'class' => 'el-title-image']);
                    if(!empty($description)) echo wp_kses_post('<div class="el-desc">'.$description.'</div>');
                echo '</div>';
                if($taxonomies) {
                    echo '<div class="add_to_cart_inline align-self-end"><a class="simple-link" href="'.get_category_link($taxonomies).'">'.esc_html__('Explore More','melokids').' <span class="fa fa-caret-'.melokids_align2().'"></span></a></div>';
                }
            echo '</div>';
        break;
        case '6' : 
            if(empty($img_size)) $img_size = '560x470';
            $term = get_term($taxonomies);
            echo '<div class="content justify-content-center align-items-center text-center" style="min-height:'.melokids_thumbnail_dimensions($img_id, $img_size).';">';
                echo '<a href="'.get_category_link($taxonomies).'">';
                    melokids_image_by_size(['id' => $img_id, 'size' => $img_size, 'class' => 'overlay image-fit']);
                echo '</a>';
                echo '<div class="content-inner">';
                    if(!empty($title)) echo wp_kses_post('<h5 class="el-title"><a href="'.get_category_link($taxonomies).'">'.$title.'</a></h5>');
                    if(!empty($taxonomies)) echo esc_html__('by','melokids').' <a class="brand-name" href="'.get_category_link($taxonomies).'">'.$term->name.'</a>';
                echo '</div>';
            echo '</div>';
        break;
        case '5' :
            if(empty($img_size)) $img_size = '840x418';
            echo '<div class="content" style="min-height:'.melokids_thumbnail_dimensions($img_id, $img_size).';">';
                melokids_image_by_size(['id' => $img_id, 'size' => $img_size, 'class' => 'overlay image-fit']);
                echo '<div class="content-inner"><div class="header">';
                    if(!empty($title)) echo wp_kses_post('<h2 class="el-title">'.$title.'</h2>');
                    echo '<div class="p-price">';
                        if(!empty($sale_price)) echo '<ins>'.esc_html($sale_price).'</ins>';
                        if(!empty($regular_price)) echo '<del>'.esc_html($regular_price).'</del>';
                    echo '</div></div>';
                echo '</div>';
                if($use_link) {
                    echo '<div class="add_to_cart_inline align-self-end"><a class="simple-link" href="'.esc_url($a_href).'" target="'.esc_attr($a_target).'">'.esc_html($a_title).' <span class="fa fa-caret-'.melokids_align2().'"></span></a></div>';
                }
            echo '</div>';
        break;
        case '4' :  
            if(empty($img_size)) $img_size = '840x418';
            echo '<div class="content" style="min-height:'.melokids_thumbnail_dimensions($img_id, $img_size).';">';
                melokids_image_by_size(['id' => $img_id, 'size' => $img_size, 'class' => 'overlay image-fit']);
                echo '<div class="content-inner"><div class="header">';
                    if(!empty($title)) echo wp_kses_post('<h2 class="el-title">'.$title.'</h2>');
                    echo '<div class="p-price">';
                        if(!empty($sale_price)) echo '<ins>'.esc_html($sale_price).'</ins>';
                        if(!empty($regular_price)) echo '<del>'.esc_html($regular_price).'</del>';
                    echo '</div></div>';
                echo '</div>';
                if($use_link) {
                    echo '<div class="add_to_cart_inline align-self-end"><a class="simple-link" href="'.esc_url($a_href).'" target="'.esc_attr($a_target).'">'.esc_html($a_title).' <span class="fa fa-caret-'.melokids_align2().'"></span></a></div>';
                }
            echo '</div>';
        break;
        case '2' :
            if(empty($img_size)) $img_size = '570x227';
            echo '<div class="img-wrap">';
                melokids_image_by_size(['id' => $img_id, 'size' => $img_size]);
                if($use_link) {
                    echo '<div class="center-align"><a class="zk-btn zk-btn-white zk-btn-xl" href="'.esc_url($a_href).'" title="'.esc_attr($a_title).'" target="'.esc_attr($a_target).'">'.esc_html($a_title).'</a></div>';
                }
            echo '</div>';
            if(!empty($title)) echo wp_kses_post('<h4 class="el-title">'.$title.'</h4>');
            if(!empty($description)) echo wp_kses_post('<div class="el-desc">'.$description.'</div>');
        break;
        default:
            if(empty($img_size)) $img_size = '270';
            echo '<div class="img-wrap">';
                melokids_image_by_size(['id' => $img_id, 'size' => $img_size, 'class' => 'circle']); 
                if($use_link) {
                    echo '<div class="overlay animated circle zoomOut" data-animation-in="zoomIn" data-animation-out="zoomOut"><a href="'.esc_url($a_href).'" title="'.esc_attr($a_title).'" target="'.esc_attr($a_target).'">'.esc_html($a_title).' <span class="fa fa-caret-'.melokids_align2().'"></span></a></div>';
                }
            echo '</div>';
            if(!empty($title)) echo wp_kses_post('<h4 class="el-title">'.$title.'</h4>');
            if(!empty($description)) echo wp_kses_post('<div class="el-desc">'.$description.'</div>');
        break;
    } ?>
</div>