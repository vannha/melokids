<?php
/**
 * MeloKids Logo
*/
if(!function_exists('melokids_logo')){
    function melokids_logo($args = []){
        $args = wp_parse_args($args, [
            'class' => ''
        ]);
        $title = get_bloginfo('name');
        $header_layout = melokids_get_opts('header_layout','3');

        if(file_exists(get_template_directory().'/assets/images/logo'.$header_layout.'.png')){
            $default_logo = get_template_directory_uri() . '/assets/images/logo'.$header_layout.'.png';
        } else {
            $default_logo = get_template_directory_uri() . '/assets/images/logo.png';
        }

        $logo          = melokids_get_opts('main_logo', $default_logo, 'url');
        $_ontop_logo   = melokids_get_opts('ontop_logo','', 'url');
        $_sticky_logo  = melokids_get_opts('sticky_logo','', 'url');

        $main_logo   = !empty($logo) ? $logo : $default_logo;
        $ontop_logo  = !empty($_ontop_logo) ? $_ontop_logo : get_template_directory_uri() . '/assets/images/logo-ontop.png';
        $sticky_logo = !empty($_sticky_logo) ? $_sticky_logo : get_template_directory_uri() . '/assets/images/logo-ontop.png';

        $show_ontop_logo  = melokids_get_opts('header_ontop','0');
        $show_sticky_logo = melokids_get_opts('header_sticky','0');
        /* Custom logo on page */
        $page_logo = melokids_get_opts('page_logo','', 'url');

        if(!empty($page_logo)) {
            $main_logo = $ontop_logo = $sticky_logo = $page_logo;
            $logo_output = '<img class="page-logo" alt="' . esc_attr($title). '" src="' . esc_url($page_logo) . '"/>';
        } else {
            /* Main Logo */
            $logo_output = '<img class="main-logo" alt="' . esc_attr($title). '" src="' . esc_url($main_logo) . '"/>';
            /* On Top Logo */
            if($show_ontop_logo === '1') {
               $logo_output .= '<img class="ontop-logo" alt="' . esc_attr($title). '" src="' . esc_url($ontop_logo) . '"/>';
            }
            /* Sticky Logo */
            if($show_sticky_logo === '1') $logo_output .= '<img class="sticky-logo" alt="' . esc_attr($title). '" src="' . esc_url($sticky_logo) . '"/>';
        }
        $html_atts = ['id="zk-logo"'];
        $classes = ['header-'.$header_layout, $args['class']];
        if(is_singular() && melokids_get_opts('page_show_logo', '1') === '0') $classes[] = 'd-xl-none';
        $html_atts[] = 'class="'.trim(implode(' ', $classes)).'"';
    ?>
        <div <?php echo trim(implode(' ', $html_atts));?>><?php 
            echo '<a href="' . esc_url(home_url('/')) . '" title="'.esc_attr($title).'" class="header-'.esc_attr($header_layout).'">';
                switch ($logo_type) {
                    default:
                        echo wp_kses_post($logo_output);
                        break;
                }
            echo '</a>';
        ?></div>
    <?php
    }
}

/**
 * MeloKids Header Navigation
 */
if(!function_exists('melokids_header_navigation')){
    function melokids_header_navigation($args = []){
        $args = wp_parse_args($args,[
            'class'        => '',
            'walker'       => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
            'add_li_class' => 'zk-menu-item'
        ]);
        /* get menu for each page */
        $default_menu = is_nav_menu('all-pages') ? 'all-pages' : '';
        $header_menu = melokids_get_opts('header_menu', $default_menu);
        /* Empty menu for each page */
        if($header_menu === 'none') return;

        $attr = array(
            'menu_class'        => 'zk-main-nav desktop-nav',
            'container_class'   => 'zk-main-navigation clearfix',
            'theme_location'    => 'primary',
            'link_before'       => '<span class="menu-title">',
            'link_after'        => '</span>',
            'fallback_cb'       => false,
            'echo'              => false,
            'walker'            => $args['walker'],
            'add_li_class'      => $args['add_li_class']
        );
        if(!empty($header_menu)) $attr['menu'] = $header_menu;

        $html_atts = ['id="zk-navigation"'];
        if(!empty($args['class'])) $html_atts[] = 'class="'.$args['class'].'"';
        /* main nav. */
        echo '<nav '.trim(implode(' ', $html_atts)).'>'.wp_nav_menu( $attr ).'</nav>';
    }
}
add_filter('nav_menu_item_id', function(){ return false;});
/**
 * main navigation left.
 * used for header layout 2
 */
if(!function_exists('melokids_header_navigation_left')){
    function melokids_header_navigation_left($args = []){
    	$args = wp_parse_args($args,[
            'class' => ''
        ]);
        /* get menu for each page */
        $default_menu = is_nav_menu('all-pages') ? 'short' : '';
        $header_menu_left = melokids_get_opts('header_menu_left', $default_menu);
        /* Empty menu for each page */
        if(empty($header_menu_left) || $header_menu_left === 'none') return;
        $attr = array(
            'menu_class'        => 'zk-main-nav desktop-nav zk-menu-left clearfix',
            'container_class'   => 'zk-main-navigation', 
            'theme_location'    => 'primary',
            'link_before'       => '<span class="menu-title">',
            'link_after'        => '</span>',
            'fallback_cb'       => false,
            'echo'              => false,
            'menu'              => $header_menu_left,
            'walker'            => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
            'add_li_class'      => 'zk-menu-item'
        );

        $html_atts = ['id="zk-navigation-left"'];
        if(!empty($args['class'])) $html_atts[] = 'class="'.$args['class'].'"';


        /* Menu Left */
        echo '<nav '.trim(implode(' ', $html_atts)).'>'.wp_nav_menu( $attr ).'</nav>';
    }
}
/**
 * main navigation right.
 * used for header layout 2
 */
if(!function_exists('melokids_header_navigation_right')){
    function melokids_header_navigation_right($args = []){
    	$args = wp_parse_args($args,[
            'class' => ''
        ]);
        /* get menu for each page */
        $default_menu = is_nav_menu('all-pages') ? 'short' : '';
        $header_menu_right = melokids_get_opts('header_menu_right', $default_menu);

        /* Empty menu for each page */
        if(empty($header_menu_right) || $header_menu_right === 'none') return;
        $attr = array(
            'menu_class'        => 'zk-main-nav desktop-nav zk-menu-right clearfix',
            'container_class'   => 'zk-main-navigation',
            'theme_location'    => 'primary',
            'link_before'       => '<span class="menu-title">',
            'link_after'        => '</span>',
            'fallback_cb'       => false,
            'echo'              => false,
            'menu'              => $header_menu_right,
            'walker'            => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
            'add_li_class'      => 'zk-header-menu-item'
        );
        $html_atts = ['id="zk-navigation-right"'];
        if(!empty($args['class'])) $html_atts[] = 'class="'.$args['class'].'"';

        /* Menu Right */
        echo '<nav '.trim(implode(' ', $html_atts)).'>'.wp_nav_menu( $attr ).'</nav>';
    }
}

/**
 * MeloKids Header Attributes
*/
if(!function_exists('melokids_header_atts')){ 
    function melokids_header_atts($args = []){
        $args = wp_parse_args($args,[
            'class' => ''
        ]);
        $html_atts = ['id="zk-header-atts"'];
        if(!empty($args['class'])) $html_atts[] = 'class="'.$args['class'].'"';
    ?><div <?php echo trim(implode(' ', $html_atts));?>><?php 
        melokids_header_search();
        melokids_header_wc_cart();
        melokids_header_tools();
        melokids_header_sidebar_menu();
        melokids_header_donate();
        melokids_header_social();
        melokids_header_mobile_nav();
    ?></div><?php
    }
}

/**
 * Header Search Icon 
*/
if(!function_exists('melokids_header_search')){
    function melokids_header_search($args=[]){
        $args = wp_parse_args($args,[
            'icon' => 'fa fa-search'
        ]);
        $header_search = melokids_get_opts('header_search','0');
        if('0' === $header_search) return;
        wp_enqueue_script('magnific-popup');
        wp_enqueue_style('magnific-popup');
        $unique_id = esc_attr( uniqid( 'search-form-' ) );

    ?><a href="#zk-header-search" class="mfp-search">
        <span class="<?php echo esc_attr($args['icon']);?>"></span>
    </a><div id="zk-header-search" class="mfp-hide">
        <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="search" id="<?php echo esc_attr($unique_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Type something to search ...', 'placeholder', 'melokids' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
            <button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'melokids' ); ?></span></button>
        </form>
    </div><?php
    }
}
/**
 * Header WC Cart Icon
*/
if(!function_exists('melokids_header_wc_cart')){
    function melokids_header_wc_cart($args=[]){
        $args = wp_parse_args($args, [
            'icon' => 'fa fa-shopping-basket'
        ]);
        $header_wc_cart = melokids_get_opts('header_wc_cart', '0');
        if('0' === $header_wc_cart || !class_exists('WooCommerce')) return;
        wp_enqueue_script('magnific-popup');
        wp_enqueue_style('magnific-popup');
    ?><a href="#zk-header-wc-cart" class="mfp-inline"><span class="cart-icon-wrap"><span class="<?php echo esc_attr($args['icon']);?>"></span><span class="cart-count"><?php echo WC()->cart->cart_contents_count; ?></span></span></a>
        <div id="zk-header-wc-cart" class="mfp-hide">
            <div class="widget_shopping_cart">
                <div class="widget_shopping_cart_content">
                    <?php woocommerce_mini_cart(); ?>
                </div>
            </div>
        </div>
    <?php
    }
}
/**
 * Header Tools Icon 
*/
if(!function_exists('melokids_header_tools')){
    function melokids_header_tools($args=[]){
        $args = wp_parse_args($args,[
            'icon' => 'fa fa-cogs'
        ]);
        $header_tool = melokids_get_opts('header_tool','0');
        if('0' === $header_tool || !is_active_sidebar('header-tool')) return;
        global $theme_options, $meta_options;
        if($meta_options['header_tool'] === '1')
            $display = $meta_options['header_tool_screen'];
        else 
            $display = $theme_options['header_tool_screen'];

        $d_class = ['mfp-html'];
        if(!empty($display)){
            if(!in_array('1', $display)) $d_class[] = 'd-xs-none'; else $d_class[] = 'd-xs-inline';
            if(!in_array('2', $display)) $d_class[] = 'd-sm-none'; else $d_class[] = 'd-sm-inline';
            if(!in_array('3', $display)) $d_class[] = 'd-md-none'; else $d_class[] = 'd-md-inline';
            if(!in_array('4', $display)) $d_class[] = 'd-lg-none'; else $d_class[] = 'd-lg-inline';
            if(!in_array('5', $display)) $d_class[] = 'd-xl-none'; else $d_class[] = 'd-xl-inline';
        } else {
            $d_class[] = 'd-none';
        } 
        
        wp_enqueue_script('magnific-popup');
        wp_enqueue_style('magnific-popup');
    ?><a href="#zk-header-tool" class="<?php echo trim(implode(' ', $d_class));?>">
        <span class="<?php echo esc_attr($args['icon']);?>"></span>
    </a><div id="zk-header-tool" class="mfp-hide container"><?php dynamic_sidebar('header-tool');?></div><?php
    }
}

/**
 * Header Sidebar Menu
*/
if(!function_exists('melokids_header_sidebar_menu')){
    function melokids_header_sidebar_menu($args=[]){
        $args = wp_parse_args($args,[
            'icon' => 'fa fa-sign-in'
        ]);
        $sidebar_menu = melokids_get_opts('sidebar_menu','0');
        if('0' === $sidebar_menu || !is_active_sidebar('zk-sidebar-menu')) return;
    ?><a href="#zk-sidebar-menu" class="mfp-html">
        <span class="<?php echo esc_attr($args['icon']);?>"></span>
    </a><div id="zk-sidebar-menu" class="mfp-hide container"><?php dynamic_sidebar('zk-sidebar-menu');?></div><?php
    }
}

/**
 * Header Donate Button
*/
if(!function_exists('melokids_header_donate')){
    function melokids_header_donate($args=[]){
        $args = wp_parse_args($args,[
            'icon' => 'fa fa-money'
        ]);
        $header_donate = melokids_get_opts('header_donate','0');
        if('0' === $header_donate) return;

        global $theme_options, $meta_options;

        $url1 = (isset($meta_options['header_donate_url']) && !empty($meta_options['header_donate_url'])) ? $meta_options['header_donate_url'] : $theme_options['header_donate_url'];
        $url2 = (isset($meta_options['header_donate_url2']) && !empty($meta_options['header_donate_url2'])) ? $meta_options['header_donate_url2'] : $theme_options['header_donate_url2'];
        
        $page_id = melokids_get_page_by_slug($url1);
        $target = '_self';

        $label = melokids_get_opts('header_donate_label', esc_html__('Donate Now','melokids'));

        switch ($header_donate) {
            case '1':
                $url = get_post_type_archive_link( 'ef4d_donation' );
                break;
            case '2':
                $url = get_permalink($page_id);
                break;
            case '3':
                $url = $url2;
                $target = '_blank';
                break;
            default:
                $url = '';
                break;
        }
    ?><a href="<?php echo esc_attr($url);?>" class="btn-primary"><?php 
    	echo !empty($label) ? esc_html($label) : esc_html__('Donate Now','melokids'); 
    ?></a><?php
    }
}

/**
 * Header Social 
*/
if(!function_exists('melokids_header_social')){
    function melokids_header_social(){
        $header_social = melokids_get_opts('header_social','0');
        if('0' === $header_social) return;
        melokids_social_list();
    }
}
/**
 * Theme social list
*/
function melokids_social_list($args = []){
    $args = wp_parse_args($args, [
        'layout' => '1'
    ]);
    $icons = '';
    for ($i=0; $i <= 10; $i++) { 
        $title{$i}  = melokids_get_opts('s'.$i.'_title', '');
		$url{$i}  = melokids_get_opts('s'.$i.'_url', '');
		$icon{$i} = melokids_get_opts('s'.$i.'_icon', '');
        switch ($args['layout']) {
            case '2':
                if(!empty($url{$i}) && !empty($icon{$i}))
                    $icons .= '<a title="'.esc_attr($title{$i}).'" href="'.esc_url($url{$i}).'"><span class="'.esc_attr($icon{$i}).'"></span>'.esc_attr($title{$i}).'</a>';
                break;
            
            default:
                if(!empty($url{$i}) && !empty($icon{$i}))
                    $icons .= '<a title="'.esc_attr($title{$i}).'" href="'.esc_url($url{$i}).'"><span class="'.esc_attr($icon{$i}).'"></span></a>';
                break;
        }
    	
    }
    if(empty($icons)) return;
	echo wp_kses_post($icons);   
}

/**
 * MeloKids Mobile Navigation Icon
*/
if(!function_exists('melokids_header_mobile_nav')){
	function melokids_header_mobile_nav($args = []){
		$args = wp_parse_args($args, []);
		echo '<a id="zk-menu-mobile" class="hamburger d-xl-none" href="javascript:void(0)" title="'.esc_attr__('Open Menu','melokids').'"><span></span></a>';
	}
}

/**
 * MeloKids Loop Header 
*/
if(!function_exists('melokids_entry_header')){
	function melokids_entry_header($args = []){
		$args = wp_parse_args($args, [
			'tag'			=> 'h3',
			'meta'          => 'after',
			'meta_args'		=> [],
			'title_class'	=> '',
			'class'			=> ''
		]);
		/* css class */
		$classes = ['entry-header',$args['class']];
		/* title css class */
		$title_class = ['entry-title', $args['title_class'], 'meta-'.$args['meta']];
        /* Sticky post */
        if(is_sticky())
            $sticky_icon = '<span class="post-sticky-icon fa fa-thumb-tack"></span>&nbsp;&nbsp;';
        else 
            $sticky_icon = '';
        /**
         * Page title 
         * Check Page title is On/Off then hide/show single page/post title
         *
        */
        $show_page_title   = melokids_get_opts('page_title', '1');
	?><div class="<?php echo trim(implode(' ', $classes));?>"><?php
		/* Meta list before title */
		if('before' === $args['meta']) 
			melokids_entry_meta($args['meta_args']);
		/* Post title */
		if(is_singular())
			if($show_page_title !== '1') 
                the_title('<'.$args['tag'].' class="'.trim(implode(' ', $title_class)).'">','</'.$args['tag'].'>');
            else 
                echo '';
		else
			the_title('<'.$args['tag'].' class="'.trim(implode(' ', $title_class)).'"><a href="'.get_permalink().'">'.$sticky_icon,'</a></'.$args['tag'].'>');
		/* Meta list after title */
		if('after' === $args['meta']) 
			melokids_entry_meta($args['meta_args']);
	?></div><?php
	}
}

/**
 * MeloKids Loop Meta
*/
if(!function_exists('melokids_entry_meta')){
	function melokids_entry_meta($args = []){
        $show_date   = is_singular() ? melokids_get_opts('single_date','1') : melokids_get_opts('loop_date','1');
        $show_cate   = is_singular() ? melokids_get_opts('single_category','1') : melokids_get_opts('loop_category','1');
        $show_author = is_singular() ? melokids_get_opts('single_author','1') : melokids_get_opts('loop_author','1');
        $show_cmt    = is_singular() ? melokids_get_opts('single_comment','1') : melokids_get_opts('loop_cmt','1');
        $show_view   = is_singular() ? melokids_get_opts('single_view','0') : melokids_get_opts('loop_view','0');
        $show_like   = is_singular() ? melokids_get_opts('single_like','0') : melokids_get_opts('loop_like','0');
        $show_share  = is_singular() ? melokids_get_opts('single_share','0') : melokids_get_opts('loop_share','0');
		$args = wp_parse_args($args, [
            'taxonomy'    => 'cat',
            'show_date'   => $show_date,
            'date_icon'   => '<span class="meta-icon fa fa-clock-o"></span>&nbsp;&nbsp;',
            'show_author' => $show_author,
            'author_icon' => '<span class="meta-icon fa fa-user"></span>&nbsp;&nbsp;',
            'show_cate'   => $show_cate,
            'cat_icon'    => '<span class="meta-icon fa fa-folder-open"></span>&nbsp;&nbsp;',
            'show_cmt'    => $show_cmt,
            'cmt_icon'    => '<span class="meta-icon fa fa-comment-o"></span>&nbsp;&nbsp;',
            'show_view'   => $show_view,
            'view_icon'   => '<span class="meta-icon fa fa-eye"></span>&nbsp;&nbsp;',
            'show_like'   => $show_like,
            'like_icon'   => '<span class="meta-icon fa fa-heart-o"></span>&nbsp;&nbsp;',
            'liked_icon'  => '<span class="meta-icon fa fa-heart"></span>&nbsp;&nbsp;',
            'show_share'  => $show_share,
            'share_icon'  => '<span class="meta-icon fa fa-share-alt"></span>&nbsp;&nbsp;',
            'class'       => ''
		]);
        $post_type = get_post_types();
        $term  = melokids_get_taxonimies($args['taxonomy']);

		/* css class */
		$classes = ['entry-meta row', $args['class']];
	?>
	<div class="<?php echo trim(implode(' ', $classes));?>"><?php
		/* Meta Date */
		if($args['show_date'] === '1') melokids_get_date(['before' => '<div class="meta-item col-auto">','after' => '</div>', 'icon'=> $args['date_icon'] ]);
		/* Meta Author */
		if($args['show_author'] === '1') melokids_get_author(['before' => '<div class="meta-item col-auto">','after' => '</div>', 'icon' => $args['author_icon'] ]);
		/* Meta category */
		if(has_term('',$term) && $args['show_cate'] === '1') melokids_the_terms(['before' => '<div class="meta-item col-auto">','after' => '</div>','term' => $term, 'icon' => $args['cat_icon'] ]);
		/* Meta Comment */
		if($args['show_cmt'] === '1') melokids_cmt_count(['before' => '<div class="meta-item col-auto">','after' => '</div>','icon' => $args['cmt_icon'] ]);
        /* Meta View */
        if($args['show_view'] === '1') melokids_get_post_views(['before' => '<div class="meta-item col-auto">','after' => '</div>', 'icon' => $args['view_icon'] ]);
        /* Meta Like */
        if($args['show_like'] === '1') melokids_like_post(['before' => '<div class="meta-item col-auto">','after' => '</div>', 'icon' => $args['like_icon'], 'icon_liked' => $args['liked_icon'] ]);
        /* Meta Share */
        if($args['show_share'] === '1') melokids_meta_share(['before' => '<div class="meta-item col-auto">','after' => '</div>', 'icon' => $args['share_icon'] ]);
	?></div><?php
	}
}

/**
 * MeloKids Get Date
*/
if(!function_exists('melokids_get_date')){
    function melokids_get_date($args = []){
        $args = wp_parse_args($args, [
            'before' => '',
            'after'  => '',
            'icon'   => '<span class="meta-icon fa fa-clock-o"></span> '
        ]);
        echo wp_kses_post($args['before'].$args['icon'].get_the_date().$args['after']);
    }
}
/**
 * MeloKids Get Author
*/
if(!function_exists('melokids_get_author')){
    function melokids_get_author($args = []){
        $args = wp_parse_args($args, [
            'before' => '',
            'after'  => '',
            'link'   => true,
            'icon'   => '<span class="meta-icon fa fa-user"></span> '
        ]);
        echo wp_kses_post($args['before']);
        echo wp_kses_post($args['icon']);
        if($args['link'])
            the_author_posts_link();
        else 
            echo get_the_author();
        echo wp_kses_post($args['after']);        
    }
}
if(!function_exists('melokids_the_terms')){
    function melokids_the_terms($args = []){
        $args = wp_parse_args($args, [
            'before'    => '',
            'after'     => '',
            'term'      => 'category',
            'seperator' => ' / ',
            'icon'      => '<span class="meta-icon fa fa-folder-open"></span> '
        ]);
        the_terms( get_the_ID(), $args['term'] , $args['before'].$args['icon'], $args['seperator'], $args['after']);
    }
}

/**
 * MeloKids Loop Comments Count 
*/
if(!function_exists('melokids_cmt_count')){
	function melokids_cmt_count($args = []){
        $args = wp_parse_args($args, [
            'before' => '',
            'after'  => '',
            'icon'   => '<span class="meta-icon fa fa-comment-o"></span> '
        ]);

		if(!comments_open())  return;
		$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
		if ( $num_comments == 0 ) {
			$comments = esc_html__('No Comments','melokids');
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments. ' ' . esc_html__('Comments', 'melokids');
		} else {
			$comments = esc_html__('1 Comment','melokids');
		}
		$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
		echo wp_kses_post($args['before'].$args['icon'].$write_comments.$args['after']);
	}
}

/**
 * MeloKids Meta Share
 * Use Share this
 * source : https://www.sharethis.com/support/customization/how-to-set-custom-buttons/
*/
if(!function_exists('melokids_meta_share')){
    function melokids_meta_share($args = []){
        if(!class_exists('EF4Framework')) return;
        $args = wp_parse_args($args,[
            'before'     => '',
            'after'      => '',
            'show_title' => true,
            'title'      => esc_html__('Share this','melokids'),   
            'icon'       => '<span class="meta-icon fa fa-share-alt"></span>',
            'icon_pos'   => 'before'
        ]);
        global $post;
        $url = get_the_permalink();
        $image = get_the_post_thumbnail_url($post->ID);
        $title = get_the_title();
        wp_enqueue_script('sharethis');
        echo wp_kses_post($args['before']);
    ?><a href="javascript:void(0);" 
            title="<?php echo esc_attr($args['title']); ?>" 
            data-toggle="tooltip" 
            data-network="sharethis" 
            data-url="<?php echo esc_url($url);?>" 
            data-short-url="<?php echo esc_url($url);?>" 
            data-title="<?php echo esc_attr($title);?>" 
            data-image="<?php echo esc_url($image); ?>" 
            data-description="<?php echo get_the_excerpt(); ?>" 
            data-username="" 
            data-message="<?php echo bloginfo(); ?>" 
            class="st-custom-button hint--bounce hint--top" data-hint="<?php echo esc_attr($args['title']);?>"><?php 
                if($args['icon_pos'] === 'before') echo wp_kses_post($args['icon']);
                if($args['show_title']) echo '<span class="title">'.$args['title'].'</span>';
                if($args['icon_pos'] === 'after') echo wp_kses_post($args['icon']);
            ?></a><?php
        echo wp_kses_post($args['after']);
    }
}

/**
 * MeloKids Loop Excerpt
*/
if(!function_exists('melokids_entry_excerpt')){
	function melokids_entry_excerpt($args = []){
		$args = wp_parse_args($args, [
            'length'    => melokids_get_opts('loop_excerpt_length', 55),
            'class'     => '',
            'post'      => '',
            'show_more' => true
		]);
		$post = get_post($args['post']);
	    if (empty($post) || 0 >= $args['length']) {
	        return '';
	    }

	    if (post_password_required($post)) {
	        return esc_html__('There is no excerpt because this is a protected post.', 'melokids');
	    }
	   
        $content = get_the_excerpt();

	    if($args['show_more'])
            $excerpt_more = apply_filters('melokids_excerpt_more', '&nbsp;&hellip;');
        else 
            $excerpt_more = '';

	    $excerpt = wp_trim_words($content, $args['length'], $excerpt_more);

	    /* css class */
	    $classes = ['entry-excerpt', $args['class']];
	?>
		<div class="<?php echo trim(implode(' ', $classes));?>"><?php 
			echo esc_html($excerpt); 
		?></div>
	<?php
	}
}

/**
 * MeloKids Loop Tags
*/
if(!function_exists('melokids_entry_tag')){
    $tags = get_the_tag_list();
	function melokids_entry_tag($args = []){
		$args = wp_parse_args($args, [
            'show_tag'  => is_singular() ? melokids_get_opts('single_tags', '1') : melokids_get_opts('loop_tags', '0'),
            'before'    => '',
            'separator' => ', ',
            'after'     => '',
            'icon'      => '<span class="fa fa-tags fa-rotate-90"></span>&nbsp;&nbsp;',
            'class'     => ''
		]);
		$tag  = melokids_get_taxonimies('tag');
		if(!has_term('',$tag) || !$args['show_tag']) return; 

		/* css class */
		$classes = ['entry-tags', $args['class']];

	?><div class="<?php echo trim(implode(' ', $classes));?>"><?php
		the_terms( get_the_ID(), $tag , $args['before'].$args['icon'], $args['separator'], $args['after'] );
	?></div><?php
	}
}

/**
 * MeloKids Share
*/
if(!function_exists('melokids_entry_share')){
    function melokids_entry_share($args = []){
        $args = wp_parse_args($args, [
            'show_share' => is_singular() ? melokids_get_opts('single_share', '0') : melokids_get_opts('loop_share', '0'),
            'before'     => '',
            'after'      => '',
            'share_icon' => '<span class="fa fa-share-alt circle-outline"></span>',
            'class'      => '',
            'title'      => esc_html__('Share this post','melokids'),  
        ]);
        $classes =['entry-share', $args['class']];
        if($args['show_share'] === '1') { 
        ?><div class="<?php echo trim(implode(' ', $classes));?>"><?php 
            melokids_meta_share(['before' => $args['before'],'after' => $args['before'], 'title' => $args['title'], 'icon' => $args['share_icon'], 'icon_pos' => 'after' ]);
        ?></div><?php
        }
    }
}

/**
 * MeloKids Loop Read More Button 
*/
if(!function_exists('melokids_entry_readmore')){
	function melokids_entry_readmore($args = [] ){
		$args = wp_parse_args($args, [
			'show_readmore' => melokids_get_opts('loop_readmore','true'),
			'class'         => '',
			'title'         => esc_html__('Read More','melokids'),
			'rm_class'      => '',
            'icon_before'   => '',
            'icon_after'    => '<span class="rm-icon fa fa-caret-'.melokids_align2().'"></span>'
		]);
		if(!$args['show_readmore']) return; 
		/* css class */
		$classes = ['entry-readmore', $args['class']];
		/* link class */
		$rm_class = ['entry-link', $args['rm_class']];

	?><div class="<?php echo trim(implode(' ', $classes));?>"><a class="<?php echo trim(implode(' ', $rm_class));?>" href="<?php the_permalink();?>"><?php echo esc_html($args['title']).' '.wp_kses_post($args['icon_after'])?></a></div><?php	
	}
}

/**
 * MeloKids Media
*/
if(!function_exists('melokids_entry_media')){
	function melokids_entry_media($args = []){
		$args = wp_parse_args($args, [
            'class'           => '',
            'size'            => is_singular() ? 'post-thumbnail' : 'large',
            'img_class'       => '',
		]);
		/* post format */
		$post_format = !empty(get_post_format()) ? get_post_format() : 'standard';
		$thumbnail = has_post_thumbnail();
		/* css class */
		$classes = ['entry-media','entry-'.$post_format, $args['class']];
	?><div class="<?php echo trim(implode(' ', $classes));?>"><?php 
		do_action('melokids_entry_media_start');
		switch ($post_format) {
			case 'video':
				melokids_entry_video(['size' => $args['size'], 'img_class' => $args['img_class']]);
				break;
			case 'audio':
				melokids_entry_audio(['size' => $args['size'], 'img_class' => $args['img_class']]);
				break;
			case 'gallery':
				melokids_entry_gallery(['size' => $args['size'], 'img_class' => $args['img_class']]);
				break;
			case 'quote':
				melokids_entry_quote(['size' => $args['size'], 'img_class' => $args['img_class']]);
				break;
			case 'link':
				melokids_entry_link(['size' => $args['size'], 'img_class' => $args['img_class']]);
				break;
			default:
				melokids_post_thumbnail(['size' => $args['size'], 'img_class' => $args['img_class']]);
				break;
		}
		do_action('melokids_entry_media_end');
	?></div><?php 
	}
}

if(!function_exists('melokids_single_post_class')){
    add_filter('post_class','melokids_single_post_class');
    function melokids_single_post_class($classes){
        if(is_singular('post')) {
            $classes[] = 'entry-single';
            $gallery_layout       = melokids_format_opts('gallery_layout','slide');
            switch ($gallery_layout) {
                case 'grid':
                    $classes[] = '';
                    break;
                case 'masonry':
                    $classes[] = '';
                    break;
                default:
                    $classes[] = 'hoverdir-wrap hoverdir-swing';
                    break;
            }
        }
        return $classes;
    }
}

/*
 * Add media overlay content 
*/
if(!function_exists('melokids_media_overlay_content')){
    add_action('melokids_entry_media_end', 'melokids_media_overlay_content');
    function melokids_media_overlay_content(){
    ?>
        <div class="overlay">
            <div class="overlay-inner">
                <?php do_action('melokids_media_overlay_content'); ?>
            </div>
        </div>
    <?php
    }
}

if(!function_exists('melokids_loop_overlay_link')){
    add_action('melokids_media_overlay_content','melokids_loop_overlay_link');
    function melokids_loop_overlay_link(){
        if(!is_singular()) {
        ?>
            <a href="<?php the_permalink();?>"><span class="open-popup transition fa fa-search"></span></a>
        <?php } else {
            switch (get_post_format()) {
                case 'gallery':
                    $gallery_layout       = melokids_format_opts('gallery_layout','slide');
                    $gallery_ids          = melokids_format_opts('gallery_ids','');
                    $array_id = explode(',', $gallery_ids);
                    if($gallery_layout === 'slide' && !empty($array_id[0])){
                        $full_image = wp_get_attachment_image_src($array_id[0], 'full', false);
                        $image_id = $array_id[0];
                        $attachment_meta        = wp_prepare_attachment_for_js($image_id);
                        $attachment_url         = $attachment_meta['url'];
                        $attachment_title       = !empty($attachment_meta['title']) ? $attachment_meta['title'] : $attachment_meta['name'];
                        $attachment_caption     = !empty($attachment_meta['caption']) ? $attachment_meta['caption'] : '';
                        $attachment_alt         = !empty($attachment_meta['alt']) ? $attachment_meta['alt'] : '';
                        $attachment_description = !empty($attachment_meta['description']) ? $attachment_meta['description'] : '';
                    
                    ?>
                        <a class="prettyphoto" href="<?php echo esc_url($full_image[0]);?>" title="<?php echo esc_attr($attachment_title); ?>"><span class="open-popup transition fa fa-search"></span></a>
                    <?php
                    }
                    break;
                default:
        ?>
            <a class="prettyphoto" href="<?php the_post_thumbnail_url();?>"><span class="open-popup transition fa fa-search"></span></a>
        <?php
                break;
            }
        }
    }
}

/**
 * MeloKids Single Content 
*/
if(!function_exists('melokids_entry_content')){
	function melokids_entry_content($args = []){
		$args = wp_parse_args($args, [
			'class'	   => ''
		]);
		$classes = ['entry-content'];
        if(!empty($args['class'])) $classes[] = $args['class'];
        $classes[] = 'clearfix';
		?><div class="<?php echo trim(implode(' ', $classes));?>"><?php the_content(); ?></div><?php
	}
}

/**
 * Display single post Author.
 * @since 1.0.0
 * @author Chinh Duong Manh
 */
if(!function_exists('melokids_author_info')){
    function melokids_author_info(){
        $single_author_info = melokids_get_opts('single_author_info', false);
        if( '1' !== $single_author_info || empty(get_the_author_meta('description'))) return;
        $user_info = get_userdata(get_the_author_meta('ID'));
    ?>    
        <div class="entry-author row">
            <div class="author-avatar col-md-auto text-center">
                <?php 
                    echo get_avatar(get_the_author_meta('ID'), 90, '', get_the_author(), ['class' => 'circle']);
                    melokids_user_social();
                ?>
            </div>
            <div class="author-info col text-sm-center text-md-<?php melokids_align(true);?>">
                <div class="author-header">
                    <h5 class="author-name"><?php the_author(); ?></h5>
                </div>
                <div class="author-bio"><?php the_author_meta('description'); ?></div>
            </div>
        </div>
    <?php
    }
}

/**
 * Get Custom User Meta 
 * user meta added from EF4 Framework
*/
/* get custom user social */
if(!function_exists('melokids_user_social')){
    function melokids_user_social($args = []){
        if(!function_exists('ef4_user_info')) return;

        $args = wp_parse_args($args, [
            'author_id' => '', 
            'return'    => false, 
            'class'     => 'author-social'
        ]);
        global $post;
        if(empty($args['author_id'])) $args['author_id'] = $post->post_author;
        $extend_social = ef4_user_info($args['author_id'], 'extend_social');

        $social_icon = '<div class="'.esc_attr($args['class']).'">';
            foreach ($extend_social as $social) {
                if(!empty($social)){
                    $remove = array('fa fa-','ion-', 'icon-', 'social-', 'ti-', 'slip-');
                    $class3 = str_replace($remove, '', $social['icon']);
                    $social_icon .= '<a title="'.str_replace('-', ' ', $class3).'" target="_blank" href="' . esc_url( $social['url'] ) . '" class="'.str_replace('-', ' ', $class3).'"><i class="'.esc_attr($social['icon']).'"></i></a>';
                }
            }
        $social_icon .='</div>';
        if($args['return'])
           return $social_icon;
        else 
            echo wp_kses_post($social_icon);
    }
}

/**
 * Display single post related
 * 
 * @author Chinh Duong Manh
 * @since 1.0.0
 */
if(!function_exists('melokids_post_related')){
    function melokids_post_related($args = []){
        //for use in the loop, list 2 posts related to first tag on current post
        $single_related = melokids_get_opts('single_related', false);
        if('1' !== $single_related) return;
        global $post;
        $args = wp_parse_args($args, [
            'title'          => esc_html__('Related Articles','melokids'),
            'term'           => 'tag',
        ]);
        if(class_exists('VC_Manager')){
            $args['posts_per_page'] = '9';
            $args['layout'] = 'carousel';
            $args['class'] = 'zk-carousel owl-carousel';
            /* OWL Settings */
            wp_enqueue_script('vc_pageable_owl-carousel');
            wp_enqueue_script('zk-owlcarousel');
            wp_enqueue_style('vc_pageable_owl-carousel-css');
            $rtl = is_rtl() ? true : false;
            $el_id = 'zk-single-post-related';
            global $zkcarousel;
            $zkcarousel[$el_id] = array(
                'rtl'                => $rtl,
                'margin'             => 40,
                'loop'               => true,
                'startPosition'      => 1,
                'nav'                => false,
                'dots'               => true,
                'autoplay'           => false,
                'responsiveClass'    => true,
                'slideBy'            => 'page',
                'responsive'         => array(
                    0    => array(
                        'items' => 1,
                    ),
                    768  => array(
                        'items' => 2,
                    ),
                    992  => array(
                        'items' => 3,
                    ),
                    1200 => array(
                        'items' => 3,
                    )
                )
            );
            wp_localize_script('vc_pageable_owl-carousel', 'zkcarousel', $zkcarousel);
            
        } else {
            $args['posts_per_page'] = '3';
            $args['layout'] = 'grid';
            $args['class'] = 'zk-grid row';
        }
        $term = melokids_get_taxonimies($args['term']);
        $tags = get_the_terms($post->ID,$term);
        if(!$tags) return;

        $_tag = array();
        foreach ($tags as $tag) {
            $_tag[] = $tag->slug;
        }        
        $related_query = array(
            'post_type' => get_post_type(),
            'tax_query' => array(
                array(
                    'taxonomy' => $term,
                    'field'    => 'slug',
                    'terms'    => $_tag,
                ),
            ),
            'post__not_in'          => array($post->ID),
            'posts_per_page'        => $args['posts_per_page'],
            'ignore_sticky_posts'   => 1
        );

        $related_post = new WP_Query($related_query);
        if( $related_post->have_posts() ) {
            echo '<div class="entry-related text-center">';
            echo '<h3 class="related-title">'.esc_html($args['title']).'</h3>';
            echo '<div id="zk-single-post-related" class="'.esc_attr($args['class']).'">';
            while ($related_post->have_posts()) : $related_post->the_post(); 
                get_template_part( 'template-parts/loop/related', get_post_format() );
            endwhile;
            echo '</div></div>';
        }
        wp_reset_postdata();
    }
}

/**
* Display navigation to next/previous on single post/page
*
* @since 1.0.0
*/
if(!function_exists('melokids_single_post_nav')){
    function melokids_single_post_nav() {
        $single_nav = melokids_get_opts('single_nav', '1');
        if('1' !== $single_nav) return;
        melokids_custom_single_post_nav();
    }
}
/* Custom post navigation */
if(!function_exists('melokids_custom_single_post_nav')){
    function melokids_custom_single_post_nav($args = []){
        $args = wp_parse_args($args, [
            'layout' => ''
        ]);
        $prevthumbnail = $nextthumbnail = '';
        $prevPost = get_previous_post(true);
        if($prevPost) $prevthumbnail = get_the_post_thumbnail($prevPost->ID);
        $nextPost = get_next_post(true);
        if($nextPost) $nextthumbnail = get_the_post_thumbnail($nextPost->ID);
        if(!$prevPost && !$nextPost) return;
    ?>
        <nav class="single-post-navigation">
            <div class="row">
                <?php switch ($args['layout']) {
                    case '2':
                    ?>
                        <div class="nav-box previous col-md-6 text-<?php melokids_align(true);?>">
                            <?php if($prevPost) { 
                                if(!empty($prevthumbnail)) { ?>
                                    <div class="overlay-wrap">
                                        <?php previous_post_link('%link', "$prevthumbnail".'<div class="post-nav-label"><span class="post-nav-label-inner">'.esc_html__('Prev Post','melokids').'</span></div>', TRUE); ?>
                                        <a href="<?php echo get_the_permalink($prevPost->ID);?>"  class="overlay animated zoomOut" data-item-animation-in="zoomIn" data-item-animation-out="zoomOut">
                                            <div class="overlay-inner vertical-align">
                                                <h4><?php echo get_the_title($prevPost->ID); ?></h4>
                                                <div><?php echo get_the_date(get_option('date_format'), $prevPost->ID); ?></div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <h6><?php esc_html_e('Prev Post','melokids'); ?></h6>
                                    <h3><a href="<?php echo get_the_permalink($prevPost->ID);?>"><?php echo get_the_title($prevPost->ID); ?></a></h3>
                                    <div><?php echo get_the_date(get_option('date_format'), $prevPost->ID); ?></div>
                                <?php } 
                            } ?>
                        </div>
                        
                        <div class="nav-box next col-md-6 text-<?php melokids_align2(true);?>">
                            <?php if($nextPost) {
                            if(!empty($nextthumbnail)) { ?>
                                <div class="overlay-wrap">
                                    <?php next_post_link('%link',"$nextthumbnail".'<div class="post-nav-label"><span class="post-nav-label-inner">'.esc_html__('Next Post','melokids').'</span></div>', TRUE); ?>
                                    <a href="<?php echo get_the_permalink($nextPost->ID);?>" class="overlay animated zoomOut" data-item-animation-in="zoomIn" data-item-animation-out="zoomOut">
                                        <div class="overlay-inner vertical-align">
                                            <h4><?php echo get_the_title($nextPost->ID); ?></h4>
                                            <div><?php echo get_the_date(get_option('date_format'), $nextPost->ID); ?></div>
                                        </div>
                                    </a>
                                </div>
                            <?php } else { ?>
                                <h6><?php esc_html_e('Next Post','melokids'); ?></h6>
                                <h3><a href="<?php echo get_the_permalink($nextPost->ID);?>"><?php echo get_the_title($nextPost->ID); ?></a></h3>
                                <div><?php echo get_the_date(get_option('date_format'), $nextPost->ID); ?></div>
                            <?php }
                            } ?>
                        </div>
                    <?php
                        break;
                    default:
                    ?>
                       <div class="nav-box previous col-md-6 text-<?php melokids_align(true);?>">
                            <?php if($prevPost) { ?>
                                <a href="<?php echo get_the_permalink($prevPost->ID);?>">
                                <div class="row align-items-center">
                                    <?php if(!empty($prevthumbnail)) echo '<div class="col-sm-2 col-md-auto nav-image">'.get_the_post_thumbnail($prevPost->ID,'thumbnail').'</div>'; ?>
                                    <div class="col-sm-10 col-md-auto nav-text">
                                        <div><?php esc_html_e('Prev Post','melokids'); ?></div>
                                        <h4><?php echo get_the_title($prevPost->ID); ?></h4>
                                    </div>
                                </div>
                                </a>
                            <?php } ?>
                       </div>
                       <div class="nav-box next col-md-6 text-<?php melokids_align2(true);?>">
                            <?php if($nextPost) { ?>
                                <a href="<?php echo get_the_permalink($nextPost->ID);?>">
                                <div class="row align-items-center justify-content-end">
                                    <div class="col-sm-10 col-md-auto nav-text">
                                        <div><?php esc_html_e('Next Post','melokids'); ?></div>
                                        <h4><?php echo get_the_title($nextPost->ID); ?></h4>
                                    </div>
                                    <?php if(!empty($nextthumbnail)) echo '<div class="col-sm-2 col-md-auto nav-image">'.get_the_post_thumbnail($nextPost->ID,'thumbnail').'</div>'; ?>
                                </div>
                                </a>
                            <?php } ?>
                       </div> 
                    <?php
                        break;
                } ?>
            </div>
        </nav>
    <?php
    }
}

/**
 * Display single post Comment Template
 * 
 * @author Chinh Duong Manh
 * @since 1.0.0
*/
if(!function_exists('melokids_comment')){
    function melokids_comment(){
        $show_comment = melokids_get_opts('single_comment_list_form', '1');
        if( $show_comment === '1' && ( comments_open() || get_comments_number() ) )
            comments_template();
    }
}

/**
 * Display single post Comment Respond Template
 * 
 * @author Chinh Duong Manh
 * @since 1.0.0
*/
if(!function_exists('melokids_comment_respond')){
    function melokids_comment_respond($args = []){
        $args = wp_parse_args($args, []);
        $show_comment = melokids_get_opts('single_comment_list_form', '1');
        if( $show_comment && ( comments_open() ) ) {   
        ?><div class="single-cmt-respond"><?php
            comment_form($args); 
        ?></div><?php
        }
    }
}
/**
 * Comment Form
 * Move comment field to above comment text
*/
add_filter( 'comment_form_fields', 'melokids_comment_form_fields');
if(!function_exists('melokids_comment_form_fields')){
    function melokids_comment_form_fields( $fields ) {

        //author, email, url 
        $fields_first = ['rating','open','author','email','url','close'];
        $fields_resort = [];
        foreach ($fields_first as $key) {
            if(array_key_exists($key,$fields))
                $fields_resort[$key] = $fields[$key];
        }
        foreach ($fields as $key => $value) {
            if(in_array($key,$fields_first))
                continue;
            $fields_resort[$key] = $value;
        }
        return $fields_resort;
    }
}

/**
 * Remove re-Captcha when user logged in
 * plugin: Google Captcha (reCAPTCHA) by BestWebSoft
 * https://wordpress.org/plugins/google-captcha/
 *
*/
if(function_exists('gglcptch_commentform_display')){
    add_action ('init', 'melokids_remove_default_gglcptch_commentform_display');
    function melokids_remove_default_gglcptch_commentform_display(){
        remove_action( 'comment_form_after_fields', 'gglcptch_commentform_display');
        remove_action( 'comment_form_logged_in_after', 'gglcptch_commentform_display');
    }
    
    function melokids_comment_submit_button($submit_button){
        $submit_button .=  gglcptch_commentform_display();
        return $submit_button;
    }
    add_filter('comment_form_submit_button', 'melokids_comment_submit_button', 10, 1);
}


/**
 * Comment Form
 * Modify Comment Field
*/
add_filter('comment_form_defaults','melokids_comment_form_defaults');
if(!function_exists('melokids_comment_form_defaults')){
    function melokids_comment_form_defaults($defaults){
        $defaults['comment_field'] = '<div class="cmt-fields-text"><textarea placeholder="'.esc_attr__( 'Your Comment', 'melokids' ).'" id="comment" name="comment" maxlength="65525" aria-required="true" required="required"></textarea></div>';

        return $defaults;
    }
}
/**
 * Comment Form
 * Modidy Comment Fields
*/
add_filter('comment_form_default_fields','melokids_comment_form_default_fields');
if(!function_exists('melokids_comment_form_default_fields')){
    function melokids_comment_form_default_fields($fields){
        $commenter     = wp_get_current_commenter();
        $user          = wp_get_current_user();
        $user_identity = $user->exists() ? $user->display_name : '';

        $req      = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $html_req = ( $req ? " required='required'" : '' );

        $name_placeholder = $req ? esc_html__('Your Name *','melokids') : esc_html__('Name','melokids');
        $mail_placeholder = $req ? esc_html__('Your Email *','melokids') : esc_html__('Email','melokids');

        $col_open  = '<div class="comment-field col-12 col-lg-4">';
        $col_close = '</div>';

        $fields = array(
            'open'   => '<div class="row cmt-fields">',
            'author' => $col_open.'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
            '" placeholder ="'.esc_attr($name_placeholder).'" ' . $aria_req . ' />'.$col_close,
            'email'  => $col_open.'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
            '" placeholder ="'.esc_attr($mail_placeholder).'" ' . $aria_req . ' />'.$col_close,
            'url'    => $col_open.'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
            '" placeholder="'.esc_attr__('Your website','melokids').'"/>'.$col_close,
            'close'  => '</div>',
            'empty' => ''
        );

        return $fields;
    }
}
/**
 * Comment Template
*/
if(!function_exists('melokids_comment_template')){
    function melokids_comment_template($comment, $args, $depth){
    ?>
        <<?php echo esc_attr($args['style']); ?> <?php comment_class( $args['has_children'] ? 'parent' : '', $comment ); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment_container">
                <div class="comment-avatar col-auto"><?php 
                    if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, 90, '', '', ['class' => 'circle'] ); 
                ?></div>
                <div class="comment-text">
                    <h5 class="comment-name"><?php printf( '%s', get_comment_author_link( $comment )); ?></h5>
                    <div class="comment-content">
                        <?php comment_text(); ?>
                    </div>
                    <div class="comment-actions">
                        <time datetime="<?php comment_time( 'c' ); ?>">
                            <?php
                                /* translators: 1: comment date, 2: comment time */
                                printf( esc_html__( '%1$s at %2$s' , 'melokids'), get_comment_date( '', $comment ), get_comment_time() );
                            ?>
                        </time>                            
                        <?php 
                            comment_reply_link( array_merge( $args, array(
                                'add_below' => 'div-comment',
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth'],
                                'before'    => '<span class="reply-link">',
                                'after'     => '</span>'
                            ) ) );
                            edit_comment_link( esc_html__( 'Edit', 'melokids' ), '<span class="edit-link">', '</span>' ); 
                        ?>
                    </div>
                    <?php if ( '0' == $comment->comment_approved ) : ?>
                    <div class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'melokids' ); ?></div>
                    <?php endif; ?>
                    
                </div>
            </article>
    <?php
    }
}