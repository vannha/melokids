<?php
/**
 * Auto create css from Meta Options.
 * 
 * @author Chinh Duong Manh
 * @version 1.0.0
 */
class MeloKids_DynamicCss
{

    function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'generate_css'),99);
    }

    /**
     * generate css inline.
     *
     * @since 1.0.0
     */
    public function generate_css()
    {
        $_dynamic_css = $this->css_render();
        wp_add_inline_style('melokids',  $_dynamic_css);
    }

    /**
     * header css
     *
     * @since 1.0.0
     * @return string
     */
    public function css_render()
    {
        global $theme_options, $meta_options;
        $style = [];
        ob_start();
        // header top
        $header_top_bg = melokids_get_opts('header_top_bg','','background-color');
        if(!empty($header_top_bg)) $style[] = '#zk-header-top{ background-color:'.$header_top_bg.'; display: inherit;}';

        // Custom logo
        $logo_size = melokids_get_opts('logo_size','','width');
        if(!empty($logo_size)) $style[] = '@media (min-width: 1200px){#zk-logo img{ max-width:'.$logo_size.';}}';

        echo implode('', $style);

        return ob_get_clean();
    }
}

new MeloKids_DynamicCss();