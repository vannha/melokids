<?php
	if(!class_exists('EF4Framework') || !class_exists('VC_Manager')) return;

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    switch ($layout_mode) {
        case 'auto':
            $layout_template = $layout_template_auto;
            break;
        
        default:
            $layout_template = $layout_template_grid;
            break;
    }
    /**/
    $wrap_classes = array(
    	'zk-posts',
    	'zk-posts-masonry',
    	'layout-'.$layout_template,
    	$el_class, 
    	$content_align
    );
    $zkwrap_attributes = $zkitem_attributes = array();

    $wrap_inner_classes = array(
    	'zk-masonry',
    	'layout-'.$layout_template,
    );

    $zkitem_classes     = array(
    	'zk-masonry-item',
    	'wpb_animate_when_almost_visible',
    	'wpb_fadeInUp',
    	'fadeInUp'
    );
    if($layout_mode === 'grid'){
        $wrap_inner_classes[] = 'row';

    	$zkitem_classes[] = 'col-sm-'.round(12/$col_sm);
    	$zkitem_classes[] = 'col-md-'.round(12/$col_md);
    	$zkitem_classes[] = 'col-lg-'.round(12/$col_lg);
    	$zkitem_classes[] = 'col-xl-'.round(12/$col_xl);
    } 

    $zkitem_inner_classes = array(
    	'item-inner',
    	'hoverdir-wrap',
    	'hoverdir-'.$hover_effect
    );

    $wrap_inner_classes[] = 'clearfix';

    /**
     * 
     * Thumbnail Size 
     * this option used for carousel
     * item width if enable option Auto Width
    */
    $thumbnail_size_index = -1;
    if(empty($thumbnail_size_custom)) $thumbnail_size_custom = '440x367,440x241,440x467,440x241,440x241,440x322,440x302,440x363,440x241,440x511,440x241,440x241';
            $thumbnail_size = explode(',', $thumbnail_size_custom);

    /* Post Query */
    $sticky = get_option('sticky_posts');
    $archive_url = get_post_type_archive_link($post_type);
    if(is_singular()){
        $post__not_in = array(get_the_ID());
    } else {
        $post__not_in = $sticky;
    }
    /* Paged */
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

    /* Tax Query */
    $tax_query = array();
    $tax_queries = array(); // List of taxnonimes
    if ( ! empty( $taxonomies ) ) {
        $taxonomies_types = get_taxonomies( array( 'public' => true ) );
        $terms = get_terms( array_keys( $taxonomies_types ), array(
            'hide_empty' => false,
            'include' => $taxonomies,
        ) );
        
        foreach ( $terms as $t ) {
            if ( ! isset( $tax_queries[ $t->taxonomy ] ) ) {
                $tax_queries[ $t->taxonomy ] = array(
                    'taxonomy' => $t->taxonomy,
                    'field' => 'id',
                    'terms' => array( $t->term_id ),
                    'relation' => 'IN',
                );
            } else {
                $tax_queries[ $t->taxonomy ]['terms'][] = $t->term_id;
            }
        }
        $tax_query = array_values( $tax_queries );
        $tax_query['relation'] = 'OR';
    }
    if('1' === $show_sticky)
        $ignore_sticky_posts = 0;
    else 
        $ignore_sticky_posts = 1;
    switch ($sort_by) {
        case 'most_viewed':
            $args = array(
                'posts_per_page'      => $posts_per_page,
                'post_type'           => $post_type,
                'post_status'         => 'publish',
                'post__not_in'        => $post__not_in,
                'ignore_sticky_posts' => $ignore_sticky_posts,
                'meta_key'            => 'post_views_count',
                'orderby'             => 'meta_value_num',
                'order'               => 'DESC',
                'paged'               => $paged,
                'tax_query'           => $tax_query,
            );
            break;
        case 'sticky_posts':
            $args = array(
                'posts_per_page' => $posts_per_page,
                'post_type'      => $post_type,
                'post_status'    => 'publish',
                'post__in'       => $sticky,
                'post__not_in'   => $post__not_in,
                'order'          => 'DESC',
                'paged'          => $paged,
                'tax_query'      => $tax_query,
            );
            break;
        case 'most_comment' :
            $args = array(
                'posts_per_page'      => $posts_per_page,
                'post_type'           => $post_type,
                'post_status'         => 'publish',
                'post__not_in'        => $sticky,
                'ignore_sticky_posts' => $ignore_sticky_posts,
                'orderby'             => 'comment_count',
                'order'               => 'DESC',
                'paged'               => $paged,
                'tax_query'           => $tax_query,
            );
            break;
        default:
            $args = array(
                'posts_per_page'      => $posts_per_page,
                'post_type'           => $post_type,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => $ignore_sticky_posts,
                'orderby'             => 'date',
                'order'               => 'DESC',
                'paged'               => $paged,
                'tax_query'           => $tax_query,
            );
            break;
    }

    switch ($content_align) {
        case 'text-left':
            $meta_class = 'justify-content-start';
            break;
        case 'text-right':
            $meta_class = 'justify-content-end';
            break;
        case 'text-center':
            $meta_class = 'justify-content-center';
            break;
        default:
            $meta_class = '';
            break;
    }

    $overlay_class = array('direction-reveal__overlay direction-reveal__anim--in');
    switch ($hover_effect) {
    	case 'slide-push':
    		$media_class = 'overlay-out';
    		break;
    	case 'flip':
    		$media_class = 'overlay-out';
    		break;
    	default:
    		$media_class = '';
    		break;
    }

    global $wp_query;
    $zkposts = $wp_query = new WP_Query($args);
    if(!($zkposts->have_posts())) {
        echo '<p class="required">'.esc_html__('No item found with your query!','melokids').'</p>';
        return;
    }

    wp_enqueue_script( 'jquery-masonry' );    
    wp_enqueue_script( 'waypoints' );
	wp_enqueue_style( 'animate-css' );

?>
<div id="zk-grid-<?php echo esc_attr($el_id);?>" class="<?php echo trim(implode(' ',$wrap_classes));?>">
    <div id="<?php echo esc_attr($el_id);?>" class="<?php echo trim(implode(' ',$wrap_inner_classes));?>" <?php echo implode(' ', $zkwrap_attributes);?>>
    <?php
        if($layout_mode === 'auto') echo '<div class="masonry-sizer"></div>';
        while ($zkposts->have_posts()): 
            $zkposts->the_post();

            $thumbnail_size_index++;
            if($thumbnail_size_index >= count($thumbnail_size))
                $thumbnail_size_index = $thumbnail_size_index - count($thumbnail_size) ;
            ?>
            <div class="<?php echo trim(implode(' ',$zkitem_classes));?>" <?php echo implode(' ', $zkitem_attributes);?>>
                <div class="<?php echo trim(implode(' ', $zkitem_inner_classes));?>">
	            <?php
	            switch ($layout_mode) {
                    case 'auto' :
                ?>
                    <?php melokids_image_by_size(['size' => $thumbnail_size[$thumbnail_size_index], 'img_class' => $media_class]); ?>
                    <div class="overlay hoverdir-content">
                        <?php 
                            melokids_entry_meta(array(
                                'show_author'   => $show_author,
                                'show_date'     => $show_date,
                                'date_icon'     => '', 
                                'show_cate'     => $show_cat, 
                                'show_cmt'      => $show_comment, 
                                'show_view'     => $show_view, 
                                'show_like'     => $show_like, 
                                'show_share'    => $show_share,
                                'class'         => $meta_class)
                            );
                            the_title('<'.$heading_tag.'><a href="'.get_the_permalink().'">','</a></'.$heading_tag.'>');
                            if($show_desc) melokids_entry_excerpt(['length' => $excerpt_length]);
                            melokids_entry_tag(['show_tag' => $show_tag]);
                            melokids_entry_readmore(['show_readmore' => 'show_readmore']);
                        ?>
                    </div>
                <?php
                        break;
	            	default:
                        melokids_entry_media(array('size' => $thumbnail_size[$thumbnail_size_index], 'img_class' => $media_class)); 
                ?>
                        <div class="hoverdir-content">
    	                    <?php 
    	                        melokids_entry_meta(array(
    	                            'show_author'   => $show_author,
    	                            'show_date'     => $show_date,
    	                            'date_icon'     => '', 
    	                            'show_cate'     => $show_cat, 
    	                            'show_cmt'      => $show_comment, 
    	                            'show_view'     => $show_view, 
    	                            'show_like'     => $show_like, 
    	                            'show_share'    => $show_share,
    	                            'class'         => $meta_class)
    	                        );
    	                        the_title('<'.$heading_tag.'><a href="'.get_the_permalink().'">','</a></'.$heading_tag.'>');
    	                        if($show_desc) melokids_entry_excerpt(['length' => $excerpt_length]);
    	                        melokids_entry_tag(['show_tag' => $show_tag]);
    	                        melokids_entry_readmore(['show_readmore' => 'show_readmore']);
    	                    ?>
    	                </div>
	            <?php
	            	break;
	            } 
	            ?>
            	</div>
            </div>
        <?php
        endwhile;
    ?>
    </div>
    <?php if('1' === $show_pagination) melokids_posts_pagination(['layout' => '2']); ?>
</div>