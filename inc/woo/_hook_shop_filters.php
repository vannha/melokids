<?php
/**
 * Products Filter
 * Add filter at the top of products archive
 *
*/
if(!function_exists('melokids_woocommerce_before_shop_loop')){
	add_action('woocommerce_before_shop_loop','melokids_woocommerce_before_shop_loop',0);
    function melokids_woocommerce_before_shop_loop(){
    ?>
        <div class="zk-wc-filters-wrap">
            <div class="zk-before-wc-filters clearfix"><?php do_action('melokids_woocommerce_before_shop_filter'); ?></div>
            <div class="zk-wc-filters clearfix"><?php do_action('melokids_woocommerce_shop_filter'); ?></div>
            <div class="zk-after-wc-filters clearfix"><?php do_action('melokids_woocommerce_after_shop_filter'); ?></div>
        </div>
    <?php
    }
}

/**
 * Output Products Filter
 *
 * Sort by list: New Arrivals, Sales, Best Seller, Staff Choise
 * Grid layout 
 * Filter 
 * - Filter by Sort
 * - Filter by price
 * - Filter by Product Attributes:  Size, Color, Brand
 * - Filter by Category
*/

if(!function_exists('melokids_products_fitler')){
    add_action('melokids_woocommerce_shop_filter','melokids_products_fitler');
    function melokids_products_fitler(){
    ?>
        <div class="zk-products-filters">
            <div class="row justify-content-between">
                <div class="zk-filters-sort col-md-auto col-12">
                    <?php do_action('melokids_wc_filter_sort'); ?>
                </div>
                <div class="zk-filters-grid-filters col-md-auto col-12">
                    <div class="row justify-content-center">
                        <div class="zk-filters-grid col-auto">
                            <a href="javascript:void(0)" class="filter-ajax" data-cols="5">05</a>
                            <a href="javascript:void(0)" class="filter-ajax" data-cols="4">04</a>
                            <a href="javascript:void(0)" class="filter-ajax" data-cols="3">03</a>
                        </div>
                        <div class="zk-filters-filter-btn col-auto">
                            <a class="open-filter"><?php esc_html_e('Filter','melokids') ?>&nbsp;&nbsp;&nbsp;<span class="fa fa-caret-down"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="line"></div>
            <div class="zk-wc-filtered"><?php do_action('melokids_woocommerce_shop_filtered'); ?></div>
            <div id="zk-filters-content" class="zk-filters-content">
                <div class="zk-filters-content-inner row justify-content-between">
                    <?php do_action('melokids_wc_filter_content'); ?>
                </div>
            </div>
        </div>
    <?php
    }
}

/**
 * Output the product sorting options.
 * Custom html output layout 
 * Display as list
 */
if ( ! function_exists( 'melokids_woocommerce_catalog_ordering_filter' ) ) {
    add_action('melokids_wc_filter_sort', 'melokids_woocommerce_catalog_ordering_filter', 1);
    function melokids_woocommerce_catalog_ordering_filter() {
        if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
            return;
        }
        $catalog_orderby_options = array(
            'date'        => esc_html__( 'Arrivals', 'melokids' ),
            'on_sale'     => esc_html__( 'Sales', 'melokids' ),
            'bestselling' => esc_html__( 'Bestseller', 'melokids' ),
        );

        $default_orderby = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
        $orderby         = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby; // WPCS: sanitization ok, input var ok, CSRF ok.

        if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
            $orderby = current( array_keys( $catalog_orderby_options ) );
        }
        ?>
            <div class="filter-by-order">
                <ul class="filter-orderby hozr justify-content-center <?php echo melokids_align();?>">
                    <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
                        <?php

                        $link = get_permalink( wc_get_page_id( 'shop' ));

                        $link = add_query_arg( 'orderby', $id, $link );

                        ?>
                        <li>
                            <a href="<?php echo esc_url( $link ); ?>" data-order="<?php echo esc_attr( $id ); ?>"
                               class="wc-widget-filter <?php if ( selected( $orderby, $id, false ) ) {
                                   echo 'selected-order';
                               } ?>"><?php echo esc_html( $name ); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php

    }
}


/**
 * Products Filter
 * Add widget to filter area
 *
*/
/**
 * Output the product sorting options.
 * Custom html output layout 
 * Display as list
 */
if ( ! function_exists( 'melokids_woocommerce_catalog_ordering_list' ) ) {
    /**
     * Products Filter
     * Filter By Order
    */
    add_action('melokids_wc_filter_content', 'melokids_woocommerce_catalog_ordering_list', 2);
    function melokids_woocommerce_catalog_ordering_list() {
        if(is_active_sidebar('shop-filter')) return; 
        if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
            return;
        }
        $show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
        $catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
            'menu_order' => esc_html__( 'Default sorting', 'melokids' ),
            'popularity' => esc_html__( 'Sort by popularity', 'melokids' ),
            'rating'     => esc_html__( 'Sort by average rating', 'melokids' ),
            'date'       => esc_html__( 'Sort by newness', 'melokids' ),
            'price'      => esc_html__( 'Sort by price: low to high', 'melokids' ),
            'price-desc' => esc_html__( 'Sort by price: high to low', 'melokids' ),
        ) );

        $default_orderby = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
        $orderby         = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby; // WPCS: sanitization ok, input var ok, CSRF ok.

        if ( wc_get_loop_prop( 'is_search' ) ) {
            $catalog_orderby_options = array_merge( array( 'relevance' => esc_html__( 'Relevance', 'melokids' ) ), $catalog_orderby_options );

            unset( $catalog_orderby_options['menu_order'] );
        }

        if ( ! $show_default_orderby ) {
            unset( $catalog_orderby_options['menu_order'] );
        }

        if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
            unset( $catalog_orderby_options['rating'] );
        }

        if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
            $orderby = current( array_keys( $catalog_orderby_options ) );
        }
        ?>
        <div class="widget zk-filter filter-by-sort col">
            <h5><?php esc_html_e('Sort By','melokids');?></h5>
            <ul class="orderby">
                <?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
                    <?php

                    $link = get_permalink( wc_get_page_id( 'shop' ));

                    $link = add_query_arg( 'orderby', $id, $link );

                    ?>
                    <li>
                        <a href="<?php echo esc_url( $link ); ?>" data-order="<?php echo esc_attr( $id ); ?>"
                           class="wc-widget-filter <?php if ( selected( $orderby, $id, false ) ) {
                               echo 'selected-order';
                           } ?>"><?php echo esc_html( $name ); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php

    }
}
if(!function_exists('melokids_woocommerce_get_catalog_ordering_args')){
    add_filter( 'woocommerce_get_catalog_ordering_args', 'melokids_woocommerce_get_catalog_ordering_args' );
    function melokids_woocommerce_get_catalog_ordering_args( $args ) {
      
      $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
        if ( 'on_sale' == $orderby_value ) {
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'desc';
            $args['meta_key'] = '_sale_price';
        }
        if('bestselling' == $orderby_value){
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'desc';
            $args['meta_key'] = 'total_sales';
        }
        
        return $args;
    }
}
if(!function_exists('melokids_woocommerce_default_catalog_orderby_options')){
    add_filter( 'woocommerce_default_catalog_orderby_options', 'melokids_woocommerce_default_catalog_orderby_options' );
    add_filter( 'woocommerce_catalog_orderby', 'melokids_woocommerce_default_catalog_orderby_options' );
    function melokids_woocommerce_default_catalog_orderby_options( $sortby ) {
        $sortby['on_sale']     = esc_html__('Sort by On Sale','melokids');
        $sortby['bestselling'] = esc_html__('Sort by Best Selling','melokids');
        return $sortby;
    }
}
if(!function_exists('melokids_woocommerce_shop_filters')){
    add_action('melokids_wc_filter_content', 'melokids_woocommerce_shop_filters', 3);
    function melokids_woocommerce_shop_filters(){
        if(is_active_sidebar('shop-filter')){
            dynamic_sidebar('shop-filter');
        } else {
            /**
             * Products Filter
             * Filter By Price
            */
            if(class_exists('MeloKids_Widget_Price_Filter')){
                $args = [
                    'title'           => esc_html__('Prices','melokids'),
                ];
                the_widget(
                    'MeloKids_Widget_Price_Filter',
                    $args,
                    array(
                        'before_widget' => '<div class="widget zk-filter filter-by-price col theme-style">',
                        'after_widget'  => '</div>',
                        'before_title'  => '<h5>',
                        'after_title'   => '</h5>',
                    ) 
                );
            }
            /**
             * Products Filter
             * Filter By Size
            */
            $filter_wg = class_exists('Melokids_WC_Widget_Layered_Nav') ? 'Melokids_WC_Widget_Layered_Nav' : 'WC_Widget_Layered_Nav';
            $filter_wg_style = class_exists('Melokids_WC_Widget_Layered_Nav') ? 'theme-style' : '';
            if(class_exists($filter_wg)){
                $args = [
                    'title'           => esc_html__('Sizes','melokids'),
                    'attribute'       => 'size',
                    'display_type'    => 'list',
                    'query_type'      => 'and'
                ];
                the_widget(
                    $filter_wg,
                    $args,
                    array(
                        'before_widget' => '<div class="widget widget_layered_nav zk-filter filter-by-size col '.$filter_wg_style.'">',
                        'after_widget'  => '</div>',
                        'before_title'  => '<h5>',
                        'after_title'   => '</h5>',
                    ) 
                );
            }
            /**
             * Products Filter
             * Filter By Colors
            */
            if(class_exists($filter_wg)){
                $args = [
                    'title'           => esc_html__('Colors','melokids'),
                    'attribute'       => 'color',
                    'display_type'    => 'list',
                    'query_type'      => 'and',
                ];
                the_widget(
                    $filter_wg,
                    $args,
                    array(
                        'before_widget' => '<div class="widget widget_layered_nav zk-filter filter-by-color col '.$filter_wg_style.'">',
                        'after_widget'  => '</div>',
                        'before_title'  => '<h5>',
                        'after_title'   => '</h5>',
                    ) 
                );
            }
            /**
             * Products Filter
             * Filter By Categories
            */
            if(class_exists('WC_Widget_Product_Categories')){
                $args = [
                    'title'           => esc_html__('Categories','melokids'),
                    'orderby'         => 'name',
                    'count'           => '1'
                ];
                the_widget(
                    'WC_Widget_Product_Categories',
                    $args,
                    array(
                        'before_widget' => '<div class="widget widget_product_categories zk-filter filter-by-cat col theme-style">',
                        'after_widget'  => '</div>',
                        'before_title'  => '<h5>',
                        'after_title'   => '</h5>',
                    ) 
                );
            }
            /**
             * Products Filter
             * Filter By Brand
            */
            if(class_exists($filter_wg)){
                $args = [
                    'title'           => esc_html__('Brand','melokids'),
                    'attribute'       => 'brand',
                    'display_type'    => 'list',
                    'query_type'      => 'and'
                ];
                the_widget(
                    $filter_wg,
                    $args,
                    array(
                        'before_widget' => '<div class="widget widget_layered_nav zk-filter filter-by-brand col">',
                        'after_widget'  => '</div>',
                        'before_title'  => '<h5>',
                        'after_title'   => '</h5>',
                    ) 
                );
            }
        }
    }
}

/**
 * Products Active Filter
 * Show filtered option
*/
if(!function_exists('melokids_woocommerce_shop_filtered')){
	add_action('melokids_woocommerce_default', 'melokids_woocommerce_shop_filtered', 1);
	function melokids_woocommerce_shop_filtered($args = []){
		
		$args = wp_parse_args($args, [
			'title'           => '',
        ]);
        $filter_wg = class_exists('Melokids_WC_Widget_Layered_Nav_Filters') ? 'Melokids_WC_Widget_Layered_Nav_Filters' : 'WC_Widget_Layered_Nav_Filters';
        $filter_wg_style = class_exists('Melokids_WC_Widget_Layered_Nav_Filters') ? 'theme-style' : '';
        if(class_exists($filter_wg)){
            the_widget(
                $filter_wg,
                $args,
                array(
                    'before_widget' => '<div class="widget widget_layered_nav widget_layered_nav_filters zk-filtered '.$filter_wg_style.'">',
                    'after_widget'  => '</div>',
                ) 
            );
        }
	}
}

/**
 * Product filter result
 * no product found message
 * Add filter bar on no-result page
 * Add return shop button on no-result page
*/
add_action('woocommerce_no_products_found','melokids_woocommerce_before_shop_loop',0);
if(!function_exists('melokids_woocommerce_return_shop_filter')){
    add_action('woocommerce_no_products_found','melokids_woocommerce_return_shop_filter',99);
    function melokids_woocommerce_return_shop_filter(){
        ?>
            <div class="return-to-shop">
                <a class="zk-btn-primary wc-widget-filter" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
                    <?php esc_html_e( 'Reset all filter', 'melokids' ); ?>
                </a>
            </div>
        <?php
    }
}

