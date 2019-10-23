<?php
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    /**/
    $wrap_classes = array('zk-posts', $el_id, $el_class, $content_align);
    $wrap_inner_classes = $zkitem_classes = $zkwrap_attributes = $zkitem_attributes = array();

    if(is_numeric($masonry_gutter)) 
        $masonry_gutter = $masonry_gutter;
    else 
        $masonry_gutter = 30;
    $originLeft = is_rtl() ? false : true;

    $masonry_opts = array(
        'itemSelector'    => '.zk-masonry-item',
        'columnWidth'     => '.masonry-sizer',
        'percentPosition' => true,
        'originLeft'      => $originLeft,
        'horizontalOrder' => false,
    );

    switch ($layout_type) {
        case 'carousel':
            $wrap_classes[]       = 'zk-owl-wrap';
            $wrap_inner_classes[] = 'zk-carousel owl-carousel';
            $zkitem_classes[]     = 'zk-carousel-item';
            break;
        case 'masonry':
            $wrap_inner_classes[] = 'zk-masonry';
            $zkwrap_attributes[]  = 'style="margin-left:'.round($masonry_gutter/-2).'px; margin-right:'.round($masonry_gutter/-2).'px;"';
            $zkitem_attributes[]  = 'style="margin-bottom: '.esc_attr($masonry_gutter).'px; padding-left:'.round($masonry_gutter/2).'px; padding-right:'.round($masonry_gutter/2).'px;"'; 
            $zkitem_classes[]     = 'zk-masonry-item';
            //$zkwrap_attributes[]  = 'data-masonry="'.esc_attr(json_encode($masonry_opts)).'"';
            break;
        default:
            $wrap_inner_classes[] = 'zk-grid row';
            $zkitem_classes[]     = 'zk-grid-item col-sm-'.round(12/$col_sm).' col-md-'.round(12/$col_md).' col-lg-'.round(12/$col_lg).' col-xl-'.round(12/$col_xl);
            break;
    }

    $wrap_inner_classes[] = 'clearfix';

    /**
     * 
     * Thumbnail Size 
     * this option used for carousel
     * item width if enable option Auto Width
    */
    $thumbnail_size_index = -1;
    switch ($layout_type) {
        case 'masonry':
            if(empty($masonry_size)) $masonry_size = '440x367,440x241,440x467,440x241,440x241,440x322,440x302,440x363,440x241,440x511,440x241,440x241';
            $thumbnail_size = explode(',', $masonry_size);
            break;
        
        default:
            if($thumbnail_size === 'custom') {
                $thumbnail_size = explode(',', $thumbnail_size_custom);
            } else {
                $thumbnail_size = (array)$thumbnail_size;
            }
            break;
    }
    
    /* Carousel */
    $dot_image = wp_get_attachment_image(get_the_ID(),'thumbnail','',array('class'=>'img-circle'));

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
                'post__not_in'        => $sticky,
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


    global $wp_query;
    $zkposts = $wp_query = new WP_Query($args);
    if(!($zkposts->have_posts())) {
        echo '<p class="required">'.esc_html__('No item found with your query!','melokids').'</p>';
        return;
    }

    $count = $posts_per_page;
    $i=1;
    $j= $d = 0;
    $k = -1;
?>
<div class="<?php echo trim(implode(' ',$wrap_classes));?>">
    <?php melokids_owl_dots_top($layout_type, $nav_style, $dot_pos, $dot_style); ?>
    <div id="<?php echo esc_attr($el_id);?>" class="<?php echo trim(implode(' ',$wrap_inner_classes));?>" <?php echo implode(' ', $zkwrap_attributes);?>>
    <?php
        if($layout_type === 'masonry') echo '<div class="masonry-sizer"></div>';
        while ($zkposts->have_posts()): 
            $zkposts->the_post();

            $thumbnail_size_index++;
            if($thumbnail_size_index >= count($thumbnail_size))
                $thumbnail_size_index = $thumbnail_size_index - count($thumbnail_size) ;
        ?>
            <div class="<?php echo trim(implode(' ',$zkitem_classes));?>" <?php echo implode(' ', $zkitem_attributes);?>>
                <div class="item-inner">
                    <?php 
                        melokids_entry_media(array('size' => $thumbnail_size[$thumbnail_size_index]));
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
                        the_title('<h3><a href="'.get_the_permalink().'">','</a></h3>');
                        if($show_desc) melokids_entry_excerpt(['length' => $excerpt_length]);
                        melokids_entry_tag(['show_tag' => $show_tag]);
                        melokids_entry_readmore(['show_readmore' => 'show_readmore']);
                    ?>
                </div>
            </div>

        <?php
        endwhile;
    ?>
    </div>
    <?php 
        melokids_owl_preload($layout_type);
        melokids_owl_dots($layout_type, $dot_style, $dot_pos);
        melokids_owl_nav($layout_type, $nav_style, $nav_pos);
        melokids_owl_dots_in_nav($layout_type, $nav_style);

        if($layout_type !== 'carousel') melokids_posts_pagination();
    ?>
</div>