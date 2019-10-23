<?php
if(!function_exists('EF4Framework')) return;
/**
 * Add custom post type Header Top
 *
 * This custom post used for build Header Top section
 *
*/
function melokids_cpts_header_banner() {
    $header_banner = apply_filters('melokids_cpts_header_banner', false);
    if(!$header_banner) return;

    $labels = array(
        'name'          => esc_html__( 'MeloKids Headers Banner', 'melokids' ),
        'singular_name' => esc_html__( 'MeloKids Header Banner', 'melokids' ),
        'all_items'     => esc_html__( 'All Header Banner', 'melokids' ),
        'add_new_item'  => esc_html__( 'Add New MeloKids Header Banner', 'melokids' ),
    );

    $args = array(
        'label'               => esc_html__( 'MeloKids Header Banner', 'melokids' ),
        'labels'              => $labels,
        'description'         => 'Add custom Header Banner Layout ',
        'public'              => true,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'rest_base'           => '',
        'has_archive'         => false,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'exclude_from_search' => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'rewrite'             => false,
        'query_var'           => true,
        'menu_position'       => 10000,
        'menu_icon'           => 'dashicons-editor-insertmore',
        'supports'            => array( 'title', 'editor' ),
    );

    register_ef4_post_type( 'header_banner', $args );
}
add_action( 'init', 'melokids_cpts_header_banner' );

/**
 * MeloKids Header Banner
 * Need custom post type Banner
*/
if(!function_exists('melokids_header_banner')){
    function melokids_header_banner($args = []){
        $args = wp_parse_args($args, [
            'class'         => ''
        ]);
        $header_banner = melokids_get_opts('header_banner','');
        $classes = [$args['class']];
        if(empty($header_banner)) return;

    ?><div id="zk-header-banner" class="<?php echo trim(implode(' ', $classes));?>"><div class="container"><?php 
            melokids_content_by_slug($header_banner, 'header_banner'); 
        ?></div></div><?php
    }
}
/**
 * Add custom post type Header Top
 *
 * This custom post used for build Header Top section
 *
*/
function melokids_cpts_header_top() {
    $header_top = apply_filters('melokids_cpts_header_top', false);
    if(!$header_top) return;

    $labels = array(
        'name'          => esc_html__( 'MeloKids Headers Top', 'melokids' ),
        'singular_name' => esc_html__( 'MeloKids Header Top', 'melokids' ),
        'all_items'     => esc_html__( 'All Header Top', 'melokids' ),
        'add_new_item'  => esc_html__( 'Add New MeloKids Header Top', 'melokids' ),
    );

    $args = array(
        'label'               => esc_html__( 'MeloKids Header Top', 'melokids' ),
        'labels'              => $labels,
        'description'         => 'Add custom Header Top Layout ',
        'public'              => true,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'rest_base'           => '',
        'has_archive'         => false,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'exclude_from_search' => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'rewrite'             => false,
        'query_var'           => true,
        'menu_position'       => 10000,
        'menu_icon'           => 'dashicons-editor-insertmore',
        'supports'            => array( 'title', 'editor' ),
    );

    register_ef4_post_type( 'header_top', $args );
}
add_action( 'init', 'melokids_cpts_header_top' );

/**
 * MeloKids Header Top
 * Need custom post type header_top
*/
if(!function_exists('melokids_header_top')){
    function melokids_header_top($args = []){
        $args = wp_parse_args($args, [
            'class'         => ''
        ]);
        $header_top = melokids_get_opts('header_top','');
        if(empty($header_top)) return;

    ?><div id="zk-header-top" class="clearfix"><div class="container"><?php melokids_content_by_slug($header_top, 'header_top'); ?></div></div><?php
    }
}

/**
 * Add custom post type Header Custom
 *
 * This custom post used for build Header Custom section
 *
*/
function melokids_cpts_header_custom() {
    $header_custom = apply_filters('melokids_cpts_header_custom', false);
    if(!$header_custom) return;

    $labels = array(
        'name'          => esc_html__( 'MeloKids Custom Header', 'melokids' ),
        'singular_name' => esc_html__( 'MeloKids Custom Header', 'melokids' ),
        'all_items'     => esc_html__( 'All Custom Header', 'melokids' ),
        'add_new_item'  => esc_html__( 'Add New MeloKids Custom Header', 'melokids' ),
    );

    $args = array(
        'label'               => esc_html__( 'MeloKids Custom Header', 'melokids' ),
        'labels'              => $labels,
        'description'         => 'Add custom Custom Header Layout ',
        'public'              => true,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'rest_base'           => '',
        'has_archive'         => false,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'exclude_from_search' => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'rewrite'             => false,
        'query_var'           => true,
        'menu_position'       => 10000,
        'menu_icon'           => 'dashicons-editor-insertmore',
        'supports'            => array( 'title', 'editor' ),
    );

    register_ef4_post_type( 'header_custom', $args );
}
add_action( 'init', 'melokids_cpts_header_custom' );

/**
 * MeloKids Custom Header
 * Need custom post type header_custom
*/
if(!function_exists('melokids_header_custom')){
    function melokids_header_custom($args = []){
        $args = wp_parse_args($args, [
            'class'         => ''
        ]);
        $header_custom = melokids_get_opts('header_custom_value','');
        if(empty($header_custom)) return;
        $classes = array('zk-custom-header', $args['class'] );
    ?>
    <div id="zk-custom-header" class="<?php echo trim(implode(' ', $classes));?>">
        <div class="zk-custom-header-mobile d-flex justify-content-between align-items-center d-xl-none">
            <?php melokids_logo(['class'=>'col-auto']);?>
            <div class="col-auto"><?php melokids_header_mobile_nav(); ?></div>
        </div>
        <div id="zk-header-custom-mobile-content">
            <?php melokids_content_by_slug($header_custom, 'header_custom'); ?>
        </div>
    </div>
    <?php
    }
}

/**
 * Add custom post type Footer 
 * 
 * This custom post used for build Footer section
 *  
 */
function melokids_cpts_footer() {
    $footer = apply_filters('melokids_cpts_footer', false);
    if(!$footer) return;

    $labels = array(
        'name'          => esc_html__( 'MeloKids Footers', 'melokids' ),
        'singular_name' => esc_html__( 'MeloKids Footer', 'melokids' ),
        'all_items'     => esc_html__( 'All Footer', 'melokids' ),
        'add_new_item'  => esc_html__( 'Add New MeloKids Footer', 'melokids' ),
    );

    $args = array(
        'label'               => esc_html__( 'MeloKids Footers', 'melokids' ),
        'labels'              => $labels,
        'description'         => 'Add custom Footer Layout ',
        'public'              => true,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'rest_base'           => '',
        'has_archive'         => false,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'exclude_from_search' => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'rewrite'             => false,
        'query_var'           => true,
        'menu_position'       => 10000,
        'menu_icon'           => 'dashicons-editor-insertmore',
        'supports'            => array( 'title', 'editor' ),
    );

    register_ef4_post_type( 'footer', $args );
}
add_action( 'init', 'melokids_cpts_footer' );

/**
 * MeloKids Footer
 * Need custom post type footer
*/
if(!function_exists('melokids_footer')){
    function melokids_footer($args = []){
        $args = wp_parse_args($args, [
            'class'         => ''
        ]);
        $footer = melokids_get_opts('footer','');
        $classes = [$args['class']];
        if(empty($footer)) $classes[] = 'default';
        $classes[] = 'clearfix';
    ?><div class="zk-footer-wrapper"><div id="open-footer" class="zk-backtotop hint--top" data-hint="<?php esc_html_e('Click to open','melokids');?>"><span></span><span></span><span></span></div><footer id="zk-footer" class="<?php echo trim(implode(' ', $classes));?>"><div class="container"><?php 
        if(empty($footer))
            melokids_footer_default();
        else
            melokids_content_by_slug($footer, 'footer'); 
        ?></div></footer></div><?php
    }
}

add_filter('melokids_cpts_header_banner',function(){
    return true;
});

add_filter('melokids_cpts_header_top',function(){
    return true;
});

add_filter('melokids_cpts_header_custom',function(){
    return true;
});

add_filter('melokids_cpts_footer', function(){
    return true;
});