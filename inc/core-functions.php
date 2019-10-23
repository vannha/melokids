<?php
/**
 * Language direction 
 * @since 1.0.0
 * @author Chinh Duong Manh
*/
function melokids_direction($echo = false){
    $direction = is_rtl() ? 'dir-right' : 'dir-left';
    if($echo)
        echo esc_attr($direction);
    else
        return $direction;
}
/* get text-align left / right for RTL language */
function melokids_align($echo = false){
    $align = is_rtl() ? 'right' : 'left';
    if($echo)
        echo esc_attr($align);
    else
        return $align;
}
function melokids_align2($echo = false){
    $align = is_rtl() ? 'left' : 'right';
    if($echo)
        echo esc_attr($align);
    else
        return $align;
}

/* Page Loading */
add_action('melokids_before_main_content','melokids_page_loading');
function melokids_page_loading(){
    $page_loading = melokids_get_opts('page_loading', '0');
    $page_loading_style = melokids_get_opts('page_loading_style','fading-circle');
    if($page_loading === '1'){
        echo '<div id="zk-loading">';
            switch ($page_loading_style) {
                case 'flip-box':
                    melokids_spin_flip_box();
                    break;
                case 'double-bounce':
                    melokids_spin_double_bounce();
                    break;
                case 'wave':
                    melokids_spin_wave();
                    break;
                case 'double-cube':
                    melokids_spin_double_cube();
                    break;
                case 'scaleout':
                    melokids_spin_scaleout();
                    break;
                case 'double-dots':
                    melokids_spin_double_dots();
                    break;
                case 'three-dot-bounce':
                    melokids_spin_three_dot_bounce();
                    break;
                case 'circle-loading':
                    melokids_spin_circle_loading();
                    break;
                case 'cube-grid':
                    melokids_spin_cube_grid();
                    break;
                case 'fading-circle':
                    melokids_spin_fading_circle();
                    break;
                case 'folding-cube':
                    melokids_spin_folding_cube();
                    break;
                default:
                    melokids_spin_fading_circle();
                    break;
            }
        echo '</div>';
    }  
}
function melokids_spin_flip_box(){
    ?>
        <div class="spinner rotateplane"></div>
    <?php
}
function melokids_spin_double_bounce(){
    ?>
        <div class="spinner double-bounce">
          <div class="double-bounce1"></div>
          <div class="double-bounce2"></div>
        </div>
    <?php
}
function melokids_spin_wave(){
    ?>
        <div class="spinner wave">
          <div class="rect1"></div>
          <div class="rect2"></div>
          <div class="rect3"></div>
          <div class="rect4"></div>
          <div class="rect5"></div>
        </div>
    <?php
}
function melokids_spin_double_cube(){
    ?>
        <div class="spinner">
          <div class="cube1"></div>
          <div class="cube2"></div>
        </div>
    <?php
}
function melokids_spin_scaleout(){
    ?>
        <div class="spinner scaleout"></div>
    <?php
}
function melokids_spin_double_dots(){
    ?>
        <div class="spinner double-dots">
          <div class="dot1"></div>
          <div class="dot2"></div>
        </div>
    <?php
}
function melokids_spin_three_dot_bounce(){
    ?>
        <div class="spinner three-circle-bounce">
          <div class="bounce1"></div>
          <div class="bounce2"></div>
          <div class="bounce3"></div>
        </div>
    <?php
}
function melokids_spin_circle_loading(){
    ?>
        <div class="spinner sk-circle">
          <div class="sk-circle1 sk-child"></div>
          <div class="sk-circle2 sk-child"></div>
          <div class="sk-circle3 sk-child"></div>
          <div class="sk-circle4 sk-child"></div>
          <div class="sk-circle5 sk-child"></div>
          <div class="sk-circle6 sk-child"></div>
          <div class="sk-circle7 sk-child"></div>
          <div class="sk-circle8 sk-child"></div>
          <div class="sk-circle9 sk-child"></div>
          <div class="sk-circle10 sk-child"></div>
          <div class="sk-circle11 sk-child"></div>
          <div class="sk-circle12 sk-child"></div>
        </div>
    <?php
}
function melokids_spin_cube_grid(){
    ?>
        <div class="spinner sk-cube-grid">
          <div class="sk-cube sk-cube1"></div>
          <div class="sk-cube sk-cube2"></div>
          <div class="sk-cube sk-cube3"></div>
          <div class="sk-cube sk-cube4"></div>
          <div class="sk-cube sk-cube5"></div>
          <div class="sk-cube sk-cube6"></div>
          <div class="sk-cube sk-cube7"></div>
          <div class="sk-cube sk-cube8"></div>
          <div class="sk-cube sk-cube9"></div>
        </div>
    <?php
}
function melokids_spin_fading_circle(){
    ?>
        <div class="spinner sk-fading-circle">
          <div class="sk-circle1 sk-circle"></div>
          <div class="sk-circle2 sk-circle"></div>
          <div class="sk-circle3 sk-circle"></div>
          <div class="sk-circle4 sk-circle"></div>
          <div class="sk-circle5 sk-circle"></div>
          <div class="sk-circle6 sk-circle"></div>
          <div class="sk-circle7 sk-circle"></div>
          <div class="sk-circle8 sk-circle"></div>
          <div class="sk-circle9 sk-circle"></div>
          <div class="sk-circle10 sk-circle"></div>
          <div class="sk-circle11 sk-circle"></div>
          <div class="sk-circle12 sk-circle"></div>
        </div>
    <?php
}
function melokids_spin_folding_cube(){
    ?>
        <div class="spinner sk-folding-cube">
          <div class="sk-cube1 sk-cube"></div>
          <div class="sk-cube2 sk-cube"></div>
          <div class="sk-cube4 sk-cube"></div>
          <div class="sk-cube3 sk-cube"></div>
        </div>
    <?php
}

/* Back to top */
add_action('wp_footer','melokids_backtotop');
function melokids_backtotop(){
    $backtotop = melokids_get_opts('backtotop','0');
    if($backtotop === '1') echo '<div class="zk-backtotop"><a href="#zk-page" class="zk-scroll"><span></span><span></span><span></span></a></div>';
}
/**
 * Get Page List
 * Used in theme options
 * @author Chinh Duong Manh
 * @since 1.0.0
*/
function melokids_list_page(){
    $page_list = array();
    $pages = get_pages(array('hierarchical' => 0));
    foreach($pages as $page){
        $page_list[$page->post_name] = $page->post_title;
    }
    return $page_list;
}

/**
 * Get Post List 
 * Used in theme otpion
 * @author Chinh Duong Manh
 * @since 1.0.0
*/
function melokids_list_post($post_type = 'post', $default = false){
    $post_list = array();
    
    if($default){
        $post_list['-1'] = esc_html__('Default','melokids');
        $post_list[''] = esc_html__('None','melokids');
    }
    $posts = get_posts(array('post_type' => $post_type,'posts_per_page' => '-1'));
    foreach($posts as $post){
        $post_list[$post->post_name] = $post->post_title;
    }
    return $post_list;
}

/*
 * get page ID by Slug
*/
function melokids_get_id_by_slug($slug, $post_type){
    $content = get_page_by_path($slug, OBJECT, $post_type);
    $id = $content->ID;
    return $id;
}
/** 
 * Get Page ID from page Slug
 * melokids_get_page_by_slug('any-page-slug');
*/
function melokids_get_page_by_slug($page_slug, $post_type = 'page'){
    $query = new WP_Query( array( 'name' => $page_slug ,'post_type'=> $post_type) );
    $page_id = 0;
    if($query->have_posts())
        $page_id = $query->posts[0]->ID;
    return $page_id;
}
/**
 * get content by slug
**/
function melokids_get_content_by_slug($slug, $post_type){
    $content = get_posts(
        array(
            'name'      => $slug,
            'post_type' => $post_type
        )
    );
    if(!empty($content))
        return $content[0]->post_content;
    else 
        return sprintf(esc_html__('Please %sClick Here%s to add post type called %s first. And make sure you have post with SLUG called: %s', 'melokids'), '<a href="' . esc_url( admin_url( 'edit.php?post_type='.$post_type.'' ) ) . '" target="_blank">', '</a>', $post_type, $slug);
}
/**
 * Show content by slug
**/
if(!function_exists('melokids_content_by_slug')) {
    function melokids_content_by_slug($slug, $post_type){
        $content = melokids_get_content_by_slug($slug, $post_type);
        $id = melokids_get_id_by_slug($slug, $post_type);
        $shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
        
        if ( ! empty( $shortcodes_custom_css ) ) {
            $shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
            echo '<style type="text/css" data-type="vc_shortcodes-custom">';
                echo esc_html($shortcodes_custom_css);
            echo '</style>';
        }
        echo apply_filters('the_content', $content);
    }
}

/**
 * Get theme option / meta option
 *
*/
if(!function_exists('melokids_get_opts')){
    function melokids_get_opts($option = '', $default = '', $args = ''){
        global $theme_options, $meta_options;
        $value = ( isset($theme_options[$option]) && !empty($theme_options[$option]) )? $theme_options[$option] : $default;
        if(is_singular() && isset($meta_options[$option]) && $meta_options[$option] !== '-1')
            $value = $meta_options[$option];
        if(is_array($value) && !empty($value) && !empty($args) )
            $result = ( isset($value[$args]) && !empty($value[$args]) ) ? $value[$args] :  $default;
        else 
            $result = $value;
        return $result;
    }
}

/**
 * Get post format options
*/
if(!function_exists('melokids_format_opts')){
    function melokids_format_opts($option = '', $default = ''){
        global $meta_options;
        $value = isset($meta_options[$option]) && ('' != $meta_options[$option]) ? $meta_options[$option] : $default;
        return $value;
    }
}

/**
 * Add extra class to body
*/
add_filter('body_class','melokids_body_class');
if(!function_exists('melokids_body_class')){
    function melokids_body_class($classes){
        $classes[] = wp_get_theme()->get('TextDomain');
        $classes[] = 'zk-body';
        /* add boxed class */
        $boxed = melokids_get_opts('body_layout', '0');
        if($boxed === '1') $classes[] = 'zk-boxed';
        /* add header layout class */
        $header_layout = melokids_get_opts('header_layout','3');
        $classes[] = 'body-header-'.$header_layout;
        if(is_singular('page'))
            $classes[] = 'single-page';
        // single post with comment
        if((is_single() || is_singular('page')) && comments_open())
            $classes[] = 'comment-open';
        /* return */
        return $classes;
    }
}
/**
 * Add body attributes
*/
if(!function_exists('melokids_body_atts')){
    function melokids_body_atts(){
        $atts = [];
        $header_layout        = melokids_get_opts('header_layout','3');
        $header_width = melokids_get_opts('header_width','320px');
        /* CSS */
        $styles = [];
        //if('4' === $header_layout) $styles[] = 'margin-'.melokids_align().':'.$header_width['width'];

        if(!empty($styles))  $atts[] = 'style="'.trim(implode(';', $styles)).'"';

        /* Print attributes */
        echo trim(implode(' ', $atts));
    }
}
/**
 * Page Attributes
 *
*/
if(!function_exists('melokids_page_atts')){
    function melokids_page_atts($args=[]){
        $args = wp_parse_args($args, array(
            'class' => ''
        ));
        extract($args);
        $atts = [];
        /* ID */
        $atts[] = 'id="zk-page"';
        /* Class */
        $classes = ['zk-page'];
        /* add header layout class */
        $header_layout = melokids_get_opts('header_layout','3');
        $classes[] = 'header-'.$header_layout;

        $atts[] = 'class="'.trim(implode(' ', $classes)).'"';

        /* CSS */
        $styles = [];
        if(!empty($styles))
            $atts[] = 'style="'.trim(implode(';', $styles)).'"';

        /* Print attributes */
        echo trim(implode(' ', $atts));
    }
}

/**
 * MeloKids Header 
*/
if(!function_exists('melokids_header')){
    function melokids_header($args = []){
        $args = wp_parse_args($args,[
            'class' => ''
        ]);
        $header_layout = melokids_get_opts('header_layout','3');
    ?>
    <div <?php melokids_header_html_atts(); ?>>
        <div class="<?php melokids_header_inner_class(); ?>">
            <?php get_template_part('template-parts/header/header', $header_layout); ?>
        </div>
    </div>
    <?php
    }
}
/**
 * Header HTML attributes
 * @since 1.0.0
 * @author Chinh Duong Manh
 */
if(!function_exists('melokids_header_html_atts')){
    function melokids_header_html_atts($args = []){
        $args = wp_parse_args($args,[
            'class' => ''
        ]);
        $atts = ['id="zk-header"'];
        $classes = [];
        /* Header Layout */
        $header_layout = melokids_get_opts('header_layout', '3');
        $header_custom = melokids_get_opts('header_custom', '-1');
        $header_custom_value = melokids_get_opts('header_custom_value', '');

        $classes[] = 'zk-header-'.$header_layout;

        if($header_custom !== '-1') $classes[] = 'zk-header-custom zk-header-custom-'.$header_custom_value;

        $header_ontop  = melokids_get_opts('header_ontop','0');
        $header_sticky = melokids_get_opts('header_sticky','0');
        
        if($header_ontop) 
            $classes[]  = 'header-ontop';
        else 
            $classes[]  = 'header-default';

        if($header_sticky) $classes[] = 'sticky-on';

        if(!$header_ontop && $header_sticky) $classes[] = 'header-only-sticky';
        if($header_ontop && $header_sticky) $classes[] = 'header-ontop-sticky';

        $classes[] = $args['class'];
        $atts[] = 'class="'.trim(implode(' ', $classes)).'"';

        /* Custom CSS */
        $styles = [];
        if('4' === $header_layout) $styles[] = melokids_align().':0';

        if(!empty($styles))
            $atts[] = 'style="'.trim(implode(';', $styles)).'"';

        echo trim(implode(' ', $atts));
    }
}
/**
 * Header Inner CSS Class
 * @since 1.0.0
 * @author Chinh Duong Manh
 */
if(!function_exists('melokids_header_inner_class')){
    function melokids_header_inner_class($class = ''){
        $classes = ['zk-header-inner'];
        $header_inner_width = melokids_get_opts('header_fullwidth','1');
        if('1' === $header_inner_width){
            $classes[] = 'container-fluid';
        } else {
            $classes[] = 'container';
        }
        $classes[] = $class;
        $classes[] = 'clearfix';
        echo trim(implode(' ',$classes));
    }
}


/**
 * Main Attributes
**/
if(!function_exists('melokids_main_atts')){
    function melokids_main_atts($args=[]){
        $args = wp_parse_args($args, array(
            'class' => ''
        ));
        extract($args);
        $atts = [];
        /* ID */
        $atts[] = 'id="zk-main"';
        /* Class */
        $classes = ['zk-main'];
        $mc_w = melokids_get_opts('mc_w', '0');
        $classes[] = ('1' === $mc_w) ? 'container-fluid' : 'container';
        $atts[] = 'class="'.trim(implode(' ', $classes)).'"';

        /* Print attributes */

        echo trim(implode(' ', $atts));
    }
}

/**====== PAGE TITLE ========*/
/**
 * Page Title 
 * @since 1.0.0
 * @author Chinh Duong Manh
 */
if(!function_exists('melokids_page_title')){
    function melokids_page_title(){
        $show_page_title   = melokids_get_opts('page_title', '1');
        if($show_page_title === '0') return;

        $page_title_layout = melokids_get_opts('page_title_layout', '1');
        $page_title_w      = melokids_get_opts('page_title_w', '0');
        $page_title_align  = melokids_get_opts('page_title_align', 'text-default');

        $page_title_class = array(
            'zk-page-title-wrapper',
            'layout-'.$page_title_layout,
            $page_title_align
        );
        $page_title_containter_class = array(
            'zk-page-title-inner'
        );
        $page_title_containter_class[] = $page_title_w ? 'container-fluid' : 'container';
        ?>
            <div id="zk-page-title-wrapper" class="<?php echo join(' ', $page_title_class);?>">
                <div class="zk-page-title-overlay"></div>
                <?php if($page_title_layout === '3') melokids_page_title_img(); ?>
                <div class="<?php echo join(' ', $page_title_containter_class); ?>">
                    <div class="row">
                    <?php switch ($page_title_layout){
                        case '1':
                            ?>
                            <div id="zk-page-title" class="col-md-12"><?php melokids_get_page_title(); ?></div>
                            <div class="space col-sm-12"></div>
                            <?php if(!is_front_page()) { ?>
                                <div id="zk-breadcrumb" class="col-md-12"><?php melokids_get_bread_crumb(); ?></div>
                            <?php
                                }
                            break;
                        case '2':
                            ?>
                            <?php if(!is_front_page()) { ?>
                            <div id="zk-breadcrumb" class="col-md-12"><?php melokids_get_bread_crumb(); ?></div>
                            <?php } ?>
                            <div class="space col-sm-12"></div>
                            <div id="zk-page-title" class="col-md-12"><?php melokids_get_page_title();  ?></div>
                            <?php
                            break;
                        case '3':
                            ?>
                            <div id="zk-page-title" class="col-lg-6"><?php melokids_get_page_title(); ?></div>
                            <div class="space col-sm-12"></div>
                            <?php if(!is_front_page()) { ?>
                                <div id="zk-breadcrumb" class="col-lg-6"><?php melokids_get_bread_crumb(); ?></div>
                            <?php
                                }
                            break;
                        case '4':
                            ?>
                            <?php if(!is_front_page()) { ?>
                            <div id="zk-breadcrumb" class="col-lg-6 offset-lg-6"><?php melokids_get_bread_crumb(); ?></div>
                            <?php } ?>
                            <div class="space col-sm-12"></div>
                            <div id="zk-page-title" class="col-lg-6 offset-lg-6"><?php melokids_get_page_title();  ?></div>
                            <?php
                            break;
                        case '5':
                            ?>
                            <div id="zk-page-title" class="col-lg-7"><?php melokids_get_page_title(); ?></div>
                            <?php if(!is_front_page()) { ?>
                            <div id="zk-breadcrumb" class="zk-breadcrumb col-lg-5 text-lg-right"><?php melokids_get_bread_crumb(); ?></div>
                            <?php
                                }
                            break;
                        case '6':
                            ?>
                            <?php if(!is_front_page()) { ?>
                            <div id="zk-breadcrumb" class="zk-breadcrumb col-lg-5"><?php melokids_get_bread_crumb(); ?></div>
                            <?php } ?>
                            <div id="zk-page-title" class="col-lg-7 text-lg-right"><?php melokids_get_page_title(); ?></div>
                            <?php
                            break;
                        case '7':
                            ?>
                            <div id="zk-page-title" class="col-md-12"><?php melokids_get_page_title(); ?></div>
                            <?php
                            break;
                        case '8':
                            ?>
                            <div id="zk-breadcrumb" class="col-md-12"><?php melokids_get_bread_crumb(); ?></div>
                            <?php
                            break;
                    } ?>
                    </div>
                </div>
            </div>
        <?php   
    }
}
/**
 * page title text
 */
function melokids_get_page_title(){
    echo '<div class="zk-page-title-text h3">';
    if (!is_archive()){
        /* Static page : Post Page */
        if(is_home()):
            if(is_front_page()){
                echo get_option('blogname');
            } else {
                echo get_the_title(get_option( 'page_for_posts' ));
            }
        /* page. */
        elseif(is_singular()) :
            /* custom title. */
            if(!empty(melokids_get_opts('page_title_text'))):
                $page_title_text = strip_tags(melokids_get_opts('page_title_text'));
                echo '<div class="title">';
                    echo esc_html($page_title_text);
                echo '</div>';
            else :
                echo '<div class="title">';
                    the_title(); 
                echo '</div>';
            endif;
            /* custom sub title. */
            if(!empty(melokids_get_opts('page_title_subtext'))):
                $page_title_subtext = strip_tags(melokids_get_opts('page_title_subtext'));
                echo '<div class="sub-title d-block">';
                    echo esc_html($page_title_subtext);
                echo '</div>';
            endif;
        elseif (is_front_page()):
            esc_html_e('Our Blog', 'melokids');
        /* search */
        elseif (is_search()):
            printf( esc_html__( 'Search Results for: %s', 'melokids' ), '<span>' . get_search_query() . '</span>' );
        /* 404 */
        elseif (is_404()):
            esc_html_e( '404', 'melokids');
        /* Single Post */
        elseif(is_singular('post') ):
            the_title();
        /* other */
        else :
            the_title();
        endif;
    } else {
        /* category. */
        if ( is_category() ) :
            single_cat_title();
        /* tag. */     
        elseif ( is_tag() ) : 
            single_tag_title();
        /* author. */
        elseif ( is_author() ) :
            printf( esc_html__( 'Author: %s', 'melokids' ), '<span>' . get_the_author() . '</span>' );
        /* date */
        elseif ( is_day() ) :
            printf( esc_html__( 'Day: %s', 'melokids' ), '<span>' . get_the_date() . '</span>' );
        elseif ( is_month() ) :
            printf( esc_html__( 'Month: %s', 'melokids' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'melokids' ) ) . '</span>' );
        elseif ( is_year() ) :
            printf( esc_html__( 'Year: %s', 'melokids' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'melokids' ) ) . '</span>' );
        /* post format */
        elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
            esc_html_e( 'Asides', 'melokids' );
        elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
            esc_html_e( 'Galleries', 'melokids');
        elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
            esc_html_e( 'Images', 'melokids');
        elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
            esc_html_e( 'Videos', 'melokids' );
        elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
            esc_html_e( 'Quotes', 'melokids' );
        elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
            esc_html_e( 'Links', 'melokids' );
        elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
            esc_html_e( 'Statuses', 'melokids' );
        elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
            esc_html_e( 'Audios', 'melokids' );
        elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
            esc_html_e( 'Chats', 'melokids' );
        /* woocommerce */
        elseif (function_exists('is_woocommerce') && is_woocommerce()):
            woocommerce_page_title();
        /* Custom taxonomy */
        elseif(is_tax() ):
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            echo esc_html($term->name);
        /* Custom Post type */
        elseif(is_post_type_archive() ):
            post_type_archive_title();
        else :
            /* other */
            the_title();
        endif;
    }
    echo '</div>';
}

/**
 * Breadcrumb NavXT
 *
 * @since 1.0.0
 */
function melokids_get_bread_crumb() {
    if(!function_exists('bcn_display')) return;
    echo '<div class="zk-breadcrumb-inner"><div class="zk-breadcrumb-inner2">';
    bcn_display();
    echo '</div></div>';
}

/**
 * Page Title Image
 * get image for page title layout 3
 * page_title_img
*/
function melokids_page_title_img(){
    global $theme_options, $meta_options;
    $page_title_layout = $meta_options['page_title_layout'];
    $page_title_img = isset($theme_options['page_title_img']['url']) ? $theme_options['page_title_img']['url'] : '';
    if(is_singular() && $page_title_layout !== '-1' && isset($meta_options['page_title_img']['url']) && !empty($meta_options['page_title_img']['url'])){
        $page_title_img = $meta_options['page_title_img']['url'];
    }
    if(empty($page_title_img)) return;
    ?>
    <div class="pt-img w-lg-50 full-<?php echo melokids_align2();?>">
        <?php
            echo sprintf(
                '<img alt="%s" src="%s" />',
                get_the_title(),
                esc_url($page_title_img)
            );
        ?>
    </div>
    <?php
}

/**
 * Content Area Attributes
*/
if(!function_exists('melokids_content_atts')){
    function melokids_content_atts($args = []){
        $args = wp_parse_args($args, array(
            'sidebar' => 'sidebar-main',
            'class'   => ''
        ));
        extract($args);
        /* ID */
        $atts[] = 'id="content-area"';
        /* Class */
        $classes = ['content-area', $class];
        /* get class if have sidebar */
        if(is_singular('page')){
            $sidebar_pos = melokids_get_opts('page_layout','right');
            $sidebar = melokids_get_opts('page_sidebar','sidebar-main');
        } elseif(is_singular('post')){
            $sidebar_pos = melokids_get_opts('single_layout','right');
            $sidebar = melokids_get_opts('single_sidebar','sidebar-main');
        } elseif(is_singular('product')){
            $sidebar_pos = melokids_get_opts('single_product_layout','right');
            $sidebar = melokids_get_opts('single_product_sidebar','sidebar-shop');
        } elseif(function_exists('is_woocommerce') && ( is_woocommerce() || is_product_taxonomy() ) ){
            $sidebar_pos = melokids_get_opts('wc_archive_layout','right');
            $sidebar = melokids_get_opts('wc_archive_sidebar','sidebar-shop');
        } else {
            $sidebar_pos = melokids_get_opts('archive_layout','right');
            $sidebar = melokids_get_opts('archive_sidebar','sidebar-main');
        }
        if($sidebar_pos === 'full'){
            $classes[] = 'col-12';
            $classes[] = 'no-sidebar';
        } else {
            if(is_active_sidebar($sidebar)){
                $classes[] = 'col-lg-8 col-xl-9';
            } else {
                $classes[] = 'col-12';
                $classes[] = 'no-sidebar';
            }
        }

        if($sidebar_pos === 'left')
            $classes[] = 'order-lg-1';

        $atts[] = 'class="'.trim(implode(' ', $classes)).'"';
        /* Print attributes */

        echo trim(implode(' ', $atts));
    }
}

/**
 * Get Sidebar Area
*/
if(!function_exists('melokids_get_sidebar')){
    function melokids_get_sidebar($args = []){
        global $theme_options, $meta_options;
        if(is_singular('page')){
            $sidebar_pos = melokids_get_opts('page_layout','right');
            $sidebar = melokids_get_opts('page_sidebar','sidebar-main');
        } elseif(is_singular('post')){
            $sidebar_pos = melokids_get_opts('single_layout','right');
            $sidebar = melokids_get_opts('single_sidebar','sidebar-main');
        } elseif(is_singular('product')){
            $sidebar_pos = melokids_get_opts('single_product_layout','right');
            $sidebar = melokids_get_opts('single_product_sidebar','sidebar-shop');
        } elseif(function_exists('is_woocommerce') && ( is_woocommerce() || is_product_taxonomy() ) ){
            $sidebar_pos = melokids_get_opts('wc_archive_layout','right');
            $sidebar = melokids_get_opts('wc_archive_sidebar','sidebar-shop');
        } else {
            $sidebar_pos = melokids_get_opts('archive_layout','right');
            $sidebar = melokids_get_opts('archive_sidebar','sidebar-main');
        }
        if($sidebar_pos === 'full' || !is_active_sidebar($sidebar) )  return;

        $args = wp_parse_args($args, array(
            'sidebar' => $sidebar,
            'class' => ''
        ));
        extract($args);
        
        /* ID */
        $atts[] = 'id="sidebar-area"';
        /* Class */
        $classes = ['sidebar-area',$class,'col-lg-4 col-xl-3'];
        
        $atts[] = 'class="'.trim(implode(' ', $classes)).'"';
        if(is_active_sidebar($sidebar)) {
            echo '<div '.trim(implode(' ', $atts)).'><div class="sidebar-inner">';
                dynamic_sidebar($sidebar);
            echo '</div></div>';
        }
    }
}


/**
 * Get custom post type taxonomy: taxonomies
 *
*/
function melokids_get_taxonimies($key=array())
{
    $post = get_post();
    $tax_names = get_object_taxonomies($post);
    $result = 'category';
    if(is_array($tax_names))
    {
        foreach ($tax_names as $name)
            if(strpos($name,$key) !== false)
            {
                $result = $name;
                break;
            }
    }
    return $result;
}

/**
 * MeloKids Loop Start 
*/
if(!function_exists('melokids_loop_start')){
    function melokids_loop_start(){
        $archive_layout = melokids_get_opts('archive_content_layout','list');
        $loop_classes = ['zk-loop-start zk-blog'];
        if('list' === $archive_layout) 
            $loop_classes[] = 'zk-list';
        else 
            $loop_classes[] = 'zk-grid row';
    ?>
        <div class="<?php echo trim(implode(' ', $loop_classes));?>">
    <?php
    }
}
add_action('melokids_loop_start','melokids_loop_start');

/**
 * MeloKids Loop End 
*/
if(!function_exists('melokids_loop_end')){
    function melokids_loop_end(){
    ?>
        </div>
    <?php
    }
}
add_action('melokids_loop_end','melokids_loop_end');

/**
 * Post Class
*/
add_filter('post_class','melokids_post_class');
if(!function_exists('melokids_post_class')){
    function melokids_post_class($classes){
        //$classes[] = 'overlay-wrap';
        return $classes;
    }
}

/**
 * Remove shortcode from post excerpt.
 * if shortcode is not registered with wordpress function add_shortcode
 * ex: remove wpvideo from jetpack
 * the_excerpt
 */
add_filter( 'the_excerpt', 'melokids_remove_shortcodes', 20 );
function melokids_remove_shortcodes( $content){
    $content = strip_shortcodes($content);
    $tagnames = apply_filters('melokids_remove_shortcodes_in_excerpt', array('wpvideo', 'vc_row', 'vc_section'));
    $content = do_shortcodes_in_html_tags( $content, true, $tagnames );

    $pattern = get_shortcode_regex( $tagnames );
    $content = preg_replace_callback( "/$pattern/", 'strip_shortcode_tag', $content );
    return $content;
}

/**
 * Display an optional post Thumbnail.
 * 
 * @since 1.0.0
 * @author Chinh Duong Manh
*/
if(!function_exists('melokids_post_thumbnail')){
    function melokids_post_thumbnail($args=[]){
        $args = wp_parse_args($args,[
            'size'       => 'large',
            'link_class' => 'media-link text-center',
            'img_class'  => '',
        ]);
        if(!has_post_thumbnail() || (isset($args['id']) && empty($args['id']))) return;
        wp_enqueue_script('magnific-popup');
        wp_enqueue_style ('magnific-popup');
        wp_enqueue_style ('animate-css');
            
        if(!is_singular()){
            $link_open = '<a class="'.esc_attr($args['link_class']).'" href="'.esc_url(get_the_permalink()).'">';
            $link_close = '</a>';
        } else {
            $link_open = $link_close = '';
        }
        echo wp_kses_post($link_open);
            if(isset($args['id']) && !empty($args['id'])){
                echo wp_get_attachment_image($args['id'],$args['size'], array('class' => $args['img_class']) );
            } else {
                melokids_image_by_size(['size' => $args['size'], 'class' => $args['img_class']]);
            }
        echo wp_kses_post($link_close);
    }
}
/**
 * Display an optional post video.
 * Post Format : Video 
 * @since 1.0.0
 * @author Chinh Duong Manh
 */
function melokids_entry_video($args = array() ) {
    $defaults = array(
        'size'          => 'large',
        'img_class'     => ''    
    );
    $args = wp_parse_args($args, $defaults);
    global  $wp_embed;

    $video = '';
    /* get video from post option */
    $video_type        = melokids_format_opts('video_type','embed');
    $video_local       = melokids_format_opts('video_local',[]);
    $video_local_thumb = melokids_format_opts('video_local_thumb',[]);
    $video_embed       = melokids_format_opts('video_embed','');
    /* Local video */
    if($video_type === 'local' && !empty($video_local['id'])){
        /* Get default video poster */
        $video_thumb = !empty(get_the_post_thumbnail_url($video_local['id'])) ? get_the_post_thumbnail_url($video_local['id'],'full') : get_the_post_thumbnail_url(get_the_ID(),'full');
        /* change poster */
        $poster = !empty($video_local_thumb['url']) ? $video_local_thumb['url'] : $video_thumb;
        /* Build video */            
        $atts = array(
            'src'    => esc_url($video_local['url']),
            'poster' => esc_url($poster),
            'width'  => esc_attr($video_local['width']),
            'height' => esc_attr($video_local['height'])
        );
        $video = wp_video_shortcode($atts);
    }
    /* Embed Video */
    elseif ($video_type === 'embed' && !empty($video_embed)){
        $video = do_shortcode($wp_embed->run_shortcode('[embed]'.esc_url($video_embed).'[/embed]'));
    } 
    /* Show video */
    if(!empty($video)){
        echo ''.$video;
    } else {
        melokids_post_thumbnail(['size' => $args['size'], 'img_class' => $args['img_class']]);
    }
}

/**
 * Display an optional post audio.
 * @since 1.0.0
 * @author Chinh Duong Manh
 */
function melokids_entry_audio($args = array() ) {
    $defaults = array(
        'size'          => 'large',
        'img_class'     => ''
    );
    $args = wp_parse_args($args, $defaults);

    global $wp_embed;
    $audio = '';
    $audio_type  = melokids_format_opts('audio_type','embed');
    $audio_embed = melokids_format_opts('audio_embed','');
    $audio_local = melokids_format_opts('audio_local','');

    /* get audio from post option */
    if($audio_type === 'local' && !empty($audio_local['id'])){
        $atts = array(
            'src'    => esc_url($audio_local['url']),
        );
        $audio =  wp_audio_shortcode($atts);
    } 
    /* Embed Audio */
    elseif ($audio_type === 'embed' && !empty($audio_embed)){
        $audio = do_shortcode($wp_embed->run_shortcode('[embed]'.esc_url($audio_embed).'[/embed]'));
    }
    /* Show Audio */
    if(!empty($audio)){
        echo ''.$audio;
    } else {
        melokids_post_thumbnail(['size' => $args['size'], 'img_class' => $args['img_class']]);
    }
}
/**
 * Display an optional post gallery.
 * @since 1.0.0
 * @author Chinh Duong Manh
 */
function melokids_entry_gallery($args = array()){
    $defaults = array(
        'size'          => 'large',
        'img_class'     => ''
    );
    $args = wp_parse_args($args, $defaults);

    $gallery_layout       = melokids_format_opts('gallery_layout','slide');
    $gallery_ids          = melokids_format_opts('gallery_ids',''); 

    /* Show post featured image if empty gallery */
    if(empty($gallery_ids)) {
        melokids_post_thumbnail(['size' => $args['size'], 'img_class' => $args['img_class']]);
    } else {

        $gallery_size         = melokids_format_opts('gallery_size','large'); 
        $gallery_grid_col     = melokids_format_opts('gallery_grid_col','3');
        $gallery_size_custom  = melokids_format_opts('gallery_size_custom','medium');

        /* gallery option */
        $array_id = explode(',', $gallery_ids);
        $wrap_class = ['post-gallery','post-gallery-'.$gallery_layout];
        $item_class = ['gal-item'];

        switch ($gallery_layout) {
            case 'grid':
                $wrap_class[] = 'zk-grid row';
                $item_class[] = 'grid-item col-md-'.round(12 / $gallery_grid_col);
                break;
            case 'masonry':
                $wrap_class[] = 'zk-masonry';
                $item_class[] = 'zk-masonry-item';
                wp_enqueue_script('jquery-masonry');
                break;
            default:
                $wrap_class[] = '';
                $item_class[] = 'slide-item col-12';
                if(is_singular()) $args['size'] = ['post-thumbnail'];
                break;
        }
        
        if(!is_singular()){
            melokids_post_thumbnail(['id'=> $array_id[0] , 'size' => $args['size']]);
        } else {
            if('custom' === $gallery_size)
                $args['size'] = $gallery_size_custom;
            else 
                $args['size'] = $gallery_size;

            $size = explode(',', $args['size']);

            wp_enqueue_script('magnific-popup');
            wp_enqueue_style ('magnific-popup');
            wp_enqueue_style ('animate-css');
        ?>
        <div id="post-gallery<?php the_ID();?>" class="<?php echo trim(implode(' ', $wrap_class));?>">
            <?php 
                $i = 0;
                $size_index = -1;
                switch ($gallery_layout) {
                    case 'slide':
                        melokids_entry_gallery_slide($gallery_ids);
                        break;
                    
                    default:
                        
                        if($gallery_layout === 'masonry'){
                            wp_enqueue_script( 'jquery-masonry');
                            echo '<div class="masonry-size"></div>';
                        } 
                        foreach ($array_id as $image_id):
                            $attachment_image = wp_get_attachment_image_src($image_id, $args['size'], false);
                            $full_image = wp_get_attachment_image_src($image_id, 'full', false);

                            $size_index++;
                            if($size_index >= count($size))
                            $size_index = $size_index - count($size);

                            if($attachment_image){
                                /* Attachment Meta */
                                $attachment_meta        = wp_prepare_attachment_for_js($image_id);
                                $attachment_url         = $attachment_meta['url'];
                                $attachment_title       = !empty($attachment_meta['title']) ? $attachment_meta['title'] : $attachment_meta['name'];
                                $attachment_caption     = !empty($attachment_meta['caption']) ? $attachment_meta['caption'] : '';
                                $attachment_alt         = !empty($attachment_meta['alt']) ? $attachment_meta['alt'] : '';
                                $attachment_description = !empty($attachment_meta['description']) ? $attachment_meta['description'] : '';
                                $attachment_thumbnail   = isset($attachment_meta['sizes']) ? $attachment_meta['sizes'] : array('full'=> array('url' => $attachment_url,'width' => '1170', 'height' => '770'));
                                $attachment_data_size   = $attachment_thumbnail['full']['width'].'x'.$attachment_thumbnail['full']['height'];
                                ?>
                                    <div class="<?php echo trim(implode(' ', $item_class));?>">
                                        <a class="prettyphoto hoverdir-wrap hoverdir-slide" href="<?php echo esc_url($full_image[0]);?>" title="<?php echo esc_attr($attachment_title); ?>"  data-size="<?php echo esc_attr($size[$size_index]);?>" data-rel="prettyPhoto[rel-<?php the_ID();?>]"><?php 
                                                melokids_image_by_size(['id' => $image_id, 'size' => trim($size[$size_index])] );
                                                echo '<div class="overlay"><div class="overlay-inner"><span class="open-popup fa fa-search"></span></div></div>'; 
                                        ?></a>
                                    </div>
                                <?php
                            }
                            if($i==0)
                                $i++;
                        endforeach; 
                    break;
                }
            ?>
        </div>
        <?php
        }
    }
}

function melokids_entry_gallery_slide($gallery_ids){
    if(empty($gallery_ids)) return;
    $array_id = explode(',', $gallery_ids);
    $i = 0;
    foreach ($array_id as $image_id):
        $i ++;
        $full_image = wp_get_attachment_image_src($image_id, 'full', false);
        if($full_image){
            /* Attachment Meta */
            $attachment_meta        = wp_prepare_attachment_for_js($image_id);
            $attachment_url         = $attachment_meta['url'];
            $attachment_title       = !empty($attachment_meta['title']) ? $attachment_meta['title'] : $attachment_meta['name'];
            $attachment_caption     = !empty($attachment_meta['caption']) ? $attachment_meta['caption'] : '';
            $attachment_alt         = !empty($attachment_meta['alt']) ? $attachment_meta['alt'] : '';
            $attachment_description = !empty($attachment_meta['description']) ? $attachment_meta['description'] : '';
            ?>
                <a class="prettyphoto" href="<?php echo esc_url($full_image[0]);?>" title="<?php echo esc_attr($attachment_title); ?>">
                    <?php if($i === 1) melokids_post_thumbnail(['id'=> $array_id[0] , 'size' => 'post-thumbnail']); ?>
                </a>
            <?php
        }
    endforeach; 
}

/**
 * Display an optional post quote.
 * @since 1.0.0
 * @author Chinh Duong Manh
 */
function melokids_entry_quote($args = array()) {
    $defaults = array(
        'size'          => 'large',
        'img_class'     => ''
    );
    $args = wp_parse_args($args, $defaults);
    $quote_title = melokids_format_opts('quote_title','');
    $quote_content = melokids_format_opts('quote_content','');

    if(empty($quote_title) && empty($quote_content)){
        melokids_post_thumbnail(['size' => $args['size'], 'img_class' => $args['img_class']]);
        return;
    } 

    $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), $args['size'] );
    $styles = array();
    if($thumbnail_url) {
        $styles[] = 'background-image:url('.esc_url($thumbnail_url).')';
    } else {
        $styles[] = '';
    }
    if ( ! empty( $styles ) ) {
        $style = 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
    } else {
        $style = '';
    }

    if(has_post_thumbnail()) $has_thumbnail = 'has-thumbnail'; else $has_thumbnail = '';
    /* start show quote */
    echo '<div class="entry-quote-inner text-center '.esc_attr($has_thumbnail).'" ' . $style . '>';
        echo wp_kses_post($quote_content).'<cite>'.esc_html($quote_title).'</cite>';
    echo '</div>';
}
/**
 * Display an optional post Link.
 * @since 1.0.0
 * @author Chinh Duong Manh
 */
function melokids_entry_link($args = array() ) {
    $defaults = array(
        'size'          => 'large',
        'img_class'     => ''
    );
    $args = wp_parse_args($args, $defaults);
   
    $link_text = melokids_format_opts('link_text','');
    $link_url  = melokids_format_opts('link_url','');

    if(empty($link_text) || empty($link_url)){
        melokids_post_thumbnail(['size' => $args['size'], 'img_class' => $args['img_class']]);
        return;
    } 

    $inner_class = ['entry-link-inner'];

    $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), $args['size'] );
    $styles = array();
    if($thumbnail_url) {
        $styles[] = 'background-image:url('.esc_url($thumbnail_url).')';
        $inner_class[] = 'has-thumbnail';
    }
    if ( ! empty( $styles ) ) {
        $style = 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
    } else {
        $style = '';
    }
    /* start show link */
    if(!empty($link_url)){
        echo '<div class="'.trim(implode(' ', $inner_class)).'" '. $style . ' >';
            echo '<a class="btn-primary" href="'.esc_url($link_url).'" target="_blank">'.wp_trim_words($link_text, 34, '&nbsp;&hellip;').'<span class="icon-link"></span></a>';
        echo '</div>';
    }
}

if(!function_exists('melokids_format_opts_value')){
    function melokids_format_opts_value(){
        $post_format = get_post_format();
        /* Video */
        $video_type  = melokids_format_opts('video_type','');
        $video_embed = melokids_format_opts('video_embed','');
        $video_local = melokids_format_opts('video_local','');
        /* Audio */
        $audio_type  = melokids_format_opts('audio_type','');
        $audio_embed = melokids_format_opts('audio_embed','');
        $audio_local = melokids_format_opts('audio_local','');
        /* Gallery */
        $gallery_ids = melokids_format_opts('gallery_ids','');
        /* Quote */
        $quote_title   = melokids_format_opts('quote_title','');
        $quote_content = melokids_format_opts('quote_content','');
        /* Link  */
        $link_text = melokids_format_opts('link_text','');
        $link_url  = melokids_format_opts('link_url','');

        switch ($post_format) {
            case 'video':
                if( ($video_type === 'embed' && !empty($video_embed)) || ($video_type === 'local' && !empty($video_local)) || has_post_thumbnail())
                    $value = true;
                else 
                    $value = false; 
                break;
            case 'audio':
                if( ($audio_type === 'embed' && !empty($audio_embed)) || ($audio_type === 'local' && !empty($audio_local)) || has_post_thumbnail())
                    $value = true;
                else 
                    $value = false; 
                break;
            case 'gallery':
                if( !empty($gallery_ids) || has_post_thumbnail())
                    $value = true;
                else 
                    $value = false; 
                break;
            case 'quote':
                if( (!empty($quote_title) && !empty($quote_content)) || has_post_thumbnail() )
                    $value = true;
                else 
                    $value = false; 
                break;
            case 'link':
                if( (!empty($link_text) && !empty($link_url)) || has_post_thumbnail() )
                    $value = true;
                else 
                    $value = false; 
                break;
            default:
                $value = has_post_thumbnail() ? true : false;
        }
        return $value;
    }
}

/**
 * MeloKids Post Pagination
*/
if(!function_exists('melokids_posts_pagination')){
    function melokids_posts_pagination($args = []){
        $args = wp_parse_args($args, array(
            'layout' => '1'
        ));
        switch ($args['layout']) {
            default:
                the_posts_pagination(array(
                    'prev_text' => '<span class="far fa-long-arrow-'.melokids_align().'"></span>',
                    'next_text' => '<span class="far fa-long-arrow-'.melokids_align2().'"></span>',
                ));
                break; 
        }
    }
}
// add leading zero to pagination
//add_filter( 'number_format_i18n', 'melokids_number_format_i18n', 10, 1);
if(!function_exists('melokids_number_format_i18n')){
    function melokids_number_format_i18n($formatted){
        $formatted = zeroise($formatted, 2);
        return $formatted;
    }
}

/**
 * MeloKids Page pagination
*/
if(!function_exists('melokids_wp_link_pages')){
    function melokids_wp_link_pages(){
        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'melokids' ),
            'after'  => '</div>',
            'link_before'      => '<span class="page-link-number">',
            'link_after'       => '</span>',
        ));
    }
}

/**
 * MeloKids Footer Default 
*/
if(!function_exists('melokids_footer_default')){
    function melokids_footer_default(){
        printf( esc_html__('&copy; %s %s by %s. All Rights Reserved.','melokids'), date('Y') , get_bloginfo('name'), '<a href="'.esc_url('https://themeforest.net/user/zookastudio').'">'.esc_html__('Zooka Studio','melokids').'</a>');
    }
}

/*
* Resize images dynamically using wp built in functions
* Chinh Duong Manh
*
*
*/
if ( ! function_exists( 'melokids_resize' ) ) {
    /**
     * @param int $attach_id
     * @param string $img_url
     * @param int $width
     * @param int $height
     * @param bool $crop
     *
     * @since 1.0
     * @return array
     */
    function melokids_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {
        // this is an attachment, so we have the ID
        if(empty($img_url) || $img_url === null) $img_url = '/wp-content/themes/'.get_template().'/assets/images/no-image.jpg';
        $image_src = array();
        if ( $attach_id ) {
            $image_src = wp_get_attachment_image_src( $attach_id, 'full' );
            $actual_file_path = get_attached_file( $attach_id );
            // this is not an attachment, let's use the image url
        } elseif ( $img_url ) {
            $file_path = parse_url( $img_url );
            $actual_file_path = rtrim( ABSPATH, '/' ) . $file_path['path'];
            $orig_size = getimagesize( $actual_file_path );
            $image_src[0] = site_url().$img_url;
            $image_src[1] = $orig_size[0];
            $image_src[2] = $orig_size[1];
        }
        if ( ! empty( $actual_file_path ) ) {
            $file_info = pathinfo( $actual_file_path );
            $extension = '.' . $file_info['extension'];

            // the image path without the extension
            $no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

            $cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

            // checking if the file size is larger than the target size
            // if it is smaller or the same size, stop right here and return
            if ( $image_src[1] > $width || $image_src[2] > $height ) {

                // the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
                if ( file_exists( $cropped_img_path ) ) {
                    $cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
                    $melokids_image = array(
                        'url'    => $cropped_img_url,
                        'width'  => $width,
                        'height' => $height,
                        'alt'    => get_bloginfo('name')   
                    );

                    return $melokids_image;
                }

                if ( false == $crop ) {
                    // calculate the size proportionaly
                    $proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
                    $resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

                    // checking if the file already exists
                    if ( file_exists( $resized_img_path ) ) {
                        $resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

                        $melokids_image = array(
                            'url'    => $resized_img_url,
                            'width'  => $proportional_size[0],
                            'height' => $proportional_size[1],
                            'alt'    => get_bloginfo('name')   
                        );

                        return $melokids_image;
                    }
                }

                // no cache files - let's finally resize it
                $img_editor = wp_get_image_editor( $actual_file_path );

                if ( is_wp_error( $img_editor ) || is_wp_error( $img_editor->resize( $width, $height, $crop ) ) ) {
                    return array(
                        'url'    => '',
                        'width'  => '',
                        'height' => '',
                        'alt'    => get_bloginfo('name')   
                    );
                }

                $new_img_path = $img_editor->generate_filename();

                if ( is_wp_error( $img_editor->save( $new_img_path ) ) ) {
                    return array(
                        'url'    => '',
                        'width'  => '',
                        'height' => '',
                        'alt'    => get_bloginfo('name')   
                    );
                }
                if ( ! is_string( $new_img_path ) ) {
                    return array(
                        'url'    => '',
                        'width'  => '',
                        'height' => '',
                        'alt'    => get_bloginfo('name')   
                    );
                }

                $new_img_size = getimagesize( $new_img_path );
                $new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

                // resized output
                $melokids_image = array(
                    'url'    => $new_img,
                    'width'  => $new_img_size[0],
                    'height' => $new_img_size[1],
                    'alt'    => get_bloginfo('name')   
                );

                return $melokids_image;
            }

            // default output - without resizing
            $melokids_image = array(
                'url'    => $image_src[0],
                'width'  => $image_src[1],
                'height' => $image_src[2],
                'alt'    => get_bloginfo('name')   
            );

            return $melokids_image;
        }
        return false;
    }
}

if(!function_exists('melokids_get_image_url_by_size')){
    function melokids_get_image_url_by_size( $id, $size ) {
        global $_wp_additional_image_sizes;

        if ( is_string( $size ) && ( ( ! empty( $_wp_additional_image_sizes[ $size ] ) && is_array( $_wp_additional_image_sizes[ $size ] ) ) || in_array( $size, array(
                    'thumbnail',
                    'thumb',
                    'medium',
                    'medium_large',
                    'large',
                    'full',
                ) ) )
        ) {
            return wp_get_attachment_image_src( $id, $size );
        } else {
            if ( is_string( $size ) ) {
                preg_match_all( '/\d+/', $size, $thumb_matches );
                if ( isset( $thumb_matches[0] ) ) {
                    $size = array();
                    $count = count( $thumb_matches[0] );
                    if ( $count > 1 ) {
                        $size[] = $thumb_matches[0][0]; // width
                        $size[] = $thumb_matches[0][1]; // height
                    } elseif ( 1 === $count ) {
                        $size[] = $thumb_matches[0][0]; // width
                        $size[] = $thumb_matches[0][0]; // height
                    } else {
                        $size = false;
                    }
                }
            }
            if ( is_array( $size ) ) {
                // Resize image to custom size
                $p_img = melokids_resize( $id, null, $size[0], $size[1], true );

                return $p_img['url'];
            }
        }
        return '';
    }
}

if(!function_exists('melokids_image_by_size')){
    function melokids_image_by_size( $args = []) {
        global $_wp_additional_image_sizes;
        $args = wp_parse_args($args,[
            'id'     => get_post_thumbnail_id(get_the_ID()), 
            'img_url'=> null,
            'size'   => 'medium', 
            'class'  => '',
            'echo'   => true 
        ]);

        if ( is_string( $args['size'] ) && ( ( ! empty( $_wp_additional_image_sizes[ $args['size'] ] ) && is_array( $_wp_additional_image_sizes[ $args['size'] ] ) ) || in_array( $args['size'], array(
                    'thumbnail',
                    'thumb',
                    'medium',
                    'medium_large',
                    'large',
                    'full',
                ) ) )
        ) {
 
            if(true === $args['echo'])
                echo wp_get_attachment_image( $args['id'], $args['size'], '', array('class' => $args['class']) );
            else 
                return wp_get_attachment_image( $args['id'], $args['size'], '', array('class' => $args['class']) );
        } else {

            $size = explode('x', $args['size']);
            if(!isset($size[1]) || empty($size[1])) $size[1] = $size[0];

            if ( is_string( $size ) ) {
                preg_match_all( '/\d+/', $size, $thumb_matches );
                if ( isset( $thumb_matches[0] ) ) {
                    $size = array();
                    $count = count( $thumb_matches[0] );
                    if ( $count > 1 ) {
                        $size[] = $thumb_matches[0][0]; // width
                        $size[] = $thumb_matches[0][1]; // height
                    } elseif ( 1 === $count ) {
                        $size[] = $thumb_matches[0][0]; // width
                        $size[] = $thumb_matches[0][0]; // height
                    } else {
                        $size = false;
                    }
                }
            }
            if ( is_array( $size ) ) {
                // Resize image to custom size
                $p_img = melokids_resize( $args['id'], $args['img_url'], $size[0], $size[1], true );
                $alt = trim( strip_tags( get_post_meta( $args['id'], '_wp_attachment_image_alt', true ) ) );
                $attachment = get_post( $args['id'] );
                if ( ! empty( $attachment ) ) {
                    $title = trim( strip_tags( $attachment->post_title ) );

                    if ( empty( $alt ) ) {
                        $alt = trim( strip_tags( $attachment->post_excerpt ) ); // If not, Use the Caption
                    }
                    if ( empty( $alt ) ) {
                        $alt = $title;
                    } // Finally, use the title
                } else {
                    $title = $alt = get_bloginfo('name');
                }
                $attributes = melokids_stringify_attributes( array(
                    'class'  => $args['class'],
                    'src'    => $p_img['url'],
                    'width'  => $p_img['width'],
                    'height' => $p_img['height'],
                    'alt'    => $alt,
                    'title'  => $title,
                ) );
                $thumbnail = '<img ' . $attributes . ' />';
                if(true === $args['echo'])
                    echo wp_kses_post($thumbnail);
                else 
                    return wp_kses_post($thumbnail);
            }
        }
    }
}

/**
 * Convert array of named params to string version
 * All values will be escaped
 *
 * E.g. f(array('name' => 'foo', 'id' => 'bar')) -> 'name="foo" id="bar"'
 *
 * @param $attributes
 *
 * @return string
 */
function melokids_stringify_attributes( $attributes ) {
    $atts = array();
    foreach ( $attributes as $name => $value ) {
        $atts[] = $name . '="' . esc_attr( $value ) . '"';
    }

    return implode( ' ', $atts );
}

/**
 * Get thumbnail size 
 * @return width / height of thumbnail
 *
*/
function melokids_thumbnail_dimensions($image_id = '', $size = 'thumbnail', $dimensions = 'height', $echo = false){
    if(empty($image_id)) $image_id = get_post_thumbnail_id();

    if(in_array( $size, array('thumbnail','thumb','medium','medium_large','large','full') ) ){
        $image = wp_get_attachment_image_src($image_id);
        $width = $image[1];
        $height = $image[2];
    } else {
        $image = explode('x', $size);
        $width = $image[0];
        $height = isset($image[1]) ? $image[1] : $image[0];
    }

    if($dimensions = 'height')
        $result = $height;
    else 
        $result = $width;
    if($echo)
        echo esc_html($result).'px';
    else 
        return $result.'px';
}