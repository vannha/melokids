<?php
if(!class_exists('EF4Framework')) return;

add_action('widgets_init', 'MeloKidsRecentPost');       
function MeloKidsRecentPost() {
    register_ef4_widget('MeloKidsRecentPost');
}

class MeloKidsRecentPost extends WP_Widget {

    function __construct() {
        $widget_ops = array(
            'classname'                   => 'melokids-recentpost',
            'description'                 => esc_html__( 'A list of recent posts.','melokids' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'MeloKidsRecentPost', esc_html__( '[MeloKids] Posts','melokids' ), $widget_ops );
    }

    function widget($args, $instance) {
        global $post;
        extract($args);
        $title         = apply_filters('widget_title', empty($instance['title']) ? esc_html__('Recent Posts','melokids') : $instance['title'], $instance, $this->id_base);
        $layout        = $instance['layout_wg'];
        $categories    = $instance['categories'];
        $post_type     = $instance['post_type'];
        $sort_by       = $instance['sort_by'];
        $show_image    = $instance['show_image'];
        $show_cat      = $instance['show_cat'];
        $show_author   = $instance['show_author'];
        $show_date     = $instance['show_date'];
        $show_comment  = $instance['show_comment'];
        $show_view     = $instance['show_view'];
        $show_view_all = (int) $instance['show_view_all'];
        $show_desc     = (int) $instance['show_desc'];
        $number        = (int) $instance['number'];

        /* direction */
        $dir_icon = is_rtl() ? 'left' : 'right';

        /* get post from special category */
        $cat_name = array();
        $sticky = get_option('sticky_posts');

        echo wp_kses_post($before_widget);
        if(is_singular()){
            $post__not_in = array($post->ID);
        } else {
            $post__not_in = $sticky;
        }
        switch ($sort_by) {
            case 'most_viewed':
                $args = array(
                    'posts_per_page' => $number,
                    'post_type'      => $post_type,
                    'post_status'    => 'publish',
                    'post__not_in'   => $post__not_in,
                    'meta_key'       => 'melokids_entry_views_count',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'DESC',
                    'paged'          => 1,
                    //'category_name'  => $cat_name
                );
                break;
            case 'sticky_posts':
                $args = array(
                    'posts_per_page' => $number,
                    'post_type'      => $post_type,
                    'post_status'    => 'publish',
                    'post__in'       => $sticky,
                    'post__not_in'   => $post__not_in,
                    'order'          => 'DESC',
                    'paged'          => 1,
                    //'category_name'  => $cat_name
                );
                break;
            case 'most_comment' :
                $args = array(
                    'posts_per_page' => $number,
                    'post_type'      => $post_type,
                    'post_status'    => 'publish',
                    'post__not_in'   => $sticky,
                    'orderby'        => 'comment_count',
                    'order'          => 'DESC',
                    'paged'          => 1,
                    //'category_name'  => $cat_name
                );
                break;
            default:
                $args = array(
                    'posts_per_page' => $number,
                    'post_type'      => $post_type,
                    'post_status'    => 'publish',
                    'post__not_in'   => $post__not_in,
                    'orderby'        => 'rand',
                    'order'          => 'DESC',
                    'paged'          => 1,
                    //'category_name'  => $cat_name,
                );
                break;
        }
        switch ($post_type) {
            default:
                $archive_url = get_post_type_archive_link($post_type);
                break;
        }
        $recent_post = new WP_Query($args);
        ?>
        <?php if($title) echo wp_kses_post($before_title.$title.$after_title); ?>
        <?php
            if ($recent_post->have_posts()){
                ?>
                <div class="zk-recent-post layout-<?php echo esc_attr($layout);?>">
                <?php
                switch ($layout) {
                    default:
                        while ($recent_post->have_posts()): $recent_post->the_post(); ?>
                            <div class="zk-recent-item <?php if(has_post_thumbnail() == '') {echo 'no-image';} ?> clearfix"> 
                                <?php if($show_image && has_post_thumbnail()){ ?>
                                <div class="post-media space-<?php echo melokids_align2();?>">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                </div>
                                <?php } ?>
                                <div class="item-content">
                                    <?php melokids_entry_meta(array(
                                        'show_date'   => (string)$show_date, 
                                        'show_author' => (string)$show_author, 
                                        'show_cate'   => (string)$show_cat , 
                                        'show_cmt'    => (string)$show_comment , 
                                        'show_view'   => (string)$show_view, 
                                        'show_like'   => '0', 
                                        'show_share'  => '0',
                                        'date_icon'   => '', 
                                        'author_icon' => '', 
                                        'cat_icon'    => '', 
                                        'cmt_icon'    => '', 
                                        'view_icon'   => '',
                                        'like_icon'   => '',
                                        'liked_icon'  => '',
                                        'share_icon'  => ''
                                    )); ?>
                                    <h6 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h6>
                                    <?php if ($show_desc) echo melokids_entry_excerpt(); ?>
                                </div>
                            </div>
                        <?php endwhile; wp_reset_postdata();
                    break;
                }
                if($show_view_all) echo '<div class="view-all clearfix text-'.melokids_align2().'"><a class="entry-link" href="'.esc_url($archive_url).'"><span>'.esc_html__('View More','melokids').' <span class="rm-icon fa fa-caret-'.melokids_align2().'"></span></span></a></div>';
                echo '</div>';
            } else {
            ?>
                <div class="zk-recent-post layout-<?php echo esc_attr($layout);?>">
                    <span class="notfound error-msg"><?php esc_html_e('No post found!','melokids') ?></span>
                </div>
              <?php  
            }
         ?>
        <?php 
        echo wp_kses_post($after_widget);
    }

    function update($new_instance, $old_instance) {
        $fields = [
            'layout_wg'   =>'0',
            'categories'  =>'',
            'title'       =>'',
            'post_type'   =>'post',
            'sort_by'     =>'date',
            'number'      =>'5',
        ];
        $select_fields = [
            'show_image',
            'show_cat',           
            'show_author',
            'show_date',
            'show_comment',
            'show_view',
            'show_desc',
            'show_view_all',
        ];
        $instance                  = $old_instance;
        foreach ($fields as $key => $value) {
            if(isset($new_instance[$key]))
                $instance[$key]= $new_instance[$key];
            else
                $instance[$key] = $value;
        }
        foreach ($select_fields as $key) {
            $instance[$key] = (isset($new_instance[$key])) ? $new_instance[$key] : '';
        }
        return $instance;
    }

    function form($instance) {
        $layout        = isset($instance['layout_wg']) ? $instance['layout_wg'] : '0';
        $categories    = isset($instance['categories']) ? $instance['categories'] : array();
        $title         = isset($instance['title']) ? esc_attr($instance['title']) : esc_html__('Recent Posts','melokids');
        $post_type     = isset($instance['post_type']) ? esc_attr($instance['post_type']) : 'post';
        $sort_by       = isset($instance['sort_by']) ? esc_attr($instance['sort_by']) : '';
        $show_image    = isset($instance['show_image']) ? esc_attr($instance['show_image']) : '1';
        $show_cat      = isset($instance['show_cat']) ? esc_attr($instance['show_cat']) : '';
        $show_author   = isset($instance['show_author']) ? esc_attr($instance['show_author']) : '';
        $show_date     = isset($instance['show_date']) ? esc_attr($instance['show_date']) : '1';
        $show_comment  = isset($instance['show_comment']) ? esc_attr($instance['show_comment']) : '';
        $show_view     = isset($instance['show_view']) ? esc_attr($instance['show_view']) : '';
        $show_view_all = isset($instance['show_view_all']) ? esc_attr($instance['show_view_all']) : '';
        $show_desc     = isset($instance['show_desc']) ? esc_attr($instance['show_desc']) : '';
        if ( !isset($instance['number']) || !$number = (int) $instance['number'] ) $number = 5;

        $post_types = get_post_types(array('_builtin' => false), 'objects');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e( 'Title:', 'melokids' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p><label for="<?php echo esc_attr($this->get_field_id('layout_wg')); ?>"><?php esc_html_e( 'Layout:', 'melokids' ); ?></label>
         <select class="widefat" id="<?php echo esc_attr( $this->get_field_id('layout_wg') ); ?>" name="<?php echo esc_attr( $this->get_field_name('layout_wg') ); ?>">
            <option value="0"<?php if( $layout == '0' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Default', 'melokids'); ?></option>
         </select>
         </p>
        <p><label for="<?php echo esc_attr($this->get_field_id('post_type')); ?>"><?php esc_html_e( 'Post Type:', 'melokids' ); ?></label>
         <select class="widefat" id="<?php echo esc_attr( $this->get_field_id('post_type') ); ?>" name="<?php echo esc_attr( $this->get_field_name('post_type') ); ?>">
            <option value="post"<?php if( $post_type == 'post' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Post', 'melokids'); ?></option>
            <?php
            foreach($post_types as $_post_type): ?>
                <option value="<?php echo esc_attr($_post_type->name); ?>" <?php if( $post_type == $_post_type->name ){ echo 'selected="selected"';} ?>><?php echo esc_html($_post_type->labels->name); ?></option>
            <?php endforeach; ?>
         </select>
         </p>
         <p><label for="<?php echo esc_attr($this->get_field_id('sort_by')); ?>"><?php esc_html_e( 'Sort by:', 'melokids' ); ?></label>
         <select class="widefat" id="<?php echo esc_attr( $this->get_field_id('sort_by') ); ?>" name="<?php echo esc_attr( $this->get_field_name('sort_by') ); ?>">
            <option value=""<?php if( $sort_by == '' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Recent', 'melokids'); ?></option>
            <option value="most_viewed"<?php if( $sort_by == 'most_viewed' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Most Viewed', 'melokids'); ?></option>
            <option value="sticky_posts"<?php if( $sort_by == 'sticky_posts' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Sticky post', 'melokids'); ?></option>
            <option value="most_comment"<?php if( $sort_by == 'most_comment' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Most Commented', 'melokids'); ?></option>
         </select>
         </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_image')); ?>"><?php esc_html_e( 'Show Image:', 'melokids' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('show_image') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_image') ); ?>" <?php if($show_image!='') echo 'checked="checked"'; ?> type="checkbox" value="1"  />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_author')); ?>"><?php esc_html_e( 'Show Author:', 'melokids' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('show_author') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_author') ); ?>" <?php if($show_author!='') echo 'checked="checked"'; ?> type="checkbox" value="1"  />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>"><?php esc_html_e( 'Show date:', 'melokids' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('show_date') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_date') ); ?>" <?php if($show_date!='') echo 'checked="checked";' ?> type="checkbox" value="1"  />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_cat')); ?>"><?php esc_html_e( 'Show Category:', 'melokids' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('show_cat') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_cat') ); ?>" <?php if($show_cat!='') echo 'checked="checked"'; ?> type="checkbox" value="1"  />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_comment')); ?>"><?php esc_html_e( 'Show Comment:', 'melokids' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('show_comment') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_comment') ); ?>" <?php if($show_comment!='') echo 'checked="checked";' ?> type="checkbox" value="1"  />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_view')); ?>"><?php esc_html_e( 'Show View:', 'melokids' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('show_view') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_view') ); ?>" <?php if($show_view!='') echo 'checked="checked";' ?> type="checkbox" value="1"  />
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_desc')); ?>"><?php esc_html_e( 'Show Description:', 'melokids' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('show_desc') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_desc') ); ?>" <?php if($show_desc!='') echo 'checked="checked";' ?> type="checkbox" value="1" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_view_all')); ?>"><?php esc_html_e( 'Show View All Link:', 'melokids' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('show_view_all') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_view_all') ); ?>" <?php if($show_view_all!='') echo 'checked="checked";' ?> type="checkbox" value="1"  />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e( 'Number of items to show:', 'melokids' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" />
        </p>
        <?php
    }
}
?>