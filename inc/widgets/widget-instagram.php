<?php
if(!class_exists('EF4Framework')) return;

add_action('widgets_init', 'MeloKids_WG_Instagram');
function MeloKids_WG_Instagram() {
    register_ef4_widget('MeloKids_Instagram');
}

class MeloKids_Instagram extends WP_Widget {
    function __construct() {
        parent::__construct(
            'MeloKids_Instagram', // Base ID
            esc_html__('[MeloKids] Instagram', 'melokids'), // Name
            array(
                'classname' => 'zk-instagram',
                'description' => esc_html__('Show Instagram Image', 'melokids')
            ) // Args
        );
    }
    
    function widget($args, $instance) {      
        extract($args);
        $title         = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $layout_mode   = empty($instance['layout_mode']) ? '0' : $instance['layout_mode'];
        $username      = melokids_get_opts('instagram_api_username');
        $limit         = empty($instance['number']) ? 6 : $instance['number'];
        $columns       = empty($instance['columns']) ? 3 : $instance['columns'];
        $columns_space = (int)$instance['columns_space'];
        $size          = empty($instance['size']) ? 'thumbnail' : $instance['size'];
        $show_author   = (int) $instance['show_author'];
        $target        = empty($instance['target']) ? '_self' : $instance['target'];
        $author_text   = $instance['author_text'];
        $show_like     = (int) $instance['show_like'];
        $show_cmt      = (int) $instance['show_cmt'];
        switch ($columns) {
            case 1:
                $span = "col-12";
                break;
            case 2:
                $span = "col-6";
                break;
            case 3:
                $span = "col-4";
                break;
            case 4:
                $span = "col-3";
                break;
            case 6:
                $span = "col-2";
                break;
            case 12:
                $span = "col-1";
                break;
            case 8:
                $span = "col-auto";
                break;
            default:
                $span = "col-4";
        }
        echo wp_kses_post($before_widget);
        if (!empty($title))
            echo wp_kses_post($before_title) . esc_html($title) . wp_kses_post($after_title);
        switch ($layout_mode) {
            default:
                echo '<div class="zk-instagram layout'.$layout_mode.'">'; 
                if ($username != '') {

                    $media_array = melokids_instagram( $username );
                    if ( is_wp_error($media_array) ) {

                       echo esc_html($media_array->get_error_message());

                    } else {

                        // filter for images only?
                        if ( $images_only = apply_filters( 'melokids_instagram_images_only', false ) )
                            $media_array = array_filter( $media_array, array( $this, 'melokids_instsgram_images_only' ) );

                        $media_array = array_slice( $media_array, 0, $limit );
                        ?>
                        <div class="row gutters-<?php echo esc_attr($columns_space);?> clearfix">
                        <?php
                        foreach ($media_array as $item) {
                        ?>
                            <div class="<?php echo trim(implode(' ', array('instagram-item', $span, 'overlay-wrap')));?>">
                                <a href="<?php echo esc_url( $item['link'] ); ?>" target="<?php echo esc_attr( $target );?>">
                                    <img src="<?php echo esc_url($item[$size]);?>" alt="<?php echo esc_attr($item['description']);?>" />
                                </a>
                                <div class="overlay d-flex align-items-center animated zoomOut" data-animation-in="zoomIn" data-animation-out="zoomOut">
                                    <div class="overlay-inner col-12 text-center">
                                        <a class="d-block" href="<?php echo esc_url( $item['link'] );?>" target="<?php echo esc_attr( $target );?>"><span class="fa fa-instagram"></span></a>
                                        <?php if( $show_like):?><a class="like" href="<?php echo esc_url( $item['link'] );?>" target="<?php echo esc_attr( $target );?>"><span class="fa fa-heart-o"></span>&nbsp;<?php echo esc_html($item['likes']);?></a><?php endif; ?>
                                        <?php if( $show_cmt):?><a class="comments" href="<?php echo esc_url( $item['link'] );?>" target="<?php echo esc_attr( $target ) ;?>"><span class="fa fa-comments-o"></span>&nbsp;<?php echo esc_html($item['comments']);?></a><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        </div>
                        <?php
                    }
                }
                if ($show_author) {
                    ?><div class="user">
                        <a href="//instagram.com/<?php echo trim($username); ?>" target="<?php echo esc_attr( $target ); ?>"><?php if(!empty($author_text)) echo '<span class="author-text">'.esc_html($author_text).'</span>'; ?> <span class="author-name">@<?php echo trim($username); ?></span></a></div><?php
                }
                echo '</div>';
                break;
        }
        
        echo wp_kses_post($after_widget);
    }         
    
    function update( $new_instance, $old_instance ) {
        $instance                  = $old_instance;
        $instance['title']         = strip_tags($new_instance['title']);
        $instance['layout_mode']   = (int)($new_instance['layout_mode']);
        $username                  = melokids_get_opts('instagram_api_username');
        $instance['number']        = !absint($new_instance['number']) ? 6 : $new_instance['number'];
        $instance['columns']       = !absint($new_instance['columns']) ? 3 : $new_instance['columns'];
        $instance['columns_space'] = (int)$new_instance['columns_space'];
        $instance['size']          = (($new_instance['size'] == 'thumbnail' || $new_instance['size'] == 'large') ? $new_instance['size'] : 'thumbnail');
        $instance['show_author']   = $new_instance['show_author'];
        $instance['target']        = (($new_instance['target'] == '_self' || $new_instance['target'] == '_blank') ? $new_instance['target'] : '_self');
        $instance['author_text']   = strip_tags($new_instance['author_text']);
        $instance['show_like']     = $new_instance['show_like'];
        $instance['show_cmt']      = $new_instance['show_cmt'];
        return $instance;
    }
    
    function form( $instance ) {
        $instance      = wp_parse_args( (array) $instance, array( 'title' => '', 'layout_mode' => '0', 'username' => '', 'show_author' => '1', 'author_text' => esc_html__('Follow Us', 'melokids'), 'number' => 6,'columns' => 3, 'columns_space' => '0', 'size' => 'thumbnail', 'target' => '_self') );
        $title         = esc_attr($instance['title']);
        $layout_mode   = (int)($instance['layout_mode']);
        $username      = melokids_get_opts('instagram_api_username');
        $number        = absint($instance['number']);
        $columns       = absint($instance['columns']);
        $columns_space = (int)$instance['columns_space'];
        $size          = esc_attr($instance['size']);
        $show_author   = isset($instance['show_author']) ? esc_attr($instance['show_author']) : ''; 
        $target        = esc_attr($instance['target']);
        $author_text   = strip_tags($instance['author_text']);
        $show_like     = isset($instance['show_like']) ? esc_attr($instance['show_like']) : ''; 
        $show_cmt      = isset($instance['show_cmt']) ? esc_attr($instance['show_cmt']) : ''; 
        ?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'melokids'); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('layout_mode')); ?>"><?php esc_html_e('Layout Mode', 'melokids'); ?>:</label>
            <select id="<?php echo esc_attr($this->get_field_id('layout_mode')); ?>" name="<?php echo esc_attr($this->get_field_name('layout_mode')); ?>" class="widefat">
                <option value="0" <?php selected('0', $layout_mode) ?>><?php esc_html_e('Default', 'melokids'); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of photos', 'melokids'); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columns')); ?>"><?php esc_html_e('Columns', 'melokids'); ?>:</label>
            <select id="<?php echo esc_attr($this->get_field_id('columns')); ?>" name="<?php echo esc_attr($this->get_field_name('columns')); ?>" class="widefat">
                <option value="1" <?php selected('1', $columns) ?>><?php esc_html_e('1', 'melokids'); ?></option>
                <option value="2" <?php selected('2', $columns) ?>><?php esc_html_e('2', 'melokids'); ?></option>
                <option value="3" <?php selected('3', $columns) ?>><?php esc_html_e('3', 'melokids'); ?></option>
                <option value="4" <?php selected('4', $columns) ?>><?php esc_html_e('4', 'melokids'); ?></option>
                <option value="6" <?php selected('6', $columns) ?>><?php esc_html_e('6', 'melokids'); ?></option>
                <option value="12" <?php selected('12', $columns) ?>><?php esc_html_e('12', 'melokids'); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columns_space')); ?>"><?php esc_html_e('Columns Space', 'melokids'); ?>:</label>
            <select id="<?php echo esc_attr($this->get_field_id('columns_space')); ?>" name="<?php echo esc_attr($this->get_field_name('columns_space')); ?>" class="widefat">
                <option value="0" <?php selected('0', $columns_space) ?>><?php esc_html_e('0', 'melokids'); ?></option>
                <option value="2" <?php selected('2', $columns_space) ?>><?php esc_html_e('2', 'melokids'); ?></option>
                <option value="10" <?php selected('10', $columns_space) ?>><?php esc_html_e('10', 'melokids'); ?></option>
                <option value="20" <?php selected('20', $columns_space) ?>><?php esc_html_e('20', 'melokids'); ?></option>
                <option value="30" <?php selected('30', $columns_space) ?>><?php esc_html_e('30', 'melokids'); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('size')); ?>"><?php esc_html_e('Photo size', 'melokids'); ?>:</label>
            <select id="<?php echo esc_attr($this->get_field_id('size')); ?>" name="<?php echo esc_attr($this->get_field_name('size')); ?>" class="widefat">
                <option value="thumbnail" <?php selected( 'thumbnail', $size ); ?>><?php esc_html_e( 'Thumbnail', 'melokids' ); ?></option>
                <option value="small" <?php selected( 'small', $size ); ?>><?php esc_html_e( 'Small', 'melokids' ); ?></option>
                <option value="large" <?php selected( 'large', $size ); ?>><?php esc_html_e( 'Large', 'melokids' ); ?></option>
                <option value="original" <?php selected( 'original', $size ); ?>><?php esc_html_e( 'Original', 'melokids' ); ?></option>
            </select>
        </p>
        <p>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('show_author') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_author') ); ?>" <?php if($show_author!='') echo 'checked="checked"'; ?> type="checkbox" value="1"  />
            <label for="<?php echo esc_attr($this->get_field_id('show_author')); ?>"><?php esc_html_e( 'Show Author:', 'melokids' ); ?></label>
            
        </p>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('author_text')); ?>"><?php esc_html_e('Author text', 'melokids'); ?>: </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('author_text')); ?>" name="<?php echo esc_attr($this->get_field_name('author_text')); ?>" type="text" value="<?php echo esc_attr($author_text); ?>" placeholder="<?php echo esc_attr__('Follow Us','melokids'); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('target')); ?>"><?php esc_html_e('Open author links in', 'melokids'); ?>:</label>
            <select id="<?php echo esc_attr($this->get_field_id('target')); ?>" name="<?php echo esc_attr($this->get_field_name('target')); ?>" class="widefat">
                <option value="_self" <?php selected('_self', $target) ?>><?php esc_html_e('Current window (_self)', 'melokids'); ?></option>
                <option value="_blank" <?php selected('_blank', $target) ?>><?php esc_html_e('New window (_blank)', 'melokids'); ?></option>
            </select>
        </p>
        <p>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('show_like') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_like') ); ?>" <?php if($show_author!='') echo 'checked="checked"'; ?> type="checkbox" value="1"  />
            <label for="<?php echo esc_attr($this->get_field_id('show_like')); ?>"><?php esc_html_e( 'Show Like Count', 'melokids' ); ?></label>
        </p>
        <p>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('show_cmt') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_cmt') ); ?>" <?php if($show_author!='') echo 'checked="checked"'; ?> type="checkbox" value="1"  />
            <label for="<?php echo esc_attr($this->get_field_id('show_cmt')); ?>"><?php esc_html_e( 'Show Comment Count', 'melokids' ); ?></label>
        </p>
        <?php   
    } 
}
