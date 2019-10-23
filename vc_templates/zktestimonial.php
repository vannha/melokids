<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this WPBakeryShortCode_zktestimonial
 */
/* get Shortcode custom value */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$wrap_css_class = array('zk-testimonial-wrap', $el_id);

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

$testimonial = vc_map_get_attributes( $this->getShortcode(), $atts );
$values = (array) vc_param_group_parse_atts( $testimonial['values'] );
if(!isset($values[0]['text'])){
    echo '<p class="require required">'.esc_html__('Please add a testimonial text!','melokids').'</p>';
    return;
}

$thumbnail = $style = $quote_bg_color = '';
$styles = array();
$styles[] = 'font-size: 30px;';
if(!empty($quote_bg_color)) $styles[] = 'width: 30px; height: 30px; display: inline-block; background-color:'.$quote_bg_color.'; padding: 0 5px;';
if(!empty($quote_color)) $styles[] = 'color:'.$quote_color;
if(!empty($styles)) $style = 'style="'.implode(';', $styles).'"';
$lquote = is_rtl() ? 'fa fa-quote-left' : 'fa fa-quote-right';
$rquote = is_rtl() ? 'fa fa-quote-right' : 'fa fa-quote-left';
$dot_image = $avatar = '';
$default_avatar = get_template_directory_uri().'/assets/images/avatar.png';


$count = count($values);
$i=1;
$j=0;
?>
<div class="<?php echo trim(implode(' ',$wrap_css_class));?>">
    <?php melokids_owl_dots_top($layout_type, $nav_style, $dot_pos, $dot_style); ?>
    <div id="<?php echo esc_attr($el_id);?>" class="<?php echo join(' ',$css_class_attr);?>">
        <?php            
            switch ($layout_template) {
                default:
                    foreach($values as $value){
                        $author_avatar = isset($value['author_avatar']) ? $value['author_avatar'] : '';
                        $j++; 
                        if($i > $number_row) $i=1;
                        if(isset($value['text']) && !empty($value['text'])){
                            $dot_image = $avatar = melokids_image_by_size([
                                'id'      => $author_avatar,
                                'img_url' => '/wp-content/themes/'.get_template().'/assets/images/avatar-none.png',
                                'size'    =>'46',
                                'class'   =>'avatar circle', 
                                'echo'    => false]
                            );
                            
                            $author_signature = '';
                            if(isset($value['author_signature_img']) && !empty($value['author_signature_img'])) {
                                $author_signature = melokids_image_by_size([
                                    'id'      => $value['author_signature_img'],
                                    'size'    =>'full',
                                    'class'   =>'signature-img', 
                                    'echo'    => false]
                                );
                            }
                            if($i==1) : ?>
                            <div class="<?php echo join(' ',$item_class);?>"<?php if($dot_style === 'dots-thumbnail'): ?> data-dot='<?php echo wp_kses_post($dot_image); ?>'<?php endif; ?>>
                            <?php
                                endif;
                                echo '<div class="zk-testimonial-item">';
                                    echo '<div class="zk-testimonial-content color-'.esc_attr($color_mode).'">';
                                        if(isset($value['text'])) echo '<div class="description">'.esc_html($value['text']).'</div>';
                                    echo '</div>';
                                    echo '<div class="author-info clearfix row gutters-15 align-items-center">';
                                        echo wp_kses_post('<div class="author-avatar col-auto">'.$avatar.'</div>');
                                        $author = '<div class="col"><h6 class="author-name">';
                                        if(isset($value['author_url']) && !empty($value['author_url']))
                                            $author .= '<a href="'.esc_url($value['author_url']).'">';
                                        if(isset($value['author_name']) && !empty($value['author_name'])) 
                                            $author .= esc_html($value['author_name']);
                                        if(isset($value['author_url']) && !empty($value['author_url']))
                                            $author .= '</a>';
                                        $author .= '</h6>';
                                        if(isset($value['author_position']) && !empty($value['author_position'])) 
                                            $author .= '<div class="author-position small">'.esc_html($value['author_position']).'</div>';
                                        $author .= $author_signature;
                                        $author .= '</div>';
                                        echo wp_kses_post($author);
                                    echo '</div>';
                                echo '</div>';
                            if($i == $number_row || $j==$count) echo '</div>';
                            $i ++;
                        }
                    }
                break;
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
