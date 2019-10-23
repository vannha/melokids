<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */
if (! class_exists('Redux')) {
    return;
}
// This line is only for altering the demo. Can be easily removed.
$opt_name = apply_filters('opt_name', 'theme_options');

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array( 
    // TYPICAL -> Change these values as you need/desire
    'opt_name' => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name' => $theme->get('Name'),
    // Name that appears at the top of your panel
    'display_version' => $theme->get('Version'),
    // Version that appears at the top of your panel
    'menu_type' => 'menu', 
    // Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu' => true,
    // Show the sections below the admin menu item or not
    'menu_title' => $theme->get('Name'),
    'page_title' => $theme->get('Name'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key' => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography' => false,
    // Use a asynchronous font on the front end or font string
    // 'disable_google_fonts_link' => true, // Disable this in case you want to create your own google fonts loader
    'admin_bar' => false,
    // Show the panel pages on the admin bar
    'admin_bar_icon' => 'dashicons-smiley',
    // Choose an icon for the admin bar menu
    'admin_bar_priority' => 50,
    // Choose an priority for the admin bar menu
    'global_variable' => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode' => false,
    // Show the time the page took to load, etc
    'update_notice' => true,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer' => true,
    // Enable basic customizer support
    // 'open_expanded' => true, // Allow you to start the panel in an expanded way initially.
    'disable_save_warn' => true, // Disable the save warning when a user changes a field

    // OPTIONAL -> Give you extra features
    'page_priority' => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent' => 'themes.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions' => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon' => 'dashicons-dashboard',
    // Specify a custom URL to an icon
    'last_tab' => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon' => 'dashicons-smiley',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug' => '',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults' => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show' => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark' => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export' => false,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time' => 60 * MINUTE_IN_SECONDS,
    'output' => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag' => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit' => '', // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database' => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn' => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    // HINTS
    'hints' => array(
        'icon' => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color' => 'lightgray',
        'icon_size' => 'normal',
        'tip_style' => array(
            'color' => 'red',
            'shadow' => true,
            'rounded' => false,
            'style' => ''
        ),
        'tip_position' => array(
            'my' => 'top left',
            'at' => 'bottom right'
        ),
        'tip_effect' => array(
            'show' => array(
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'mouseover'
            ),
            'hide' => array(
                'effect' => 'slide',
                'duration' => '500',
                'event' => 'click mouseleave'
            )
        )
    )
);

Redux::setArgs($opt_name, $args);

/**
 * General
 * 
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title'     => esc_html__('General', 'melokids'),
    'icon'      => 'dashicons dashicons-admin-home',
    'fields'    => array_merge(
        melokids_general_opts()
    )
));

/**
 * Extra
 * 
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title'     => esc_html__('Extra', 'melokids'),
    'icon'      => 'dashicons dashicons-plus-alt',
    'subsection'=> true,
    'fields'    => array(
        array(
            'title'     => esc_html__('Enable Page Loading', 'melokids'),
            'subtitle'  => '',
            'id'        => 'page_loading',
            'type'      => 'switch',
            'default'   => '1'
        ),
        array(
            'title'     => esc_html__('Page Loadding Style','melokids'),
            'subtitle'  => esc_html__('Select Style Page Loadding.','melokids'),
            'id'        => 'page_loading_style',
            'type'      => 'select',
            'options'   => array(
                'flip-box'         => esc_html__('Flip Box','melokids'),
                'double-bounce'    => esc_html__('Double Bounce','melokids'),
                'wave'             => esc_html__('Wave','melokids'),
                'double-cube'      => esc_html__('Double Cube','melokids'),
                'scaleout'         => esc_html__('Scale Out','melokids'),
                'double-dots'      => esc_html__('Double Dots','melokids'),
                'three-dot-bounce' => esc_html__('Three Circle Bounce','melokids'),
                'circle-loading'   => esc_html__('Circle Loading','melokids'),
                'cube-grid'        => esc_html__('Cube Grid','melokids'),
                'fading-circle'    => esc_html__('Fading Circle','melokids'),
                'folding-cube'     => esc_html__('Folding Cube','melokids'),
            ),
            
            'default'   => 'fading-circle',
            'required'  => array( 0 => 'page_loading', 1 => '=', 2 => 1 )
        ) ,
        array(
            'title'     => esc_html__('Enable Back To Top', 'melokids'),
            'subtitle'  => '',
            'id'        => 'backtotop',
            'type'      => 'switch',
            'default'   => '1'
        ),
    )
));

/**
 * Styling
 * 
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title'     => esc_html__('Theme Color', 'melokids'),
    'icon'      => 'dashicons dashicons-art',
    'fields'    => array(
        array(
            'title'     => esc_html__('Primary Color', 'melokids'),
            'subtitle'  => esc_html__('Choose your primary color.', 'melokids'),
            'id'        => 'primary_color',
            'type'      => 'color_rgba',
        ),
        array(
            'title'     => esc_html__('Accent Color', 'melokids'),
            'subtitle'  => esc_html__('Choose your accent color.', 'melokids'),
            'id'        => 'accent_color',
            'type'      => 'color_rgba',
        )
    )
));
/**
 * Typography
 * 
 * @author Chinh Duong Manh
 */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Typography', 'melokids'),
    'heading' => '',
    'icon' => 'el-icon-text-width',
    'fields' => array(
        array(
            'id'                =>  'font_body',
            'type'              =>  'typography',
            'title'             =>  esc_html__('Body Font', 'melokids'),
            'text-transform'    =>  true,
            'letter-spacing'    =>  true,
            'text-align'        =>  false,
            'output'            =>  array('body'),
            'units'             =>  'px',
            'subtitle'          =>  esc_html__('Typography option with each property can be called individually.', 'melokids'),
        )
    )
));
/**
 * Heading Font
 * 
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Heading', 'melokids'),
    'heading' => esc_html__('Choose style for all heading style', 'melokids'),
    'icon' => 'el-icon-text-width',
    'subsection' => true,
    'fields' => array(
        array(
            'id'                => 'heading_h1',
            'type'              => 'typography',
            'title'             => esc_html__('H1', 'melokids'),
            'subtitle'          => esc_html__('Typography option with each property can be called individually.', 'melokids'),
            'description'       => esc_html__('If not choose any option here, all style for h1 will applied by default theme style.', 'melokids'),
            'text-transform'    =>  true,
            'letter-spacing'    =>  true,
            'text-align'        =>  false,
            'output'            => array('h1, .h1, h1 a, .h1 a'),
            'units'             => 'px',
        ),
        array(
            'id'             =>  'heading_h2',
            'type'           =>  'typography',
            'title'          =>   esc_html__('H2', 'melokids'),
            'subtitle'       =>  esc_html__('Typography option with each property can be called individually.', 'melokids'),
            'description'    =>  esc_html__('If not choose any option here, all style for h2 will applied by default theme style.', 'melokids'),
            'text-transform' =>  true,
            'letter-spacing' =>  true,
            'text-align'     =>  false,
            'output'         =>  array('h2, .h2, h2 a, .h2 a'),
            'units'          =>  'px',
        ),
        array(
            'id'             =>  'heading_h3',
            'type'           =>  'typography',
            'title'          =>   esc_html__('H3', 'melokids'),
            'subtitle'       =>  esc_html__('Typography option with each property can be called individually.', 'melokids'),
            'description'    =>  esc_html__('If not choose any option here, all style for h3 will applied by default theme style.', 'melokids'),
            'text-transform' =>  true,
            'letter-spacing' =>  true,
            'text-align'     =>  false,
            'output'         =>  array('h3, .h3, h3 a, .h3 a'),
            'units'          =>  'px',
        ),
        array(
            'id'             =>  'heading_h4',
            'type'           =>  'typography',
            'title'          =>   esc_html__('H4', 'melokids'),
            'subtitle'       =>  esc_html__('Typography option with each property can be called individually.', 'melokids'),
            'description'    =>  esc_html__('If not choose any option here, all style for h4 will applied by default theme style.', 'melokids'),
            'text-transform' =>  true,
            'letter-spacing' =>  true,
            'text-align'     =>  false,
            'output'         =>  array('h4, .h4, h4 a, .h4 a'),
            'units'          =>  'px',
        ),
        array(
            'id'             =>  'heading_h5',
            'type'           =>  'typography',
            'title'          =>   esc_html__('H5', 'melokids'),
            'subtitle'       =>  esc_html__('Typography option with each property can be called individually.', 'melokids'),
            'description'    =>  esc_html__('If not choose any option here, all style for h5 will applied by default theme style.', 'melokids'),
            'text-transform' =>  true,
            'letter-spacing' =>  true,
            'text-align'     =>  false,
            'output'         =>  array('h5, .h5, h5 a, .h5 a'),
            'units'          =>  'px',
        ),
        array(
            'id'             =>  'heading_h6',
            'type'           =>  'typography',
            'title'          =>  esc_html__('H6', 'melokids'),
            'subtitle'       =>  esc_html__('Typography option with each property can be called individually.', 'melokids'),
            'description'    =>  esc_html__('If not choose any option here, all style for h6 will applied by default theme style.', 'melokids'),
            'text-transform' =>  true,
            'letter-spacing' =>  true,
            'text-align'     =>  false,
            'output'         =>  array('h6, .h6, h6 a, .h6 a'),
            'units'          =>  'px',
        ),
    )
));

/* extra font. */
$custom_font_1 = Redux::getOption($opt_name, 'extra_font_selector');
$custom_font_1 = !empty($custom_font_1) ? explode(',', $custom_font_1) : array();

$custom_font_2 = Redux::getOption($opt_name, 'extra_font_selector2');
$custom_font_2 = !empty($custom_font_2) ? explode(',', $custom_font_2) : array();

Redux::setSection($opt_name, array(
    'title' => esc_html__('Extra Fonts', 'melokids'),
    'icon' => 'el el-fontsize',
    'subsection' => true,
    'fields' => array(
        array(
            'id'            => 'extra_font',
            'type'          => 'typography',
            'title'         => esc_html__('Custom Font', 'melokids'),
            'google'        => true,
            'font-backup'   => true,
            'all_styles'    => true,
            'color'         => false,
            'font-style'    => false,
            'font-weight'   => false,
            'font-size'     => false,
            'line-height'   => false,
            'text-align'    => false,
            'output'        =>  $custom_font_1,
            'units'         => 'px',
            'subtitle'      => esc_html__('Choose a font for some special place.', 'melokids'),
            'default'       => array(
            )
        ),
        array(
            'id'        => 'extra_font_selector',
            'type'      => 'textarea',
            'title'     => esc_html__('Selector', 'melokids'),
            'subtitle'  => esc_html__('add html tags ID or class (body,a,.class-name,#id-name)', 'melokids'),
            'validate'  => 'no_html',
            'default'   => '',
        ),
        array(
            'id'            => 'extra_font2',
            'type'          => 'typography',
            'title'         => esc_html__('Custom Font 2', 'melokids'),
            'google'        => true,
            'font-backup'   => true,
            'all_styles'    => true,
            'color'         => false,
            'font-style'    => false,
            'font-weight'   => false,
            'font-size'     => false,
            'line-height'   => false,
            'text-align'    => false,
            'output'        =>  $custom_font_2,
            'units'         => 'px',
            'subtitle'      => esc_html__('Choose a font for some special place.', 'melokids'),
            'default'       => array(
            )
        ),
        array(
            'id'        => 'extra_font_selector2',
            'type'      => 'textarea',
            'title'     => esc_html__('Selector', 'melokids'),
            'subtitle'  => esc_html__('add html tags ID or class (body,a,.class-name,#id-name)', 'melokids'),
            'validate'  => 'no_html',
            'default'   => '',
        )
    )
));

/* Header Banner section Option */
Redux::setSection($opt_name, melokids_header_banner_opts());

/* Header TOP section Option */
Redux::setSection($opt_name, melokids_header_top_opts());

/**
 * Header 
 * @author Chinh Duong Manh
 * @since 1.0.0
*/
Redux::setSection($opt_name, array(
    'title' => esc_html__('Header', 'melokids'),
    'icon' => 'el-icon-credit-card',
    'fields' => array_merge( 
        melokids_header_layout_opts(),
        array(        
            array(
                'title'    => esc_html__('Mega Menu', 'melokids'),
                'subtitle' => esc_html__('Enable mega menu', 'melokids'),
                'id'       => 'enable_mega_menu',
                'type'     => 'switch',
                'default'  => '1',
            )
        )
    )
));
/* Logo Option */
Redux::setSection($opt_name, array(
    'title'         => esc_html__('Logo', 'melokids'),
    'heading'       => '',
    'icon'          => 'el-icon-picture',
    'subsection'    => true,
    'fields'        => array(
        array(
            'title'     => esc_html__('Logo Image', 'melokids'),
            'subtitle'  => esc_html__('Select an image file for your logo.', 'melokids'),
            'id'        => 'main_logo',
            'type'      => 'media',
            'default'   => array()
        ),
        array(
            'title'     => esc_html__('Logo Width', 'melokids'),
            'subtitle'  => esc_html__('Fixed width for logo!', 'melokids'),
            'id'        => 'logo_size',
            'type'      => 'dimensions',
            'units'     => array('px'),
            'height'    => false,
            'default'   => array(),
            'output'    => '#zk-logo',
        )
    )
));

/* Header Attributes */
Redux::setSection($opt_name, array(
    'title'         => esc_html__('Attributes', 'melokids'),
    'heading'       => '',
    'icon'          => 'el el-plus',
    'subsection'    => true,
    'fields'        => array_merge(
        melokids_header_atts_opts()
    )
));
/* Header Default */
Redux::setSection($opt_name, array(
    'title'         => esc_html__('Header Default', 'melokids'),
    'heading'       => '',
    'icon'          => 'el-icon-credit-card',
    'subsection'    => true,
    'fields'        => array(
        array(
            'title'     => esc_html__('Background Color', 'melokids'),
            'subtitle'  => esc_html__('choose Background color style.', 'melokids'),
            'id'        => 'header_bg_color',
            'type'      => 'color_rgba',
            'default'   => array(),
            'output'    => array(
                'background-color' => '.header-default',
            ),
            'validate'  => 'colorrgba'
        ),
        array(
            'title'     => esc_html__('Background Image', 'melokids'),
            'subtitle'  => esc_html__('choose Background image style.', 'melokids'),
            'id'        => 'header_bg',
            'type'      => 'background',
            'background-color'  => false,
            'default'   => array(),
            'output'    => array('.header-default')
        ),
        array(
            'title'     => esc_html__('Typography', 'melokids'),
            'subtitle'  => esc_html__('This option just applied for Menu first level', 'melokids'),
            'id'        => 'header_typo',
            'type'      => 'typography',
            'text-transform'    => true,
            'letter-spacing'    => true,
            'line-height'       => false,
            'color'             => false,
            'text-align'        => false,
            'font-style'        => false,
            'default'           => array(),
            'output'            => array(
                '.zk-nav-extra',
                'ul.desktop-nav > li > a',
                '#zk-logo .logo-text'
            )
        ),
        array(
            'title'     => esc_html__('Link Color', 'melokids'),
            'subtitle'  => esc_html__('This option just applied for Menu first level', 'melokids'),
            'id'        => 'header_fl_color',
            'type'      => 'link_color',
            'default'   => array(),
            'output'    => array(),
            'validate'  => 'color'
        ),
    )
));

/* Header on Top */
Redux::setSection($opt_name, array(
    'title'         => esc_html__('Header on Top', 'melokids'),
    'heading'       => '',
    'icon'          => 'el-icon-credit-card',
    'subsection'    => true,
    'fields'        => array_merge(
        melokids_header_ontop_opts()
    )
));
/* Sticky Header */
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Sticky Header', 'melokids'),
    'heading'    => '',
    'icon'       => 'el-icon-credit-card',
    'subsection' => true,
    'fields'     => array_merge(
        melokids_header_sticky_opts()
    )
));

/* Dropdown & Mobile Menu */
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Dropdown & Mobile', 'melokids'),
    'heading'    => esc_html__('All style in this section will apply for Dropdown & Mobile Menu','melokids'),
    'icon'       => 'dashicons dashicons-networking',
    'subsection' => true,
    'fields'     => array(
        array(
            'title'     => esc_html__('Background', 'melokids'),
            'subtitle'  => esc_html__('Choose background style.', 'melokids'),
            'id'        => 'header_dropdown_mobile_bg',
            'type'      => 'background',
            'default'   => array(),
            'output'    => array(
                '.zk-main-nav.desktop-nav .sub-menu',
                '.zk-main-nav.mobile-nav'
            )
        ),
        array(
            'title'     => esc_html__('Typography', 'melokids'),
            'subtitle'  => esc_html__('Choose typography style.', 'melokids'),
            'id'        => 'header_dropdown_mobile_typo',
            'type'      => 'typography',
            'text-transform'    => true,
            'letter-spacing'    => true,
            'color'             => false,
            'default'   => array(),
            'output'    => array(
                '.zk-main-nav.desktop-nav .sub-menu',
                '.zk-main-nav.mobile-nav'
            )
        ),
        array(
            'title'     => esc_html__('Link Color', 'melokids'),
            'subtitle'  => esc_html__('Choose color for menu in Dropdown & Mobile', 'melokids'),
            'id'        => 'header_dropdown_mobile_color',
            'type'      => 'link_color',
            'default'   => array(),
            'output'    => array(),
            'validate'  => 'color'
        ),
    )
));


/**
 * Page Title & Breadcrumb
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title'     => esc_html__('Page Title & BC', 'melokids'),
    'icon'      => 'el-icon-map-marker',
    'fields'    => array_merge(
        melokids_pagetitle_opts()
    )
));

/* Page title  */
Redux::setSection($opt_name, array(
    'icon'          => 'el el-text-width',
    'title'         => esc_html__('Page title', 'melokids'),
    'heading'       => '',
    'subsection'    => true,
    'fields'        => array_merge(
        melokids_pagetitle_typo()
    )
));

/* Breadcrumb */
Redux::setSection($opt_name, array(
    'icon'       => 'el-icon-random',
    'title'      => esc_html__('Breadcrumb', 'melokids'),
    'subsection' => true,
    'fields'     => array_merge(
        melokids_pagetitle_breadcrumb_opts()
    )
));

/**
 * Main Content
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title'   => esc_html__('Content', 'melokids'),
    'heading' => esc_html__('Main Content Settings','melokids'),
    'icon'    => 'el el-website',
    'fields'  => array_merge(
        melokids_main_content_opts()
    )
));
/**
 * Content Area
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Content Area', 'melokids'),
    'icon'       => 'el el-website',
    'subsection' => true,
    'fields'     => array(
        array(
            'title'     => esc_html__('Background', 'melokids'),
            'subtitle'  => esc_html__('Choose background style', 'melokids'),
            'id'        => 'contentarea_bg',
            'type'      => 'background',
            'default'   => array(),
            'output'    => array('#content-area')
        ),
        array(
            'title'     => esc_html__('Padding', 'melokids'),
            'subtitle'  => esc_html__('Choose space for: Top, Right, Bottom, Left', 'melokids'),
            'id'        => 'contentarea_padding',
            'type'      => 'spacing',
            'mode'      => 'padding',
            'units'     => array('px'),
            'default'   => array(),
            'output'    => array('#content-area')
        ),
    )
));
/**
 * Sidebar Area
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Sidebar Area', 'melokids'),
    'icon'       => 'el el-website',
    'subsection' => true,
    'fields'     => array(
        array(
            'title'     => esc_html__('Background', 'melokids'),
            'subtitle'  => esc_html__('Choose background style', 'melokids'),
            'id'        => 'sidebararea_bg',
            'type'      => 'background',
            'default'   => array(),
            'output'    => array('#sidebar-area')
        ),
        array(
            'title'     => esc_html__('Padding', 'melokids'),
            'subtitle'  => esc_html__('Choose space for: Top, Right, Bottom, Left', 'melokids'),
            'id'        => 'sidebararea_padding',
            'type'      => 'spacing',
            'mode'      => 'padding',
            'units'     => array('px'),
            'default'   => array(),
            'output'    => array('#sidebar-area')
        ),
    )
));
/**
 * Page Options
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title'         => esc_html__('Page Options', 'melokids'),
    'icon'          => 'dashicons dashicons-schedule',
    'subsection'    => true,
    'fields'        => array_merge(
        melokids_page_layout_opts()
    )
));
/**
 * Blog Options
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title'         => esc_html__('Archives Options', 'melokids'),
    'icon'          => 'dashicons dashicons-schedule',
    'subsection'    => true,
    'fields'        => array(
        array(
            'id'          => 'archive_layout',
            'title'       => esc_html__('Archives page layout', 'melokids'),
            'description' => esc_html__('This layout apply for archives page: Recent Post, Category, Tag, Author, Search result, Taxonomy, ...', 'melokids'),
            'type'        => 'button_set',
            'options'     => array(
                'left'     => esc_html__('Left Sidebar','melokids'), 
                'full'     => esc_html__('No Sidebar','melokids'),
                'right'    => esc_html__('Right Sidebar','melokids'), 
            ), 
            'default'   => 'right',
        ),
        array(
            'id'        => 'archive_sidebar',
            'title'     => esc_html__('Sidebar', 'melokids'),
            'placeholder'  => esc_html__('select a widget area for archive page', 'melokids'),
            'type'      => 'select',
            'data'      => 'sidebars',
            'default'   => 'sidebar-main',
            'required'  => array( 0 => 'archive_layout', 1 => '!=', 2 => 'full' )
        ),
        array(
            'id'        => 'archive_content_layout',
            'title'     => esc_html__('Content Layouts', 'melokids'),
            'subtitle'  => esc_html__('select a layout for content', 'melokids'),
            'type'      => 'button_set',
            'options'   => array(
                'grid'  =>  esc_html__('Grid','melokids'), 
                'list'  =>  esc_html__('List','melokids'),
            ),
            'default'   => 'list'
        ),
        array(
            'id'        => 'archive_content_coloumn',
            'title'     => esc_html__('Archives Column', 'melokids'),
            'description'  => esc_html__('Choose columns you want to show on Archives Page', 'melokids'),
            'type'      => 'button_set',
            'options' => array(
                '1'     => esc_html__('One','melokids'), 
                '2'     => esc_html__('Two','melokids'),
                '3'     => esc_html__('Three','melokids'), 
                '4'     => esc_html__('Four','melokids'), 
                '6'     => esc_html__('Six','melokids'), 
            ), 
            'default'   => '2',
            'required'  => array( 0 => 'archive_content_layout', 1 => '!=', 2 => 'list' )
        ),
        array(
            'title'     => esc_html__('Excerpt Length', 'melokids'),
            'subtitle'  => esc_html__('Enter the number of word you want to show in excerpt', 'melokids'),
            'description'  => esc_html__('Enter numeric only, do not include decimal or comma please. Enter \'0\' to remove excerpt text', 'melokids'),
            'id'        => 'loop_excerpt_length',
            'type'      => 'text',
            'validate'  => 'numeric',
            'default'   => '55',
        ),
        array(
            'title'     => esc_html__('Show Author', 'melokids'),
            'subtitle'  => esc_html__('Show/Hide post author', 'melokids'),
            'id'        => 'loop_author',
            'type'      => 'switch',
            'default'   => '1',
        ),
        array(
            'title'     => esc_html__('Show Date', 'melokids'),
            'subtitle'  => esc_html__('Show/Hide post date', 'melokids'),
            'id'        => 'loop_date',
            'type'      => 'switch',
            'default'   => '1',
        ),
        array(
            'title'     => esc_html__('Show Category', 'melokids'),
            'subtitle'  => esc_html__('Show/Hide post categories', 'melokids'),
            'id'        => 'loop_category',
            'type'      => 'switch',
            'default'   => '1',
        ),
        array(
            'title'     => esc_html__('Show tags', 'melokids'),
            'subtitle'  => esc_html__('Show/Hide post tags', 'melokids'),
            'id'        => 'loop_tags',
            'type'      => 'switch',
            'default'   => '0',
        ),
        array(
            'title'     => esc_html__('Show Comment', 'melokids'),
            'subtitle'  => esc_html__('Show/Hide post comment count', 'melokids'),
            'id'        => 'loop_cmt',
            'type'      => 'switch',
            'default'   => '1',
        ),
        array(
            'title'     => esc_html__('Show Views', 'melokids'),
            'subtitle'  => esc_html__('Show/Hide post view count', 'melokids'),
            'id'        => 'loop_view',
            'type'      => 'switch',
            'default'   => '0',
        ),
        array(
            'title'     => esc_html__('Show Like', 'melokids'),
            'subtitle'  => esc_html__('Show/Hide post Like count', 'melokids'),
            'id'        => 'loop_like',
            'type'      => 'switch',
            'default'   => '0',
        ),
        array(
            'title'     => esc_html__('Show Share', 'melokids'),
            'subtitle'  => esc_html__('Show/Hide share to', 'melokids'),
            'id'        => 'loop_share',
            'type'      => 'switch',
            'default'   => '0',
        ),
        array(
            'title'     => esc_html__('Read More', 'melokids'),
            'subtitle'  => esc_html__('Show/Hide Read More button', 'melokids'),
            'id'        => 'loop_readmore',
            'type'      => 'switch',
            'default'   => '1',
        ),
    )
));


/**
 * Single Post
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title'         => esc_html__('Single Post', 'melokids'),
    'icon'          => 'dashicons dashicons-align-left',
    'subsection'    => true,
    'fields'        => array_merge(
        melokids_post_layout_opts(),
        array(
            array(
                'title'     => esc_html__('Show Author', 'melokids'),
                'subtitle'  => esc_html__('Show/Hide post author', 'melokids'),
                'id'        => 'single_author',
                'type'      => 'switch',
                'default'   => '1',
            ),
            array(
                'title'     => esc_html__('Show Date', 'melokids'),
                'subtitle'  => esc_html__('Show/Hide post date', 'melokids'),
                'id'        => 'single_date',
                'type'      => 'switch',
                'default'   => '1',
            ),
            array(
                'title'     => esc_html__('Show Category', 'melokids'),
                'subtitle'  => esc_html__('Show/Hide post categories', 'melokids'),
                'id'        => 'single_category',
                'type'      => 'switch',
                'default'   => '1',
            ),
            array(
                'title'     => esc_html__('Show tags', 'melokids'),
                'subtitle'  => esc_html__('Show/Hide post tags', 'melokids'),
                'id'        => 'single_tags',
                'type'      => 'switch',
                'default'   => '1',
            ),
            array(
                'title'     => esc_html__('Show Comment', 'melokids'),
                'subtitle'  => esc_html__('Show/Hide post comment count', 'melokids'),
                'id'        => 'single_comment',
                'type'      => 'switch',
                'default'   => '1',
            ),
            array(
                'title'     => esc_html__('Show Views', 'melokids'),
                'subtitle'  => esc_html__('Show/Hide post view count', 'melokids'),
                'id'        => 'single_view',
                'type'      => 'switch',
                'default'   => '0',
            ),
            array(
                'title'     => esc_html__('Show Like', 'melokids'),
                'subtitle'  => esc_html__('Show/Hide post Like count', 'melokids'),
                'id'        => 'single_like',
                'type'      => 'switch',
                'default'   => '0',
            ),
            array(
                'title'     => esc_html__('Show share', 'melokids'),
                'subtitle'  => esc_html__('Show/Hide icon to social site, like: facebook, twitter, google plus and linkedin', 'melokids'),
                'id'        => 'single_share',
                'type'      => 'switch',
                'default'   => '0',
            ),

            array(
                'title'     => esc_html__('Show about author', 'melokids'),
                'subtitle'  => esc_html__('Show/Hide author information', 'melokids'),
                'id'        => 'single_author_info',
                'type'      => 'switch',
                'default'   => '0',
            ),
            
            array(
                'title'     => esc_html__('Show Next / Preview Post', 'melokids'),
                'subtitle'  => esc_html__('Show/Hide Next / Preview link to other post', 'melokids'),
                'id'        => 'single_nav',
                'type'      => 'switch',
                'default'   => '1',
            ),

            array(
                'title'     => esc_html__('Show Related Post', 'melokids'),
                'subtitle'  => esc_html__('Show/Hide related post. Related post using Post Tag', 'melokids'),
                'id'        => 'single_related',
                'type'      => 'switch',
                'default'   => '0',
            ),
            array(
                'title'     => esc_html__('Show Comment List & Form', 'melokids'),
                'subtitle'  => esc_html__('Show/Hide post commented list & Comment Form', 'melokids'),
                'id'        => 'single_comment_list_form',
                'type'      => 'switch',
                'default'   => '1',
            )
        )
    )
));
/**
 * WooCommerce
*/
Redux::setSection($opt_name, melokids_woocommerce_opts());
Redux::setSection($opt_name, melokids_woocommerce_single_opts());
/**
 * Footer
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, melokids_footer_opts());

/**
 * Button Options
 *
 * Add some extra config for button
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title'         => esc_html__('Button Options', 'melokids'),
    'heading'       => '',
    'icon'          => 'dashicons dashicons-editor-bold',
    'fields'        => array(
    )
));

/* Default */
Redux::setSection($opt_name, array(
    'title'         => esc_html__('Default Button', 'melokids'),
    'heading'       => esc_html__('Choose style for Default Button', 'melokids'),
    'icon'          => 'dashicons dashicons-editor-bold',
    'subsection'    => true,
    'fields'        => array(
        array(
            'title'     => esc_html__('Typography', 'melokids'),
            'subtitle'  => esc_html__('all style for: font-family, font-size, ...', 'melokids'),
            'id'        => 'btn_default_typo',
            'type'      => 'typography',
            'text-transform'    => true,
            'letter-spacing'    => true,
            'color'             => false,
            'text-align'        => false,
            'line-height'       => false,
        ),
        array(
            'title'     => esc_html__('Text Color', 'melokids'),
            'subtitle'  => esc_html__('choose style for color text of button', 'melokids'),
            'id'        => 'btn_default_color',
            'type'      => 'link_color',
            'active'    => false,
            'validate'  => 'color'
        ),
        array(
            'title'    => esc_html__('Border', 'melokids'),
            'subtitle' => esc_html__('Choose border style for default button', 'melokids'),
            'id'       => 'btn_default_border',
            'type'     => 'border',
            'all'      => false,
        ),
        array(
            'title'    => esc_html__('Border Radius', 'melokids'),
            'subtitle'     => esc_html__('This option will apply for button radius', 'melokids'),
            'id'       => 'btn_default_border_radius',
            'type'     => 'dimensions',
            'height'   => false,
            'units'    => array('px','%'),
        ),
        array(
            'title'     => esc_html__('Background', 'melokids'),
            'subtitle'  => esc_html__('background style default', 'melokids'),
            'id'        => 'btn_default_bg',
            'type'      => 'background',
        ),
        array(
            'title'     => '',
            'subtitle'  => esc_html__('background style on mouse over', 'melokids'),
            'id'        => 'btn_default_bg_hover',
            'type'      => 'background',
        ),
    )
));
/* Primary */
Redux::setSection($opt_name, array(
    'title'         => esc_html__('Primary Button', 'melokids'),
    'heading'       => esc_html__('Choose style for Primary Button', 'melokids'),
    'icon'          => 'dashicons dashicons-editor-bold',
    'subsection'    => true,
    'fields'        => array(
        array(
            'title'     => esc_html__('Typography', 'melokids'),
            'subtitle'  => esc_html__('all style for: font-family, font-size, ...', 'melokids'),
            'id'        => 'btn_primary_typo',
            'type'      => 'typography',
            'text-transform'    => true,
            'letter-spacing'    => true,
            'color'             => false,
            'text-align'        => false,
            'line-height'        => false,
        ),
        array(
            'title'     => esc_html__('Text Color', 'melokids'),
            'subtitle'  => esc_html__('choose style for color text of button', 'melokids'),
            'id'        => 'btn_primary_color',
            'type'      => 'link_color',
            'active'    => false,
            'validate'  => 'color'
        ),
        array(
            'title'    => esc_html__('Border', 'melokids'),
            'subtitle' => esc_html__('Choose border style for primary button', 'melokids'),
            'id'       => 'btn_primary_border',
            'type'     => 'border',
            'all'      => false,
        ),
        array(
            'title'    => esc_html__('Border Radius', 'melokids'),
            'subtitle'     => esc_html__('This option will apply for button radius: Top, Right, Bottom, Left', 'melokids'),
            'id'       => 'btn_primary_border_radius',
            'type'     => 'dimensions',
            'height'   => false,
            'units'    => array('px'),
            'default'  => array(),
        ),
        array(
            'title'     => esc_html__('Background', 'melokids'),
            'subtitle'  => esc_html__('background style default', 'melokids'),
            'id'        => 'btn_primary_bg',
            'type'      => 'background',
        ),
        array(
            'title'     => '',
            'subtitle'  => esc_html__('background style on mouse over', 'melokids'),
            'id'        => 'btn_primary_bg_hover',
            'type'      => 'background',
        ),
    )
));

/* Social Media  */
Redux::setSection($opt_name, array(
    'title'         => esc_html__('Social Link', 'melokids'),
    'heading'       => esc_html__('Add your social network', 'melokids'),
    'desc'          => esc_html__('IMPORTANT: if you want to add skype chat button, please use: htttp://skype.your-skype-name, ex: http://skype.chinhjm, replace \'chinhjm\' with your skype name', 'melokids'),
    'icon'          => 'dashicons dashicons-share',
    'fields'        => array(
        array(
            'id'         => 's1_title',
            'type'       => 'text',
            'title'      => esc_html__('Title 1', 'melokids'),
            'subtitle'   => esc_html__('Enter title', 'melokids'),
            'desc'       => esc_html__('Example: Facebook', 'melokids'),
        ),
        array(
            'id'         => 's1_url',
            'type'       => 'text',
            'title'      => esc_html__('Link 1', 'melokids'),
            'validate'   => 'url',
            'subtitle'   => esc_html__('Enter your link', 'melokids'),
            'desc'       => esc_html__('Example: https://facebook.com', 'melokids'),
        ),
        array(
            'id'         => 's1_icon',
            'type'       => 'text',
            'title'      => esc_html__('Icon 1', 'melokids'),
            'validate'   => 'html',
            'subtitle'   => esc_html__('Add class of your icon font', 'melokids'),
            'desc'       => esc_html__('Example: fa fa-facebook', 'melokids'),
        ),
        array(
            'id'         => 's2_title',
            'type'       => 'text',
            'title'      => esc_html__('Title 2', 'melokids'),
            'subtitle'   => esc_html__('Enter title', 'melokids'),
            'desc'       => esc_html__('Example: Facebook', 'melokids'),
        ),
        array(
            'id'         => 's2_url',
            'type'       => 'text',
            'title'      => esc_html__('Link 2', 'melokids'),
            'validate'   => 'url',
            'subtitle'   => esc_html__('Enter your link', 'melokids'),
            'desc'       => esc_html__('Example: https://facebook.com', 'melokids'),
        ),
        array(
            'id'         => 's2_icon',
            'type'       => 'text',
            'title'      => esc_html__('Icon 2', 'melokids'),
            'validate'   => 'html',
            'subtitle'   => esc_html__('Add class of your icon font', 'melokids'),
            'desc'       => esc_html__('Example: fa fa-facebook', 'melokids'),
        ),
        array(
            'id'         => 's3_title',
            'type'       => 'text',
            'title'      => esc_html__('Title 3', 'melokids'),
            'subtitle'   => esc_html__('Enter title', 'melokids'),
            'desc'       => esc_html__('Example: Facebook', 'melokids'),
        ),
        array(
            'id'         => 's3_url',
            'type'       => 'text',
            'title'      => esc_html__('Link 3', 'melokids'),
            'validate'   => 'url',
            'subtitle'   => esc_html__('Enter your link', 'melokids'),
            'desc'       => esc_html__('Example: https://facebook.com', 'melokids'),
        ),
        array(
            'id'         => 's3_icon',
            'type'       => 'text',
            'title'      => esc_html__('Icon 3', 'melokids'),
            'validate'   => 'html',
            'subtitle'   => esc_html__('Add class of your icon font', 'melokids'),
            'desc'       => esc_html__('Example: fa fa-facebook', 'melokids'),
        ),
        array(
            'id'         => 's4_title',
            'type'       => 'text',
            'title'      => esc_html__('Title 4', 'melokids'),
            'subtitle'   => esc_html__('Enter title', 'melokids'),
            'desc'       => esc_html__('Example: Facebook', 'melokids'),
        ),
        array(
            'id'         => 's4_url',
            'type'       => 'text',
            'title'      => esc_html__('Link 4', 'melokids'),
            'validate'   => 'url',
            'subtitle'   => esc_html__('Enter your link', 'melokids'),
            'desc'       => esc_html__('Example: https://facebook.com', 'melokids'),
        ),
        array(
            'id'         => 's4_icon',
            'type'       => 'text',
            'title'      => esc_html__('Icon 4', 'melokids'),
            'validate'   => 'html',
            'subtitle'   => esc_html__('Add class of your icon font', 'melokids'),
            'desc'       => esc_html__('Example: fa fa-facebook', 'melokids'),
        ),
        array(
            'id'         => 's5_title',
            'type'       => 'text',
            'title'      => esc_html__('Title 5', 'melokids'),
            'subtitle'   => esc_html__('Enter title', 'melokids'),
            'desc'       => esc_html__('Example: Facebook', 'melokids'),
        ),
        array(
            'id'         => 's5_url',
            'type'       => 'text',
            'title'      => esc_html__('Link 5', 'melokids'),
            'validate'   => 'url',
            'subtitle'   => esc_html__('Enter your link', 'melokids'),
            'desc'       => esc_html__('Example: https://facebook.com', 'melokids'),
        ),
        array(
            'id'         => 's5_icon',
            'type'       => 'text',
            'title'      => esc_html__('Icon 5', 'melokids'),
            'validate'   => 'html',
            'subtitle'   => esc_html__('Add class of your icon font', 'melokids'),
            'desc'       => esc_html__('Example: fa fa-facebook', 'melokids'),
        ),
        array(
            'id'         => 's6_title',
            'type'       => 'text',
            'title'      => esc_html__('Title 6', 'melokids'),
            'subtitle'   => esc_html__('Enter title', 'melokids'),
            'desc'       => esc_html__('Example: Facebook', 'melokids'),
        ),
        array(
            'id'         => 's6_url',
            'type'       => 'text',
            'title'      => esc_html__('Link 6', 'melokids'),
            'validate'   => 'url',
            'subtitle'   => esc_html__('Enter your link', 'melokids'),
            'desc'       => esc_html__('Example: https://facebook.com', 'melokids'),
        ),
        array(
            'id'         => 's6_icon',
            'type'       => 'text',
            'title'      => esc_html__('Icon 6', 'melokids'),
            'validate'   => 'html',
            'subtitle'   => esc_html__('Add class of your icon font', 'melokids'),
            'desc'       => esc_html__('Example: fa fa-facebook', 'melokids'),
        ),
        array(
            'id'         => 's7_title',
            'type'       => 'text',
            'title'      => esc_html__('Title 7', 'melokids'),
            'subtitle'   => esc_html__('Enter title', 'melokids'),
            'desc'       => esc_html__('Example: Facebook', 'melokids'),
        ),
        array(
            'id'         => 's7_url',
            'type'       => 'text',
            'title'      => esc_html__('Link 7', 'melokids'),
            'validate'   => 'url',
            'subtitle'   => esc_html__('Enter your link', 'melokids'),
            'desc'       => esc_html__('Example: https://facebook.com', 'melokids'),
        ),
        array(
            'id'         => 's7_icon',
            'type'       => 'text',
            'title'      => esc_html__('Icon 7', 'melokids'),
            'validate'   => 'html',
            'subtitle'   => esc_html__('Add class of your icon font', 'melokids'),
            'desc'       => esc_html__('Example: fa fa-facebook', 'melokids'),
        ),
        array(
            'id'         => 's8_title',
            'type'       => 'text',
            'title'      => esc_html__('Title 8', 'melokids'),
            'subtitle'   => esc_html__('Enter title', 'melokids'),
            'desc'       => esc_html__('Example: Facebook', 'melokids'),
        ),
        array(
            'id'         => 's8_url',
            'type'       => 'text',
            'title'      => esc_html__('Link 8', 'melokids'),
            'validate'   => 'url',
            'subtitle'   => esc_html__('Enter your link', 'melokids'),
            'desc'       => esc_html__('Example: https://facebook.com', 'melokids'),
        ),
        array(
            'id'         => 's8_icon',
            'type'       => 'text',
            'title'      => esc_html__('Icon 8', 'melokids'),
            'validate'   => 'html',
            'subtitle'   => esc_html__('Add class of your icon font', 'melokids'),
            'desc'       => esc_html__('Example: fa fa-facebook', 'melokids'),
        ),
        array(
            'id'         => 's9_title',
            'type'       => 'text',
            'title'      => esc_html__('Title 9', 'melokids'),
            'subtitle'   => esc_html__('Enter title', 'melokids'),
            'desc'       => esc_html__('Example: Facebook', 'melokids'),
        ),
        array(
            'id'         => 's9_url',
            'type'       => 'text',
            'title'      => esc_html__('Link 9', 'melokids'),
            'validate'   => 'url',
            'subtitle'   => esc_html__('Enter your link', 'melokids'),
            'desc'       => esc_html__('Example: https://facebook.com', 'melokids'),
        ),
        array(
            'id'         => 's9_icon',
            'type'       => 'text',
            'title'      => esc_html__('Icon 9', 'melokids'),
            'validate'   => 'html',
            'subtitle'   => esc_html__('Add class of your icon font', 'melokids'),
            'desc'       => esc_html__('Example: fa fa-facebook', 'melokids'),
        ),
        array(
            'id'         => 's10_title',
            'type'       => 'text',
            'title'      => esc_html__('Title 10', 'melokids'),
            'subtitle'   => esc_html__('Enter title', 'melokids'),
            'desc'       => esc_html__('Example: Facebook', 'melokids'),
        ),
        array(
            'id'         => 's10_url',
            'type'       => 'text',
            'title'      => esc_html__('Link 10', 'melokids'),
            'validate'   => 'url',
            'subtitle'   => esc_html__('Enter your link', 'melokids'),
            'desc'       => esc_html__('Example: https://facebook.com', 'melokids'),
        ),
        array(
            'id'         => 's10_icon',
            'type'       => 'text',
            'title'      => esc_html__('Icon 10', 'melokids'),
            'validate'   => 'html',
            'subtitle'   => esc_html__('Add class of your icon font', 'melokids'),
            'desc'       => esc_html__('Example: fa fa-facebook', 'melokids'),
        )
    )
));
/**
 * Social API
 *
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title'  => esc_html__('Socials API', 'melokids'),
    'icon'   => 'dashicons dashicons-share',
    'fields' => array()
));
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Google Maps', 'melokids'),
    'icon'       => 'dashicons dashicons-googleplus',
    'desc'      => sprintf(__('Click here to <a href="%s" target="_blank">Get your google API key</a>','melokids'), 'https://developers.google.com/maps/documentation/javascript/get-api-key'),
    'subsection' => true,
    'fields'     => array(
        array(
            'title'     => esc_html__('API Key', 'melokids'),
            'id'        => 'google_api_key',
            'type'      => 'text',
            'default'   => '',
        )
    )
));
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Twitter', 'melokids'),
    'desc'       => sprintf(__('These details are available in <a href="%s" target="_blank">Your Twitter dashboard</a>','melokids'), 'https://dev.twitter.com/apps'),
    'icon'       => 'dashicons dashicons-twitter',
    'subsection' => true,
    'fields'     => array(
        array(
            'title'     => esc_html__('Consumer Key (API Key)', 'melokids'),
            'id'        => 'twitter_api_consumer_key',
            'type'      => 'text',
            'default'   => 'i90SevLFwZDscXPo3Wj89Y4eO',
        ),
        array(
            'title'     => esc_html__('Consumer Secret (API Secret)', 'melokids'),
            'id'        => 'twitter_api_consumer_secret',
            'type'      => 'text',
            'default'   => '61AmOoAxacZeQneXjCOzKZGRwXwcRFgMsIhhYnQ5JTAOvMdlmL',
        ),
        array(
            'title'     => esc_html__('Access Token', 'melokids'),
            'id'        => 'twitter_api_access_key',
            'type'      => 'text',
            'default'   => '107960275-v9RLlUdpW7xW0wbh0Xtg8X2mVFbaCDtFNAs8vwAc',
        ),
        array(
            'title'     => esc_html__('Access Token Secret', 'melokids'),
            'id'        => 'twitter_api_access_secret',
            'type'      => 'text',
            'default'   => 'VewAXAcJEyDpqlrDfDO40HbRq6rzkYPEHgXz3WNhxAbSv',
        )
    )
));
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Instagram', 'melokids'),
    'desc'       => esc_html__('Enter your Instagram user','melokids'),
    'icon'       => 'el el-instagram',
    'subsection' => true,
    'fields'     => array(
        array(
            'title'     => esc_html__('User ID', 'melokids'),
            'desc'      => esc_html__('Ex: https://www.instagram.com/zooka.studio/. Get zooka.studio','melokids'),
            'id'        => 'instagram_api_username',
            'type'      => 'text',
            'default'   => 'zooka.studio'
        )
    )
));