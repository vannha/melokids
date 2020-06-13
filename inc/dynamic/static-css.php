<?php
/**
 * Auto create .css file from Theme Options
 * @author Chinh Duong Manh
 * @version 1.0.0
 */
class MeloKids_StaticCss
{
    public $scss;

    function __construct()
    {
        $scss = false;
        if (class_exists('\Leafo\ScssPhp\Compiler')) {
            $scss = new \Leafo\ScssPhp\Compiler();
            $this->scss_ver = 'new';
        }
        if ($scss === false)
            return;
        /* scss */
        $this->scss = $scss;
        /* set paths scss */
        $this->scss->setImportPaths(get_template_directory() . '/assets/scss/');
        /* generate css over time */
        add_action('wp', array($this, 'generate_over_time'));
        /* save option generate css */
        add_action("redux/options/theme_options/saved", array($this, 'generate_file'));
    }

    public function generate_over_time()
    {

        $dev_mode = (!defined('WP_DEBUG') || !WP_DEBUG) ? '0' : '1';
         
        if ('1' === $dev_mode) {
            $this->generate_file();
            $this->generate_file_magnific_popup();
        }
    }

    protected function is_file_changed()
    {
        $theme = wp_get_theme();
        $files = $theme->get_files('scss', 5, true);
        $files_hash = get_option('scss_files', []);
        $changed = false;
        if (!is_array($files_hash))
            $files_hash = [];
        foreach ($files as $relative => $abs_path) {
            $hash = md5_file($abs_path);
            if (!array_key_exists($relative, $files_hash) || $files_hash[$relative] != $hash)
                $changed = true;
            $files_hash[$relative] = $hash;
        }
        if ($changed)
            update_option('scss_files', $files_hash);
        //check css build files
        $css_hash = get_option('compile_css_files','');
        if(!is_array($css_hash))
            $changed = true;
        else
        {
            foreach ($css_hash as $file => $hash)
            {
                if(file_exists($file) && md5_file($file) == $hash)
                    continue;
                $changed = true;
                break;
            }
        }
        return $changed;
    }

    /**
     * generate css file.
     *
     * @since 1.0.0
     */
    public function generate_file()
    {
        global $theme_options, $wp_filesystem;
        if (empty($wp_filesystem) || !isset($theme_options))
            return;

        $theme_name = wp_get_theme()->get('TextDomain');

        $scss_dir = get_template_directory() . '/assets/scss/';
        $css_dir  = get_template_directory() . '/assets/css/';
        $css_file = $css_dir . $theme_name .'.css';
        // Child Theme
        $child_scss_dir = get_stylesheet_directory() . '/assets/scss/';
        $child_css_dir  = get_stylesheet_directory() . '/assets/css/';
        $child_css_file = $child_css_dir . $theme_name . '.child.css';

        $options_scss = $scss_dir. 'options.scss';
        /* rewrite file options.scss if change theme options*/
        $current_options_content = $this->css_render();
        if (md5_file($options_scss) !== md5($current_options_content)) {
            $wp_filesystem->delete($options_scss);
            /* write options to scss file */
            $wp_filesystem->put_contents($options_scss, $this->css_render(), FS_CHMOD_FILE); // Save it
        }

        /**
         * build source map
         * this used for load scss file when dev_mode is on
         * @source: https://github.com/leafo/scssphp/wiki/Source-Maps
        */
        $this->scss->setSourceMap(\Leafo\ScssPhp\Compiler::SOURCE_MAP_FILE);
        if(is_child_theme()){
            $this->scss->setSourceMapOptions(array(
                'sourceMapWriteTo'  => $child_css_file . ".map",
                'sourceMapURL'      => $theme_name.".child.css.map",
                'sourceMapFilename' => $child_css_file,
                'sourceMapBasepath' => $child_scss_dir,
                'sourceRoot'        => $child_scss_dir,
            ));
        } else {
            $this->scss->setSourceMapOptions(array(
                'sourceMapWriteTo'  => $css_file . ".map",
                'sourceMapURL'      => $theme_name.".css.map",
                'sourceMapFilename' => $css_file,
                'sourceMapBasepath' => $scss_dir,
                'sourceRoot'        => $scss_dir,
            ));
        }
        // end build source map

        if (!$this->is_file_changed())
            return;
        /* minimize CSS styles */
        if (class_exists('scssc') && !class_exists('\Leafo\ScssPhp\Compiler')) {
            $this->scss->setFormatter('scss_formatter_compressed');
        } else {
            $this->scss->setFormatter('Leafo\ScssPhp\Formatter\Compressed');
        }
        /* compile scss to css */
        $css = $this->scss_render();
        
        //save hash of files css rendered used
        $css_hash = [$css_file => md5($css)];
        update_option('compile_css_files',$css_hash);
        /* delete files $theme_name.css */
        $wp_filesystem->delete($css_file);
        /* write $theme_name.css file */
        $wp_filesystem->put_contents($css_file, $css, FS_CHMOD_FILE); // Save it
        /* write $theme_name.child.css file */
        if(is_child_theme()){
            $wp_filesystem->put_contents($child_css_file, $css, FS_CHMOD_FILE); // Save it
        }
    }

    /**
     * scss compile
     *
     * @since 1.0.0
     * @return string
     */
    public function scss_render()
    {
        /* compile scss to css */
        if (file_exists($file = trailingslashit(get_template_directory()) . 'assets/scss/master.php')) {
            include $file;
            $query = "";
            if (isset($import) && is_array($import)) {
                foreach ($import as $name) {
                    switch ($this->scss_ver) {
                        case 'old':
                            $query .= '@'.'import "' . $name . '.scss";' . PHP_EOL;
                            break;
                        case 'new':
                            $query .= '@'.'import "' . $name . '";' . PHP_EOL;
                    }
                }
            }
            if (!empty($query)) {
                return $this->scss->compile($query);
            }
        }
    }

    /**
     * main css
     *
     * @since 1.0.0
     * @return string
     */
    public function css_render()
    {
        /* Theme Color */
        $primary_color       = melokids_get_opts('primary_color', '#99A9B4', 'rgba');
        $accent_color        = melokids_get_opts('accent_color', '#F0524B', 'rgba');
        $accent_color_hover  = $accent_color;
        $accent_color_active = $accent_color;
        /* Body Typo */
        $body_color       = '#8C8C8C';
        $body_font_family = '\'edmondsansregular\'';
        $extra_font       = 'edmondsansregular';
        $extra_font2      = $extra_font;
        $body_font_size   = '16px';
        $body_font_weight = 'inherit';
        $body_line_height = 1.75;
        /* Header style */
        $header_height                = '100px';
        $header_width                 = '320px';
        $logo_w                       = '270px';
        /* Menu Dropdown */
        $dropdown_mobile_bg           = '#FFFFFF';
        $dropdown_mobile_color        = '#9b9b9b';
        $dropdown_mobile_color_hover  = $accent_color;
        $dropdown_mobile_color_active = $accent_color;
        /* Page title */
        $page_title_color   = '#FFFFFF';
        /* Button */
        $btn_font_family    = 'edmondsansmedium';
        $btn_font_weight    = 'inherit';
        $btn_font_size      = '14px';
        $btn_font_transform = 'uppercase';
        $btn_font_spacing   = '3px';
        /* button default */
        $btn_bg_color       = $primary_color;
        $btn_bg_color_hover = $accent_color;
        $btn_color          = '#FFFFFF';
        $btn_color_hover    = '#FFFFFF';
        $btn_border_style   = 'solid';
        $btn_border_width   = '1px';
        $btn_border_color   = $btn_bg_color;
        $btn_radius         = '0px';
        /* button primary */
        $btn_primary_bg_color       = $accent_color;
        $btn_primary_bg_color_hover = $primary_color;
        $btn_primary_color          = '#FFFFFF';
        $btn_primary_color_hover    = '#FFFFFF';
        $btn_primary_border_style   = 'solid';
        $btn_primary_border_width   = '1px';
        $btn_primary_border_color   = $btn_primary_bg_color;
        $btn_primary_radius         = '0px';

        $options_map = [
            'boxed_width'                     => ['body_width.width', '1200px'],
            'primary_color'                   => ['primary_color.regular', $primary_color],
            'accent_color'                    => ['accent_color.regular', $accent_color],
            'body_font_family'                => ['font_body.font-family', $body_font_family],
            'body_font_color'                 => ['font_body.color', $body_color],
            'body_font_size'                  => ['font_body.font-size', $body_font_size],
            'body_font_weight'                => ['font_body.font-weight', $body_font_weight],
            'body_line_height'                => ['font_body.line-height', $body_line_height],
            'extra_font'                      => ['extra_font.font-family', $extra_font],
            'extra_font2'                     => ['extra_font2.font-family', $extra_font2],
            /* Header */
            'header_height'                   => ['header_height.height', $header_height],
            'header_width'                    => ['header_width.width', $header_width],
            'header_logo_w'                   => ['logo_size.width', $logo_w],
            /* Header Default */
            'menu_default_link_color'         => ['header_fl_color.regular', '#4a4a4a'],
            'menu_default_link_color_hover'   => ['header_fl_color.hover', $accent_color],
            'menu_default_link_color_active'  => ['accent_color.active', $accent_color],
            /* Header On Top */
            'menu_ontop_link_color'           => ['header_ontop_fl_color.regular', '#FFFFFF'],
            'menu_ontop_link_color_hover'     => ['header_ontop_fl_color.hover', $accent_color],
            'menu_ontop_link_color_active'    => ['header_ontop_fl_color.active',$accent_color],
            /* Header Sticky  */
            'menu_sticky_link_color'          => ['header_sticky_fl_color.regular', '#FFFFFF'],
            'menu_sticky_link_color_hover'    => ['header_sticky_fl_color.hover', $accent_color],
            'menu_sticky_link_color_active'   => ['header_sticky_fl_color.active', $accent_color],
            /* Menu Mobile */
            'dropdown_bg_color'               => ['header_dropdown_mobile_bg.background-color', $dropdown_mobile_bg],
            'dropdown_link_color'             => ['header_dropdown_mobile_color.regular', $dropdown_mobile_color],
            'dropdown_link_color_hover'       => ['header_dropdown_mobile_color.hover', $dropdown_mobile_color_hover],
            'dropdown_link_color_active'      => ['header_dropdown_mobile_color.active', $dropdown_mobile_color_active],
            /* Page Title */
            'page_title_color'                => ['pagetitle_typo.color', $page_title_color],
            /* Button Default */
            'btn_font_family'                 => ['btn_default_typo.font-family', $btn_font_family],
            'btn_font_weight'                 => ['btn_default_typo.font-weight', $btn_font_weight],
            'btn_font_transform'              => ['btn_default_typo.text-transform', $btn_font_transform],
            'btn_font_size'                   => ['btn_default_typo.font-size', $btn_font_size],
            'btn_font_spacing'                => ['btn_default_typo.letter-spacing', $btn_font_spacing],
            'btn_default_color'               => ['btn_default_color.regular', $btn_color],
            'btn_default_color_hover'         => ['btn_default_color.hover', $btn_color_hover],
            'btn_default_border_width'        => [
            ['btn_default_border.border-top', 'btn_default_border.border-right', 'btn_default_border.border-bottom', 'btn_default_border.border-left',]
            , $btn_border_width
            , 'join: '],
            'btn_default_border_style'        => ['btn_default_border.border-style', $btn_border_style],
            'btn_default_border_color'        => ['btn_default_border.border-color', $btn_border_color],
            'btn_default_border_radius'       => ['btn_default_border_radius.width', $btn_radius],
            'btn_default_bg_color'            => ['btn_default_bg.background-color', $btn_bg_color],
            'btn_default_bg_image'            => ['btn_default_bg.background-image', 'inherit', 'replace:\'{1}\''],
            'btn_default_bg_size'             => ['btn_default_bg.background-size', 'inherit'],
            'btn_default_bg_repeat'           => ['btn_default_bg.background-repeat', 'inherit'],
            'btn_default_bg_position'         => ['btn_default_bg.background-position', 'inherit'],
            'btn_default_bg_attachment'       => ['btn_default_bg.background-attachment', 'inherit'],
            'btn_default_bg_hover'            => ['btn_default_bg_hover.background-color', $btn_bg_color_hover],
            'btn_default_bg_hover_image'      => ['btn_default_bg_hover.background-image', 'inherit', 'replace:url({1})'],
            'btn_default_bg_hover_size'       => ['btn_default_bg_hover.background-size', 'inherit'],
            'btn_default_bg_hover_repeat'     => ['btn_default_bg_hover.background-repeat', 'inherit'],
            'btn_default_bg_hover_position'   => ['btn_default_bg_hover.background-position', 'inherit'],
            'btn_default_bg_hover_attachment' => ['btn_default_bg_hover.background-attachment', 'inherit'],
            /* Button Primary */
            'btn_primary_font_family'         => ['btn_primary_typo.font-family', $btn_font_family],
            'btn_primary_font_weight'         => ['btn_primary_typo.font-weight', $btn_font_weight],
            'btn_primary_font_transform'      => ['btn_primary_typo.text-transform', $btn_font_transform],
            'btn_primary_font_size'           => ['btn_primary_typo.font-size', $btn_font_size],
            'btn_primary_font_spacing'        => ['btn_primary_typo.letter-spacing', $btn_font_spacing],
            'btn_primary_color'               => ['btn_primary_color.regular', $btn_primary_color],
            'btn_primary_color_hover'         => ['btn_primary_color.hover', $btn_primary_color_hover],
            'btn_primary_border_width'        => [
            ['btn_primary_border.border-top', 'btn_primary_border.border-right', 'btn_primary_border.border-bottom', 'btn_primary_border.border-left',]
            , $btn_primary_border_width
            , 'join: '],
            'btn_primary_border_style'        => ['btn_primary_border.border-style', $btn_primary_border_style],
            'btn_primary_border_color'        => ['btn_primary_border.border-color', $btn_primary_border_color],
            'btn_primary_border_radius'       => ['btn_primary_border_radius.width', $btn_primary_radius],
            'btn_primary_bg_color'            => ['btn_primary_bg.background-color', $btn_primary_bg_color],
            'btn_primary_bg_image'            => ['btn_primary_bg.background-image', 'none', 'replace:url({1})'],
            'btn_primary_bg_size'             => ['btn_primary_bg.background-size', 'inherit'],
            'btn_primary_bg_repeat'           => ['btn_primary_bg.background-repeat', 'inherit'],
            'btn_primary_bg_position'         => ['btn_primary_bg.background-position', 'inherit'],
            'btn_primary_bg_attachment'       => ['btn_primary_bg.background-attachment', 'inherit'],
            'btn_primary_bg_hover'            => ['btn_primary_bg_hover.background-color', $btn_primary_bg_color_hover],
            'btn_primary_bg_hover_image'      => ['btn_primary_bg_hover.background-image', 'inherit', 'replace:\'{1}\''],
            'btn_primary_bg_hover_size'       => ['btn_primary_bg_hover.background-size', 'inherit'],
            'btn_primary_bg_hover_repeat'     => ['btn_primary_bg_hover.background-repeat', 'inherit'],
            'btn_primary_bg_hover_position'   => ['btn_primary_bg_hover.background-position', 'inherit'],
            'btn_primary_bg_hover_attachment' => ['btn_primary_bg_hover.background-attachment', 'inherit'],
        ];
        $css_render = '';
        foreach ($options_map as $var => $value) {
            // if special modify just give it as string.
            if (is_string($value)) {
                $css_render .= '$' . "{$var}:{$value};";
                continue;
            }
            //default modify
            if (is_array($value)) {
                // 0 => param , 1 => default , 2=> special type
                $param_temp = $value[0];
                $default = $value[1];
                $special = (isset($value[2])) ? $value[2] : '';
                //get param from options
                if (is_string($param_temp)) {
                    $param_temp = $this->get_theme_option_field($param_temp, null);
                    if (empty($param_temp)) {
                        $css_render .= '$' . "{$var}:{$default};";
                        continue;
                    } else if (!empty($special)) {
                        $value = $this->do_special_action_modify($param_temp,$special);
                        $css_render .= '$'."{$var}:{$value};";
                    }else{
                        $css_render .= '$'."{$var}:{$param_temp};";
                    }
                }elseif(is_array($param_temp))
                {
                    $params = [];
                    foreach ($param_temp as $key => $param)
                    {
                        $param = $this->get_theme_option_field($param, null);
                        if(empty($param))
                        {
                            if(is_string($default))
                                $params[] = $default;
                            elseif(isset($default[$key]))
                                $params[] = $default[$key];
                            else
                                $params[] = end($default);
                        }
                        else
                            $params[] = $param;
                    }
                    $value = $this->do_special_action_modify($params,$special);
                    $css_render .= '$'."{$var}:{$value};";
                }
            }
        }
        return $css_render;
    }

    function do_special_action_modify($param, $action)
    {
        $result = '';
        if (is_string($param))
            $params = [$param];
        else
            $params = $param;
        if (!is_array($params))
            return $result;
        $special_actions = explode(':', $action);
        switch ($special_actions[0]) {
            case 'replace':
                $index = 1;
                if (!isset($special_actions[1]))
                    break;
                $result = $special_actions[1];
                foreach ($params as $var)
                    $result = str_replace('{' . $index++ . '}', $var, $result);
                break;
            case 'join':
                $join_str = (isset($special_actions[1])) ? $special_actions[1] : ' ';
                $result = join($join_str, $params);
                break;
        }
        return $result;
    }

    function get_theme_option_field($str_map, $default = '')
    {
        global $theme_options;
        $keys = explode('.', $str_map);
        $value = $default;
        foreach ($keys as $key) {
            if (!isset($wrap)) {
                if (!array_key_exists($key, $theme_options)) {
                    $wrap = $value;
                    break;
                }
                $wrap = $theme_options[$key];
                continue;
            }
            if (!is_array($wrap))
                break;
            $wrap = (array_key_exists($key, $wrap)) ? $wrap[$key] : $value;
        }
        $value = $wrap;
        $except = ['px',''];
        if(in_array($value,$except))
            return $default;
        return $value;
    }
    /**
     * generate magnific_popup css file.
     *
     * @since 1.0.0
     */
    public function generate_file_magnific_popup(){
        global $wp_filesystem;

        $magnific_scss_dir = get_template_directory() . '/assets/scss/magnific-popup/';
        $magnific_css_dir  = get_template_directory() . '/assets/libs/magnific-popup/';

        $this->scssc = new \Leafo\ScssPhp\Compiler();
        $this->scssc->setImportPaths( $magnific_scss_dir );

        $magnific_css_file = $magnific_css_dir . 'magnific-popup.css';
        $this->scssc->setFormatter( 'Leafo\ScssPhp\Formatter\Crunched' );
        
        $css = $this->scssc->compile( '@'.'import "main.scss"' );

        $wp_filesystem->put_contents($magnific_css_file, $css, FS_CHMOD_FILE); // Save it
    }
}

new MeloKids_StaticCss();