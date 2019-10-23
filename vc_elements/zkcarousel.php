<?php
if (!defined('ABSPATH')) exit;
vc_map(array(
        "name"                    => esc_html__("ZK Carousel", 'melokids'),
        "base"                    => "zkcarousel",
        "class"                   => "zk-carousel",
        "content_element"         => true,
        "show_settings_on_create" => false,
        "is_container"            => true,
        "controls"                => "full",
        "category"                => esc_html__('MeloKids', 'melokids'),
        "description"             => esc_html__("Add fancy Carousel", 'melokids'),
        "as_parent"               => array(
            'except' => 'zkcarousel, zkblog, zkteam, zktestimonial,zkclients, zkposts, vc_section, vc_row, vc_row_inner, vc_tta_accordion, vc_tta_tabs, vc_tta_tour, vc_tta_pageable , vc_tta_section, vc_basic_grid, vc_media_grid, vc_masonry_grid, vc_masonry_media_grid, vc_posts_slider, vc_images_carousel, vc_gallery, vc_widget_sidebar, vc_raw_js, vc_raw_html, vc_accordion, vc_tour, vc_tabs'
        ),
        "js_view"                 => 'VcColumnView',
        "params"                  => array_merge(
            array(
                array(
                    'type'        => 'el_id',
                    'settings'    => array(
                        'auto_generate' => true,
                    ),
                    'heading'     => esc_html__('Element ID', 'melokids'),
                    'param_name'  => 'el_id',
                    'description' => sprintf(__('Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'melokids'), 'http://www.w3schools.com/tags/att_global_id.asp'),
                )
                    , array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Extra Class', 'melokids'),
                    'param_name'  => 'el_class',
                    'value'       => '',
                    'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'melokids'),
                )
            ), 
            melokids_owl_settings()
        )
    )
);


class WPBakeryShortCode_zkcarousel extends WPBakeryShortCodesContainer
{
    protected function content($atts, $content = null)
    {
        $atts = vc_map_get_attributes($this->getShortcode(), $atts);
        $atts = wp_parse_args($atts, array(
            'layout_type'  => 'carousel',
        ));
        extract($atts);
        wp_enqueue_style('animate-css');
        melokids_owl_call_settings($atts);
        $content = $this->melokids_columnize_content($content);
        return parent::content($atts, $content);
    }

    protected function melokids_columnize_content($content)
    {
        $tag_pattern = '@\[([^<>&/\[\]\x00-\x20=]++)@';
        preg_match_all($tag_pattern, $content, $matches);
        if(empty($matches[0]))
            return [];
        $tags = $matches[1];
        $result = [];
        for($i=0;$i<count($tags);$i++)
        {
            $check_text =  explode('[',$content,2);
            if(!empty($check_text[0]))
                $result[] = $check_text[0];
            if(empty($check_text[1]))
                break;
            $content = '['.$check_text[1];
            preg_match_all($tag_pattern, $content, $matches);
            if(empty($matches[1]) || empty($matches[1][0]))
                break;
            $tag = $matches[1][0];
            $end = "[/{$tag}]";
            if(strpos($content,$end)=== false)
                $pattern = '/\['.$tag.'([^\]]*)\]/i';
            else
                $pattern = '/\['.$tag.'(.*)\[\/'.$tag.'\]/i';
            preg_match($pattern,$content,$matches);
            if(empty($matches[0]))
                break;//something err
            $sub_result = $matches[0];
            $content =  str_replace($matches[0],'',$content);
            $fix = explode($end,$sub_result,2);
            if(!empty($fix[1]))
            {
                $content = $fix[1].$content;
                $sub_result = $fix[0].$end;
            }
            $result[] = $sub_result;
        }
        return $result;
    }

    /**
     * [$controls_css_settings description]
     * @var string
     */
    protected $controls_css_settings = 'out-tc vc_controls-content-widget';

    /**
     * [$controls_list description]
     * @var array
     */
    protected $controls_list = array('add', 'edit', 'delete');

    /**
     * @param $width
     * @param $i
     *
     * @return string
     */

    public function mainHtmlBlockParams($width, $i)
    {
        $sortable = (vc_user_access_check_shortcode_all('zk_carousel_group') ? 'wpb_sortable' : 'vc-non-draggable');

        return 'data-element_type="zkcarousel" class="wpb_vc_tta_accordion wpb_sortable wpb_content_holder vc_shortcodes_container vc_tta-container vc_tta-o-non-responsive"' . $this->customAdminBlockParams();
    }

    public function getColumnControls($controls = 'full', $extended_css = '')
    {

        $column_controls = $this->getColumnControlsModular();

        $column_controls = str_replace('vc_element-move"', 'vc_element-move" data-vc-control="move"', $column_controls);
        $column_controls = str_replace('vc_edit"', 'vc_edit" data-vc-control="add"', $column_controls);
        $column_controls = str_replace('vc_control-btn-edit"', 'vc_control-btn-edit" data-vc-control="edit"', $column_controls);
//                $column_controls = str_replace( 'vc_control-btn-clone"', 'vc_control-btn-clone" data-vc-control="clone"', $column_controls );
        $column_controls = str_replace('vc_control-btn-delete"', 'vc_control-btn-delete" data-vc-control="delete"', $column_controls);

        return $column_controls;
    }

    public function contentAdmin($atts, $content = null)
    {

        $width = $el_class = '';

        $atts = shortcode_atts($this->predefined_atts, $atts);
        extract($atts);
        $this->atts = $atts;
        $output = '';

        for ($i = 0; $i < count($width); $i++) {

            $output .= '<div ' . $this->mainHtmlBlockParams($width, $i) . '>';

            if ($this->backened_editor_prepend_controls) {
                $output .= $this->getColumnControls('full', 'vc_controls-out-tc vc_controls-content-widget');
            }

            $output .= $this->paramsHtmlHolders($atts);

            $output .= '<div class="wpb_element_wrapper zkcarousel">';

            $output .= '<div ' . $this->containerHtmlBlockParams($width, $i) . '>';

            $output .= do_shortcode(shortcode_unautop($content));

            $output .= '</div>';

            $output .= '</div>';

            $output .= '</div>';
        }

        return $output;
    }
}