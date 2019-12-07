<?php
/**
 * WooCommerce Template Hooks
 *
 * Action/filter hooks used for WooCommerce functions/templates.
 *
 * @author      Chinh Duong Manh
 * @category    Core
 * @package     WooCommerce/Templates
 * @version     3.x
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if(!class_exists('WooCommerce')) return;

/**
 * Remove all default WC css
*/
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
//add_filter( 'woocommerce_enqueue_styles', 'melokids_wc_styles' );
function melokids_wc_styles( $wc_styles ) {
    unset( $wc_styles['woocommerce-general'] ); // Remove the gloss
    unset( $wc_styles['woocommerce-layout'] );      // Remove the layout
    unset( $wc_styles['woocommerce-smallscreen'] ); // Remove the smallscreen optimisation
    return $wc_styles;
}

/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter( 'loop_shop_per_page', 'melokids_loop_shop_per_page', 20 );
function melokids_loop_shop_per_page( $limit ) {
  // $limit contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $limit = melokids_get_opts('wc_archive_limit', 8);
  return $limit;
}

/**
 * Change number of column that are displayed per page (shop page)
*/
add_filter( 'loop_shop_columns', 'melokids_loop_shop_columns', 20 );
function melokids_loop_shop_columns( $columns ) {
  $columns = melokids_get_opts('wc_archive_coloumn', 4);
  return $columns;
}
/**
 * Product Image Thumbnail Size 
 * @since 1.0
 * @since WC 3.x
 * @author Chinh Duong Manh
 * @source https://docs.woocommerce.com/document/image-sizes-theme-developers/
*/
/* Loop Thumbnail Size */
/*add_filter( 'woocommerce_get_image_size_thumbnail', function( $size ) {
    return array(
        'width'  => 440,
        'height' => 509,
        'crop'   => 1,
    );
} ); */

/* Single Thumbnail Size */
/*add_filter( 'woocommerce_get_image_size_single', function( $size ) {
    return array(
        'width'  => 570, // 870
        'height' => 360, // 550
        'crop'   => 1,
    );
} );*/
/* Gallery Thumbnail Size */
/*add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return array(
        'width'  => 177,
        'height' => 235,
        'crop'   => 1,
    );
} );*/
die('xxx');
/**
 * Unset image width theme support.
 */
function melokids_modify_wc_theme_support() {
    $theme_support = get_theme_support( 'melokids' );
    $theme_support = is_array( $theme_support ) ? $theme_support[0] : array();
 
    unset( $theme_support['single_image_width'], $theme_support['thumbnail_image_width'] );
 
    remove_theme_support( 'melokids' );

    add_theme_support( 'melokids', $theme_support );

    update_option( 'woocommerce_single_image_width', '870' );
    update_option( 'woocommerce_thumbnail_image_width', '440' );

    update_option( 'woocommerce_thumbnail_cropping', 'custom' );
    update_option( 'woocommerce_thumbnail_cropping_custom_width', '440' );
    update_option( 'woocommerce_thumbnail_cropping_custom_height', '509' );
}
 
add_action( 'after_setup_theme', 'melokids_modify_wc_theme_support', 10 );


/**
 * Loop Products 
 * Archive products
 * Remove Shop Title
*/

add_filter('woocommerce_show_page_title', function(){ return false;});

/**
 * Loop Products 
 * Add  Div wrap shop loop
*/
add_action('woocommerce_before_shop_loop', function(){
    echo '<div class="zk-loop-wrap">';
}, 1);

add_action('woocommerce_after_shop_loop', function(){
    echo '</div>';
}, 99999);

/**
 * Loop Products
 * Move some default loop content 
 * 
*/
add_action('woocommerce_before_shop_loop', function(){
    do_action('melokids_woocommerce_default');
}, 2);

/**
 * Archive descriptions.
 *
 * @see woocommerce_taxonomy_archive_description()
 * @see woocommerce_product_archive_description()
 */
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
add_action( 'melokids_woocommerce_default', 'woocommerce_taxonomy_archive_description', 10 );
add_action( 'melokids_woocommerce_default', 'woocommerce_product_archive_description', 10 );

/**
 * Hook: woocommerce_before_shop_loop.
 *
 * @hooked woocommerce_output_all_notices - 10
 * @hooked woocommerce_result_count - 20
 * @hooked woocommerce_catalog_ordering - 30
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'melokids_woocommerce_default', 'woocommerce_result_count', 2 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/**
 * Loop Products Layout 
 * Modify products list layout
 *
*/
// wrap item
add_action('woocommerce_before_shop_loop_item', function(){ echo '<div class="overlay-wrap">';}, 0);
add_action('woocommerce_after_shop_loop_item', function(){ echo '</div>';}, 99999);

// remove link
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

// change product thumb, sale flash
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

add_action('woocommerce_before_shop_loop_item_title', 'melokids_woocommerce_template_loop_product_thumbnail', 10);
if(!function_exists('melokids_woocommerce_template_loop_product_thumbnail')){
    function melokids_woocommerce_template_loop_product_thumbnail(){
    ?>
    <div class="loop-thumb text-center"><?php
        echo woocommerce_get_product_thumbnail();
        melokids_loop_product_thumnail_attrs();
        melokids_loop_product_thumnail_overlay();
    ?></div>
    <?php
    }
}

/* loop attributes */
if(!function_exists('melokids_loop_product_thumnail_attrs')){
    function melokids_loop_product_thumnail_attrs(){
        ?>
        <div class="loop-attrs row justify-content-between align-items-center"><div class="loop-attrs-left col-auto"><?php 
            do_action('melokids_loop_product_thumnail_attrs_left'); 
            ?></div>
            <div class="loop-attrs-right col justify-content-end"><?php 
                do_action('melokids_loop_product_thumnail_attrs_right'); 
        ?></div></div>
        <?php
    }
}

add_action('melokids_loop_product_thumnail_attrs_left','melokids_woocommerce_show_product_loop_badges',10);
if(!function_exists('melokids_woocommerce_show_product_loop_badges')){
    function melokids_woocommerce_show_product_loop_badges(){
        global $post, $product;
        $terms = get_the_terms($product->get_id(), 'pa_badge');
        if(!is_wp_error($terms)){
            $count = count($terms);
        } else {
            $count = 0;
        }
        if($product->is_on_sale() || (is_array($terms) && $count > 0)) echo '<div class="wc-badges">';
            if ( $product->is_on_sale() ) : 
                echo apply_filters( 'woocommerce_sale_flash', '<span class="wc-badge sale">' . esc_html__( 'Sale', 'melokids' ) . '</span>', $post, $product ); 
            endif;
            if ( is_array($terms) && $count > 0 ){
                foreach ( $terms as $term ) {
                    echo '<span class="wc-badge '.strtolower($term->name).'">'.$term->name.'</span>';
                }
            }
        if($product->is_on_sale() || (is_array($terms) && $count > 0)) echo '</div>';
    }
}


if(!function_exists('melokids_loop_product_thumnail_attrs_open_lightbox')){
    //add_action('melokids_loop_product_thumnail_attrs_right','melokids_loop_product_thumnail_attrs_open_lightbox');
    function melokids_loop_product_thumnail_attrs_open_lightbox(){
         echo '<a href="#" class="pswp-btn wc-attr-btn hint--left hint--bounce" data-hint="'.esc_html__('Click to enlarge','melokids').'"><span class="fa fa-expand"></span></a>';
    }
}

/* loop title */
remove_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title','melokids_woocommerce_template_loop_product_title', 10);
if(!function_exists('melokids_woocommerce_template_loop_product_title')){
    function melokids_woocommerce_template_loop_product_title(){
    ?>
    <div class="loop-info text-center">
        <?php do_action('melokids_before_shop_loop_title'); ?>
        <h5 class="loop-title"><?php  
            woocommerce_template_loop_product_link_open(); 
            the_title();
            woocommerce_template_loop_product_link_close();
        ?></h5>
        <?php do_action('melokids_after_shop_loop_title'); ?>
    </div>
    <?php
    }
}

/* loop category */
add_action('melokids_before_shop_loop_title', 'melokids_shop_loop_category', 10);
if(!function_exists('melokids_shop_loop_category')){
    function melokids_shop_loop_category(){
        the_terms(get_the_ID(), 'product_cat','<div class="loop-cat">',', ','</div>');
    }
}
/* loop price */
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action('melokids_after_shop_loop_title','woocommerce_template_loop_rating',1);
add_action('melokids_after_shop_loop_title','woocommerce_template_loop_price',2);

/* loop add to cart */
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' , 10);
add_action('melokids_woocommerce_loop_overlay', 'woocommerce_template_loop_add_to_cart', 2);

if(!function_exists('melokids_loop_product_thumnail_overlay')){
    function melokids_loop_product_thumnail_overlay(){
        $animated_in = melokids_get_opts('wc_overlay_in','zoomIn');
        $animated_out = melokids_get_opts('wc_overlay_out','zoomOut');
        ?>
        <div class="overlay animated <?php echo esc_attr($animated_out);?>" data-animation-in="<?php echo esc_attr($animated_in);?>" data-animation-out="<?php echo esc_attr($animated_out);?>">
            <?php 
                woocommerce_template_loop_product_link_open(); 
                woocommerce_template_loop_product_link_close(); 
            ?>
            <div class="overlay-inner center-align">
                <?php do_action('melokids_woocommerce_loop_overlay'); ?>
            </div>
        </div>
        <?php
    }
}

/* Loop add to cart text */
// Change add to cart text on archives depending on product type
if(!function_exists('melokids_woocommerce_product_add_to_cart_text')){
    add_filter( 'woocommerce_product_add_to_cart_text' , 'melokids_woocommerce_product_add_to_cart_text' );
    function melokids_woocommerce_product_add_to_cart_text() {
        global $product;
        
        $product_type = $product->get_type();
        $product_price = $product->get_price();
        switch ( $product_type ) {
            case 'external':
                return esc_html__( 'Buy product', 'melokids' );
                break;
            case 'grouped':
                return esc_html__( 'View products', 'melokids' );
                break;
            case 'simple':
                if ($product_price != '') {
                   return esc_html__( 'Quick Buy', 'melokids' );
                } else {
                    return esc_html__( 'Read more', 'melokids' );
                }
                break;
            case 'variable':
                return esc_html__( 'Select options', 'melokids' );
                break;
            default:
                return esc_html__( 'Read more', 'melokids' );
                break;
        }
    }
}

/**
 * Add icon to loop add to cart button
 *
*/
if(!function_exists('melokids_woocommerce_loop_add_to_cart_link')){
    add_filter('woocommerce_loop_add_to_cart_link', 'melokids_woocommerce_loop_add_to_cart_link', 10, 3);
    if(!function_exists('melokids_woocommerce_loop_add_to_cart_link')){
        function melokids_woocommerce_loop_add_to_cart_link($btn, $product, $args = []){
            $args = wp_parse_args($args, [
                'attributes'=>[]
            ]);
            $btn = sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s%s</a>',
                esc_url( $product->add_to_cart_url() ),
                esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
                isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                '<span class="far fa-shopping-basket"></span>&nbsp;',
                esc_html( $product->add_to_cart_text() )
            );
            return $btn;
        }
    }
}
/**
 * WooCommerce Pagianation
 * Custom WooCommerce Pagianation
*/
if ( ! function_exists( 'melokids_woocommerce_pagination' ) ) {
    /**
     * Output the pagination.
    */
    remove_action('woocommerce_after_shop_loop','woocommerce_pagination');
    add_action('woocommerce_after_shop_loop','melokids_woocommerce_pagination');

    function melokids_woocommerce_pagination() {
        if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
            return;
        }

        $args = array(
            'total'   => wc_get_loop_prop( 'total_pages' ),
            'current' => wc_get_loop_prop( 'current_page' ),
            'base'    => esc_url_raw( add_query_arg( 'product-page', '%#%', false ) ),
            'format'  => '?product-page=%#%',
        );

        if ( ! wc_get_loop_prop( 'is_shortcode' ) ) {
            $args['format'] = '';
            $args['base']   = esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
        }
        extract($args);

        if ( $total <= 1 ) {
            return;
        }
        ?>
        <nav class="navigation pagination">
            <?php
                echo paginate_links( apply_filters( 'woocommerce_pagination_args', array( // WPCS: XSS ok.
                    'base'         => $base,
                    'format'       => $format,
                    'add_args'     => false,
                    'current'      => max( 1, $current ),
                    'total'        => $total,
                    'prev_text'    => '<span class="far fa-long-arrow-'.melokids_align().'"></span>',
                    'next_text'    => '<span class="far fa-long-arrow-'.melokids_align2().'"></span>',
                    'type'         => 'plain',
                    'end_size'     => 3,
                    'mid_size'     => 3,
                ) ) );
            ?>
        </nav>
        <?php
    }
}
if(!function_exists('melokids_woocommerce_pagination_args')){
    //add_filter('woocommerce_pagination_args', 'melokids_woocommerce_pagination_args', 10, 1);
    function melokids_woocommerce_pagination_args($args){
        $args['prev_text'] = '<span class="far fa-long-arrow-'.melokids_align().'"></span>';
        $args['next_text'] = '<span class="far fa-long-arrow-'.melokids_align2().'"></span>';
        $args['type']      = 'plain';
        return $args;
    }
}

/**
 * Get WooCommerce Cart
 * Used for popup cart content
 * @since 1.0.0
 */
if(!function_exists('melokids_wc_cart')){
    function melokids_wc_cart() { 
        if(!class_exists('WooCommerce')) return;
        ?>
            <div class="widget_shopping_cart">
                <div class="widget_shopping_cart_content">
                    <?php woocommerce_mini_cart(); ?>
                </div>
            </div>
        <?php
    }
}

if(!function_exists('melokids_woocommerce_add_to_cart_fragment')){
    add_filter('woocommerce_add_to_cart_fragments', 'melokids_woocommerce_add_to_cart_fragment', 10, 1 );
    function melokids_woocommerce_add_to_cart_fragment( $fragments ) {
        if(!class_exists('WooCommerce')) return;
        ob_start();
        ?>
        <span class="cart-count"><?php echo WC()->cart->cart_contents_count; ?></span>
        <?php
        $fragments['.cart-count'] = ob_get_clean();
        return $fragments;
    }
}

if(!function_exists('melokids_woocommerce_add_to_cart_data_fragment')){
    add_filter('woocommerce_add_to_cart_fragments', 'melokids_woocommerce_add_to_cart_data_fragment', 10, 1 );
    function melokids_woocommerce_add_to_cart_data_fragment( $fragments ) {
    	if(!class_exists('WooCommerce')) return;
        ob_start();
        ?>
        <span class="data-cart-count" data-count="<?php echo WC()->cart->cart_contents_count; ?>"></span>
        <?php
        $fragments['.data-cart-count'] = ob_get_clean();
        return $fragments;
    }
}