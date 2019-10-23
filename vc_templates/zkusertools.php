<?php 
    $add_icon1 = $icon_name1 = $iconClass1 = $add_icon2 = $icon_name2 = $iconClass2 = $add_icon3 = $icon_name3 = $iconClass3 = $add_icon4 = $icon_name4 = $iconClass4 = '';

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    if(empty($el_id)) $el_id = uniqid();
    $html_id = 'zk-usertools-'.$el_id;
    
    /* get value for Design Tab */
    $css_classes = array(
        $color_mode,
        vc_shortcode_custom_css_class( $css ),
    );

    $css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
    
    /* Icon */
    
    if('true' === $add_icon1){
        $icon_name1 = "i1_icon_" . $i1_type;
        $iconClass1 = isset($atts[$icon_name1]) ? $atts[$icon_name1]: '';
    }
    if('true' === $add_icon2){
        $icon_name2 = "i2_icon_" . $i2_type;
        $iconClass2 = isset($atts[$icon_name2]) ? $atts[$icon_name2]: '';
    }
    if('true' === $add_icon3){
        $icon_name3 = "i3_icon_" . $i3_type;
        $iconClass3 = isset($atts[$icon_name3]) ? $atts[$icon_name3]: '';
    }
    if('true' === $add_icon4){
        $icon_name4 = "i4_icon_" . $i4_type;
        $iconClass4 = isset($atts[$icon_name4]) ? $atts[$icon_name4]: '';
    }

    ob_start();
    if('true' === $show_account) : 
        if(!empty($account_page))
            $link = get_the_permalink(melokids_get_id_by_slug($account_page, 'page'));
        elseif(class_exists('WooCommerce'))
            $link = wc_get_page_permalink( 'myaccount' );
        else 
            $link = get_edit_user_link();
    ?>
        <a class="ut-link <?php echo empty($title_myaccount) ? 'no-title' : '';?>" href="<?php echo esc_url($link); ?>">
        <?php if( !empty($iconClass1) ) :?>
            <span class="<?php echo esc_attr($iconClass1); ?>"></span>
        <?php endif;
            if(!empty($title_myaccount)) {
                $class = ['d-md-inline-block'];
                if('true' === $add_icon1) $class[] = 'd-none';
                echo '<span class="'.implode(' ', $class).'">'.esc_html($title_myaccount).'</span>';
            }
        ?>
        </a>
    <?php endif;

    $account = ob_get_clean();

    ob_start();
    if(isset($show_wishlist) && 'true' === $show_wishlist) : 
        if(!empty($wishlist_page))
            $link = get_the_permalink(melokids_get_id_by_slug($wishlist_page, 'page'));
        elseif (!empty(get_option('woosw_page_id')))
            $link = class_exists('WPcleverWoosw') ? WPcleverWoosw::get_url() : get_the_permalink(get_option('woosw_page_id'));
        else 
            $link = '#';
    ?>
        <a class="ut-link wswl-page <?php echo empty($title_wishlist) ? 'no-title' : '';?>" href="<?php echo esc_url($link); ?>">
        <?php if(!empty($iconClass2) ) :?>
            <span class="<?php echo esc_attr($iconClass2); ?>"></span>
        <?php endif;
            if(!empty($title_wishlist)) {
                $class = ['d-md-inline-block'];
                if('true' === $add_icon2) $class[] = 'd-none';
                echo '<span class="'.implode(' ', $class).'">'.esc_html($title_wishlist).'</span>';
                echo '<span class="wswl-count" data-count="'.esc_html(WPcleverWoosw::get_count()).'"><span class="wssl-count-number d-none">'.esc_html(WPcleverWoosw::get_count()).'</span></span>';
            }
        ?>
        </a>
    <?php endif;
    $wishlist = ob_get_clean();
    if('true' === $show_search) : 
        wp_enqueue_script( 'magnific-popup');
        wp_enqueue_style( 'magnific-popup');
    ob_start();
    ?>
        <a href="#zk-usertools-search<?php echo esc_attr($el_id);?>" class="ut-link mfp-search <?php echo empty($title_search) ? 'no-title' : '';?>">
        <?php if( !empty($iconClass3) ) :?>
            <span class="<?php echo esc_attr($iconClass3); ?>"></span>
        <?php endif;
            if(!empty($title_search)) {
                $class = ['d-md-inline-block'];
                if('true' === $add_icon3) $class[] = 'd-none';
                echo '<span class="'.implode(' ', $class).'">'.esc_html($title_search).'</span>';
            }
        ?>
        </a>
        <div id="zk-usertools-search<?php echo esc_attr($el_id);?>" class="mfp-hide">
            <?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>
            <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input type="search" id="<?php echo esc_attr($unique_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Type something to search ...', 'placeholder', 'melokids' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                <button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'melokids' ); ?></span></button>
            </form>
        </div>
    <?php endif;
    $search = ob_get_clean();

    
    if(class_exists('WooCommerce') && 'true' === $show_cart) : 
        wp_enqueue_script( 'magnific-popup');
        wp_enqueue_style( 'magnific-popup');
    ob_start();
        ?>
        <a href="#zk-usertools-cart<?php echo esc_attr($el_id);?>" class="ut-link mfp-inline <?php echo empty($title_cart) ? 'no-title' : '';?>">
        <?php if( !empty($iconClass4) ) :?>
            <span class="<?php echo esc_attr($iconClass4); ?>"><span class="data-cart-count" data-count="<?php echo WC()->cart->cart_contents_count; ?>"></span></span>
        <?php endif;
            if(!empty($title_cart)) {
                $class = ['d-md-inline-block'];
                if('true' === $add_icon4) $class[] = 'd-none';
                echo '<span class="'.implode(' ', $class).'">'.esc_html($title_cart).'</span>';
            }
            //if(!$layout_template === '2') {
        ?>
            <span class="cart-total-wrap">(<span class="cart-count"><?php echo WC()->cart->cart_contents_count; ?></span>)</span>
        <?php //} ?>
        </a>
        <div id="zk-usertools-cart<?php echo esc_attr($el_id);?>" class="mfp-hide"><div class="container"><div class="row"><div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3"><?php melokids_wc_cart(); ?></div></div></div></div>
    <?php endif;
    $cart = ob_get_clean();

    $classes = [
        'zk-usertools',
        trim($css_class),
        'clearfix'
    ];

?>
<div id="<?php echo esc_attr($html_id);?>" class="<?php echo trim(implode(' ', $classes));?>">
    <?php switch ($layout_template) {
        case '2':
        ?>
            <div class="row justify-content-between align-items-center <?php echo esc_attr($gutters.' '.$el_class);?>">
                <div class="row col-auto <?php echo esc_attr($gutters);?>">
                    <?php if(!empty($account)) :?><div class="col-auto"><?php printf('%s',$account); ?></div><?php endif; ?>
                    <?php if(!empty($wishlist)) :?><div class="col-auto"><?php printf('%s',$wishlist); ?></div><?php endif; ?>
                </div>
                <div class="row col-auto <?php echo esc_attr($gutters);?>">
                    <?php if(!empty($search)) :?><div class="col-auto"><?php printf('%s',$search); ?></div><?php endif; ?>
                    <?php if(!empty($cart)) :?><div class="col-auto"><?php printf('%s',$cart); ?></div><?php endif; ?>
                </div>
            </div>
        <?php
            break;
        
        default:
        $classes = ['row', 'align-items-center', $gutters, $el_class];
        if(!empty($content_align)) $classes[] = 'justify-content-'.$content_align;
        ?>
        <div class="<?php echo trim(implode(' ', $classes));?>">
            <?php if(!empty($account)) :?><div class="col-auto"><?php printf('%s',$account); ?></div><?php endif; ?>
            <?php if(!empty($wishlist)) :?><div class="col-auto"><?php printf('%s',$wishlist); ?></div><?php endif; ?>
            <?php if(!empty($search)) :?><div class="col-auto"><?php printf('%s',$search); ?></div><?php endif; ?>
            <?php if(!empty($cart)) :?><div class="col-auto"><?php printf('%s',$cart); ?></div><?php endif; ?>
        </div>
        <?php
            break;
    } ?>
</div>