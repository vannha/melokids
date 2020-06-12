<?php
if (!class_exists('VC_Manager') || !class_exists('EF4Framework')) return;

/**
 * Add VC as Theme
*/
add_action( 'vc_before_init', 'themeframe_vc_set_as_theme' );
function themeframe_vc_set_as_theme() {
    vc_set_as_theme();
}
/**
 * Remove Element from EF4 FrameWork
*/
add_filter('cms-shorcode-list', 'remove_ef4_shortcodes');
function remove_ef4_shortcodes(){
  return array();
}

/**
 * Custom CPT UI
 * Need to do this to add custom post type registered with CPT UI
 * show in list DATA SOURCE of VC POST GRID Element
 * referent link : https://wordpress.org/support/topic/custom-post-type-and-visual-composer-grid-block/#post-6182678
 * and : https://wordpress.org/support/topic/custom-post-type-and-visual-composer-grid-block/page/2#post-6182761
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
if (function_exists('cptui_create_custom_post_types')) {
  remove_action('init', 'cptui_create_custom_post_types', 10);
  add_action('init', 'cptui_create_custom_post_types', 2);
}

/**
 * Remove VC frontend Editor
 * add_action( 'vc_after_init', 'vc_remove_wp_admin_bar_button' );
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
function vc_remove_wp_admin_bar_button()
{
    remove_action('admin_ef4_bar_menu', array(vc_frontend_editor(), 'adminBarEditLink'), 1000);
}

/**
 * Remove VC frontend Editor Post Link
 * add_action( 'vc_after_init', 'vc_remove_wp_edit_post_link' );
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
if(function_exists('remove_ef4_filter')){
    function vc_remove_wp_edit_post_link()
    {
        remove_ef4_filter('edit_post_link', array(vc_frontend_editor(), 'renderEditButton'));
    }
    add_action('vc_after_init', 'vc_remove_wp_edit_post_link');
}

function vc_remove_frontend_links() {
    vc_disable_frontend(); // this will disable frontend editor
}
add_action( 'vc_after_init', 'vc_remove_frontend_links' );


/**
 * Get Page List
 * Used in VC ELement options
 * @author Chinh Duong Manh
 * @since 1.0.0
*/
function melokids_list_page_vc(){
    $page_list = array(
        esc_html__('Default','melokids') => ''
    );
    $pages = get_pages(array('hierarchical' => 0));
    foreach($pages as $page){
       $page_list[$page->post_title] = $page->post_name;
    }
    return $page_list;
}

/**
  * Get post type list for VC
*/
if (!function_exists('melokids_get_post_types_for_vc')) {
    function melokids_get_post_types_for_vc()
    {
        $post_types = get_post_types(['public' => true], 'object');
        $excludedPostTypes = array(
            'revision',
            'nav_menu_item',
            'vc_grid_item',
            'page',
            'attachment',
            'custom_css',
            'customize_changeset',
            'oembed_cache',
            'cms-mega-menu'
        );
        $result = [];
        if (!is_array($post_types))
            return $result;
        foreach ($post_types as $post_type) {
            if (!$post_type instanceof WP_Post_Type)
                continue;
            if (in_array($post_type->name, $excludedPostTypes))
                continue;
            $result["{$post_type->label} ({$post_type->name})"] = $post_type->name;
        }
        return $result;
    }
}

/*
 * Get taxonomy list for VC
*/
if(!function_exists('melokids_get_taxonomy_for_vc')){
    function melokids_get_taxonomy_for_vc(){
        $taxonomiesForFilter = array();
        if ( 'vc_edit_form' === vc_post_param( 'action' ) ) {
            $vcTaxonomiesTypes = vc_taxonomies_types();
            if ( is_array( $vcTaxonomiesTypes ) && ! empty( $vcTaxonomiesTypes ) ) {
                foreach ( $vcTaxonomiesTypes as $t => $data ) {
                    if ( 'post_format' !== $t && is_object( $data ) ) {
                        $taxonomiesForFilter[ $data->labels->name . '(' . $t . ')' ] = $t;
                    }
                }
            }
        }
        return $taxonomiesForFilter;
    }
}

/**
 * Change default class name of VC to use Bootstrap 4.x
 *
 * Filter to replace default css class names for vc_row shortcode and vc_column
 * https://kb.wpbakery.com/docs/filters/vc_shortcodes_css_class/
*/
add_filter( 'vc_shortcodes_css_class', 'melokids_css_classes_for_vc_row_and_vc_column', 10, 2 );
function melokids_css_classes_for_vc_row_and_vc_column( $class_string, $tag ) {
    if ( $tag == 'vc_section' ) {
        $class_string = str_replace( 'vc_section-has-fill', 'vc-section-has-fill vc-has-fill', $class_string );
        //$class_string = str_replace( 'vc_column-gap-', 'vc-column-gap-', $class_string );
        //$class_string = str_replace( 'vc_row-o-full-height', 'vc-full-height', $class_string );
        //$class_string = str_replace( 'vc_section-o-content-', 'vc-content-', $class_string );
        //$class_string = str_replace( 'vc_section-flex', 'vc-flex', $class_string );
    }
    if ( $tag == 'vc_row' || $tag == 'vc_row_inner' ) {
        $class_string = str_replace( 'vc_row-has-fill', 'vc-row-has-fill vc-has-fill', $class_string );
        $class_string = str_replace( 'vc_column-gap-', 'vc-column-gap-', $class_string );
        //$class_string = str_replace( 'vc_row-o-full-height', 'vc-full-height', $class_string );
        //$class_string = str_replace( 'vc_row-o-columns-', 'vc-content-', $class_string );
        //$class_string = str_replace( 'vc_row-flex', 'vc-flex', $class_string );
    }
    if ( $tag == 'vc_column' || $tag == 'vc_column_inner' ) {
        //$class_string = preg_replace( '/wpb_column/', '', $class_string );
        //$class_string = preg_replace( '/vc_column_container/', 'vc-column-container', $class_string );
        $class_string = preg_replace( '/vc_col-has-fill/', 'vc-col-has-fill', $class_string );
        //$class_string = preg_replace( '/vc_column-inner/', 'vc-column-inner', $class_string );

        $class_string = preg_replace( '/vc_col-lg-(\d{1,2})/', 'col-xl-$1', $class_string );
        $class_string = preg_replace( '/vc_col-md-(\d{1,2})/', 'col-lg-$1', $class_string );
        $class_string = preg_replace( '/vc_col-sm-(\d{1,2})/', 'col-md-$1', $class_string );
        $class_string = preg_replace( '/vc_col-xs-(\d{1,2})/', 'col-$1', $class_string );
        // offset 
        $class_string = preg_replace( '/vc_col-lg-offset-(\d{1,2})/', 'offset-xl-$1', $class_string );
        $class_string = preg_replace( '/vc_col-md-offset-(\d{1,2})/', 'offset-lg-$1', $class_string );
        $class_string = preg_replace( '/vc_col-sm-offset-(\d{1,2})/', 'offset-md-$1', $class_string );
        $class_string = preg_replace( '/vc_col-xs-offset-(\d{1,2})/', 'offset-$1', $class_string );
    }
    return $class_string; // Important: you should always return modified or original $class_string
}

/**
 * Custom VC shortcode output
 */
add_filter('vc_shortcode_output', 'melokids_vc_shortcode_output', 10, 3);
function melokids_vc_shortcode_output($html = '', $sc_obj = '', $atts = [])
{
    extract($atts);
    //modify shortcode use div as container
    $shortcode_modify = array(
        'vc_section',
        'vc_row',
        'vc_row_inner',
        'vc_column',
        'vc_column_inner'
    );
    $shortcode_name = $sc_obj->getShortcode();
    if (!in_array($shortcode_name, $shortcode_modify))
        return $html;
    //
    $modify = [
        'attrs'       => [], // for add attrs can use string or array
        'before'      => '',
        'after'       => '',
        'first-child' => '',
        'last-child'  => '',
        'full-left'   => '',
        'full-right'  => '',
    ];
    switch ($shortcode_name) {
        //case for $shortcode_modify element
        case 'vc_section':
            $styles = [];
            /* Text Color */
            if (isset($text_color)) $styles[] = 'color:' . $text_color;
            /* Background Color */
            if (isset($bgc_color)) $styles[] = 'background-color:' . $bgc_color;
            /* Add custom style */
            if(!empty($styles)) $modify['attrs']['style'] = implode(';', $styles );

            /* parallax overlay color */
            if (isset($parallax_overlay) && !empty($parallax_overlay)) 
              $modify['first-child'] = '<div class="parallax_overlay" style="background-color:' . esc_attr($parallax_overlay) . '"></div>';
            if(isset($row_close) && !empty($row_close))
                $modify['last-child'] = '<div class="close-row '.melokids_align2().' far fa-times-circle transition"></div>'; 
            break;
        case 'vc_row':
            $styles = [];
            /* Text Color */
            if (isset($text_color) && empty($row_close)) $styles[] = 'color:' . $text_color;
            /* Background Color */

            if (isset($bgc_color) && empty($row_close)) $styles[] = 'background-color:' . $bgc_color;
             
            /* Add custom style */
            if(!empty($styles) ) $modify['attrs']['style'] = implode(';', $styles );
 
            /* parallax overlay color */
            if (isset($parallax_overlay) && !empty($parallax_overlay)) 
              $modify['first-child'] = '<div class="parallax_overlay" style="background-color:' . esc_attr($parallax_overlay) . '"></div>'; 
            //if(isset($row_close) && !empty($row_close))
                //$modify['last-child'] = '<div class="close-row '.melokids_align2().' far fa-times-circle transition"></div>'; //ex: '<div class="d-none">Row last child</div>';
            // row before
            $modify['before'] = ''; //ex: '<div class="d-none">Row Before</div>';
            $modify['after'] = ''; //ex: '<div class="d-none">Row after</div>';

            // full left
            $full_left_align = isset($row_full_image_left_img_align) ? $row_full_image_left_img_align : 'center';
            $full_left_screen = isset($row_full_image_left_img_screen) ? $row_full_image_left_img_screen : 'xl';
            if(isset($row_full_image_left) && $row_full_image_left === 'true' && isset($row_full_image_left_img) && !empty($row_full_image_left_img))
                $modify['full-left'] .= '<div class="row-full-image-left align-items-'.$full_left_align.' row-full-'.$full_left_screen.'">'.melokids_image_by_size(['id'=>$row_full_image_left_img,'size'=>'full','echo' => false]).'</div>';
            // full right
            $full_right_align = isset($row_full_image_right_img_align) ? $row_full_image_right_img_align : 'center';
            $full_right_screen = isset($row_full_image_right_img_screen) ? $row_full_image_right_img_screen : 'xl';
            if(isset($row_full_image_right) && $row_full_image_right === 'true' && isset($row_full_image_right_img) && !empty($row_full_image_right_img))
                $modify['full-right'] .= '<div class="row-full-image-right align-items-'.$full_right_align.' row-full-'.$full_right_screen.'">'.melokids_image_by_size(['id'=>$row_full_image_right_img,'size'=>'full','echo' => false]).'</div>';

            
            break;
        case 'vc_row_inner':
            $styles = [];
            /* Text Color */
            if (isset($text_color) && empty($row_close)) $styles[] = 'color:' . $text_color;
            /* Background Color */
            if (isset($bgc_color) && empty($row_close)) $styles[] = 'background-color:' . $bgc_color;
            /* Add custom style */
            if(!empty($styles)) $modify['attrs']['style'] = implode(';', $styles );

            /* parallax overlay color */
            if (isset($parallax_overlay) && !empty($parallax_overlay))
                $modify['first-child'] = '<div class="parallax_overlay" style="background-color:' . esc_attr($parallax_overlay) . '"></div>';
            //if(isset($row_close) && !empty($row_close))
                //$modify['last-child'] = '<div class="close-row '.melokids_align2().' far fa-times-circle transition"></div>';
            break;
        case 'vc_column':
            $styles = [];
            /* Text Color */
            if (isset($text_color)) $styles[] = 'color:' . $text_color;
            /* Background Color */
            if (isset($bgc_color)) $styles[] = 'background-color:' . $bgc_color;
            /* Add custom style */
            if(!empty($styles)) $modify['attrs']['style'] = implode(';', $styles );

            /* parallax overlay color */
            if (isset($parallax_overlay) && !empty($parallax_overlay)) $modify['first-child'] = '<div class="parallax_overlay" style="background-color:' . esc_attr($parallax_overlay) . '"></div>';
            $modify['last-child'] = ''; //ex: '<div class="d-none">col last child</div>';
            $modify['before'] = ''; //ex: '<div class="d-none">col Before</div>';
            $modify['after'] = ''; //ex: '<div class="d-none">col after</div>';
            break;
        default:
            return $html;
            break;
    }
    // change VC_SECTION
    $html = str_replace('<section', '<div', $html);
    $html = str_replace('</section>', '</div>', $html);
    //begin modify
    if (!empty($modify['attrs'])) {
        if (is_array($modify['attrs'])) {
            $custom_attr_str = [];
            foreach ($modify['attrs'] as $key => $value) {
                $value = esc_attr($value);
                $custom_attr_str[] = "{$key}=\"{$value}\"";
            }
            $custom_attr_str = join(' ', $custom_attr_str);
        } else
            $custom_attr_str = $modify['attrs'];
        $html = '<div ' . $custom_attr_str . substr($html, 4);
    }
    // full left
    if (!empty($modify['full-left'])) {
        $html_exp = explode('>', $html);
        $html_exp[1] = $modify['full-left'] . $html_exp[1];
        $html = join('>', $html_exp);
    }
    // full right 
    if (!empty($modify['full-right'])) {
        $html_exp = explode('</div>', $html);
        if (count($html_exp) > 2) {
            for ($index = count($html_exp) - 1; $index > 0; $index--) {
                if (empty(trim($html_exp[$index - 1])))
                    break;
            }
            $html_exp[$index - 1] .= $modify['full-right'];
            $html = join('</div>', $html_exp);
        } else
            $html = substr($html, 0, -6) . $modify['full-right'] . '</div>';
    }
    // first child
    if (!empty($modify['first-child'])) {
        $html_exp = explode('>', $html);
        $html_exp[1] = $modify['first-child'] . $html_exp[1];
        $html = join('>', $html_exp);
    }
    // last child
    if (!empty($modify['last-child'])) {
        $html_exp = explode('</div>', $html);
        if (count($html_exp) > 2) {
            for ($index = count($html_exp) - 1; $index > 0; $index--) {
                if (empty(trim($html_exp[$index - 1])))
                    break;
            }
            $html_exp[$index - 1] .= $modify['last-child'];
            $html = join('</div>', $html_exp);
        } else
            $html = substr($html, 0, -6) . $modify['last-child'] . '</div>';
    }
    if (!empty($modify['before']))
        $html = $modify['before'] . $html;
    if (!empty($modify['after']))
        $html = $html . $modify['after'];
    return $html;
}

/**
 * Add custom class from custom param to VC Element
 * https://kb.wpbakery.com/docs/filters/vc_shortcodes_css_class/
 *
 */
add_filter('vc_shortcodes_css_class', 'melokids_vc_shortcodes_css_class', 10, 3);
function melokids_vc_shortcodes_css_class($class_string, $tag, $atts = '')
{
    $custom_class = array();
    extract($atts);
    if ($tag = 'vc_section' || $tag == 'vc_row' || $tag == 'vc_row_inner') {
        if (isset($row_priority)) {
            $custom_class[] = $row_priority;
        }
        if (isset($row_stretch_row_content)) {
            $custom_class[] = $row_stretch_row_content;
        }
        if (isset($row_vertical_space)) {
            $custom_class[] = $row_vertical_space;
        }
        if (isset($row_hori_space)) {
            $custom_class[] = $row_hori_space;
        }
        if (isset($parallax_position)) {
            $custom_class[] = $parallax_position;
        }
    }
    if ($tag == 'vc_column' || $tag == 'vc_column_inner') {
        if (isset($col_priority)) {
            $custom_class[] = $col_priority;
        }
        if (isset($col_space)) {
            $custom_class[] = $col_space;
        }
    }
    /* add custom loading delay time for VC Grid */
    if ($tag = 'vc_basic_grid' || $tag = 'vc_masonry_grid' || $tag = 'vc_media_grid' || $tag = 'vc_masonry_media_grid') {
        if (isset($element_width) && $element_width) {
            $custom_class[] = 'zk-iw-' . $element_width;
        }
        if (isset($item) && $item) {
            $custom_class[] = $item;
        }

        if (isset($vcbg_hover) && $vcbg_hover) {
            $custom_class[] = $vcbg_hover;
        }

        if (isset($vcbg_space) && $vcbg_space) {
            $custom_class[] = 'vc_gitem-row-' . $vcbg_space;
        }

        if (isset($delay_time) && $delay_time) {
            $custom_class[] = 'zk-loading-delay-' . $delay_time;
        }

        if (isset($pagination_top_space) && $pagination_top_space) {
            $custom_class[] = 'pagination-top-' . $pagination_top_space;
        }
    }

    $class_string .= ' ' . join(' ', $custom_class);
    return $class_string;
}

add_filter('vc_map_get_attributes','melokids_vc_wp_custommenu_class', 10, 2);
function melokids_vc_wp_custommenu_class($atts, $tag = 'vc_wp_custommenu'){
    $menu_style = isset($atts['menu_style']) ? $atts['menu_style'] : '';
    if(isset($atts['el_class']))
        $atts['el_class'] .= $menu_style;
    else 
        $atts['el_class'] = $menu_style;
    return $atts;
}

/**
 * Add new param text-align to VC param_type font_container
 * Added text-align INHERIT for get default text-align when
 * switch LTR to RTL language
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
add_filter('vc_font_container_output_data', 'melokids_vc_font_container_render_filter', 11, 4);
function melokids_vc_font_container_render_filter($data, $fields, $values, $settings)
{
    if (isset($fields['text_align'])) {
        $data['text_align'] = '
        <div class="vc_row-fluid vc_column">
            <div class="wpb_element_label">' . esc_html__('Text align', 'melokids') . '</div>
            <div class="vc_font_container_form_field-text_align-container">
                <select class="vc_font_container_form_field-text_align-select">
                    <option value="inherit" class="inherit" ' . ('inherit' === $values['text_align'] ? 'selected="selected"' : '') . '>' . esc_html__('Default', 'melokids') . '</option>
                    <option value="left" class="left" ' . ('left' === $values['text_align'] ? 'selected="selected"' : '') . '>' . esc_html__('Left', 'melokids') . '</option>
                    <option value="right" class="right" ' . ('right' === $values['text_align'] ? 'selected="selected"' : '') . '>' . esc_html__('Right', 'melokids') . '</option>
                    <option value="center" class="center" ' . ('center' === $values['text_align'] ? 'selected="selected"' : '') . '>' . esc_html__('center', 'melokids') . '</option>
                    <option value="justify" class="justify" ' . ('justify' === $values['text_align'] ? 'selected="selected"' : '') . '>' . esc_html__('Justify', 'melokids') . '</option>
                </select>
            </div>';
        if (isset($fields['text_align_description']) && strlen($fields['text_align_description']) > 0) {
            $data['text_align'] .= '
            <span class="vc_description clear">' . $fields['text_align_description'] . '</span>
            ';
        }
        $data['text_align'] .= '</div>';
    }
    return $data;
}

/**
 *
 * Custom  VC Section
 *
 */
vc_add_params('vc_section', array(
    array(
        'type'        => 'checkbox',
        'heading'     => esc_html__('Add close icon', 'melokids'),
        'param_name'  => 'row_close',
        'value'       => array(
            esc_html__('Add close icon to top right corner of this', 'melokids')      => 'true',
        ),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Section Priority', 'melokids'),
        'param_name'  => 'row_priority',
        'value'       => array(
            esc_html__('Default', 'melokids')      => '',
            esc_html__('On Top', 'melokids')       => 'ontop',
            esc_html__('Fixed Bottom', 'melokids') => 'fixed-b'
        ),
        'description' => esc_html__('Choose priority for this row', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Top/Bottom Space', 'melokids'),
        'param_name'  => 'row_vertical_space',
        'value'       => melokids_vc_row_vert_space(),
        'description' => esc_html__('Choose top/bottom space for this', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__('Text Color', 'melokids'),
        'param_name'  => 'text_color',
        'description' => esc_html__('Choose color for this', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'             => 'colorpicker',
        'heading'          => esc_html__('Overlay Color', 'melokids'),
        'param_name'       => 'parallax_overlay',
        'value'            => '',
        'description'      => esc_html__('Choose overlay color.', 'melokids'),
        'edit_field_class' => 'vc_col-sm-4',
        'group'            => esc_html__('Parallax', 'melokids')
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Parallax Position', 'melokids'),
        'param_name'  => 'parallax_position',
        'value'       => array(
            esc_html__('Default', 'melokids') => '',
            esc_html__('Center', 'melokids')  => 'parallax-center',
        ),
        'description' => esc_html__('Parallax image position', 'melokids'),
        'dependency'  => array(
            'element' => 'parallax',
            'value'   => array(
                'content-moving',
                'content-moving-fade'
            )
        ),
        'group'       => esc_html__('Parallax', 'melokids')
    ),
));

/**
 *
 * Custom  VC Row
 *
 */
vc_add_params('vc_row', array(
    array(
        'type'        => 'checkbox',
        'heading'     => esc_html__('Add close icon', 'melokids'),
        'param_name'  => 'row_close',
        'value'       => array(
            esc_html__('Add close icon to top right corner of this', 'melokids')      => 'true',
        ),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Priority', 'melokids'),
        'param_name'  => 'row_priority',
        'value'       => array(
            esc_html__('Default', 'melokids')      => '',
            esc_html__('On Top', 'melokids')       => 'ontop',
            esc_html__('Fixed Bottom', 'melokids') => 'fixed-b'
        ),
        'description' => esc_html__('Choose priority for this', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Full Width Stretch Content Style', 'melokids'),
        'param_name'  => 'row_stretch_row_content',
        'dependency'  => array(
            'element' => 'full_width',
            'value'   => array(
                'stretch_row_content'
            )
        ),
        'value'       => melokids_fullwidth_stretch_row_space(),
        'description' => esc_html__('Choose Left/Right space for full width stretch content', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Vertical Space', 'melokids'),
        'param_name'  => 'row_vertical_space',
        'value'       => melokids_vc_row_vert_space(),
        'description' => esc_html__('Choose vertical space for this', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Horizontal Space', 'melokids'),
        'param_name'  => 'row_hori_space',
        'value'       => melokids_vc_row_hori_space(),
        'description' => esc_html__('Choose Horizontal space for this', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__('Text Color', 'melokids'),
        'param_name'  => 'text_color',
        'description' => esc_html__('Choose color for this', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__('Background Color', 'melokids'),
        'param_name'  => 'bgc_color',
        'description' => esc_html__('Choose background color for this. NOTE: this option will be overide if you use custom background color in Design Options tab.', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'             => 'colorpicker',
        'heading'          => esc_html__('Overlay Color', 'melokids'),
        'param_name'       => 'parallax_overlay',
        'value'            => '',
        'description'      => esc_html__('Choose overlay color.', 'melokids'),
        'edit_field_class' => 'vc_col-sm-4',
        'group'            => esc_html__('Parallax', 'melokids')
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Parallax Position', 'melokids'),
        'param_name'  => 'parallax_position',
        'value'       => array(
            esc_html__('Default', 'melokids') => '',
            esc_html__('Center', 'melokids')  => 'parallax-center',
        ),
        'description' => esc_html__('Parallax image position', 'melokids'),
        'dependency'  => array(
            'element' => 'parallax',
            'value'   => array(
                'content-moving',
                'content-moving-fade'
            )
        ),
        'group'       => esc_html__('Parallax', 'melokids')
    ),
));
/**
 *
 * Custom  VC Row Inner
 *
 */
vc_add_params('vc_row_inner', array(
    array(
        'type'        => 'checkbox',
        'heading'     => esc_html__('Add close icon', 'melokids'),
        'param_name'  => 'row_close',
        'value'       => array(
            esc_html__('Add close icon to top right corner of this', 'melokids')      => 'true',
        ),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Priority', 'melokids'),
        'param_name'  => 'row_priority',
        'value'       => array(
            esc_html__('Default', 'melokids')      => '',
            esc_html__('On Top', 'melokids')       => 'ontop',
            esc_html__('Fixed Bottom', 'melokids') => 'fixed-b'
        ),
        'description' => esc_html__('Choose priority for this', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Vertical Space', 'melokids'),
        'param_name'  => 'row_vertical_space',
        'value'       => melokids_vc_row_vert_space(),
        'std'         => 'vs-0',
        'description' => esc_html__('Choose vertical space for this', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Horizontal Space', 'melokids'),
        'param_name'  => 'row_hori_space',
        'value'       => melokids_vc_row_hori_space(),
        'description' => esc_html__('Choose horizontal space for this', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids'),
    ),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__('Text Color', 'melokids'),
        'param_name'  => 'text_color',
        'description' => esc_html__('Choose color for this', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'             => 'colorpicker',
        'heading'          => esc_html__('Overlay Color', 'melokids'),
        'param_name'       => 'parallax_overlay',
        'value'            => '',
        'description'      => esc_html__('Choose overlay color.', 'melokids'),
        'edit_field_class' => 'vc_col-sm-12',
        'group'            => esc_html__('Design Options', 'melokids')
    ),
));
/**
 *
 * Custom  VC Column
 *
 */
vc_add_params('vc_column', array(
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Column Priority', 'melokids'),
        'param_name'  => 'col_priority',
        'value'       => array(
            esc_html__('Default', 'melokids') => '',
            esc_html__('On Top', 'melokids')  => 'ontop'
        ),
        'description' => esc_html__('Choose priority for this column', 'melokids'),
        'edit_field_class' => 'vc_col-sm-6',
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'             => 'dropdown',
        'heading'          => esc_html__('Column Space', 'melokids'),
        'param_name'       => 'col_space',
        'value'            => melokids_vc_column_space(),
        'description'      => esc_html__('Choose custom column space for this column', 'melokids'),
        'edit_field_class' => 'vc_col-sm-6',
        'group'            => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'        => 'colorpicker',
        'heading'     => esc_html__('Text Color', 'melokids'),
        'param_name'  => 'text_color',
        'description' => esc_html__('Choose color for this', 'melokids'),
        'edit_field_class' => 'vc_col-sm-6',
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    ),
    array(
        'type'             => 'colorpicker',
        'heading'          => esc_html__('Overlay Color', 'melokids'),
        'param_name'       => 'parallax_overlay',
        'value'            => '',
        'description'      => esc_html__('Choose overlay color.', 'melokids'),
        'edit_field_class' => 'vc_col-sm-4',
        'group'            => esc_html__('Parallax', 'melokids')
    ),
));

/**
 * Custom VC Basic Grid
 * add delay time on loading
 */
vc_add_params('vc_basic_grid', array(
    array(
        'type'        => 'textfield',
        'param_name'  => 'delay_time',
        'value'       => '3000',
        'save_always' => true,
        'heading'     => esc_html__('Loading Delay', 'melokids'),
        'description' => esc_html__('Enter delay time in milisecond', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    )
));

/**
 * Custom VC Media Grid
 * add delay time on loading
 */
vc_add_params('vc_media_grid', array(
    array(
        'type'        => 'textfield',
        'param_name'  => 'delay_time',
        'value'       => '3000',
        'save_always' => true,
        'heading'     => esc_html__('Loading Delay', 'melokids'),
        'description' => esc_html__('Enter delay time in milisecond', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    )
));

/**
 * Custom VC Masonry Grid
 * add delay time on loading
 */
vc_add_params('vc_masonry_grid', array(
    array(
        'type'        => 'textfield',
        'param_name'  => 'delay_time',
        'value'       => '3000',
        'save_always' => true,
        'heading'     => esc_html__('Loading Delay', 'melokids'),
        'description' => esc_html__('Enter delay time in milisecond', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    )
));

/**
 * Custom VC Masonry Media Grid
 * add delay time on loading
 */
vc_add_params('vc_masonry_media_grid', array(
    array(
        'type'        => 'textfield',
        'param_name'  => 'delay_time',
        'value'       => '3000',
        'save_always' => true,
        'heading'     => esc_html__('Loading Delay', 'melokids'),
        'description' => esc_html__('Enter delay time in milisecond', 'melokids'),
        'group'       => esc_html__('MeloKids Custom', 'melokids')
    )
));

/**
 * Custom VC WordPress Menu
 * add menu style options
*/
vc_add_params('vc_wp_custommenu', array(
    array(
        'type'       => 'dropdown',
        'param_name' => 'menu_style',
        'value'      => array(
            esc_html__('Default', 'melokids')          => '',
            esc_html__('Mega Menu', 'melokids')        => 'megamenu',
            esc_html__('Horizontal Small', 'melokids') => 'hori small',
            esc_html__('Horizontal Large', 'melokids') => 'hori',
        ),
        'heading' => esc_html__('Choose Menu Style','melokids'),
        'group'   => esc_html__('MeloKids Custom', 'melokids')
    )
)); 

/* VC WP Custom Menu 
 * change menu id to slug
*/
$custom_menus = array();
if ( 'vc_edit_form' === vc_post_param( 'action' ) && vc_verify_admin_nonce() ) {
    $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
    if ( is_array( $menus ) && ! empty( $menus ) ) {
        foreach ( $menus as $single_menu ) {
            if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->slug ) ) {
                $custom_menus[ $single_menu->name ] = $single_menu->slug;
            }
        }
    }
}
vc_add_param('vc_wp_custommenu', array(
    'type'        => 'dropdown',
    'heading'     => esc_html__( 'Menu', 'melokids' ),
    'param_name'  => 'nav_menu',
    'value'       => $custom_menus,
    'description' => empty( $custom_menus ) ? esc_html__( 'Custom menus not found. Please visit <b>Appearance > Menus</b> page to create new menu.', 'melokids' ) : esc_html__( 'Select menu to display.', 'melokids' ),
    'admin_label' => true,
    'save_always' => true,
));


/**
 * CUSTOM VC PARAMS and Style
 * New style, shape, color, ...
 * @source : https://kb.wpbakery.com/docs/developers-how-tos/update-single-param-values/
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
add_action('vc_after_init', 'melokids_vc_custom_params');
function melokids_vc_custom_params()
{
    /**
     * Add new value to single param
     * Use
     * $param = WPBMap::getParam('SHORTCODE_NAME', 'PARAM_NAME');
     * $param['value'][esc_html__('Value Title', 'melokids')] = 'value';
     * vc_update_shortcode_param('SHORTCODE_NAME', $param);
     **/
    /*
     * VC SECTION 
     * New parallax style
     * Move parallax option to new group
    */
    $param = WPBMap::getParam('vc_section', 'parallax');
    $param['value'][esc_html__('Fixed', 'melokids')] = 'fixed';
    $param['value'][esc_html__('Scroll Left', 'melokids')] = 'scroll-left';
    $param['value'][esc_html__('Scroll Bottom Right', 'melokids')] = 'scroll-br';
    $param['group'] = esc_html__('Parallax', 'melokids');
    vc_update_shortcode_param('vc_section', $param);

    $param = WPBMap::getParam('vc_section', 'parallax_image');
    $param['group'] = esc_html__('Parallax', 'melokids');
    $param['edit_field_class'] = 'vc_col-sm-6';
    vc_update_shortcode_param('vc_section', $param);

    $param = WPBMap::getParam('vc_section', 'parallax_speed_bg');
    $param['group'] = esc_html__('Parallax', 'melokids');
    $param['edit_field_class'] = 'vc_col-sm-6';
    vc_update_shortcode_param('vc_section', $param);

    $param = WPBMap::getParam('vc_section', 'video_bg_parallax');
    $param['group'] = esc_html__('Parallax', 'melokids');
    $param['edit_field_class'] = 'vc_col-sm-6';
    vc_update_shortcode_param('vc_section', $param);

    $param = WPBMap::getParam('vc_section', 'parallax_speed_video');
    $param['group'] = esc_html__('Parallax', 'melokids');
    $param['edit_field_class'] = 'vc_col-sm-6';
    vc_update_shortcode_param('vc_section', $param);

    /*
     * VC ROW 
     * New parallax style
     * Move parallax option to new group
     * New Gap
    */

    $param = WPBMap::getParam('vc_row', 'parallax');
    $param['value'][esc_html__('Fixed', 'melokids')] = 'fixed';
    $param['value'][esc_html__('Scroll Left', 'melokids')] = 'scroll-left';
    $param['value'][esc_html__('Scroll Bottom Right', 'melokids')] = 'scroll-br';
    $param['group'] = esc_html__('Parallax', 'melokids');
    vc_update_shortcode_param('vc_row', $param);

    $param = WPBMap::getParam('vc_row', 'parallax_image');
    $param['group'] = esc_html__('Parallax', 'melokids');
    $param['edit_field_class'] = 'vc_col-sm-6';
    vc_update_shortcode_param('vc_row', $param);

    $param = WPBMap::getParam('vc_row', 'parallax_speed_bg');
    $param['group'] = esc_html__('Parallax', 'melokids');
    $param['edit_field_class'] = 'vc_col-sm-6';
    vc_update_shortcode_param('vc_row', $param);

    $param = WPBMap::getParam('vc_row', 'video_bg_parallax');
    $param['group'] = esc_html__('Parallax', 'melokids');
    $param['edit_field_class'] = 'vc_col-sm-6';
    vc_update_shortcode_param('vc_row', $param);

    $param = WPBMap::getParam('vc_row', 'parallax_speed_video');
    $param['group'] = esc_html__('Parallax', 'melokids');
    $param['edit_field_class'] = 'vc_col-sm-6';
    vc_update_shortcode_param('vc_row', $param);
    /* Gap */

    $param = WPBMap::getParam('vc_row', 'gap');
    $param['value']['40px'] = '40';
    $param['value']['50px'] = '50';
    $param['value']['60px'] = '60';
    $param['value']['70px'] = '70';
    $param['value']['80px'] = '80';
    $param['value']['90px'] = '90';
    $param['value']['100px'] = '100';
    vc_update_shortcode_param('vc_row', $param);

    /*
     * VC Row Inner
     * New Gap
    */
    /* Gap */
    $param = WPBMap::getParam('vc_row_inner', 'gap');
    $param['value']['40px'] = '40';
    $param['value']['50px'] = '50';
    $param['value']['60px'] = '60';
    $param['value']['70px'] = '70';
    $param['value']['80px'] = '80';
    $param['value']['90px'] = '90';
    $param['value']['100px'] = '100';
    vc_update_shortcode_param('vc_row_inner', $param);

    /*
     * VC Column 
     * Move parallax option to new group
    */
    $param = WPBMap::getParam('vc_column', 'parallax');
    $param['value'][esc_html__('Fixed', 'melokids')] = 'fixed';
    $param['value'][esc_html__('Scroll Left', 'melokids')] = 'scroll-left';
    $param['group'] = esc_html__('Parallax', 'melokids');
    vc_update_shortcode_param('vc_column', $param);

    $param = WPBMap::getParam('vc_column', 'parallax_image');
    $param['group'] = esc_html__('Parallax', 'melokids');
    $param['edit_field_class'] = 'vc_col-sm-4';
    vc_update_shortcode_param('vc_column', $param);

    $param = WPBMap::getParam('vc_column', 'parallax_speed_bg');
    $param['group'] = esc_html__('Parallax', 'melokids');
    $param['edit_field_class'] = 'vc_col-sm-4';
    vc_update_shortcode_param('vc_column', $param);
    
    /**
     * VC Icon
     * add custom icon font
     */
    $param = WPBMap::getParam('vc_icon', 'type');
    $param['value'][esc_html__('Themify Icons', 'melokids')] = 'themify';
    vc_update_shortcode_param('vc_icon', $param);

    /**
     * VC Custom Heading
     * Change text-align to inherit
     * Change font style to theme default
     **/
    $param = WPBMap::getParam('vc_custom_heading', 'font_container');
    $param['value'] = 'tag:h2|text_align:inherit';
    vc_update_shortcode_param('vc_custom_heading', $param);

    $param = WPBMap::getParam('vc_custom_heading', 'use_theme_fonts');
    $param['std'] = 'yes';
    vc_update_shortcode_param('vc_custom_heading', $param);

    /**
     * VC Masonry Media Grid
     */
    /* General: Grid elements per row */
    $param = WPBMap::getParam('vc_masonry_media_grid', 'element_width');
    $param['value']['masonry'] = 'masonry';
    vc_update_shortcode_param('vc_masonry_media_grid', $param);
    /* Load more button: Style  */
    $param = WPBMap::getParam('vc_masonry_media_grid', 'btn_style');
    $param['value'][esc_html__('[MeloKids] Default', 'melokids')] = 'melokids btn';
    $param['value'][esc_html__('[MeloKids] Default Alt', 'melokids')] = 'melokids btn btn-alt';
    $param['std'] = 'melokids btn';
    $param['save_always'] = true;
    vc_update_shortcode_param('vc_masonry_media_grid', $param);
    /* Load more button: Shape  */
    $param = WPBMap::getParam('vc_masonry_media_grid', 'btn_shape');
    $param['dependency'] = array(
        'element'            => 'btn_style',
        'value_not_equal_to' => array(
            'melokids btn',
            'melokids btn btn-alt'
        )
    );
    vc_update_shortcode_param('vc_masonry_media_grid', $param);
    /* Load more button: Color  */
    $param = WPBMap::getParam('vc_masonry_media_grid', 'btn_color');
    $param['dependency'] = array(
        'element'            => 'btn_style',
        'value_not_equal_to' => array(
            'melokids btn',
            'melokids btn btn-alt'
        )
    );
    vc_update_shortcode_param('vc_masonry_media_grid', $param);
}

/*
 * Grid Settings 
*/
function melokids_grid_settings(array $args = array())
{
    extract($arr = array_merge(array(
        'group'      => '',
        'param_name' => '',
        'value'      => ''
    ), $args));
    $raw_params = array(
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Small Screen', 'melokids'),
            'param_name'       => 'col_sm',
            'edit_field_class' => 'vc_col-sm-3 vc_carousel_item',
            'value'            => array(1, 2, 3, 4, 6, 12),
            'std'              => 1,
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Medium Screen', 'melokids'),
            'param_name'       => 'col_md',
            'edit_field_class' => 'vc_col-sm-3 vc_carousel_item',
            'value'            => array(1, 2, 3, 4, 6, 12),
            'std'              => 2,
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Large Screen', 'melokids'),
            'param_name'       => 'col_lg',
            'edit_field_class' => 'vc_col-sm-3 vc_carousel_item',
            'value'            => array(1, 2, 3, 4, 6, 12),
            'std'              => 3,
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Extra Large Screen', 'melokids'),
            'param_name'       => 'col_xl',
            'edit_field_class' => 'vc_col-sm-3 vc_carousel_item',
            'value'            => array(1, 2, 3, 4, 6, 12),
            'std'              => 4,
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        )
    );
    $params = [];
    foreach ($raw_params as $param) {
        if (!empty($param['dependency']) && empty($param['dependency']['element']))
            unset($param['dependency']);
        $params[] = $param;
    }
    return $params;
}

/* OWL Carousel Setting
 * All option will use in element use OWL Carousel Libs
*/
function melokids_owl_settings(array $args = array())
{
    extract($arr = array_merge(array(
        'group'      => '',
        'param_name' => '',
        'value'      => ''
    ), $args));
    $raw_params = array(
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Small Screen', 'melokids'),
            'param_name'       => 'owl_sm_items',
            'edit_field_class' => 'vc_col-sm-3 vc_carousel_item',
            'value'            => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
            'std'              => 1,
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Medium Screen', 'melokids'),
            'param_name'       => 'owl_md_items',
            'edit_field_class' => 'vc_col-sm-3 vc_carousel_item',
            'value'            => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
            'std'              => 2,
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Large Screen', 'melokids'),
            'param_name'       => 'owl_lg_items',
            'edit_field_class' => 'vc_col-sm-3 vc_carousel_item',
            'value'            => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
            'std'              => 3,
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Extra Large Screen', 'melokids'),
            'param_name'       => 'owl_xl_items',
            'edit_field_class' => 'vc_col-sm-3 vc_carousel_item',
            'value'            => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12),
            'std'              => 4,
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Number Row', 'melokids'),
            'description' => esc_html__('Choose number of row you want to show.', 'melokids'),
            'param_name'  => 'number_row',
            'value'       => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
            'std'         => 1,
            'dependency'  => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'       => $group,
        ),

        array(
            'type'             => 'checkbox',
            'heading'          => esc_html__('Loop Items', 'melokids'),
            'param_name'       => 'loop',
            'std'              => 'false',
            'edit_field_class' => 'vc_col-sm-3 vc_carousel_item',
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
        array(
            'type'             => 'checkbox',
            'heading'          => esc_html__('Center', 'melokids'),
            'param_name'       => 'center',
            'std'              => 'false',
            'edit_field_class' => 'vc_col-sm-3 vc_carousel_item',
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
        array(
            'type'             => 'checkbox',
            'heading'          => esc_html__('Auto Width', 'melokids'),
            'param_name'       => 'autowidth',
            'std'              => 'false',
            'edit_field_class' => 'vc_col-sm-3 vc_carousel_item',
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
        array(
            'type'             => 'checkbox',
            'heading'          => esc_html__('Auto Height', 'melokids'),
            'param_name'       => 'autoheight',
            'std'              => 'true',
            'edit_field_class' => 'vc_col-sm-3 vc_carousel_item',
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),

        array(
            'type'             => 'textfield',
            'heading'          => esc_html__('Items Space', 'melokids'),
            'param_name'       => 'margin',
            'value'            => 30,
            'edit_field_class' => 'vc_col-sm-4 vc_carousel_item',
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
        array(
            'type'             => 'textfield',
            'heading'          => esc_html__('Stage Padding', 'melokids'),
            'param_name'       => 'stagepadding',
            'value'            => '0',
            'edit_field_class' => 'vc_col-sm-4 vc_carousel_item',
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),

        array(
            'type'             => 'textfield',
            'heading'          => esc_html__('Start Position', 'melokids'),
            'param_name'       => 'startposition',
            'value'            => '0',
            'edit_field_class' => 'vc_col-sm-4 vc_carousel_item',
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),

        array(
            'type'       => 'checkbox',
            'param_name' => 'nav',
            'value'      => array(
                esc_html__('Show Next/Preview button', 'melokids') => 'true'
            ),
            'std'        => 'false',
            'dependency' => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'      => $group
        ),
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Nav Style', 'melokids'),
            'param_name'       => 'nav_style',
            'value'            => melokids_carousel_nav_style(),
            'std'              => '',
            'dependency'       => array(
                'element' => 'nav',
                'value'   => 'true',
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_carousel_item',
            'group'            => $group
        ),
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Nav Position', 'melokids'),
            'param_name'       => 'nav_pos',
            'value'            => melokids_carousel_nav_pos(),
            'std'              => '',
            'dependency'       => array(
                'element'            => 'nav_style',
                'value_not_equal_to' => array('1'),
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_carousel_item',
            'group'            => $group
        ),
        array(
            'type'       => 'checkbox',
            'value'      => array(
                esc_html__('Show Dots', 'melokids') => 'true'
            ),
            'param_name' => 'dots',
            'std'        => 'true',
            'dependency' => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'      => $group
        ),
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Dots Style', 'melokids'),
            'param_name'       => 'dot_style',
            'value'            => melokids_carousel_dots_style(),
            'std'              => '',
            'dependency'       => array(
                'element' => 'dots',
                'value'   => 'true',
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_carousel_item',
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Dots Position', 'melokids'),
            'param_name'       => 'dot_pos',
            'value'            => melokids_carousel_dot_pos(),
            'std'              => '',
            'dependency'       => array(
                'element' => 'dots',
                'value'   => array('true'),
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_carousel_item',
            'group'            => $group
        ),

        array(
            'type'       => 'checkbox',
            'value'      => array(
                esc_html__('Auto Play', 'melokids') => 'true'
            ),
            'param_name' => 'autoplay',
            'std'        => 'true',
            'dependency' => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'      => $group
        ),
        array(
            'type'             => 'textfield',
            'heading'          => esc_html__('Smart Speed', 'melokids'),
            'param_name'       => 'smartspeed',
            'value'            => '250',
            'description'      => esc_html__('Speed scroll of each item', 'melokids'),
            'edit_field_class' => 'vc_col-sm-4 vc_carousel_item',
            'dependency'       => array(
                'element' => 'autoplay',
                'value'   => 'true',
            ),
            'group'            => $group
        ),
        array(
            'type'             => 'textfield',
            'heading'          => esc_html__('Auto Play TimeOut', 'melokids'),
            'param_name'       => 'autoplaytimeout',
            'value'            => '5000',
            'dependency'       => array(
                'element' => 'autoplay',
                'value'   => 'true',
            ),
            'edit_field_class' => 'vc_col-sm-4 vc_carousel_item',
            'group'            => $group
        ),
        array(
            'type'             => 'checkbox',
            'heading'          => esc_html__('Pause on mouse hover', 'melokids'),
            'param_name'       => 'autoplayhoverpause',
            'std'              => 'true',
            'dependency'       => array(
                'element' => 'autoplay',
                'value'   => 'true',
            ),
            'edit_field_class' => 'vc_col-sm-4 vc_carousel_item',
            'group'            => $group
        ),
        array(
            'type'             => 'animation_style',
            'class'            => '',
            'heading'          => esc_html__('Animation In', 'melokids'),
            'param_name'       => 'owlanimation_in',
            'std'              => '',
            'settings'         => array(
                'type' => array(
                    'in'
                ),
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_carousel_item',
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
        array(
            'type'             => 'animation_style',
            'class'            => '',
            'heading'          => esc_html__('Animation Out', 'melokids'),
            'param_name'       => 'owlanimation_out',
            'std'              => '',
            'settings'         => array(
                'type' => array(
                    'out'
                ),
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_carousel_item',
            'dependency'       => array(
                'element' => $param_name,
                'value'   => $value,
            ),
            'group'            => $group
        ),
    );
    $params = [];
    foreach ($raw_params as $param) {
        if (!empty($param['dependency']) && empty($param['dependency']['element']))
            unset($param['dependency']);
        $params[] = $param;
    }
    return $params;
}

/**
 * OWL Nav & Dots
 * Nav Position melokids_carousel_nav_pos(),
 * Nav Style melokids_carousel_nav_style(),
 * Dot style melokids_carousel_dots_style()
 */
function melokids_carousel_nav_pos()
{
    $carousel_nav_pos = array(
        esc_html__('Default', 'melokids')          => '',
        esc_html__('Vertical Inside', 'melokids')  => 'nav-vertical inside',
        esc_html__('Vertical Outside', 'melokids') => 'nav-vertical outside',
    );
    return $carousel_nav_pos;
}

function melokids_carousel_nav_style()
{
    $carousel_nav_style = array(
        esc_html__('Default', 'melokids')     => '',
        esc_html__('Dots In Nav', 'melokids') => '1',
    );
    return $carousel_nav_style;
}

function melokids_carousel_dots_style()
{
    $carousel_dots_style = array(
        esc_html__('Default', 'melokids')   => '',
        esc_html__('Thumbnail', 'melokids') => 'dots-thumbnail',
        esc_html__('Progress', 'melokids')  => 'dots-progress',
    );
    return $carousel_dots_style;
}

function melokids_carousel_dot_pos()
{
    return array(
        esc_html__('Default', 'melokids') => '',
        esc_html__('Top', 'melokids')     => '1',
    );
}

function melokids_owl_preload($layout_type)
{
    if ($layout_type !== 'carousel') return;
    ?>
    <div class="owl-preload"><?php 
        melokids_spin_circle_loading();
    ?></div>
    <?php
}

function melokids_owl_nav($layout_type, $nav_style, $nav_pos)
{
    if ($layout_type === 'carousel') :
        if ($nav_style !== '1'): ?>
            <div class="<?php echo trim(implode(' ', array('owl-nav', $nav_pos))); ?>"></div>
        <?php endif;
    endif;
}

function melokids_owl_dots($layout_type, $dot_style, $dot_pos)
{
    if ($layout_type === 'carousel') :
        if ($dot_pos !== '1'): ?>
            <div class="<?php echo trim(implode(' ', array('owl-dots', $dot_style))); ?>"></div>
        <?php endif;
    endif;
}

function melokids_owl_dots_in_nav($layout_type, $nav_style)
{
    if ($layout_type === 'carousel' && $nav_style === '1') :
        ?>
        <div class="owl-nav-wrap">
            <div class="owl-dots-wrap"></div>
        </div>
    <?php endif;
}

function melokids_owl_dots_top($layout_type, $nav_style, $dot_pos, $dot_style)
{
    if($nav_style === '1') return;
    if ($layout_type === 'carousel' && $dot_pos === '1') echo '<div class="owl-dots top ' . $dot_style . '"></div>';
}

/* Call OWL Settings */
function melokids_owl_call_settings($atts)
{
    extract($atts);
    if ($layout_type !== 'carousel') return;
    wp_enqueue_script('vc_pageable_owl-carousel');
    wp_enqueue_script('zk-owlcarousel');
    wp_enqueue_style('vc_pageable_owl-carousel-css');
    /* Carousel Settings */
    $icon_prev = is_rtl() ? 'right' : 'left';
    $icon_next = is_rtl() ? 'left' : 'right';
    if ($layout_type === 'carousel' && $nav_style === '1'){
        $navContainer = '.' . $el_id . ' .owl-nav-wrap';
        $dotsContainer = '.' . $el_id . ' .owl-dots-wrap';
    } else {
        $navContainer = '.' . $el_id . ' .owl-nav';
        $dotsContainer = '.' . $el_id . ' .owl-dots';
    }
    

    $nav_icon = array('<i class="fa fa-angle-' . $icon_prev . '" data-title="' . esc_attr__('Prev', 'melokids') . '"></i>', '<i class="fa fa-angle-' . $icon_next . '" data-title="' . esc_attr__('Next', 'melokids') . '"></i>');
    $rtl = is_rtl() ? true : false;
    $dotsData = false;

    /* Dots Style */
    if ($dot_style === 'dots-thumbnail') {
        $dotsData = true;
    }
    global $zkcarousel;
    $zkcarousel[$el_id] = array(
        'rtl'                => $rtl,
        'margin'             => (int)$margin,
        'loop'               => $loop,
        'center'             => $center,
        'stagePadding'       => (int)$stagepadding,
        'autoWidth'          => $autowidth,
        'startPosition'      => (int)$startposition,
        'nav'                => $nav,
        'navContainer'       => $navContainer,
        'navText'            => $nav_icon,
        'dots'               => $dots,
        'dotsContainer'      => $dotsContainer,
        'dotsData'           => $dotsData,
        'autoplay'           => $autoplay,
        'autoplayTimeout'    => (int)$autoplaytimeout,
        'autoplayHoverPause' => $autoplayhoverpause,
        'smartSpeed'         => (int)$smartspeed,
        'autoHeight'         => $autoheight,
        'animateIn'          => $owlanimation_in,
        'animateOut'         => $owlanimation_out,
        'responsiveClass'    => true,
        'slideBy'            => 'page',
        'responsive'         => array(
            0    => array(
                'items' => (int)$owl_sm_items,
            ),
            768  => array(
                'items' => (int)$owl_md_items,
            ),
            992  => array(
                'items' => (int)$owl_lg_items,
            ),
            1200 => array(
                'items' => (int)$owl_xl_items,
            )
        )
    );
    wp_localize_script('vc_pageable_owl-carousel', 'zkcarousel', $zkcarousel);
}

/* Call Masonry Settings */
function melokids_masonry_call_settings($atts)
{
    extract($atts);
    if ($layout_type !== 'masonry') return;
    wp_enqueue_script('jquery-masonry');
}

/**
 * Icon font libs
 *
 * Add default VC Icon
 * add new icon from theme
 *
 * Themify Icon
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
function melokids_icon_libs($args = array())
{
    $args = wp_parse_args($args, array(
        'group'        => esc_html__('Icon', 'melokids'),
        'field_prefix' => 'i_',
        'dependency'   => 'add_icon'
    ));
    extract($args);
    require_once vc_path_dir('CONFIG_DIR', 'content/vc-icon-element.php');
    /**
     * @source
     * vc_map_integrate_shortcode( $shortcode, $field_prefix = '', $group_prefix = '', $change_fields = null, $dependency = null )
     **/
    $icons_params = vc_map_integrate_shortcode(vc_icon_element_params(), $field_prefix, $group, array(
        'include_only_regex' => '/^(type|icon_\w*)/',
        // we need only type, icon_fontawesome, icon_blabla..., NOT color and etc
    ), array(
        'element' => $dependency,
        'value'   => 'true',
    ));

    // populate integrated vc_icons params.
    if (is_array($icons_params) && !empty($icons_params)) {
        foreach ($icons_params as $key => $param) {
            if (is_array($param) && !empty($param)) {
                if ($field_prefix . 'type' === $param['param_name']) {
                    /* append melokids icon to dropdown 
                     * use: 
                     * $icons_params[ $key ]['value'][ esc_html__( 'Themify Icon', 'melokids' ) ] = 'themify';
                     * 
                    */
                    $icons_params[$key]['value'][esc_html__('Themify Icon', 'melokids')] = 'themify';
                    /* Change default font icon
                     * $icons_params[ $key ]['std'] = 'fontawesome';
                    */

                }
                if (isset($param['admin_label'])) {
                    /*remove admin label*/
                    unset($icons_params[$key]['admin_label']);
                }
            }
        }
    }
    return $icons_params;
}

function melokids_icon_libs_icon($args = array())
{
    $args = wp_parse_args($args, array(
        'group'        => esc_html__('Icon', 'melokids'),
        'field_prefix' => 'i_',
    ));
    extract($args);
    return array(
        /* Theme Icons */
        array(
            'type'        => 'iconpicker',
            'heading'     => esc_html__('Icon', 'melokids'),
            'param_name'  => $field_prefix . 'icon_themify',
            'value'       => 'ti-arrow-up',
            'settings'    => array(
                'emptyIcon'    => false,
                'type'         => 'themify',
                'iconsPerPage' => 100,
            ),
            'dependency'  => array(
                'element' => $field_prefix . 'type',
                'value'   => 'themify',
            ),
            'description' => esc_html__('Select icon from library.', 'melokids'),
            'group'       => $group
        )
    );
}

/**
 * Register icons for Visual Composer
 */
function melokids_vc_icon_fonts_register()
{
    wp_register_style('font-themify', get_template_directory_uri() . '/vc_customs/themify-icons/font-themify.min.css', array(), wp_get_theme()->get('Version'));
}

add_action('wp_enqueue_scripts', 'melokids_vc_icon_fonts_register');
add_action('admin_enqueue_scripts', 'melokids_vc_icon_fonts_register');

/**
 * Enqueues icons for Visual Composer
 */
function melokids_vc_icon_fonts_enqueue()
{
    wp_enqueue_style('font-themify');
}

add_action('vc_backend_editor_enqueue_js_css', 'melokids_vc_icon_fonts_enqueue');
add_action('vc_frontend_editor_enqueue_js_css', 'melokids_vc_icon_fonts_enqueue');

/**
 * Call icons for Visual Composer
 */
add_action('vc_enqueue_font_icon_element', 'melokids_vc_icon_font');
function melokids_vc_icon_font($font)
{
    switch ($font) {
        case 'themify':
            wp_enqueue_style('font-themify');
            break;
    }
}

/* Load new icon font */
melokids_require_folder('vc_customs/themify-icons', get_template_directory());


function melokids_btn_types()
{
    return array(
        esc_html__('Default', 'melokids')     => 'zk-btn',
        esc_html__('Primary', 'melokids')     => 'zk-btn-primary',
        esc_html__('Default Alt', 'melokids') => 'zk-btn zk-btn-alt',
        esc_html__('Primary Alt', 'melokids') => 'zk-btn-primary zk-btn-alt',
        esc_html__('White', 'melokids')       => 'zk-btn zk-btn-white',
        esc_html__('Alt White', 'melokids')   => 'zk-btn zk-btn-white zk-btn-alt',
        esc_html__('Simple Link', 'melokids') => 'simple',
    );
}

function melokids_btn_size()
{
    return array(
        esc_html__('Default', 'melokids')     => '',
        esc_html__('Small', 'melokids')       => 'zk-btn-sm',
        esc_html__('Medium', 'melokids')      => 'zk-btn-md',
        esc_html__('Large', 'melokids')       => 'zk-btn-lg',
        esc_html__('Extra Large', 'melokids') => 'zk-btn-xl',
    );
}

/**
 * List of thumbnails size
 * @since 1.0.0
 * @author Chinh Duong Manh
 */
function melokids_thumbnail_sizes()
{
    return array(
        esc_html__('Thumbnail', 'melokids')      => 'thumbnail',
        esc_html__('Medium', 'melokids')         => 'medium',
        esc_html__('Large', 'melokids')          => 'large',
        esc_html__('Post Thumbnail', 'melokids') => 'post-thumbnail',
        esc_html__('Full', 'melokids')           => 'full',
        esc_html__('Custom', 'melokids')         => 'custom',
    );
}

/**
 * List of Row Gutters
 * @since 1.0
 * @author Chinh Duong Manh
*/
function melokids_vc_gutters_list(){
    return array(
        esc_html__('Default', 'melokids') => '',
        esc_html__('0px', 'melokids')     => 'gutters-0',
        esc_html__('10px', 'melokids')    => 'gutters-10',
        esc_html__('15px', 'melokids')    => 'gutters-15',
        esc_html__('20px', 'melokids')    => 'gutters-20',
        esc_html__('25px', 'melokids')    => 'gutters-25',
        esc_html__('30px', 'melokids')    => 'gutters-30',
        esc_html__('35px', 'melokids')    => 'gutters-35',
        esc_html__('40px', 'melokids')    => 'gutters-40',
        esc_html__('50px', 'melokids')    => 'gutters-50',
        esc_html__('60px', 'melokids')    => 'gutters-60',
        esc_html__('70px', 'melokids')    => 'gutters-70',
        esc_html__('80px', 'melokids')    => 'gutters-80',
        esc_html__('90px', 'melokids')    => 'gutters-90',
        esc_html__('100px', 'melokids')   => 'gutters-100',
    );
}

/**
 * List of VC SECTION / ROW Vertical Space
 * @since 1.0
 * @author Chinh Duong Manh
*/
function melokids_vc_row_vert_space(){
    return array(
        esc_html__('Default', 'melokids') => 'vs-default',
        '0px'                             => 'vs-0',
        '20px'                            => 'vs-20',
        '30px'                            => 'vs-30',
        '35px'                            => 'vs-35',
        '40px'                            => 'vs-40',
        '50px'                            => 'vs-50',
        '100px'                           => 'vs-100',
        '120px'                           => 'vs-120',
        '150px'                           => 'vs-150',
    );
}
/**
 * List of VC SECTION / ROW Gutter
 * @since 1.0
 * @author Chinh Duong Manh
*/
function melokids_vc_row_hori_space(){
    return array(
        esc_html__('Default', 'melokids') => 'hs-default',
        '0px'                             => 'hs-0',
        '20px'                            => 'hs-20',
        '30px'                            => 'hs-30',
        '40px'                            => 'hs-40',
        '50px'                            => 'hs-50',
        '100px'                           => 'hs-100',
        '120px'                           => 'hs-120',
        '150px'                           => 'hs-150',
        '260px'                           => 'hs-260',
    );
}

/**
 * List of VC Column custom space
 * @since 1.0
 * @author Chinh Duong Manh
*/
function melokids_vc_column_space(){
    return array(
        esc_html__('Default', 'melokids') => '',
        '0px'  => 'pad-0',
        '10px' => 'pad-lg-10',
        '20px' => 'pad-lg-20',
        '30px' => 'pad-lg-30',
        '40px' => 'pad-lg-40',
        '50px' => 'pad-lg-50',
        '60px' => 'pad-lg-60',
        '70px' => 'pad-lg-70',
        '80px' => 'pad-lg-80',
        '90px' => 'pad-lg-90',
        '100px' => 'pad-lg-100',
    );
}

/**
 * List of VC Stretch Row left/right space
 * @since 1.0
 * @author Chinh Duong Manh 
*/
function melokids_fullwidth_stretch_row_space(){
    return array(
        esc_html__('Default', 'melokids') => '',
        '100px' => 'fhs-100',
        '120px' => 'fhs-120',
        '140px' => 'fhs-140',
        '160px' => 'fhs-160',
        '180px' => 'fhs-180',
        '200px' => 'fhs-200',
        '220px' => 'fhs-220',
        '240px' => 'fhs-240',
        '260px' => 'fhs-260',
    );
}
/**
 * Suggester for autocomplete by id/name/title/sku
 * @since 4.4
 *
 * @param $query
 *
 * @return array - id's from products with title/sku.
 */
function vc_autocomplete_product_id_field_search( $query ) {
    global $wpdb;
    $product_id = (int) $query;
    $post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
                FROM {$wpdb->posts} AS a
                LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
                WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

    $results = array();
    if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
        foreach ( $post_meta_infos as $value ) {
            $data = array();
            $data['value'] = $value['id'];
            $data['label'] = esc_html__( 'Id', 'melokids' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'melokids' ) . ': ' . $value['title'] : '' ) . ( ( strlen( $value['sku'] ) > 0 ) ? ' - ' . esc_html__( 'Sku', 'melokids' ) . ': ' . $value['sku'] : '' );
            $results[] = $data;
        }
    }

    return $results;
}

/**
* Find product by id
* @since 4.4
*
* @param $query
*
* @return bool|array
*/
function vc_autocomplete_product_id_field_render( $query ) {
    $query = trim( $query['value'] ); // get value from requested
    if ( ! empty( $query ) ) {
        // get product
        $product_object = wc_get_product( (int) $query );
        if ( is_object( $product_object ) ) {
            $product_sku = $product_object->get_sku();
            $product_title = $product_object->get_title();
            $product_id = $product_object->get_id();

            $product_sku_display = '';
            if ( ! empty( $product_sku ) ) {
                $product_sku_display = ' - ' . esc_html__( 'Sku', 'melokids' ) . ': ' . $product_sku;
            }

            $product_title_display = '';
            if ( ! empty( $product_title ) ) {
                $product_title_display = ' - ' . esc_html__( 'Title', 'melokids' ) . ': ' . $product_title;
            }

            $product_id_display = esc_html__( 'Id', 'melokids' ) . ': ' . $product_id;

            $data = array();
            $data['value'] = $product_id;
            $data['label'] = $product_id_display . $product_title_display . $product_sku_display;

            return ! empty( $data ) ? $data : false;
        }

        return false;
    }

    return false;
}

/**
 * Get Post List 
 * @author CMSSuperHeroes
 * @since 1.0.0
*/
if(!function_exists('biger_vc_list_post')){
    function biger_vc_list_post($post_type = 'post'){
        $post_list = array('-1' => esc_html__('None','melokids') );
        $posts = get_posts(array('post_type' => $post_type,'posts_per_page' => '-1'));
        foreach($posts as $post){
            $post_list[$post->post_title] = $post->ID;
        }
        return $post_list;
    }
}

/**
 * Get Page List 
 * @author CMSSuperHeroes
 * @since 1.0.0
*/
if(!function_exists('biger_vc_list_page')){
    function biger_vc_list_page(){
        $page_list = array();
        $pages = get_pages(array('hierarchical' => 0));
        foreach($pages as $page){
            $page_list[$page->post_title] = $page->ID;
        }
        return $page_list;
    }
}