<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $thumbnail_size
 * @var $thumbnail_size_custom
 * @var $values
 * Shortcode class
 * @var $this WPBakeryShortCode_cms_team_carousel
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$wrap_css_class = array('zk-team-wrap', $el_id);

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


/* Image Size */
$custom_size = false;
$thumbnail_class = '';
if ($thumbnail_size === 'custom'){
    $custom_size = true;
    $thumbnail_size = $thumbnail_size_custom;
}
if($thumbnail_bw) $thumbnail_class .= ' bw';

$member = vc_map_get_attributes( $this->getShortcode(), $atts );
$values = (array) vc_param_group_parse_atts( $member['values'] );
if(empty($values[0])) {
    echo '<p class="require required">'.esc_html__('Please add a member!','melokids').'</p>';
    return;
}
$count = count($values);
$i=1;
$j=0;

?>
<div class="<?php echo trim(implode(' ',$wrap_css_class));?>">
    <?php melokids_owl_dots_top($layout_type, $dot_pos, $dot_style); ?>
    <div id="<?php echo esc_attr($el_id);?>" class="<?php echo join(' ',$css_class_attr);?>">
        <?php
            foreach($values as $value){
                /* Team Image */
                if(isset($value['image'])) {  
                    $img = wpb_getImageBySize( array(
                        'attach_id' => $value['image'],
                        'thumb_size' => $thumbnail_size,
                        'class' => 'team-image'.$thumbnail_class,
                    ));
                    $thumbnail = $img['thumbnail'];
                    $dot_image = wp_get_attachment_image($value['image'],'thumbnail','',array('class'=>'dot-img circle'));
                } else {
                    $thumbnail = '';
                    $dot_image = melokids_default_image_thumbnail(array('size' => 'thumbnail', 'class' => 'dot-img circle'));
                }

                $j++;
                if($i > $number_row) $i=1;
                if($i==1): 
                ?>
                <div class="<?php echo join(' ',$item_class) ?>"<?php if($dot_style === 'dots-thumbnail'): ?> data-dot='<?php echo wp_kses_post($dot_image); ?>'<?php endif; ?>>
                <?php endif ; ?>
                <div class="zk-team-item overlay-wrap">
                <?php
                    /* parse image_link */
                    $link = false;
                    if(isset($value['image_link'])){
                        $image_link = vc_build_link( $value['image_link']);
                        $image_link = ( $image_link == '||' ) ? '' : $image_link;
                        if ( strlen( $image_link['url'] ) > 0 ) {
                            $link = true;
                            $a_href = $image_link['url'];
                            $a_title = $image_link['title'] ? $image_link['title'] : esc_html__('Read More','melokids');
                            $a_target = strlen( $image_link['target'] ) > 0 ? str_replace(' ','',$image_link['target']) : '_self';
                        }
                    }
                    if($link){
                        $link_open = '<a class="btn btn-primary" href="'.esc_url($a_href).'" title="'.esc_attr($a_title).'" target="'.esc_attr($a_target).'">';
                        $link_close = '</a>';
                    }

                    /* Get social */
                    if(isset($value['social_values'])){
                        $socials_list = '';
                        $socials = (array) vc_param_group_parse_atts( $value['social_values']);

                        foreach($socials as $social){
                            if(isset($social['social_icon'])) $social_icon = '<i class="'.$social['social_icon'].'"></i>';
                            /* parse social link */
                            $social_link = false;
                            if(isset($social['social_link'])){
                                $social_icon_link = vc_build_link( $social['social_link'] );
                                $social_icon_link = ( $social_icon_link == '||' ) ? '' : $social_icon_link;
                                if ( strlen( $social_icon_link['url'] ) > 0 ) {
                                    $social_link = true;
                                    $social_href = $social_icon_link['url'];
                                    $social_title = $social_icon_link['title'] ? $social_icon_link['title'] : '';
                                    $social_target = strlen( $social_icon_link['target'] ) > 0 ? str_replace(' ','',$social_icon_link['target']) : '_self';

                                    /* get domain as class */
                                    $domail_name = melokids_parse_url_all($social_href);
                                    $colored = $domail_name['domain_name'];
                                    if ($domail_name['domain_name'] == 'skype') {
                                        $social_href = 'skype:'.$domail_name['domain_ext'].'?chat';
                                    } 
                                    //echo '<a class="'.esc_attr($icon).'" target="_blank" href="' .  $value  . '"><span class="ion-social-'.esc_attr($icon).'"></span></a>';
                                        
                                }
                            }
                            if($social_link){
                                $social_link_open = '<a class="'.esc_attr($colored).'" href="'.esc_url($social_href).'" title="'.esc_attr($social_title).'" target="'.esc_attr($social_target).'">';
                                $social_link_close = '</a>';
                                $socials_list .= $social_link_open.$social_icon.$social_link_close;
                            }     
                        }
                    }
                    /* Team Image */
                    if(isset($value['image']) && !empty($thumbnail)) {  
                        echo '<div class="zk-team-media entry-media">';
                            echo wp_kses_post($thumbnail);
                            /* Overlay Content */
                            if($link){
                                echo '<div class="overlay animated '.esc_attr($thumbnail_class.' '.$animation_out).'" data-animation-in="'.esc_attr($animation_in).'" data-animation-out="'.esc_attr($animation_out).'">
                                    <div class="overlay-inner vertical-align text-center"><div class="zk-team-info-content">';
                                       echo wp_kses_post($link_open).esc_html($a_title).wp_kses_post($link_close);
                                echo '</div></div></div>';
                            }
                        echo '</div>';
                    }
                    
                    echo '<div class="zk-team-info">';
                        echo '<div class="zk-team-info-header">';
                            if(isset($value['name']))  echo '<h5 class="name">'.esc_html($value['name']).'</h5>';
                            if(isset($value['position']))   echo '<div class="position">'.esc_html($value['position']).'</div>';
                            if(isset($value['slogan']) && !empty($value['slogan'])) echo '<div class="description">'.esc_html($value['slogan']).'</div>';
                        echo '</div>';
                        if(isset($value['social_values']) && $value['social_values']!=='%5B%5D')  echo wp_kses_post('<div class="zk-social">'.$socials_list.'</div>');

                        if(empty($thumbnail) && $link) echo wp_kses_post($link_open).esc_html($a_title).wp_kses_post($link_close);
                    echo '</div>';
                ?>
                </div>
                <?php if( ($i == $number_row || $j == $count) ) : ?>
                </div>
                <?php endif; 
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
