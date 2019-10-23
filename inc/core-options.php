<?php
/**
 * get list menu.
 * used in theme options
 * @return array
 */
if(!function_exists('melokids_get_nav_menu')){
    function melokids_get_nav_menu($default = false){
        $menus = array();
        $obj_menus = wp_get_nav_menus();
        if($default) $menus['-1'] = esc_html__('Default','melokids');
        $menus['none'] = esc_html__('None','melokids');
        foreach ($obj_menus as $obj_menu){
            $menus[$obj_menu->slug] = $obj_menu->name;
        }
        return $menus;
    }
}

/**
 * Get RevSlider List 
 * used in theme option
 * @author Chinh Duong Manh
 * @since 1.0.0
*/
if(!function_exists('melokids_get_list_rev_slider')){
    function melokids_get_list_rev_slider() {
        if (class_exists('RevSlider')) {
            $slider = new RevSlider();
            $arrSliders = $slider->getArrSliders();
            $revsliders = array();
            if ($arrSliders) {
                foreach ($arrSliders as $slider) {
                    /* @var $slider RevSlider */
                    $revsliders[$slider->getAlias()] = $slider->getTitle();
                }
            }
            return $revsliders;
        }
    }
}
/**
 * Get Contact Form 7 List
 * 
 * @author Chinh Duong Manh
 * @since 1.0.0
*/
function melokids_get_list_cf7() {
    if(!class_exists('WPCF7')) return;
    $cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );
    $contact_forms = array();
    if ( $cf7 ) {
        foreach ( $cf7 as $cform ) {
            $contact_forms[ $cform->post_title ] = $cform->ID;
        }
    } else {
        $contact_forms[ esc_html__( 'No contact forms found', 'melokids' ) ] = 0;
    }
    return $contact_forms;
}


/* General Options */
if(!function_exists('melokids_general_opts')){
    function melokids_general_opts($args = []){
        $args = wp_parse_args($args, array(
            'default'       => false,
            'default_value' => '0'
        ));
        extract($args);
        $options = [];
        if($default){ 
            $options['-1'] = esc_html__('Default','melokids');
            $default_value = '-1';
        }

        $options['1'] = esc_html__('Yes','melokids');
        $options['0'] = esc_html__('No','melokids');


        return array(
            array(
                'title'    => esc_html__('Boxed Layout', 'melokids'),
                'subtitle' => esc_html__('make your site is boxed?', 'melokids'),
                'id'       => 'body_layout',
                'type'     => 'button_set',
                'options'  => $options,
                'default'  => $default_value
            ),
            array(
                'title'     => esc_html__('Boxed Background', 'melokids'),
                'subtitle'  => esc_html__('Choose background style boxed area', 'melokids'),
                'id'        => 'boxed_bg',
                'type'      => 'background',
                'default'   => array(),
                'output'    => array('.zk-boxed'),
                'required'  => array(
                    array('body_layout', '=','1')
                )
            ),
            array(
                'title'     => esc_html__('Boxed width', 'melokids'),
                'subtitle'  => esc_html__('This option just applied for screen larger than value you enter here!', 'melokids'),
                'id'        => 'body_width',
                'type'      => 'dimensions',
                'units'     => array('px'),
                'height'    => false,
                'default'   => array(
                    'width' => '1200px',
                    'units' => 'px'
                ),
                'output'    => array('.zk-boxed'),
                'required'  => array( 
                    array( 'body_layout', '=', '1'), 
                ),
            ),
            array(
                'title'     => esc_html__('Body Background', 'melokids'),
                'subtitle'  => esc_html__('Choose background style', 'melokids'),
                'id'        => 'body_bg',
                'type'      => 'background',
                'default'   => array(),
                'output'    => array('html')
            ),
            
            array(
                'title'     => esc_html__('Body Padding', 'melokids'),
                'subtitle'  => esc_html__('Choose padding for BODY tag', 'melokids'),
                'id'        => 'body_padding',
                'type'      => 'spacing',
                'mode'      => 'padding',
                'units'     => array('px'),     
                'default'   => array(),
                'output'    => array('html')
            ),
            array(
                'title'     => esc_html__('Body Margin', 'melokids'),
                'subtitle'  => esc_html__('Choose margin for BODY tag', 'melokids'),
                'id'        => 'body_margin',
                'type'      => 'spacing',
                'mode'      => 'margin',
                'units'     => array('px'),     
                'default'   => array(),
                'output'    => array('html')
            )
        );
    }
}

/**
 * Theme Option: Header Banner
 * All option for Header Banner area
 *
 * Applied for theme option and page option
 *
 * variantion: $default
 * add default option on Page option 
 *
*/
if(!function_exists('melokids_header_banner_opts')){
    function melokids_header_banner_opts($default = false){
        $default_value = $default ? '-1' : '';
        return array(
            'title'      => esc_html__('Header Banner', 'melokids'),
            'icon'       => 'el el-credit-card',
            'fields'     => array(
                array(
                    'title'       => esc_html__('Header Banner', 'melokids'),
                    'subtitle'    => esc_html__('Choose header banner', 'melokids'),
                    'description' => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom header banner layout first.','melokids'),'<a href="' . esc_url( admin_url( 'post-new.php?post_type=header_banner' ) ) . '">','</a>'),
                    'id'          => 'header_banner',
                    'type'        => 'select',
                    'options'     => melokids_list_post('header_banner', $default),
                    'default'     => $default_value
                )
            )
        );
    }
}

/**
 * Theme Option: Header Top
 * All option for Header Top area
 *
 * Applied for theme option and page option
 *
 * variantion: $default
 * add default option on Page option 
 *
*/
if(!function_exists('melokids_header_top_opts')){
    function melokids_header_top_opts($default = false){
        $default_value = $default ? '-1' : '';
        return array(
            'title'         => esc_html__('Header Top', 'melokids'),
            'heading'       => '',
            'icon'          => 'el-icon-credit-card',
            'fields'        => array(
                array(
                    'title'       => esc_html__('Header Top', 'melokids'),
                    'subtitle'    => esc_html__('Choose header top', 'melokids'),
                    'description' => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom header top layout first.','melokids'),'<a href="' . esc_url( admin_url( 'post-new.php?post_type=header_top' ) ) . '">','</a>'),
                    'id'          => 'header_top',
                    'type'        => 'select',
                    'options'     => melokids_list_post('header_top', $default),
                    'default'     => $default_value
                )
            )
        );
    }
}
/**
 * Theme Option: 
 * Header Layout 
*/
if(!function_exists('melokids_header_layout_opts')){
    function melokids_header_layout_opts($default = false){
        $header_layout_opts = $header_fullwidth_opts = $header_justify_content_opts = array();
        if($default){
            $header_layout_opts['-1'] = get_template_directory_uri().'/assets/images/header/default.jpg';
            $header_fullwidth_opts['-1'] = $header_justify_content_opts['-1'] = esc_html__('Default','melokids');

            $default_value = $btn_set_default_value = $header_justify_content_default_value = '-1';
            $main_menu = $menu_left = $menu_right = '-1';
        } else {
            $default_value = '3';
            $btn_set_default_value = '1';
            $main_menu = 'all-pages';
            $menu_left = $menu_right = 'short';

            $header_justify_content_default_value = 'center';
        }
        $header_layout_opts['1']  = get_template_directory_uri().'/assets/images/header/v1.jpg';
        $header_layout_opts['2']  = get_template_directory_uri().'/assets/images/header/v2.jpg';
        $header_layout_opts['3']  = get_template_directory_uri().'/assets/images/header/v3.jpg';
        $header_layout_opts['4']  = get_template_directory_uri().'/assets/images/header/v4.jpg';

        $header_fullwidth_opts['1'] = esc_html__('Yes','melokids');
        $header_fullwidth_opts['0'] = esc_html__('No','melokids');

        $header_justify_content_opts['center'] = esc_html__('Center','melokids');
        $header_justify_content_opts['between'] = esc_html__('Justify','melokids');

        return array(
            array(
                'id'        => 'header_layout',
                'title'     => esc_html__('Layouts', 'melokids'),
                'subtitle'  => esc_html__('select a layout for header', 'melokids'),
                'type'      => 'image_select',
                'options'   => $header_layout_opts,
                'default'   => $default_value
            ),
            array(
                'title'     => esc_html__('Header Width', 'melokids'),
                'subtitle'  => esc_html__('Make header content full width?', 'melokids'),
                'id'        => 'header_fullwidth',
                'type'      => 'button_set',
                'options'   => $header_fullwidth_opts,
                'default'   => $btn_set_default_value,
                'required' => array( 'header_layout', '!=', '4' )
            ),
            array(
                'title'     => esc_html__('Content Align', 'melokids'),
                'subtitle'  => esc_html__('content alignments', 'melokids'),
                'id'        => 'header_justify_content',
                'type'      => 'button_set',
                'options'   => $header_justify_content_opts,
                'default'   => $header_justify_content_default_value,
                'required' => array( 'header_layout', '=', '2' )
            ),
            array(
                'title'       => esc_html__('Header Type', 'melokids'),
                'subtitle'    => esc_html__('Choose your header', 'melokids'),
                'description' => esc_html__('If you choose Header Custom, all config for header will lost!', 'melokids'),
                'id'          => 'header_custom',
                'type'        => 'select',
                'options'     => array(
                    '-1'     => esc_html__('Default','melokids'),
                    'custom' => esc_html__('Custom','melokids'),
                ),
                'default'     => '-1',
                'required'    => array('header_layout','=','4' )
            ),
            array(
                'title'       => esc_html__('Custom Header', 'melokids'),
                'subtitle'    => esc_html__('Choose custom Header', 'melokids'),
                'description' => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom header first.','melokids'),'<a href="' . esc_url( admin_url( 'post-new.php?post_type=header_custom' ) ) . '" target="_blank">','</a>'),
                'id'          => 'header_custom_value',
                'type'        => 'select',
                'options'     => melokids_list_post('header_custom',''),
                'default'     => '',
                'required'    => array('header_custom','=','custom' )
            ),
            array(
                'title'     => esc_html__('Header Width', 'melokids'),
                'subtitle'  => esc_html__('Add width for header!', 'melokids'),
                'id'        => 'header_width',
                'type'      => 'dimensions',
                'units'     => array('px'),
                'height'    => false,
                'required'  => array('header_layout','=','4' )
            ),
            array(
                'title'    => esc_html__('Header Height', 'melokids'),
                'subtitle' => esc_html__('Add height for header.', 'melokids'),
                'id'       => 'header_height',
                'type'     => 'dimensions',
                'units'    => array('px'),
                'width'    => false,
                'required' => array( 'header_layout', '!=', '4' )
            ),
            array(
                'id'       => 'header_menu',
                'type'     => 'select',
                'title'    => esc_html__('Header Menu', 'melokids'),
                'subtitle' => esc_html__('Choose the menu will show on header.', 'melokids'),
                'options'  => melokids_get_nav_menu($default),
                'default'  => $main_menu,
                'required' => array( 'header_layout', '=', array('1', '3'))
            ),
            array(
                'id'       => 'header_menu_left',
                'type'     => 'select',
                'title'    => esc_html__('Header Menu Left', 'melokids'),
                'subtitle' => esc_html__('Choose the menu will show in left handside of LOGO.', 'melokids'),
                'options'  => melokids_get_nav_menu($default),
                'default'  => $menu_left,
                'required' => array( 'header_layout', '=', '2' )
            ),
            array(
                'id'       => 'header_menu_right',
                'type'     => 'select',
                'title'    => esc_html__('Header Menu Right', 'melokids'),
                'subtitle' => esc_html__('Choose the menu will show in right handside if LOGO.', 'melokids'),
                'options'  => melokids_get_nav_menu($default),
                'default'  => $menu_right,
                'required' => array( 'header_layout', '=', '2' )
            )
        );
    }
}

/**
 * Theme Option:
 * Header Attributes 
 *
*/
if(!function_exists('melokids_header_atts_opts')){
    function melokids_header_atts_opts($default = false){
        if($default){
            $options = array(
                '-1' => esc_html__('Default','melokids'),
                '1'  => esc_html__('Yes','melokids'),
                '0'  => esc_html__('No','melokids'),
            );
            $default_value = '-1';
        } else {
            $options = array(
                '1'  => esc_html__('Yes','melokids'),
                '0'  => esc_html__('No','melokids'),
            );
            $default_value = '0';
        }
        return array_merge(
            array(
                array(
                    'title'    => esc_html__('Show Search', 'melokids'),
                    'subtitle' => esc_html__('Show/Hide search icon', 'melokids'),
                    'id'       => 'header_search',
                    'type'      => 'button_set',
                    'options'   => $options,
                    'default'   => $default_value,
                )
            ),
            melokids_header_cart($options, $default_value, $default),
            melokids_header_tool($options, $default_value, $default),
            melokids_header_sidebar_menu_opts($options, $default_value, $default),
            melokids_header_donate_opts($default),
            melokids_header_social_opts($options, $default_value, $default)
        );
    }
}
/* Theme Options: show WC Cart */
function melokids_header_cart($options, $default_value,  $default = false){
    if(!class_exists('WooCommerce')) return array();
    return array(
        array(
            'title'     => esc_html__('Show Cart', 'melokids'),
            'subtitle'      => esc_html__('Show/Hide cart icon', 'melokids'),
            'id'        => 'header_wc_cart',
            'type'      => 'button_set',
            'options'   => $options,
            'default'   => $default_value,
        )
    );
}

/* Theme option: show Tools */
function melokids_header_tool($options, $default_value,  $default = false){
    return array(
        array(
            'title'       => esc_html__('Show Tools', 'melokids'),
            'subtitle'    => esc_html__('Show/Hide tool icon', 'melokids'),
            'description' => sprintf(esc_html__('When this options is YES, you need to add a widget to %sHeader Tools%s area via %sWidget Manager%s','melokids'), '<a href="' . esc_url( admin_url( 'widgets.php#header-tool' ) ) . '" target="_blank">', '</a>', '<a href="' . esc_url( admin_url( 'widgets.php#header-tool' ) ) . '" target="_blank">', '</a>'),
            'id'          => 'header_tool',
            'type'        => 'button_set',
            'options'     => $options,
            'default'     => $default_value,
        ),
        array(
            'title'       => esc_html__('Show Tools on screen', 'melokids'),
            'description' => esc_html__('Tools icon show on what screen display', 'melokids'),
            'id'          => 'header_tool_screen',
            'type'        => 'button_set',
            'multi'       => true,
            'options' => array(
                '1' => esc_html__('Extra Small','melokids'), 
                '2' => esc_html__('Small','melokids'), 
                '3' => esc_html__('Medium','melokids'), 
                '4' => esc_html__('Large','melokids'), 
                '5' => esc_html__('Extra Large','melokids'), 
             ), 
            'default' => array('1', '2', '3','4','5'),
            'required'  => array('header_tool', '=', 1)
        )
    );
}

/* Theme Option: Show Donate Button */
function melokids_header_donate_opts($default = false){
    $options = array();
    if($default){
        $options['-1'] =  esc_html__('Default', 'melokids');
        $default_value = '-1';
    } else{
        $default_value = '0';
    }
    $options['0'] = esc_html__('Hide', 'melokids');
    $options['1'] = esc_html__('Donate Archive Page', 'melokids');
    $options['2'] = esc_html__('Internal Link', 'melokids');
    $options['3'] = esc_html__('External Link', 'melokids');


    if(!class_exists('EF4Donations')) return array();
    return array(
        array(
            'title'     => esc_html__('Show Donate Button', 'melokids'),
            'subtitle'  => esc_html__('Show/Hide donate button', 'melokids'),
            'id'        => 'header_donate',
            'type'      => 'button_set',
            'options'   => $options,
            'default'   => $default_value,
        ),
        array(
            'title'     => esc_html__('Donate Button Link', 'melokids'),
            'subtitle'  => esc_html__('Choose an exiting page', 'melokids'),
            'id'        => 'header_donate_url',
            'type'      => 'select',
            'options'   => melokids_list_page(),
            'required'  => array( 'header_donate', '=', '2' )
        ),
        array(
            'title'       => esc_html__('Donate Button Link', 'melokids'),
            'subtitle'    => esc_html__('Enter your url', 'melokids'),
            'id'          => 'header_donate_url2',
            'type'        => 'text',
            'validate'    => 'url',
            'placeholder' => 'http://your-url.com',
            'required'    => array( 'header_donate', '=', '3' )
        ),
        array(
            'title'       => esc_html__('Donate Button Label', 'melokids'),
            'subtitle'    => esc_html__('Enter Label for button', 'melokids'),
            'id'          => 'header_donate_label',
            'type'        => 'text',
            'placeholder' => esc_html__('Donate Now','melokids'),
            'required'    => array(
                array( 'header_donate', '!=', '-1' ),
                array( 'header_donate', '!=', '0' )
            )
        )
    );
}

/* Theme option: Sidebar Menu */
function melokids_header_sidebar_menu_opts($options, $default_value, $default = false){
    return array(
        array(
            'title'       => esc_html__('Show Sidebar Area', 'melokids'),
            'subtitle'    => esc_html__('Show/Hide sidebar area', 'melokids'),
            'description' => sprintf(esc_html__('When this options is YES, you need to add a widget to %sSidebar Menu%s area via %sWidget Manager%s','melokids'), '<a href="' . esc_url( admin_url( 'widgets.php#zk-sidebar-menu' ) ) . '" target="_blank">', '</a>', '<a href="' . esc_url( admin_url( 'widgets.php#zk-sidebar-menu' ) ) . '" target="_blank">', '</a>'),
            'id'          => 'sidebar_menu',
            'type'        => 'button_set',
            'options'     => $options,
            'default'     => $default_value
        )
    );
}

/* Theme option: Social */
function melokids_header_social_opts($options, $default_value, $default = false){
    return array(
        array(
            'title'       => esc_html__('Show Social', 'melokids'),
            'subtitle'    => esc_html__('Show/Hide social icon in Header area', 'melokids'),
            'description' => sprintf(esc_html__('When this option is YES, you need to manage social icon in %sSocial Link%s','melokids'), '<a href="' . esc_url( admin_url( 'admin.php?page=MeloKids&tab=22' ) ) . '" target="_blank">', '</a>'),
            'id'          => 'header_social',
            'type'        => 'button_set',
            'options'     => $options,
            'default'     => $default_value
        )
    );
}

/**
 * Theme Options
 * Header on top options
*/
if(!function_exists('melokids_header_ontop_opts')){
    function melokids_header_ontop_opts($args = []){
        $args = wp_parse_args($args, [
            'default' => false
        ]);
        if($args['default']){
            $options = array(
                '-1' => esc_html__('Default','melokids'),
                '1'  => esc_html__('Yes','melokids'),
                '0'  => esc_html__('No','melokids'),
            );
            $default_value = '-1';
            $logo = '';
        } else {
            $options = array(
                '1'  => esc_html__('Yes','melokids'),
                '0'  => esc_html__('No','melokids'),
            );
            $default_value = '0';
            $logo = array(
                'title'     => esc_html__('Logo Image', 'melokids'),
                'subtitle'  => esc_html__('Select an image file for your logo.', 'melokids'),
                'id'        => 'header_ontop_logo',
                'type'      => 'media',
                'default'   => array(),
                'required'  => array( 
                    array( 'header_ontop', '=', '1')
                )
            );
        }
        return array(
            array(
                'title'     => esc_html__('Header on Top', 'melokids'),
                'subtitle'  => esc_html__('enable on top header.', 'melokids'),
                'id'        => 'header_ontop',
                'type'      => 'button_set',
                'options'   => $options,
                'default'   => $default_value,
            ),
            $logo,
            array(
                'title'     => esc_html__('Background Color', 'melokids'),
                'subtitle'  => esc_html__('choose Background color style.', 'melokids'),
                'id'        => 'header_ontop_bg_color',
                'type'      => 'color_rgba',
                'default'   => array(),
                'required'  => array( 
                    array( 'header_ontop', '=', '1'), 
                ),
                'output'    => array(
                    'background-color' => '#zk-header.header-ontop'
                ),
                'validate'  => 'colorrgba'
            ),
            array(
                'title'     => esc_html__('Background Image', 'melokids'),
                'subtitle'  => esc_html__('choose Background image style.', 'melokids'),
                'id'        => 'header_ontop_bg',
                'type'      => 'background',
                'background-color'  => false,
                'default'   => array(),
                'required'  => array( 
                    array( 'header_ontop', '=', '1'), 
                ),
                'output'    => array(),
            ),
            array(
                'title'     => esc_html__('Typography', 'melokids'),
                'subtitle'  => esc_html__('This option just applied for Menu first level', 'melokids'),
                'id'        => 'header_ontop_typo',
                'type'      => 'typography',
                'text-transform'    => true,
                'letter-spacing'    => true,
                'line-height'       => false,
                'color'             => false,
                'text-align'        => false,
                'font-style'        => false,
                'font-weight'       => false,
                'default'           => array(),
                'required'  => array( 
                    array( 'header_ontop', '=', '1'), 
                ),
                'output'    => array(
                    '.header-ontop .zk-nav-extra',
                    '.header-ontop ul.desktop-nav > li > a',
                )
            ),
            array(
                'title'     => esc_html__('Link Color', 'melokids'),
                'subtitle'  => esc_html__('This option just applied for Menu first level', 'melokids'),
                'id'        => 'header_ontop_fl_color',
                'type'      => 'link_color',
                'default'   => array(),
                'required'  => array( 
                    array( 'header_ontop', '=', '1'), 
                ),
                'output'    => array(),
                'validate'  => 'color'
            )
        );
    }
}

/**
 * Theme Options
 * Header Sticky options
*/
if(!function_exists('melokids_header_sticky_opts')){
    function melokids_header_sticky_opts($args = []){
        $args = wp_parse_args($args, [
            'default' => false
        ]);
        if($args['default']){
            $options = array(
                '-1' => esc_html__('Default','melokids'),
                '1'  => esc_html__('Yes','melokids'),
                '0'  => esc_html__('No','melokids'),
            );
            $default_value = '-1';
            $logo = '';
        } else {
            $options = array(
                '1'  => esc_html__('Yes','melokids'),
                '0'  => esc_html__('No','melokids'),
            );
            $default_value = '0';
            
            $logo = array(
                'title'     => esc_html__('Logo Image', 'melokids'),
                'subtitle'  => esc_html__('Select an image file for your logo.', 'melokids'),
                'id'        => 'header_sticky_logo',
                'type'      => 'media',
                'default'   => array(),
                'required'  => array( 
                    array( 'header_sticky', '=', '1'), 
                )
            );
        }
        return array(
            array(
                'title'     => esc_html__('Sticky Header', 'melokids'),
                'subtitle'  => esc_html__('enable sticky header.', 'melokids'),
                'id'        => 'header_sticky',
                'type'        => 'button_set',
                'options'     => $options, 
                'default'     => $default_value,
            ),
            $logo,
            /* Sticky header default */
            array(
                'title'     => esc_html__('Background Color', 'melokids'),
                'subtitle'  => esc_html__('choose Background color style.', 'melokids'),
                'id'        => 'header_sticky_bg_color',
                'type'      => 'color_rgba',
                'default'   => array(),
                'required'  => array( 
                    array( 'header_sticky', '=', '1')
                ),
                'output'    => array(
                    'background-color' => '#zk-header.header-sticky'
                ),
                'validate'  => 'colorrgba'
            ),
            array(
                'title'     => esc_html__('Background Image', 'melokids'),
                'subtitle'  => esc_html__('choose Background image style.', 'melokids'),
                'id'        => 'header_sticky_bg',
                'type'      => 'background',
                'background-color'  => false,
                'default'   => array(),
                'required'  => array( 
                    array( 'header_sticky', '=', '1'),
                ),
                'output'    => array('#zk-header.header-sticky'),
            ),
            array(
                'title'     => esc_html__('Typography', 'melokids'),
                'subtitle'  => esc_html__('This option just applied for Menu first level', 'melokids'),
                'id'        => 'header_sticky_typo',
                'type'      => 'typography',
                'text-transform'    => true,
                'letter-spacing'    => true,
                'line-height'       => false,
                'color'             => false,
                'text-align'        => false,
                'font-style'        => false,
                'font-weight'       => false,
                'default'           => array(),
                'required'  => array( 
                    array( 'header_sticky', '=', '1'), 
                ),
                'output'    => array(
                    '.header-sticky .zk-nav-extra',
                    '.header-sticky ul.desktop-nav > li > a',
                )
            ),
            array(
                'title'     => esc_html__('Link Color', 'melokids'),
                'subtitle'  => esc_html__('This option just applied for Menu first level', 'melokids'),
                'id'        => 'header_sticky_fl_color',
                'type'      => 'link_color',
                'default'   => array(),
                'required'  => array( 
                    array( 'header_sticky', '=', '1'), 
                ),
                'output'    => array(),
                'validate'  => 'colorrgba'
            )
        );
    }
}

/* Main Content Options */
if(!function_exists('melokids_main_content_opts')){
    function melokids_main_content_opts($args = []){
        $args = wp_parse_args($args, array(
            'default'       => false,
            'default_value' => '0'
        ));
        extract($args);
        $options = [];
        if($default){ 
            $options['-1'] = esc_html__('Default','melokids');
            $default_value = '-1';
        }

        $options['1'] = esc_html__('Yes','melokids');
        $options['0'] = esc_html__('No','melokids');


        return array(
            array(
                'id'          => 'mc_w',
                'title'       => esc_html__('Main ContentWidth', 'melokids'),
                'description' => esc_html__('Make content area has full width?', 'melokids'),
                'type'        => 'button_set',
                'options'     => $options, 
                'default'     => $default_value,
            ),
            array(
                'title'     => esc_html__('Background', 'melokids'),
                'subtitle'  => esc_html__('Choose background style', 'melokids'),
                'id'        => 'main_bg',
                'type'      => 'background',
                'default'   => array(),
                'output'    => array('#zk-main')
            ),
            array(
                'title'     => esc_html__('Padding', 'melokids'),
                'subtitle'  => esc_html__('Choose space for: Top, Right, Bottom, Left', 'melokids'),
                'id'        => 'main_padding',
                'type'      => 'spacing',
                'mode'      => 'padding',
                'units'     => array('px'),
                'default'   => array(),
                'output'    => array('#zk-main')
            ),
        );
    }
}

/* Page Layout Options */
if(!function_exists('melokids_page_layout_opts')){
    function melokids_page_layout_opts($args = []){
        $args = wp_parse_args($args, array(
            'default'       => false,
            'default_value' => 'right'
        ));
        extract($args);
        $options = [];
        if($default){ 
            $options['-1'] = esc_html__('Default','melokids');
            $default_value = '-1';
        }

        $options['left']  = esc_html__('Left Sidebar','melokids');
        $options['full']  = esc_html__('No Sidebar','melokids');
        $options['right'] = esc_html__('Right Sidebar','melokids');


        return array(
            array(
                'id'          => 'page_layout',
                'title'       => esc_html__('Page layout', 'melokids'),
                'description' => esc_html__('This layout apply for page template layout', 'melokids'),
                'type'        => 'button_set',
                'options'     => $options, 
                'default'     => $default_value,
            ),
            array(
                'id'          => 'page_sidebar',
                'title'       => esc_html__('Sidebar', 'melokids'),
                'placeholder' => esc_html__('select a widget area for page', 'melokids'),
                'type'        => 'select',
                'data'        => 'sidebars',
                'default'     => 'sidebar-main',
                'required'    => array( 
                    array('page_layout', '!=', array('-1') ),
                    array('page_layout', '!=', array('full') )
                )
            )
        );
    }
}

/* Post Layout Options */
if(!function_exists('melokids_post_layout_opts')){
    function melokids_post_layout_opts($args = []){
        $args = wp_parse_args($args, array(
            'default'       => false,
            'default_value' => 'right'
        ));
        extract($args);
        $options = [];
        if($default){ 
            $options['-1'] = esc_html__('Default','melokids');
            $default_value = '-1';
        }

        $options['left']  = esc_html__('Left Sidebar','melokids');
        $options['full']  = esc_html__('No Sidebar','melokids');
        $options['right'] = esc_html__('Right Sidebar','melokids');


        return array(
            array(
                'title'     => esc_html__('Single Layout', 'melokids'),
                'subtitle'  => esc_html__('Choose a layout for single post page', 'melokids'),
                'id'        => 'single_layout',
                'type'      => 'button_set',
                'options'   => $options,
                'default'   => $default_value,
            ),
            array(
                'id'        => 'single_sidebar',
                'title'     => esc_html__('Sidebar', 'melokids'),
                'placeholder'  => esc_html__('select a widget area for single post page', 'melokids'),
                'type'      => 'select',
                'data'      => 'sidebars',
                'default'   => 'sidebar-main',
                'required'  => array(
                    array('single_layout','!=', array('-1')),
                    array('single_layout','!=', array('full'))
                )
            )
        );
    }
}
/* Portfolio Options  */
if(!function_exists('melokids_portfolio_opts')){
    function melokids_portfolio_opts(){
        global $opt_name;

        if(!post_type_exists('portfolio')) return;
        
        return Redux::setSection($opt_name, array(
            'title'         => esc_html__('Single Portfolio', 'melokids'),
            'icon'          => 'dashicons dashicons-align-left',
            'subsection'    => true,
            'fields'        => array(
                array(
                    'title'     => esc_html__('Single Layout', 'melokids'),
                    'subtitle'  => esc_html__('Choose default layout for single Portfolio page', 'melokids'),
                    'id'        => 'portfolio_layout',
                    'type'      => 'button_set',
                    'options'   => array(
                        ''     => esc_html__('Default','melokids'),
                    ),
                    'default'   => '',
                ),
            )
        ));
    }
}

/* Theme Options: Page title */
if(!function_exists('melokids_pagetitle_opts')){
    function melokids_pagetitle_opts($default = false){
        $enable_opts     = $layout_opts = [];
        $default_value   = '1';
        $default_value_w = '0';
        $page_title_align = array();
        $page_title_align_default = 'text-default';
        if($default){ 
            $enable_opts['-1'] = esc_html__('Default','melokids');
            $layout_opts['-1'] = get_template_directory_uri().'/assets/images/pagetitle/pt-s-default.png';
            $default_value     = '-1';
            $default_value_w   = '-1';
            $page_title_align  = array('-1' => esc_html__('Theme Default','melokids'));
            $page_title_align_default = '-1';
        }

        $enable_opts['1'] = esc_html__('Yes','melokids');
        $enable_opts['0'] = esc_html__('No','melokids');

        $layout_opts['1'] = get_template_directory_uri().'/assets/images/pagetitle/pt-s-1.png';
        $layout_opts['2'] = get_template_directory_uri().'/assets/images/pagetitle/pt-s-2.png';
        $layout_opts['3'] = get_template_directory_uri().'/assets/images/pagetitle/pt-s-3.png';
        
        $page_title_align = array_merge(
            $page_title_align, 
            array(
                'text-default'  => esc_html__('Default','melokids'),
                'text-left'     => esc_html__('Left','melokids'),
                'text-right'    => esc_html__('Right','melokids'),
                'text-center'   => esc_html__('Center','melokids'),
                'text-justify'  => esc_html__('Justify','melokids'),
            )
        );

        return array(
            array(
                'title'   => esc_html__('Enable Page Title', 'melokids'),
                'id'      => 'page_title',
                'type'    => 'button_set',
                'options' => $enable_opts, 
                'default' => $default_value,
            ),
            array(
                'id'        => 'page_title_layout',
                'title'     => esc_html__('Layouts', 'melokids'),
                'subtitle'  => esc_html__('select a layout for page title', 'melokids'),
                'type'      => 'image_select',
                'options'   => $layout_opts,
                'default'   => $default_value,
                'required'  => array( 
                    array( 'page_title', '!=', '0')
                ),
            ),
            array(
                'title'     => esc_html__('Page Title Image', 'melokids'),
                'subtitle'  => esc_html__('Select an image file to show page title.', 'melokids'),
                'id'        => 'page_title_img',
                'type'      => 'media',
                'default'   => array(),
                'required'  => array( 
                    array( 'page_title_layout', '=', '3')
                )
            ),
            array(
                'title'   => esc_html__('Page Title Width', 'melokids'),
                'subtitle'=> esc_html__('Make page title content full width?','melokids'),
                'id'      => 'page_title_w',
                'type'    => 'button_set',
                'options' => $enable_opts, 
                'default' => $default_value_w,
                'required'  => array( 
                    array( 'page_title', '!=', '0')
                ),
            ),
            array(
                'id'        => 'page_title_align',
                'title'     => esc_html__('Content Align', 'melokids'),
                'subtitle'  => esc_html__('choose text align for page title', 'melokids'),
                'default'   => $page_title_align_default,
                'type'      => 'select',
                'options'   => $page_title_align,
                'required'  => array( 
                    array( 'page_title', '!=', '0')
                )
            ),
            array(
                'id'        => 'page_title_bg',
                'title'     => esc_html__('Background', 'melokids'),
                'subtitle'  => esc_html__('Choose background style', 'melokids'),
                'default'   => array(),
                'type'      => 'background',
                'output'    => array('#zk-page-title-wrapper'),
                'required'  => array( 
                    array( 'page_title', '!=', '0')
                ),
            ),
            array(
                'id'        => 'page_title_bg_overlay',
                'title'     => esc_html__('Overlay Background', 'melokids'),
                'subtitle'  => esc_html__('Choose overlay background color', 'melokids'),
                'default'   => array(),
                'type'      => 'color_rgba',
                'output'    => array(
                    'background-color' => '.zk-page-title-overlay'
                ),
                'required'  => array( 
                    array( 'page_title', '!=', '0')
                ),
            ),
            array(
                'id'        => 'page_title_padding',
                'title'     => esc_html__('Padding', 'melokids'),
                'subtitle'  => esc_html__('Enter padding', 'melokids'),
                'type'      => 'spacing',
                'mode'      => 'padding',
                'units'     => array('px'),
                'default'   => array(),
                'output'    => array('#zk-page-title-wrapper'),
                'required'  => array( 
                    array( 'page_title', '!=', '0')
                ),
            ),
            array(
                'id'        => 'page_title_margin',
                'title'     => esc_html__('Margin', 'melokids'),
                'subtitle'  => esc_html__('Enter margin', 'melokids'),
                'type'      => 'spacing',
                'mode'      => 'margin',
                'units'     => array('px'),
                'default'   => array(),
                'output'    => array('#zk-page-title-wrapper'),
                'required'  => array( 
                    array( 'page_title', '!=', '0')
                ),
            )
        );
    }
}
/* Page Title Typo */
if(!function_exists('melokids_pagetitle_typo')){
    function melokids_pagetitle_typo(){
        return array(
            array(
                'title'     => esc_html__('Typography for Title', 'melokids'),
                'id'        => 'pagetitle_typo',
                'type'      => 'typography',
                'text-transform'    => true,
                'letter-spacing'    => true,
                'text-align'        => false,
                'default'   => array(),
                'output'    => array('.zk-page-title-text')
            ),
            array(
                'title'          => esc_html__('Typography for Subtitle', 'melokids'),
                'id'             => 'pagetitle_subtypo',
                'type'           => 'typography',
                'text-transform' => true,
                'letter-spacing' => true,
                'text-align'     => false,
                'default'        => array(),
                'output'         => array('.zk-page-title-text .sub-title')
            )
        );
    }
}
/* Breadcrumb Options */
if(!function_exists('melokids_pagetitle_breadcrumb_opts')){
    function melokids_pagetitle_breadcrumb_opts(){
        return array(
            array(
                'title'     => esc_html__('Typography for Breadcrumb', 'melokids'),
                'id'        => 'breadcrumb_typo',
                'type'      => 'typography',
                'text-transform'    => true,
                'letter-spacing'    => true,
                'text-align'        => false,
                'default'   => array(),
                'output'    => array('#zk-breadcrumb')
            ),
            array(
                'title'     => esc_html__('Link Color', 'melokids'),
                'id'        => 'breadcrumb_link_color',
                'type'      => 'link_color',
                'active'    => false,
                'default'   => array(),
                'output'    => array('#zk-breadcrumb a'),
                'validate'  => 'color'
            )
        );
    }
}

/**
 * Theme Options: Footer
 * All option for Footer
 *
 * Applied for theme option and page option
 *
 * variantion: $default
 * add default option on Page option 
 *
*/
if(!function_exists('melokids_footer_opts')){
    function melokids_footer_opts($default = false){
        $default_value = $default ? '-1' : '';
        return array(
            'title'  => esc_html__('Footer', 'melokids'),
            'icon'   => 'el el-credit-card',
            'fields' => array(
                array(
                    'title'       => esc_html__('Footer', 'melokids'),
                    'subtitle'    => esc_html__('Choose footer', 'melokids'),
                    'description' => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom footer layout first.','melokids'),'<a href="' . esc_url( admin_url( 'post-new.php?post_type=footer' ) ) . '">','</a>'),
                    'id'          => 'footer',
                    'type'        => 'select',
                    'options'     => melokids_list_post('footer', $default),
                    'default'     => $default_value
                ),
                array(
                    'title'       => esc_html__('Margin', 'melokids'),
                    'subtitle'    => esc_html__('Enter footer outer space', 'melokids'),
                    'id'          => 'footer_margin',
                    'type'        => 'spacing',
                    'mode'        => 'margin',
                    'units'       => array('px'),
                    'default'     => array(),
                    'output'      => '#zk-footer'
                )
            )
        );
    }
}


/**
 * WooCommerce Options 
 *
*/
if(!function_exists('melokids_woocommerce_opts')){
    function melokids_woocommerce_opts(){
        if(!class_exists('WooCommerce')) return;
        return array(
            'title'    => esc_html__('WooCommerce', 'melokids'),
            'desc'     => esc_html__('Config your shop page', 'melokids'),
            'icon'     => 'dashicons dashicons-wc-shop',
            'fields'   => array_merge(
                array(
                    array(
                        'id'          => 'wc_archive_layout',
                        'title'       => esc_html__('Products layout', 'melokids'),
                        'description' => esc_html__('This layout apply for products page: Recent, Category, Tag, Author, Search result, Taxonomy, ...', 'melokids'),
                        'type'        => 'button_set',
                        'options'     => array(
                            'left'     => esc_html__('Left Sidebar','melokids'), 
                            'full'     => esc_html__('No Sidebar','melokids'),
                            'right'    => esc_html__('Right Sidebar','melokids'), 
                        ), 
                        'default'   => 'right',
                    ),
                    array(
                        'id'        => 'wc_archive_sidebar',
                        'title'     => esc_html__('Sidebar', 'melokids'),
                        'placeholder'  => esc_html__('select a widget area for archive page', 'melokids'),
                        'type'      => 'select',
                        'data'      => 'sidebars',
                        'default'   => 'sidebar-shop',
                        'required'  => array( 0 => 'wc_archive_layout', 1 => '!=', 2 => 'full' )
                    ),
                    array(
                        'id'        => 'wc_archive_content_layout',
                        'title'     => esc_html__('Content Layouts', 'melokids'),
                        'description'  => esc_html__('select a layout for content', 'melokids'),
                        'type'      => 'button_set',
                        'options'   => array(
                            'grid'  =>  esc_html__('Grid','melokids'), 
                            'list'  =>  esc_html__('List','melokids'),
                        ),
                        'default'   => 'grid'
                    ),
                    array(
                        'id'        => 'wc_archive_coloumn',
                        'title'     => esc_html__('Grid Column', 'melokids'),
                        'description'  => esc_html__('Choose columns you want to show on Grid Layout', 'melokids'),
                        'type'      => 'button_set',
                        'options' => array(
                            '2'     => esc_html__('Two','melokids'),
                            '3'     => esc_html__('Three','melokids'), 
                            '4'     => esc_html__('Four','melokids'), 
                            '6'     => esc_html__('Six','melokids'), 
                        ), 
                        'default'   => '4',
                        'required'  => array('wc_archive_content_layout', '!=','list' )
                    ),
                    array(
                        'id'            => 'wc_archive_limit',
                        'title'         => esc_html__('Products per page', 'melokids'),
                        'description'   => esc_html__('Choose number product you want to show on each page', 'melokids'),
                        'type'          => 'slider',
                        'min'           => '1',
                        'max'           => '100',
                        'step'          => '1',
                        'default'       => '16',
                        'display_value' => 'label'
                    ),
                    array(
                        'title'     => esc_html__('Excerpt Length', 'melokids'),
                        'subtitle'  => esc_html__('Enter the number of word you want to show in excerpt', 'melokids'),
                        'description'  => esc_html__('Enter numeric only, do not include decimal or comma please. Enter \'0\' to remove excerpt text', 'melokids'),
                        'id'        => 'wc_loop_excerpt_length',
                        'type'      => 'text',
                        'validate'  => 'numeric',
                        'default'   => '0',
                    )
                )
            )
        );
    }
}
if(!function_exists('melokids_woocommerce_single_opts')){
    function melokids_woocommerce_single_opts($args=[]){
        if(!class_exists('WooCommerce')) return;
        $args = wp_parse_args($args, [
            'subsection' => true,
            'default'    => false
        ]);
        $single_product_layout_opts = [
            'left'     => esc_html__('Left Sidebar','melokids'), 
            'full'     => esc_html__('No Sidebar','melokids'),
            'right'    => esc_html__('Right Sidebar','melokids'), 
        ];

        $single_product_gallery_layout = array(
            'default' => esc_html__('Woo Default','melokids'),
            'slick-h' => esc_html__('Style 1 (Horizontal)','melokids'),
            'slick-v' => esc_html__('Style 2 (Vertical)','melokids'),
        );
        if($args['default']){
            $std = $std_gallery_layout = '-1';

            $single_product_layout_opts = (
                ['-1' => esc_html__('Default','melokids')] + $single_product_layout_opts
            );

            $single_product_gallery_layout = (
                ['-1' => esc_html__('Theme Default','melokids')] + $single_product_gallery_layout
            );

        } else {
            $std = 'right';
            $std_gallery_layout = 'default';
        }
        return array(
            'title'     => esc_html__('Single Product', 'melokids'),
            'icon'      => 'dashicons dashicons-wc-single',
            'subsection'=> $args['subsection'],
            'fields'    => array_merge(
                array(
                    array(
                        'id'          => 'single_product_layout',
                        'title'       => esc_html__('Product layout', 'melokids'),
                        'description' => esc_html__('This layout apply for single product page', 'melokids'),
                        'type'        => 'button_set',
                        'options'     => $single_product_layout_opts, 
                        'default'     => $std,
                    ),
                    array(
                        'id'        => 'single_product_sidebar',
                        'title'     => esc_html__('Sidebar', 'melokids'),
                        'placeholder'  => esc_html__('select a widget area for single product page', 'melokids'),
                        'type'      => 'select',
                        'data'      => 'sidebars',
                        'default'   => 'sidebar-shop',
                        'required'    => array(
                            array('single_product_layout','=', array('left','right')),
                        )
                    ),
                    array(
                        'id'          => 'single_product_gallery_layout',
                        'title'       => esc_html__('Gallery Layout', 'melokids'),
                        'description' => esc_html__('Select Gallery Layout For Product Page', 'melokids'),
                        'type'        => 'select',
                        'options'     => $single_product_gallery_layout,
                        'default'     => $std_gallery_layout,
                    ),
                    array(
                        'id'          => 'single_product_related',
                        'title'       => esc_html__('Related products', 'melokids'),
                        'description' => esc_html__('Show related product', 'melokids'),
                        'type'        => 'switch',
                        'default'     => '1',
                    ),
                    array(
                        'id'          => 'single_product_related_item',
                        'title'       => esc_html__('Related items', 'melokids'),
                        'description' => esc_html__('Enter the number of product you want to show', 'melokids'),
                        'type'        => 'text',
                        'default'     => '12',
                        'required'    => array('single_product_related','=','1' )
                    )
                )
            )
        );
    }
}