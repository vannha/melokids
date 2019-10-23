<?php
	if(!class_exists('EF4Framework') || !class_exists('VC_Manager')) return;

    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    /**/
    $wrap_classes = array(
    	'zk-posts',
    	'zk-posts-special',
    	$el_class,
    );
    $zkwrap_attributes = $zkitem_attributes = array();

    $wrap_inner_classes = array(
    	'zk-special',
    	'row'
    );

    $zkitem_classes     = array(
    	'zk-special-item',
    	'wpb_animate_when_almost_visible',
    	'wpb_fadeInUp',
    	'fadeInUp'
    );

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
    $thumbnail_size = ['800x438','440x241','440x241','440x241','440x241','440x241','440x241','360x196','360x196'];

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
                'posts_per_page'      => 9,
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
                'posts_per_page' => 9,
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
                'posts_per_page'      => 9,
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
                'posts_per_page'      => 9,
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
    $d = 0;
?>
<div id="zk-grid-<?php echo esc_attr($el_id);?>" class="<?php echo trim(implode(' ',$wrap_classes));?>">
    <div id="<?php echo esc_attr($el_id);?>" class="<?php echo trim(implode(' ',$wrap_inner_classes));?>" <?php echo implode(' ', $zkwrap_attributes);?>>
    <?php
        while ($zkposts->have_posts()): 
            $zkposts->the_post();
            $d ++;

            $thumbnail_size_index++;
            if($thumbnail_size_index >= count($thumbnail_size))
                $thumbnail_size_index = $thumbnail_size_index - count($thumbnail_size) ;
            if($d == 1) {
            ?>
            <div class="col-12 text-center">
                <div class="first-post <?php echo trim(implode(' ', $zkitem_classes));?>">
                    <div class="row <?php echo trim(implode(' ', $zkitem_inner_classes));?> gutters-70 align-items-center">
                        <div class="col-md-6 col-lg-7">
                            <?php melokids_entry_media(array('size' => $thumbnail_size[$thumbnail_size_index], 'img_class' => $media_class)); ?>
                        </div>
                        <div class="col-md-6 col-lg-5">
                            <?php 
                                melokids_entry_meta(array(
                                    'show_author'   => '',
                                    'show_date'     => '1',
                                    'date_icon'     => '', 
                                    'show_cate'     => '', 
                                    'show_cmt'      => '', 
                                    'show_view'     => '', 
                                    'show_like'     => '', 
                                    'show_share'    => '',
                                    'class'         => 'justify-content-center')
                                );
                                the_title('<h2><a href="'.get_the_permalink().'">','</a></h2>');
                                melokids_entry_excerpt(['length' => 41]);
                                melokids_entry_readmore(['show_readmore' => '1']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } elseif (in_array($d, array(2,3,4,5,6,7))) { ?>
            <div class="large-item <?php echo trim(implode(' ',$zkitem_classes));?> col-sm-12 col-md-6 col-lg-4 text-center" <?php echo implode(' ', $zkitem_attributes);?>>
                <div class="<?php echo trim(implode(' ', $zkitem_inner_classes));?>">
					<?php 
                        melokids_entry_media(array('size' => $thumbnail_size[$thumbnail_size_index], 'img_class' => $media_class)); ?>
                    <div class="hoverdir-content">
	                    <?php 
	                        melokids_entry_meta(array(
	                            'show_author'   => '',
                                'show_date'     => '1',
                                'date_icon'     => '', 
                                'show_cate'     => '', 
                                'show_cmt'      => '', 
                                'show_view'     => '', 
                                'show_like'     => '', 
                                'show_share'    => '',
                                'class'         => 'justify-content-center')
	                        );
	                        the_title('<h3><a href="'.get_the_permalink().'">','</a></h3>');
	                        melokids_entry_readmore(['show_readmore' => '1']);
	                    ?>
	                </div>
            	</div>
            </div>
            <?php } elseif(in_array($d, array(8,9))){ 
                if($d === 8) echo '<div class="col-12"><div class="small-item"><div class="row">';
                ?>
                <div class="col-xl-6 <?php echo trim(implode(' ', $zkitem_classes));?>">
                    <div class="row <?php echo trim(implode(' ', $zkitem_inner_classes));?>">
                        <div class="col-md-6">
                            <?php melokids_entry_media(array('size' => $thumbnail_size[$thumbnail_size_index],  'img_class' => $media_class)) ?>
                        </div>
                        <div class="col-md-6">
                            <?php 
                                melokids_entry_meta(array(
                                    'show_author'   => '',
                                    'show_date'     => '1',
                                    'date_icon'     => '', 
                                    'show_cate'     => '', 
                                    'show_cmt'      => '', 
                                    'show_view'     => '', 
                                    'show_like'     => '', 
                                    'show_share'    => '',
                                    'class'         => '')
                                );
                                the_title('<h3><a href="'.get_the_permalink().'">','</a></h3>');
                                melokids_entry_readmore(['show_readmore' => '1']);
                            ?>
                        </div>
                    </div>
                </div>
            <?php 
                if($d === 9 || $d === $zkposts->query['posts_per_page']) echo '</div></div></div>';
            } ?>
        <?php
        
        endwhile;
    ?>
    </div>
    <?php if('1' === $show_pagination) melokids_posts_pagination(['layout' => '2']); ?>
</div>