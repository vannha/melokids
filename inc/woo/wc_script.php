<?php
/**
 * Enqueue scripts and styles for front-end.
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 * @author Chinh Duong Manh
 *
 */
function melokids_wc_front_end_scripts()
{
    global $wp_styles;
    $melokids_ver = wp_get_theme()->get('Version');
    /* Add main.js */
    $min = '';
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        $min = '.min';
    }
    wp_enqueue_style('animate-css');
    /* WooCommerce JS */
    wp_enqueue_script('melokids-woo', get_template_directory_uri() . '/inc/woo/js/woo' . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' ) . '.js', array('jquery'), $melokids_ver, true);

    wp_enqueue_script('melokids-woo-filter', get_template_directory_uri() . '/inc/woo/js/woo-filter' . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' ) . '.js', array('jquery'), $melokids_ver, true);

    if(is_singular('product')){
        wp_enqueue_script('melokids-single-product', get_template_directory_uri() . '/inc/woo/js/single-product' . ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' ) . '.js', array('jquery'), '', true);

        wp_enqueue_script('vc_pageable_owl-carousel');
        wp_enqueue_script('zk-owlcarousel');
        wp_enqueue_style('vc_pageable_owl-carousel-css');
    }
}
add_action('wp_enqueue_scripts', 'melokids_wc_front_end_scripts');