<?php
/**
 * MeloKids functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 * @author Chinh Duong Manh
 *
 */

// Set up the content width value based on the theme's design and stylesheet.
if (!isset($content_width))
    $content_width = 1170;

/**
 * MeloKids setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * MeloKids supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 *    custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since 1.0.0
 *
 */
function melokids_setup()
{
    // load language.
    load_theme_textdomain('melokids', get_template_directory() . '/languages');
    // Adds title tag
    add_theme_support("title-tag");

    // Add woocommerce
    add_theme_support('woocommerce');

    // Adds custom header
    add_theme_support('custom-header');

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support('automatic-feed-links');

    // This theme supports a variety of post formats.
    add_theme_support('post-formats', array('video', 'audio', 'gallery', 'quote', 'link'));

    // This theme uses wp_nav_menu() in one location.
    register_nav_menu('primary', esc_html__('Primary Menu', 'melokids'));
    register_nav_menu('primary-left', esc_html__('Primary Menu Left', 'melokids'));
    register_nav_menu('primary-right', esc_html__('Primary Menu Right', 'melokids'));
    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    /*
     * This theme supports custom background color and image,
     * and here we also set up the default background color.
     */
    add_theme_support('custom-background', array('default-color' => 'ffffff',));

    // This theme uses a custom image size for featured images, displayed on "standard" posts.
    add_theme_support('post-thumbnail');
    set_post_thumbnail_size(1400, 766, true); // Limited height, hard crop
    

    /* NavXT */
    $bcn_options = get_option('bcn_options', array());
    if(empty($bcn_options['installed']))
    {
        $bcn_options['hseparator'] = '<span class="separator fa fa-caret-right"></span>';
        $bcn_options['home_title'] = 'Home';
        $bcn_options['installed']  = 'true';
        update_option('bcn_options',$bcn_options);
    }
    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, icons, and column width.
     */
    add_editor_style(array('assets/css/editor-style.css'));

    //ef4 frame use
    $option = get_option('ef4_frames_use',[]);
    if(!is_array($option))
        $option = [];
    $option['scss'] = 'new'; // = false/0 to turn off

    update_option('ef4_frames_use',$option);

    /* WooCommerce */
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-slider' );
    add_theme_support( 'wc-product-gallery-lightbox' );
}

add_action('after_setup_theme', 'melokids_setup');

function melokids_switch_theme(){
    $bcn_options = get_option('bcn_options', array());
    if(!empty($bcn_options['installed']))
    {
        unset($bcn_options['installed']);
        update_option('bcn_options',$bcn_options);
    }

    /* Change default image thumbnail sizes in wordpress */
    $theme_options = [
        'large_size_w'        => 1040,
        'large_size_h'        => 369,
        'large_crop'          => 1, /* limited width/height=> hard crop */
        'medium_large_size_w' => 680,
        'medium_large_size_h' => 399,
        'medium_large_crop'   => 1, /* limited width/height=> hard crop */
        'medium_size_w'       => 440,
        'medium_size_h'       => 241,
        'medium_crop'         => 1, /* limited width/height=> hard crop */
        'thumbnail_size_w'    => 130,
        'thumbnail_size_h'    => 72,
        'thumbnail_crop'      => 1, /* limited width/height=> hard crop */
    ];
    foreach ($theme_options as $option => $value) {
        if (get_option($option, '') != $value)
            update_option($option, $value); 
    }
}
//add_action('switch_theme', 'melokids_switch_theme');


/**
 * Add new image sizes to list of thumbnail
 * when add image
 *
*/
add_filter( 'image_size_names_choose', 'melokids_image_size_names_choose' );
function melokids_image_size_names_choose( $sizes ) {
    $melokids_sizes = array(
        'medium_large'      => esc_html__( 'Medium Large', 'melokids' ), 
    );
    $sizes = array_merge( $sizes, $melokids_sizes );

    return $sizes;
}

/**
 * Enqueue scripts and styles for front-end.
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 * @author Chinh Duong Manh
 *
 */
function melokids_front_end_scripts()
{
    global $wp_styles;
    $melokids_ver = wp_get_theme()->get('Version');
    /* Add main.js */
    $min = '';
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        $min = '.min';
    } 

    /**
     * VC Script 
     * Our Theme use some script from Visual Composer plugin
     * and need to call exactly name from plugin and can not change to use 
     * dashes '-' instead of '_' or '.' for handlers 
     *
    */
    if (class_exists('VC_Manager')) {
        wp_register_script( 'vc_pageable_owl-carousel', vc_asset_url( 'lib/owl-carousel2-dist/owl.carousel.min.js' ), array(
            'jquery',
        ), WPB_VC_VERSION, true );
        wp_register_style( 'vc_pageable_owl-carousel-css', vc_asset_url( 'lib/owl-carousel2-dist/assets/owl.min.css' ), array(), WPB_VC_VERSION );

        /* Custom Pie Chart */
        wp_register_script( 'vc_pie', get_template_directory_uri() . '/assets/js/vc/jquery.vc_chart.min.js', array(
            'jquery',
            'waypoints',
            'progressCircle',
        ), WPB_VC_VERSION, true );
        
    }
    wp_register_script('zk-owlcarousel', get_template_directory_uri() . '/assets/js/zk-owlcarousel.js', array('jquery','vc_pageable_owl-carousel'), $melokids_ver, true);
    wp_register_style( 'animate-css', get_template_directory_uri() . '/assets/css/animate.min.css', '', $melokids_ver );
    
    /* Magnific Popup */
    wp_register_script( 'magnific-popup', get_template_directory_uri() . '/assets/libs/magnific-popup/magnific-popup.min.js', array(
            'jquery',
        ), $melokids_ver, true );
    wp_register_style('magnific-popup', get_template_directory_uri() . '/assets/libs/magnific-popup/magnific-popup.css', '', $melokids_ver);    
    /* Comment */
    if (is_singular() && comments_open() && get_option('thread_comments'))
        wp_enqueue_script('comment-reply');
    /* Share this */
    wp_register_script('sharethis', get_template_directory_uri() . '/assets/js/sharethis.js', '', $melokids_ver);
    wp_enqueue_script('sharethis');

    /* Loads Font stylesheet. */
    wp_enqueue_style('font-edmondsans', get_template_directory_uri() . '/assets/fonts/edmondsans/font-edmondsans.css', '', $melokids_ver);
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/fontawesome5/css/fontawesome.css', '', '5.1.0');
    wp_enqueue_style('font-awesome5-all', get_template_directory_uri() . '/assets/css/fontawesome5/css/all.css', '', '5.1.0');
    wp_enqueue_style('font-awesome5-brand', get_template_directory_uri() . '/assets/css/fontawesome5/css/brands.css', '', '5.1.0');
    wp_enqueue_style('font-awesome5-light', get_template_directory_uri() . '/assets/css/fontawesome5/css/light.css', '', '5.1.0');
    wp_enqueue_style('font-awesome5-regular', get_template_directory_uri() . '/assets/css/fontawesome5/css/regular.css', '', '5.1.0');
    wp_enqueue_style('font-awesome5-solid', get_template_directory_uri() . '/assets/css/fontawesome5/css/solid.css', '', '5.1.0');
    wp_enqueue_style('font-awesome5-svg-with-js', get_template_directory_uri() . '/assets/css/fontawesome5/css/svg-with-js.css', '', '5.1.0');
    wp_enqueue_style('font-awesome5-v4-shims', get_template_directory_uri() . '/assets/css/fontawesome5/css/v4-shims.css', '', '5.1.0');

    /* Slick */
    wp_register_script('slick', get_template_directory_uri() . '/assets/libs/slick/slick.min.js', array('jquery'), $melokids_ver, true);
    wp_register_script('slick-theme', get_template_directory_uri() . '/assets/libs/slick/slick.theme.js', array('slick'), $melokids_ver, true);
    /* Select2 */
    wp_enqueue_script('select2', get_template_directory_uri() . '/assets/libs/select2/select2.full.min.js', array('jquery'), $melokids_ver, true);
    /* Flexslider */
    wp_enqueue_script('flexslider', get_template_directory_uri() . '/assets/libs/flexslider/jquery.flexslider'.$min.'.js', array('jquery'), $melokids_ver, true);    
    /* Load theme css */
    wp_enqueue_script('melokids-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $melokids_ver, true);
    wp_register_style('melokids', get_template_directory_uri() . '/assets/css/melokids.css', array(), $melokids_ver, 'all');
    wp_enqueue_style('melokids');
}

add_action('wp_enqueue_scripts', 'melokids_front_end_scripts', 99);

/**
 * load admin scripts.
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 * @author Chinh Duong Manh
 *
 */
function melokids_admin_scripts()
{
    $melokids_ver = wp_get_theme()->get('Version');
    /* Adds style for admin */
    wp_enqueue_style('melokids', get_template_directory_uri() . '/assets/css/admin.css', '', $melokids_ver);
    wp_enqueue_style('melokids-admin-fonts', get_template_directory_uri() . '/assets/fonts/edmondsans/font-edmondsans.css');


    $screen = get_current_screen();

    /* load js for edit post. */
    if ($screen->post_type == 'post') {
        /* post format select. */
        wp_enqueue_script('melokids-post-format', get_template_directory_uri() . '/assets/js/post-format.js', '', $melokids_ver, true);
    }
}
add_action('admin_enqueue_scripts', 'melokids_admin_scripts');


/**
 * Register Google Fonts
 *
 * https://gist.github.com/kailoon/e2dc2a04a8bd5034682c
 * https://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
 *
 */
function melokids_fonts_url()
{
    $font_url = '';
    $font_url = add_query_arg('family', 'Lato:400,400i|Roboto:400,400i', "//fonts.googleapis.com/css");
    return $font_url;
}

function melokids_font_scripts()
{
    wp_enqueue_style('melokids-fonts', melokids_fonts_url(), '', wp_get_theme()->get('Version'));
}

add_action('wp_enqueue_scripts', 'melokids_font_scripts');

/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 * @author Chinh Duong Manh
 *
 */
function melokids_widgets_init()
{

    global $theme_options;
    $widget_heading_open = '<h5 class="wg-title">';
    $widget_heading_close = '</h5>';
    register_sidebar(array(
        'name'          => esc_html__('Main Sidebar', 'melokids'),
        'id'            => 'sidebar-main',
        'description'   => esc_html__('Appears on posts and pages except the optional Page Builder template, which has its own widgets', 'melokids'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => $widget_heading_open,
        'after_title'   => $widget_heading_close,
    ));
    /* Shop Sidebar */
    if (class_exists('WooCommerce')) {
        register_sidebar(array(
            'name'          => esc_html__('WooCommerce Sidebar', 'melokids'),
            'id'            => 'sidebar-shop',
            'description'   => esc_html__('Appears in WooCommerce Archive page', 'melokids'),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => $widget_heading_open,
            'after_title'   => $widget_heading_close,
        ));
        register_sidebar(array(
            'name'          => esc_html__('WooCommerce Filters', 'melokids'),
            'id'            => 'shop-filter',
            'description'   => esc_html__('Appears in WooCommerce Filter area. Leave blank to use our default', 'melokids'),
            'before_widget' => '<aside id="%1$s" class="zk-filter %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h5 class="wg-title-filter">',
            'after_title'   => '</h5>',
        ));
    }
    /* Sidebar Menu */
    register_sidebar(array(
        'name'          => esc_html__('Sidebar Menu', 'melokids'),
        'id'            => 'zk-sidebar-menu',
        'description'   => esc_html__('Appears in Left/Right handside when click Bars icon', 'melokids'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => $widget_heading_open,
        'after_title'   => $widget_heading_close,
    ));

    /* Header Tools */
    register_sidebar(array(
        'name'          => esc_html__('Header Tools', 'melokids'),
        'id'            => 'header-tool',
        'description'   => esc_html__('Appears in right side of the site when you click on Header TooLs icon', 'melokids'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => $widget_heading_open,
        'after_title'   => $widget_heading_close,
    ));
}

add_action('widgets_init', 'melokids_widgets_init');

/**
 * Incudes file
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 * @author Chinh Duong Manh
 *
*/
function melokids_require_folder($foldername,$path = '')
{   
    if(empty($path)) $path = get_template_directory();
    $dir = $path . DIRECTORY_SEPARATOR . $foldername;
    if (!is_dir($dir)) {
        return;
    }
    $files = array_diff(scandir($dir), array('..', '.'));
    foreach ($files as $file) {
        $patch = $dir . DIRECTORY_SEPARATOR . $file;
        if (file_exists($patch) && strpos($file, ".php") !== false) {
            require_once $patch;
        }
    }
}

/**
 * Core functions. 
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 * @author Chinh Duong Manh
 *
*/
melokids_require_folder('core',get_template_directory());
melokids_require_folder('inc',get_template_directory());
melokids_require_folder('inc/classes',get_template_directory());
melokids_require_folder('vc_customs',get_template_directory());

/**
 * Custom Extensions used
 *
*/
melokids_require_folder('inc/extensions',get_template_directory());
/* Custom JetPack */
if(class_exists('Jetpack')){
    melokids_require_folder('inc/jetpack');
}
/* Custom WooCommerce */
if(class_exists('WooCommerce')){
    melokids_require_folder('inc/woo',get_template_directory());
}
/**
 * Remove some script/ style from 3rd plugin.
 *
 * Filter Hooked: ef4_remove_scripts filter,
 * 
 */
function melokids_remove_scripts() {
    $scripts[] = ''; // enter name of script/style you want to remove
    return $scripts;
}
add_filter( 'ef4_remove_scripts', 'melokids_remove_scripts');

if(!function_exists('melokids_allow_html')){
    function melokids_allow_html($html){
        return $html;
    }
}
// Remove gutenberg 
add_filter('ef4_support_gtb', function(){ return false;});
/* Remvoe EF4 Settings */
add_filter('ef4_show_settings_menu', '__return_false');